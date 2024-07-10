<?php 

session_start();

if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

$db = new PDO('mysql:host=localhost;dbname=oprec', 'root', '');

// if ($db) {
//     echo true;
// }

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $errors = array();

    if (empty(trim($email)) || empty(trim($password))) {
        $errors['required'] = 'inputan tidak boleh ada yang kosong';
        echo "<script>alert('inputan tidak boleh ada yang kosong')</script>";
    } else {
        $statement = $db->prepare('select * from petugas where email = :email');
        $statement->execute([':email'=>$email]);
        if ($statement->rowCount() == 0) {
            $errors['email'] = 'email tidak ditemukan';
            echo "<script>alert('email tidak ditemukan')</script>";
        }
        
        $statement = $db->prepare('select * from petugas where email = :email and password = sha2(:password,256)');
        $statement->execute([':email'=>$email, ':password'=>$password]);
        if ($statement->rowCount() == 0) {
            $errors['password'] = 'password salah';
            echo "<script>alert('password salah')</script>";
        }

        if (!$errors) {
            $_SESSION['login'] = true;

            header('Location: index.php');
            exit();
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <form action="" method="post">

        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="masukkan email" value="<?= $_POST['email'] ?? ''; ?>">
        <br>
        <label for="password">Password</label>
        <input type="text" id="password" name="password" placeholder="masukkan password" value="<?= $_POST['password'] ?? ''; ?>">
        <br>
        <input type="submit" name="submit">

    </form>
    
</body>
</html>