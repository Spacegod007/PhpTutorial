<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Fake car app</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

    <div class="page-header">
        <h1>Update car</h1>
    </div>

    <?php
    $id = isset($_GET['id']) ? $_GET['id'] : die("ERROR: id not found");
    $userId = isset($_GET['userId']) ? $_GET['userId'] : die("ERROR: userId not found");


    include '../config/database.php';

    try {
        $query = "SELECT id, brand, type FROM car WHERE id = ? LIMIT 0,1";
        $statement = $connection->prepare($query);

        $statement->bindParam(1, $id);

        $statement->execute();

        $row = $statement->fetch();

        $id = $row['id'];
        $brand = $row['brand'];
        $type = $row['type'];
    }
    catch (PDOException $exception) {
        die("ERROR: " . $exception->getMessage());
    }
    ?>

    <?php
    if ($_POST) {
        try {
            $query = "UPDATE car SET brand=:brand, type=:type WHERE id=:id";
            $statement = $connection->prepare($query);

            $brand = htmlspecialchars(strip_tags($_POST['brand']));
            $type = htmlspecialchars(strip_tags($_POST['type']));

            $statement->bindParam(":type", $type);
            $statement->bindParam(":brand", $brand);
            $statement->bindParam(":id", $id);

            if ($statement->execute()) {
                echo "<div class='alert alert-success'>Record updated</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>Update failed</div>";
            }
        }
        catch (PDOException $exception)
        {
            die("ERROR: " . $exception->getMessage());
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id={$id}&userId={$userId}") ?>" method="post">
        <table class="table table-hover table-responsive table-bordered">
            <tr>
                <td><label for="brand">Brand</label></td>
                <td><input id="brand" type="text" name="brand" value="<?php echo htmlspecialchars($brand, ENT_QUOTES) ?>" class="form-control"></td>
            </tr>
            <tr>
                <td><label for="type">Type</label></td>
                <td><input id="type" type="text" name="type" value="<?php echo htmlspecialchars($type, ENT_QUOTES) ?>" class="form-control"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Save changes" class="btn btn-primary">
                    <a href="../User/read_one.php?<?php echo "id={$userId}" ?>" class="btn btn-danger">Back</a>
                </td>
            </tr>
        </table>
    </form>

</div>

</body>
</html>