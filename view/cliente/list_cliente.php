<h1 class="page-title">
    <i class="bi bi-people-fill"></i> <?php echo $controller->page_title; ?>
</h1>

<?php if(isset($_GET["response"]) && $_GET["response"] === true): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> 
        <strong>¡Éxito!</strong> Operación realizada correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">
        <i class="bi bi-person-badge"></i> Total de clientes: 
        <strong><?php echo count($dataToView["data"]); ?></strong>
    </p>
    <a href="?controller=cliente&action=create" class="btn btn-success">
        <i class="bi bi-person-plus"></i> Nuevo Cliente
    </a>
</div>

<?php if(empty($dataToView["data"])): ?>
    <div class="text-center py-5">
        <i class="bi bi-person-x" style="font-size: 5rem; color: #cbd5e1;"></i>
        <h3 class="mt-3 text-muted">No hay clientes registrados</h3>
        <p class="text-muted">Comienza agregando tu primer cliente</p>
        <a href="?controller=cliente&action=create" class="btn btn-primary mt-3">
            <i class="bi bi-person-plus"></i> Agregar Primer Cliente
        </a>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Ciudad</th>
                            <th>Fecha Registro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dataToView["data"] as $cliente): ?>
                        <tr>
                            <td><strong>#<?php echo $cliente["id"]; ?></strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                         style="width: 40px; height: 40px; font-weight: bold;">
                                        <?php echo strtoupper(substr($cliente["nombre"], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <strong><?php echo htmlspecialchars($cliente["nombre"] . ' ' . $cliente["apellido"]); ?></strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="bi bi-envelope"></i>
                                <?php echo htmlspecialchars($cliente["email"]); ?>
                            </td>
                            <td>
                                <i class="bi bi-telephone"></i>
                                <?php echo htmlspecialchars($cliente["telefono"]); ?>
                            </td>
                            <td>
                                <i class="bi bi-geo-alt"></i>
                                <?php echo htmlspecialchars($cliente["ciudad"]); ?>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y', strtotime($cliente["fecha_registro"])); ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="?controller=cliente&action=edit&id=<?php echo $cliente["id"]; ?>" 
                                       class="btn btn-sm btn-warning"
                                       title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="?controller=cliente&action=confirmDelete&id=<?php echo $cliente["id"]; ?>" 
                                       class="btn btn-sm btn-danger"
                                       title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>