<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Fake car app</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
        .m-r-1em{ margin-right:1em; }
        .m-b-1em{ margin-bottom:1em; }
    </style>

    <script type="javascript">
        function delete_user(id) {
            var answer = confirm("Are you sure?");
            if (answer) {
                window.location = ";
            }
        }
    </script>

</head>
<body>
<div class="container">

    <div class="page-header">
        <h3>Users</h3>
    </div>

    <?php
    include '../config/database.php';

    $action = isset($_GET['action']) ? $_GET['action'] : "";

    if ($action == 'deleted') {
        echo "<div class='alert alert-success'>Record deleted</div>";
    }

    $query = "SELECT id, name FROM app_user ORDER BY id";
    $statement = $connection->prepare($query);
    $statement->execute();
    $amount = $statement->rowCount();

    echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create new user</a>";

    if ($amount) {

        $data = "<h3>{$amount} Users found</h3><table class='table table-hover table-responsive table-bordered'><tr><th>Name</th></tr>";

        while ($row = $statement->fetch()) {
            $id = $row['id'];
            $name = $row['name'];

            $data .= "<tr><td>{$name}</td>"
                . "<td>"
                . "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>"
                . "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>"
                . "<a href='delete.php?id={$id}' onclick='delete_user({$id})' class='btn btn-danger'>Delete</a>"
                . "</td></tr>";
        }

        $data .= "</table>";

        echo $data;

    }
    ?>

</div>

</body>
</html>