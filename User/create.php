<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fake car app</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<h1>Fake car app</h1>

<div class="container">
    <div class="page-header">
        <h3>Create user</h3>
    </div>

    <?php
    if ($_POST) {
        include '../config/database.php';
        try {
            $query = "INSERT INTO app_user SET name=:name";
            $statement = $connection->prepare($query);

            $name = htmlspecialchars(strip_tags($_POST["name"]));

            $statement->bindParam(":name", $name);

            if ($statement->execute()) {
                echo "<div class='alert alert-success'>User added</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>Failed to add user</div>";
            }
        }
        catch (PDOException $exception) {
            die("Error: " . $exception->getMessage());
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <table class="table table-hover table-responsive table-bordered">
            <tr>
                <td>
                    <label for="name">Name</label>
                </td>
                <td>
                    <input id="name" type="text" name="name" class="form-control" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Save" class="btn btn-primary"/>
                    <a href="index.php" class="btn btn-danger">Back</a>
                </td>
            </tr>
        </table>
    </form>


</div>

</body>
</html>

