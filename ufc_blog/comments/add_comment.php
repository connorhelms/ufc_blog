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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fighterKey = $_POST['fighter'];
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        $comments = read_json('../comments.json');

        if (!isset($comments[$fighterKey])) {
            $comments[$fighterKey] = [];
        }
        $comments[$fighterKey][] = $comment;

        write_json('../comments.json', $comments);
    }

    header("Location: ../fighters/detail.php?fighter={$fighterKey}");
}
?>
