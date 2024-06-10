<?php

$con=mysqli_connect("localhost","root","","chattly");
if(mysqli_connect_error()){
    echo'
    <script>
        alert("Cannot connect to server");
    </script>
    ';
    exit();
}

//$con=mysqli_connect("localhost","id21656122_root","Chattlydb@123","id21656122_chattlydb");


?>