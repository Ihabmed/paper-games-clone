<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php"><img src="arrow.svg" alt="an arrow" style='width: 50px; height: 50px;'></a>
    <div>
    <?php

        session_start();

        $id = $_SESSION["user_id"];

        require_once "database.php";

        $username_sql = "SELECT username FROM user WHERE id=$id";

        $username = mysqli_query($conn, $username_sql);
        $username2 = mysqli_fetch_array($username, MYSQLI_ASSOC);

        echo "<h1 style='margin-left: 550px;'>Profile de " . $username2['username'] . "</h1>";

        $sql = "SELECT id, COUNT(id) as total_victoires FROM `partie`, `user` WHERE (user_1 = $id or user_2 = $id) and gagne = $id GROUP BY id";

        $sql2 = "SELECT id, COUNT(id) as total_defaites FROM `partie`, `user` WHERE (user_1 = $id or user_2 = $id) and gagne != $id GROUP BY id";

        $sql3 = "SELECT u.username as 'user_1', u1.username as 'user_2', p.temps_termine as temps_termine, u2.username as 'gagne' FROM `partie` p JOIN `user` u ON u.id = p.user_1 JOIN `user` u1 ON u1.id = p.user_2 JOIN `user` u2 ON u2.id = p.gagne WHERE p.user_1 = $id or p.user_2 = $id ORDER BY p.temps_termine DESC";

        $result = mysqli_query($conn, $sql);
        $result2 = mysqli_query($conn, $sql2);
        $result3 = mysqli_query($conn, $sql3);

        $victoires = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $defaites = mysqli_fetch_array($result2, MYSQLI_ASSOC);
        
        echo "<table style='padding: 10px; margin-left: 350px;'>";
        echo "<tr>";
        echo "<th style='width: 100px; border: 2px solid black; border-collapse: collapse; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; background-color: navy; color: white;'>Totale parties joué</th>";
        echo "<th style='width: 100px; border: 2px solid black; border-collapse: collapse; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; background-color: navy; color: white;'>Victoires</th>";
        echo "<th style='width: 100px; border: 2px solid black; border-collapse: collapse; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; background-color: navy; color: white;'>Defaites</th>";
        echo "<th style='width: 100px; border: 2px solid black; border-collapse: collapse; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; background-color: navy; color: white;'>Statistique</th>";
        echo "</tr>";

        echo "<tr>";

        echo "<td style='text-align: center; padding: 10px; background-color: lightgray;'> ". $victoires['total_victoires'] + $defaites['total_defaites'] . "</td>";
    
        echo "<td style='text-align: center; background-color: lightgray;'>". $victoires['total_victoires'] . "</td>";

        echo "<td style='text-align: center; background-color: lightgray;'>". $defaites['total_defaites'] . "</td>";

        echo "<td style='text-align: center; background-color: lightgray;'>" . intval($victoires['total_victoires'] * 100 / ($victoires['total_victoires'] + $defaites['total_defaites'])) . " %</td>";

        echo "</tr>";

        echo "</table'>";

        echo "<table style='padding: 10px;margin-left: 475px; margin-top: 20px;'>";
        echo "<caption><h2>Historique des parties</h2></caption>";
        echo "<tr>";
        echo "<th style='width: 100px; border: 2px solid black; border-collapse: collapse; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; background-color: navy; color: white;'>opponent</th>";
        echo "<th style='width: 150px; border: 2px solid black; border-collapse: collapse; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; background-color: navy; color: white;'>Temps</th>";
        while($user = mysqli_fetch_assoc($result3)) {
            if ($user['gagne'] == $username2['username'])
            {
                echo "<tr style='border: 2px solid; border-collapse: collapse; background-color: lightgreen;'>";
            } else
            {
                echo "<tr style='border: 2px solid; border-collapse: collapse; background-color: lightcoral;'>";
            }
            if ($user['user_1'] == $username2['username'])
            {
                echo "<td style='padding: 10px; text-align: center;'>" . $user['user_2'] . "</td>";
            } else
            {
                echo "<td style='padding: 10px; text-align: center;'>" . $user['user_1'] . "</td>";
            }
            echo "<td style='padding: 10px; text-align: center;'>" . $user['temps_termine'] . "</td>";
            echo "</tr>";   
        }
    ?>
    </div>
</body>
</html>