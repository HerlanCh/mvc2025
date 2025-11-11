<h1 class="page-title">
    <i class="bi bi-check-circle"></i> Balón Eliminado
</h1>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>

                <h3 class="mb-3">¡Eliminado con éxito!</h3>
                <p class="text-muted mb-4">
                    El balón ha sido eliminado permanentemente del sistema.
                </p>

                <a href="?controller=balon&action=list" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Volver al Catálogo
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto redirect after 3 seconds
    setTimeout(function() {
        window.location.href = '?controller=balon&action=list';
    }, 3000);
</script>