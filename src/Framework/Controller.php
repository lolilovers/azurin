<?php

/**
 * ===========================
 * Base Controller
 * ===========================
 */

namespace Src\Framework;

class Controller
{
    public function __construct(
        private $sessionState = false,
        protected $view = '',
        protected $viewData = [],
        protected $viewEngine = true,
        protected $model = '',
        protected $cache = ''
    ){}

    // Renderer service
    public function view($view, $data = [], $viewEngine = true)
    {
        // View path
        $viewPath   = SRCPATH . 'Views/';
        $cachePath  = SRCPATH . 'Storage/cache/';

        // Save data
        if(! empty($data)) {
            if(is_array($data)) {
                $this->viewData = $data;
                unset($data);
            }
        }
        else {
            $this->viewData = [];
        }
        $this->viewEngine = $viewEngine;
        unset($viewEngine);
        
        // Render with twig
        if($this->viewEngine) {
            $twigLoader = new \Twig\Loader\FilesystemLoader($viewPath);
            $twig   = new \Twig\Environment($twigLoader);
            ob_start();
            echo $twig->render($view . '.html', $this->viewData);
            $this->view = ob_get_contents();
            ob_end_clean();
        }
        // Render without twig
        else {
            ob_start();
            include $viewPath . $view . '.html';
            $this->view = ob_get_contents();
            ob_end_clean();
        }
        
        // Save rendered view
        if ($view == $this->cache) {
            $cacheName      = CACHE_PREFIX . '_' . md5($view) . '.html';
            $cacheFile      = $cachePath . $cacheName;
            $cacheFactory   = fopen($cacheFile, 'w');
            fwrite($cacheFactory, $this->view);
            fclose($cacheFactory);
        }
        
        // Return rendered view
        return $this->view;
    }

    // Cache service
    public function cache($cache = '', $expire = CACHE_DEFAULT_EXPIRE)
    {
        // Cache file
        $this->cache    = $cache;
        $cacheName      = CACHE_PREFIX . '_' . md5($cache) . '.html';
        $cachePath      = SRCPATH.'/Storage/cache/'.$cacheName;
        // Check cache
        if (file_exists($cachePath) && (time() - $expire < filemtime($cachePath))) {
            // Load cache and stop execution
            require_once($cachePath);
            exit();
        }
    }

    // View extender
    public function merge($view)
    {
        return $this->view($view, $this->viewData, $this->viewEngine);
    }
    
    // Model loader
    public function model($model)
    {
        $model          = 'Src\Models\\'.$model;
        $this->model    = new $model;
        return $this->model;
    }
    
    // Redirect
    public function redirect($redirect)
    {
        return header('Location: ' . URL . $redirect);
    }
    
    // Session service
    public function session($type , $id = '', $data = '')
    {
        // Start the session
        if(! $this->sessionState) {
            ini_set('session.save_path', SRCPATH . '/Storage/session');
            session_start();
            $this->sessionState = true;
        }
        // Destroy
        if($type == 'destroy') {
            // Destroy session
            return session_destroy();
        }
        // Set
        else if($type == 'set') {
            // Set data
            return $_SESSION[$id] = $data;
        }
        // Get
        else if($type == 'get') {
            if(! empty($_SESSION[$id])) {
                // Get data
                $data   = $_SESSION[$id];    
                return $data;
            }
        }
    }

    // Form action service
    public function get($var)
    {
        // GET & POST in same time
        if (! empty($_GET[$var]) && ! empty($_POST[$var])) {
            $var = [
                'get'   => $_GET[$var],
                'post'  => $_POST[$var]
            ];
        }
        // GET
        else if (! empty($_GET[$var])) {
            $var = $_GET[$var];
        }
        // POST
        else if (! empty($_POST[$var])) {
            $var = $_POST[$var];
        }
        // NULL
        else {
            $var = null;
        }
        // Return
        return $var;
    }

    // Response JSON data
    public function json($data = '')
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // Encryption service
    public function encryption($type, $rawData)
    {
        // Key
        $key = ENCRYPTION_KEY;

        // Encrypt
        if($type == 'encrypt') {
            $plaintext = $rawData;
            $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
            $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
            // Encrypted data
            $data = $ciphertext;
        }

        // Decrypt
        else if ($type == 'decrypt') {
            $c = base64_decode($rawData);
            $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
            $iv = substr($c, 0, $ivlen);
            $hmac = substr($c, $ivlen, $sha2len=32);
            $ciphertext_raw = substr($c, $ivlen+$sha2len);
            $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
            $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
            if (hash_equals($hmac, $calcmac)) {
                // Match
                $data = $original_plaintext;
            }
            else {
                // Not match
                $data = null;
            }
        }
        else {
            // Set null
            $data = null;
        }

        // Return processed data
        return $data;
    }
}