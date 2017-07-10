<?php

class Autoloader
{
    const PHP_EXT = 'php';

    /** @var string[] */
    private $knownFiles = [];

    /**
     * Autoloader constructor.
     *
     * @param string $basePath
     */
    public function __construct($basePath = __DIR__)
    {
        $this->findAllFiles($basePath);
    }

    /**
     * @param string $fileName
     */
    public function autoload($fileName)
    {
        // if (array_key_exists($fileName, $this->knownFiles))
        //    require_once $this->knownFiles[$fileName];
    }

    private function findAllFiles($basePath)
    {
        $paths = scandir($basePath);
        foreach ($paths as $path)
        {
            // if (is_dir($path))
            //    findAllFiles($path);
            // else
            //    $ext = pathinfo(...);
            //    if ($ext == PHP)
            //        $fileName = pathinfo(...);
            //        $knownFiles[$fileName] = $filePath;
        }
    }
}