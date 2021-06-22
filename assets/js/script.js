const menuBtn = document.querySelector("#menu-btn");
const sideBar = document.querySelector("#side-bar");
const header = document.querySelector("#header");
const overlay = document.querySelector("#overlay");
const searchForm = document.querySelector('#search-form');
const searchContols = document.querySelector('#search-controls');

// Menu Button
menuBtn.addEventListener("click", () => {
  menuBtn.classList.toggle("menu-btn-active");
  sideBar.classList.toggle("side-bar-open");
  overlay.classList.toggle("overlay-active");
  document.body.classList.toggle("no-scroll");
});

// Overlay
overlay.addEventListener("click", () => {
  menuBtn.classList.toggle("menu-btn-active");
  sideBar.classList.toggle("side-bar-open");
  overlay.classList.toggle("overlay-active");
  document.body.classList.toggle("no-scroll");
});

// Slide Menu in Side bar Menu
const slideHeads = document.querySelectorAll(".sub-menu-head");
slideHeads.forEach((slideHead) => {
  slideHead.addEventListener("click", () => {
    let slideList = slideHead.nextElementSibling;
    slideList.classList.toggle("active");
  });
});

// Menu Back Arrow
const backArrowArr = document.querySelectorAll(".back-menu");
backArrowArr.forEach((backArrow)=>{
    backArrow.addEventListener("click", () => {
    backArrow.parentElement.classList.toggle("active");
    });
});


//Search Form
searchContols.addEventListener("click", () => {
  searchContols.classList.toggle('search-controls-active');
  searchForm.classList.toggle('search-form-active');
});


// Scroll to Top Button
const scrollToTopBtn = document.getElementById("scrollToTopBtn");
const rootElement = document.documentElement;
var prevYpos = window.pageYOffset;
window.onscroll = () => {
  // Scroll to top button
  if (rootElement.scrollTop > 400) {
    scrollToTopBtn.style.right = "20px";
  } else if (rootElement.scrollTop < 300) {
    scrollToTopBtn.style.right = "-60px";
  }

  // header slide
  var currentYpos = window.pageYOffset;
  if (prevYpos > currentYpos) {
    header.style.top = "0";
  } else {
    header.style.top = "-100%";
  }
  prevYpos = currentYpos;

  searchContols.classList.remove('search-controls-active');
  searchForm.classList.remove('search-form-active');
};

function scrollToTop() {
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}
scrollToTopBtn.addEventListener("click", scrollToTop);


// Banner Owl Carousel
$(document).ready(function () {
  $("#banner-section .owl-carousel").owlCarousel({
    loop: true,
    nav: false,
    items: 1,
    center: true,
    touch: true,
  });
});


// Product Section's Owl Carousel
$(document).ready(function () {
  $(".products-slider .owl-carousel").owlCarousel({
    // margin: 20,
    nav: true,
    responsive: {
      0: {
        items: 1,
      },
      380: {
        items: 2,
      },
      576: {
        items: 3,
      },
      768: {
        items: 4,
      },
      992: {
        items: 5,
      },
      1200: {
        items: 7,
      },
    },
  });
});



// poduct Zoom Call
$(document).ready(function () {
  $("#exzoom").exzoom({
    "autoPlay": false
  });
});



// Search Box Suggerstions 

$(document).ready(function () {
  $("#search-input").on("keyup", function () {
    let searchTerm = $(this).val();
    $.ajax({
      url: "product-crud/search-options.php",
      data: { search: searchTerm },
      type: "POST",
      success: function (data) {
        if (data != 0) {
          $("#search-options").html(data);
        }
      }
    });
  });
});



// Popup Box
const popupTrigger = document.querySelector(".popup-trigger");
const popupBox = document.querySelector(".popup-box");
const popupClose = document.querySelector(".popup-close");
const overlayRating = document.querySelector(".overlay");

if(popupTrigger != null)
popupTrigger.addEventListener("click", (e) => {
    let isBuy = e.target.getAttribute("data-buy");
    
    if(isBuy == 1){
        popupBox.classList.toggle('slide-down');
        overlayRating.classList.toggle("show");
        document.body.classList.toggle("no-scroll");
    }else if(isBuy == 0){
        toast.classList.add("show");
        setTimeout(() => {
          toast.classList.remove("show");
        }, 4000);
    }
});

if(popupClose != null)
popupClose.addEventListener("click", () => {
    popupBox.classList.toggle('slide-down');
    overlayRating.classList.toggle("show");
    document.body.classList.toggle("no-scroll");
});

// Toast 
const toast = document.querySelector(".toast");
const closeBtn = document.querySelector(".close");
if(closeBtn != null)
closeBtn.addEventListener("click", () => {
    toast.classList.remove("show");
});

