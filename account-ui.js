(function () {
  "use strict";

  const app = () => window.learningDesignerApp;
  const authState = {
    user: null,
    loading: false
  };
  let requestedRemoteDesignHandled = false;
  let startupRemoteDesignSynced = false;
  let autoSaveTimer = null;
  let lastLoadTime = 0;
  let autoSaveHideTimer = null;

  function tr(fr, en) {
    return app()?.getCurrentLang?.() === "en" ? en : fr;
  }

  function $(id) {
    return document.getElementById(id);
  }

  function formatDate(value) {
    if (!value) return "";
    const date = new Date(String(value).replace(" ", "T"));
    if (Number.isNaN(date.getTime())) return String(value);
    return new Intl.DateTimeFormat(app()?.getCurrentLang?.() === "en" ? "en-GB" : "fr-FR", {
      dateStyle: "medium",
      timeStyle: "short"
    }).format(date);
  }

  function currentDesignTitle() {
    const state = app()?.getState?.() ?? {};
    const title = String(state?.meta?.name ?? "").trim();
    return title || tr("Production sans titre", "Untitled design");
  }

  function currentDesignId() {
    const state = app()?.getState?.() ?? {};
    return Number(state?.meta?.remoteDesignId || 0);
  }

  function currentDesignUpdatedAt() {
    const state = app()?.getState?.() ?? {};
    return String(state?.meta?.remoteUpdatedAt || "");
  }

  function setRemoteDesignUrl(designId) {
    if (!Number.isFinite(designId) || designId <= 0) return;
    const url = new URL(window.location.href);
    url.searchParams.set("remote_design_id", String(designId));
    window.history.replaceState({}, "", url.toString());
  }

  function clearRemoteDesignUrl() {
    const url = new URL(window.location.href);
    url.searchParams.delete("remote_design_id");
    window.history.replaceState({}, "", url.toString());
  }

  async function fetchJson(url, options = {}) {
    const response = await fetch(url, {
      credentials: "same-origin",
      headers: {
        Accept: "application/json",
        ...(options.body ? { "Content-Type": "application/json" } : {})
      },
      ...options
    });

    let data = null;
    try {
      data = await response.json();
    } catch (_) {
      data = null;
    }

    if (!response.ok || !data?.success) {
      const error = new Error(data?.error || tr("Erreur serveur.", "Server error."));
      error.status = response.status;
      error.data = data;
      throw error;
    }
    return data;
  }

  async function refreshAuth() {
    authState.loading = true;
    try {
      const data = await fetchJson("auth_me.php");
      authState.user = data.user;
    } catch (_) {
      authState.user = null;
    } finally {
      authState.loading = false;
      renderAccountArea();
      syncSaveUi();
      syncPublishUi();
      await maybeLoadRequestedDesign();
      await maybeSyncCurrentRemoteDesign();
    }
  }

  function setSaveButtonText(label) {
    const button = $("save-btn");
    if (!button) return;
    const labelNode = button.querySelector(".btn-label");
    if (labelNode) {
      labelNode.innerHTML = `<i class="fa-regular fa-floppy-disk btn-icon-inline" aria-hidden="true"></i>${escapeHtml(label)}`;
    } else {
      button.textContent = label;
    }
    button.setAttribute("aria-label", label);
    button.title = label;
  }

  function resetSaveButtonState() {
    const button = $("save-btn");
    if (!button) return;
    clearTimeout(autoSaveHideTimer);
    button.removeAttribute("data-save-status");
    button.removeAttribute("aria-busy");
    setSaveButtonText(tr("Enregistrer", "Save"));
  }

  function syncSaveUi() {
    const button = $("save-btn");
    if (!button) return;

    if (authState.user) {
      button.hidden = false;
      if (!button.dataset.saveStatus) {
        setSaveButtonText(tr("Enregistrer", "Save"));
      }
      return;
    }

    resetSaveButtonState();
    button.hidden = true;
  }

  function openSavedDesignsOrLogin() {
    if (!authState.user) {
      window.location.href = "login.php";
      return;
    }
    window.location.href = "my-designs.php";
  }

  function saveToAccountOrLogin(event) {
    if (event) {
      event.preventDefault?.();
      event.stopImmediatePropagation?.();
    }
    if (!authState.user) {
      window.location.href = "login.php";
      return;
    }
    saveRemoteDesign();
  }

  function setAutoSaveStatus(kind, text) {
    const button = $("save-btn");
    if (!button || button.hidden) return;
    clearTimeout(autoSaveHideTimer);
    button.dataset.saveStatus = kind;
    if (kind === "saving") {
      button.setAttribute("aria-busy", "true");
    } else {
      button.removeAttribute("aria-busy");
    }
    setSaveButtonText(text);
    if (kind === "saving") return;
    autoSaveHideTimer = setTimeout(() => {
      resetSaveButtonState();
    }, kind === "error" ? 4000 : 2500);
  }

  function scheduleAutoSave() {
    if (!authState.user) return;
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
      if (!authState.user) return;
      if (Date.now() - lastLoadTime < 3000) return;
      autoSaveRemote();
    }, 45000);
  }

  async function autoSaveRemote() {
    const state = app()?.getState?.();
    if (!state) return;
    setAutoSaveStatus("saving", tr("Sauvegarde…", "Saving…"));
    try {
      const data = await fetchJson("save_design.php", {
        method: "POST",
        body: JSON.stringify({
          design_id: currentDesignId(),
          expected_updated_at: currentDesignUpdatedAt(),
          title: currentDesignTitle(),
          document: state
        })
      });
      app()?.updateMeta?.({
        remoteDesignId: data.design.id,
        remoteUpdatedAt: data.design.updatedAt
      });
      setRemoteDesignUrl(data.design.id);
      setAutoSaveStatus("success", tr("Sauvegarde auto ✓", "Auto-saved ✓"));
    } catch (error) {
      if (error?.status === 409) {
        const updatedAt = error?.data?.design?.updatedAt;
        if (updatedAt) app()?.updateMeta?.({ remoteUpdatedAt: updatedAt });
        setAutoSaveStatus("error", tr("Conflit détecté", "Conflict detected"));
        app()?.showNotice?.(
          tr(
            "Conflit de sauvegarde : ce design a été modifié dans une autre fenêtre. La prochaine sauvegarde résoudra le conflit.",
            "Save conflict: this design was changed in another window. The next save will resolve the conflict."
          ),
          "error"
        );
        return;
      }
      setAutoSaveStatus("error", tr("Échec sauvegarde auto", "Auto-save failed"));
      app()?.showNotice?.(tr("Échec de la sauvegarde automatique.", "Auto-save failed."), "error");
    }
  }

  async function saveRemoteDesign() {
    if (!authState.user) {
      return;
    }

    const state = app()?.getState?.();
    if (!state) return;

    try {
      const data = await fetchJson("save_design.php", {
        method: "POST",
        body: JSON.stringify({
          design_id: currentDesignId(),
          expected_updated_at: currentDesignUpdatedAt(),
          title: currentDesignTitle(),
          document: state
        })
      });

      app()?.updateMeta?.({
        remoteDesignId: data.design.id,
        remoteUpdatedAt: data.design.updatedAt
      });
      setRemoteDesignUrl(data.design.id);
      const message = tr(
        "Production sauvegardée sur votre compte. Ouvrez Designs pour la retrouver.",
        "Design saved to your account. Open Designs to find it again."
      );
      app()?.showNotice?.(message, "success");
      app()?.announce?.(message);
    } catch (error) {
      if (error?.status === 409) {
        const updatedAt = error?.data?.design?.updatedAt;
        if (updatedAt) app()?.updateMeta?.({ remoteUpdatedAt: updatedAt });
        const message = tr(
          "Conflit de sauvegarde : ce design a été modifié dans une autre fenêtre.",
          "Save conflict: this design was changed in another window."
        );
        app()?.showNotice?.(message, "error");
        app()?.announce?.(message);
        return;
      }
      const message = error.message || tr("Sauvegarde distante impossible.", "Remote save failed.");
      app()?.showNotice?.(message, "error");
      app()?.announce?.(message);
    }
  }

  function ensureSiteNavUi() {
    if ($("account-toolbar-cluster")) return;
    const navActions = $("site-nav-actions");
    if (!navActions) return;

    const cluster = document.createElement("div");
    cluster.className = "account-toolbar-cluster";
    cluster.id = "account-toolbar-cluster";
    cluster.innerHTML = `
      <a id="saved-designs-btn" class="nav-account-btn nav-saves-btn" href="my-designs.php" title="${tr("Designs", "Designs")}" aria-label="${tr("Designs", "Designs")}">
        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
        <span class="nav-account-label">${tr("Designs", "Designs")}</span>
      </a>
      <span id="account-pill" class="account-pill" style="display:none"></span>
      <div class="account-menu-wrap">
        <button id="account-menu-btn" class="nav-account-btn" type="button">
          <i class="fa-regular fa-user" aria-hidden="true"></i>
          <span class="nav-account-label">${tr("Connexion", "Sign in")}</span>
        </button>
        <div id="account-menu" class="account-menu hidden" role="menu" aria-hidden="true"></div>
      </div>
    `;

    navActions.append(cluster);

    $("account-menu-btn")?.addEventListener("click", () => {
      if (!authState.user) {
        window.location.href = "login.php";
        return;
      }
      toggleAccountMenu();
    });

    document.addEventListener("click", (event) => {
      const wrap = document.querySelector(".account-menu-wrap");
      if (wrap && !wrap.contains(event.target)) {
        closeAccountMenu();
      }
    });
  }

  function renderAccountArea() {
    ensureSiteNavUi();

    const pill = $("account-pill");
    const button = $("account-menu-btn");
    const menu = $("account-menu");
    if (!pill || !button || !menu) return;

    if (!authState.user) {
      pill.innerHTML = `${tr("Compte", "Account")} <strong>${tr("non connecte", "not signed in")}</strong>`;
      button.innerHTML = `<i class="fa-regular fa-user" aria-hidden="true"></i><span class="nav-account-label">${tr("Connexion", "Sign in")}</span>`;
      menu.innerHTML = "";
      syncSaveUi();
      return;
    }

    pill.innerHTML = `${tr("Compte", "Account")} <strong>${escapeHtml(authState.user.username || authState.user.email)}</strong>`;
    button.innerHTML = `<i class="fa-solid fa-user-check" aria-hidden="true"></i><span class="nav-account-label">${tr("Compte", "Account")}</span>`;
    menu.innerHTML = `
      <a class="account-menu-link" role="menuitem" href="profile.php">${tr("Profil", "Profile")}</a>
      ${String(authState.user.role) === "admin" ? `<a class="account-menu-link" role="menuitem" href="admin.php">${tr("Administration", "Admin")}</a>` : ""}
      <a class="account-menu-link" role="menuitem" href="logout.php">${tr("Deconnexion", "Sign out")}</a>
    `;
    syncSaveUi();
  }

  function toggleAccountMenu() {
    const menu = $("account-menu");
    if (!menu) return;
    const hidden = menu.classList.toggle("hidden");
    menu.setAttribute("aria-hidden", hidden ? "true" : "false");
  }

  function closeAccountMenu() {
    const menu = $("account-menu");
    if (!menu) return;
    menu.classList.add("hidden");
    menu.setAttribute("aria-hidden", "true");
  }

  async function maybeLoadRequestedDesign() {
    if (requestedRemoteDesignHandled) return;
    const params = new URLSearchParams(window.location.search);
    const designId = Number(params.get("remote_design_id") || 0);
    if (!Number.isFinite(designId) || designId <= 0) return;
    requestedRemoteDesignHandled = true;

    if (!authState.user) {
      const message = tr(
        "Connectez-vous pour ouvrir cette production sauvegardée.",
        "Sign in to open this saved design."
      );
      app()?.showNotice?.(message, "warning");
      app()?.announce?.(message);
      return;
    }

    await syncRemoteDesignFromServer(designId, true);
  }

  async function syncRemoteDesignFromServer(designId, showLoadedMessage = false) {
    if (!Number.isFinite(designId) || designId <= 0) return false;
    try {
      const data = await fetchJson(`get_design.php?design_id=${encodeURIComponent(String(designId))}`);
      app()?.loadDocument?.(data.design.document, {
        remoteDesignId: data.design.id,
        remoteUpdatedAt: data.design.updatedAt
      });
      setRemoteDesignUrl(data.design.id);
      lastLoadTime = Date.now();
      if (showLoadedMessage) {
        const message = tr("Production chargee.", "Design loaded.");
        app()?.showNotice?.(message, "success");
        app()?.announce?.(message);
      }
      return true;
    } catch (error) {
      if (showLoadedMessage) {
        const message = error.message || tr("Chargement impossible.", "Load failed.");
        app()?.showNotice?.(message, "error");
        app()?.announce?.(message);
      }
      return false;
    }
  }

  async function maybeSyncCurrentRemoteDesign() {
    if (startupRemoteDesignSynced) return;
    if (!authState.user) return;
    const params = new URLSearchParams(window.location.search);
    const requestedDesignId = Number(params.get("remote_design_id") || 0);
    if (Number.isFinite(requestedDesignId) && requestedDesignId > 0) return;
    const designId = currentDesignId();
    if (!Number.isFinite(designId) || designId <= 0) return;
    startupRemoteDesignSynced = true;
    await syncRemoteDesignFromServer(designId, false);
  }

  function ensureSavedDesignsModal() {
    if ($("saved-designs-modal-backdrop")) return;

    const backdrop = document.createElement("div");
    backdrop.id = "saved-designs-modal-backdrop";
    backdrop.className = "modal-backdrop hidden";
    backdrop.setAttribute("role", "dialog");
    backdrop.setAttribute("aria-modal", "true");
    backdrop.setAttribute("aria-hidden", "true");
    backdrop.innerHTML = `
      <div class="modal-card" style="width:min(760px,calc(100vw - 24px));max-height:85vh;overflow:auto;">
        <h2 class="modal-title">${tr("Mes productions sauvegardées", "My saved designs")}</h2>
        <p class="saved-designs-status" id="saved-designs-status">${tr("Chargement...", "Loading...")}</p>
        <div id="saved-designs-list" class="saved-designs-list"></div>
        <div class="modal-actions">
          <button id="saved-designs-close-btn" class="btn btn-light" type="button">${tr("Fermer", "Close")}</button>
        </div>
      </div>
    `;
    document.body.appendChild(backdrop);

    $("saved-designs-close-btn")?.addEventListener("click", closeSavedDesignsModal);
    backdrop.addEventListener("click", (event) => {
      if (event.target === backdrop) closeSavedDesignsModal();
    });
  }

  function openSavedDesignsModal() {
    ensureSavedDesignsModal();
    const backdrop = $("saved-designs-modal-backdrop");
    if (!backdrop) return;
    backdrop.classList.remove("hidden");
    backdrop.setAttribute("aria-hidden", "false");
    loadSavedDesigns();
  }

  function closeSavedDesignsModal() {
    const backdrop = $("saved-designs-modal-backdrop");
    if (!backdrop) return;
    backdrop.classList.add("hidden");
    backdrop.setAttribute("aria-hidden", "true");
  }

  async function loadSavedDesigns() {
    const status = $("saved-designs-status");
    const list = $("saved-designs-list");
    if (!status || !list) return;

    status.textContent = tr("Chargement...", "Loading...");
    list.innerHTML = "";

    try {
      const data = await fetchJson("list_designs.php");
      if (!data.items.length) {
        status.textContent = "";
        list.innerHTML = `<p class="saved-designs-empty">${tr("Aucune production enregistree pour le moment.", "No saved designs yet.")}</p>`;
        return;
      }

      status.textContent = tr("Choisissez une production a charger ou supprimer.", "Choose a design to load or delete.");
      const fragment = document.createDocumentFragment();

      data.items.forEach((item) => {
        const article = document.createElement("article");
        article.className = "saved-design-item";
        article.innerHTML = `
          <div class="saved-design-head">
            <div>
              <h3 class="saved-design-title">${escapeHtml(item.title)}</h3>
              <p class="saved-design-meta">${tr("Derniere mise a jour: ", "Last updated: ")}${escapeHtml(formatDate(item.updatedAt))}</p>
            </div>
            <div class="saved-design-actions">
              <button class="btn btn-light" type="button" data-action="load" data-id="${item.id}">${tr("Charger", "Load")}</button>
              <button class="btn" type="button" data-action="delete" data-id="${item.id}">${tr("Supprimer", "Delete")}</button>
            </div>
          </div>
        `;
        fragment.appendChild(article);
      });

      list.appendChild(fragment);
      list.querySelectorAll("button[data-action='load']").forEach((button) => {
        button.addEventListener("click", () => loadRemoteDesign(Number(button.dataset.id)));
      });
      list.querySelectorAll("button[data-action='delete']").forEach((button) => {
        button.addEventListener("click", () => deleteRemoteDesign(Number(button.dataset.id)));
      });
    } catch (error) {
      status.textContent = error.message || tr("Impossible de charger la liste.", "Could not load the list.");
    }
  }

  async function loadRemoteDesign(id) {
    if (!Number.isFinite(id) || id <= 0) return;
    if (!window.confirm(tr("Charger cette production et remplacer le contenu actuel ?", "Load this design and replace the current content?"))) {
      return;
    }

    try {
      const loaded = await syncRemoteDesignFromServer(id, false);
      if (!loaded) {
        throw new Error(tr("Chargement impossible.", "Load failed."));
      }
      closeSavedDesignsModal();
      app()?.announce?.(tr("Production chargee.", "Design loaded."));
    } catch (error) {
      app()?.announce?.(error.message || tr("Chargement impossible.", "Load failed."));
    }
  }

  async function deleteRemoteDesign(id) {
    if (!Number.isFinite(id) || id <= 0) return;
    if (!window.confirm(tr("Supprimer definitivement cette production ?", "Delete this design permanently?"))) {
      return;
    }

    try {
      await fetchJson("delete_design.php", {
        method: "POST",
        body: JSON.stringify({ design_id: id })
      });
      if (currentDesignId() === id) {
        app()?.clearRemoteMeta?.();
      }
      await loadSavedDesigns();
      app()?.announce?.(tr("Production supprimee.", "Design deleted."));
    } catch (error) {
      app()?.announce?.(error.message || tr("Suppression impossible.", "Delete failed."));
    }
  }

  function escapeHtml(value) {
    return String(value)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function bindSaveButton() {
    $("save-btn")?.addEventListener("click", saveToAccountOrLogin, true);
  }

  // ── Publish / Share ──────────────────────────────────────────

  function syncPublishUi() {
    const btn = $("publish-btn");
    if (!btn) return;
    btn.hidden = !authState.user;
  }

  function openPublishModal(shareUrl, alreadyPublished) {
    closePublishModal();

    const backdrop = document.createElement("div");
    backdrop.id = "publish-modal-backdrop";
    backdrop.className = "modal-backdrop";
    backdrop.setAttribute("role", "dialog");
    backdrop.setAttribute("aria-modal", "true");
    backdrop.setAttribute("aria-label", tr("Partager la production", "Share design"));

    const urlHtml = shareUrl
      ? `<div class="publish-url-row">
           <input id="publish-url-input" class="publish-url-input" type="text" readonly value="${escapeHtml(shareUrl)}" aria-label="${tr("Lien de partage", "Share link")}">
           <button id="publish-copy-btn" class="btn btn-light" type="button">${tr("Copier", "Copy")}</button>
         </div>`
      : "";

    const revokeHtml = alreadyPublished
      ? `<button id="publish-revoke-btn" class="btn" type="button" style="color:#b91c1c">${tr("Révoquer le lien", "Revoke link")}</button>`
      : "";

    backdrop.innerHTML = `
      <div class="modal-card" style="width:min(520px,calc(100vw - 24px))">
        <h2 class="modal-title">${tr("Partager la production", "Share design")}</h2>
        ${shareUrl
          ? `<p class="publish-hint">${tr("Ce lien permet à n'importe qui de consulter votre production (lecture seule).", "Anyone with this link can view your design (read-only).")}</p>
             ${urlHtml}`
          : `<p class="publish-hint">${tr("Votre production sera accessible publiquement via un lien unique.", "Your design will be publicly accessible via a unique link.")}</p>`
        }
        <div class="modal-actions" style="margin-top:20px">
          ${!shareUrl ? `<button id="publish-confirm-btn" class="btn btn-primary" type="button">${tr("Générer le lien", "Generate link")}</button>` : ""}
          ${revokeHtml}
          <button id="publish-close-btn" class="btn btn-light" type="button">${tr("Fermer", "Close")}</button>
        </div>
      </div>`;

    document.body.appendChild(backdrop);

    $("publish-close-btn")?.addEventListener("click", closePublishModal);
    backdrop.addEventListener("click", (e) => { if (e.target === backdrop) closePublishModal(); });

    $("publish-copy-btn")?.addEventListener("click", () => {
      const input = $("publish-url-input");
      if (!input) return;
      navigator.clipboard?.writeText(input.value).then(() => {
        const btn = $("publish-copy-btn");
        if (btn) { btn.textContent = tr("Copié !", "Copied!"); setTimeout(() => { btn.textContent = tr("Copier", "Copy"); }, 2000); }
      }).catch(() => { input.select(); document.execCommand("copy"); });
    });

    $("publish-confirm-btn")?.addEventListener("click", async () => {
      const confirmBtn = $("publish-confirm-btn");
      if (confirmBtn) { confirmBtn.disabled = true; confirmBtn.textContent = tr("Génération…", "Generating…"); }
      await doPublish();
    });

    $("publish-revoke-btn")?.addEventListener("click", async () => {
      if (!window.confirm(tr("Révoquer ce lien ? Les personnes qui l'ont reçu ne pourront plus y accéder.", "Revoke this link? Anyone who received it will lose access."))) return;
      const revokeBtn = $("publish-revoke-btn");
      if (revokeBtn) { revokeBtn.disabled = true; revokeBtn.textContent = tr("Révocation…", "Revoking…"); }
      await doUnpublish();
    });
  }

  function closePublishModal() {
    $("publish-modal-backdrop")?.remove();
  }

  async function doPublish() {
    let designId = currentDesignId();

    if (designId <= 0) {
      const state = app()?.getState?.();
      if (!state) return;
      try {
        const saved = await fetchJson("save_design.php", {
          method: "POST",
          body: JSON.stringify({
            design_id: 0,
            expected_updated_at: "",
            title: currentDesignTitle(),
            document: state
          })
        });
        app()?.updateMeta?.({ remoteDesignId: saved.design.id, remoteUpdatedAt: saved.design.updatedAt });
        setRemoteDesignUrl(saved.design.id);
        designId = saved.design.id;
      } catch (err) {
        app()?.showNotice?.(err.message || tr("Sauvegarde impossible.", "Save failed."), "error");
        closePublishModal();
        return;
      }
    }

    try {
      const data = await fetchJson("publish_design.php", {
        method: "POST",
        body: JSON.stringify({ action: "publish", design_id: designId })
      });
      closePublishModal();
      openPublishModal(data.share_url, true);
    } catch (err) {
      app()?.showNotice?.(err.message || tr("Publication impossible.", "Publish failed."), "error");
      closePublishModal();
    }
  }

  async function doUnpublish() {
    const designId = currentDesignId();
    if (designId <= 0) { closePublishModal(); return; }
    try {
      await fetchJson("publish_design.php", {
        method: "POST",
        body: JSON.stringify({ action: "unpublish", design_id: designId })
      });
      closePublishModal();
      app()?.showNotice?.(tr("Lien révoqué.", "Link revoked."), "success");
    } catch (err) {
      app()?.showNotice?.(err.message || tr("Révocation impossible.", "Revoke failed."), "error");
      closePublishModal();
    }
  }

  function openPublishFlow(event) {
    if (event) { event.preventDefault?.(); event.stopImmediatePropagation?.(); }
    if (!authState.user) { window.location.href = "login.php"; return; }
    openPublishModal(null, false);
  }

  function bindPublishButton() {
    $("publish-btn")?.addEventListener("click", openPublishFlow, true);
  }

  window.learningDesignerOpenSaves = openSavedDesignsOrLogin;
  window.learningDesignerSaveToAccount = saveToAccountOrLogin;
  window.learningDesignerClearRemoteDesignUrl = clearRemoteDesignUrl;

  document.addEventListener("DOMContentLoaded", () => {
    ensureSiteNavUi();
    bindSaveButton();
    bindPublishButton();
    syncSaveUi();
    syncPublishUi();
    refreshAuth();
    window.addEventListener("ld:statechange", scheduleAutoSave);
  });
})();
