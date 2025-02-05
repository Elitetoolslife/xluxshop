<?php

/**
 * Setup script for creating required directories and files
 */

$directories = [
    "xlux/application/config",
    "xlux/application/controllers",
    "xlux/application/helpers",
    "xlux/application/libraries",
    "xlux/application/models",
    "xlux/application/views",
    "xlux/bootstrap",
    "xlux/system/core"
];

$files = [
    // Configuration files
    "xlux/application/config/AutoLoadConfig.php" => "<?php // Autoload configuration",
    "xlux/application/config/app.php" => "<?php return ['name' => 'Xluxshop'];",
    "xlux/application/config/constants.php" => "<?php define('BASE_URL', '/xlux/');",

    // Database Configuration with .env support
    "xlux/application/config/database.php" => "<?php 
    require_once __DIR__.'/../../vendor/autoload.php';
    \$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
    \$dotenv->load();
    \$dbcon = mysqli_connect(\$_ENV['DB_HOST'], \$_ENV['DB_USER'], \$_ENV['DB_PASS'], \$_ENV['DB_NAME']);
    if (!\$dbcon) { die('Connection failed: ' . mysqli_connect_error()); }",

    // Controllers
    "xlux/application/controllers/BaseController.php" => "<?php namespace Xluxshop\\Controllers; class BaseController { protected function view(\$view, \$data = []) { extract(\$data); require \"../application/views/\$view.php\"; } }",
    "xlux/application/controllers/PageController.php" => "<?php namespace Xluxshop\\Controllers; class PageController extends BaseController { public function index() { \$this->view('home', ['title' => 'Home Page']); } }",

    // Helpers
    "xlux/application/helpers/auth.php" => "<?php // Auth helper",
    "xlux/application/helpers/url.php" => "<?php function base_url(\$path = '') { return BASE_URL . \$path; }",
    
    // Models
    "xlux/application/models/User.php" => "<?php namespace Xluxshop\\Models; class User { }",

    // Views
    "xlux/application/views/home.php" => "<!DOCTYPE html><html><head><title><?php echo \$title; ?></title></head><body><h1>Welcome to Xluxshop!</h1></body></html>",

    // Core System Files
    "xlux/system/core/Controller.php" => "<?php namespace Xluxshop\\Core; class Controller { }",
    "xlux/system/core/Model.php" => "<?php namespace Xluxshop\\Core; class Model { }",
    "xlux/system/core/Database.php" => "<?php namespace Xluxshop\\Core; class Database { }",
    "xlux/system/core/View.php" => "<?php namespace Xluxshop\\Core; class View { public static function render(\$view, \$data = []) { extract(\$data); require \"../application/views/\$view.php\"; } }",
    "xlux/system/core/Router.php" => "<?php namespace Xluxshop\\Core; class Router { public static function route() { \$controller = new \\Xluxshop\\Controllers\\PageController(); \$controller->index(); } }",

    // .env file (Environment Variables)
    ".env" => "DB_HOST=localhost\nDB_USER=artmir\nDB_PASS=Omeri1233\nDB_NAME=artmir",

    // Bootstrap file
    "xlux/bootstrap/autoload.php" => "<?php require_once __DIR__.'/../vendor/autoload.php';",

    // Main index.php with routing and database connection
    "index.php" => "<?php
    require_once 'vendor/autoload.php';
    require_once 'xlux/application/config/database.php';
    use Xluxshop\\Core\\Router;
    Router::route();"
];

// Create directories if they don't exist
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
        echo "Created directory: $dir\n";
    }
}

// Create files if they don't exist
foreach ($files as $file => $content) {
    if (!file_exists($file)) {
        file_put_contents($file, $content);
        echo "Created file: $file\n";
    }
}

echo "Setup completed successfully!\n";