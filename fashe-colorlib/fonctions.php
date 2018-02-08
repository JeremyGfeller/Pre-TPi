<meta charset="utf-8"/>
<?php
@session_start();
extract($_SESSION);
//Connection base de donnée
function ConnectDB()
{
    // Toutes les infos nécessaires pour la connexion à une base de donnée
    $hostname = 'localhost';
    $dbname = 'yonik';
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

function Connexion()
{
    if(isset($_SESSION['UserName']))
    {
        return true;
        echo $UserName;
    }
    else
    {
        return false;  
        echo "Pas connecté";
    }    
}

if(isset($_POST['deconnexion']))
{
    unset($_SESSION['IDPersonne']);
    unset($_SESSION['UserName']);
}

if(isset($_POST['profil']))
{
    header("Location: profil.php");
}

function afficherLogin()
{
    extract($_SESSION);
    $login = "";
    if(isset($_SESSION['UserName']))
    {
        $login .= "$UserName";
    }
    else
    {
        $login .= "Pas connecté";
    }  
    return $login;    
}

function LoginBox()
{
    extract($_SESSION);
    $res = "";
    if(isset($_SESSION['IDPersonne']))
    {
        //echo "$IDPersonne $UserName";
        //echo "<br><a href='CRUD.php?deconnexion'> Deconnexion </a>";
        $res .= "$UserName($IDPersonne)
                <form method='post'>
                    <input type='submit' name='deconnexion' value='Deconnexion'> 
                </form>";
    }
    else
    {
        $res .= "<form method='post'>
                    Nom: <input type='text' name='login'><br>
                    Password: <input type='password' name='password'><br>
                    <input type='submit' value='Connexion'>    
                </form>";
    }  
    return $res;    
}
?>