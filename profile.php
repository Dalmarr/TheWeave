<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="validate.js"></script>
        <script type="text/javascript">
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
            <a href="homepage.php">Home</a>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                        echo "<a href=\"profile.php?username=".$_SESSION['username']."\" style=\"float: right;\">Logged in as: ".$_SESSION['username']."  </a>
                          <br><button onclick=\"logoff()\" style=\"float: right;\">Log off</button>";
                  } else {
                    echo "<a href=\"login.php\" style=\"float: right;\">Login</a>
                          <a href=\"signup.php\" style=\"float: right;\">Signup</a>";}?>
        </div>
        <div id="search">
            <form action="threadLookup.php" method="POST">
            <input type="text" id="threadString" name="threadString" placeholder="Search threads...">
            <input type="image" name="submit" src="imgs/search.png" alt="Submit" style="width: 30px; display: inline-block;">
            </form>
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
                if (!(empty($_GET['username']))){
                    
                    $username = $_GET['username'];
                    
                    $sql = "SELECT * FROM project.users WHERE username = \"".$username."\"";

                    $results = mysqli_query($connection, $sql);
                    $profile = "<div class=\"profile\"><hr>";
                    if ($row = mysqli_fetch_assoc($results))
                    {
                        $profile .= "<h2>Username: ".$row['username']."</h2>
                        <h5>email: ".$row['email']."</h5>";
                    }
                    $sql = "SELECT * FROM project.threads WHERE author = '".$username."'";

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

                    echo $profile;
                    echo $threadList;
                    mysqli_free_result($results);
                    mysqli_close($connection);
                }
            }
        ?>
    </body>
</html>