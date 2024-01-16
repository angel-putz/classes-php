<?php
session_start();
$login = $_POST['login'];
$password = $_POST['password'];
$email = $_POST['email'];

$_SESSION['login'] = $login;
include "database.php";

class User {
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    private $password;
    public $servername;
    public $username;
    public $passwordBDD;
    public $database;

    public function __construct($login, $password, $email, $firstname, $lastname) {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->servername = "localhost";
        $this->username = "root";
        $this->passwordBDD = "";
        $this->database = "classes";
    }

    public function register($login, $email, $firstname, $lastname , $password) {

        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $mysqli->query("INSERT INTO `utilisateurs` (`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
        
        echo "Vous êtes inscrit !";
    }

    public function connect($login , $password) {
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $result = $mysqli->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;

        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $this->login = $user['login'];
            $this->password = $user['password'];
            $this->email = $user['email'];
            $this->firstname = $user['firstname'];
            $this->lastname = $user['lastname'];
            echo "Vous êtes connecté ! Bienvenue " . $this->firstname . " " . $this->lastname . " !";
            return true;
        } else {
            echo "Erreur de connexion !";
            return false;
        }
    }

    public function disconnect() {
        session_destroy();
        echo "Vous êtes déconnecté !";
    }

    public function delete() {
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $login = $_POST['login'];
        $password = $_POST['password'];
        $mysqli->query("DELETE FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        //$mysqli->query("DELETE FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        echo "Votre compte a été supprimé !";
    }

    public function update($login ,$password ,$email , $firstname , $lastname ,$login2 ,$password2){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $mysqli2 = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $id = $mysqli2->query("SELECT 'id' FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
       // $mysqli->query("UPDATE `utilisateurs` SET `login` = '2', `password` = '2', `email` = '2', `firstname` = '2', `lastname` = '2' WHERE `utilisateurs`.`id` = '7'");
        $mysqli->query("UPDATE `utilisateurs` SET `login` = '$login2', `password` = '$password2', `email` = '$email', `firstname` = '$firstname', `lastname` = '$lastname' WHERE `utilisateurs`.`id` = $id");
        echo "Votre compte a été mis à jour !";
    }

    public function isConnected() {

        if (isset($_SESSION['login'])) {
            echo "Vous êtes connecté !";
            return true;
        } else {
            echo "Vous n'êtes pas connecté !";
            return false;
        }
    }

    public function getAllInfos($login , $password) {
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $result = $mysqli->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "Voici vos informations !", "<br>" ;
            echo "Login: " . $user['login'] , "<br>" ;
            echo "Email: " . $user['email'], "<br>" ;
            echo "Firstname: " . $user['firstname'], "<br>" ;
            echo "Lastname: " . $user['lastname'], "<br>" ;
        } else {
            echo "Aucun utilisateur trouvé avec ce login et ce mot de passe.";
        }
    }

    public function getLogin($email){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $result = $mysqli->query("SELECT * FROM `utilisateurs` WHERE `email` = '$email'");
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "Voici vos login !", "<br>" ;
            echo "Login: " . $user['login'] , "<br>" ;
        } else {
            echo "Aucun utilisateur trouvé";
        }
    }

    public function getEmail($login){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $result = $mysqli->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login'");
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "Voici vos informations !", "<br>" ;
            echo "Email: " . $user['email'], "<br>" ;
        } else {
            echo "Aucun utilisateur trouvé";
        }
    }
    public function getFirstname($login){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $result = $mysqli->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login'");
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "Voici vos informations !", "<br>" ;
            echo "Firstname: " . $user['firstname'], "<br>" ;
        } else {
            echo "Aucun utilisateur trouvé";
        }
    }
    public function getLastname($login){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $result = $mysqli->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login'");
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "Voici vos informations !", "<br>" ;
            echo "Lastname: " . $user['lastname'], "<br>" ;
        } else {
            echo "Aucun utilisateur trouvé";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $user = new User($login, $password, $email, $firstname, $lastname);  
   // $user->register($login, $email, $firstname, $lastname , $password); 
   // $user->connect($login , $password);
    //$user->update($login ,$password ,$email , $firstname , $lastname);
    //$user->disconnect();
 //   $user->delete();
    //$user->update(2 ,2 ,2, 2 , 2);
   // $user->isConnected();
   // $user->getAllInfos($login , $password);
   // $user->getLogin($email);
  //  $user->getEmail($login);
    //$user->getFirstname($login);
    //$user->getLastname($login);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <input type="text" name="login" placeholder="login">
        <input type="password" name="password" placeholder="password">
        <input type="text" name="email" placeholder="email">
        <input type="text" name="firstname" placeholder="firstname">
        <input type="text" name="lastname" placeholder="lastname">
        <input type="submit" name="submit" value="submit">
    </form>
</body>
</html>
