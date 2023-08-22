const body = document.querySelector("body"),
    modeToggle = body.querySelector(".mode-toggle");
sidebar = body.querySelector("nav");
sidebarToggle = body.querySelector(".sidebar-toggle");

let getMode = localStorage.getItem("mode");
if (getMode && getMode === "dark") {
    body.classList.toggle("dark");
}

let getStatus = localStorage.getItem("status");
if (getStatus && getStatus === "close") {
    sidebar.classList.toggle("close");
}

modeToggle.addEventListener("click", () => {
    body.classList.toggle("dark");
    if (body.classList.contains("dark")) {
        localStorage.setItem("mode", "dark");
    } else {
        localStorage.setItem("mode", "light");
    }
});

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if (sidebar.classList.contains("close")) {
        localStorage.setItem("status", "close");
    } else {
        localStorage.setItem("status", "open");
    }
})

// الحصول على العنوان الحالي
var currentURL = window.location.href;

// الجزء الأخير من العنوان (اسم الملف)
var lastPart = currentURL.substring(currentURL.lastIndexOf('/') + 1);

window.onload = () => {
    const navLinks = document.querySelectorAll('.nav-links li a');

    // استرجاع قيمة الرابط النشطة من localStorage
    const activeLinkAdmin = sessionStorage.getItem("activeLinkAdmin");

    if (activeLinkAdmin) {
        // تعيين العنصر النشط بناءً على القيمة المسترجعة
        navLinks.forEach(link => {
            if (link.href === currentURL) {
                link.classList.add("active");
            } else {
                link.classList.remove("active");
            }
        });
    }

    // تعيين الاستماع للنقر على الروابط
    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            navLinks.forEach(link => {
                link.classList.remove("active");
            });
            this.classList.add("active");

            // حفظ الرابط النشط في localStorage
            sessionStorage.setItem("activeLinkAdmin", this.href);

        });
    });

}