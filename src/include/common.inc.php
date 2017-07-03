<?php
function autoLoad($path)
{
    foreach (scandir($path) as $fileName)
    {
        $fileInfo = new SplFileInfo($fileName);
        $extension = $fileInfo->getExtension();
        if ($extension && $extension == 'php' && $fileName != basename(__FILE__))
        {
            require_once $fileName;
        }
    }
}

autoLoad($_SERVER['DOCUMENT_ROOT'] . '/Service-PageTest/src/include/');
