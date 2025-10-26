<?php
session_start();
// include Function file
include_once('function.php');
// Object creation
$usercredentials = new DB_con();

if(isset($_POST['signin']))
{
    // Posted Values
    $uname = $_POST['username'];
    $pasword = md5($_POST['password']);

    // Function Calling
    $ret = $usercredentials->signin($uname, $pasword);
    $num = mysqli_fetch_array($ret);

    if($num > 0)
    {
        $_SESSION['uid'] = $num['id'];
        $_SESSION['fname'] = $num['FullName'];
        // تحويل مباشرة إلى لوحة التحكم الجديدة
        echo "<script>window.location.href='dashboard.php'</script>";
    }
    else
    {
        // Message for unsuccessful login
        echo "<script>alert('Invalid details. Please try again');</script>";
        echo "<script>window.location.href='signin.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>مرحبا بكم في منصة ميسرون لخدمة ضيوف الرحمن</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assests/style.css" rel="stylesheet">
    <script src="assests/jquery-1.11.1.min.js"></script>
    <script src="assests/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        legend {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 25px;
            display: block;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<form action='' method="POST">
  <fieldset>
    <legend>التسجيل في منصة ميسرون</legend>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div class="form-group">
        <button type="submit" name="signin">Signin</button>
    </div>

    <div class="form-group">
        Not Registered yet? <a href="index.php">Register Here</a>
    </div>
  </fieldset>
</form>
</body>
</html>
