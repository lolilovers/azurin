<?php

namespace Azurin\Framework\Services;

class Cache
{
    public function __construct(
        // Cache path
        protected $path
    ){}

    public function create($name, $content)
    {
        // Cache path
        $cacheName  = 'cache_' . md5($name) . '.html';
        $cachePath  = $this->path . $cacheName;

        // Save cache
        $cacheFactory   = fopen($cachePath, 'w');
        fwrite($cacheFactory, $content);
        fclose($cacheFactory);
    }

    public function load($name, $expire)
    {
        // Cache path
        $cacheName  = 'cache_' . md5($name) . '.html';
        $cachePath  = $this->path . $cacheName;
        
        // Check cache
        if (file_exists($cachePath) && (time() - $expire < filemtime($cachePath))) {
            // Load cache and stop execution
            require_once($cachePath);
            
            exit();
        }
    }
}