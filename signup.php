<?php
include "../../db.php";
include "../../config.php";
    if(isset($_POST["login"]) && strlen($_POST["login"]) > 0 &&
        isset($_POST["full_name"]) && strlen($_POST["full_name"]) >0 &&
        isset($_POST["password"]) && strlen($_POST["password"]) >0 &&
        isset($_POST["password2"]) && strlen($_POST["password2"])>0)
    {
        $login = $_POST["login"];
        $full_name = $_POST["full_name"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];

        $hash = password_hash(sha1($password), PASSWORD_DEFAULT);
        $token = bin2hex(openssl_random_pseudo_bytes(16));

        $exist = $db->query("SELECT * FROM users WHERE login = '$login'");
        if($exist->num_rows > 0)
        {
            header("Location: $base_url/register.php?error=2");
        }
        elseif($password != $password2)
        {
            header("Location: $base_url/register.php?error=3");
        }
        else
        {
            $db->query("INSERT INTO users (login, full_name, password)  
                                    VALUES ('$login', '$full_name', '$hash')");
            header("Location: $base_url/profile.php");
        }
    }
    else
    {
        header("Location: $base_url/register.php?error=1");
    }
?>
