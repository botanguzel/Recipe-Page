function changePass() {
    var formData = new FormData(document.getElementById('updateForm'));
    fetch('../php/fetch.php?type=update', {
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
async function loadPage() {
    try {
        fetch('../php/fetch.php?type=user', {

        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.getElementById('user').innerHTML = data[0].username;
            document.getElementById('username').value = data[0].username;
            document.getElementById('email').value = data[0].email;
        })
        .catch(error => {
            showNotificationButton(error);
        });

  
    } catch (error) {
        showNotificationButton('Error adding entries:', error);
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    (async function() {
      await loadPage();
    })();
  });