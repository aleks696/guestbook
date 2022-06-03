<?php
require_once("defines.php");
if (!empty($_SESSION['user_id'])) {
    header("location: defines.php");
}
#Errors
$errors = [];
if (!empty($_POST)) {
    if (empty($_POST['user_name'])) {
        $errors[] = 'Please enter User Name';
    }
    if (empty($_POST['email'])) {
        $errors[] = 'Please enter email';
    }
    if (empty($_POST['full_name'])) {
        $errors[] = 'Please enter Full Name';
    }
    if (empty($_POST['password'])) {
        $errors[] = 'Please enter password';
    }
    if (empty($_POST['confirm_password'])) {
        $errors[] = 'Please confirm password';
    }
    if (strlen($_POST['user_name']) > 100) {
        $errors[] = 'User Name is too long. Max length is 100';
    }
    if (strlen($_POST['full_name']) > 100) {
        $errors[] = 'Full Name is too long. Max length is 100';
    }
    if (strlen($_POST['password']) < 5) {
        $errors[] = 'Password should contains at least 5 characters';
    }
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $errors[] = 'Incorrect password';
    }
    if (empty($errors)) {
        $stmt = $dbConn->prepare('INSERT INTO users(`username`, `email`, `password`, `full_name`) VALUES(:username, :email, :password, :full_name)');
        $stmt->execute(array('username' => $_POST['user_name'], 'email' => $_POST['email'], 'password' => sha1($_POST['password'].SALT),
                            'full_name' => $_POST['full_name']));
        header("location: /login.php?registration=1");
    }
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
    <title>Registration</title>
</head>
<body>
    <div class="Registration_page">
        <h1>Registration Page</h1>
        <form method="POST">
            <div style="color: red;">
                <?php foreach ($errors as $error) :?>
                    <p><?php echo $error;?></p>
                <?php endforeach; ?>
            </div>
            <div>
                <label>User Name:</label><br>
                <div>
                    <input type="text" name="user_name" required="" value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name'] : "");?>">
                </div>
            </div>
            <div>
                <label>Email:</label><br>
                <div>
                    <input type="email" name="email" required="" value="<?php echo (!empty($_POST['email']) ? $_POST['email'] : "");?>">
                </div>    
            </div>
            <div>
                <label>Full Name:</label><br>
                <div>
                    <input type="text" name="full_name" required="" value="<?php echo (!empty($_POST['full_name']) ? $_POST['full_name'] : "");?>">
                </div>
            </div>
            <div>
                <label>Password:</label><br>
                <div>
                    <input type="password" name="password" required="" value=""/>
                </div>
            </div>
            <div>
                <label>Confirm password:</label><br>
                <div>
                    <input type="password" name="confirm_password" required="" value=""/>
                </div>
            </div>
            <div class="Submit">
                <input type="submit" name="submit" class="submit_btn" value="Register">
            </div>
        </form>
    </div>
</body>
</html>