<?php 
include ("connect.php");

function read($conn)
{
    $sql = "SELECT * FROM person";
    $sql = $conn->prepare($sql);
    $sql->execute();
    $result = $sql->fetchAll();

    return $result;
}






?>