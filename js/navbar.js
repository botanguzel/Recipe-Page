var modal = document.getElementById('login');

document.addEventListener('DOMContentLoaded', function() {
    var button = document.getElementById('loginBtn');
    if (button !== null) {
        button.addEventListener('click', function() {
            if (modal.style.display === 'none') {modal.style.display = "block"}
            else {modal.style.display = "none"}
        });
    }
});


let l = document.getElementById("lgn");
let s = document.getElementById("sgn");
let lB = document.getElementById("login-btn");
let sB = document.getElementById("signup-btn");
// JavaScript functions to toggle between login and sign up forms
function showLoginForm() {
    l.style.display = "block";
    lB.style.outline = "1px solid #00FF7F";
    sB.style.outline = "0";
    s.style.display = "none";
}

function showSignupForm() {
    l.style.display = "none";
    sB.style.outline = "1px solid #00FF7F";
    lB.style.outline = "0";
    s.style.display = "block";
}



window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

function submitLogForm() {
    var formData = new FormData(document.getElementById('logForm'));
    fetch('../php/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'Success') {
            location.reload();
        } else { showNotificationButton(data); } 
    })
    .catch(error => {
        showNotificationButton(error);
    });
}

function submitRegForm() {
    var formData = new FormData(document.getElementById('regForm'));
    fetch('../php/register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        showNotificationButton(data);
    })
    .catch(error => {
        showNotificationButton(error);
    });
}
var t = null;

function showNotificationButton(notif) {
    if (t !== null) { clearTimeout(t); }
    var notificationButton = document.getElementById("notification");
    notificationButton.style.display = "block";
    notificationButton.innerHTML = '<i class="bi bi-bell-fill"></i>  ' + notif;
    t = setTimeout(function() {
        notificationButton.style.display = "none";
    }, 10000);
}