<h1 class="page-title">
    <i class="bi bi-check-circle"></i> Cliente Eliminado
</h1>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-body p-5 text-center">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                <h3 class="mb-3 mt-3">¡Eliminado con éxito!</h3>
                <p class="text-muted mb-4">
                    El cliente ha sido eliminado permanentemente del sistema.
                </p>
                <a href="?controller=cliente&action=list" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Volver a Clientes
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        window.location.href = '?controller=cliente&action=list';
    }, 3000);
</script>