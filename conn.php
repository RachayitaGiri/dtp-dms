<?php
$conn = mysqli_connect("localhost", "root", "anonymous001", "dms");
//Check connection
if(!$conn) 
{
  die("ERROR: Could not connect.".mysqli_connect_error());
}
?>