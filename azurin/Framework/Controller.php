<?php

namespace Azurin\Framework;

use Azurin\Framework\Services\Encryption;
use Azurin\Framework\Services\Output;
use Azurin\Framework\Services\Files;
use Azurin\Framework\Services\Input;
use Azurin\Framework\CSP\CSPBuilder;

Abstract class Controller
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
            $this->csp = CSPBuilder::fromFile(ROOTPATH . CSP_FILE);
            $this->csp->sendCSPHeader();
        }

        // Encryption
        $this->encryption   = new Encryption(ENCRYPTION_KEY);

        // Request & response
        $this->response = new Output();
        $this->request  = new Input();
        $this->files    = new Files();
    }
}
