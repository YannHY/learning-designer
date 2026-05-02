(function () {
  "use strict";

  const app = () => window.learningDesignerApp;
  const authState = {
    user: null,
    loading: false
  };
  let requestedRemoteDesignHandled = false;
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
      await maybeLoadRequestedDesign();
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

  function syncSaveUi() {
    const button = $("save-btn");
    if (!button) return;

    if (authState.user) {
      button.hidden = false;
      setSaveButtonText(tr("Enregistrer", "Save"));
      return;
    }

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
    const el = $("autosave-status");
    if (!el) return;
    clearTimeout(autoSaveHideTimer);
    el.textContent = text;
    el.className = `autosave-status as-visible as-${kind}`;
    if (kind !== "saving") {
      autoSaveHideTimer = setTimeout(() => {
        el.classList.remove("as-visible");
        setTimeout(() => { el.textContent = ""; el.className = "autosave-status"; }, 400);
      }, 4000);
    }
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
          title: currentDesignTitle(),
          document: state
        })
      });
      app()?.updateMeta?.({
        remoteDesignId: data.design.id,
        remoteUpdatedAt: data.design.updatedAt
      });
      setAutoSaveStatus("success", tr("Sauvegarde auto ✓", "Auto-saved ✓"));
    } catch (_) {
      setAutoSaveStatus("error", tr("Échec sauvegarde auto", "Auto-save failed"));
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
          title: currentDesignTitle(),
          document: state
        })
      });

      app()?.updateMeta?.({
        remoteDesignId: data.design.id,
        remoteUpdatedAt: data.design.updatedAt
      });
      const message = tr(
        "Production sauvegardee sur votre compte. Ouvrez Sauvegardes pour la retrouver.",
        "Design saved to your account. Open Saves to find it again."
      );
      app()?.showNotice?.(message, "success");
      app()?.announce?.(message);
    } catch (error) {
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
      <a id="saved-designs-btn" class="nav-account-btn nav-saves-btn" href="my-designs.php" title="${tr("Sauvegardes", "Saves")}" aria-label="${tr("Sauvegardes", "Saves")}">
        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
        <span class="nav-account-label">${tr("Sauvegardes", "Saves")}</span>
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
        "Connectez-vous pour ouvrir cette production sauvegardee.",
        "Sign in to open this saved design."
      );
      app()?.showNotice?.(message, "warning");
      app()?.announce?.(message);
      return;
    }

    try {
      const data = await fetchJson(`get_design.php?design_id=${encodeURIComponent(String(designId))}`);
      app()?.loadDocument?.(data.design.document, {
        remoteDesignId: data.design.id,
        remoteUpdatedAt: data.design.updatedAt
      });
      lastLoadTime = Date.now();
      const cleanUrl = new URL(window.location.href);
      cleanUrl.searchParams.delete("remote_design_id");
      window.history.replaceState({}, "", cleanUrl.toString());
      const message = tr("Production chargee.", "Design loaded.");
      app()?.showNotice?.(message, "success");
      app()?.announce?.(message);
    } catch (error) {
      const message = error.message || tr("Chargement impossible.", "Load failed.");
      app()?.showNotice?.(message, "error");
      app()?.announce?.(message);
    }
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
        <h2 class="modal-title">${tr("Mes productions sauvegardees", "My saved designs")}</h2>
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
      const data = await fetchJson(`get_design.php?design_id=${encodeURIComponent(String(id))}`);
      app()?.loadDocument?.(data.design.document, {
        remoteDesignId: data.design.id,
        remoteUpdatedAt: data.design.updatedAt
      });
      lastLoadTime = Date.now();
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

  window.learningDesignerOpenSaves = openSavedDesignsOrLogin;
  window.learningDesignerSaveToAccount = saveToAccountOrLogin;

  document.addEventListener("DOMContentLoaded", () => {
    ensureSiteNavUi();
    bindSaveButton();
    syncSaveUi();
    refreshAuth();
    window.addEventListener("ld:statechange", scheduleAutoSave);
  });
})();
