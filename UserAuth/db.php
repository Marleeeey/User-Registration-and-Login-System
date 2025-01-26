<?php
    $username = 'root';
    $servername = 'localhost';
    $pass = '';
    $dbName = '';


    //MAKE THE CONNECTION
    $conn = new mysqli($servername, $username, $pass, $dbName);

    //SEE IF IT CONNECTED
    if ($conn->connect_error)
    {
        echo "There is an error here: " . $conn->connect_error;
    }
?>