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
        <h3>Create car</h3>
    </div>

    <?php
    if ($_POST) {
        include 'C:/Users/Jordi van Roij/Documents/PhpstormProjects/PhpTutorial/config/database.php';
        parse_str($_SERVER["QUERY_STRING"], $params);

        try {
            $query = "INSERT INTO car SET brand=:brand, type=:type, user_id=:userId";
            $statement = $connection->prepare($query);

            $brand = htmlspecialchars(strip_tags($_POST["brand"]));
            $type = htmlspecialchars(strip_tags($_POST["type"]));
            $userId = $params['userId'];

            $statement->bindParam(":brand", $brand);
            $statement->bindParam(":type", $type);
            $statement->bindParam(":userId", $userId);

            if ($statement->execute()) {
                echo "<div class='alert alert-success'>Car added</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>Failed to add car</div>";
            }
        }
        catch (PDOException $exception) {
            die("Error: " . $exception->getMessage());
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars("{$_SERVER["PHP_SELF"]}?{$_SERVER["QUERY_STRING"]}");?>" method="post">
        <table class="table table-hover table-responsive table-bordered">
            <tr>
                <td>
                    <label for="brand">Brand</label>
                </td>
                <td>
                    <input id="brand" type="text" name="brand" class="form-control" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="type">Type</label>
                </td>
                <td>
                    <input id="type" type="text" name="type" class="form-control" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Save" class="btn btn-primary"/>
                    <a href="../User/read_one.php?<?php echo "id={$params["userId"]}" ?>" class="btn btn-danger">Back</a>
                </td>
            </tr>
        </table>
    </form>


</div>

</body>
</html>

