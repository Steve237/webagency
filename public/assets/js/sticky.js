
/*  Sticky Header*/
let logo = document.querySelector('.logo-04');
window.addEventListener('scroll', function () {
    let header = document.querySelectorAll('header');

    header.forEach((headItem) => {
        headItem.classList.toggle('sticky', window.scrollY > 0);
    });
    // window.scrollY > 0
    // ? logo.setAttribute('src', 'assets/img/logo/logo04.png')
    // : logo.setAttribute('src', 'assets/img/logo/logo04.png');
});

var swiper = new Swiper(".swiper-container", {
    slidesPerView: 1,
    spaceBetween: 00,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        type: "progressbar",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        640: {
            slidesPerView: "auto",
            spaceBetween: 30,
        },
    },
});