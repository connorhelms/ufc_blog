<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit;
}

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
    $title = $_POST['title'];
    $content = $_POST['content'];
    $timestamp = date('Y-m-d');  

    $blog_posts = read_json('../blog/posts.json');

    $new_post = [
        'title' => $title,
        'content' => $content,
        'timestamp' => $timestamp
    ];

    array_unshift($blog_posts, $new_post);

    write_json('../blog/posts.json', $blog_posts);

    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a New Blog Post</title>
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>
    <section>
        <h2>Create a New Blog Post</h2>
        <form method="POST" action="create_post.php">
            <label for="title">Title:</label>
            <input type="text" name="title" required>
            <label for="content">Content:</label>
            <textarea name="content" rows="5" required></textarea>
            <button type="submit">Create Post</button>
        </form>

        <p><a href="../index.php">Go back to the homepage</a></p>
    </section>
</body>
</html>
