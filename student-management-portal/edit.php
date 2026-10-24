<?php
require_once 'includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    header("Location: index.php");
    exit;
}

$errors = [];
$name    = $student['name'];
$email   = $student['email'];
$age     = $student['age'];
$course  = $student['course'];
$address = $student['address'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $age     = trim($_POST['age'] ?? '');
    $course  = trim($_POST['course'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (empty($name)) $errors[] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($age) || !is_numeric($age) || $age < 1 || $age > 120) $errors[] = "Please enter a valid age (1-120).";
    if (empty($course)) $errors[] = "Course is required.";
    if (empty($address)) $errors[] = "Address is required.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE students SET name=?, email=?, age=?, course=?, address=? WHERE id=?");
        $stmt->execute([$name, $email, (int)$age, $course, $address, $id]);
        header("Location: index.php?msg=updated");
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="mb-8">
    <a href="index.php" class="inline-flex items-center gap-2 text-sm text-stone-500 hover:text-stone-700 mb-4 transition">
        <i class="fas fa-arrow-left text-xs"></i> Back to Dashboard
    </a>
    <h2 class="text-2xl font-semibold text-stone-800">Edit Student</h2>
    <p class="text-stone-500 text-sm mt-1">Update details for <span class="font-medium text-stone-700"><?php echo htmlspecialchars($student['name']); ?></span></p>
</div>

<div class="card max-w-2xl">
    <div class="p-6 sm:p-8">
        <?php if (!empty($errors)): ?>
            <div class="mb-6 px-4 py-3 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-stone-700 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"
                           class="input-field w-full px-4 py-2.5 rounded-xl text-sm" required>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-stone-700 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"
                           class="input-field w-full px-4 py-2.5 rounded-xl text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5">Age</label>
                    <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>"
                           min="1" max="120" class="input-field w-full px-4 py-2.5 rounded-xl text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1.5">Course</label>
                    <input type="text" name="course" value="<?php echo htmlspecialchars($course); ?>"
                           class="input-field w-full px-4 py-2.5 rounded-xl text-sm" required>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-stone-700 mb-1.5">Address</label>
                    <textarea name="address" rows="3"
                              class="input-field w-full px-4 py-2.5 rounded-xl text-sm resize-none" required><?php echo htmlspecialchars($address); ?></textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary px-6 py-2.5 rounded-xl text-white text-sm font-medium shadow-sm">
                    <i class="fas fa-save mr-2 text-xs"></i> Update Student
                </button>
                <a href="index.php" class="px-5 py-2.5 rounded-xl text-sm font-medium bg-stone-100 text-stone-600 hover:bg-stone-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
