<?php

class PathProvider
{
    public function getPathTemplates(): string
    {
        return realpath('../src/templates/');
    }
}