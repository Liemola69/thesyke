<?php
    $iconName = [
        "fa-utensils", 
        "fa-glass-cheers", 
        "fa-walking", 
        "fa-smoking", 
        "fa-bed", 
        "fa-mug-hot", 
        "fa-pills", 
        "fa-bolt", 
        "fa-cloud-sun-rain", 
        "fa-clock", 
        "fa-mobile-alt", 
        "fa-band-aid"
    ];

    $infoName = [
        "infoFood",
        "infoAlcohol",
        "infoActivity",
        "infoSmoke",
        "infoVitality",
        "infoStimulant",
        "infoMedicine",
        "infoStress",
        "infoMood",
        "infoSleepAmount",
        "infoScreenTime",
        "infoPains"
    ];
    
    // Tulosta ikonit ja indikaattorit väreillä
    for($i = 0; $i < 12; $i++){
        echo('<div id = "' . $infoName[$i] . '" class="ikoniWrapper">');
            echo('<i class="fas ' . $iconName[$i] . ' ikoni"></i>');
        echo('</div>');
    }
?>