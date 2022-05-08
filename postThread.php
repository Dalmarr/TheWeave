<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="scripts/validate.js"></script>
        <link rel="stylesheet" href="forms_and_inputs.css">
        <link rel="stylesheet" href="navbar.css">
    </head>
    <body>
        <?php session_start();?>
        
        <div id="navbar">
            <ul><li><a href="homepage.php">Home</a></li>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                    echo "<a href=\"profile.php\">Logged in as: ".$_SESSION['username']."  </a>
                          <br><br><button onclick=\"logoff()\">Log out</button>";
                  } else {
                    echo "<li><a href=\"login.php\">Log In</a></li>
                          <li><a href=\"signup.php\">Sign Up</a></li></ul>";}?>
                          
        </div>
        <div id="search">
        <form action="threadLookup.php" method="POST">
        <input type="text" id="threadString" name="threadString" placeholder="Search threads...">
        <input type="image" name="submit" src="imgs/search.png" alt="Submit" style="width: 30px; display: inline-block;">
    </div>
        <?php
            //SQL connection variables
            $host = "localhost";
            $database = "project";
            $user = "webuser";
            $password = "P@ssw0rd";
            
            //connect to SQL
            $connection = mysqli_connect($host, $user, $password, $database);
            
            //check connection to SQL
            $error = mysqli_connect_error();
            if($error != null)
            {
                $output = "<p>Unable to connect to database!</p>";
                exit($output);
            }
            else
            {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !(empty($_POST['threadTitle']) && !(empty($_POST['threadBody'])))){
                    
                    $userID = 0;
                    $sql = "SELECT userID FROM project.users WHERE username = '".$_SESSION['username']."';";
                    $results = mysqli_query($connection, $sql);
                    if ($row = mysqli_fetch_assoc($results)) {
                        $userID = $row['userID'];
                    }
                    
                    $sql = "INSERT INTO `threads`(`userID`, `author`, `title`, `body`, `time`) VALUES (".$userID.",'".$_SESSION['username']."','".$_POST['threadTitle']."','".$_POST['threadBody']."', NOW());";
                    if (mysqli_query($connection, $sql) && $userID != 0)
                    {
                        echo "<p>Your thread has been posted!</p>";
                        echo "<p><a href=\"homepage.php\">View thread</a></p>";
                    } else {
                        echo "<p>There was an error posting your thread.</p>";
                        echo "<p><a href=\"homepage.php\">Return to homepage</a></p>";
                    }
                }
            }
            mysqli_free_result($results);
            mysqli_close($connection);
        ?>
    </body>
</html>