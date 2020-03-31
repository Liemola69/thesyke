<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <title>Teh SyKe</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Da+2&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/styles_test.css">
</head>
<body>
    <?php
        include_once("../config/https.php");
        include_once("../config/config.php");

        // Estä uloskirjautumisen jälkeen tälle sivulle pääsy
        if(!isset($_SESSION['loggedIn'])){
            header("Location: ../teaser.php");
        }

        if(isset($_GET['logOut'])){
            include("logOut.php");
        }
    ?>

    <nav id="ylaNav">
        <div id="sivunNimi">PÄIVÄNÄKYMÄ</div>
        <div id="hampurilaisMenu" class="fa fa-bars"></div>
        <div id="hampurilaisValikko">
            <ul id="ylaValikko">
                <li id="raportitValikkoLinkki">Raportit</li>
                <li>Omat tiedot</li>
                <li>Polar-linkitys</li>
                <li>Apua</li>
                <li>Käyttöehdot</li>
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
                        <div id="paivaPaasivu" class="swiper-slide paasivuWrapper">
                            <i class='fas fa-meh-blank hymio' style='color:var(--liikennevaloHarmaa);'></i>

                            <!--inforuudut-->
                            <div class="box">
                                <div>
                                    <p>UNIAIKA</p><p>8 h 39 min</p>
                                </div>
                                <div>
                                    <p>UNISYKLIT</p><p>6 sykliä</p>
                                </div>       
                            </div>

                            <!--nuolet-->
                            <div class="clear">
                                <i class='fas fa-arrow-alt-circle-down'><p>3</p></i>
                                <i class='fas fa-arrow-alt-circle-up'><p>5</p></i>
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
                                    <i class='fas fa-syringe ikoni' style='color:var(--liikennevaloHarmaa);'></i>
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

            <!--viikkosivu-->
            <div id="viikkoSivu" class="swiper-slide">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div id="viikkoPaasivu" class="swiper-slide paasivuWrapper">
                            <i class='fas fa-meh hymio' style='color:var(--liikennevaloKeltainen);'></i>

                            <!--inforuudut-->
                            <div class="box">
                                <div>
                                    <p>UNIAIKA</p><p>8 h 39 min</p>
                                </div>
                                <div>
                                    <p>UNISYKLIT</p><p>6 sykliä</p>
                                </div>       
                            </div>

                            <!--nuolet-->
                            <div class="clear">
                                <i class='fas fa-arrow-alt-circle-down'><p>3</p></i>
                                <i class='fas fa-arrow-alt-circle-up'><p>5</p></i>
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
                                <i class='fas fa-syringe ikoni' style='color:var(--liikennevaloHarmaa);'></i>
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
                        <div id="kuukausiPaasivu" class="swiper-slide paasivuWrapper">
                            <i class='fas fa-laugh hymio' style='color:var(--liikennevaloVihrea);'></i>

                            <!--inforuudut-->
                            <div class="box">
                                <div>
                                    <p>UNIAIKA</p><p>8 h 39 min</p>
                                </div>
                                <div>
                                    <p>UNISYKLIT</p><p>6 sykliä</p>
                                </div>       
                            </div>

                            <!--nuolet-->
                            <div class="clear">
                                <i class='fas fa-arrow-alt-circle-down'><p>3</p></i>
                                <i class='fas fa-arrow-alt-circle-up'><p>5</p></i>
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
                                <i class='fas fa-syringe ikoni' style='color:var(--liikennevaloHarmaa);'></i>
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