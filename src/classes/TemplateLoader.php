<?php
class TemplateLoader
{
    public function loadTemplate($template, $vars)
    {
        $content = file_get_contents(Config::TEMPLATE_ROOT . $template);
        foreach ($vars as $key => $value)
        {
            $content = str_replace($key, $value, $content);
        }

        echo $content;
    }
}