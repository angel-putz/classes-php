<?php
session_start();
$login = $_POST['login'];
$password = $_POST['password'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$login2 = "422";
$password2 = "422";

$_SESSION['login'] = $login;


class Userpdo {
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    private $password;
    public $servername;
    public $username;
    public $passwordBDD;
    public $BDD;
    public $conn;

    public function __construct($login, $password, $email, $firstname, $lastname) {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->servername = "localhost";
        $this->username = "root";
        $this->passwordBDD = "";
        $this->BDD = "classes";
        $this->conn = null;
    }

    public function register($login, $email, $firstname, $lastname , $password) {
        $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
        $pdo->query("INSERT INTO `utilisateurs` (`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");

        
        echo "Vous êtes inscrit !";
    }

    public function connect($login , $password) {
        $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
        $result = $pdo->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;


        
        if ($result->rowCount() > 0) {
            $user = $result->fetch(PDO::FETCH_ASSOC);
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

    public function delete($login, $password) {
        $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
        $result = $pdo->query("DELETE FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        echo "Votre compte a été supprimé !";
    }

    public function update($login, $password, $email, $firstname, $lastname , $login2, $password2) {
            $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
            $stmt = $pdo->prepare("SELECT `id` FROM `utilisateurs` WHERE `login` = :login AND `password` = :password");
            $stmt->execute([':login' => $login, ':password' => $password]);
            $user = $stmt->fetch();


            if ($user) {
                $stmt = $pdo->prepare("UPDATE `utilisateurs` SET `login` = :login, `password` = :password, `email` = :email, `firstname` = :firstname, `lastname` = :lastname WHERE `id` = :id");
                $stmt->execute([':login' => $login2, ':password' => $password2, ':email' => $email, ':firstname' => $firstname, ':lastname' => $lastname, ':id' => $user['id']]);
                echo "Votre compte a été mis à jour !";
                $this->id = $user['id'];
                $this->login = $login;
                $this->password = $password;
                $this->email = $email;
                $this->firstname = $firstname;
                $this->lastname = $lastname;
            } else {
                echo "Aucun utilisateur trouvé avec ce login et ce mot de passe.";
            }
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
        $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
        $result = $pdo->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login' AND `password` = '$password'");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        echo "Voici vos informations !", "<br>" ;
        echo "Login: " . $user['login'] , "<br>" ;
        echo "Email: " . $user['email'], "<br>" ;
        echo "Firstname: " . $user['firstname'], "<br>" ;
        echo "Lastname: " . $user['lastname'], "<br>" ;
    }

    public function getLogin($email) {
        $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
        $result = $pdo->query("SELECT * FROM `utilisateurs` WHERE `email` = '$email'");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        echo "Voici vos informations !", "<br>" ;
        echo "Login: " . $user['login'] , "<br>" ;
    }

    public function getEmail($login) {
        $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
        $result = $pdo->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login'");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        echo "Voici vos informations !", "<br>" ;
        echo "Email: " . $user['email'], "<br>" ;
    }

    public function getFirstname($login) {
        $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
        $result = $pdo->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login'");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        echo "Voici vos informations !", "<br>" ;
        echo "Firstname: " . $user['firstname'], "<br>" ;
    }

    public function getLastname($login) {
        $pdo = new PDO("mysql:host=localhost;dbname=classes", "root", "");
        $result = $pdo->query("SELECT * FROM `utilisateurs` WHERE `login` = '$login'");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        echo "Voici vos informations !", "<br>" ;
        echo "Lastname: " . $user['lastname'], "<br>" ;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $user = new Userpdo($login, $password, $email, $firstname, $lastname);
    //$user->register($login, $email, $firstname, $lastname , $password);
    //$user->connect($login, $password);
    //$user->isConnected();
    //$user->getAllInfos($login, $password);
    //$user->getLogin($email);
    //$user->getEmail($login);
    //$user->getFirstname($login);
    //$user->getLastname($login);
    //$user->disconnect();
    //$user->delete($login, $password);
    $user->update($login, $password, $email, $firstname, $lastname , $login2, $password2);
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