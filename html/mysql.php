<?php
$servername = 'mysql';
$username = 'root';
$password = '123456';
$conn = mysqli_connect($servername,$username,$password);
if(! $conn)
{
    die('could not connect:'.mysqli_error());
}
    echo 'mysql connected!!!';
    mysqli_close($conn)
?>
