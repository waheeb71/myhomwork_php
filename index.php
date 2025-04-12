<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "cyber_code";
$courses = [];
$link = mysqli_connect($host, $user, $password, $db);
if (!$link) {
    echo "فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error();
} else {
    mysqli_set_charset($link, "utf8mb4");
    /////////////////////////////  عشان القائمة المنسدلة حق المواد  /////////////////////////////////////
    $query_courses = "SELECT course_id, course_name FROM courses ORDER BY course_name ASC";
    $result_courses = mysqli_query($link, $query_courses);
    if ($result_courses) {
        while ($row = mysqli_fetch_assoc($result_courses)) {
            $courses[] = $row;
        }
        mysqli_free_result($result_courses);
    }

    /////////////////////////////////////////////////////////////////
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $student_name = isset($_POST['student_name']) ? htmlspecialchars(trim($_POST['student_name'])) : '';
        $selected_course_id = isset($_POST['course_id']) ? filter_var(trim($_POST['course_id']), FILTER_VALIDATE_INT) : false;
        $grade = isset($_POST['grade']) ? filter_var(trim($_POST['grade']), FILTER_VALIDATE_INT) : false;
        if (empty($student_name) || $selected_course_id === false || $grade === false) {
            echo "<div style='color:white; background-color:red; padding:10px;'>يرجى ملء جميع الحقول بشكل صحيح.</div>";
        } else {
            $sql = "INSERT INTO stud_course (student_name, course_id, grade) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sii", $student_name, $selected_course_id, $grade);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<div style='color:white; background-color:green; padding:10px;'>تمت إضافة السجل بنجاح!</div>";
                } else {
                    echo "<div style='color:white; background-color:red; padding:10px;'>فشل في تنفيذ الاستعلام.</div>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<div style='color:white; background-color:red; padding:10px;'>فشل في تجهيز الاستعلام.</div>";
            }
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////

    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدخال بيانات الطالب</title>
</head>
<style>
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f4f7f6;
  color: #333;
  margin: 0;
  padding: 20px;
  direction: rtl;
}

form {
  background-color: #ffffff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  max-width: 500px;
  margin: 40px auto;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
  color: #555;
}

input[type="text"],
input[type="number"],
select {
  width: 100%;
  padding: 12px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus {
  border-color: #007bff;
  outline: none;
}

.button-container {
  display: flex;
  gap: 10px;
  justify-content: flex-start;
}

button {
  padding: 12px 25px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: bold;
  transition: background-color 0.3s ease, transform 0.1s ease;
}

button[type="submit"] {
  background-color: #28a745;
  color: white;
}

button[type="submit"]:hover {
  background-color: #218838;
  transform: translateY(-1px);
}

button[type="reset"] {
  background-color: #6c757d;
  color: white;
}

button[type="reset"]:hover {
  background-color: #5a6268;
  transform: translateY(-1px);
}

.message {
  padding: 15px;
  margin: 20px 0;
  border-radius: 5px;
  color: #ffffff;
  text-align: center;
  font-weight: bold;
}

.success-message {
  background-color: #28a745;
  border: 1px solid #1e7e34;
}

.error-message {
  background-color: #dc3545;
  border: 1px solid #bd2130;
}
</style>
<body style="font-family: sans-serif; direction: rtl; margin: 20px;">
    <form action="" method="post">
        <label>اسم الطالب:</label><br>
        <input type="text" name="student_name" required><br><br>
        <label>المادة:</label><br>
        <select name="course_id" required>
            <option value="" disabled selected></option>
        
            <?php
            if (!empty($courses)) {
                foreach ($courses as $course) {
                    echo "<option value='" . $course['course_id'] . "'>" . htmlspecialchars($course['course_name']) . "</option>";
                }
            } else {
                echo "<option disabled>لا توجد مواد</option>";
            }
            ?>
        </select><br><br>
        <label>الدرجة:</label><br>
        <input type="number" name="grade" required><br><br>
        <button type="submit">إدخال</button>
        <button type="reset">تجاهل</button>
    </form>
</body>
</html>


