<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "missing_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agency = $conn->real_escape_string($_POST['agency']);
    $report_location = $conn->real_escape_string($_POST['report_location']);
    $place = $conn->real_escape_string($_POST['place']);
    $floor = $conn->real_escape_string($_POST['floor']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO missing_reports (agency, report_location, place, floor, message)
            VALUES ('$agency', '$report_location', '$place', '$floor', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<!DOCTYPE html>
        <html lang='ar'>
        <head>
            <meta charset='UTF-8'>
            <title>تم الإرسال</title>
            <style>
                body { font-family: Arial; text-align: center; margin-top: 50px; }
                a { display: inline-block; margin-top: 20px; text-decoration: none; color: #007bff; font-size: 18px; }
                a:hover { color: #0056b3; }
            </style>
        </head>
        <body>
            <h2>تم إرسال البلاغ بنجاح!</h2>
            <a href='missing_report.php'>إرسال بلاغ آخر</a><br>
            <a href='view_reports.php'>عرض قائمة البلاغات</a>
        </body>
        </html>";
    } else {
        echo "حدث خطأ: " . $conn->error;
    }
}

$conn->close();
?>
