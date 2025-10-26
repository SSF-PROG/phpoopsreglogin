<?php
session_start();
if(strlen($_SESSION['uid'])=="") {
    header('location:signin.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "missing_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error); }

$sql = "SELECT * FROM missing_reports ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>قائمة البلاغات</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #007bff; color: white; }
        h2 { text-align: center; }
        a { text-decoration: none; color: #007bff; margin-top: 10px; display: inline-block; }
    </style>
</head>
<body>
    <h2>قائمة البلاغات</h2>
    <table>
        <tr>
            <th>الجهة</th>
            <th>موقع البلاغ</th>
            <th>المكان</th>
            <th>الدور</th>
            <th>تفاصيل البلاغ</th>
            <th>تاريخ البلاغ</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['agency'])."</td>";
                echo "<td>".htmlspecialchars($row['report_location'])."</td>";
                echo "<td>".htmlspecialchars($row['place'])."</td>";
                echo "<td>".htmlspecialchars($row['floor'])."</td>";
                echo "<td>".htmlspecialchars($row['message'])."</td>";
                echo "<td>".htmlspecialchars($row['created_at'])."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>لا توجد بلاغات حتى الآن</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="missing_report.php">إرسال بلاغ جديد</a>
</body>
</html>
<?php $conn->close(); ?>
