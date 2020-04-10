document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", false);
document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);

document.getElementById("loginButton").addEventListener("click", function(){
    document.querySelector(".loginPopup").style.visibility = "visible";
    document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", true);
    
})

document.getElementById("loginClose").addEventListener("click", function(){
    document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", false);
    document.querySelector(".loginPopup").style.visibility = "hidden";
    document.location = 'php/resetVariables.php';

})

document.getElementById("registerButton").addEventListener("click", function(){
    document.querySelector(".registerPopup").style.visibility = "visible";
    document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", true);
})

document.getElementById("registerClose").addEventListener("click", function(){
    document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
    document.querySelector(".registerPopup").style.visibility = "hidden";
    document.location = 'php/resetVariables.php';

})