<<?php
session_start();
include "config.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cocokkan dengan password MD5
    $cek = mysqli_query($koneksi, 
        "SELECT * FROM users WHERE username='$username' AND password=MD5('$password')"
    );

    $data = mysqli_fetch_assoc($cek);

    if ($data) {
        $_SESSION['login'] = true;
        $_SESSION['role'] = $data['role'];
        $_SESSION['username'] = $data['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            width: 380px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .title {
            font-weight: 700;
        }
        .input-group-text {
            background: #4e73df;
            color: white;
        }
    </style>
</head>

<body>

<div class="card login-card p-4">
    <h3 class="text-center title mb-4">🔐 Login Sistem</h3>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger py-2 text-center">
            <?= $error ?>
        </div>
    <?php } ?>

    <form method="POST">

        <div class="form-group">
            <label>Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
        </div>

        <button type="submit" name="login" class="btn btn-primary btn-block mt-3">
            Login Sekarang
        </button>

    </form>
</div>

</body>
</html>
