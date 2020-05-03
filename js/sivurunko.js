let hampurilaisMenu = document.getElementById("hampurilaisMenu");
let hampurilaisValikko = document.getElementById("hampurilaisValikko");
let ylaValikko = document.querySelectorAll("ul")[0];
let ylaNav = document.getElementById("ylaNav");
let alaNav = document.getElementById("alaNav");
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
let viikonpaivaListaItem = document.querySelectorAll(".viikkoNakymaTietue");

// Kuukausinäkymän muuttujat
let paasivuKuukausiWrapper = document.querySelector(".paasivuKuukausiWrapper");

// Polar valikon muuttujat
let paivita = document.querySelectorAll(".hidden")[0];
let poista = document.querySelectorAll(".hidden")[1];
let polarLinkitys = document.getElementById("polarLinkitys");

let kalenteriKkPaivat;
let kalenteriPaivat;
let currentDay;

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
paasivuPaivaWrapper.style.gridTemplateRows = "10% auto 10% 10% auto 10% " + alaNav.clientHeight + "px";
paasivuViikkoWrapper.style.gridTemplateRows = "10% auto 10% " + alaNav.clientHeight + "px";
paasivuKuukausiWrapper.style.gridTemplateRows = "auto 10%" + alaNav.clientHeight + "px";

// Aseta detailsivun viimeinen grid alaNavin kokoiseksi
for(let i = 0; i < 3; i++){
    detailWrapper[i].style.gridTemplateRows = "10% auto auto auto auto 5% " + alaNav.clientHeight + "px";
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
        detailWrapper[i].style.gridTemplateRows = "10% auto auto auto auto 5% " + alaNav.clientHeight + "px";
    }
}

// Kuukausinäkymän js
let dt;
let highlightDate;
checkCurrentDay();

// Rakentaa kalenterin
function renderDate(currentDay) {
    dt = new Date(currentDay.split("-")[0], (currentDay.split("-")[1] - 1));
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

    kalenteriKkPaivat = document.querySelector(".daysOfMonth");
    kalenteriPaivat = kalenteriKkPaivat.childNodes;

    // Varmista, ettei highlight jää vanhalle päivälle päälle
    for(let i = 0; i < kalenteriPaivat.length; i++){
        if(kalenteriPaivat[i].classList.contains('highlight')){
            kalenteriPaivat[i].classList.toggle('highlight');
        }
    }
    
    for(let i = 0; i < kalenteriPaivat.length; i++){

        // Lisää kalenteriin highlight sovelluksen currentDayn kohdalle
        if((dt.getFullYear() + "-" + formatMonth(dt.getMonth(), kalenteriPaivat[i].classList) + "-" + formatDay(kalenteriPaivat[i].innerText, kalenteriPaivat[i].classList)) == highlightDate){
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

// Palauta kuukausi muodossa mm
function formatMonth2(currentMonth){
    if(currentMonth < 10){
        return "0"+currentMonth;
    } else{
        return currentMonth;
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

// Kuukausinäkymän kuukauden vaihto nuolet
function moveDate(para) {
    let month;
    let tempMonth;

    if(para == "prev") {
        dt.setMonth(dt.getMonth() - 1);

        if(dt.getMonth() < 10){
            month = "0" + (dt.getMonth()+1);
        } else{
            month = (dt.getMonth()+1);
        }
 
        tempMonth = dt.getFullYear() + "-" + month + "-" + "01";
        requestTempMonth(tempMonth);

    } else if(para == 'next') {
        dt.setMonth(dt.getMonth() + 1);
        if(dt.getMonth() < 10){
            month = "0" + (dt.getMonth()+1);
        } else{
            month = (dt.getMonth()+1);
        }

        tempMonth = dt.getFullYear() + "-" + month + "-" + "01";
        requestTempMonth(tempMonth);
    }
}

function requestTempMonth(tempMonth){
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let month = this.responseText;
            getTempMonth(tempMonth, month);
        }
    };
    xhttp.open("GET", "tempMonthAJAX.php?tempMonth=" + tempMonth, true);
    xhttp.send();
}

function getTempMonth(tempDate, ajaxResponse){
    renderDate(tempDate);
    printMonthHymio(ajaxResponse);
    requestIconMonth(tempDate);
}

// Käy kysymässä palvelimelta, mikä on sessiomuuttujissa nykyinen päivä
function requestCurrentDay(){
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            getCurrentDay(this.responseText);
        }
    };
    xhttp.open("GET", "currentDayAJAX.php", true);
    xhttp.send();
}

// Kun palvelimelta saatu nykyinen päivä, renderöi kuukausinäkymä ja lataa hymiöt
function getCurrentDay(ajaxResponse){
    highlightDate = ajaxResponse;
    renderDate(ajaxResponse);
    requestHymio();
    requestIconMonth(ajaxResponse.slice(0, -2) + "01"); // funktio ottaa vastaan kk ensimmäisen päivän pvm
}

// Kysyy palvelimelta hymiöiden arvot tietokannasta
function requestHymio(){
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            printMonthHymio(this.responseText); // Hymiöiden lukuarvo tietokannasta
        }
    };
    xhttp.open("GET", "currentMonthAJAX.php", true);
    xhttp.send();
}

// Ottaa vastaan kuukauden hymiöt JSONina ja asettaa ne kalenterinäkymään
function printMonthHymio(hymio){

    let hymiot = JSON.parse(hymio);
    let offset;
    let loops = 0;
    
    // Tarkista kuukausinäkymän offsetin mukaan, kuinka monta kertaa hymiöiden tulostus loopataan
    if(dt.getDay() == 0){
        loops = kalenteriPaivat.length - dt.getDay();
    } else{
        loops = kalenteriPaivat.length - dt.getDay() + 1;
    }
   
    // Loopataan hymiöiden tulostus kalenteriin
    for(let i = 0; i < loops; i++){

        let hymioDiv = document.createElement("div");
        let naamari = luoHymio(hymiot[i]);

        if(dt.getDay() == 0){
            offset = i;
        } else{
            offset = dt.getDay() - 1 + i;
        }

        hymioDiv.appendChild(naamari);
        kalenteriPaivat[offset].appendChild(hymioDiv);
    }

}

// Palauttaa oikeanlaisen ja värisen hymiön tietokannan datan mukaisesti
// Parametrina tietokannasta haettu numeroarvo
function luoHymio(i){
    let hymio = document.createElement("i");
    if(i == null || i == 0){
        hymio.classList.add('fas');
        hymio.classList.add('fa-meh-blank');
        hymio.classList.add('hymio-kuukausi');
        hymio.style.color = "var(--liikennevaloHarmaa)";
    } else{

        if(i > 2){
            hymio.classList.add('fas');
            hymio.classList.add('fa-laugh');
            hymio.classList.add('hymio-kuukausi');
            hymio.style.color = "var(--liikennevaloVihrea)";
        } else if(i <= 2 && i >= -2){
            hymio.classList.add('fas');
            hymio.classList.add('fa-meh');
            hymio.classList.add('hymio-kuukausi');
            hymio.style.color = "var(--liikennevaloKeltainen)";
        } else if(i < -2){
            hymio.classList.add('fas');
            hymio.classList.add('fa-frown');
            hymio.classList.add('hymio-kuukausi');
            hymio.style.color = "var(--liikennevaloPunainen)";
        }
    }
    return hymio;
}


//kyselyn ohje-popupit
// When the user clicks on div, open the popup
function myKofeinFunction() {
    var kofeiinipopup = document.getElementById("myKofeiiniPopup");
    kofeiinipopup.classList.toggle("show");
  }
  
  function myAlcoholFunction() {
    var alkoholipopup = document.getElementById("myAlkoholiPopup");
    alkoholipopup.classList.toggle("show");
  }
  function myScreenTimeFunction() {
    var screenTimepopup = document.getElementById("myScreenTimePopup");
    screenTimepopup.classList.toggle("show");
  }
  function myInfoFunction() {
    var infopopup = document.getElementById("myInfoPopup");
    infopopup.classList.toggle("show");
  }
  function myDeleteAccountFunction(){
    var deletePopup = document.getElementById("myDeleteAccount");
    deletePopup.classList.toggle("show"); 
  }
  function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
  }


// Tarkistaa, mikä on sovelluksen päivä
function checkCurrentDay(){
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            returnCurrentDay(this.responseText);
        }
    };
    xhttp.open("GET", "currentDayAJAX.php", true);
    xhttp.send();
}

// Tallentaa currentDay-muuttujaan sovelluksen päivän
function returnCurrentDay(paiva){
    currentDay = paiva;
}

// Kun kuukausi vaihtuu -> suorita php joka hakee kuukauden päivät olioina
// Summaa ikonien tiedot
function requestIconMonth(month){
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            updateIconColor(this.responseText);
        }
    };
    xhttp.open("GET", "requestIconMonthAJAX.php?iconMonth=" + month, true);
    xhttp.send();
}

// Haetaan kaikki ikonit kuukausinäkymästä, [0] on nuoli ylöspäin
let iconsMonth = document.getElementById('kuukausiDetailSivu').children;

/**
 * Vaihtaa ikoneiden värit kuukausinäkymässä
 * @param {JSON} values ikoneiden lukuarvo tietokannasta JSONina
 */
function updateIconColor(values){
    let iconColor = JSON.parse(values);
    //console.log(iconColor);
    let indikaattori;
    deleteIndicators();

    for(let i = 0; i < 12; i++){
        if(i == 3){ // Tupakka

            if(iconColor[i] == 0){
                iconsMonth[i+1].style.color = "var(--liikennevaloHarmaa)";
                indikaattori = getIndicator(iconColor[i]);
            }else if(iconColor[i] == 1){
                iconsMonth[i+1].style.color = "var(--liikennevaloPunainen)";
                indikaattori = getIndicator(iconColor[i]);
            }else if(iconColor[i] == 2){
                iconsMonth[i+1].style.color = "var(--liikennevaloVihrea)";
                indikaattori = getIndicator(iconColor[i]);
            }

        } else if(i == 6){ // Lääkkeet

            if(iconColor[i] == 1){
                iconsMonth[i+1].style.color = "var(--liikennevaloVihrea)";
                indikaattori = getIndicator(iconColor[i]);
            } else if(iconColor[i] == 0){
                iconsMonth[i+1].style.color = "var(--liikennevaloHarmaa)";
                indikaattori = getIndicator(iconColor[i]);
            }

        } else{ // Muille

            if(iconColor[i] == 0){
                iconsMonth[i+1].style.color = "var(--liikennevaloHarmaa)";
                indikaattori = getIndicator(iconColor[i]);
            }else if(iconColor[i] > 0){
                iconsMonth[i+1].style.color = "var(--liikennevaloVihrea)";
                indikaattori = getIndicator(iconColor[i]);
            }else if(iconColor[i] < 0){
                iconsMonth[i+1].style.color = "var(--liikennevaloPunainen)";
                indikaattori = getIndicator(iconColor[i]);
            }
        }

        iconsMonth[i+1].appendChild(indikaattori);
    }
}

/**
 * Luo ja palauttaa indikaattori-elementin iconColor lukuarvon mukaisesti
 * @param {int} iconColor 
 */
function getIndicator(iconColor){
    let indikaattori = document.createElement("i");
    indikaattori.classList.add('fas');

    if(iconColor > 3){
        indikaattori.classList.add('fa-laugh');
        indikaattori.classList.add('hymio-indikaattori');
    } else if(iconColor > 0){
        indikaattori.classList.add('fa-smile');
        indikaattori.classList.add('hymio-indikaattori');
    } else if(iconColor == 0){
        indikaattori.classList.add('fa-meh-blank');
        indikaattori.classList.add('hymio-indikaattori');
    } else if(iconColor < 0 && iconColor > -4){
        indikaattori.classList.add('fa-frown');
        indikaattori.classList.add('hymio-indikaattori');
    } else if(iconColor < -3){
        indikaattori.classList.add('fa-sad-tear');
        indikaattori.classList.add('hymio-indikaattori');
    }

    return indikaattori;
}

/**
 * Poistaa indikaattorit
 */
function deleteIndicators(){

    for(let i = 1; i < 13; i++){
        let indicator = iconsMonth[i].children[1];

        if(indicator != null){
            iconsMonth[i].removeChild(indicator);
        }
    }
}
//detail-sivujen pop-up aukeaa
function dayInfo(i) {
    document.getElementById(i).style.visibility='visible';
    }
//detail-sivujen pop-up sulkeutuu
    function closeDayInfo(i) {
    document.getElementById(i).style.visibility='hidden';
    }