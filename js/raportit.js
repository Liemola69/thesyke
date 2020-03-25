let hampurilaisMenu = document.getElementById("hampurilaisMenu");
let hampurilaisValikko = document.getElementById("hampurilaisValikko");
let ylaValikko = document.querySelectorAll("ul")[0];
let ylaNav = document.getElementById("ylaNav");
let etusivuValikkoLinkki = document.getElementById("etusivuValikkoLinkki");
let sivunNimi = document.getElementById("sivunNimi");
let auki = false;

// Luo olion, jolla seurataan vertikaalista swippausta
let mySwiper = new Swiper ('.swiper-container', {
    direction: 'vertical',
    loop: false,
    mousewheel: true,
    scrollbar: {
      el: '.swiper-scrollbar',
    }
});

// Luo olion, jolla seurataan horisontaalista swippausta
let mySwiper2 = new Swiper ('.swiper-pageContainer', {
    direction: 'horizontal',
    loop: false,
    pagination: {
        el: '.swiper-pagination',
        clickable: 'true',
        renderBullet: function (index, className) {
            let temp = ["Päivä","Viikko","Kuukausi"];
            return '<span class="' + className + '">' + (temp[index]) + '</span>';
        }
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

etusivuValikkoLinkki.addEventListener('click', function(evt){
    window.location.href = "sivurunko.html";
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
/*mySwiper2.on('slideChange', function(evt){
    if(mySwiper2.activeIndex == 1){
        sivunNimi.innerText = "Viikkonäkymä";
    } else if(mySwiper2.activeIndex == 2){
        sivunNimi.innerText = "Kuukausinäkymä";
    } else{
        sivunNimi.innerText = "Päivänäkymä";
    }
});*/