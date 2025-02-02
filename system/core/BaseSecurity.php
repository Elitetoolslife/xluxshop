<?php
/**
 * BaseSecurity Class
 *
 * A security class for the application.
 */

class BaseSecurity {
    public $filename_bad_chars = array(
        '../', '<!--', '-->', '<', '>',
        "'", '"', '&', '$', '#',
        '{', '}', '[', ']', '=',
        ';', '?', '%20', '%22',
        '%3c', '%253c', '%3e', '%0e',
        '%28', '%29', '%2528', '%26',
        '%24', '%3f', '%3b', '%3d'
    );

    public $charset = 'UTF-8';
    protected $_xss_hash;
    protected $_csrf_hash;
    protected $_csrf_expire = 7200;
    protected $_csrf_token_name = 'csrf_token';
    protected $_csrf_cookie_name = 'csrf_token';
    protected $_never_allowed_str = array(
        'document.cookie' => '[removed]',
        '(document).cookie' => '[removed]',
        'document.write' => '[removed]',
        '(document).write' => '[removed]',
        '.parentNode' => '[removed]',
        '.innerHTML' => '[removed]',
        '-moz-binding' => '[removed]',
        '<!--' => '&lt;!--',
        '-->' => '--&gt;',
        '<![CDATA[' => '&lt;![CDATA[',
        '<comment>' => '&lt;comment&gt;',
        '<%' => '&lt;&#37;'
    );

    protected $_never_allowed_regex = array(
        'javascript\s*:',
        '(\(?document\)?|\(?window\)?(\.document)?)\.(location|on\w*)',
        'expression\s*(\(|&\#40;)',
        'vbscript\s*:',
        'wscript\s*:',
        'jscript\s*:',
        'vbs\s*:',
        'Redirect\s+30\d',
        "([\"'])?data\s*:[^\\1]*?base64[^\\1]*?,[^\\1]*?\\1?"
    );

    public function __construct() {
        $this->charset = strtoupper('UTF-8');
        $this->_csrf_set_hash();
    }

    public function csrf_verify() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->csrf_set_cookie();
        }

        $valid = isset($_POST[$this->_csrf_token_name], $_COOKIE[$this->_csrf_cookie_name]) &&
                 hash_equals($_POST[$this->_csrf_token_name], $_COOKIE[$this->_csrf_cookie_name]);

        unset($_POST[$this->_csrf_token_name]);

        if ($valid !== TRUE) {
            $this->csrf_show_error();
        }

        $this->_csrf_set_hash();
        $this->csrf_set_cookie();
        return $this;
    }

    public function csrf_set_cookie() {
        $expire = time() + $this->_csrf_expire;
        setcookie($this->_csrf_cookie_name, $this->_csrf_hash, $expire, '/', '', false, true);
        return $this;
    }

    public function csrf_show_error() {
        die('The action you have requested is not allowed.');
    }

    public function get_csrf_hash() {
        return $this->_csrf_hash;
    }

    public function get_csrf_token_name() {
        return $this->_csrf_token_name;
    }

    public function xss_clean($str, $is_image = FALSE) {
        if (is_array($str)) {
            foreach ($str as $key => &$value) {
                $str[$key] = $this->xss_clean($value);
            }
            return $str;
        }

        $str = remove_invisible_characters($str);
        $str = rawurldecode($str);
        $str = preg_replace_callback('/[a-z]+=([\'"]).*?\\1/si', array($this, '_convert_attribute'), $str);
        $str = preg_replace_callback('/<\w+.*/si', array($this, '_decode_entity'), $str);
        $str = str_replace("\t", ' ', $str);
        $converted_string = $str;
        $str = $this->_do_never_allowed($str);
        $str = str_replace(array('<?', '?'.'>'), array('&lt;?', '?&gt;'), $str);
        return $str;
    }

    protected function _convert_attribute($match) {
        return str_replace(array('>', '<', '\\'), array('&gt;', '&lt;', '\\\\'), $match[0]);
    }

    protected function _decode_entity($match) {
        $match = preg_replace('|\&([a-z\_0-9\-]+)\=([a-z\_0-9\-/]+)|i', $this->xss_hash().'\\1=\\2', $match[0]);
        return str_replace($this->xss_hash(), '&', html_entity_decode($match, ENT_COMPAT, 'UTF-8'));
    }

    protected function _do_never_allowed($str) {
        $str = str_replace(array_keys($this->_never_allowed_str), $this->_never_allowed_str, $str);
        foreach ($this->_never_allowed_regex as $regex) {
            $str = preg_replace('#'.$regex.'#is', '[removed]', $str);
        }
        return $str;
    }

    protected function _csrf_set_hash() {
        if ($this->_csrf_hash === NULL) {
            $rand = bin2hex(random_bytes(16));
            $this->_csrf_hash = $rand;
        }
        return $this->_csrf_hash;
    }
}
?>