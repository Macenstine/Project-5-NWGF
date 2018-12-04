<?php
#------------------------------------------------------------------------------------------
#Author: David Schott
#Creation Date: 2/9/2018
#
#2/11: Updated to work properly
#
#
#Purpose: To hold separate function for the database call.
#------------------------------------------------------------------------------------------
    function MessageSQLQuery ($firstName, $message) {
        global $db;
            //Code prepares data that is loaded into 
            //temporary variables to be inserted into the table.
            $query = 'INSERT INTO messagelog
                         (firstName, message, empID)
                      VALUES
                         (:firstName, :message, 1)';
            $statement = $db->prepare($query);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':message', $message);
            $statement->execute();
            $statement->closeCursor();
            return $firstName;
        }
?>