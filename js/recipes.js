var meats = []
var veggies = []
var mix = []
var elementTypes = ['meat', 'veggie', 'mixed'];
var filter = false;

function createRating(cardIndex, cRank) {
  // Create a div element with class 'rating'
  var ratingDiv = document.createElement('div');
  ratingDiv.className = 'rating';

  // Loop to create radio inputs and labels
  for (var i = 5; i >= 1; i--) {
    // Create radio input
    var radioInput = document.createElement('input');
    radioInput.value = i;
    radioInput.name = 'rating' + cardIndex; // Unique name for each rating set
    radioInput.id = 'star' + cardIndex + i;
    radioInput.type = 'radio';

    // If current rank is greater than or equal to i, check the radio input
    if (cRank <= i) {
      radioInput.checked = true;
    }

    // Create label
    var label = document.createElement('label');
    label.htmlFor = 'star' + cardIndex + i;

    // Append radio input and label to the rating div
    ratingDiv.appendChild(radioInput);
    ratingDiv.appendChild(label);
  }

  // Get the div with id 'top' and append the rating div to it
  return ratingDiv;
}



function redirectToDetails(param) {
  window.location.href = 'recipe-detail.html?' + param;
}

function cardCreator(recipe_name, recipe_desc, url, rIndex, cRank, cal, n_ingredients, n_steps) {
  const col = document.createElement('div');
  const overlay = document.createElement('div');
  const overlayText = document.createElement('p');
  const htmlImage = document.createElement('img');
  const htmlRecipes = document.createElement('div');
  const htmlBody = document.createElement('div');
  const htmlStars = document.createElement('div');
  const htmlDesc = document.createElement('h3');
  const htmlTitle = document.createElement('h1');

  col.classList.add('col-sm-4', 'py-5', 'hidden-col');
  overlay.classList.add('overlay');
  overlayText.classList.add('overlay-text', 'pl-3', 'mt-3');
  htmlRecipes.classList.add('card', 'crd-detail');
  htmlBody.classList.add('card-body', 'crd-body');
  htmlStars.classList.add('comment-author');
  htmlStars.setAttribute('id', 'ranking-container');
  htmlImage.classList.add('card-img-top', 'crd-img');
  htmlImage.setAttribute('src', url);

  let t = `This recipe requires: ${n_ingredients} different ingredients and ${n_steps} steps to cook and prepare. <br> <hr> Calories: ${cal}`;
  overlayText.innerHTML = t;
  htmlTitle.innerHTML = recipe_name;
  htmlDesc.innerHTML = recipe_desc;

  overlay.addEventListener('click', () => {
    localStorage.setItem('curr_rec_i', rIndex);
    window.location.href = "recipe-detail.php";
  });

  const rTest = createRating(rIndex, cRank);
  htmlStars.appendChild(rTest);
  htmlBody.appendChild(htmlStars);
  htmlBody.appendChild(htmlTitle);
  htmlBody.appendChild(htmlDesc);
  overlay.appendChild(overlayText);
  htmlRecipes.appendChild(overlay);
  htmlRecipes.appendChild(htmlImage);
  htmlRecipes.appendChild(htmlBody);
  col.appendChild(htmlRecipes);
  return col;
}

function capitalizeFirstLetters(inputString) {
  return inputString.replace(/\b\w/g, function(match) {
      return match.toUpperCase();
  });
}

async function loadPage() {
  try {
    const recipes = await fetch('../php/fetch.php?type=recipe');
    const data = await recipes.json();
    data.forEach(element => {
      const name = capitalizeFirstLetters(element.recipe_name);
      const a = cardCreator(name, element.description, element.images, element.id, element.ranking, element.nutrition, element.n_ingredients, element.n_steps);
      $('.galleryRow').append(a);
    });

  } catch (error) {
    showNotificationButton('Error adding entries:', error);
  }
}

$(document).ready(function() {
  (async function() {
      await loadPage(); // Wait for loadPage to complete

      var hiddenCols = $(".hidden-col");
      var visibleCols = 6;

      // Show the initial set of columns
      hiddenCols.slice(0, visibleCols).removeClass("hidden-col");

      function loadMore() {
        // Implement your logic to load more content
        // This may involve making an AJAX request or manipulating the DOM
  
        // For example, if you have more hidden columns, you can reveal them:
        var remainingCols = hiddenCols.slice(visibleCols, visibleCols + 6);
        remainingCols.removeClass("hidden-col");
  
        // Update the visibleCols count
        visibleCols += 6;
      }

      $("#loadMoreBtn").on("click", loadMore);
      $(window).scroll(function() {
          if ($(window).scrollTop() + $(window).height() == $(document).height()) {
              setTimeout(loadMore, 1000);
          }
      });
  })();
});