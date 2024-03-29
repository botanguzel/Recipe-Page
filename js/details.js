function createRating(cRank) {
  // Create a div element with class 'rating'
  var ratingDiv = document.createElement('div');
  ratingDiv.className = 'rating';

  // Loop to create radio inputs and labels
  for (var i = 5; i >= 1; i--) {
    // Create radio input
    var radioInput = document.createElement('input');
    radioInput.value = i;
    radioInput.name = 'rating'
    radioInput.id = 'star' + i;
    radioInput.type = 'radio';

    // If current rank is greater than or equal to i, check the radio input
    if (cRank <= i) {
      radioInput.checked = true;
    }

    // Create label
    var label = document.createElement('label');
    label.htmlFor = 'star' + i;

    // Append radio input and label to the rating div
    ratingDiv.appendChild(radioInput);
    ratingDiv.appendChild(label);
    radioInput.addEventListener('click', function() {
      var formData = new FormData();
      var rec_id = localStorage.getItem('curr_rec_i');
      formData.append('id', rec_id);
      formData.append('newRank', this.value);
      fetch('../php/fetch.php?type=updateRank', {
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
      console.log(this.value); // Log the value of the clicked star
    });
  }

  // Get the div with id 'top' and append the rating div to it
  return ratingDiv;
}

function createCard(name, description, ingredients, n_ingredients, steps, n_steps, cRank, url, minutes, nutrition, comments) {
  // Create main card container
  let cardContainer = document.createElement('div');
  let cardHeader = document.createElement('div');
  let row = document.createElement('div');
  let colImage = document.createElement('div');
  let colDesc = document.createElement('div');
  let rowCom = document.createElement('div');
  let rowDesc = document.createElement('div');
  let rowDescHeader = document.createElement('h1');
  let cardTitle = document.createElement('h5');
  let cardBody = document.createElement('div');
  let cardRating = document.createElement('div');
  let cardImage = document.createElement('img');
  let cardFooter = document.createElement('div');
  let ingList = document.createElement('ul');
  let stepList = document.createElement('ul');
  let cardText = document.createElement('h5');
  let footerText = document.createElement('p');
  let hideButton = document.createElement('button');
  let formFloatingDiv = document.createElement('form');
  let textarea = document.createElement('input');
  let label = document.createElement('label');
  let commentButton = document.createElement('button');


  cardContainer.classList.add('card', 'text-white');
  cardContainer.style.backgroundColor = '#00000080';
  cardHeader.classList.add('card-header', 'header');
  cardTitle.classList.add('card-title', 'text-center');
  row.classList.add('row');
  colImage.classList.add('col-lg-6', 'py-5', 'mx-3');
  colDesc.classList.add('col-sm-4', 'py-5', 'mx-5');
  rowCom.classList.add('row', 'p-3', 'container');
  rowCom.style.backgroundColor = '#00ff7f08';
  rowDescHeader.classList.add('py-3');
  formFloatingDiv.classList.add('form-floating', 'my-5');
  formFloatingDiv.setAttribute('id', 'commentForm');
  textarea.classList.add('form-control');
  rowDesc.classList.add('row');
  cardBody.classList.add('card-body');
  cardRating.classList.add('comment-author');
  cardRating.setAttribute('id', 'ranking-container');
  hideButton.classList.add('submit-button', 'showbtn', 'my-3');
  hideButton.setAttribute('id', 'toggleIng');
  cardFooter.classList.add('card-footer');
  cardImage.classList.add('card-img-top', 'img-fit');
  ingList.classList.add('list-group', 'list-group-flush', 'recipe-list', 'hidden');
  ingList.setAttribute('id', 'ingList');
  stepList.classList.add('list-group', 'list-group-flush', 'recipe-list');
  cardText.classList.add('card-text');
  footerText.classList.add('card-text', 'submit-button');
  commentButton.classList.add('submit-button', 'my-2');
  commentButton.style.marginLeft = '25%';
  commentButton.style.width = '50%';
  commentButton.setAttribute('id', 'cmtBtn');
  commentButton.type ='button';

  let t = '\nThis recipe requires: ' + n_ingredients + ' different ingredients.' + ' Total Calories: ' + nutrition
  rowDescHeader.innerHTML = 'Comments';
  textarea.placeholder = 'Leave a comment here';
  textarea.style.height = '100px';
  textarea.id = 'floatingTextarea2';
  textarea.name = 'comment';

  label.htmlFor = 'floatingTextarea2';
  label.textContent = 'Add A Comment';

  cardText.textContent = description;
  footerText.textContent = t;
  cardTitle.textContent = name;
  document.title = 'Recipe Box - ' + name;
  cardImage.src = url;
  hideButton.textContent = "Show Ingredients";
  commentButton.textContent = 'Comment';

  ingredients.forEach(ingredient => {
    const li = document.createElement('li');
    li.classList.add('submit-button');
    li.textContent = capitalizeFirstLetters(ingredient);
    ingList.appendChild(li);
  });
  steps.forEach(steps => {
    const li = document.createElement('li');
    li.classList.add('submit-button');
    li.textContent = capitalizeFirstLetters(steps);
    stepList.appendChild(li);
  });
  formFloatingDiv.appendChild(textarea);
  formFloatingDiv.appendChild(label);
  formFloatingDiv.appendChild(commentButton);
  rowCom.appendChild(rowDescHeader);
  comments.forEach(com => {
    console.log(com.username);
    if (com.username !== null) {
      let comment = createCommentContainer(com.comment_date, com.username, com.comment_text);
      rowCom.appendChild(comment);
    }
  });
  rowCom.appendChild(document.createElement('hr'))
  rowCom.appendChild(formFloatingDiv);  
  cardHeader.appendChild(cardTitle);
  cardContainer.appendChild(cardHeader);
  colImage.appendChild(cardImage);
  rowDesc.appendChild(cardText)
  colDesc.appendChild(rowDesc);

  row.appendChild(colImage);
  row.appendChild(colDesc);
  cardContainer.appendChild(row);
  let rTest = createRating(cRank);
  cardRating.appendChild(rTest);
  cardBody.appendChild(cardRating);
  cardBody.appendChild(hideButton);
  cardBody.appendChild(ingList);
  cardBody.appendChild(document.createElement('hr'));
  cardBody.appendChild(stepList);
  cardContainer.appendChild(cardBody);
  cardFooter.appendChild(footerText);
  cardContainer.appendChild(cardFooter);
  cardContainer.appendChild(rowCom);

  return cardContainer;
}

function createCommentContainer(time, user, comment) {
  var container = document.createElement("div");
  var card = document.createElement('div');
  var header = document.createElement('div');
  var body = document.createElement('div');
  var footer = document.createElement('div');
  var title = document.createElement('h5');
  var text = document.createElement('p');
  

  container.classList.add("col", "mt-3");
  card.classList.add('card', 'border-success', 'mb-3');
  header.classList.add('card-header', 'bg-transparent', 'border-success');
  body.classList.add('card-body', 'text-success');
  footer.classList.add('card-footer', 'bg-transparent', 'border-success');
  title.classList.add('card-title');
  text.classList.add('card-text');
  
  header.innerHTML = user;
  text.innerHTML = comment;
  footer.innerHTML = time;

  card.appendChild(header);
  body.appendChild(title);
  body.appendChild(text);
  card.appendChild(body);
  card.appendChild(footer);
  container.appendChild(card);

  return container;
}

function capitalizeFirstLetters(inputString) {
  return inputString.replace(/\b\w/g, function(match) {
      return match.toUpperCase();
  });
}

async function loadPage(id) {
  try {
    const recipes = await fetch('../php/fetch.php?id=' + id);
    const comments = await fetch('../php/fetch.php?type=fetchComments&rid=' + id);
    const data = await recipes.json();
    const comData =  await comments.json();
    const name = capitalizeFirstLetters(data.recipe_name);
    const ingredientsArray = JSON.parse(data.ingredients.replace(/'/g, '"'));
    console.log(data.steps);
    const stepsArray = JSON.parse(data.steps.replace(/'/g, '"'));
    const a = createCard(name, data.description, ingredientsArray, data.n_ingredients, stepsArray, data.n_steps,
                        data.ranking, data.images, data.minutes, data.nutrition, comData);
    $('#main').append(a);

 
  } catch (error) {
    console.error('Error adding entries:', error);
  }
}

document.addEventListener('DOMContentLoaded', function() {
  (async function() {
    var rec_id = localStorage.getItem('curr_rec_i');
    await loadPage(rec_id);
    document.getElementById('cmtBtn').onclick = function() {
      var formData = new FormData(document.getElementById('commentForm'));
      formData.append('rec_id', rec_id);
      console.log(formData)
      fetch('../php/fetch.php?type=comment', {
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
    document.getElementById("toggleIng").onclick = function() {
        var list = document.getElementById("ingList");
        if (list.classList.contains("hidden")) {
            this.innerHTML = "Hide Ingredients";
            list.classList.remove("hidden");
        } else {
            this.innerHTML = "Show Ingredients";
            list.classList.add("hidden");
        }
    };
  })();
});