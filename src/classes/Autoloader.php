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
    public function __construct(string $basePath = __DIR__)
    {
        $this->findAllFiles($basePath);
    }

    /**
     * @param string $fileName
     */
    public function autoload(string $fileName): void
    {
        if (array_key_exists($fileName, $this->knownFiles))
        {
            require_once $this->knownFiles[$fileName];
        }
    }

    private function findAllFiles(string $basePath): void
    {
        $paths = scandir($basePath);
        foreach ($paths as $path)
        {
            if ($path != '.' && $path != '..')
            {
                $absolutePath = $basePath . DIRECTORY_SEPARATOR . $path;
                $pathInfo = pathinfo($path);
                if (is_dir($absolutePath))
                {
                    $this->findAllFiles($absolutePath);
                }
                elseif ($pathInfo['extension'] = self::PHP_EXT)
                {
                    $fileName = $pathInfo['filename'];
                    $this->knownFiles[$fileName] = $absolutePath;
                }
            }
        }
    }
}