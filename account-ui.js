(function () {
  "use strict";

  const app = () => window.learningDesignerApp;
  const authState = {
    user: null,
    loading: false
  };

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
    }
  }

  function updateSaveStatus(message) {
    const label = $("save-status-label");
    const value = $("save-status-value");
    const wrap = $("save-status");
    if (!label || !value || !wrap) return;
    label.textContent = tr("Compte", "Account");
    value.textContent = message;
    wrap.dataset.state = "saved";
    wrap.title = message;
  }

  async function saveRemoteDesign() {
    if (!authState.user) {
      return;
    }

    const state = app()?.getState?.();
    if (!state) return;

    try {
      updateSaveStatus(tr("Sauvegarde du compte en cours...", "Saving to account..."));
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
      updateSaveStatus(
        tr("Sauvegarde compte: ", "Account save: ") + formatDate(data.design.updatedAt)
      );
      app()?.announce?.(tr("Production sauvegardee sur votre compte.", "Design saved to your account."));
      await maybeRefreshSavedDesigns();
    } catch (error) {
      updateSaveStatus(tr("Echec de la sauvegarde compte.", "Account save failed."));
      app()?.announce?.(error.message || tr("Sauvegarde distante impossible.", "Remote save failed."));
    }
  }

  async function maybeRefreshSavedDesigns() {
    const list = $("saved-designs-list");
    if (!list || $("saved-designs-modal-backdrop")?.classList.contains("hidden")) return;
    await loadSavedDesigns();
  }

  function ensureSiteNavUi() {
    if ($("account-toolbar-cluster")) return;
    const navActions = $("site-nav-actions");
    if (!navActions) return;

    const cluster = document.createElement("div");
    cluster.className = "account-toolbar-cluster";
    cluster.id = "account-toolbar-cluster";
    cluster.innerHTML = `
      <a id="nav-help-link" class="nav-icon-btn" href="https://github.com/jourde/learning-designer-revised" target="_blank" rel="noopener noreferrer" title="${tr("Aide", "Help")}" aria-label="${tr("Aide", "Help")}">
        <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
      </a>
      <button id="saved-designs-btn" class="nav-icon-btn" type="button" title="${tr("Mes sauvegardes", "My saves")}" aria-label="${tr("Mes sauvegardes", "My saves")}">
        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
      </button>
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

    $("saved-designs-btn")?.addEventListener("click", () => {
      if (!authState.user) {
        window.location.href = "login.php";
        return;
      }
      openSavedDesignsModal();
    });

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
      return;
    }

    pill.innerHTML = `${tr("Compte", "Account")} <strong>${escapeHtml(authState.user.username || authState.user.email)}</strong>`;
    button.innerHTML = `<i class="fa-solid fa-user-check" aria-hidden="true"></i><span class="nav-account-label">${tr("Mon compte", "My account")}</span>`;
    menu.innerHTML = `
      <a class="account-menu-link" role="menuitem" href="profile.php">${tr("Profil", "Profile")}</a>
      ${String(authState.user.role) === "admin" ? `<a class="account-menu-link" role="menuitem" href="admin.php">${tr("Administration", "Admin")}</a>` : ""}
      <a class="account-menu-link" role="menuitem" href="logout.php">${tr("Deconnexion", "Sign out")}</a>
    `;
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
      updateSaveStatus(tr("Production chargee depuis votre compte.", "Design loaded from your account."));
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
    $("save-btn")?.addEventListener("click", () => {
      if (authState.user) {
        saveRemoteDesign();
      }
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    ensureSiteNavUi();
    ensureSavedDesignsModal();
    bindSaveButton();
    refreshAuth();
  });
})();
