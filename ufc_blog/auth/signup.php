<?php
function read_json($filename) {
    if (file_exists($filename)) {
        $data = json_decode(file_get_contents($filename), true);
        return $data ?: []; 
    }
    return [];
}

function write_json($filename, $data) {
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = read_json('../users.json');

    if (isset($users[$username])) {
        echo "Username already taken!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $users[$username] = [
            'username' => $username,
            'password' => $hashedPassword
        ];

        write_json('../users.json', $users);
        echo "User registered successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Sign Up</h2>
    <form method="POST" action="signup.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Sign Up</button>
    </form>

    <p><a href="../index.php">Go back to the homepage</a></p>
</body>
</html>
