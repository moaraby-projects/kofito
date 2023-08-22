window.onload = function () {
    const navLinks = document.querySelectorAll("nav a");

    // استرجاع قيمة الرابط النشطة من localStorage
    const activeLink = sessionStorage.getItem("activeLink");

    if (activeLink) {
        // تعيين العنصر النشط بناءً على القيمة المسترجعة
        navLinks.forEach(link => {
            if (link.href === activeLink) {
                link.classList.add("active");
            } else {
                link.classList.remove("active");
            }
        });
    }

    // تعيين الاستماع للنقر على الروابط
    navLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            navLinks.forEach(link => {
                link.classList.remove("active");
            });
            this.classList.add("active");

            // حفظ الرابط النشط في localStorage
            sessionStorage.setItem("activeLink", this.href);

        });
    });
};

const header = document.querySelector('header');

function fixedNavbar () {
    header.classList.toggle('scrolled', window.pageYOffset > 0)
}
fixedNavbar();

window.onscroll = () => {
    fixedNavbar();
}
// or window.addEventListener('scroll', fixedNavbar);

let menu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');

menu.addEventListener('click', () => {
    let nav = document.querySelector('.navbar');
    nav.classList.toggle('active');
})
userBtn.addEventListener('click', () => {
    let userBox = document.querySelector('.user-box');
    userBox.classList.toggle('active');
})

// ------------ home page slider ----------
const leftArrow = document.querySelector('.left-arrow');
const rightArrow = document.querySelector('.right-arrow');
const slider = document.querySelector('.slider');
let timeId = setInterval(scrollRight, 7000);

// scroll to right
function scrollRight () {
    slider.scrollBy({
        left: slider.clientWidth,
        behavior: 'smooth'
    });

    checkAndReset();
}

// scroll to left
function scrollLeft () {
    slider.scrollBy({
        left: -slider.clientWidth,
        behavior: 'smooth'
    });

    checkAndReset();
}

// check if reached of end
function checkAndReset () {
    if (slider.scrollWidth - slider.scrollLeft === slider.clientWidth) {
        slider.scrollTo({
            left: 0,
            behavior: 'smooth'
        });
    }
}

// reset timer to scroll right
function resetTime () {
    clearInterval(timeId);
    timeId = setInterval(scrollRight, 7000);
}

// slider events
leftArrow.addEventListener('click', function () {
    scrollLeft();
    resetTime();
});

rightArrow.addEventListener('click', function () {
    scrollRight();
    resetTime();
});


// testimonials
let slides = document.querySelectorAll('.testimonials-item');
let index = 0;

function nextSlide () {
    slides[index].classList.remove('active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('active');
}
function prevSlide () {
    slides[index].classList.remove('active');
    index = (index - 1 + slides.length) % slides.length;
    slides[index].classList.add('active');
}
