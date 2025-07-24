<?php

function connect()
{
    try {
        $dbhost = 'localhost'; // host
        $dbname = 'takana'; // nama database
        $dbuser = 'root'; // username database
        $dbpass = ''; // password database
        return new PDO("mysql:host=$dbhost; dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "<br/>";
        die();
    }
}
