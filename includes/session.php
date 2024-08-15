<?php
session_start();

function checkLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /auth/login.php');
        exit();
    }
}

function isAdmin()
{
    return $_SESSION['role'] === 'admin';
}

function isClient()
{
    return $_SESSION['role'] === 'client';
}