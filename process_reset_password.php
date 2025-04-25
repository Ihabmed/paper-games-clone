<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

require_once "database.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = '$token_hash'";

$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE user
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = mysqli_stmt_init($conn);
$prepareStmt = mysqli_stmt_prepare($stmt,$sql);
if ($prepareStmt) {
    mysqli_stmt_bind_param($stmt,"si", $password_hash, $user["id"]);
    mysqli_stmt_execute($stmt);
}

echo "Password updated. You can now login.";

header("Location: login.php");