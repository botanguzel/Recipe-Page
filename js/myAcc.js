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

function creator(name, id) {
    const form = document.createElement('div');
    const inp = document.createElement('input');
    form.classList.add('form-inp');
    inp.value = name;
    form.appendChild(inp);

    form.addEventListener('click', () => {
        localStorage.setItem('curr_rec_i', id);
        window.location.href = "../recipe-detail.php";
      });

    return form;
}

async function loadPage() {
    const saved = await fetch('../php/fetch.php?type=getSaved', {});
    const data = await saved.json();
    data.forEach(element => {
        const a = creator(element.recipe_name, element.id);
        $('.galleryRow').append(a);
    });
}

async function loadUser() {
    try {
        fetch('../php/fetch.php?type=user', {

        })
        .then(response => response.json())
        .then(data => {
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
      await loadUser();
      await loadPage();
    })();
  });