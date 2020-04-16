let hampurilaisMenu = document.getElementById("hampurilaisMenu");
let hampurilaisValikko = document.getElementById("hampurilaisValikko");
let ylaValikko = document.querySelectorAll("ul")[0];
let ylaNav = document.getElementById("ylaNav");
let alaNav = document.getElementById("alaNav");
let raportitValikkoLinkki = document.getElementById("raportitValikkoLinkki");
let sivunNimi = document.getElementById("sivunNimi");
let auki = false;

let prevDayNuoli = document.getElementById("prevDayNuoli");
let nextDayNuoli = document.getElementById("nextDayNuoli");
let prevWeekNuoli = document.getElementById("prevWeekNuoli");
let nextWeekNuoli = document.getElementById("nextWeekNuoli");
let nuoliAlas = document.querySelectorAll(".fa-chevron-down");
let nuoliYlos = document.querySelectorAll(".fa-chevron-up");

let swiperContainer = document.querySelectorAll(".swiper-container");
let swiperPageContainer = document.querySelector(".swiper-pageContainer");

let paasivuWrapper = document.querySelectorAll(".paasivuWrapper");
let detailWrapper = document.querySelectorAll(".detailWrapper");

let paasivuViikkoWrapper = document.querySelector(".paasivuViikkoWrapper");

let viikonpaivaListaItem = document.getElementById("viikonpaivaLista").getElementsByTagName("li");

//let kuukaudenpaivaListaItem = document.getElementById("kuukaudenpaivaLista").getElementsByTagName("td");

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

// Korjaa viikkonäkymän selauksen pysymään viikkonäkymässä sivun päivittyessä
if(window.location.search == "?prevWeek=true"
|| window.location.search == "?nextWeek=true"){
    mySwiper2.slideTo('1', '0');
}


//**  Korjaa vertikaalisen swiperin ja wrappereiden korkeuden */
swiperPageContainer.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
for(let i = 0; i < 3; i++){
    swiperContainer[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
}
        
for(let i = 0; i < 2; i++){
    paasivuWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
}
            
for(let i = 0; i < 2; i++){
    detailWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
}

// Käynnistää vertikaaliset swiperit korjatuilla korkeusarvoilla
for(let i = 0; i < 3; i++){
    mySwiper[i].init();
}

// Aseta pääsivun viimeinen grid alaNavin kokoiseksi
for(let i = 0; i < 2; i++){
    paasivuWrapper[i].style.gridTemplateRows = "10% auto 15% auto 10% " + alaNav.clientHeight + "px";
    detailWrapper[i].style.gridTemplateRows = "auto auto auto auto auto " + alaNav.clientHeight + "px";

    paasivuViikkoWrapper.style.gridTemplateRows = "10% auto 10% " + alaNav.clientHeight + "px";
}

window.addEventListener("resize", function(evt){
    //**  Korjaa vertikaalisen swiperin ja wrappereiden korkeuden */
    swiperPageContainer.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    for(let i = 0; i < 3; i++){
        swiperContainer[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    }

    for(let i = 0; i < 2; i++){
        paasivuWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    }

    paasivuViikkoWrapper.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");

    for(let i = 0; i < 3; i++){
        detailWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    }

    // Korjaa pääsivun viimeinen grid alaNavin kokoiseksi
    for(let i = 0; i < 2; i++){
        paasivuWrapper[i].style.gridTemplateRows = "10% auto 15% auto 10% " + alaNav.clientHeight + "px";
        detailWrapper[i].style.gridTemplateRows = "60px auto auto auto auto " + alaNav.clientHeight + "px";
    }
    paasivuViikkoWrapper.style.gridTemplateRows = "10% auto 10% " + alaNav.clientHeight + "px";
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

// Siirry raportti sivulle
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

// Päivä painettu
nappula[0].addEventListener('click', function(evt){
    mySwiper[1].slideTo('0','300','true');
    mySwiper[2].slideTo('0','300','true');
});

// Viikko painettu
nappula[1].addEventListener('click', function(evt){
    mySwiper[0].slideTo('0','300','true');
    mySwiper[2].slideTo('0','300','true');
});

// Kuukausi painettu
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

// Päivänäkymän yläbannerin nuolien toiminta
prevDayNuoli.addEventListener('click', function(evt){
    window.location.href="sivurunko.php?prevDay=true";
});

nextDayNuoli.addEventListener('click', function(evt){
    window.location.href="sivurunko.php?nextDay=true";
});

// Viikkonäkymän yläbannerin nuolien toiminta
prevWeekNuoli.addEventListener('click', function(evt){
    window.location.href="sivurunko.php?prevWeek=true";
});

nextWeekNuoli.addEventListener('click', function(evt){
    window.location.href="sivurunko.php?nextWeek=true";
});

// Siirry detail/pääsivuun kun painetaan nuolta alas/ylöspäin
for(let i = 0; i < 3; i++){

    nuoliAlas[i].addEventListener('click', function(evt){
        mySwiper[i].slideTo('1');
    });

    nuoliYlos[i].addEventListener('click', function(evt){
        mySwiper[i].slideTo('0');
    });
}

// Siirry viikkonäkymästä klikattuun päivään
for(let i = 0; i < 7; i++){

    viikonpaivaListaItem[i].addEventListener('click', function(evt){
        window.location.href="sivurunko.php?moveToDay=" + i;
    });
}

var dt = new Date();
        function renderDate() {
            dt.setDate(1);

            var day = dt.getDay();
            var today = new Date();
            var endDate = new Date(
                dt.getFullYear(),
                dt.getMonth() + 1,
                0
            ).getDate();

            var prevDate = new Date(
                dt.getFullYear(),
                dt.getMonth(),
                0
            ).getDate();
            var months = [
                "TAMMIKUU",
                "HELMIKUU",
                "MAALISKUU",
                "HUHTIKUU",
                "TOUKOKUU",
                "KKESÄKUU",
                "HEINÄKUU",
                "ELOKUU",
                "SSYYSKUU",
                "LOKAKUU",
                "MARRASKUU",
                "JOULUKUU"
            ]

document.getElementById("month").innerHTML = months[dt.getMonth()];
document.getElementById("year").innerHTML = dt.getFullYear();
var cells = "";
for (x = day-1; x > 0; x--) {

    cells += "<div class='prev_date'>" + (prevDate - x + 1) + "</div>";
}
console.log(day);
for (i = 1; i <= endDate; i++) {
    if (i == today.getDate() && dt.getMonth() == today.getMonth()) cells += "<div class='today'>" + i + "</div>";
    else
        cells += "<div class = other-day>" + i + "</div>";
}
document.getElementsByClassName("daysOfMonth")[0].innerHTML = cells;



/*document.addEventListener("click", function(){
    document.getElementsByClassName("today").innerHTML = today;
  });
document.addEventListener("click", function(){
    document.getElementsByClassName("other-day").innerHTML = cells++;
  });*/

}

        function moveDate(para) {
            if(para == "prev") {
                dt.setMonth(dt.getMonth() - 1);
            } else if(para == 'next') {
                dt.setMonth(dt.getMonth() + 1);
            }
            renderDate();
        }