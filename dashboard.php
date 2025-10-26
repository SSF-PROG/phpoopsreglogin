<?php
session_start();
if (!isset($_SESSION['uid']) || empty($_SESSION['uid'])) {
    header('location:signin.php');
    exit();
}

// إعداد الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "missing_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error); }

// التعامل مع إرسال البلاغ
$messageSent = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agency = $conn->real_escape_string($_POST['agency']);
    $report_location = $conn->real_escape_string($_POST['report_location']);
    $place = $conn->real_escape_string($_POST['place']);
    $floor = $conn->real_escape_string($_POST['floor']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO missing_reports (agency, report_location, place, floor, message)
            VALUES ('$agency', '$report_location', '$place', '$floor', '$message')";

    if ($conn->query($sql) === TRUE) {
        $messageSent = true;
    } else {
        $error = $conn->error;
    }
}

// جلب البلاغات السابقة
$sqlReports = "SELECT * FROM missing_reports ORDER BY created_at DESC";
$resultReports = $conn->query($sqlReports);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>لوحة التحكم - البلاغات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial; margin: 20px; }
        .container { max-width: 900px; margin: auto; }
        h2 { text-align: center; margin-bottom: 20px; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 8px; background-color: #f9f9f9; margin-bottom: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        button { display: block; width: 100%; padding: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #007bff; color: white; }
        .success { color: green; text-align: center; margin-bottom: 20px; }
        .error { color: red; text-align: center; margin-bottom: 20px; }
        a.logout { float: right; margin-bottom: 10px; color: #007bff; text-decoration: none; }
        a.logout:hover { color: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <a href="logout.php" class="logout">تسجيل الخروج</a>
    <h2>مرحبا <?php echo htmlspecialchars($_SESSION['fname']); ?> - لوحة التحكم</h2>

    <?php if ($messageSent) echo "<div class='success'>تم إرسال البلاغ بنجاح!</div>"; ?>
    <?php if (!empty($error)) echo "<div class='error'>حدث خطأ: $error</div>"; ?>

    <!-- فورم إرسال البلاغ -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="agency">اسم الجهة</label>
            <select id="agency" name="agency" required>
                <option value="">اختر الجهة</option>
                <option value="المرور">المرور</option>
                <option value="الشرطة">الشرطة</option>
                <option value="عام">عام</option>
                <option value="للحجاج">للحجاج</option>
            </select>
        </div>
        <div class="form-group">
            <label for="report_location">موقع البلاغ</label>
            <select id="report_location" name="report_location" required>
                <option value="">اختر الموقع</option>
                <option value="حدود الحرم">حدود الحرم</option>
                <option value="داخل الحرم">داخل الحرم</option>
            </select>
        </div>
        <div class="form-group">
            <label for="place">المكان</label>
            <select id="place" name="place" required>
                <option value="">اختر المكان</option>
                <option value="الطواف">الطواف</option>
                <option value="المسعى">المسعى</option>
                <option value="الصحن">الصحن</option>
            </select>
        </div>
        <div class="form-group">
            <label for="floor">الدور</label>
            <select id="floor" name="floor" required>
                <option value="">اختر الدور</option>
                <option value="الأول">الأول</option>
                <option value="الثاني">الثاني</option>
                <option value="الثالث">الثالث</option>
            </select>
        </div>
        <div class="form-group">
            <label for="message">تفاصيل المفقود</label>
            <textarea id="message" name="message" rows="4" placeholder="اكتب التفاصيل هنا" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit">إرسال البلاغ</button>
        </div>
    </form>

    <!-- جدول البلاغات السابقة -->
    <h2>البلاغات السابقة</h2>
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
        if ($resultReports->num_rows > 0) {
            while($row = $resultReports->fetch_assoc()) {
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
</div>
</body>
</html>

<?php $conn->close(); ?>
