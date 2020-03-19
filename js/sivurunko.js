let nav = document.querySelector("nav");
let navTop = nav.offsetTop;

window.addEventListener("scroll", function(evt){
    if (window.pageYOffset > navTop){
        nav.classList.add('fixed');
    } else{
        nav.classList.remove('fixed');
    }
});