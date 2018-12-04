<?php 
#---------------------------------------------------------
# Editor: David Schott
# Creation Date: 1/26/2018
#
# 1/26: Created this file using html from my website and php from another site, modified it to work with my database.
#
# 1/27: Edited php script to fix communication issues between this script and the database.
#
# 1/30: Added this log.
#
# 2/11: relocated database query to function in database/messageFunctions.php
#
# 2/16: Created error handling for databse communication 
#
# Function: retrieve and process data inputs from message.html
#
#
# Result: Input data to SQL Database
#---------------------------------------------------------
include "messageFunctions.php";
//Statements define php variables as equal to the value of the form inputs.
    $firstName = filter_input(INPUT_GET, 'firstName');
    $message = filter_input(INPUT_GET, 'message');
    
    // Validate inputs to verify they aren't empty, displays error if any are null.
    if ($firstName == null || $message == null) {
        $error = "Invalid input data. Check all fields and try again.";
        echo "Form Data Error: " . $error; 
        exit();
        } else {
        //SQL Database authentication, displays error if incorrect
            $dsn = 'mysql:host=localhost;dbname=northwestgf';
            $username = 'root';
            $password = 'Pa$$w0rd';
            $error_message = '';

            try {
                $db = new PDO($dsn, $username, $password);

            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                //echo "DB Error: " . $error_message; 
                //exit();
            }
        
        if($error_message) {
            $message = 'Sorry ' . $firstName . ', we are having technical difficulties right now. Please try again later!';
        } else {
            $firstName = MessageSQLQuery($firstName, $message);
            $message = 'Thanks for sending a message ' . $firstName . ', we\'ll get back to you soon!';
        }

        /*function MessageSQLQuery ($firstName, $message, $empID) {
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
        }*/
              

}

?>
<!--The rest of this code is Thankyou and form submission acknowledgement-->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NorthwestG&amp;F</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="../vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/creative.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="../index.html">NorthwestG&amp;F</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="../services.html">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="../portfolio.html">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="../newsletter.html">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="../calculator.html">Calculator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="../message.html">Message</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="../chart.html">Chart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="../faq.html">FAQ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-heading"><?php echo $message; ?></h2>
                    <hr class="primary">
                    <p id="p2"></p>
                </div>
            </div>
        </div>
            
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/popper/popper.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="../vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="../js/creative.min.js"></script>
    <script src="../js/email_list.js"></script>

</body>

</html>
