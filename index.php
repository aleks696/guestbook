<?php 
require_once("source/defines.php");
if (empty($_SESSION['user_id'])) {
    header("location: source/registration.php");
}
$stmt = $dbConn->prepare("SELECT comments.*, users.username FROM `comments` INNER JOIN `users` ON comments.user_id = users.id ORDER BY id DESC;");
$stmt->execute();
$comments = $stmt->fetchAll();
$stmt_user = $dbConn->prepare('SELECT username FROM users');
$usernames = $stmt_user->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="css/style.css">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">  
    <title>Main Page</title>
</head>
<body class="bg-light">
    <div class="post_page">
        <h1>Posts Page</h1>
        <a class="submit_btn" href="source/logout.php">Logout</a>
    </div>
    <div class="post_page">
        <a class="submit_btn" href="source/addpost.php">Add post</a>
    </div>
    <div class="post_page">
        <h2 class="posts">Posts:</h2>
    </div>
    <div class="comments-panel">
        <?php foreach ($comments as $comment) : ?>
        <div class="comment">
            <p <?php if ($comment['user_id'] == $_SESSION['user_id']) {
                echo 'style="font-weight: bold;"';
            }?>><span class="username"><?php echo $comment['username'];?></span>
            <span>(<?php echo $comment['date'];?>)</span>
            <p class="text-align-justify"><?php echo $comment['comment']?> </p>
            <?php if ($comment['user_id'] == $_SESSION['user_id']) {
                echo "<form action='source/delete.php' method='post'>
                <input type='hidden' name='id' value='" . $comment['id'] . "' />
                <button class='delete_btn'>Delete</button>
                </form>
                ";   
            }?>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
