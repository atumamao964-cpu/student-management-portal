<?php
// ============================================
// DATABASE CONFIGURATION
// Change these values with your InfinityFree credentials
// ============================================

define('DB_HOST', 'sql108.infinityfree.com');
define('DB_NAME', 'if0_42752902_stdnt_ms');      // ← Change this
define('DB_USER', 'if0_42752902');  // ← Change this
define('DB_PASS', 'cY8Sgzi74dKC');  // ← Change this

// ============================================
// DO NOT EDIT BELOW THIS LINE
// ============================================

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    die("<div style='font-family:sans-serif;padding:40px;text-align:center;'>
            <h2 style='color:#e11d48;'>Database Connection Failed</h2>
            <p style='color:#666;'>Please check your database credentials in <code>includes/config.php</code></p>
            <p style='color:#999;font-size:14px;'>" . htmlspecialchars($e->getMessage()) . "</p>
         </div>");
}
?>
