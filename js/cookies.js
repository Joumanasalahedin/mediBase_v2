// Cookie Consent Popup
document.addEventListener("DOMContentLoaded", function () {
  var consentPopup = document.getElementById("cookieConsentPopup");
  var acceptBtn = document.getElementById("acceptCookies");
  var declineBtn = document.getElementById("declineCookies");

  var userConsent = getCookie("userConsent");
  if (!userConsent) {
    consentPopup.style.display = "block";
  }

  acceptBtn.onclick = function () {
    setCookie("userConsent", "accepted", 30); // Set cookie for 30 days
    consentPopup.style.display = "none";
  };

  declineBtn.onclick = function () {
    setCookie("userConsent", "declined", 30); // Set cookie for 30 days
    consentPopup.style.display = "none";
  };
});

function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1, c.length);
    }
    if (c.indexOf(nameEQ) == 0) {
      return c.substring(nameEQ.length, c.length);
    }
  }
  return null;
}
