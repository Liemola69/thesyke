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
        if(isset($_SESSION['polarAccountTrue']) && (!isset($_SESSION['polarSync']))){
            $polar_ID = getPolarID($DBH, $_SESSION['user_ID']);
            $polar_token = getPolarToken($DBH, $_SESSION['user_ID']);

            $transactionID = getPolarActivityTransaction($polar_ID, $polar_token);
            //$transactionID = "230945953";
            echo('<script>console.log("Transaction ID: ' . $transactionID . '")</script>');
            $activityIDArray = getPolarActivityList($polar_ID, $polar_token, $transactionID);
            getPolarZoneData($polar_ID, $polar_token, $transactionID, $activityIDArray, $_SESSION['user_ID'], $DBH);
            commitPolarTransaction($polar_ID, $polar_token, $transactionID);
            $_SESSION['polarSync'] = true;
            echo('<script>console.log("Polar synkronoitu")</script>');
        }

        // Jos Polar rekisteröinti on onnistunut (server response 200 OK)
        if(isset($_SESSION['polarRegisterationTrue'])){
            if($_SESSION['polarRegisterationTrue']){
                echo('<script>console.log("Rekisteröinti onnistui")</script>');
            } else{
                echo('<script>console.log("Rekisteröinti epäonnistui")</script>');
            }
            unset($_SESSION['polarRegisterationTrue']);
        }

        //Poistaa Polar linkityksen
        if(isset($_GET['deletePolar'])){
            $polar_ID = getPolarID($DBH, $_SESSION['user_ID']);
            $polar_token = getPolarToken($DBH, $_SESSION['user_ID']);

            $serverResponse = deletePolar($polar_ID, $polar_token, $DBH);
            if($serverResponse == "204"){
                echo('<script>console.log("Poistettu")</script>');
            } else{
                echo('<script>console.log("Poisto epäonnistui: ' . $serverResponse . '")</script>');
            }
        }
    ?>




    <nav id="ylaNav">
        <div id="sivunNimi"><b>PÄIVÄNÄKYMÄ</b></div>
        <div id="hampurilaisMenu" class="fa fa-bars"></div>
        <div id="hampurilaisValikko">
            <ul id="ylaValikko">
                <li id="raportitValikkoLinkki">Raportit</li>
                <li id="omattiedotValikkoLinkki">Omat tiedot</li>
                <li id="polarLinkitys">Synkronoi Polar</li>
                <li class="hidden polarLisaValikko">Synkronoi tiedot</li>
                <li id="polarPoistaLinkitys" class="hidden polarLisaValikko">Poista Polar synkronointi</li>
                <li id="apuaValikkoLinkki">Apua</li>
                <li id="kayttoehdotValikkoLinkki">Käyttöehdot</li>
                <li></li>
                <li onclick='window.location.href="sivurunko.php?logOut=true"'>Kirjaudu ulos </li>
            </ul>
        </div>
    </nav>

    <!--<div class="raportitPage valikkoBackground">
                    <div class="raportitContent valikkoContent">
                    <?php
                    include("php/raportit.php");
                    ?>
                </div>

                <div class="omattiedotPage valikkoBackground">
                    <div class="omattiedotContent valikkoContent">
                    <?php
                    include("php/omattiedot.php");
                    ?>
                </div>

                <div class="apuaPage valikkoBackground">
                    <div class="apuaContent valikkoContent">
                    <?php
                    include("php/apua.php");
                    ?>
                </div>

                <div class="kayttoehdotPage valikkoBackground">
                    <div class="kayttoehdotContent valikkoContent">
                    <?php
                    include("php/kayttoehdot.php");
                    ?>
                </div>
    -->

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
                                <?php getDayFormatted($_SESSION['currentDay']); ?>
                                <i id="nextDayNuoli" class='fas fa-chevron-right'></i>
                                
                            </div>
                            

                            <!-- Unenlaatu hymiö -->
                            <div class="dailySmiley">
                            <!-- Menee päiväkyselysivulle -->
                            <a class="dailyButton fas fa-plus-circle" href="kysely.php"></a>  
                            <i <?php 
                                if($paivaOlio == null){
                                    echo('class="fas fa-meh-blank hymio" style="color: var(--liikennevaloHarmaa);"');
                                                                        
                                } else{
                                    getHymio($paivaOlio);
                                }
                            ?>></i>
                            <a class="dailyButton fas fa-info-circle"></a>
                            
                            </div>

                            <!--inforuudut-->
                            <div class="box">
                                <div>
                                    <p>UNIAIKA</p><p> <?php echo(getUniAika($paivaOlio)); ?> </p>
                                </div>
                                <div>
                                    <p>UNISYKLIT</p><p> <?php echo(getUniSykli($paivaOlio)); ?> </p>
                                </div>
                                 <!--LISÄÄ AO. TIEDOT PÄIVÄOLIOON-->
                            </div>
                            <div class="box">
                                <div>
                                    <p>TÄNÄÄN NUKKUMAAN</p><p>22.45</p>
                                </div>
                                <div>
                                    <p>HERÄTYS HUOMENNA</p><p>06.30</p>
                                </div>       
                            </div>


                            <!--progress/meter bar-->
                            <div class="clear">
                                <progress class="attributes_balance" value="65" min="0" max="100"></progress>
                            </div>
                           

                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-down'></i>

                            <div class="alaNavRow"></div>

                        </div>
                        <div id="paivaDetailSivu" class="swiper-slide detailWrapper">
                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-up'></i>

                            <!--DetailsivuIconit-->
                                <div class="ikoniWrapper">
                                    <i class='fas fa-utensils ikoni' style='color: <?php $value = $paivaOlio->user_food; getIconColorFood($value); ?>;'></i>
                                    <i <?php $value = $paivaOlio->indikator; getIndikator($value);?>></i>
                                </div>
                                
                                <div class="ikoniWrapper">
                                    <i class='fas fa-glass-cheers ikoni' style='color:<?php $value = $paivaOlio->user_alcohol; getIconColorAlcohol($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-walking ikoni' style='color: <?php $value = $paivaOlio->user_alcohol; getIconColorActivity($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-smoking ikoni' style='color:<?php $value = $paivaOlio->user_smoke; getIconColorSmoke($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-bed ikoni' style='color: <?php $value = $paivaOlio->user_vitality; getIconColorVitality($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-mug-hot ikoni' style='color:<?php $value = $paivaOlio->user_stimulant; getIconColorStimulant($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-pills ikoni' style='color:<?php $value = $paivaOlio->user_medicine; getIconColorMedicine($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-bolt ikoni' style='color:<?php $value = $paivaOlio->user_stress; getIconColorStress($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-cloud-sun-rain ikoni' style='color:<?php $value = $paivaOlio->user_mood; getIconColorMood($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-clock ikoni' style='color: <?php $value = $paivaOlio->user_alcohol; getIconColorSleepAmount($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-mobile-alt ikoni' style='color:<?php $value = $paivaOlio->user_screen_time; getIconColorScreenTime($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-band-aid ikoni' style='color:<?php $value = $paivaOlio->user_pain; getIconColorPains($value); ?>;'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
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
                                <?php echo ("Viikko " . $_SESSION['currentWeek']); ?>
                                <i id="nextWeekNuoli" class='fas fa-chevron-right'></i>
                            </div>

                            <!-- Viikonpäivä listaus -->
                            <div>
                                <ul id="viikonpaivaLista">
                                    
                                    <li class="viikkoNakymaTietue">
                                    
                                        <div><?php echo $_SESSION['days'][0]; ?></div>
                                        
                                        <?php $monday = getDateData($user_ID, $_SESSION['days'][0], $DBH);?>
                                        <i 
                                            <?php 
                                                if($monday == null){
                                                    echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);"');
                                                } else{
                                                    getHymioFromDate($monday);
                                                }
                                            ?>>
                                        </i>

                                    </li>

                                    <li class="viikkoNakymaTietue">
                                        
                                        <div><?php echo $_SESSION['days'][1]; ?></div>
                                        
                                        <?php $tuesday = getDateData($user_ID, $_SESSION['days'][1], $DBH);?>
                                        <i 
                                            <?php 
                                                if($tuesday == null){
                                                    echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);"');
                                                } else{
                                                    getHymioFromDate($tuesday);
                                                }
                                            ?>>
                                        </i>
                                        
                                    </li>

                                    <li class="viikkoNakymaTietue">
                                        
                                        <div><?php echo $_SESSION['days'][2]; ?></div>
                                            
                                        <?php $wednesday = getDateData($user_ID, $_SESSION['days'][2], $DBH);?>
                                        <i 
                                            <?php 
                                                if($wednesday == null){
                                                    echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);"');
                                                } else{
                                                    getHymioFromDate($wednesday);
                                                }
                                            ?>>
                                        </i>        
                                        
                                    </li>

                                    <li class="viikkoNakymaTietue">
                                        
                                        <div><?php echo $_SESSION['days'][3]; ?></div>
                                            
                                        <?php $thursday = getDateData($user_ID, $_SESSION['days'][3], $DBH);?>
                                        <i 
                                            <?php 
                                                if($thursday == null){
                                                    echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);"');
                                                } else{
                                                    getHymioFromDate($thursday);
                                                }
                                            ?>>
                                        </i>
                                            
                                    </li>

                                    <li class="viikkoNakymaTietue">
                                        
                                        <div><?php echo $_SESSION['days'][4]; ?></div>
                                            
                                        <?php $friday = getDateData($user_ID, $_SESSION['days'][4], $DBH);?>
                                        <i 
                                            <?php 
                                                if($friday == null){
                                                    echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);"');
                                                } else{
                                                    getHymioFromDate($friday);
                                                }
                                            ?>>
                                        </i>
                                            
                                    </li>

                                    <li class="viikkoNakymaTietue">
                                        
                                        <div><?php echo $_SESSION['days'][5]; ?></div>
                                            
                                        <?php $saturday = getDateData($user_ID, $_SESSION['days'][5], $DBH);?>
                                        <i 
                                            <?php 
                                                if($saturday == null){
                                                    echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);"');
                                                } else{
                                                    getHymioFromDate($saturday);
                                                }
                                            ?>>
                                        </i>
                                                                       
                                    </li>

                                    <li class="viikkoNakymaTietue">
                                        
                                        <div><?php echo $_SESSION['days'][6]; ?></div>
                                            
                                        <?php $sunday = getDateData($user_ID, $_SESSION['days'][6], $DBH);?>
                                        <i 
                                            <?php 
                                                if($sunday == null){
                                                    echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);"');
                                                } else{
                                                    getHymioFromDate($sunday);
                                                }
                                            ?>>
                                        </i>
            
                                    </li>
                                </ul>
                            </div>

                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-down'></i>

                        </div>
                        <div id="viikkoDetailSivu" class="swiper-slide detailWrapper">
                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-up'></i>

                            <!--DetailsivuIconit-->
                            
                                <div class="ikoniWrapper">
                                    <i class='fas fa-utensils ikoni' style='color: var(--liikennevaloVihrea);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>
                                
                                <div class="ikoniWrapper">
                                    <i class='fas fa-glass-cheers ikoni' style='color:var(--liikennevaloKeltainen);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-walking ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-smoking ikoni' style='color:var(--liikennevaloVihrea);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-bed ikoni' style='color:var(--liikennevaloHarmaa);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-mug-hot ikoni' style='color:var(--liikennevaloKeltainen);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-pills ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-bolt ikoni' style='color:var(--liikennevaloVihrea);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-cloud-sun-rain ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-clock ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class= 'fas fa-mobile-alt ikoni' style='color:var(--liikennevaloHarmaa);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>

                                <div class="ikoniWrapper">
                                    <i class='fas fa-band-aid ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                    <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                                </div>
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

                                    <div class="prev" onclick="moveDate('prev')">
                                        <span>&#10094;</span>
                                    </div>

                                    <div>
                                        <h2 id="month"></h2>
                                        <p id="year"></p>
                                    </div>

                                    <div class="next" onclick="moveDate('next')">
                                            <span>&#10095;</span>
                                    </div>

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
                            
                            <div class="ikoniWrapper">
                                <i class='fas fa-utensils ikoni' style='color: var(--liikennevaloVihrea);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>
                            
                            <div class="ikoniWrapper">
                                <i class='fas fa-glass-cheers ikoni' style='color:var(--liikennevaloKeltainen);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-walking ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-smoking ikoni' style='color:var(--liikennevaloVihrea);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-bed ikoni' style='color:var(--liikennevaloHarmaa);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-mug-hot ikoni' style='color:var(--liikennevaloKeltainen);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-pills ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-bolt ikoni' style='color:var(--liikennevaloVihrea);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-cloud-sun-rain ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-clock ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-mobile-alt ikoni' style='color:var(--liikennevaloHarmaa);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>

                            <div class="ikoniWrapper">
                                <i class='fas fa-band-aid ikoni' style='color:var(--liikennevaloPunainen);'></i>
                                <i class='fas fa-exclamation-circle ikoniHuutomerkki'></i>
                            </div>
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