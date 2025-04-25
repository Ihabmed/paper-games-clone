<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php"><img src="arrow.svg" alt="a flesh" style='width: 50px; height: 50px;'></a>

    <div class="container">
    <?php

    if(isset($_POST["Change_password"])){

        require_once "database.php";
        session_start();

        $password = $_POST["password"];
        $password_confirmation = $_POST["password_confirmation"];

        $errors = array();
                
        if (empty($password) OR empty($password_confirmation)) {
            array_push($errors,"All fields are required");
        }

        if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
        }
        if ($password != $password_confirmation)
        {
            array_push($errors,"Password does not match");
        }

        $id = $_SESSION["user_id"];

        $sql = "SELECT id FROM user
            WHERE id ='$id'";

        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($user === null) {
            array_push($errors,"invalid operation");
        }

        if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
        else {

            $sql = "UPDATE user
                SET password = ?,
                    reset_token_hash = NULL,
                    reset_token_expires_at = NULL
                WHERE id = ?";

            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"si", $password_hash, $user["id"]);
                mysqli_stmt_execute($stmt);
            }
            echo "Password changed successfully.";

            header("Location: index.php");
            die();
        }
    }
    ?>
    <form method="post" action="setting.php">

    <div class="form-group">
        <label for="email">email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="form-group">
    <label for="password">New password</label>
    <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="form-group">
    <label for="password_confirmation">Repeat password</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>

    <div class="form-btn">
        <input type="submit" class="btn btn-primary" value="change password" name="Change_password">
    </div>
    </form>
    </div>
</body>
</html>