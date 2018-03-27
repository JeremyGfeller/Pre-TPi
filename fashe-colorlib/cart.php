<!DOCTYPE html>
<html lang="en">
<head>
	<title>Cart</title>
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
    extract($_POST);

    require_once('fonctions.php');
    ConnectDB();
    
    if(isset($_POST['deleteBasket']))
    {
		$query = "UPDATE article set quantity = quantity + (SELECT quantity FROM orderlist WHERE fk_article = $deleteBasket) WHERE id_article = $deleteBasket;";
		$dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

        $query = "DELETE FROM orderlist WHERE fk_article = '$deleteBasket';";
		$dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
	}

	// Show content in the bsaket 
	require_once('top.php');
    ?>
	

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/connexion.jpg);">
		<h2 class="l-text2 t-center">
			<font color="black"> Panier </font>
		</h2>
	</section>

	<!-- Cart -->
    <?php
    
    if(isset($UserName))
    {
        $query = "SELECT id_basket, id_users, id_article, id_orderlist, size, illustration, orderlist.quantity, users_lastName, users_role, model_name, model_prix, brand FROM basket
              inner join orderlist on fk_basket = id_basket
              inner join users on fk_users = id_users
              inner join article on fk_article = id_article
              inner join size on fk_size = id_size
              inner join model on fk_model = id_model
              inner join brand on fk_brand = id_brand
              WHERE fk_users = $IDPersonne;";
    
        $baskets = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

        echo"
        <section class=cart bgwhite p-t-70 p-b-100'>
            <div class='container'>
                <!-- Cart item -->
                <div class='container-table-cart pos-relative'>
                    <div class='wrap-table-shopping-cart bgwhite'>
                        <table class='table-shopping-cart'>
                            <tr class='table-head'>
                                <th class='column-1'></th>
                                <th class='column-2'>Produit</th>
                                <th class='column-3'>Prix</th>
                                <th class='column-3'>Taille</th>
                                <th class='column-4'>Quantité</th>
                                <th class='column-3'>Supprimer</th>
                            </tr>";

                            while($basket = $baskets->fetch())
                            {
                                extract($basket); // $id_basket, $id_users, $id_article, $id_orderlist, $users_firstName, $size, $illustration, $orderlist.quantity, $users_lastName, $users_role, $model_name, $model_prix, $brand
                                echo "
                                <tr class='table-row'>
                                    <td class='column-1'>
                                        <div class='cart-img-product b-rad-4 o-f-hidden'>
                                            <img src='images/articles/$illustration' alt='IMG-PRODUCT'>
                                        </div>
                                    </td>
                                    <td class='column-2'>$brand - $model_name</td>
                                    <td class='column-3'>$model_prix.-</td>
                                    <td class='column-3'>$size</td>
                                    <td class='column-4'>
										<select class='selection-2' name='quantity'>
											<optgroup label='Quantité'>
												<option value='$quantity'>$quantity</option>
											</optgroup>
											<optgroup label='Changer la quantité'>
												<option value='1'>1</option>
												<option value='2'>2</option>
												<option value='3'>3</option>
												<option value='4'>4</option>
												<option value='5'>5</option>
											</optgroup>	
										</select>
                                    </td>
                                    <td class='column-5'>
                                        <form method='post'>
                                            <button type='submit' name='deleteBasket' value='$id_article'>
                                                <img src='images/icons/effacer.png' alt='IMG-PRODUCT'> 
                                            </button>
                                        </form>
                                    </td>
                                </tr>";
                            }

                            $query = "SELECT id_orderlist, orderlist.quantity, fk_article, fk_basket, sum(model_prix) as total FROM yonik.orderlist
                                      inner join article on fk_article = id_article
                                      inner join model on fk_model = id_model
                                      inner join basket on fk_basket = id_basket
                                      where fk_users = (select fk_users from basket where fk_users = $IDPersonne);";
                            $additions = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

                            if ($additions->rowCount() > 0)
                            {
                                $addition = $additions->fetch(); 
                                extract($addition); //$id_users, $users_firstName, $users_lastName, $users_role, $users_login, $users_password, $hashPassword
                            }
                            echo "
                            <tr class='table-row'>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th class='column-2'>
                                    TOTAL
                                </th>";
                                if($total != 0)
                                {
                                    echo "<td>$total.-</td>";
                                }
                                else
                                {
                                    echo "<td>0.-</td>";
                                }
                            echo "
                            </tr>
                        </table>
                    </div>
                </div>
        </section>";
    }
    else
    {
        echo "<section style='padding: 10px;'>
                    <h2 class='t-center'>
                        Merci de vous connecter pour accéder à cette page  
                    </h2>
                  </section>";
    }
    ?>
    
    <br><br>
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
