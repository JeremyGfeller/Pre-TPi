<!DOCTYPE html>
<html lang="en">
<head>
	<title>Administration</title>
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
<body class="animsition">

	<?php
    //----------------------------- Démarrage SESSION ----------------------------------------

    session_start();

    require_once('fonctions.php');
    ConnectDB();


	/* Header */
    require_once('top.php');
    extract($_GET);
    extract($_POST);
    
    if(isset($_POST['delete']))
    {
        echo "POST";
        $query = "DELETE FROM article WHERE id_article = $delete;";
        $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
    }
    
    if(isset($_POST['appliquer']))
    {  
        if($newPrice == "" && $newQuantity == "")
        {
            echo "toto";
            $query = "UPDATE article SET quantity = $quantity WHERE id_article = $appliquer;
                      UPDATE model SET model_prix = $modelPrix WHERE id_model = $idModel;";
        }
        else if($newPrice != "" && $newQuantity != "")
        {   
            echo "tata";
            $query = "UPDATE article SET quantity = $newQuantity WHERE id_article = $appliquer;
                      UPDATE model SET model_prix = $newPrice WHERE id_model = $idModel;";
        }
        else if($newPrice != "")
        {
            echo "titi";
            $query = "UPDATE model SET model_prix = $newPrice WHERE id_model = $idModel;";
        }
        else if($newQuantity != "")
        {
            echo "tutu";
            $query = "UPDATE article SET quantity = $newQuantity WHERE id_article = $appliquer;";
        }
            
        
        $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
    }
    ?>
	

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/connexion.jpg);">
		<h2 class="l-text2 t-center">
			Administration
		</h2>
	</section>

	<!-- Cart -->
	<section class="cart bgwhite p-t-70 p-b-100">
		<div class="container">
			<!-- Cart item -->
			<div class="container-table-cart pos-relative">
				<div class="wrap-table-shopping-cart bgwhite">
					<table class="table-shopping-cart">
						<tr class="table-head">
							<th class="column-1"></th>
							<th class="column-2">Article - Taille</th>
							<th class="column-3">Couleur</th>
							<th class="column-4">Prix</th>
							<th class="column-5">Quantité</th>
                            <th class='column-6'>Modifier</th>
                            <th class='column-7'>Supprimer</th>
						</tr>
                        <?php
                            $query = "SELECT id_article, id_model, quantity, illustration, brand, model_name, model_prix, size, color FROM article
                                      INNER JOIN model on id_model = fk_model
                                      INNER JOIN size on id_size = fk_size
                                      INNER JOIN color ON id_color = fk_color
                                      INNER JOIN brand ON fk_brand = id_brand
                                      group by id_article;";
                        
                            $administrations = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
                        
                            while($administration = $administrations->fetch()) //fetch = aller chercher
                            {
                                extract($administration); // $id_article, $id_model, $quantity, $illustration, $brand, $model_name, $model_prix, $size, $color  
                                extract($_GET);
                                echo"
                                <tr class='table-row'>
                                    <td class='column-1'>
                                        <div class='cart-img-product b-rad-4 o-f-hidden'>
                                            <img src='images/articles/$illustration' alt='IMG-PRODUCT'>
                                        </div>
                                    </td>";
                                    if(isset($modifier) && $id_article == $modifier)
                                    {
                                        echo"
                                        <form method='post' action='admin.php'>
                                            <td class='column-2'>$model_name | en $size</td>
                                            <td class='column-3'>$color</td>
                                            <td class='column-5'>
                                                <input type='text' name='newPrice' placeholder='Entrez le nouveau prix'/>
                                            </td>
                                            <td class='column-5'>
                                                <input type='text' name='newQuantity' placeholder='Entrez la nouvelle quantité'/>
                                            </td>
                                            <td class='column-6'>
                                                <button type='submit' name='appliquer' value='$id_article'>
                                                    <input type='hidden' name='idModel' value='$id_model'/>
                                                    <input type='hidden' name='quantity' value='$quantity'/>
                                                    <input type='hidden' name='modelPrix' value='$model_prix'/>
                                                    <img src='images/icons/ok.png' alt='IMG-PRODUCT'> 
                                                </button>
                                            </td>
                                        </form>";
                                    }
                                    else
                                    {  
                                        echo"
                                        <form method='post'>
                                            <td class='column-2'>$model_name | en $size</td>
                                            <td class='column-3'>$color</td>
                                            <td class='column-4'>$model_prix.-</td>
                                            <td class='column-5'>$quantity</td>
                                            <td class='column-6'>
                                                <button type='submit' name='modifier' value='$id_article'>
                                                    <img src='images/icons/modifier.png' alt='IMG-PRODUCT'> 
                                                </button>
                                            </td>
                                            <td class='column-7'>
                                                <button type='submit' name='delete' value='$id_article'>
                                                    <img src='images/icons/effacer.png' alt='IMG-PRODUCT'> 
                                                </button>
                                            </td>
                                        </form>";
                                    }
                                echo"
                                </tr>";
                            }
                        ?>
					</table>
				</div>
			</div>
		</div>
	</section>

    <!--

    <div class='flex-w bo5 of-hidden w-size17'>
        <button class='btn-num-product-down color1 flex-c-m size7 bg8 eff2'>
            <i class='fs-12 fa fa-minus' aria-hidden='true'></i>
        </button>

        <input class='size8 m-text18 t-center num-product' type='number' name='num-product1' value='1'>

        <button class='btn-num-product-up color1 flex-c-m size7 bg8 eff2'>
            <i class='fs-12 fa fa-plus' aria-hidden='true'></i>
        </button>
    </div>

    -->

	<!-- Footer -->
	<footer class="bg6 p-t-45 p-b-43 p-l-45 p-r-45">
		<div class="flex-w p-b-90">
			<div class="w-size6 p-t-30 p-l-15 p-r-15 respon3">
				<h4 class="s-text12 p-b-30">
					GET IN TOUCH
				</h4>

				<div>
					<p class="s-text7 w-size27">
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
					</p>

					<div class="flex-m p-t-30">
						<a href="#" class="fs-18 color1 p-r-20 fa fa-facebook"></a>
						<a href="#" class="fs-18 color1 p-r-20 fa fa-instagram"></a>
						<a href="#" class="fs-18 color1 p-r-20 fa fa-pinterest-p"></a>
						<a href="#" class="fs-18 color1 p-r-20 fa fa-snapchat-ghost"></a>
						<a href="#" class="fs-18 color1 p-r-20 fa fa-youtube-play"></a>
					</div>
				</div>
			</div>

			<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
				<h4 class="s-text12 p-b-30">
					Categories
				</h4>

				<ul>
					<li class="p-b-9">
						<a href="#" class="s-text7">
							Men
						</a>
					</li>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							Women
						</a>
					</li>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							Dresses
						</a>
					</li>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							Sunglasses
						</a>
					</li>
				</ul>
			</div>

			<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
				<h4 class="s-text12 p-b-30">
					Links
				</h4>

				<ul>
					<li class="p-b-9">
						<a href="#" class="s-text7">
							Search
						</a>
					</li>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							About Us
						</a>
					</li>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							Contact Us
						</a>
					</li>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							Returns
						</a>
					</li>
				</ul>
			</div>

			<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
				<h4 class="s-text12 p-b-30">
					Help
				</h4>

				<ul>
					<li class="p-b-9">
						<a href="#" class="s-text7">
							Track Order
						</a>
					</li>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							Returns
						</a>
					</li>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							Shipping
						</a>
					</li>

					<li class="p-b-9">
						<a href="#" class="s-text7">
							FAQs
						</a>
					</li>
				</ul>
			</div>

			<div class="w-size8 p-t-30 p-l-15 p-r-15 respon3">
				<h4 class="s-text12 p-b-30">
					Newsletter
				</h4>

				<form>
					<div class="effect1 w-size9">
						<input class="s-text7 bg6 w-full p-b-5" type="text" name="email" placeholder="email@example.com">
						<span class="effect1-line"></span>
					</div>

					<div class="w-size2 p-t-20">
						<!-- Button -->
						<button class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">
							Subscribe
						</button>
					</div>

				</form>
			</div>
		</div>

		<div class="t-center p-l-15 p-r-15">
			<a href="#">
				<img class="h-size2" src="images/icons/paypal.png" alt="IMG-PAYPAL">
			</a>

			<a href="#">
				<img class="h-size2" src="images/icons/visa.png" alt="IMG-VISA">
			</a>

			<a href="#">
				<img class="h-size2" src="images/icons/mastercard.png" alt="IMG-MASTERCARD">
			</a>

			<a href="#">
				<img class="h-size2" src="images/icons/express.png" alt="IMG-EXPRESS">
			</a>

			<a href="#">
				<img class="h-size2" src="images/icons/discover.png" alt="IMG-DISCOVER">
			</a>

			<div class="t-center s-text8 p-t-20">
				Copyright © 2018 All rights reserved. | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
			</div>
		</div>
	</footer>



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
