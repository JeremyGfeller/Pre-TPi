<?php
@session_start();
extract($_SESSION);
//Connection base de donnée
function ConnectDB()
{
    // Toutes les infos nécessaires pour la connexion à une base de donnée
    $hostname = 'localhost';
    $dbname = 'zira';
    $username = 'root';
    $password = '';

    // PDO = Persistant Data Object
    // Entre "" = Connection String
    $connectionString = "mysql:host=$hostname; dbname=$dbname";

    global $dbh; 

    try
    {
        $dbh = new PDO($connectionString, $username, $password);
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $dbh->exec("SET NAMES UTF8");
    }
    catch(PDOException $e)
    {
        die("Erreur de connexion au serveur (".$e->getMessage().")");
    }
}

function panier()
{
    global $dbh;
    extract($_SESSION);
    $sum = "";
    if(isset($IDPersonne))
    {
        $query = "select sum(quantity) as somme from orderlist where fk_basket = $IDPersonne;";
        $sumArticles = $dbh->query($query) or die ("SQL Error in:<br> $query <br>Error message:".$dbh->errorInfo()[2]);
        if ($sumArticles->rowCount() > 0)
        {
            $sumArticle = $sumArticles->fetch();
            extract($sumArticle);
            if($somme > 0)
            {
                $sum .= "$somme";
            }
            else
            {
                $sum .= "0";                
            }
        }
    }
    return $sum;
}

if(isset($_POST['deconnexion']))
{
    unset($_SESSION['IDPersonne']);
    unset($_SESSION['UserName']);
}

function afficherLogin()
{
    extract($_SESSION);
    $login = "";
    if(isset($_SESSION['UserName']))
    {
        $login .= "Connecté en tant que: $UserName";
    }
    else
    {
        $login .= "Pas connecté";
    }  
    return $login;    
}

function loginBox()
{
    global $dbh; 
    extract($_SESSION);
    $login = "";
    if(isset($_SESSION['IDPersonne']))
    {
        $login .= "Bonjour $UserName <br><br>
                <form method='post'>
                    <input type='submit' name='deconnexion' value='Deconnexion'> 
                </form>";
    }
    else
    {
        $login .= "<form method='post'>
                    <input type='text' name='login' placeholder='Entrez votre login' required><br><br>
                    <input type='password' name='password' placeholder='Entrez votre mot de passe' required><br><br>
                    <input type='submit' value='Connexion'>    
                </form>";

        $dbh->quote($login);
    }  
    return $login;    
}

function inscription()
{
    global $dbh; 
    extract($_POST);
    extract($_SESSION);
    $registration = "";
    if(!isset($_SESSION['IDPersonne']))
    {
        $registration .= "<form method='post'>
                <input type='text' name='firstName' placeholder='Entrez votre prénom' required><br><br>
                <input type='text' name='lastName' placeholder='Entrez votre nom de famille' required><br><br>
                <input type='hidden' name='role' value='1' required>
                <input type='text' name='login' placeholder='Entrez votre identifiant' required><br><br>
                <input type='password' name='password' placeholder='Entrez votre mot de passe' required><br><br>
                <input type='submit' value='Inscription'>    
            </form>";

            $dbh->quote($registration);
    }  
    return $registration;
}
?>  