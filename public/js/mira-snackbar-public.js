(function () {
  "use strict";
  const els = document.querySelectorAll(".mira-snackbar__close");
  els.forEach((el) => {
    el.addEventListener("click", closeSnackbar, {
      once: true,
    });
  });

  function closeSnackbar(e) {
    const container = e.target.closest(".mira-snackbar");
    container.classList.add("mira-snackbar--closed");
    container.addEventListener("transitionend", () => container.remove());
  }
})();
