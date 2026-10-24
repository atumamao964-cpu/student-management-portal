</main>

<footer class="border-t border-stone-200 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <p class="text-center text-sm text-stone-400">
            Student Management Portal &copy; <?php echo date('Y'); ?> — Elegant & Professional
        </p>
    </div>
</footer>

<script>
    function confirmDelete(name) {
        return confirm('Are you sure you want to delete "' + name + '"?\nThis action cannot be undone.');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('[data-auto-hide]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.4s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 400);
            }, 3500);
        });
    });
</script>
</body>
</html>
