<?php session_start(); ?>
<script defer src="../js/navbar.js"></script>
<link rel="stylesheet" href="../css/login.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container-sm text-white">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand btn btn-outline-info btn-dark" href="../index.php">Recipe Box</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link navbar-brand btn btn-outline-info btn-dark" aria-current="page" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navbar-brand btn btn-outline-info btn-dark" href="../recipes.php">Recipes</a>
            </li>
            </ul>
            <button id="notification" style="display: none;" class="submit-button notification"> Notification </button>
            <?php 
            if ( isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE ) {
                echo '<a class="btn btn-outline-primary btn-dark mx-3" href="../php/myAcc.php"><i class="bi bi-person-fill-gear"></i> My Account </a>';
                echo '<a class="btn btn-outline-primary btn-dark mx-3" href="../php/logout.php/"><i class="bi bi-box-arrow-right"></i> Log Out </a>';
            } else {
                echo '<button id="loginBtn" class="btn btn-outline-primary btn-dark"><i class="bi bi-person-plus-fill"></i> Login </button>';
            }
            ?>
        </div>
        
        </div>
        <!-- Login form-->
        <div id="login" style="display: none;" class="login-box login">
            <div class="box">
                <div id="welcome-lines">
                    <div id="welcome-line-1">Recipe Box</div>
                </div>
                <div class="row">
                    <button class="btns col" id="login-btn" onclick="showLoginForm()">Login</button>
                    <button class="btns col" id="signup-btn" onclick="showSignupForm()">Sign Up</button>
                </div>
                <div id="lgn">
                    <form action="../php/login.php" method="post" id="logForm">
                        <div id="form-body">
                            <div id="welcome-lines">
                                <div id="welcome-line-2">Welcome Back</div>
                            </div>
                            <div id="input-area">
                                <div class="form-inp">
                                <input name='username' placeholder="Username / Email" type="text">
                                </div>
                                <div class="form-inp">
                                <input name="password" placeholder="Password" type="password">
                                </div>
                            </div>
                            <div id="submit-button-cvr">
                                <button class="submit-button" type="button" onclick="submitLogForm()">Login</button>
                            </div>
                            <div id="forgot-pass">
                                <a href="#">Forgot password?</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="sgn" style="display: none;">
                    <form action="../php/register.php" method="post" id="regForm">
                        <div id="form-body">
                            <div id="welcome-lines">
                                <div id="welcome-line-2">Register</div>
                            </div>
                            <div id="input-area">
                                <div class="form-inp">
                                    <input name='username' placeholder="Username" type="text">
                                </div>
                                <div class="form-inp">
                                    <input name="email" placeholder="E-mail" type="text">
                                </div>
                                <div class="form-inp">
                                    <input name="password" placeholder="Password" type="password">
                                </div>
                                <div class="form-inp">
                                    <input placeholder="Re-enter Password" type="password">
                                </div>
                            </div>
                            <div id="submit-button-cvr">
                                <button class="submit-button" type="button" onclick="submitRegForm()">Register</button>
                            </div>
                            <div id="forgot-pass">
                                <a href="#">Forgot password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>