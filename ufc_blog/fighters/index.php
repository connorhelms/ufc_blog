<?php
session_start();  

function read_json($filename) {
    if (file_exists($filename)) {
        $data = json_decode(file_get_contents($filename), true);
        return $data ?: []; 
    }
    return [];
}

$blog_posts = read_json('blog/posts.json');
$fighters = read_json('fighters.json');

usort($blog_posts, function ($a, $b) {
    return strtotime($b['timestamp']) - strtotime($a['timestamp']);
});

$recent_posts = array_slice($blog_posts, 0, 5);

$famous_fighters = array_slice($fighters, 0, 5);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFC Blog - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to the UFC Fighters Blog</h1>
        <nav>
            <a href="auth/login.php">Login</a> | 
            <a href="auth/signup.php">Sign Up</a>
        </nav>
    </header>

    <?php if (isset($_SESSION['username'])): ?>
        <p><a href="blog/create_post.php" class="button">Create a New Blog Post</a></p>
    <?php endif; ?>

    <section>
        <h2>Recent Blog Posts</h2>
        <ul>
            <?php foreach ($recent_posts as $post): ?>
                <li>
                    <strong><?php echo $post['title']; ?></strong> <br>
                    <?php echo $post['content']; ?> <br>
                    <small>Posted on: <?php echo date('F j, Y', strtotime($post['timestamp'])); ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section>
        <h2>Famous UFC Fighters</h2>
        <ul>
            <?php foreach ($famous_fighters as $fighterKey => $fighter): ?>
                <li>
                    <strong><?php echo $fighter['name']; ?></strong><br>
                    <p><?php echo $fighter['description']; ?></p>
                    <form action="fighters/detail.php" method="GET">
                        <input type="hidden" name="fighter" value="<?php echo $fighterKey; ?>">
                        <button type="submit">Go to Details</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>
