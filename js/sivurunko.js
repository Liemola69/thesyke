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

// Detailsivun muuttujat
let detailWrapper = document.querySelectorAll(".detailWrapper");

// Päivänäkymän muuttujat
let paasivuPaivaWrapper = document.querySelector(".paasivuPaivaWrapper");

// Viikkonäkymän muuttujat
let paasivuViikkoWrapper = document.querySelector(".paasivuViikkoWrapper");
let viikonpaivaListaItem = document.getElementById("viikonpaivaLista").getElementsByTagName("li");

//let kuukaudenpaivaListaItem = document.getElementById("kuukaudenpaivaLista").getElementsByTagName("td");
// Kuukausinäkymän muuttujat
let paasivuKuukausiWrapper = document.querySelector(".paasivuKuukausiWrapper");

// Polar valikon muuttujat
let paivita = document.querySelectorAll(".hidden")[0];
let poista = document.querySelectorAll(".hidden")[1];
let polarLinkitys = document.getElementById("polarLinkitys");

let kalenteriKkPaivat = document.querySelector(".daysOfMonth");
let kalenteriPaivat = kalenteriKkPaivat.childNodes;

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

// Korjaa vertikaalisen swiperin ja wrappereiden korkeuden
swiperPageContainer.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
for(let i = 0; i < 3; i++){
    swiperContainer[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
}

// Korjaa sivun sisällön korkeus ylä- ja alanavin mukaisesti
paasivuPaivaWrapper.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
paasivuViikkoWrapper.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
paasivuKuukausiWrapper.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");

// Korjaa sivun detailnäkymien sisällön korkeus ylä- ja alanavin mukaisesti
for(let i = 0; i < 3; i++){
    detailWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
}

// Käynnistää vertikaaliset swiperit korjatuilla korkeusarvoilla
for(let i = 0; i < 3; i++){
    mySwiper[i].init();
}

// Aseta päänäkymän viimeinen grid alaNavin kokoiseksi
paasivuPaivaWrapper.style.gridTemplateRows = "10% auto 15% auto 10% " + alaNav.clientHeight + "px";
paasivuViikkoWrapper.style.gridTemplateRows = "10% auto 10% " + alaNav.clientHeight + "px";
paasivuKuukausiWrapper.style.gridTemplateRows = "auto 10%" + alaNav.clientHeight + "px";

// Aseta detailsivun viimeinen grid alaNavin kokoiseksi
for(let i = 0; i < 3; i++){
    detailWrapper[i].style.gridTemplateRows = "auto auto auto auto auto " + alaNav.clientHeight + "px";
}

window.addEventListener("resize", function(evt){
    korjaaSisallonKorkeus();
});

document.addEventListener("resize", function(evt){
    korjaaSisallonKorkeus();
});

// Avaa hampurilaisvalikon klikkauksesta
hampurilaisMenu.addEventListener('click', function(evt){

    if(auki == false){
        ylaValikko.style['display'] = "block";
        hampurilaisValikko.style['top'] = ylaNav.clientHeight + "px";
        //hampurilaisValikko.style['height'] = "fit-content";
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

// Avaa lisävalikko kun paina hampurilaisvalikosta Polar
polarLinkitys.addEventListener('click', function(evt){
    paivita.classList.toggle('hidden');
    poista.classList.toggle('hidden');
});

paivita.addEventListener('click', function(evt){
    window.location.href = "polar.php";
})

poista.addEventListener('click', function(evt){
    let varmistus = confirm("Haluatko varmasti poistaa linkityksen?");
    if(varmistus){
        window.location.href="sivurunko.php?deletePolar=true";
    }
})

function korjaaSisallonKorkeus(){
    //**  Korjaa vertikaalisen swiperin ja wrappereiden korkeuden */
    swiperPageContainer.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    for(let i = 0; i < 3; i++){
        swiperContainer[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    }

    // Korjaa sivun päänäkymien sisällön korkeus ylä- ja alanavin mukaisesti
    paasivuPaivaWrapper.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    paasivuViikkoWrapper.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    paasivuKuukausiWrapper.setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");

    // Korjaa sivun detailnäkymien sisällön korkeus ylä- ja alanavin mukaisesti
    for(let i = 0; i < 3; i++){
        detailWrapper[i].setAttribute('style', "height: " + (window.innerHeight - alaNav.clientHeight) + "px;");
    }

    // Aseta päänäkymän viimeinen grid alaNavin kokoiseksi
    paasivuPaivaWrapper.style.gridTemplateRows = "10% auto 15% auto 10% " + alaNav.clientHeight + "px";
    paasivuViikkoWrapper.style.gridTemplateRows = "10% auto 10% " + alaNav.clientHeight + "px";
    paasivuKuukausiWrapper.style.gridTemplateRows = "auto 10%" + alaNav.clientHeight + "px";

    // Korjaa detailsivun viimeinen grid alaNavin kokoiseksi
    for(let i = 0; i < 3; i++){
        detailWrapper[i].style.gridTemplateRows = "auto auto auto auto auto " + alaNav.clientHeight + "px";
    }
}

// Kuukausinäkymän js
let dt = new Date(); // vaihda hakemaan sovelluksesta päivä
        
function renderDate(currentDay) {
    dt.setDate(1);

    let day = dt.getDay();
    let today = new Date();
    let endDate = new Date(
        dt.getFullYear(),
        dt.getMonth() + 1,
        0
    ).getDate();

    let prevDate = new Date(
        dt.getFullYear(),
        dt.getMonth(),
        0
    ).getDate();
    
    let months = [
        "TAMMIKUU",
        "HELMIKUU",
        "MAALISKUU",
        "HUHTIKUU",
        "TOUKOKUU",
        "KESÄKUU",
        "HEINÄKUU",
        "ELOKUU",
        "SYYSKUU",
        "LOKAKUU",
        "MARRASKUU",
        "JOULUKUU"
    ];

    // Asetetaan kuukauden nimi ja vuosi näkyviin yläreunaan
    document.getElementById("month").innerHTML = months[dt.getMonth()];
    document.getElementById("year").innerHTML = dt.getFullYear();
    let cells = "";

    // Asetetaan edeltävän kuukauden päivien numerot soluihin
    for (x = day-1; x > 0; x--) {
        cells += "<div class='prev_date'>" + (prevDate - x + 1) + "</div>";
    }
    
    // Asetetaan kuluvan kuukauden päivien numerot soluihin
    for (i = 1; i <= endDate; i++) {
        if (i == today.getDate() && dt.getMonth() == today.getMonth()){
            cells += "<div class='today'>" + i + "</div>";
        } else{
            cells += "<div class = other-day>" + i + "</div>";
        } 
    }
    document.getElementsByClassName("daysOfMonth")[0].innerHTML = cells;

    /*document.addEventListener("click", function(){
        document.getElementsByClassName("today").innerHTML = today;
    });
    document.addEventListener("click", function(){
        document.getElementsByClassName("other-day").innerHTML = cells++;
    });*/


    //let kalenteriKkPaivat = document.querySelector(".daysOfMonth");
    //let kalenteriPaivat = kalenteriKkPaivat.childNodes;

    // Varmista, ettei highlight jää vanhalle päivälle päälle
    for(let i = 0; i < kalenteriPaivat.length; i++){
        if(kalenteriPaivat[i].classList.contains('highlight')){
            kalenteriPaivat[i].classList.toggle('highlight');
        }
    }
    
    for(let i = 0; i < kalenteriPaivat.length; i++){

        // Lisää kalenteriin highlight sovelluksen currentDayn kohdalle
        if((dt.getFullYear() + "-" + formatMonth(dt.getMonth(), kalenteriPaivat[i].classList) + "-" + formatDay(kalenteriPaivat[i].innerText, kalenteriPaivat[i].classList)) == currentDay){
            kalenteriPaivat[i].classList.toggle('highlight');
        }

        // Vaihda sovelluksen currentDay kalenteripäivän painalluksen mukaiseksi
        kalenteriPaivat[i].addEventListener('click', function(evt){
            if(dt.getMonth() == 0 && kalenteriPaivat[i].classList.contains('prev_date')){
                window.location.href="sivurunko.php?moveToDay=" + (dt.getFullYear()-1) + "-" + formatMonth(11, kalenteriPaivat[i].classList) + "-" + formatDay(kalenteriPaivat[i].innerText, kalenteriPaivat[i].classList);
            } else{
                window.location.href="sivurunko.php?moveToDay=" + dt.getFullYear() + "-" + formatMonth(dt.getMonth(), kalenteriPaivat[i].classList) + "-" + formatDay(kalenteriPaivat[i].innerText, kalenteriPaivat[i].classList);
            }
        })
    }
}

// Palauta kuukausi muodossa mm
function formatMonth(currentMonth, classList){
    currentMonth += 1;
    if(classList.contains('prev_date')){
        if(currentMonth < 10){
            currentMonth -= 1;
            return "0"+currentMonth;
        }else{
            return currentMonth;
        }
    } else{
        if(currentMonth < 10){
            return "0"+currentMonth;
        } else{
            return currentMonth;
        }
    }
}

// Palauta päivä muodossa dd
function formatDay(numberOfDay, classList){
    if(classList.contains('prev_date')){
        if(numberOfDay < 10){
            numberOfDay -= 1;
            return "0"+numberOfDay;
        } else{
            return numberOfDay;
        }
    } else{
        if(numberOfDay < 10){
            return "0"+numberOfDay;
        } else{
            return numberOfDay;
        }
    }
}

function moveDate(para) {
    let month;

    if(para == "prev") {
        dt.setMonth(dt.getMonth()-1);
        /*if(dt.getMonth() < 10){
            month = "0" + (dt.getMonth()+1);
        } else{
            month = (dt.getMonth()+1);
        }
        console.log(dt.getFullYear() + "-" + month + "-" + "01");
        getCurrentDay(dt.getFullYear() + "-" + month + "-" + "01");*/
    } else if(para == 'next') {
        dt.setMonth(dt.getMonth() + 1);
        /*if(dt.getMonth() < 10){
            month = "0" + (dt.getMonth()+1);
        } else{
            month = (dt.getMonth()+1);
        }
        console.log(dt.getFullYear() + "-" + month + "-" + "01");
        getCurrentDay(dt.getFullYear() + "-" + month + "-" + "01");*/
    }

    requestCurrentDay();
}

// Käy kysymässä palvelimelta, mikä on sessiomuuttujissa nykyinen päivä
function requestCurrentDay(){
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let currentDay = this.responseText;
            getCurrentDay(currentDay);
        }
    };
    xhttp.open("GET", "currentDayAJAX.php", true);
    xhttp.send();
}

// Kun palvelimelta saatu nykyinen päivä, renderöi kuukausinäkymän uudelleen ja lataa hymiöt
function getCurrentDay(ajaxResponse){
    renderDate(ajaxResponse);
    requestHymio();
}

function requestHymio(){
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let hymio = this.responseText;
            console.log("One hymiö coming up");
            printMonthHymio(hymio);
        }
    };
    xhttp.open("GET", "currentMonthAJAX.php", true);
    xhttp.send();
}

// Ottaa vastaan kuukauden hymiöt stringinä ja asettaa ne kalenterinäkymään
function printMonthHymio(hymio){
    //console.log(hymio);
    let hymiot = hymio.split(";");
    //console.log(hymiot);
    
    let kalenteriKkPaivat = document.querySelector(".daysOfMonth");
    let kalenteriPaivat = kalenteriKkPaivat.childNodes;

    for(let i = 0; i < kalenteriPaivat.length; i++){
        let hymioDiv = document.createElement("div");
        let naamari = luoHymio(hymiot[i]);
        let offset;

        if(dt.getDay() == 0){
            offset = i;
        } else{
            offset = dt.getDay() - 1 + i;
        }
        
        hymioDiv.appendChild(naamari);
        kalenteriPaivat[offset].appendChild(hymioDiv);
    }
}

function luoHymio(i){
    let hymio = document.createElement("i");
    if(i == "null"){
        hymio.classList.add('fas');
        hymio.classList.add('fa-meh-blank');
        hymio.classList.add('hymio-viikko');
        hymio.style.color = "var(--liikennevaloHarmaa)";
    } else{
        switch(i){
            case "1":
                hymio.classList.add('fas');
                hymio.classList.add('fa-frown');
                hymio.classList.add('hymio-viikko');
                hymio.style.color = "var(--liikennevaloPunainen)";
                break;
            case "2":
                hymio.classList.add('fas');
                hymio.classList.add('fa-meh');
                hymio.classList.add('hymio-viikko');
                hymio.style.color = "var(--liikennevaloKeltainen)";
                break;
            case "3":
                hymio.classList.add('fas');
                hymio.classList.add('fa-laugh');
                hymio.classList.add('hymio-viikko');
                hymio.style.color = "var(--liikennevaloVihrea)";
                break;
        }
    }
    return hymio;
}
