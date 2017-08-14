<?php
session_start();

if (array_key_exists('userId', $_SESSION))
{
    session_unset();
    header('Location: auth.php');
}