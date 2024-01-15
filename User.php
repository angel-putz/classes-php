<?php
session_start();
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
        return $mysqli;
        echo "Vous êtes inscrit !";
    }

    public function connect($login , $password) {
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $mysqli->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        echo "Vous êtes connecté !";
        return $mysqli;
    }

    public function disconnect() {
        session_unset();
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

    public function update($login ,$password ,$email , $firstname , $lastname){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $mysqli2 = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $id = $mysqli2->query("SELECT 'id' FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
       // $mysqli->query("UPDATE `utilisateurs` SET `login` = '2', `password` = '2', `email` = '2', `firstname` = '2', `lastname` = '2' WHERE `utilisateurs`.`id` = '7'");
        $mysqli->query("UPDATE `utilisateurs` SET `login` = '$login', `password` = '$password', `email` = '$email', `firstname` = '$firstname', `lastname` = '$lastname' WHERE `utilisateurs`.`id` = $id");
        var_dump($mysqli);
        echo "Votre compte a été mis à jour !";
    }

    public function isConnected() {
        if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllInfos($login , $password) {
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $mysqli->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        echo "Voici vos informations !" . $mysqli;
    }

    public function getLogin($email){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $login=$mysqli->query("SELECT 'login' FROM `utilisateurs` WHERE `email` = '$email'");
        echo "Voici votre login ! " . $login;
    }

    public function getEmail($login){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $email=$mysqli->query("SELECT 'email' FROM `utilisateurs` WHERE `login` = '$login''");

        echo "Voici votre email !" . $email;
    }
    public function getFirstname($login){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $firstname=$mysqli->query("SELECT 'firstname' FROM `utilisateurs` WHERE `login` = '$login''");

        echo "Voici votre prénom !". $firstname;
    }
    public function getLastname($login){
        $mysqli = new mysqli($this->servername, $this->username, $this->passwordBDD, $this->database);
        $lastname=$mysqli->query("SELECT 'lastname' FROM `utilisateurs` WHERE `login` = '$login''");
        echo "Voici votre nom !" . $lastname;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $user = new User($login, $password, $email, $firstname, $lastname);
  //  $user->register($login, $email, $firstname, $lastname , $password);
   // $user->connect($login , $password);
   // $user->connect(2 , 2);
    //$user->disconnect();
 //   $user->delete();
    //$user->update(2 ,2 ,2, 2 , 2);
    //$user->isConnected();
   // $user->getAllInfos();
    $user->getLogin(2);
  //  $user->getEmail($email);
    //$user->getFirstname();
    //$user->getLastname();
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
        <input type="email" name="email" placeholder="email">
        <input type="text" name="firstname" placeholder="firstname">
        <input type="text" name="lastname" placeholder="lastname">
        <input type="submit" name="submit" value="submit">
    </form>
</body>
</html>
