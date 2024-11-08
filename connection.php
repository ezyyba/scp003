<?php

    include "credentials.php";
    
    // Database connection
    $connection = new mysqli('localhost', $user, $pw, $db);
    
    // Select all records from our table
    $AllRecords = $connection->prepare("SELECT * FROM scp1"); 
    $AllRecords->execute();
    $result = $AllRecords->get_result();

?>