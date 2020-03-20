let hampurilaisMenu = document.getElementById("hampurilaisMenu");
let hampurilaisValikko = document.getElementById("hampurilaisValikko");
let ylaValikko = document.querySelectorAll("ul")[0];
let ylaNav = document.getElementById("ylaNav");
let alaNav = document.getElementById("alaNav");
let sivulleSwipe = document.getElementById("sivuSwipeWrapper");
let auki = false;

// Luo olion, jolla seurataan vertikaalista swippausta
let mySwiper = new Swiper ('.swiper-container', {
    direction: 'vertical',
    loop: false,
    mousewheel: true,
    scrollbar: {
      el: '.swiper-scrollbar',
    },
});

// Luo olion, jolla seurataan horisontaalista swippausta
let mySwiper2 = new Swiper ('.swiper-pageContainer', {
    direction: 'horizontal',
    loop: false,
    scrollbar: {
      el: '.swiper-scrollbar',
    },
});

// Avaa hampurilaisvalikon klikkauksesta
hampurilaisMenu.addEventListener('click', function(evt){

    if(auki == false){
        ylaValikko.style['display'] = "block";
        hampurilaisValikko.style['height'] = "fit-content";
        auki = true;
    } else{
        ylaValikko.style['display'] = "none";
        hampurilaisValikko.style['height'] = "0px";
        auki = false;
    }
    
});

// Vaihtaa alaNavin highlightin swipen mukaisesti vertaamalla
// swippauksen transition leveyttä näytön leveyteen
sivulleSwipe.addEventListener('transitionend', function(evt){
    let paivaNakyma = document.getElementById("paivaNakyma");
    let viikkoNakyma = document.getElementById("viikkoNakyma");
    let kuukausiNakyma = document.getElementById("kuukausiNakyma");

    let transArvo = sivulleSwipe.style.transform.split("p");
    let xArvo = parseInt(transArvo[0].slice(12)) * (-1);

    if(xArvo < 1){
        // päivänäkymä
        paivaNakyma.classList.add("activeNav");
        viikkoNakyma.classList.remove("activeNav");
        kuukausiNakyma.classList.remove("activeNav");
    }else if(xArvo == window.innerWidth){
        //viikkonäkymä
        paivaNakyma.classList.remove("activeNav");
        viikkoNakyma.classList.add("activeNav");
        kuukausiNakyma.classList.remove("activeNav");
    }else if(xArvo == (2*window.innerWidth)){
        //kuukausinäkymä
        paivaNakyma.classList.remove("activeNav");
        viikkoNakyma.classList.remove("activeNav");
        kuukausiNakyma.classList.add("activeNav");
    }
});