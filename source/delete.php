<?php 
if (isset($_POST["id"])) {
    $conn = new mysqli("localhost", "root","", "guestbook");
    $comment_id = $conn->real_escape_string($_POST["id"]);
    $sql = "DELETE FROM comments WHERE id = '$comment_id'";
    if ($conn->query($sql)) {            
        header("Location: \index.php");
    }
    else {
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();  
}
?>