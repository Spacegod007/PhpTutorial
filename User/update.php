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
        <h1>Update user</h1>
    </div>

    <?php
    $id = isset($_GET['id']) ? $_GET['id'] : die("ERROR: id not found");

    include '../config/database.php';

    try {
        $query = "SELECT name FROM app_user WHERE id = ? LIMIT 0,1";
        $statement = $connection->prepare($query);

        $statement->bindParam(1, $id);

        $statement->execute();

        $row = $statement->fetch();

        $name = $row['name'];
    }
    catch (PDOException $exception) {
        die("ERROR: " . $exception->getMessage());
    }
    ?>

    <?php
    if ($_POST) {
        try {
            $query = "UPDATE app_user SET name=:name WHERE id=:id";
            $statement = $connection->prepare($query);

            $name = htmlspecialchars(strip_tags($_POST['name']));

            $statement->bindParam(":name", $name);
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

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id={$id}") ?>" method="post">
        <table class="table table-hover table-responsive table-bordered">
            <tr>
                <td><label for="name">Name</label></td>
                <td><input id="name" type="text" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES) ?>" class="form-control"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Save changes" class="btn btn-primary">
                    <a href="index.php" class="btn btn-danger">Back</a>
                </td>
            </tr>
        </table>
    </form>

</div>

</body>
</html>