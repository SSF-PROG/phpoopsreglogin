<?php
session_start();
if(strlen($_SESSION['uid'])=="") {
    header('location:signin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>إبلاغ عن مفقود</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial; margin: 20px; }
        .container { max-width: 500px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px; background-color: #f9f9f9; }
        h2 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        button { display: block; width: 100%; padding: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <h2>إبلاغ عن مفقود</h2>
    <form action="submit_missing.php" method="POST">
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
            <textarea id="message" name="message" rows="5" placeholder="اكتب التفاصيل هنا" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit">إرسال</button>
        </div>
    </form>
</div>
</body>
</html>
