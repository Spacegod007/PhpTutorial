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
</head>
<body>

<div class="container">

    <div class="page-header">
        <h3>User</h3>
    </div>

    <?php

    $action = isset($_GET['action']) ? $_GET['action'] : "";

    if ($action == 'deleted') {
        echo "<div class='alert alert-success'>Record deleted</div>";
    }

    $userId = isset($_GET['id']) ? $_GET['id'] : die("ERROR: id not found");
    include '../config/database.php';
    try {
        $query = "SELECT id, name FROM app_user WHERE id = ? LIMIT 0,1";
        $statement = $connection->prepare($query);
        $statement->bindParam(1, $userId);
        $statement->execute();
        $row = $statement->fetch();

        $name = $row['name'];
    }
    catch (PDOException $exception) {
        die("ERROR: " . $exception->getMessage());
    }

    ?>

    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>Name</td>
            <td><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <a href="index.php" class="btn btn-danger">Back</a>
            </td>
        </tr>
    </table>

    <?php
    try {
        $query = "SELECT id, type, brand FROM car WHERE user_id = ? ORDER BY id";
        $statement = $connection->prepare($query);
        $statement->bindParam(1, $userId);
        $statement->execute();

        $amount = $statement->rowCount();

        echo "<a href='../Car/create.php?userId={$userId}' class='btn btn-primary m-b-1em'>Add a car</a>";

        if ($amount)
        {
            $data = "<h3>{$amount} Cars found</h3><table class='table table-hover table-responsive table-bordered'><tr><th>id</th><th>brand</th><th>type</th><th></th></tr>";

            while ($row = $statement->fetch()) {
                $carId = $row['id'];
                $type = $row['type'];
                $brand = $row['brand'];

                $data .= "<tr>"
                    . "<td>{$carId}</td><td>{$brand}</td><td>{$type}</td><td>"
                    . "<a href='../Car/read_one.php?id={$carId}&userId={$userId}' class='btn btn-info m-r-1em'>Read</a>"
                    . "<a href='../Car/update.php?id={$carId}&userId={$userId}' class='btn btn-primary m-r-1em'>Edit</a>"
                    . "<a href='../Car/delete.php?id={$carId}&userId={$userId}' class='btn btn-danger'>Delete</a>"
                    . "</td></tr>";
            }
            $data .= "</table>";

            echo $data;
        }

    }
    catch (PDOException $exception) {
        die("ERROR: " . $exception->getMessage());
    }
    ?>

</div>

</body>
</html>