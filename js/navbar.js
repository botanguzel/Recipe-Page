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
let rPwd = document.getElementById("frgtPwd");

let lB = document.getElementById("login-btn");
let sB = document.getElementById("signup-btn");
// JavaScript functions to toggle between login and sign up forms
function showLoginForm() {
    l.style.display = "block";
    lB.style.outline = "1px solid #00FF7F";
    sB.style.outline = "0";
    s.style.display = "none";
    rPwd.style.display = "none";
}

function showSignupForm() {
    l.style.display = "none";
    sB.style.outline = "1px solid #00FF7F";
    lB.style.outline = "0";
    s.style.display = "block";
    rPwd.style.display = "none";
}

function showResetForm() {
    l.style.display = "none";
    s.style.display = "none";
    sB.style.outline = "0";
    lB.style.outline = "0";
    rPwd.style.display = "block";
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

function sendVerification() {
    var email = document.getElementById("resetMail").value;

    // Send email using fetch API
    fetch('/send-email', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ email })
    })
    .then(response => {
      if (response.ok) {
        showNotificationButton('Email sent successfully!');
      } else {
        throw new Error('Failed to send email.');
      }
    })
    .catch(error => {
      showNotificationButton('An error occurred while sending the email.');
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

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
document.getElementById("pwdCon").addEventListener("keyup", function() {
    var password = document.getElementById("pwd").value;
    var confirmPassword = document.getElementById("pwdCon").value;
    var pwdConError = document.getElementById("pwdConError");
    var pwdConCheck = document.getElementById("pwdConPass");
    if (password !== confirmPassword) {
        pwdConError.style.display = "block";
        pwdConCheck.style.display = "none";
    } else {
        pwdConError.style.display = "none";
        pwdConCheck.style.display = "block";
    }
});
document.getElementById("pwd").addEventListener("keyup", function(event) {
    var password = document.getElementById("pwd").value;
    var pwdError = document.getElementById("pwdError");
    var pwdCheck = document.getElementById("pwdPass");
    var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
    if (!passwordRegex.test(password)) {
        pwdError.style.display = "block";
        pwdCheck.style.display = "none";
        event.preventDefault();
    } else {
        pwdError.style.display = "none";
        pwdCheck.style.display = "block";
    }
});

document.getElementById("mail").addEventListener("keyup", function(event) {
    var mail = document.getElementById("mail").value;
    var mailError = document.getElementById("mailError");
    var mailCheck = document.getElementById("mailPass");
    var mailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if (!mailRegex.test(mail)) {
        mailError.style.display = "block";
        mailCheck.style.display = "none";
        event.preventDefault();
    } else {
        mailError.style.display = "none";
        mailCheck.style.display = "block";
    }
});


window.addEventListener('scroll', function() {
    var navbar = document.querySelector('.navbar');
    var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollPosition > 50) { // Adjust the scroll position as needed
        navbar.classList.add('fixed-top');
    } else {
        navbar.classList.remove('fixed-top');
    }
});