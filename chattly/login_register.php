<?php 
require("connection.php");
session_start();

//login 
if(isset($_POST['login']))
{
   $query="SELECT * FROM `registered_users` WHERE `email`='$_POST[email_username]'  OR `username`='$_POST[email_username]' ";
    $result=mysqli_query($con,$query);

    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            $result_fetch=mysqli_fetch_assoc($result);
            if(password_verify($_POST['password'],$result_fetch['password']))
            {
            //if password is correct 
            $_SESSION['logged_in']=true;
            $_SESSION['username']=$result_fetch['username'];
            header("location:index.php");
            }
            else
            {
                //if password isn't correct
            echo"
                <script>
                    alert('Incorrect password.');
                    window.location.href='index.php';
                </script>
            ";
            }
        }
        else
        {
            echo"
            <script>
                alert('Email or username not registered.');
                window.location.href='index.php';
            </script>
        ";
        }
    }
    else
    {
        echo"
            <script>
                alert('Cannot run query.');
                window.location.href='index.php';
            </script>
        ";
    }
} 

//registration
if(isset($_POST['register']))
{
    $user_select_query = "SELECT * FROM `registered_users` WHERE `username`='$_POST[username]' OR `email`='$_POST[email]' ";
    $result=mysqli_query($con,$user_select_query);

    if($result)
    {
        if(mysqli_num_rows($result)>0)//executed if email or username already exist
        {
            //if any user has already taken email or username
           $result_fetch=mysqli_fetch_assoc($result);
           if($result_fetch['username']==$_POST['username'])//check for username already exist or not
           {
            //error for username already registered
            echo"
            <script>
                alert(' $result_fetch[username] -Username already taken.');
                window.location.href='index.php';
            </script>
            ";
           }
           else//error for email already registered
           {
            echo"
            <script>
                alert(' $result_fetch[email] -Email already registered.');
                window.location.href='index.php';
            </script>
            ";
           } 
        }
        else// inserting data in database 
        {
            $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
            $query = " INSERT INTO `registered_users`(`fullname`, `username`, `email`, `password`) VALUES ('$_POST[fullname]','$_POST[username]','$_POST[email]','$password')";

            if(mysqli_query($con,$query))
            {//if data is inserted in database
                $user_id_query = "SELECT user_id FROM registered_users WHERE username='$_POST[username]'";
                $user_id_result = mysqli_query($con, $user_id_query);

                if ($user_id_result && mysqli_num_rows($user_id_result) == 1) {
                    $user_id = mysqli_fetch_assoc($user_id_result)['user_id'];
                    $_SESSION['user_id'] = $user_id; // Store user ID in the session
                }
                echo"
                <script>
                    alert('User registration successful.');
                    window.location.href='index.php';
                </script>
                ";
            }
            else
            {//if data not inserted in database
                echo"
                <script>
                    alert('User registration unsuccessful.');
                    window.location.href='index.php';
                </script>
                ";
            }
            

        }
    }
    else
    {
    echo"
    <script>
        alert('Cannot run query.');
        window.location.href='index.php';
    </script>
    ";
    }
}



?>