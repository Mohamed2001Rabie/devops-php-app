<?php
$servername = "mysql";
$username = "root";
$password = "root";
$dbname = "testdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// إنشاء الجدول لو مش موجود
$conn->query("CREATE TABLE IF NOT EXISTS numbers (id INT AUTO_INCREMENT PRIMARY KEY, value INT)");

// لو المستخدم أرسل رقم من الـ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $value = $_POST['number'];
  if (is_numeric($value)) {
    $conn->query("INSERT INTO numbers (value) VALUES ($value)");
    echo "<p style='color:green;'>✅ تم حفظ الرقم $value في قاعدة البيانات</p>";
  } else {
    echo "<p style='color:red;'>❌ من فضلك أدخل رقمًا صحيحًا</p>";
  }
}

// عرض البيانات الموجودة
$result = $conn->query("SELECT * FROM numbers ORDER BY id DESC");

echo "<h2>📊 الأرقام المسجلة:</h2>";
if ($result->num_rows > 0) {
  echo "<ul>";
  while($row = $result->fetch_assoc()) {
    echo "<li>🔹 رقم: " . $row["value"] . "</li>";
  }
  echo "</ul>";
} else {
  echo "<p>لا توجد بيانات بعد.</p>";
}
?>

<hr>
<h3>➕ أضف رقم جديد</h3>
<form method="post">
  <input type="number" name="number" placeholder="اكتب رقمًا..." required>
  <button type="submit">حفظ</button>
</form>

