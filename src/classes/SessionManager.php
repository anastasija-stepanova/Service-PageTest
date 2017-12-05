<?php

class SessionManager
{
    private const MAX_LIFE_TIME = 1800;

    public function __construct()
    {
        ini_set('session.gc_maxlifetime', self::MAX_LIFE_TIME);
        ini_set('session.cookie_lifetime', self::MAX_LIFE_TIME);

        session_start();
    }

    public function restoreSession(): void
    {
        if (array_key_exists('userId', $_SESSION))
        {
            $this->checkRedirect();
        }
    }

    public function initializeArraySession(int $userId): void
    {
        $_SESSION['userId'] = $userId;
    }

    public function checkRedirect(): void
    {
        if (array_key_exists('url', $_GET) and $_GET['url'] != false)
        {
            $url = $_GET['url'];
            header("Location: $url");
            exit();
        }
        else
        {
            header('Location: index.php');
            exit();
        }
    }

    public function checkArraySession(string $url = ''): void
    {
        if (!array_key_exists('userId', $_SESSION))
        {
            header("Location: auth.php?url=$url");
            exit();
        }
    }

    public function logout(): void
    {
        if (array_key_exists('userId', $_SESSION))
        {
            session_unset();
            header('Location: auth.php');
            exit();
        }
    }

    public function getUserId(): int
    {
        return $_SESSION['userId'];
    }
}