window.addEventListener("scroll", function () {
    const nav = document.querySelector("nav");

    if (nav) {
        nav.classList.toggle("scrolled", window.scrollY > 0);
    }
});