
$host = "localhost";
$user = "webapp_user";       // فرضاً حساب با دسترسی نامناسب (ممکن است بیشتر از نیاز حق داشته باشد)
$pass = "webapp_password";
$dbname = "example_db";

// اتصال ساده (بدون مدیریت خطا و بدون تنظیمات امن)
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed");
}

// ورودی از فرم
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// ساخت پرس‌وجو با الحاق مستقیم رشته‌ها — آسیب‌پذیر!
$query = "SELECT id, role FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";

$result = $conn->query($query);

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    // ورود موفق
    session_start();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = $row['role'];
    echo "Login successful";
} else {
    echo "Invalid credentials";
}

$conn->close();
?>
