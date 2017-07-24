<?php

class DataValidator
{
    public function validateUrl($url)
    {
        $regularExpression = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $isUrl = preg_match($regularExpression, $url);

        if ($isUrl)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}