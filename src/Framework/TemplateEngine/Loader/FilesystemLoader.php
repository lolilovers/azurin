<?php

namespace Src\Framework\TemplateEngine\Loader;

use Src\Framework\TemplateEngine\Loader;
use Src\Framework\TemplateEngine\TemplateString;


class FilesystemLoader implements Loader
{
    private $_baseDir;
    private $_extension = '.html';
    private $_prefix = '';
    private $_templates = array();

    /**
     * Template engine filesystem Loader constructor.
     *
     * $options array allows overriding certain Loader options during instantiation:
     *
     *     $options = array(
     *         // extension used for templates. Defaults to '.html'
     *         'extension' => '.other',
     *     );
     *
     * @param string|array $baseDirs A path contain template files or array of paths
     * @param array        $options  Array of Loader options (default: array())
     *
     * @throws \RuntimeException if $baseDir does not exist.
     */
    public function __construct($baseDirs, Array $options = [])
    {
        if (is_string($baseDirs)) {
            $baseDirs = array(rtrim(realpath($baseDirs), '/'));
        } else {
            foreach ($baseDirs as &$dir) {
                $dir = rtrim(realpath($dir), '/');
            } unset( $dir );
        }

        $this->_baseDir = $baseDirs;

        foreach ($this->_baseDir as $dir) {
            if (!is_dir($dir)) {
                throw new \RuntimeException(
                    'FilesystemLoader baseDir must be a directory: ' . $dir
                );
            }
        }

        if (isset($options['extension'])) {
            $this->_extension = '.' . ltrim($options['extension'], '.');
        }

        if (isset($options['prefix'])) {
            $this->_prefix = $options['prefix'];
        }
    }

    /**
     * Load a Template by name.
     *
     *     $loader = new FilesystemLoader(dirname(__FILE__).'/views');
     *     // loads "./views/admin/dashboard.html";
     *     $loader->load('admin/dashboard');
     *
     * @param string $name template name
     *
     * @return TemplateString Template source
     */
    public function load($name)
    {
        if (!isset($this->_templates[$name])) {
            $this->_templates[$name] = $this->loadFile($name);
        }

        return new TemplateString($this->_templates[$name]);
    }

    /**
     * Helper function for loading a file by name.
     *
     * @param string $name template name
     *
     * @throws \InvalidArgumentException if a template file is not found.
     * @return string html Template source
     */
    protected function loadFile($name)
    {
        $fileName = $this->getFileName($name);

        if ($fileName === false) {
            throw new \InvalidArgumentException('Template ' . $name . ' not found.');
        }

        return file_get_contents($fileName);
    }

    /**
     * Helper function for getting a template file name.
     *
     * @param string $name template name
     *
     * @return string Template file name
     */
    protected function getFileName($name)
    {
        foreach ($this->_baseDir as $baseDir) {
            $fileName = $baseDir . '/';
            $fileParts = explode('/', $name);
            $file = array_pop($fileParts);

            if (substr($file, strlen($this->_prefix)) !== $this->_prefix) {
                $file = $this->_prefix . $file;
            }

            $fileParts[] = $file;
            $fileName .= implode('/', $fileParts);
            $lastCharacters = substr($fileName, 0 - strlen($this->_extension));

            if ($lastCharacters !== $this->_extension) {
                $fileName .= $this->_extension;
            }
            if (file_exists($fileName)) {
                return $fileName;
            }
        }

        return false;
    }

}
