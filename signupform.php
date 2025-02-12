<?php
require 'vendor/autoload.php';
require 'blade.php';
require 'Controllers/SignupController.php';

use App\Controllers\SignupController;

$signupController = new SignupController($dbcon, $blade);
$signupController->handleSignup();
?>