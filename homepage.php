<!DOCTYPE html>
<html>
<head>
    <title>The Weave</title>
    <script type="text/javascript" src="logoff.js"></script>
    <link rel="stylesheet" href="pageStyles.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Pacifico&display=swap" rel="stylesheet">
</head>

<body>
        <?php
            //start session to keep info
            session_start();
            //SQL connection variables
            $host = "localhost";
            $database = "project";
            $user = "webuser";
            $password = "P@ssw0rd";
            
            //connect to SQL
            $connection = mysqli_connect($host, $user, $password, $database);
        
            //initiate error string
            $errorStr = "";
            
            //check connection to SQL
            $error = mysqli_connect_error();
            if($error != null)
            {
              $output = "<p>Unable to connect to database!</p>";
              exit($output);
            }
            else
            {
                //if connection successfull, check if request is POST and check for infoType being passed
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $infoType = $_POST['infoType'];
                    if (!(empty($infoType))) {
                        //if infoType is 'login' the user just came from login.php and is trying to log in. 
                        if ($infoType == 'login'){
                            //decleare username and password variables
                            $uname = $_POST['username'];
                            $pswd = $_POST['password'];
                            if (!(empty($uname)) && !(empty($pswd))){
                                //check if the user exists and if the password is correct
                                $sql = "SELECT * FROM users WHERE username = \"" . $uname . "\" AND password = \"" . md5($pswd) . "\";";
                                $results = mysqli_query($connection, $sql);
                                //if user is found, then change session variables accordingly.
                                if ($row = mysqli_fetch_assoc($results))
                                {
                                    $_SESSION['loggedin'] = true;
                                    $_SESSION['username'] = $uname;
                                } else {
                                    $errorStr .= "Wrong username/password.";
                                }
                            }
                        //if infoType if 'signup' user just came from signup.php and is trying to create an account.
                        } else if ($infoType == 'signup'){
                            //star session to keep info
                            session_start();
                            //get post variables to create a user.
                            $uname = $_POST['username'];
                            $email = $_POST['email'];
                            $pswd = $_POST['password'];
                            if (!(empty($uname)) && !(empty($email)) && !(empty($pswd))){
                                //build query to check if the email or username has already been used.
                                $sql = "SELECT * FROM users WHERE email = \"".$email."\" OR username = \"".$uname."\";";
                                $results = mysqli_query($connection, $sql);
                                //if the email is already in use, tell the user that.
                                if ($row = mysqli_fetch_assoc($results))
                                {
                                    echo "<p>User already exists with this email or username</p>";
                                    echo "<p><a href=\"signup.php\">Return to signup.</a></p>";
                                } else {
                                    //if the email has not been used, then build query to create a new user in the database
                                    $sql = "INSERT INTO users (`username`, `email`, `password`) VALUES (\"".$uname."\", \"".$email."\", \"".md5($pswd)."\");";
                                    if (mysqli_query($connection, $sql)){
                                        //alert the user that the user was successfuly created and change session variables accordingly
                                        echo "<p>An account for the user ".$uname." has been created.</p>";
                                        $_SESSION['loggedin'] = true;
                                        $_SESSION['username'] = $uname;
                                    } else {
                                        $errorStr .= "An error occured creating user.";
                                    }
                                }
                            }
                        //if the infoType is 'logoff' it means that the user just clicked on the log off button.
                        } else if ($infoType == 'logoff') {
                            //change session variables accordingly and destroy the session.
                            $_SESSION['loggedin'] = false;
                            session_destroy();
                        }
                    } else {
                        $errorStr .= "ERROR GETTING DATA2";
                    }
                }
                
                //build query to get all threads from database
                $sql = "SELECT * FROM threads;";

                $results = mysqli_query($connection, $sql);
                //create builderstring for the thread list
                $threadList = "<div class=\"thread\"><hr>";
                //itreate through the list of threads and build the html div
                while ($row = mysqli_fetch_assoc($results))
                {
                    $threadList .= "<h2><a href=\"thread.php?threadID=".$row['threadID']."\">".$row['title']."</a></h2>
                    <h5>Author: ".$row['author'].". @ ".$row['time'].".</h5>
                    <p>".$row['body']."</p>
                    <hr>";
                }
                $threadList .= "</div>";
                mysqli_free_result($results);
                mysqli_close($connection);
            }
        ?>
    <div id="navbar">
        <ul>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                    echo "<a href=\"profile.php?username=".$_SESSION['username']."\">Logged in as: ".$_SESSION['username']."  </a>
                    <br><button onclick=\"logoff()\">Log out</button>";
              } else {
                echo "<li><a href=\"login.php\">Log In</a></li>
                      <li><a href=\"signup.php\">Sign Up</a></li></ul>";}?>
        </div>
    </div>
    <br>
    <div id="search">
        <form action="threadLookup.php" method="POST">
        <input type="text" id="threadString" name="threadString" placeholder="Search threads...">
        <input type="image" name="submit" src="imgs/search.png" alt="Submit" style="width: 30px; display: inline-block;">
    </div>

    <div class="header">
        <h1>The Weave</h1>
    </div>
</div>
<div class="createThread">
    <a href="newthread.php">Create a thread</a>
</div>
    <div class="mainbody">
        <?php
            if (!(empty($errorStr))){
                echo "<p>".$errorStr."</p>";
            }
            echo $threadList;
        ?>
</body>