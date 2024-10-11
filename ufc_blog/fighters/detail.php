<?php
function read_json($filename) {
    if (file_exists($filename)) {
        $data = json_decode(file_get_contents($filename), true);
        return $data ?: []; 
    }
    return [];
}

$fighterKey = $_GET['fighter'];
$fighters = read_json('../fighters.json');

if (!isset($fighters[$fighterKey])) {
    die("Fighter not found!");
}

$fighter = $fighters[$fighterKey];

$comments = read_json('../comments.json');
$fighterComments = isset($comments[$fighterKey]) ? $comments[$fighterKey] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $fighter['name']; ?> - UFC Fighter</title>
</head>
<body>
    <header>
        <h1><?php echo $fighter['name']; ?></h1>
    </header>
    <section>
        <p><?php echo $fighter['description']; ?></p>
    </section>
    <section>
        <h2>Comments</h2>
        <form action="../comments/add_comment.php" method="POST">
            <input type="hidden" name="fighter" value="<?php echo $fighterKey; ?>">
            <textarea name="comment" placeholder="Add a comment..." required></textarea>
            <button type="submit">Post Comment</button>
        </form>
        <h3>Previous Comments:</h3>
        <ul>
            <?php if (!empty($fighterComments)): ?>
                <?php foreach ($fighterComments as $comment): ?>
                    <li><?php echo htmlspecialchars($comment); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No comments yet.</li>
            <?php endif; ?>
        </ul>
    </section>
</body>
</html>
