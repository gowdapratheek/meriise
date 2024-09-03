const selecteCoursesMenu = document.getElementById("select-courses");
const totalAmountElement = document.getElementById("total-amount");
const goToTopBtn = document.querySelector(".scrollupBtn");

const getSelectedCourses = () => {
    const selectedCourses = document.querySelectorAll(
        "#select-courses option:checked"
    );
    const courses = Array.from(selectedCourses).map((el) => ({
        title: el.value,
        price: el.dataset.price,
    }));
    return courses;
};

selecteCoursesMenu.addEventListener("change", () => {
    totalAmount = 0;
    const courses = getSelectedCourses();
    if (courses.length === 0) {
        totalAmountElement.innerHTML = "&#8377 " + totalAmount;
        return;
    }
    courses.forEach((c) => {
        totalAmount += parseFloat(c.price);
    });
    totalAmountElement.innerHTML = "&#8377 " + totalAmount;
});

goToTopBtn.addEventListener("click", (e) => {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});

window.onscroll = function () {
    handleScroll();
};

function handleScroll() {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        goToTopBtn.style.display = "block";
    } else {
        goToTopBtn.style.display = "none";
    }
}

//on return
window.onload = () => {
    totalAmount = 0;
    const courses = getSelectedCourses();
    if (courses.length === 0) {
        totalAmountElement.innerHTML = "&#8377 " + totalAmount;
        return;
    }
    courses.forEach((c) => {
        totalAmount += parseFloat(c.price);
    });
    totalAmountElement.innerHTML = "&#8377 " + totalAmount;
};
