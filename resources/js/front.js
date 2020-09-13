window.addEventListener("load", () => {
    const trigger = document.querySelector(".nav-trigger");

    trigger.addEventListener("click", () => {
        document.querySelector(".main-nav").classList.toggle("show");
    });
});
