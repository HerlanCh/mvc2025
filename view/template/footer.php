</div> <!-- End main-container -->
    </div> <!-- End container -->

    <!-- Footer -->
    <footer class="text-center mt-5" style="color: white;">
        <div class="container">
            <p class="mb-0">
                <i class="bi bi-heart-fill" style="color: #ef4444;"></i> 
                <?php echo constant("SITE_NAME"); ?> &copy; <?php echo date('Y'); ?> - 
                <?php echo constant("SITE_SLOGAN"); ?>
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Fade in animation for elements
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s`;
                card.style.animationFillMode = 'both';
            });

            // Auto hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.animation = 'slideOut 0.5s ease';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });

        // Confirm delete with custom animation
        function confirmDelete(id, nombre) {
            if(confirm(`¿Estás seguro de eliminar el balón "${nombre}"?`)) {
                window.location.href = `?controller=balon&action=confirmDelete&id=${id}`;
            }
        }

        // Form validation animation
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if(submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="loading"></span> Guardando...';
                }
            });
        });

        // Slide out animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOut {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(20px);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>