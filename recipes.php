<?php include_once('navbar.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Recipe Box - Recipes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="./js/recipes.js"></script>
    <link rel="stylesheet" href="./css/recipe.css">
</head>

<body class="bg-dark rec-bg">
  
  <div class="container-sm">
      <div class="row galleryRow"> </div>
      <div class="row load-more-container">
        <div class="col-sm-12 text-center">
          <button id="loadMoreBtn" class="btn btn-primary">Load More</button>
        </div>
      </div>
  </div>
  <?php include_once('footer.html'); ?>
</body>
</html>
