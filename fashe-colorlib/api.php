<?php
    header("Access-Control-Allow-Origin: *");
    require_once('fonctions.php');
    ConnectDB();
    extract($_GET);

    //echo "action = $action, id = $id";

    $query = "SELECT quantity FROM article WHERE id_article = $id;";
    $quantitys = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);

    while($quantity = $quantitys->fetch()) //fetch = aller chercher
    {
        extract($quantity);  
        
        echo json_encode($quantity);
        //echo "<br>La quantité pour l'article : $id est de $quantity";
    }
?>