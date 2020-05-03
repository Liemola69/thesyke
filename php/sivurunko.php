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
                <li onclick='window.location.href="deleteAccount.php"'>Poista tili </li>
                
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
                                    ?>>
                                </i>
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
                                <h3>UNEEN VAIKUTTAVAT TEKIJÄT</H3>
                                <progress class="attributes_balance progressBarPaiva" value="' . getDayProgressValue($day) . '" min="0" max="100"></progress>
                            </div>
                           
                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-down'></i>

                            <div class="alaNavRow"></div>

                        </div>
                        <div id="paivaDetailSivu" class="swiper-slide detailWrapper">
                            <!--sivuvaihtoNuoli-->
                            <i class='fas fa-chevron-up'></i>

                            <!--DetailsivuIconit-->
                                <div class="ikoniWrapper" onclick="dayInfo('infoFood')">
                                    <div style='color: <?php $value = $paivaOlio->user_food; getIconColorFood($value); ?>;'>
                                    <i class='fas fa-utensils ikoni'></i>
                                    <i <?php getFoodIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>
                                
                                <div class="ikoniWrapper" onclick="dayInfo('infoAlcohol')">
                                    <div style='color: <?php $value = $paivaOlio->user_alcohol; getIconColorAlcohol($value); ?>;'>
                                    <i class='fas fa-glass-cheers ikoni'></i>
                                    <i <?php getAlcoholIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoActivity')">
                                    <div style='color: <?php $value = $paivaOlio->user_activity; getIconColorActivity($value); ?>;'>
                                    <i class='fas fa-walking ikoni'></i>
                                    <i <?php getActivityIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoSmoke')">
                                    <div style='color:<?php $value = $paivaOlio->user_smoke; getIconColorSmoke($value); ?>;'>
                                    <i class='fas fa-smoking ikoni'></i>
                                    <i <?php getSmokeIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoVitality')">
                                    <div style='color: <?php $value = $paivaOlio->user_vitality; getIconColorVitality($value); ?>;'>
                                    <i class='fas fa-bed ikoni'></i>
                                    <i <?php getVitalityIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoStimulant')">
                                    <div style='color:<?php $value = $paivaOlio->user_stimulant; getIconColorStimulant($value); ?>;'>
                                    <i class='fas fa-mug-hot ikoni'></i>
                                    <i <?php getStimulantIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoMedicine')">
                                    <div style='color:<?php $value = $paivaOlio->user_medicine; getIconColorMedicine($value); ?>;'>
                                    <i class='fas fa-pills ikoni'></i>
                                    <i <?php getMedicineIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoStress')">
                                    <div style='color:<?php $value = $paivaOlio->user_stress; getIconColorStress($value); ?>;'>
                                    <i class='fas fa-bolt ikoni'></i>
                                    <i <?php getStressIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoMood')">
                                <div style='color:<?php $value = $paivaOlio->user_mood; getIconColorMood($value); ?>;'>
                                    <i class='fas fa-cloud-sun-rain ikoni'></i>
                                    <i <?php getMoodIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoSleepAmount')">
                                <div style='color: <?php $value = $paivaOlio->sleep_amount; getIconColorSleepAmount($value); ?>;'>
                                    <i class='fas fa-clock ikoni'></i>
                                    <i <?php getSleepAmountIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoScreenTime')">
                                    <div style='color:<?php $value = $paivaOlio->user_screen_time; getIconColorScreenTime($value); ?>;'>
                                    <i class='fas fa-mobile-alt ikoni'></i>
                                    <i <?php getScreenTimeIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <div class="ikoniWrapper" onclick="dayInfo('infoPains')">
                                <div style='color:<?php $value = $paivaOlio->user_pain; getIconColorPains($value); ?>;'>
                                    <i class='fas fa-band-aid ikoni'></i>
                                    <i <?php getPainIndikator($paivaOlio); ?>></i>
                                    </div>
                                </div>

                                <script>
                                function dayInfo(i) {
                                document.getElementById(i).style.visibility='visible';
                                }

                                function closeDayInfo(i) {
                                document.getElementById(i).style.visibility='hidden';
                                }
                                </script>

                                <div class=infoDaily id="infoFood" style="visibility: hidden">
                                    <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoFood')"></i>
                                        <h3>Ravinto</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                
                                <div class=infoDaily id="infoAlcohol" style="visibility: hidden">
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoAlcohol')"></i>
                                        <h3>Alkoholi</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>​​​​​​​​​​​​​​​​​​​​​​​​​​​

                                <div class=infoDaily id="infoActivity" style="visibility: hidden">
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoActivity')"></i>
                                        <h3>Liikunta</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class=infoDaily id="infoSmoke" style="visibility: hidden">​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoSmoke')"></i>
                                        <h3>Tupakointi</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class=infoDaily id="infoVitality" style="visibility: hidden">
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoVitality')"></i>
                                        <h3>Vireystila</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class=infoDaily id="infoStimulant" style="visibility: hidden">
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoStimulant')"></i>
                                        <h3>Kofeiini</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class=infoDaily id="infoMedicine" style="visibility: hidden">​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoMedicine')"></i>
                                        <h3>Lääkkeet</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class=infoDaily id="infoStress" style="visibility: hidden">
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoStress')"></i>
                                        <h3>Stressi</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class=infoDaily id="infoMood" style="visibility: hidden">
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoMood')"></i>
                                        <h3>Mieliala</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class=infoDaily id="infoSleepAmount" style="visibility: hidden">​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoSleepAmount')"></i>
                                        <h3>Unen määrä</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class=infoDaily id="infoScreenTime" style="visibility: hidden">
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoScreenTime')"></i>
                                        <h3>Ruutuaika</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
                                <div class=infoDaily id="infoPains" style="visibility: hidden">
                                <div class="infoContent">
                                        <i class="far fa-times-circle infoClose" onclick="closeDayInfo('infoPains')"></i>
                                        <h3>Kivut</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                                    </div>
                                </div>
                                ​​​​​​​​​​​​​​​​​​​​​​​​​​​
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