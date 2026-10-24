# Student Management Portal

Modern • Elegant • Professional Student Management System  
**Theme:** Soft Rose Pink + Warm Off-white + Stone

---

## Features

- Beautiful Dashboard with live stats
- Add / Edit / Delete students
- Search by name, email, course or address
- Filter by course
- Responsive design
- Real MySQL database (InfinityFree + phpMyAdmin ready)

---

## Student Fields

- Name
- Email
- Age
- Course
- Address

---

## How to Setup on InfinityFree

### 1. Create MySQL Database
1. Login to InfinityFree Control Panel
2. Go to **MySQL Databases**
3. Create a new database
4. Create a user and add the user to the database
5. Note down:
   - Database name
   - Username
   - Password
   - Host (usually `sqlXXX.infinityfree.com`)

### 2. Import the Table
1. Open **phpMyAdmin**
2. Select your database
3. Click **Import**
4. Upload the file `database.sql`
5. Click Go

### 3. Configure the Project
1. Open `includes/config.php`
2. Replace these values:

```php
define('DB_HOST', 'sqlXXX.infinityfree.com');   // your host
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_username');
define('DB_PASS', 'your_database_password');
```

### 4. Upload Files
Upload all files into the `htdocs` folder of your InfinityFree website.

---

## Local Testing (XAMPP)

1. Create a database named `student_portal` in phpMyAdmin
2. Import `database.sql`
3. Edit `includes/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'student_portal');
define('DB_USER', 'root');
define('DB_PASS', '');
```

4. Place the folder in `C:\xampp\htdocs\`
5. Open: `http://localhost/student-management-portal`

---

## Project Structure

```
student-management-portal/
├── index.php              ← Dashboard + Student list
├── add.php                ← Add student
├── edit.php               ← Edit student
├── database.sql           ← Database structure + sample data
├── includes/
│   ├── config.php         ← Database credentials
│   ├── header.php
│   └── footer.php
├── .gitignore
└── README.md
```
