<?php 
$servername = "";
$username = "";
$password = "";
$db_name = "";

try
{
    $conn = new PDO("mysql:host=$servername;dbname=$db_name" , $username , $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection established";

}
catch(Exception $e)
{
    echo "Error: " . $e->getMessage();
}
?>