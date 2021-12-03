(function () {
  "use strict";
  const els = document.querySelectorAll(".mira-snackbar");

  els.forEach((el) => {
    const closeBtns = document.querySelectorAll(
      ".mira-snackbar__close, .mira-snackbar__btn--close"
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
  });

  function closeSnackbar(e, data) {
    const container = e.target.closest(".mira-snackbar");
    container.classList.add("mira-snackbar--closed");
    container.addEventListener("transitionend", () => container.remove());
    setSnackbarCookie(data);
  }

  function setSnackbarCookie(data) {
    if (checkCookie(`m_snackbar_${data.id}`)) return;
    setCookie(`m_snackbar_${data.id}`, "showed", data.expired);
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
})();
