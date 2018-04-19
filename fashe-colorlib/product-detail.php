<!DOCTYPE html>
<html lang="en">
<head>
	<title>Product Detail</title>
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

    session_start();
    require_once('fonctions.php');
	ConnectDB();
    
    extract($_POST);

    if(isset($_GET['modelid']))
    {
        $modelid = $_GET['modelid'];
        $articleid = $_GET['articleid'];
    } 
    
    if(isset($_POST['basket']))
    {
        /* Check if we are connected */
        if(isset($UserName))
        {         
			if($selectsize != "null")
			{
                $query = "SELECT DISTINCT id_basket, fk_users from basket WHERE fk_users = $IDPersonne;";
                $recherches = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

                $query = "SELECT id_article FROM article where fk_size = $selectsize AND fk_model = $modelid;";
                $rechercheids = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
                $rechercheid = $rechercheids->fetch(); //fetch = aller chercher
                @extract($rechercheid); 
                
                /* Put the article in the basket */
                if($recherches->rowCount() > 0)
				{
                    $query = "SELECT id_orderlist, id_article, orderlist.quantity, fk_article, fk_basket from orderlist 
                                inner join article on fk_article = id_article
                                where fk_article = $id_article and fk_size = $selectsize;";
                                
                    $recherchearticles = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
                    if($recherchearticles->rowCount() > 0)
                    {
                        $query = "update orderlist set quantity = quantity + 1 where fk_article = $id_article;";
                        $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
                    }
                    else
                    {
                        $query = "INSERT INTO orderlist (fk_article, fk_basket) VALUES ($id_article, (select id_basket from basket where fk_users = $IDPersonne));";
                        $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
                    }
				}
				else
				{
					$createUserBasket = "INSERT INTO basket (fk_users) VALUES ($IDPersonne);";
					$addArticle = "INSERT INTO orderlist (fk_article, fk_basket) VALUES ($id_article, (select id_basket from basket where fk_users = $IDPersonne));";
	
					$dbh->query($createUserBasket) or die ("SQL Error in:<br> $createUserBasket <br>Error message:".$dbh->errorInfo()[2]);
					$dbh->query($addArticle) or die ("SQL Error in:<br> $addArticle <br>Error message:".$dbh->errorInfo()[2]);
				} 
                $query = "update article set quantity = quantity - 1 where id_article = $id_article;";
                $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
            }
            /* Show a message when there is no size enable */
			else
			{
				echo "<section style='padding-top: 150px;'>
                    <h2 class='t-center'>
                        Taille épuisée, veuillez choisir un autre taille 
                    </h2>
                  </section>";
			}
        }
        /* Show a message if we are not connected */
        else
        {
            echo "<section style='padding: 150px;'>
                    <h2 class='t-center'>
                        Merci de vous connecter pour commander cette article 
                    </h2>
                  </section>";
		}
    }
	
	// Show content in the bsaket 
	require_once('top.php');

    /* Take the article we selected */
    $query = "SELECT id_article, quantity, illustration, illustration1, illustration2, brand, model_name, model_prix, size, color FROM article
                INNER JOIN model on id_model = fk_model
                INNER JOIN size on id_size = fk_size
                INNER JOIN color ON id_color = fk_color
                INNER JOIN brand ON fk_brand = id_brand
                where id_article = $articleid
                group by id_article;"; 

    $articles = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
    
    /* Take every size for the model */
    $query2 = "SELECT id_article, id_model, model_name, id_size, quantity, size, id_color, color FROM article
                INNER JOIN model on id_model = fk_model
                INNER JOIN size on id_size = fk_size
                INNER JOIN color ON id_color = fk_color
                where id_model = $modelid 
                AND id_color = (SELECT fk_color FROM article where fk_model = $modelid and id_article = $articleid);";

    $details = $dbh->query($query2) or die ("SQL Error in:<br> $query2 <br>Error message:".$dbh->errorInfo()[2]);

    /* Show the article we selected */
    while($article = $articles->fetch()) //fetch = aller chercher
    {
        extract($article); // $id_article, $quantity, $illustration, $illustration1, $illustration2, $brand, $model_name, $model_prix, $size, $color
        echo "<div class='container bgwhite p-t-35 p-b-80'>
                <div class='flex-w flex-sb'>
                    <div class='w-size13 p-t-30 respon5'>
                        <div class='wrap-slick3 flex-sb flex-w'>
                            <div class='wrap-slick3-dots'></div>

                            <div class='slick3'>
                                <div class='item-slick3' data-thumb='images/articles/$illustration'>
                                    <div class='wrap-pic-w'>
                                        <img src='images/articles/$illustration' alt='IMG-PRODUCT'>
                                    </div>
                                </div>

                                <div class='item-slick3' data-thumb='images/articles/$illustration1'>
                                    <div class='wrap-pic-w'>
                                        <img src='images/articles/$illustration1' alt='IMG-PRODUCT'>
                                    </div>
                                </div>

                                <div class='item-slick3' data-thumb='images/articles/$illustration2'>
                                    <div class='wrap-pic-w'>
                                        <img src='images/articles/$illustration2' alt='IMG-PRODUCT'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='w-size14 p-t-30 respon5'>
                        <h4 class='product-detail-name m-text16 p-b-13'>
                            $brand - $model_name en $color
                        </h4>

                        <span class='m-text17'>
                            $model_prix.-
                        </span>

                        <p class='s-text8 p-t-10'>
                            Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.
                        </p>
                        
                        <form method='post'>
                            <div class='p-t-33 p-b-60'>
                                <div class='flex-m flex-w p-b-10'>
                                    <div class='s-text15 w-size15 t-center'>
                                        Size
                                    </div>
                                        <div class='rs2-select2 rs3-select2 bo4 of-hidden w-size16'>
                                            <select class='selection-2' name='selectsize'>";
                                                while($detail = $details->fetch()) //fetch = aller chercher
                                                {
													extract($detail); // $id_article, $id_size, $quantity, $size, $color
													if($quantity > 0)
													{
														echo"<option value='$id_size'>$size</option>";
													}
													else
													{
														echo"<option value='null'>Article épuisé en $size</option>";
													}
                                                }
                                        echo "
                                        </select>
                                    </div
                                </div>

                                <div class='flex-r-m flex-w p-t-10'>
                                    <div class='w-size16 flex-m flex-w'>
                                        <div class='flex-w bo5 of-hidden m-r-22 m-t-10 m-b-10'></div>

                                        <div class='size12 trans-0-4 m-t-10 m-b-10'>
                                            <!-- Button -->
                                                <button class='flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4' name='basket'>
                                                    Ajouter au panier
                                                </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class='p-b-45'>
                            <span class='s-text8'>Categories: Mug, Design</span>
                        </div>

                        <div class='wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content'>
                            <h5 class='js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4'>
                                Description
                                <i class='down-mark fs-12 color1 fa fa-minus dis-none' aria-hidden='true'></i>
                                <i class='up-mark fs-12 color1 fa fa-plus' aria-hidden='true'></i>
                            </h5>

                            <div class='dropdown-content dis-none p-t-15 p-b-23'>
                                <p class='s-text8'>
                                    Fusce ornare mi vel risus porttitor dignissim. Nunc eget risus at ipsum blandit ornare vel sed velit. Proin gravida arcu nisl, a dignissim mauris placerat
                                </p>
                            </div>
                        </div>

                        <div class='wrap-dropdown-content bo7 p-t-15 p-b-14'>
                            <h5 class='js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4'>
                                Additional information
                                <i class='down-mark fs-12 color1 fa fa-minus dis-none' aria-hidden='true'></i>
                                <i class='up-mark fs-12 color1 fa fa-plus' aria-hidden='true'></i>
                            </h5>

                            <div class='dropdown-content dis-none p-t-15 p-b-23'>
                                <p class='s-text8'>
                                    Fusce ornare mi vel risus porttitor dignissim. Nunc eget risus at ipsum blandit ornare vel sed velit. Proin gravida arcu nisl, a dignissim mauris placerat
                                </p>
                            </div>
                        </div>

                        <div class='wrap-dropdown-content bo7 p-t-15 p-b-14'>
                            <h5 class='js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4'>
                                Reviews (0)
                                <i class='down-mark fs-12 color1 fa fa-minus dis-none' aria-hidden='true'></i>
                                <i class='up-mark fs-12 color1 fa fa-plus' aria-hidden='true'></i>
                            </h5>

                            <div class='dropdown-content dis-none p-t-15 p-b-23'>
                                <p class='s-text8'>
                                    Fusce ornare mi vel risus porttitor dignissim. Nunc eget risus at ipsum blandit ornare vel sed velit. Proin gravida arcu nisl, a dignissim mauris placerat
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
    }
    ?>
    
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
	<script type="text/javascript" src="vendor/slick/slick.min.js"></script>
	<script type="text/javascript" src="js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="vendor/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript">
		$('.block2-btn-addcart').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});

		$('.block2-btn-addwishlist').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");
			});
		});

		$('.btn-addcart-product-detail').each(function(){
			var nameProduct = $('.product-detail-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");
			});
		});
	</script>

<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
