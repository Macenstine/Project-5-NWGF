<?php
#------------------------------------------------------------------------------------------
#Author: David Schott
#Creation Date: 2/11/2018
#
#
#Purpose: To hold separate function for the database call.
#------------------------------------------------------------------------------------------
    function SQLDelete(){
    $visitorID = filter_input(INPUT_POST, 'visitorID', 
            FILTER_VALIDATE_INT);
    global $db;
    $query = 'DELETE FROM messageLog
              WHERE visitorID = :visitorID';
    $statement = $db->prepare($query);
    $statement->bindValue(':visitorID', $visitorID);
    $statement->execute();
    $statement->closeCursor();
    echo ($visitorID);
    header("Location: admin.php");
    }
?>