<?php

// ---- Base Controller ----

namespace Azurin\Framework;

use Azurin\Framework\Services\Encryption;
use Azurin\Framework\Services\Session;
use Azurin\Framework\Services\Cookie;
use Azurin\Framework\Services\Output;
use Azurin\Framework\Services\Files;
use Azurin\Framework\Services\Input;
use Azurin\Framework\CSP\CSPBuilder;

class Controller
{
    protected $encryption;
    protected $response;
    protected $session;
    protected $request;
    protected $cookie;
    protected $files;
    protected $csp;

    public function __construct()
    {
        // Content security policy
        if (CSP_ENABLE) {
            $this->csp = CSPBuilder::fromFile(SRCPATH . CSP_FILE);
            $this->csp->sendCSPHeader();
        }

        // Encryption
        $this->encryption   = new Encryption(ENCRYPTION_KEY);

        // Request & response
        $this->response = new Output();
        $this->request  = new Input();
        $this->files    = new Files();
        
        // Session & cookie 
        $this->cookie   = new Cookie($options = []);
        $this->session  = new Session();
    }
}