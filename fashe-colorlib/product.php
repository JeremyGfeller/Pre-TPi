<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Product</title>
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
        <link rel="stylesheet" type="text/css" href="vendor/noui/nouislider.min.css">
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
        ?>

        <!-- Title Page -->
        <section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" style="background-image: url(images/connexion.jpg);">
            <h2 class="l-text2 t-center">
                <font color="black"> Articles </font>
            </h2>
            <p class="m-text13 t-center">
                
            </p>
        </section>


        <!-- Content page -->
        <section class="bgwhite p-t-55 p-b-65">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
                        <div class="leftbar p-r-20 p-r-0-sm">
                            <!--  -->
                            <h4 class="m-text14 p-b-7">
                                Categories
                            </h4>

                            <ul class="p-b-54">
                                <li class="p-t-4">
                                    <a href="product.php" class="s-text13 active1">
                                        Tout
                                    </a>
                                </li>

                                <li class="p-t-4">
                                    <a href="product.php?typearticle=1" class="s-text13">
                                        Habits
                                    </a>
                                </li>

                                <li class="p-t-4">
                                    <a href="product.php?typearticle=2" class="s-text13">
                                        Chaussures
                                    </a>
                                </li>

                                <li class="p-t-4">
                                    <a href="product.php?typearticle=3" class="s-text13">
                                        Sac à dos
                                    </a>
                                </li>
                            </ul>

                            <!--  -->
                            <h4 class="m-text14 p-b-32">
                                Filters
                            </h4>

                            <div class="filter-price p-t-22 p-b-50 bo3">
                                <div class="m-text15 p-b-17">
                                    Price
                                </div>

                                <div class="wra-filter-bar">
                                    <div id="filter-bar"></div>
                                </div>

                                <div class="flex-sb-m flex-w p-t-16">
                                    <div class="w-size11">
                                        <!-- Button -->
                                        <button class="flex-c-m size4 bg7 bo-rad-15 hov1 s-text14 trans-0-4">
                                            Filter
                                        </button>
                                    </div>

                                    <div class="s-text3 p-t-10 p-b-10">
                                        Range: $<span id="value-lower">610</span> - $<span id="value-upper">980</span>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-color p-t-22 p-b-50 bo3">
                                <div class="m-text15 p-b-12">
                                    Color
                                </div>

                                <ul class="flex-w">
                                    <li class="m-r-10">
                                        <input class="checkbox-color-filter" id="color-filter1" type="checkbox" name="color-filter1">
                                        <label class="color-filter color-filter1" for="color-filter1"></label>
                                    </li>

                                    <li class="m-r-10">
                                        <input class="checkbox-color-filter" id="color-filter2" type="checkbox" name="color-filter2">
                                        <label class="color-filter color-filter2" for="color-filter2"></label>
                                    </li>

                                    <li class="m-r-10">
                                        <input class="checkbox-color-filter" id="color-filter3" type="checkbox" name="color-filter3">
                                        <label class="color-filter color-filter3" for="color-filter3"></label>
                                    </li>

                                    <li class="m-r-10">
                                        <input class="checkbox-color-filter" id="color-filter4" type="checkbox" name="color-filter4">
                                        <label class="color-filter color-filter4" for="color-filter4"></label>
                                    </li>

                                    <li class="m-r-10">
                                        <input class="checkbox-color-filter" id="color-filter5" type="checkbox" name="color-filter5">
                                        <label class="color-filter color-filter5" for="color-filter5"></label>
                                    </li>

                                    <li class="m-r-10">
                                        <input class="checkbox-color-filter" id="color-filter6" type="checkbox" name="color-filter6">
                                        <label class="color-filter color-filter6" for="color-filter6"></label>
                                    </li>

                                    <li class="m-r-10">
                                        <input class="checkbox-color-filter" id="color-filter7" type="checkbox" name="color-filter7">
                                        <label class="color-filter color-filter7" for="color-filter7"></label>
                                    </li>
                                </ul>
                            </div>

                            <div class="search-product pos-relative bo4 of-hidden">
                                <input class="s-text7 size6 p-l-23 p-r-50" type="text" name="search-product" placeholder="Search Products...">

                                <button class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
                                    <i class="fs-12 fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
                        <!--  -->
                        <div class="flex-sb-m flex-w p-b-35">
                            <div class="flex-w">
                                <div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
                                    <select class="selection-2" name="sorting">
                                        <option>Default Sorting</option>
                                        <option>Popularity</option>
                                        <option>Price: low to high</option>
                                        <option>Price: high to low</option>
                                    </select>
                                </div>

                                <div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
                                    <select class="selection-2" name="sorting">
                                        <option>Price</option>
                                        <option>$0.00 - $50.00</option>
                                        <option>$50.00 - $100.00</option>
                                        <option>$100.00 - $150.00</option>
                                        <option>$150.00 - $200.00</option>
                                        <option>$200.00+</option>

                                    </select>
                                </div>
                            </div>

                            <span class="s-text8 p-t-5 p-b-5">
                                Showing 1–12 of 16 results
                            </span>
                        </div>

                        <!-- Product -->
                        <div class="row">
                            <?php                            
                                if(isset($_GET['typearticle']))
                                {
                                    $typearticle = $_GET['typearticle'];

                                    $query2 = "SELECT id_article, id_model, illustration, brand, model_name, model_prix, fk_typeArticle FROM article
                                                INNER JOIN model ON id_model = fk_model
                                                INNER JOIN brand ON fk_brand = id_brand
                                                WHERE fk_typeArticle = $typearticle
                                                GROUP BY illustration;";
                                    
                                    $articles = $dbh->query($query2) or die ("SQL Error in:<br> $query2 <br>Error message:".$dbh->errorInfo()[2]);   
                                } 
                                else
                                {
                                    $query = "SELECT id_article, id_model, illustration, brand, model_name, model_prix, fk_typeArticle FROM article
                                                INNER JOIN model ON id_model = fk_model
                                                INNER JOIN brand ON fk_brand = id_brand
                                                GROUP BY illustration;";

                                    $articles = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
                                }                               

                                while($article = $articles->fetch()) //fetch = aller chercher
                                {
                                    extract($article); // $id_article, $id_model, $quantity, $illustration, $brand, $model_name, $model_prix
                                    echo "<div class='col-sm-12 col-md-6 col-lg-4 p-b-50'>
                                            <!-- Block2 -->
                                            <div class='block2'>
                                                <div class='block2-img wrap-pic-w of-hidden pos-relative'>
                                                    <a href='product-detail.php?modelid=$id_model&articleid=$id_article'><img src='images/articles/$illustration' alt='IMG-PRODUCT'></a>
                                                </div>

                                                <div class='block2-txt p-t-20'>
                                                    <a href='product-detail.php?modelid=$id_model&articleid=$id_article' class='block2-name dis-block s-text3 p-b-5'>
                                                        $brand - $model_name
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
        <script type="text/javascript" src="vendor/daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="vendor/daterangepicker/daterangepicker.js"></script>
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
        </script>

        <!--===============================================================================================-->
        <script type="text/javascript" src="vendor/noui/nouislider.min.js"></script>
        <script type="text/javascript">
            /*[ No ui ]
	    ===========================================================*/
            var filterBar = document.getElementById('filter-bar');

            noUiSlider.create(filterBar, {
                start: [ 50, 200 ],
                connect: true,
                range: {
                    'min': 50,
                    'max': 200
                }
            });

            var skipValues = [
                document.getElementById('value-lower'),
                document.getElementById('value-upper')
            ];

            filterBar.noUiSlider.on('update', function( values, handle ) {
                skipValues[handle].innerHTML = Math.round(values[handle]) ;
            });
        </script>
        <!--===============================================================================================-->
        <script src="js/main.js"></script>

    </body>
</html>
