(function () {
  "use strict";
  const els = document.querySelectorAll(".mira-snackbar");

  els.forEach((el) => {
    const closeBtns = document.querySelectorAll(
      ".mira-snackbar__close, .mira-snackbar__btn--close"
    );
    const links = document.querySelectorAll(".mira-snackbar__btn--link");
    const popupTriggers = document.querySelectorAll(
      ".mira-snackbar__btn--popup-trigger"
    );

    const data = {
      id: el.dataset.sid,
      expired: el.dataset.showAfter,
    };

    closeBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => closeSnackbar(e, data), {
        once: true,
      });
    });

    links.forEach((link) =>
      link.addEventListener("click", () => setSnackbarCookie(data), {
        once: true,
      })
    );

    popupTriggers.forEach((el) => initPopup(el));

    if (el.dataset.delay)
      setTimeout(() => showDelayedSnackbar(el), +el.dataset.delay * 1000);
  });

  function closeSnackbar(e, data) {
    const container = e.target.closest(".mira-snackbar-container");
    container.classList.add("mira-snackbar--closed");
    container.addEventListener("transitionend", () => container.remove());
    setSnackbarCookie(data);
  }

  function setSnackbarCookie(data) {
    if (checkCookie(`m-snackbar-${data.id}`)) return;
    setCookie(`m-snackbar-${data.id}`, "showed", data.expired);
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

  function initPopup(triggerBtn) {
    const popupEl = triggerBtn
      .closest(".mira-snackbar-container")
      .querySelector(".mira-snackbar-popup");
    const closeBtn = popupEl.querySelector(".mira-snackbar-popup__close");

    triggerBtn.addEventListener("click", () => openPopup(popupEl));
    closeBtn.addEventListener("click", (e) => closePopup(e, popupEl));
    popupEl.addEventListener("click", (e) => closePopup(e, popupEl));
  }

  function openPopup(popupEl) {
    popupEl.style.display = "";
    setTimeout(() => {
      popupEl.classList.add("mira-snackbar-popup--showed");
    }, 17);
  }

  function closePopup(e, popupEl) {
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

  function showDelayedSnackbar(el) {
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
})();
