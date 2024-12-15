<?php 
include("connect.php");

if ($_POST['action'] == 'edit') {
    
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $userData = array(
        "first_name" => $first_name,
        "last_name" => $last_name
    );

    // validate first name and last name
    if(!empty($first_name))
    {
        if(preg_match("/^([a-zA-Z' ]+)$/",$first_name)){
            $errF = "";
            $statusF = 0;
        }else{
            $errF = "you should just use uppercase or lowercase letters";
            $statusF = 1;
        }
    }
    else
    {
        $errF = "you should write something!";
        $statusF = 1;
    }
    
    if(!empty($last_name))
    {
        if(preg_match("/^([a-zA-Z' ]+)$/",$last_name)){
            $errL = "";
            $statusL = 0;
        }else{
            $errL = "you should just use uppercase or lowercase letters";
            $statusL = 1;
        }
    }
    else
    {
        $errL = "you should write something!";
        $statusL = 1;
    }
    

    //edit first name and last name in database
    if(($statusF == 0) && ($statusL == 0))
    {
        $update = "UPDATE person
                    SET firstname = :first_name, lastname = :last_name 
                    WHERE id = $id";
        $update = $conn->prepare($update);
        $update->bindParam(':first_name',$first_name);
        $update->bindParam(':last_name',$last_name);
        
        $update->execute();
    }

    
    $data = array(
        "first_name" => $first_name,
        "last_name" => $last_name,
        "errF" => $errF,
        "errL" => $errL,
        "statusF" => $statusF,
        "statusL" => $statusL
    );

    echo json_encode($data);
}

if($_POST['action'] == "delete")
{
    // delete row from database
    if(isset($_POST['id']))
    {
        $id = $_POST['id'];

        $delete = "DELETE FROM person WHERE id = $id";
        $delete = $conn->prepare($delete);
        $delete->execute();

        $data = array(
            'status' => 1,
            'msg' => "deleted successfully!"
        );
        
    }
    else
    {
        $data = array(
            'status' => 0,
            'msg' => "Something went wrong!"
        );
    }

    

    echo json_encode($data);
}

if($_POST['action'] == "add")
{
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'] ;

    
    // validate first name and last name
    if(!empty($first_name))
    {
        if(preg_match("/^([a-zA-Z' ]+)$/",$first_name))
        {
            $first_name_err = "";
            $statusF = 1;
        }
        else
        {
            $first_name_err = "you should just use uppercase and lowercase letters";
            $statusF = 0;
        }
    }
    else
    {
        $first_name_err = "you should write something!";
        $statusF = 0;
    }

    if(!empty($last_name))
    {
        if(preg_match("/^([a-zA-Z' ]+)$/",$last_name))
        {   
            $last_name_err = "" ;
            $statusL = 1;
        }
        else
        {
            $last_name_err = "you should just use uppercase and lowercase letters";
            $statusL = 0;
        }
    }
    else
    {
        $last_name_err = "you should write something!";
        $statusL = 0;
    }

    //insert first name and last name into database
    if(($statusF == 1) and ($statusL == 1))
    {
        $insert = "INSERT INTO person (firstname , lastname) VALUES (:first_name , :last_name) ";
        $insert = $conn->prepare($insert);
        $insert->bindParam(':first_name',$first_name);
        $insert->bindParam(':last_name',$last_name);
        $insert->execute();
    }

    $data = array(
        'statusF' => $statusF,
        'statusL' => $statusL,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'first_name_err' => $first_name_err,
        'last_name_err' => $last_name_err
    );

    echo json_encode($data);

}
?>