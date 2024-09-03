const menuBtn = document.querySelector(".nav-btn.menu");

menuBtn.addEventListener("click", () => {
    document.getElementById("myNav").style.display = "block";
});

function closeNav() {
    document.getElementById("myNav").style.display = "none";
}
