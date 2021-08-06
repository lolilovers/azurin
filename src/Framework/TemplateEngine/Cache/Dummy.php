<?php

namespace Src\Framework\TemplateEngine\Cache;

use Src\Framework\TemplateEngine\Cache;

class Dummy implements Cache
{
    private $cache = [];

    /**
     * Get cache for $name if exist.
     *
     * @param string $name Cache id
     *
     * @return mixed data on hit, boolean false on cache not found
     */
    public function get($name)
    {
        if (array_key_exists($name, $this->cache)) {
            return $this->cache[$name];
        }
        return false;
    }

    /**
     * Set a cache
     *
     * @param string $name  cache id
     * @param mixed  $value data to store
     *
     * @return void
     */
    public function set($name, $value)
    {
        $this->cache[$name] = $value;
    }

    /**
     * Remove cache
     *
     * @param string $name Cache id
     *
     * @return void
     */
    public function remove($name)
    {
        unset($this->cache[$name]);
    }
}