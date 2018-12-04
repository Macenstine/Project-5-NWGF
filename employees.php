<?php
    function getEmployees(){
    global $db;
$query = 'SELECT * FROM employee
              ORDER BY empID';
    $statement = $db->prepare($query);
    $statement->execute();
    $employees = $statement;
    
    return $employees;
    }


?>
