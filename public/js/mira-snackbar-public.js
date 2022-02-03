const MiraSnackbars = (function () {
  "use strict";

  class MiraSnackbars {
    init() {
      this.initStaticSnackabrs();
      this.initFixedSnackbars();
    }

    hydratate(els) {
      els.forEach((el) => {
        const closeBtns = el.querySelectorAll(
          ".mira-snackbar__close, .mira-snackbar__btn--close"
        );
        const links = el.querySelectorAll(".mira-snackbar__btn--link");
        const popupTriggers = el.querySelectorAll(
          ".mira-snackbar__btn--popup-trigger"
        );

        const data = {
          id: el.dataset.sid,
          expired: el.dataset.showAfter,
        };

        closeBtns.forEach((btn) => {
          btn.addEventListener("click", (e) => this.closeSnackbar(e, data), {
            once: true,
          });
        });

        links.forEach((link) =>
          link.addEventListener("click", () => this.setSnackbarCookie(data), {
            once: true,
          })
        );

        popupTriggers.forEach((el) => this.initPopup(el));

        if (el.dataset.delay)
          setTimeout(
            () => this.showDelayedSnackbar(el),
            +el.dataset.delay * 1000
          );
      });
    }

    initStaticSnackabrs() {
      const els = document.querySelectorAll(".mira-snackbar");
      this.hydratate(els);
    }

    async initFixedSnackbars() {
      const html = await this.loadFixedSnackbars();
      if (!html) return;
      const els = this.apendFixedSnackbar(html);
      this.hydratate(els);
    }

    async loadFixedSnackbars() {
      try {
        const res = await fetch(
          mira_snackbar_settings.rest_api.base +
            "/" +
            mira_snackbar_settings.rest_api.get_snackbars,
          {
            headers: {
              "X-WP-Nonce": mira_snackbar_settings.nonce,
            },
          }
        );
        const { data } = await res.json();
        return data;
      } catch (error) {
        console.log(error);
      }
    }

    apendFixedSnackbar(html) {
      const tpl = document.createElement("template");
      tpl.innerHTML = html;
      const els = tpl.content.querySelectorAll(".mira-snackbar");
      document.body.append(tpl.content);
      return els;
    }

    closeSnackbar(e, data) {
      const container = e.target.closest(".mira-snackbar-container");
      const el = e.target.closest(".mira-snackbar");
      el.classList.add("mira-snackbar--closed");
      el.addEventListener("transitionend", () => container.remove());
      this.setSnackbarCookie(data);
    }

    setSnackbarCookie(data) {
      if (checkCookie(`m-snackbar-${data.id}`)) return;
      setCookie(`m-snackbar-${data.id}`, "showed", data.expired);
    }

    initPopup(triggerBtn) {
      const popupEl = triggerBtn
        .closest(".mira-snackbar-container")
        .querySelector(".mira-snackbar-popup");
      const closeBtn = popupEl.querySelector(".mira-snackbar-popup__close");

      triggerBtn.addEventListener("click", () => this.openPopup(popupEl));
      closeBtn.addEventListener("click", (e) => this.closePopup(e, popupEl));
      popupEl.addEventListener("click", (e) => this.closePopup(e, popupEl));
    }

    openPopup(popupEl) {
      popupEl.style.display = "";
      setTimeout(() => {
        popupEl.classList.add("mira-snackbar-popup--showed");
      }, 17);
    }

    closePopup(e, popupEl) {
      if (
        !e.target.classList.contains("mira-snackbar-popup__close") &&
        e.target != popupEl
      )
        return;
      popupEl.classList.remove("mira-snackbar-popup--showed");
      popupEl.addEventListener(
        "transitionend",
        () => (popupEl.style.display = "none"),
        {
          once: true,
        }
      );
    }

    showDelayedSnackbar(el) {
      el.style.display = "";
      setTimeout(() => {
        el.classList.add("mira-snackbar--delayed-showing");
        el.addEventListener(
          "transitionend",
          () => (
            el.classList.remove("mira-snackbar--delayed"),
            el.classList.remove("mira-snackbar--delayed-showing")
          ),
          {
            once: true,
          }
        );
      }, 16);
    }
  }

  function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(";");
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == " ") {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  function checkCookie(name) {
    let val = getCookie(name);
    if (val != "") {
      return true;
    } else {
      return false;
    }
  }

  function setCookie(cname, cvalue, exsec) {
    const d = new Date();
    d.setTime(d.getTime() + exsec * 1000);
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  return MiraSnackbars;
})();

const miraSnackbars = new MiraSnackbars();

miraSnackbars.init();
