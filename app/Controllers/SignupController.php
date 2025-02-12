<?php

namespace App\Controllers;

use eftec\bladeone\BladeOne;

class SignupController {
    private $dbcon;
    private $blade;

    public function __construct($dbcon, BladeOne $blade) {
        $this->dbcon = $dbcon;
        $this->blade = $blade;
    }

    public function showForm($errorbox = null) {
        echo $this->blade->run("signupform", ["errorbox" => $errorbox]);
    }

    public function handleSignup() {
        ob_start();
        session_start();
        include "includes/config.php";
        include 'encrypt.php';
        date_default_timezone_set('UTC');

        if(isset($_SESSION['sname']) and isset($_SESSION['spass'])){
            header("location: index.html");
            exit();
        }

        if (isset($_POST['username'],$_POST['email'],$_POST['password_signup'],$_POST['password_signup2'])) {
            $uname = mysqli_real_escape_string($this->dbcon, strip_tags($_POST['username']));
            $email = mysqli_real_escape_string($this->dbcon, strip_tags($_POST['email']));
            $pass1 = mysqli_real_escape_string($this->dbcon, strip_tags($_POST['password_signup']));
            $pass2 = mysqli_real_escape_string($this->dbcon, strip_tags($_POST['password_signup2']));
            $ip    = getenv("REMOTE_ADDR");
            $rdate = date("y-m-d");
            $lvisi = date('y-m-d');

            $passstrlen = strlen($pass1);

            $result = mysqli_query($this->dbcon, "SELECT * FROM users WHERE username='".$uname."'");
            $userexist = mysqli_num_rows($result);

            $result = mysqli_query($this->dbcon, "SELECT * FROM users WHERE email='".$email."'");
            $emailexist = mysqli_num_rows($result);

            $errorbox = '';

            if(empty($uname) or empty($email) or empty($pass1) or empty($pass2)){
                $errorbox = "Please check all entries";
            } elseif(strlen($uname) > 16){
                $errorbox = "Username must be less than 16 chars.";
            } elseif($userexist == 1 || $uname == "NONE" || $uname == "NULL" || $uname == "SYSTEM" || $uname == "none" || $uname == "system"){
                header('location:signup.html?error=userexist');
                exit();
            } elseif($emailexist == 1){
                header('location:signup.html?error=emailexist');
                exit();
            } elseif($pass1 != $pass2){
                header('location:signup.html?error=passnotmatch');
                exit();
            } elseif($passstrlen <6 or $passstrlen > 16){
                header('location:signup.html?error=passlength');
                exit();
            } elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i",$email)){
                $errorbox = "Invalid email!";
            } else {
                $password = dec_enc('encrypt',$pass1);
                $insert = mysqli_query($this->dbcon, "INSERT INTO users (username,password,email,balance,ipurchassed,ip,lastlogin,datereg,resseller,img,testemail,resetpin) VALUES ('$uname','$password','$email','0','0','$ip','$lvisi','$rdate','0','','$email',0)") or die(mysqli_error($this->dbcon));
                header('location:login.html?success=register');
                exit();
            }

            $this->showForm($errorbox);
        } else {
            header('location:index.html');
            exit();
        }

        mysqli_close($this->dbcon);
        ob_end_flush();
    }
}