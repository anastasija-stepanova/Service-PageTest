<?php

class TwigWrapper
{
    private $twig;
    private $templateLoader;

    public function __construct($path)
    {
        $this->templateLoader = new Twig_Loader_Filesystem($path);
        $this->twig = new Twig_Environment($this->templateLoader);
    }

    public function renderTemplate(string $templateName, array $paramsArray = [])
    {
        return $this->twig->render($templateName, $paramsArray);
    }

    public function getLoadedLayout(string $layoutName)
    {
        return $this->twig->load($layoutName);
    }

    public function displayTemplate(string $templateName, array $paramsArray = [])
    {
        $this->twig->display($templateName, $paramsArray);
    }
}