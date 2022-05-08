<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="validate.js"></script>
        <script type="text/javascript">
        <link rel="stylesheet" href="pageStyles.css">
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="forms_and_inputs.css">
        //log off function. Sets input type as 'logoff' and reloads the page.
        function logoff(){
            form = document.createElement('form');
            form.setAttribute('method', 'POST');
            form.setAttribute('action', 'homepage.php');
            myvar = document.createElement('input');
            myvar.setAttribute('name', 'infoType');
            myvar.setAttribute('type', 'hidden');
            myvar.setAttribute('value', 'logoff');
            form.appendChild(myvar);
            document.body.appendChild(form);
            form.submit(); 
        }
    </script>
    </head>
    <body>
        <?php session_start();?>
        
        <div id="navbar">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                    echo "<a href=\"profile.php?username=".$_SESSION['username']."\">Logged in as: ".$_SESSION['username']."  </a>
                    <br><button onclick=\"logoff()\">Log out</button>";
              } else {
                echo "<ul><li><a href=\"login.php\">Log In</a></li>
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
        
            //initiate error string
            $errorStr = "";
            
            //check connection to SQL
            $error = mysqli_connect_error();
            if($error != null)
            {
              $output = "<p>Unable to connect to database!</p>";
              exit($output);
            } else {
                if (!(empty($_GET['threadID']))){
                    
                    $threadID = $_GET['threadID'];
                    
                    $sql = "SELECT * FROM project.threads WHERE threadID = ".$threadID."";

                    $results = mysqli_query($connection, $sql);
                    $threadHead = "<div class=\"thread\"><hr>";
                    if ($row = mysqli_fetch_assoc($results))
                    {
                        $threadHead .= "<h2>".$row['title']."</h2>
                        <h5>Author: ".$row['author'].". @ ".$row['time'].".</h5>
                        <p>".$row['body']."</p>";
                    }
                    $threadHead .= "</div>";

                    $userID = 0;
                    $sql = "SELECT userID FROM project.users WHERE username = '".$_SESSION['username']."';";
                    $results = mysqli_query($connection, $sql);
                    if ($row = mysqli_fetch_assoc($results)) {
                        $userID = $row['userID'];
                    }
                    if (!(empty($_POST['commentTitle']))){
                         $sql = "INSERT INTO `comments` (`threadID`, `author`, `title`, `body`, `time`) VALUES (".$threadID.",'".$_SESSION['username']."','".$_POST['commentTitle']."','".$_POST['commentBody']."', NOW());";
                        if (mysqli_query($connection, $sql) && $userID != 0)
                        {
                            echo "<p>Your comment has been posted!</p>";
                            echo "<p><a href=\"homepage.php\">return to homepage</a></p>";
                        } else {
                            echo "<p>There was an error posting your comment.</p>";
                            echo "<p><a href=\"homepage.php\">return to homepage</a></p>";
                        }
                    }

                    //build query to get all threads from database
                    $sql = "SELECT * FROM project.comments WHERE threadID = ".$threadID.";";

                    $results = mysqli_query($connection, $sql);
                    //create builderstring for the thread list
                    $commentList = "<div class=\"comment\"><hr>";
                    //itreate through the list of threads and build the html div
                    while ($row = mysqli_fetch_assoc($results))
                    {
                        $commentList .= "<h4>".$row['title']."</h4>
                        <h5>Author: ".$row['author'].". @ ".$row['time'].".</h5>
                        <p>".$row['body']."</p>
                        <hr>";
                    }
                    $commentList .= "</div>";

                    $commentForm;
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        $commentForm = "<p>Leave a comment:</p>
                              <form action=\"thread.php?threadID=".$threadID."\" method=\"POST\" id=\"commentForm\" name=\"commentForm\">
                                <label for=\"commentTitle\">Title:</label><br>
                                <input type=\"text\" id=\"commentTitle\" name=\"commentTitle\" class=\"required\"><br>
                              </form>
                              <label for=\"commentBody\">Body:</label><br>
                              <textarea rows=\"4\" cols=\"50\" id=\"commentBody\" name=\"commentBody\"  class=\"required\" form=\"commentForm\"></textarea><br>
                              <input type=\"submit\" form=\"commentForm\">";
                    } else {
                        $commentForm = "<p>Please <a href=\"login.php\">login</a> to comment on a thread.</p>";
                    }

                    echo $threadHead;
                    echo $commentList;
                    echo $commentForm;   
                    mysqli_free_result($results);
                    mysqli_close($connection);
                    
                    
                }
            }
            
        ?>
    </body>
</html>