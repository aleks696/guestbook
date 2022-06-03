<?php 
require_once("defines.php");
if (!empty($_SESSION['user_id'])) {
    header("location: \index.php");
}

$errors = [];
$Registered = 0;
$Authorized = 0;
if (!empty($_GET['registration'])) {
    $Registered = 1;
}
if (!empty($_POST)) {
    if (empty($_POST['user_name'])) {
        $errors[] = 'Please enter User Name / Email';
    }
    if (empty($_POST['password'])) {
        $errors[] = 'Please enter password';
    }
    if (empty($errors)) {
        $stmt = $dbConn->prepare('SELECT id FROM users WHERE (username = :username or email = :username) and password = :password');
        $stmt->execute(array('username' => $_POST['user_name'], 'password' => sha1($_POST['password'].SALT)));
        $id = $stmt->fetchColumn();
        if (!empty($id)) {
            $_SESSION['user_id'] = $id;
            //die("Вы успешно авторизинованны");
            header("location: \index.php");
        } else {
            $errors[] = 'Please enter another suitable information';
        }
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
    <title>Login</title>
</head>
<body>

    <div class="registration_page">
        <h1>Log In Page</h1>
        <form method="POST">
            <div style="color: red;">
                <?php foreach ($errors as $error) :?>
                    <p><?php echo $error;?></p>
                <?php endforeach; ?>
                <?php if(!empty($Registered)) :?>
                    <p>Вы успешно зарегестрировались! Используйте свои данные для входа на сайт</p>
                <?php endif; ?>
            </div>
            <div>
                <label>User Name / Email:</label>
                <div>
                    <input type="text" name="user_name" required="" value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name'] : '');?>"/>
                </div>
            </div>
            <div>
                <label>Password:</label>
                <div>
                    <input type="password" name="password" required="" value=""/>
                </div>
            </div>
            <div>
                <br/>
                <input type="submit" name="submit" class="submit_btn" value="Log In">
            </div>      
        </form>
    </div>
</body>
</html>