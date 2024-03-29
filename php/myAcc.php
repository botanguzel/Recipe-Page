<?php
	require_once("./connect.php");
	include('../navbar.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Account Settings - RecipeBox</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/myAcc.css">
	<script defer src="../js/myAcc.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<body>
	<section class="py-5 my-5">
		<div class="container">
			<div class="text-white rounded-lg d-block d-sm-flex tbl">
				<div class="profile-tab-nav border-right" style="width:20%;">
					<div class="p-4">
						<div class="img-circle text-center mb-3"></div>
					</div>
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<h1 id="user" class="mb-5 text-primary">USERNAME</h1>

						<a class="submit-button active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
							<i class="fa fa-home text-center mr-1"></i> Account
						</a>
						<a class="submit-button my-3" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
							<i class="fa fa-key text-center mr-1"></i> Password
						</a>
					</div>
				</div>

				<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
						<h3 class="mb-4 text-primary">Account Information</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>username</label>
									<div class="form-inp">
										<input id="username" value="" disabled>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Email</label>
									<div class="form-inp">
										<input id="email" name="email" type="text" value="" disabled>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
						<h3 class="mb-4 text-primary">Password Settings</h3>
						<form action="../php/login.php" method="post" id="updateForm">
							<div id="form-body">
								<div id="welcome-lines">
									<div id="welcome-line-2">Change Your Password</div>
								</div>
								<div id="input-area">
									<div class="row">
										<div class="col-md-4">
											<div class="form-inp">
												<input name='oldPass' placeholder="Old Password" type="password">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-inp">
												<input name="newPass" placeholder="New Password" type="password">
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-inp">
												<input placeholder="New Password Again" type="password">
											</div>
										</div>
									</div>
								</div>
								<div id="submit-button-cvr">
									<button class="submit-button" type="button" onclick="changePass()"> Update Password </button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include_once('../footer.html'); ?>
</body>

</html>