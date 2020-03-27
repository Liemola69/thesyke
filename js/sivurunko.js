let hampurilaisMenu = document.getElementById("hampurilaisMenu");
let hampurilaisValikko = document.getElementById("hampurilaisValikko");
let ylaValikko = document.querySelectorAll("ul")[0];
let ylaNav = document.getElementById("ylaNav");
let raportitValikkoLinkki = document.getElementById("raportitValikkoLinkki");
let sivunNimi = document.getElementById("sivunNimi");
let auki = false;

let alaNav = document.getElementById("alaNav");
let swiperContainer = document.querySelectorAll(".swiper-container");
let swiperPageContainer = document.querySelector(".swiper-pageContainer");
let paasivuWrapper = document.querySelectorAll(".paasivuWrapper");
let detailWrapper = document.querySelectorAll(".detailWrapper");

// Luo olion, jolla seurataan vertikaalista swippausta
let mySwiper = new Swiper ('.swiper-container', {
    init: false,
    direction: 'vertical',
    loop: false,
    mousewheel: true,
});

// Luo olion, jolla seurataan horisontaalista swippausta
let mySwiper2 = new Swiper ('.swiper-pageContainer', {
    direction: 'horizontal',
    loop: false,
    pagination: {
        el: '.swiper-pagination',
        clickable: 'true',
        renderBullet: function (index, className) {
            let temp = ["PÄIVÄ","VIIKKO","KUUKAUSI"];
            return '<span class="' + className + '">' + (temp[index]) + '</span>';
        }
    }
});

//**  Korjaa vertikaalisen swiperin ja wrappereiden korkeuden */
swiperPageContainer.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
for(let i = 0; i < 3; i++){
    swiperContainer[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
}
        
for(let i = 0; i < 3; i++){
    paasivuWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
}
            
for(let i = 0; i < 3; i++){
    detailWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
}
/** */

// Käynnistää vertikaaliset swiperit korjatuilla korkeusarvoilla
for(let i = 0; i < 3; i++){
    mySwiper[i].init();
}

// Aseta pääsivun viimeinen grid alaNavin kokoiseksi
for(let i = 0; i < 3; i++){
    paasivuWrapper[i].style.gridTemplateRows = "auto 15% auto 10% " + alaNav.clientHeight + "px";
    detailWrapper[i].style.gridTemplateRows = "auto auto auto auto auto " + alaNav.clientHeight + "px";
}

window.addEventListener("resize", function(evt){
    //**  Korjaa vertikaalisen swiperin ja wrappereiden korkeuden */
    swiperPageContainer.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    for(let i = 0; i < 3; i++){
        swiperContainer[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    }

    for(let i = 0; i < 3; i++){
        paasivuWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    }

    for(let i = 0; i < 3; i++){
        detailWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    }
    /** */

    // Korjaa pääsivun viimeinen grid alaNavin kokoiseksi
    for(let i = 0; i < 3; i++){
        paasivuWrapper[i].style.gridTemplateRows = "auto 15% auto 10% " + alaNav.clientHeight + "px";
        detailWrapper[i].style.gridTemplateRows = "60px auto auto auto auto " + alaNav.clientHeight + "px";
    }
});

// Avaa hampurilaisvalikon klikkauksesta
hampurilaisMenu.addEventListener('click', function(evt){

    if(auki == false){
        ylaValikko.style['display'] = "block";
        hampurilaisValikko.style['top'] = ylaNav.clientHeight + "px";
        hampurilaisValikko.style['height'] = "fit-content";
        auki = true;
    } else{
        ylaValikko.style['display'] = "none";
        hampurilaisValikko.style['height'] = "0px";
        auki = false;
    }
    
});

raportitValikkoLinkki.addEventListener('click', function(evt){
    window.location.href = "raportit.html";
});

// Estä sivuswipe, jos detail-sivulla
for(let i = 0; i < 3; i++){
    mySwiper[i].on('slideChange', function(evt){
        if(mySwiper[i].activeIndex == 1){
            mySwiper2.allowTouchMove = false;
        } else{
            mySwiper2.allowTouchMove = true;
        }
    });
}

// Palauta muut sivut päänäkymiin, jos painaa alaNavin painikkeista
let nappula = document.querySelectorAll(".swiper-pagination-bullet");

nappula[0].addEventListener('click', function(evt){
    mySwiper[1].slideTo('0','300','true');
    mySwiper[2].slideTo('0','300','true');
});

nappula[1].addEventListener('click', function(evt){
    mySwiper[0].slideTo('0','300','true');
    mySwiper[2].slideTo('0','300','true');
});

nappula[2].addEventListener('click', function(evt){
    mySwiper[0].slideTo('0','300','true');
    mySwiper[1].slideTo('0','300','true');
});

// Päivitä yläNavin teksti näkymän mukaan
mySwiper2.on('slideChange', function(evt){
    if(mySwiper2.activeIndex == 1){
        sivunNimi.innerText = "VIIKKONÄKYMÄ";
    } else if(mySwiper2.activeIndex == 2){
        sivunNimi.innerText = "KUUKAUSINÄKYMÄ";
    } else{
        sivunNimi.innerText = "PÄIVÄNÄKYMÄ";
    }
});