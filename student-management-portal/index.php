<?php
require_once 'includes/config.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php?msg=deleted");
    exit;
}

// Search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$course_filter = isset($_GET['course']) ? trim($_GET['course']) : '';

$sql = "SELECT * FROM students WHERE 1=1";
$params = [];

if ($search) {
    $sql .= " AND (name LIKE ? OR email LIKE ? OR course LIKE ? OR address LIKE ?)";
    $term = "%$search%";
    $params = array_merge($params, [$term, $term, $term, $term]);
}

if ($course_filter) {
    $sql .= " AND course = ?";
    $params[] = $course_filter;
}

$sql .= " ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$students = $stmt->fetchAll();

// Stats
$totalStudents = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$avgAge = $pdo->query("SELECT ROUND(AVG(age), 1) FROM students")->fetchColumn() ?: 0;
$uniqueCourses = $pdo->query("SELECT COUNT(DISTINCT course) FROM students")->fetchColumn();
$recentCount = $pdo->query("SELECT COUNT(*) FROM students WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn();

// Get unique courses for filter
$courses = $pdo->query("SELECT DISTINCT course FROM students ORDER BY course")->fetchAll(PDO::FETCH_COLUMN);
?>

<?php include 'includes/header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h2 class="text-2xl font-semibold text-stone-800">Dashboard Overview</h2>
    <p class="text-stone-500 text-sm mt-1">Manage students, courses and academic records</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="card stat-card p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-stone-500 mb-1">Total Students</p>
                <p class="text-2xl font-semibold text-stone-800"><?php echo number_format($totalStudents); ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-rose-50 flex items-center justify-center">
                <i class="fas fa-users text-rose-500"></i>
            </div>
        </div>
    </div>

    <div class="card stat-card p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-stone-500 mb-1">Active Courses</p>
                <p class="text-2xl font-semibold text-stone-800"><?php echo $uniqueCourses; ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center">
                <i class="fas fa-book text-orange-500"></i>
            </div>
        </div>
    </div>

    <div class="card stat-card p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-stone-500 mb-1">New This Month</p>
                <p class="text-2xl font-semibold text-stone-800"><?php echo $recentCount; ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                <i class="fas fa-calendar-plus text-emerald-500"></i>
            </div>
        </div>
    </div>

    <div class="card stat-card p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-stone-500 mb-1">Average Age</p>
                <p class="text-2xl font-semibold text-stone-800"><?php echo $avgAge; ?></p>
            </div>
            <div class="w-11 h-11 rounded-xl bg-violet-50 flex items-center justify-center">
                <i class="fas fa-user text-violet-500"></i>
            </div>
        </div>
    </div>
</div>

<!-- Alerts -->
<?php if (isset($_GET['msg'])): ?>
    <?php
    $messages = [
        'added'   => ['Student added successfully!', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
        'updated' => ['Student updated successfully!', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
        'deleted' => ['Student deleted successfully!', 'bg-rose-50 text-rose-700 border-rose-200'],
    ];
    if (isset($messages[$_GET['msg']])):
    ?>
    <div data-auto-hide class="mb-6 px-4 py-3 rounded-xl border text-sm flex items-center gap-3 <?php echo $messages[$_GET['msg']][1]; ?>">
        <i class="fas fa-check-circle"></i>
        <?php echo $messages[$_GET['msg']][0]; ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Students Section -->
<div class="card overflow-hidden">
    <div class="p-5 border-b border-stone-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-stone-800">Students</h3>
            <p class="text-sm text-stone-500"><?php echo count($students); ?> student<?php echo count($students) !== 1 ? 's' : ''; ?> found</p>
        </div>
        <a href="add.php" class="btn-primary inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-white text-sm font-medium shadow-sm">
            <i class="fas fa-plus text-xs"></i>
            Add Student
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="p-5 border-b border-stone-100 bg-stone-50/50">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-sm"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"
                       placeholder="Search by name, email, course or address..."
                       class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl text-sm">
            </div>
            <select name="course" class="input-field px-4 py-2.5 rounded-xl text-sm text-stone-600 min-w-[160px]">
                <option value="">All Courses</option>
                <?php foreach ($courses as $c): ?>
                    <option value="<?php echo htmlspecialchars($c); ?>" <?php echo $course_filter === $c ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($c); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-medium">
                Search
            </button>
            <?php if ($search || $course_filter): ?>
                <a href="index.php" class="px-4 py-2.5 rounded-xl text-sm font-medium bg-stone-100 text-stone-600 hover:bg-stone-200 transition flex items-center">
                    Clear
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Table -->
    <?php if (empty($students)): ?>
        <div class="py-16 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-stone-100 flex items-center justify-center">
                <i class="fas fa-users text-2xl text-stone-400"></i>
            </div>
            <h3 class="text-stone-700 font-medium mb-1">No students found</h3>
            <p class="text-stone-400 text-sm mb-6">Get started by adding your first student.</p>
            <a href="add.php" class="btn-primary inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-white text-sm font-medium">
                <i class="fas fa-plus text-xs"></i> Add First Student
            </a>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-stone-100 bg-stone-50/80">
                        <th class="text-left px-6 py-3.5 font-medium text-stone-500 text-xs uppercase tracking-wider">Student</th>
                        <th class="text-left px-6 py-3.5 font-medium text-stone-500 text-xs uppercase tracking-wider">Age</th>
                        <th class="text-left px-6 py-3.5 font-medium text-stone-500 text-xs uppercase tracking-wider">Course</th>
                        <th class="text-left px-6 py-3.5 font-medium text-stone-500 text-xs uppercase tracking-wider">Address</th>
                        <th class="text-right px-6 py-3.5 font-medium text-stone-500 text-xs uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    <?php 
                    $colors = ['bg-rose-100 text-rose-600', 'bg-orange-100 text-orange-600', 'bg-emerald-100 text-emerald-600', 'bg-violet-100 text-violet-600', 'bg-sky-100 text-sky-600', 'bg-amber-100 text-amber-600'];
                    foreach ($students as $i => $student): 
                        $color = $colors[$i % count($colors)];
                        $initials = strtoupper(substr($student['name'], 0, 1) . (strpos($student['name'], ' ') ? substr($student['name'], strpos($student['name'], ' ') + 1, 1) : ''));
                    ?>
                    <tr class="hover:bg-stone-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full <?php echo $color; ?> flex items-center justify-center text-xs font-semibold">
                                    <?php echo $initials; ?>
                                </div>
                                <div>
                                    <p class="font-medium text-stone-800"><?php echo htmlspecialchars($student['name']); ?></p>
                                    <p class="text-xs text-stone-400"><?php echo htmlspecialchars($student['email'] ?? ''); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-stone-600"><?php echo htmlspecialchars($student['age']); ?></td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-stone-100 text-stone-600">
                                <?php echo htmlspecialchars($student['course']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-stone-600 max-w-[200px] truncate"><?php echo htmlspecialchars($student['address']); ?></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="edit.php?id=<?php echo $student['id']; ?>"
                                   class="w-8 h-8 rounded-lg flex items-center justify-center text-stone-400 hover:bg-stone-100 hover:text-stone-700 transition"
                                   title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <a href="index.php?delete=<?php echo $student['id']; ?>"
                                   onclick="return confirmDelete('<?php echo htmlspecialchars(addslashes($student['name'])); ?>')"
                                   class="w-8 h-8 rounded-lg flex items-center justify-center text-stone-400 hover:bg-rose-50 hover:text-rose-600 transition"
                                   title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
