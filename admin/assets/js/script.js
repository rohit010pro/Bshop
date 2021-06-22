const menuBtn = document.querySelector(".menu-btn");
const sideBar = document.querySelector("#side-bar");
const mainSection = document.querySelector("#main");

menuBtn.addEventListener("click",()=>{
    sideBar.classList.toggle("active");
    mainSection.classList.toggle("active");
});

const productDesc = document.querySelector("#product-desc");
if(productDesc != null) {
    CKEDITOR.replace('product-desc', {
        extraPlugins: 'editorplaceholder',
        editorplaceholder: 'Product Description...',
    });
}