<?php
class TemplateLoader
{
    public static function loadTemplate($template, $vars)
    {
        $content = file_get_contents(Config::TEMPLATE_ROOT . $template);

        foreach ($vars as $key => $value)
        {
            $key = "[[$$key]]";
            $content = str_replace($key, $value, $content);
        }

        echo $content;
    }
}