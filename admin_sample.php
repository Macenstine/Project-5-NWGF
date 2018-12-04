<!------------------------------------------------------------------------------
  Modification Log
  Date          Name            Description
  ----------    -------------   -----------------------------------------------
  2-1-2018      JWokersien      Initial Deployment.
  ----------------------------------------------------------------------------->
<?php   
// Connect to db
$dsn = 'mysql:host=localhost;dbname=evajones';
$username = 'root';
$password = 'Pa$$w0rd';

try {
    $db = new PDO($dsn, $username, $password);

} catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "DB Error: " . $error_message; 
    exit();
    }
        
// Check action; on initial load it is null
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_visitors';
    }
}  

// List the visitors & employees
if ($action == 'list_visitors') {

    // Read employee data 

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

    $query2 = 'SELECT * FROM visitor
                WHERE empID = :empID
                ORDER BY visitor_email';
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":empID", $empID);
    $statement2->execute();
    $visitors = $statement2;
}
// Executed when user clicks delete button
else if ($action == 'delete_visitor') {
    $visitorID = filter_input(INPUT_POST, 'visitorID', 
            FILTER_VALIDATE_INT);
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

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>Eva Jones Design</title>
<style type="text/css">
@import url("CSS/stylesheet.css");
body {
	background-image: url(images/bkgdContact.jpg);
}
</style>
<!-- Mobile -->
<link href="CSS/mobile.css" rel="stylesheet" type="text/css" media="only screen and (max-width:800px)">
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>

<body>
<div id="logo"><img src="images/logo.png" width="220" height="103" alt="Eva Jones Design"></div>
<nav>
  <ul id="MenuBar1" class="MenuBarHorizontal">
    <li><a href="index.html">home</a>    </li>
    <li><a href="about.html">about</a></li>
    <li><a href="portfolio.html">portfolio</a>    </li>
    <li><a href="contact.html">contact</a></li>
  </ul>
</nav>
<header>
  <h1>contact <span class="fancy">Eva Jones</span></h1>
</header>
<section>
  <h2>Admin Page</h2>
  <h3>Select an employee email to view messages</h3>
            <!-- display links for all employees -->
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
                <th>Email</th>
                <th class="right">Message</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($visitors as $visitor) : ?>
            <tr>
                <td><?php echo $visitor['firstName']; ?></td>
                <td><?php echo $visitor['message']; ?></td>
                <td><?php echo $visitor['visitorID']; ?></td>
                
                
                <td><form action="admin.php" method="post">
                    <input type="hidden" name="action"
                           value="delete_visitor">
                    <input type="hidden" name="visitorID"
                           value="<?php echo $messageLog['visitorID']; ?>">
                    <input type="hidden" name="category_id"
                           value="<?php echo $messageLog['empID']; ?>">
                    <input type="submit" value="Delete">
                </form></td>
            </tr>
            <?php endforeach; ?>
        </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</section>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<h1>&nbsp;</h1>
<h2>&nbsp;</h2>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
