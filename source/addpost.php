<?php 
require_once("defines.php");
if (empty($_SESSION['user_id'])) {
    header("location: /login.php");
}

if (!empty($_POST['comment'])) {
    $stmt = $dbConn->prepare('INSERT INTO comments(`user_id`, `comment`) VALUES(:user_id, :comment)');
    $stmt->execute(array('user_id' => $_SESSION['user_id'], 'comment' => $_POST['comment']));
    header("location: \index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="css/style.css">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Post</title>
</head>
<body class="bg-light">
    <div class="post">
        <div class="comments_header">
            <h1>Please add your post</h1>
            <a class="submit_btn" href="/logout.php">Logout</a>
        </div>
        <div class="comment_form">
            <form method="POST">
                <div>
                    <label>Comment</label>
                    <div>
                        <textarea name="comment"></textarea>
                    </div>
                </div>
                <div>
                    <input type="submit" name="submit" class="submit_btn" value="Save">
                </div>
            </form>
        </div>
    </div>
</body>
</html>