<?php 
    include("function.php");
    include("connect.php");

    $result = read($conn)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/0e706293c0.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <title>Editable Table</title>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="insertData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="insertDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="insertDataLabel">Registration</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control my-2 addInput first_name" placeholder="First Name">
                    <span id="first_name_err" class="text-danger"></span>
                    <input type="text" class="form-control my-2 addInput last_name" placeholder="Last Name">
                    <span id="last_name_err" class="text-danger"></span>

                    <div id="successfull" class="text-success mt-3 text-center"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="add_user" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>

    <h2 class="d-flex justify-content-center mt-3">Editable Table</h2>
    <div class="container">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#insertData">
            Add User
        </button>
        <div class="row">
            <table id="myTable" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($result as $row)
                    {
                    ?>
                    <tr id="<?php echo $row['id']; ?>">
                        <th scope="row"><?php echo $row['id'] ?></th>
                        <td id="first_name">
                            <span class="editSpan first_name"><?php echo $row['firstname']; ?></span>
                            <input class="form-control editInput first_name " type="text" name="first_name"
                                value="<?php echo $row['firstname']; ?>" style="display: none;">
                        </td>
                        <td id="last_name">
                            <span class="editSpan last_name"><?php echo $row['lastname']; ?></span>
                            <input class="form-control editInput last_name" type="text" name="last_name"
                                value="<?php echo $row['lastname']; ?>" style="display: none;">
                        </td>
                        <td>
                            <button class="btn" id="editBtn"><i class="fa-solid fa-pencil"></i></button>
                            <button class="btn" id="deleteBtn"><i class="fa-solid fa-trash"></i></button>

                            <button class="btn" style="display: none;" id="saveBtn"><i
                                    class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn" style="display: none;" id="confirmBtn"><i
                                    class="fa-solid fa-check"></i></button>
                            <button class="btn" style="display: none;" id="cancelBtn"><i
                                    class="fa-solid fa-xmark"></i></button>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
$(document).ready(function() {
    $("body").on("click", "#editBtn", function() {
        // show save and cancel buttons
        $(this).closest("tr").find("#saveBtn").show();
        $(this).closest("tr").find("#cancelBtn").show();

        // hide edit and delete buttons
        $(this).closest("tr").find("#editBtn").hide();
        $(this).closest("tr").find("#deleteBtn").hide();

        //hide edit span
        $(this).closest("tr").find(".editSpan").hide();

        //show edit input
        $(this).closest("tr").find(".editInput").show();


    });

    $("body").on("click", "#saveBtn", function() {
        var trObj = $(this).closest("tr");
        var id = $(this).closest("tr").find("th").text();
        var first_name = $(this).closest("tr").find(".editInput.first_name").val();
        var last_name = $(this).closest("tr").find(".editInput.last_name").val();

        $.ajax({
            type: "post",
            url: "action.php",
            data: {
                action: "edit",
                id: id,
                first_name: first_name,
                last_name: last_name

            },
            dataType: "json",
            success: function(response) {
                // console.log(response);
                if ((response.statusF == 0) && (response.statusL == 0)) {

                    trObj.find(".editSpan.first_name").text(response.first_name);
                    trObj.find(".editSpan.last_name").text(response.last_name);

                    trObj.find(".editInput.first_name").val(response.first_name);
                    trObj.find(".editInput.last_name").val(response.last_name);

                    trObj.find(".editInput").hide();
                    trObj.find(".editSpan").show();
                    trObj.find("#saveBtn").hide();
                    trObj.find("#cancelBtn").hide();
                    trObj.find("#editBtn").show();
                    trObj.find("#deleteBtn").show();

                } else {
                    if((response.statusF == 1) && (response.statusL == 0))
                    {
                        alert("firstname error: "+response.errF);
                    }
                    if((response.statusL == 1) && (response.statusF == 0))
                    {
                        alert("lastname error: "+response.errL);
                    }
                    if((response.statusF == 1) && (response.statusL == 1))
                    {
                        alert("firstname&lastname error: "+response.errF);
                    }
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown, textStatus);
            }

        });
    })

    $("body").on("click", "#cancelBtn", function() {
        // hide save and cancel and confirm buttons
        $(this).closest("tr").find("#saveBtn").hide();
        $(this).closest("tr").find("#cancelBtn").hide();
        $(this).closest("tr").find("#confirmBtn").hide();

        // show edit and delete buttons
        $(this).closest("tr").find("#editBtn").show();
        $(this).closest("tr").find("#deleteBtn").show();

        //hide edit span
        $(this).closest("tr").find(".editSpan").show();

        //show edit input
        $(this).closest("tr").find(".editInput").hide();
    })

    $("body").on("click", "#deleteBtn", function() {
        // show save and cancel buttons
        $(this).closest("tr").find("#confirmBtn").show();
        $(this).closest("tr").find("#cancelBtn").show();

        // hide edit and delete buttons
        $(this).closest("tr").find("#editBtn").hide();
        $(this).closest("tr").find("#deleteBtn").hide();
    })

    $("body").on("click", "#confirmBtn", function() {
        // alert("Please confirm");
        var trObj = $(this).closest("tr");
        var id = $(this).closest("tr").find("th").text();

        $.ajax({
            type: "post",
            url: "action.php",
            data: {
                action: "delete",
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 1) {
                    trObj.remove();

                } else {
                    trObj.find(".confirmBtn").hide();
                    trObj.find(".cancelBtn").hide();
                    trObj.find(".editBtn").show();
                    trObj.find(".deleteBtn").show();
                    console.log(response.msg);
                }
            }

        });

    })

    $("#add_user").on("click", function() {
        let first_name = $(".addInput.first_name").val();
        let last_name = $(".addInput.last_name").val();

        $.ajax({
            type: "post",
            url: "action.php",
            data: {
                action: "add",
                first_name: first_name,
                last_name: last_name
            },
            dataType: "json",
            success: function(response) {
                if ((response.statusF == 0) || (response.statusL == 0)) {
                    if(response.statusF == 0)
                    {
                        $("#first_name_err").text(response.first_name_err);
                        $(".addInput.first_name").addClass("is-invalid");

                        $(".addInput.last_name").removeClass("is-invalid");
                        $("#last_name_err").text(null);
                    }
                    if(response.statusL == 0)
                    {
                        $("#last_name_err").text(response.last_name_err);
                        $(".addInput.last_name").addClass("is-invalid"); 

                        $(".addInput.first_name").removeClass("is-invalid");
                        $("#first_name_err").text(null);
                    }
                    if((response.statusF == 0) && (response.statusL == 0))
                    {
                        $("#first_name_err").text(response.first_name_err);
                        $(".addInput.first_name").addClass("is-invalid");
                        $("#last_name_err").text(response.last_name_err);
                        $(".addInput.last_name").addClass("is-invalid");
                    }
                } 
                else 
                {   
                    // put empty value to inputs field
                    $(".addInput.first_name").val(null);
                    $(".addInput.last_name").val(null);
                    $("#successfull").text("data added successfully");
                    // remove error message
                    $(".addInput.first_name").removeClass("is-invalid");
                    $(".addInput.last_name").removeClass("is-invalid");
                    $("#last_name_err").text(null);
                    $("#first_name_err").text(null);
                    // refresh table
                    $("body").load("index.php", function() {
                        setTimeout(refreshTable, 10000);
                    });
                }
            }
        });
    })

})
</script>

</html>