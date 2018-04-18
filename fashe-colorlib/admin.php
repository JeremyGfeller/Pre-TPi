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
        $model = "SELECT id_orderlist, quantity, fk_article, fk_basket FROM orderlist WHERE fk_article = $delete;";
        $models = $dbh->query($model) or die ("SQL Error in:<br> $model <br>Error message:".$dbh->errorInfo()[2]);
        
        if($models->rowCount() > 0)
        {
            $query = "DELETE FROM orderlist WHERE fk_article = $delete;";
            $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
        }           
        $delArticle = "DELETE FROM article WHERE id_article = $delete;";
        $dbh->query($delArticle) or die ("SQL Error in:<br> $delArticle <br>Error message:".$dbh->errorInfo()[2]);
    }
    
    if(isset($_POST['appliquer']))
    {  
        if($newPrice == "" && $newQuantity == "")
        {
            $query = "UPDATE article SET quantity = $quantity WHERE id_article = $appliquer;
                      UPDATE model SET model_prix = $modelPrix WHERE id_model = $idModel;";
        }
        else if($newPrice != "" && $newQuantity != "")
        {   
            $query = "UPDATE article SET quantity = $newQuantity WHERE id_article = $appliquer;
                      UPDATE model SET model_prix = $newPrice WHERE id_model = $idModel;";
        }
        else if($newPrice != "")
        {
            $query = "UPDATE model SET model_prix = $newPrice WHERE id_model = $idModel;";
        }
        else if($newQuantity != "")
        {
            $query = "UPDATE article SET quantity = $newQuantity WHERE id_article = $appliquer;";
        }
        $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
    }
    ?>
	

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/connexion.jpg);">
		<h2 class="l-text2 t-center">
			<font color="black"> Administration </font>
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
                                            <td class='column-4'>
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
	<?php require_once('footer.php'); ?>
</body>
</html>
