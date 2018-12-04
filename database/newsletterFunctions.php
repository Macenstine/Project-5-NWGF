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
function SQLQuery($firstName, $email, $emailVerify){
    global $db;
            $query = 'INSERT INTO newsletter
                         (firstName, email, emailVerify)
                      VALUES
                         (:firstName, :email, :emailVerify)';
            $statement = $db->prepare($query);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':emailVerify', $emailVerify);
            $statement->execute();
            $statement->closeCursor();
}



?>