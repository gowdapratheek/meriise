var dropbtnState = false;
const moreBtn = document.getElementById("dropbtn");
const dropCont = document.getElementById("dropdown-content");

function handleMoreBtn() {
    console.log("clickED");
    dropbtnState = !dropbtnState;
    if (dropbtnState === true) {
        dropCont.style.display = "block";
        console.log("changed", dropbtnState);
    } else {
        dropCont.style.display = "none";
    }
}
iuhj8uh8
var dropbtnState1 = false;
const moreBtn1 = document.getElementById("dropbtn");
const dropCont1 = document.getElementById("dropdown-content1");

function handleMoreBtn1() {
    console.log("clickED");
    dropbtnState1 = !dropbtnState1;
    if (dropbtnState1 === true) {
        dropCont.style.display = "block";
        console.log("changed", dropbtnState1);
    } else {
        dropCont.style.display = "none";
    }
}

function openNav() {
    console.log("clickED");
    document.getElementById("myNav").style.width = "70%";
}

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides((slideIndex += n));
}

function currentSlide(n) {
    showSlides((slideIndex = n));
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}
