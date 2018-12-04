<?php 
#---------------------------------------------------------
# Editor/Author: David Schott
# Creation Date: 2/2/2018
#
# 2/2: Created this file with html from my site 
# and html & php code from the example admin.php page
#
# 2/3: modified variable names to allow php to communicate with correct 
# database and its data. Got most of the admin page functional, 
# but the delete button is still non-functional.
#
# Function: This script retrieves table data 
# from the messageLog table in the northwestgf database.
#
# 2/7: Got the delete button functioning
#
# 2/16: Created error handling for databse communication 
#
#
# Result: The script and html in this file write and display 
# an admin-accessable table on this page with all data from the messageLog table.
#---------------------------------------------------------
//Files with external Functions:
include "database/adminFunctions.php";

//Connect to the database


$dsn = 'mysql:host=localhost;dbname=northwestgf';
$username = 'root';
$password = 'Pa$$w0rd';
$error_message = '';
$message = '';

//Verify database authentication, display error if invalid
try {
    $db = new PDO($dsn, $username, $password);
    //echo 'try successful';

} catch (PDOException $e) {  
    //echo 'catch' . '<br>';
    $error_message = $e->getMessage();
    //echo "DB Authentication Error: " . $error_message; 
    }

if($error_message){
    header ('Location: adminRedirect.php');
} else {
    $message = 'Success!';

#------------------------------------------------------
// Check action; on initial load it is null
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_visitors';
    }
} 
#------------------------------------------------------

// List the visitors & employees
if ($action == 'list_visitors') {

    // Read employee ID data 

    $empID = filter_input(INPUT_GET, 'empID', 
            FILTER_VALIDATE_INT);
    if ($empID == NULL || $empID == FALSE) {
        $empID = 1;
    }

    $query = 'SELECT * FROM employee
              ORDER BY empID';
    $statement = $db->prepare($query);
    $statement->execute();
    $employees = $statement;
    
    $query2 = 'SELECT * FROM messageLog
                WHERE empID = :empID
                ORDER BY visitorID';
                
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":empID", $empID);
    $statement2->execute();
    $messageLogs = $statement2;

}



#------------------------------------------------------
// Executed when the user clicks delete button
else if ($action == 'delete_visitor') {
    SQLDelete();
    
    /*function SQLDelete(){
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
    }*/
} 
}
#------------------------------------------------------
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NorthwestG&amp;F</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/creative.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="index.html">NorthwestG&amp;F</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="services.html">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="portfolio.html">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="newsletter.html">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="calculator.html">Calculator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="message.html">Message</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="chart.html">Chart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="faq.html">FAQ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-heading">Admin Page</h2>
                    <h2 class="section-heading"><?php echo $message; ?></h2>
                    <hr class="primary">
                    <p id="p2"></p>

                    <section>
                        <h3>Select an employee email to view messages</h3>
                        <!-- Code displays the two different selectable employee categories and contains the html that is used by PHP to construct and populate a table with data from the messageLog database as well as a button to delete table entries. -->
                        <?php foreach($employees as $employee) : ?>
                        <li>
                            <a href="?empID=<?php echo $employee['empID']; ?>">
                                <?php echo $employee['empEmail']; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        </br>
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>Message</th>
                                <th class="right">ID Number</th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php foreach ($messageLogs as $messageLog) : ?>
                            <tr>
                                <td>
                                    <?php echo $messageLog['firstName']; ?>
                                </td>
                                <td>
                                    <?php echo $messageLog['message']; ?>
                                </td>
                                <td>
                                    <?php echo $messageLog['visitorID']; ?>
                                </td>
                                <td>
                                    <form action="admin.php" method="post">
                                        <input type="hidden" name="action" value="delete_visitor">
                                        <input type="hidden" name="visitorID" value="<?php echo $messageLog['visitorID']; ?>">
                                        <input type="hidden" name="category_id" value="<?php echo $messageLog['empID']; ?>">
                                        <input type="submit" value="Delete">
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </section>
                </div>
            </div>
        </div>

    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/creative.min.js"></script>
    <script src="js/email_list.js"></script>

</body>

</html>
