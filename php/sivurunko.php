<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <title>Teh SyKe</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Da+2&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/styles_test.css">

</head>
<body onload="requestCurrentDay();">
    <?php
        include_once("../config/https.php");
        include_once("../config/config.php");
        include_once("functions.php");
        include_once("kalenteriToiminnot.php");

        // Estä uloskirjautumisen jälkeen tälle sivulle pääsy
        if(!isset($_SESSION['loggedIn'])){
            header("Location: ../teaser.php");
        }

        // Jos "Kirjaudu ulos" painettu
        if(isset($_GET['logOut'])){
            include("logOut.php");
        }

        // Jos käyttäjällä on jo Polar-ID tietokannassa
        if(isset($_SESSION['polarAccountTrue']) && isset($_SESSION['polarClicked']) && (!isset($_GET['deletePolar']))){
            $polar_ID = getPolarID($DBH, $_SESSION['user_ID']);
            $polar_token = getPolarToken($DBH, $_SESSION['user_ID']);
            $transactionID = getPolarActivityTransaction($polar_ID, $polar_token);
            $activityIDArray = getPolarActivityList($polar_ID, $polar_token, $transactionID);

            getPolarZoneData($polar_ID, $polar_token, $transactionID, $activityIDArray, $_SESSION['user_ID'], $DBH);
            commitPolarTransaction($polar_ID, $polar_token, $transactionID);
            unset($_SESSION['polarClicked']);
        }

        // Jos Polar rekisteröinti on onnistunut (server response 200 OK)
        if(isset($_SESSION['polarRegisterationTrue'])){
            if($_SESSION['polarRegisterationTrue']){
                //Rekisteröinti onnistui
                echo('<script>
                let snack = document.createElement("div");
                snack.setAttribute("class", "snackbar");
                let text = document.createTextNode("Rekisteröinti onnistui! Aloita keräämään unidataa");
                snack.classList.add("show");
                snack.appendChild(text);
                document.body.appendChild(snack);
                setTimeout(function(){ 
                    document.body.removeChild(snack); 
                }, 3000);
                </script>');
            } else{
                //Rekisteröinti epäonnistui
                echo('<script>
                let snack = document.createElement("div");
                snack.setAttribute("class", "snackbar");
                let text = document.createTextNode("Rekisteröinnissä tapahtui virhe, yritä uudelleen!");
                snack.classList.add("show");
                snack.appendChild(text);
                document.body.appendChild(snack);
                setTimeout(function(){ 
                    document.body.removeChild(snack); 
                }, 3000);
                </script>');
            }
            unset($_SESSION['polarRegisterationTrue']);
        }

        //Poistaa Polar linkityksen
        if(isset($_GET['deletePolar'])){
            $polar_ID = getPolarID($DBH, $_SESSION['user_ID']);
            $polar_token = getPolarToken($DBH, $_SESSION['user_ID']);

            $serverResponse = deletePolar($polar_ID, $polar_token, $DBH);
            
            if($polar_ID == null){
                // Jos linkitys on jo poistettu
                echo('<script>
                let snack = document.createElement("div");
                snack.setAttribute("class", "snackbar");
                let text = document.createTextNode("Polar-linkitys on jo poistettu!");
                snack.classList.add("show");
                snack.appendChild(text);
                document.body.appendChild(snack);
                setTimeout(function(){ 
                    document.body.removeChild(snack); 
                }, 3000);
                </script>');
            } else{
                if($serverResponse == "204"){
                    // Poisto onnistui
                    echo('<script>
                    let snack = document.createElement("div");
                    snack.setAttribute("class", "snackbar");
                    let text = document.createTextNode("Polar-linkitys poistettu!");
                    snack.classList.add("show");
                    snack.appendChild(text);
                    document.body.appendChild(snack);
                    setTimeout(function(){ 
                        document.body.removeChild(snack); 
                    }, 3000);
                    </script>');
                    unset($_SESSION['polarAccountTrue']);
                } else{
                    // Poisto epäonnistui
                    echo('<script>
                    let snack = document.createElement("div");
                    snack.setAttribute("class", "snackbar");
                    let text = document.createTextNode("Polar-linkityksen poistossa tapahtui virhe, yritä uudelleen!");
                    snack.classList.add("show");
                    snack.appendChild(text);
                    document.body.appendChild(snack);
                    setTimeout(function(){ 
                        document.body.removeChild(snack); 
                    }, 3000);
                    </script>');
                }
            }
        }
    ?>

    <nav id="ylaNav">
        <div id="sivunNimi">PÄIVÄNÄKYMÄ</div>
        <div id="hampurilaisMenu">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div id="hampurilaisValikko">
            <ul id="ylaValikko">
                <li onclick='window.location.href="raportit.php"'>Raportit (tulossa)</li>
                <li onclick='window.location.href="omattiedot.php"'>Omat tiedot</li>
                <li id="polarLinkitys">Synkronoi Polar</li>
                <li class="hidden polarLisaValikko">Synkronoi tiedot</li>
                <li id="polarPoistaLinkitys" class="hidden polarLisaValikko">Poista Polar synkronointi</li>
                <li onclick='window.location.href="apua.php"'>Apua</li>
                <li onclick='window.location.href="kayttoehdot.php"'>Käyttöehdot</li>
                <li onclick='window.location.href="deleteAccount.php"'>Poista tili </li>
                <li></li>
                <li onclick='window.location.href="sivurunko.php?logOut=true"'>Kirjaudu ulos </li>
            </ul>
        </div>
    </nav>

    <!--sisäkkäin, päällimmäinen hoitaa sivut, alempi taso pää/detail-->
    <div class="swiper-pageContainer">
        <div class="swiper-wrapper" id="sivuSwipeWrapper">

            <!--päiväsivu-->
            <div id="paivaSivu" class="swiper-slide">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div id="paivaPaasivu" class="swiper-slide paasivuPaivaWrapper">

                            <!--Ylälaidan päiväbanneri-->
                            <div id="paasivuPaivaNav">
                                <i id="prevDayNuoli" class='fas fa-chevron-left'></i>
                                <div class="paivaOtsikko"><?php getDayFormatted($_SESSION['currentDay']); ?></div>
                                <i id="nextDayNuoli" class='fas fa-chevron-right'></i>
                            </div>

                            <!-- Unenlaatu hymiö -->
                            <div class="dailySmiley">
                                <!-- Menee päiväkyselysivulle -->
                                <div class=speechBubble id="speechBubble">
                                    <div class="dailySpeechBubble dailySpeechBubbleLeft">Klikkaa hymiötä!</div>
                                </div>
                                <div class="dailyIcon">  
                                    <i id="dailyKysely" onclick="openKysely()" <?php 
                                    if($paivaOlio == null){
                                        echo('class="fas fa-meh-blank hymio" style="color: var(--liikennevaloHarmaa);"');
                                    } else{
                                        getHymio($paivaOlio);
                                    }
                                    ?>>
                                    <?php if($paivaOlio == null){
                                        echo('<script>document.querySelector(".speechBubble").style.visibility = "visible"</script>');
                                    }?>
                                    </i>
                                </div>
                            </div>

                            <!--inforuudut-->
                            <div class="box" onclick="changeSleepDetails('changeSleepTime')">
                                <div class="boxOtsikko1">UNIAIKA</div>
                                <div class="boxTeksti1"><?php echo(getUniAika($paivaOlio));?></div>
                                <div class="boxOtsikko2">UNISYKLIT</div>
                                <div class="boxTeksti2"><?php echo(getUniSykli($paivaOlio));?></div>
                            </div>
                            
                            <!--LISÄÄ AO. TIEDOT PÄIVÄOLIOON-->
                            <div></div>

                            <div class="box2" onclick="changeSleepDetails('changeWakeUpTime')">
                                <div class="boxOtsikko1">TÄNÄÄN NUKKUMAAN</div>
                                <div class="boxTeksti1">22.45</div>
                                <div class="boxOtsikko2">HERÄTYS HUOMENNA</div>
                                <div class="boxTeksti2">06.30</div>
                            </div>

                            <script>
                                function openKysely() {
                                    document.location = 'kysely.php';
                                }

                                function changeSleepDetails(i) {
                                    document.getElementById(i).style.visibility='visible';
                                }

                                function closeSleepDetails(i) {
                                    document.getElementById(i).style.visibility='hidden';
                                }
                            </script>

                            <!--progress/meter bar-->
                            <div class="clear">
                                <h3 id="progressBarOtsikko">UNEEN VAIKUTTAVAT TEKIJÄT</H3>
                                <?php
                                echo('<progress class="attributes_balance progressBarPaiva" value="' . getDayProgressValue($paivaOlio) . '" min="0" max="100"></progress>');
                                ?>
                            </div>

                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-down'></i>

                            <div class="alaNavRow"></div>
                        </div>

                        <div class="infoDaily" id="changeSleepTime" style="visibility: hidden;">
                            <div class="infoContent">
                                <i class="far fa-times-circle infoClose" onclick='closeSleepDetails("changeSleepTime")'></i>
                                <h3>Vaihda nukkumisaikaa</h3>
                                <script>
                                    function closeSleepDetails(i) {
                                        document.getElementById(i).style.visibility='hidden';
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="infoDaily" id="changeWakeUpTime" style="visibility: hidden;">
                            <div class="infoContent">
                                <i class="far fa-times-circle infoClose" onclick='closeSleepDetails("changeWakeUpTime")'></i>
                                <h3>Vaihda heräämisaika</h3>
                                <script>
                                    function closeSleepDetails(i) {
                                        document.getElementById(i).style.visibility='hidden';
                                    }
                                </script>
                            </div>
                        </div>

                        <div id="paivaDetailSivu" class="swiper-slide detailWrapper">
                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-up'></i>

                            <!--DetailsivuIconit-->
                            <div class="ikoniWrapper" style='color: <?php $value = $paivaOlio->user_food; getIconColorFood($value); ?>;' onclick="dayInfo('infoFood')">
                                <i class='fas fa-utensils ikoni'></i>
                                <i <?php getFoodIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color: <?php $value = $paivaOlio->user_alcohol; getIconColorAlcohol($value); ?>;' onclick="dayInfo('infoAlcohol')">
                                <i class='fas fa-glass-cheers ikoni'></i>
                                <i <?php getAlcoholIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color: <?php $value = $paivaOlio->user_activity; getIconColorActivity($value); ?>;' onclick="dayInfo('infoActivity')">
                                <i class='fas fa-walking ikoni'></i>
                                <i <?php getActivityIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color:<?php $value = $paivaOlio->user_smoke; getIconColorSmoke($value); ?>;' onclick="dayInfo('infoSmoke')">
                                <i class='fas fa-smoking ikoni'></i>
                                <i <?php getSmokeIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color: <?php $value = $paivaOlio->user_vitality; getIconColorVitality($value); ?>;' onclick="dayInfo('infoVitality')">
                                <i class='fas fa-bed ikoni'></i>
                                <i <?php getVitalityIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color:<?php $value = $paivaOlio->user_stimulant; getIconColorStimulant($value); ?>;' onclick="dayInfo('infoStimulant')">
                                <i class='fas fa-mug-hot ikoni'></i>
                                <i <?php getStimulantIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color:<?php $value = $paivaOlio->user_medicine; getIconColorMedicine($value); ?>;' onclick="dayInfo('infoMedicine')">
                                <i class='fas fa-pills ikoni'></i>
                                <i <?php getMedicineIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color:<?php $value = $paivaOlio->user_stress; getIconColorStress($value); ?>;' onclick="dayInfo('infoStress')">
                                <i class='fas fa-bolt ikoni'></i>
                                <i <?php getStressIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color:<?php $value = $paivaOlio->user_mood; getIconColorMood($value); ?>;' onclick="dayInfo('infoMood')">
                                <i class='fas fa-cloud-sun-rain ikoni'></i>
                                <i <?php getMoodIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color: <?php $value = $paivaOlio->sleep_amount; getIconColorSleepAmount($value); ?>;' onclick="dayInfo('infoSleepAmount')">
                                <i class='fas fa-clock ikoni'></i>
                                <i <?php getSleepAmountIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color:<?php $value = $paivaOlio->user_screen_time; getIconColorScreenTime($value); ?>;' onclick="dayInfo('infoScreenTime')">
                                <i class='fas fa-mobile-alt ikoni'></i>
                                <i <?php getScreenTimeIndikator($paivaOlio); ?>></i>
                            </div>

                            <div class="ikoniWrapper" style='color:<?php $value = $paivaOlio->user_pain; getIconColorPains($value); ?>;' onclick="dayInfo('infoPains')">
                                <i class='fas fa-band-aid ikoni'></i>
                                <i <?php getPainIndikator($paivaOlio); ?>></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--viikkosivu-->
            <div id="viikkoSivu" class="swiper-slide">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div id="viikkoPaasivu" class="swiper-slide paasivuViikkoWrapper">
                            
                            <!--Ylälaidan viikkobanneri-->
                            <div id="paasivuViikkoNav">
                                <i id="prevWeekNuoli" class='fas fa-chevron-left'></i>
                                <div id="viikkoOtsikko"><?php echo ("VIIKKO " . $_SESSION['currentWeek']); ?></div>
                                <i id="nextWeekNuoli" class='fas fa-chevron-right'></i>
                            </div>

                            <!-- Viikonpäivä listaus -->
                            <div>
                                <ul id="viikonpaivaLista">
                                    <?php include("viikkonakyma.php"); ?>
                                </ul>
                            </div>

                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-down'></i>

                        </div>
                        <div id="viikkoDetailSivu" class="swiper-slide detailWrapper">
                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-up'></i>

                            <!--DetailsivuIconit-->
                            <?php include("viikkoNakymaDetail.php"); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!--kuukausisivu-->
            <div id="kuukausiSivu" class="swiper-slide">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div id="kuukausiPaasivu" class="swiper-slide paasivuKuukausiWrapper">

                            <div class="calendar">
                                <div class="month">
                                    <i id="prevMonthNuoli" class='fas fa-chevron-left' onclick="moveDate('prev')"></i>

                                    <div>
                                        <h2 id="month"></h2>
                                        <p id="year"></p>
                                    </div>

                                    <i id="nextMonthNuoli" class='fas fa-chevron-right' onclick="moveDate('next')"></i>

                                </div>

                                <div class="weekdays">
                                    <div>MA</div>
                                    <div>TI</div>
                                    <div>KE</div>
                                    <div>TO</div>
                                    <div>PE</div>
                                    <div>LA</div>
                                    <div>SU</div> 
                                </div>

                                <div class="daysOfMonth">
                                </div>
                            </div>

                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-down'></i>
                            
                        </div>
                        
                        <div id="kuukausiDetailSivu" class="swiper-slide detailWrapper">
                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-up'></i>

                            <!--DetailsivuIconit-->
                            <?php include("kuukausiNakymaDetail.php"); ?>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            </div>
            <div id="alaNav" class="swiper-pagination">
        </div>
    </div>
    
    <script src="https://unpkg.com/swiper/js/swiper.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script src="../js/sivurunko.js"></script>
    
</body>
</html>