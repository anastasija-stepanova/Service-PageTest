<?php

class PathProvider
{
    public static function getPathTemplates(): string
    {
        return realpath('../src/templates/');
    }
}