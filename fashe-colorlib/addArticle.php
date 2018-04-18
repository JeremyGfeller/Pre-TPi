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
    extract($_FILES);
    
    /*echo "POST: "; print_r($_POST); echo "<br>";
    echo "FILES: "; print_r($_FILES); echo "<br>";*/
    
    if(isset($_POST['create']))
    {            
        $brand = "SELECT id_brand, brand FROM brand WHERE brand = '$newBrand';";
        $brands = $dbh->query($brand) or die ("SQL Error in:<br> $brand <br>Error message:".$dbh->errorInfo()[2]);
   
        $color = "SELECT id_color, color FROM color WHERE color = '$newColor';";
        $colors = $dbh->query($color) or die ("SQL Error in:<br> $color <br>Error message:".$dbh->errorInfo()[2]);
        
        $model = "SELECT id_model, model_name, model_prix, fk_typearticle, fk_brand FROM model WHERE model_name = '$newModel';";
        $models = $dbh->query($model) or die ("SQL Error in:<br> $model <br>Error message:".$dbh->errorInfo()[2]);
                        
        if($brands->rowCount() > 0)
        {}
        else
        {    
            $addBrand = "insert into brand (brand) values ('$newBrand');"; 
            $dbh->query($addBrand) or die ("SQL Error in:<br> $addBrand <br>Error message:".$dbh->errorInfo()[2]);
        }
        
        if($colors->rowCount() > 0)
        {}
        else
        {    
            $addColor = "insert into color (color) values ('$newColor');";
            $dbh->query($addColor) or die ("SQL Error in:<br> $addColor <br>Error message:".$dbh->errorInfo()[2]);
        }
        
        $idBrand = "SELECT id_brand, brand FROM brand WHERE brand = '$newBrand';";
        $rechercheidBrands = $dbh->query($idBrand) or die ("SQL Error in:<br> $idBrand <br>Error message:".$dbh->errorInfo()[2]);
        $rechercheidBrand = $rechercheidBrands->fetch(); //fetch = aller chercher
        extract($rechercheidBrand);
        
        $idColor = "SELECT id_color, color FROM color WHERE color = '$newColor';";
        $rechercheidColors = $dbh->query($idColor) or die ("SQL Error in:<br> $idColor <br>Error message:".$dbh->errorInfo()[2]);
        $rechercheidColor = $rechercheidColors->fetch(); //fetch = aller chercher
        extract($rechercheidColor);
        
        if($models->rowCount() > 0)
        {}
        else
        {
            $addModel = "insert into model (model_name, model_prix, fk_typearticle, fk_brand) values ('$newModel', '$newPrix', '$typeArticle', '$id_brand');";
            $dbh->query($addModel) or die ("SQL Error in:<br> $addModel <br>Error message:".$dbh->errorInfo()[2]);
        }
        
        $idModel = "SELECT id_model, model_name FROM model WHERE model_name = '$newModel';";
        $rechercheidModels = $dbh->query($idModel) or die ("SQL Error in:<br> $idModel <br>Error message:".$dbh->errorInfo()[2]);
        $rechercheidModel = $rechercheidModels->fetch(); //fetch = aller chercher
        extract($rechercheidModel);

        if(isset($_FILES['illustration']) || isset($_FILES['illustration1']) || isset($_FILES['illustration2']))
        {    
            @$Extension = pathinfo($_FILES['illustration']['name'], PATHINFO_EXTENSION);
            @$illustration = $_FILES['illustration']['name'];
            
            @$Extension1 = pathinfo($_FILES['illustration1']['name'], PATHINFO_EXTENSION);
            @$illustration1 = $_FILES['illustration1']['name']; 
            
            @$Extension2 = pathinfo($_FILES['illustration2']['name'], PATHINFO_EXTENSION);
            @$illustration2 = $_FILES['illustration2']['name']; 

            $addArticle = "INSERT INTO article (quantity, illustration, illustration1, illustration2, fk_color, fk_size, fk_model) VALUES ('$newQuantity', '$illustration', '$illustration1', '$illustration2', '$id_color', '$taille', '$id_model');";
            $dbh->query($addArticle) or die ("SQL Error in:<br> $addArticle <br>Error message:".$dbh->errorInfo()[2]);
        }           
    }
    ?>
	

	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(images/connexion.jpg);">
		<h2 class="l-text2 t-center">
			<font color="black"> Ajouter un article </font>
		</h2>
	</section>

	<!-- Cart -->
	<section class="cart bgwhite p-t-70 p-b-100">
		<div class="container">
            <?php
                echo "
                    <div class='row'>
                        <div class='col-md-3 p-b-30'></div>
                        <div class='col-md-6 p-b-30'>
                            <form method='post' class='leave-comment' enctype='multipart/form-data'>
                                Première illustration: <input type='file' name='illustration' style='margin-bottom: 15px;'><br>
                                Deuxième illustration: <input type='file' name='illustration1' style='margin-bottom: 15px;'><br>
                                Troisième illustration: <input type='file' name='illustration2'><br><br>
                                
                                <div class='bo4 of-hidden size15 m-b-20'>
                                    <input class='sizefull s-text7 p-l-22 p-r-22' type='text' name='newBrand' placeholder='Entrer la marque' required>
                                </div>

                                <div class='bo4 of-hidden size15 m-b-20'>
                                    <input class='sizefull s-text7 p-l-22 p-r-22' type='text' name='newModel' placeholder='Entrer le modèle'>
                                </div>
                                
                                Taille <br>
                                <select name='taille' id='taille' style='padding-right: 175px; margin-top: 10px; margin-bottom: 15px;'/>";
                                    $query = "SELECT id_size, size FROM size;";
                                    $sizes = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
                                    while($size = $sizes->fetch()) //fetch = aller chercher
                                    {
                                        extract($size); //$id_size, $size
                                        echo "<option value='$id_size'>$size</option>";   
                                    }
                                echo"
                                </select><br>
                                
                                Type d'article <br>
                                <select name='typeArticle' id='typeArticle' style='padding-right: 150px; margin-top: 10px; margin-bottom: 15px;'/>";
                                    $query = "SELECT id_typeArticle, typeArticle FROM typearticle;";
                                    $sizes = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
                                    while($size = $sizes->fetch()) //fetch = aller chercher
                                    {
                                        extract($size); //$id_typeArticle, $typeArticle
                                        echo "<option value='$id_typeArticle'>$typeArticle</option>";   
                                    }
                                echo"
                                </select>


                                <div class='bo4 of-hidden size15 m-b-20'>
                                    <input class='sizefull s-text7 p-l-22 p-r-22' type='text' name='newPrix' placeholder='Entrer le prix'>
                                </div>
                                
                                <div class='bo4 of-hidden size15 m-b-20'>
                                    <input class='sizefull s-text7 p-l-22 p-r-22' type='text' name='newColor' placeholder='Entrer la couleur'>
                                </div>
                                
                                <div class='bo4 of-hidden size15 m-b-20'>
                                    <input class='sizefull s-text7 p-l-22 p-r-22' type='text' name='newQuantity' placeholder='Entrer la quantité'>
                                </div>
                                
                                <div class='w-size25'>
                                    <!-- Button -->
                                    <button class='flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4' name='create'>
                                        Envoyer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>";
            ?>
		</div>
	</section>
    <?php require_once('footer.php'); ?>
</body>
</html>
