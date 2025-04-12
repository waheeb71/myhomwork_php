# نشاط إدخال بيانات الطالب - PHP + MySQL

- عرض قائمة المواد من قاعدة البيانات داخل قائمة منسدلة.
- استقبال اسم الطالب والدرجة والمادة، وتخزينها داخل قاعدة البيانات.

--

## خطوات العمل:

1. تم إنشاء قاعدة بيانات باسم `cyber_code`.
2. تم إنشاء جدولين:
   - جدول `courses` يحتوي على أسماء المواد.
   - جدول `stud_course` يحتوي على سجلات الطلاب المرتبطين بالمواد.
3. تم تنفيذ نموذج (Form) بلغة PHP يحتوي على:
   - اسم الطالب.
   - قائمة منسدلة بالمواد.
   - حقل للدرجة.
4. يتم تخزين البيانات باستخدام `MySQLi` .

---

## كود إنشاء الجداول في قاعدة البيانات:

```sql
CREATE TABLE `stud_course` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_name` VARCHAR(255) NOT NULL,
  `course_name` VARCHAR(255) NOT NULL,
  `grade` INT NOT NULL,
  `submission_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) 

CREATE TABLE `courses` (
  `course_id` INT AUTO_INCREMENT PRIMARY KEY,
  `course_name` VARCHAR(255) NOT NULL UNIQUE
)
