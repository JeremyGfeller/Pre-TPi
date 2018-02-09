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
        $login .= "Connecté en tant que : $UserName";
    }
    else
    {
        $login .= "Pas connecté";
    }  
    return $login;    
}

function loginBox()
{
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
    }  
    return $login;    
}

function inscription()
{
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
    }  
    return $registration;
}
?>





