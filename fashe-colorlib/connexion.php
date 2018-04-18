<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connexion</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/themify/themify-icons.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/elegant-font/html-css/style.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
    <?php
    //----------------------------- Démarrage SESSION ----------------------------------------

    session_start();

    require_once('fonctions.php');
    ConnectDB();

    if(isset($_POST['firstName']))
    {
		extract($_POST);

		$query = "SELECT id_users, users_firstName, users_lastName, users_role, users_login, users_password, password('$password') as hashPassword FROM users where users_login = '$login';";
		$checkconnexion = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
		
		if ($checkconnexion->rowCount() > 0)
        {
            echo "<section style='padding-top: 10px;'>
                    <h2 class='t-center'>
                        Ce pseudo éxiste déjà 
                    </h2>
                  </section>";
		}
		else
		{
			$query = "INSERT INTO users (users_firstName, users_lastName, users_role, users_login, users_password) VALUES ('$firstName', '$lastName', '$role', '$login', password('$password'));";  
			$dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

			$query = "SELECT id_users, users_firstName, users_lastName, users_role, users_login, users_password, password('$password') as hashPassword FROM users where users_login = '$login';";
			$connexions = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
	
			if ($connexions->rowCount() > 0)
			{
				$connexion = $connexions->fetch(); 
				extract($connexion); //$id_users, $users_firstName, $users_lastName, $users_role, $users_login, $users_password, $hashPassword
				$_SESSION['IDPersonne'] = $id_users;
				$_SESSION['UserName'] = "$firstName $lastName";
				$_SESSION['role'] = $role;
			}
		}
    }   
    else if(isset($_POST['login']))
    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $query = "SELECT id_users, users_firstName, users_lastName, users_role, users_login, users_password, password('$password') as hashPassword FROM users where users_login = '$login';";
        $connexions = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

        if ($connexions->rowCount() > 0)
        {
            $connexion = $connexions->fetch(); 
			extract($connexion); //$id_users, $users_firstName, $users_lastName, $users_role, $users_login, $users_password, $hashPassword
			
			if($users_password == $hashPassword)
			{
				$_SESSION['IDPersonne'] = $id_users;
				$_SESSION['UserName'] = "$users_firstName $users_lastName";
				$_SESSION['role'] = $users_role;
			}
			else
			{
				echo "<section style='margin-top: 10px;'>
						<h2 class='t-center'>
							Login ou mot de passe faux 
						</h2>
					</section>";
			}
		}
    }
	require_once('top.php');
    ?>
	<body class="animsition">
		<!-- content page -->
		<section class="bgwhite p-t-60">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-lg-12 p-b-75">
						<div class="p-r-50 p-r-0-lg">
							<?php	
								if(!isset($_SESSION['IDPersonne']))
								{
									echo "<div class='item-blog p-b-80 t-center'>
										<h2>Connexion</h2><br>";
											echo loginBox();
									echo "</div>                            
									<div class='item-blog p-b-80 t-center'>
										<h3>Inscription</h3><br>";
											echo inscription();
									echo"</div>";
								}
								else
								{
									echo "<div class='item-blog p-b-80 t-center'>
										<h2>Connexion réussie</h2><br>";
											echo loginBox();
									echo "</div>";
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Footer -->
		<?php require_once('footer.php'); ?>

		<!-- Back to top -->
		<div class="btn-back-to-top bg0-hov" id="myBtn">
			<span class="symbol-btn-back-to-top">
				<i class="fa fa-angle-double-up" aria-hidden="true"></i>
			</span>
		</div>

		<!-- Container Selection -->
		<div id="dropDownSelect1"></div>
		<div id="dropDownSelect2"></div>

	<!--===============================================================================================-->
		<script type="text/javascript" src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
		<script type="text/javascript" src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
		<script type="text/javascript" src="vendor/bootstrap/js/popper.js"></script>
		<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
		<script type="text/javascript" src="vendor/select2/select2.min.js"></script>
		<script type="text/javascript">
			$(".selection-1").select2({
				minimumResultsForSearch: 20,
				dropdownParent: $('#dropDownSelect1')
			});

			$(".selection-2").select2({
				minimumResultsForSearch: 20,
				dropdownParent: $('#dropDownSelect2')
			});
		</script>
	<!--===============================================================================================-->
		<script src="js/main.js"></script>

	</body>
</html>
