<?php

class BaseURI {
    private static $config;
    private $uri_string = '';
    private $segments = [];

    public function __construct() {
        $this->loadConfig();
        $this->parseURI();
    }

    private function loadConfig() {
        if (self::$config === null) {
            self::$config = include __DIR__ . '/../config.php';
        }
    }

    private function parseURI() {
        $this->uri_string = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $this->uri_string = trim($this->uri_string, '/');
        $this->segments = explode('/', $this->uri_string);
    }

    public static function base_url($path = '') {
        self::loadConfig();
        return self::$config['base_url'] . ltrim($path, '/');
    }

    public function segment($index) {
        return isset($this->segments[$index]) ? $this->segments[$index] : null;
    }

    public function uri_string() {
        return $this->uri_string;
    }

    public function segment_array() {
        return $this->segments;
    }
}

// Example usage:
$uri = new BaseURI();
echo $uri->base_url('path/to/your/resource');
echo $uri->segment(1);
print_r($uri->segment_array());
?>