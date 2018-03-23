<?php
    header("Access-Control-Allow-Origin: *");
    require_once('fonctions.php');
    ConnectDB();
    extract($_GET);

    $query = "SELECT id_article, illustration, quantity, brand, model_name, model_prix, size, color FROM article
                inner join model on fk_model = id_model
                inner join size on fk_size = id_size
                inner join color on fk_color = id_color
                inner join brand on fk_brand = id_brand
                where id_article = $id;";
                
    $quantitys = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

    while($quantity = $quantitys->fetch()) //fetch = aller chercher
    {
        extract($quantity); // $id_article, $illustration, $quantity, $brand, $model_name, $model_prix, $size, $color
        
        $arr = array('id_article' => $id_article, 'illustration' => $illustration, 'quantity' => $quantity, 'brand' => $brand, 'model_name' => $model_name, 'model_prix' => $model_prix, 'size' => $size, 'color' => $color);

        echo json_encode($arr);
    }
?>