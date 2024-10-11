<?php
session_start();

function read_json($filename) {
    if (file_exists($filename)) {
        $data = json_decode(file_get_contents($filename), true);
        return $data ?: []; 
    }
    return [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = read_json('../users.json');

    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        $_SESSION['username'] = $username;
        header("Location: ../index.php");
    } else {
        echo "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
