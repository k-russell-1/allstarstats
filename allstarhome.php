<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles2.css">
    <title>All-Star Team-Up Stats</title>
</head>
<body>
    <header>
        <h1>All-Star Reference</h1>
        <nav>
            <ul>
                <li><a href="allstarhome.php">Home</a></li>
                <li><a href="players.php">Players</a></li>
                <li><a href="games.php">Notable Team Games</a></li>
                <li><a href="extras.php">Notable Individual Games</a></li>
            </ul>
        </nav>
    </header>
    
    <section class="content">
        <h2>Recent Games</h2>
    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nba2kstat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT gs.our_score, gs.their_score, gs.conf, gs.minutes_played, gs.game_id
    FROM `game_stat` gs 
    order by gs.game_id desc limit 5";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gid = $row["game_id"];
        if ($row["minutes_played"] < 20) {
            echo "<br> <h3> FINAL (incomplete): " . $row["our_score"]. " - " . $row["their_score"]. ". Conference: " . $row["conf"]. ". " . $row["minutes_played"]. " minutes played. </h3> <br>";
        }
        else {
            echo "FINAL: " . $row["our_score"]. " - " . $row["their_score"]. ". Conference: " . $row["conf"]. "<br>";
        }
        $sql2 = "SELECT pid.first_name, pid.last_name, ps.points, ps.assists, ps.rebounds, ps.steals, ps.blocks
        FROM `player_stat` ps
        JOIN `player_id` pid on ps.player_id = pid.idnum
        where ps.game_id = $gid";
        $result2 = $conn->query($sql2);
        if (!$result2) {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
        if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
                echo "" . $row2["first_name"]. " " . $row2["last_name"]. ": " . $row2["points"]. " points, " . $row2["rebounds"]. " rebounds, " . $row2["assists"]. " assists, " . $row2["steals"]. " steals, " . $row2["blocks"]. " blocks. <br>" ;
            }
        }
    }
} else {
    echo "0 results";
}

$conn->close();
?>
    </section>
    
    <footer>
        <p>&copy; Me</p>
    </footer>
</body>
</html>
