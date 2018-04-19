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
    
    /* Check if we are connected */
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

                            /* Show the basket from a user */
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

                            $query = "SELECT id_orderlist, orderlist.quantity, fk_article, fk_basket, sum(model_prix * orderlist.quantity) as total FROM zira.orderlist
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
    /* Show a message when we are not connected */
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
