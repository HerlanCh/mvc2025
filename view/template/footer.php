            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white py-4 mt-5" style="background: var(--primary-color);">
        <div class="container">
            <p class="mb-0">
                <i class="fas fa-basketball-ball me-2"></i>BallStore &copy; <?php echo date('Y'); ?> - Todos los derechos reservados
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Animaciones adicionales
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto de aparición para las tarjetas
            const cards = document.querySelectorAll('.ball-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>