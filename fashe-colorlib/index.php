<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
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
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/lightbox2/css/lightbox.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body class="animsition">
    
    <?php
    //----------------------------- Démarrage SESSION ----------------------------------------

    session_start();

    require_once('fonctions.php');
    ConnectDB();
    extract($_POST);

	/* Header */
    require_once('top.php');
    ?>
	
	<!-- Slide1 -->
	<section class="slide1">
		<div class="wrap-slick1">
			<div class="slick1">
				<div class="item-slick1 item1-slick1" style="background-image: url(images/connexion2.jpg);">
					<div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
						<h2 class="caption2-slide1 xl-text1 t-center animated visible-false m-b-37" data-appear="fadeInUp">
							<font color='black'>Bienvenue sur Zira</font>
						</h2>

						<div class="wrap-btn-slide1 w-size0 animated visible-false" data-appear="zoomIn">
							<!-- Button -->
							<a href="product.php" class="flex-c-m size0 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
								Acheter maintenant
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Banner -->
	<section class="banner bgwhite p-t-40 p-b-40">
		<div class="container">
			<div class="row">
				<div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
					<!-- block1 -->
					<div class="block1 hov-img-zoom pos-relative m-b-30">
						<img src="images/articles/g-star-bleu1.jpg" alt="IMG-BENNER">

						<div class="block1-wrapbtn w-size2">
							<!-- Button -->
							<a href="product.php?typearticle=1" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
								Habits
							</a>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
					<!-- block1 -->
					<div class="block1 hov-img-zoom pos-relative m-b-30">
						<img src="images/articles/blazer-noir1.jpg" alt="IMG-BENNER">

						<div class="block1-wrapbtn w-size2">
							<!-- Button -->
							<a href="product.php?typearticle=2" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
								Chaussures
							</a>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
					<!-- block1 -->
					<div class="block1 hov-img-zoom pos-relative m-b-30">
						<img src="images/articles/herschel-gris.jpg" alt="IMG-BENNER">

						<div class="block1-wrapbtn w-size2">
							<!-- Button -->
							<a href="product.php?typearticle=3" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
								Sac à dos
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- New Product -->
	<section class="newproduct bgwhite p-t-45 p-b-105">
		<div class="container">
			<div class="sec-title p-b-60">
				<h3 class="m-text5 t-center">
					Articles disponbiles
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">
					<?php 

					$query = "SELECT id_article, id_model, brand, model_name, model_prix, illustration FROM article inner join model on fk_model = id_model inner join brand on fk_brand = id_brand WHERE quantity > 0 GROUP BY fk_model ORDER BY RAND() LIMIT 10;";
					$randomarticles = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

					while($randomarticle = $randomarticles->fetch()) 
					{
						extract($randomarticle); // $id_article, $id_model, $brand, $model_name, $model_prix, $illustration

						echo "<div class='item-slick2 p-l-15 p-r-15'>
								<!-- Block2 -->
								<div class='block2'>
									<div class='block2-img wrap-pic-w of-hidden pos-relative'>
										<img src='images/articles/$illustration' alt='IMG-PRODUCT'>

										<div class='block2-overlay trans-0-4'>
											<a href='#' class='block2-btn-addwishlist hov-pointer trans-0-4'>
												<i class='icon-wishlist icon_heart_alt' aria-hidden='true'></i>
												<i class='icon-wishlist icon_heart dis-none' aria-hidden='true'></i>
											</a>

											<form method='post'>
												<div class='block2-btn-addcart w-size0 trans-0-4'>
													<!-- Button -->
													<button class='flex-c-m size0 bg4 bo-rad-23 hov1 s-text1 trans-0-4'>
														<input type='hidden' value='$id_model' name='toModel'/>
														<input type='hidden' name='toArticle' value='$id_article'/>
														Aller à l'article
													</button>
												</div>
											</form>
										</div>
									</div>

									<div class='block2-txt p-t-20'>
										<a href='product-detail.html' class='block2-name dis-block s-text3 p-b-5'>
											$brand $model_name
										</a>

										<span class='block2-price m-text6 p-r-5'>
											$model_prix.-
										</span>
									</div>
								</div>
							</div>";
					}
					?>
				</div>
			</div>

		</div>
	</section>
	<?php require_once('footer.php'); ?>
</body>
</html>
