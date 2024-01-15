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
        
        $servername = "localhost";
        $username = "root";
        $passwordBDD = "";
        $database = "classes";
        
        



        $mysqli = new mysqli($servername, $username, $passwordBDD, $database);

        $mysqli ->query("INSERT INTO `utilisateurs` (`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
        return $mysqli;
    }

    public function connect($login , $password) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "classes";


        $login = $_POST['login'];
        $password = $_POST['password'];

        $mysqli = new mysqli($servername, $username, $password, $database);

        $mysqli ->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        return $mysqli;

    }

    public function disconnect() {
        session_destroy();
    }

    public function delete() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "classes";

        $login = $_SESSION['login'];
        $password = $_SESSION['password'];

        $mysqli = new mysqli($servername, $username, $password, $database);

        $mysqli ->query("DELETE FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
    }

    public function update($login ,$password ,$email , $firstname , $lastname){
        $servername = "localhost";
        $username = "root";
        $passwordBDD = "";
        $database = "classes";

        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $mysqli = new mysqli($servername, $username, $passwordBDD, $database);

        $mysqli2 = new mysqli($servername, $username, $passwordBDD, $database);

        $id = $mysqli2 ->query("SELECT 'id' FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");


        $mysqli ->query("UPDATE `utilisateurs` SET `login` = '$login', `password` = '$password', `email` = '$email', `firstname` = '$firstname', `lastname` = '$lastname' WHERE `utilisateurs`.`id` = $id");

    }

    public function isConnected() {
        if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllInfos() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "classes";

        $login = $_SESSION['login'];
        $password = $_SESSION['password'];


        $mysqli = new mysqli($servername, $username, $password, $database);

        $mysqli ->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        
        return $mysqli;
    }

    public function getLogin(){
        $login = $_SESSION['login'];
        return $login;
    }

    public function getEmail(){
        $email = $_SESSION['email'];
        return $email;
    }
    public function getFirstname(){
        $firstname = $_SESSION['firstname'];
        return $firstname;
    }
    public function getLastname(){
        $lastname = $_SESSION['lastname'];
        return $lastname;
    }
}
$login = $_POST['login'];
$password = $_POST['password'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

$user = new User($login, $password, $email, $firstname, $lastname);
echo $user->register($login, $email, $firstname, $lastname , $password);
echo $user->connect($login , $password);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <foùrm method="post">
        <input type="text" name="login" placeholder="login">
        <input type="password" name="password" placeholder="password">
        <input type="email" name="email" placeholder="email">
        <input type="text" name="firstname" placeholder="firstname">
        <input type="text" name="lastname" placeholder="lastname">
        <input type="submit" name="submit" value="submit">
</body>
</html>