<h1 class="page-title">
    <i class="bi bi-speedometer2"></i> <?php echo $controller->page_title; ?>
</h1>

<!-- Tarjetas de Estadísticas -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Productos</h6>
                        <h2 class="mb-0 fw-bold"><?php echo $dataToView["data"]["total_productos"]; ?></h2>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Clientes</h6>
                        <h2 class="mb-0 fw-bold"><?php echo $dataToView["data"]["total_clientes"]; ?></h2>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Ventas</h6>
                        <h2 class="mb-0 fw-bold"><?php echo $dataToView["data"]["total_ventas"]; ?></h2>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">
                        <i class="bi bi-cart-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Ingresos</h6>
                        <h2 class="mb-0 fw-bold"><?php echo constant("CURRENCY"); ?><?php echo number_format($dataToView["data"]["total_ingresos"], 2); ?></h2>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Segunda Fila de Estadísticas -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="bi bi-pie-chart-fill text-primary"></i> 
                    Productos por Deporte
                </h5>
                <canvas id="deporteChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="bi bi-cash-coin text-success"></i> 
                    Valor del Inventario: 
                    <span class="text-success"><?php echo constant("CURRENCY"); ?><?php echo number_format($dataToView["data"]["valor_inventario"], 2); ?></span>
                </h5>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Este es el valor total de todos los productos en stock.
                </div>
                <div class="row text-center mt-3">
                    <div class="col">
                        <h4 class="text-primary"><?php echo $dataToView["data"]["total_productos"]; ?></h4>
                        <small class="text-muted">Productos</small>
                    </div>
                    <div class="col">
                        <h4 class="text-warning"><?php echo count($dataToView["data"]["stock_bajo"]); ?></h4>
                        <small class="text-muted">Stock Bajo</small>
                    </div>
                    <div class="col">
                        <h4 class="text-danger"><?php echo count($dataToView["data"]["sin_stock"]); ?></h4>
                        <small class="text-muted">Sin Stock</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alertas y Listas -->
<div class="row g-4 mb-4">
    <!-- Stock Bajo -->
    <?php if(!empty($dataToView["data"]["stock_bajo"])): ?>
    <div class="col-md-6">
        <div class="card border-warning">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle-fill"></i> 
                    Productos con Stock Bajo
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php foreach($dataToView["data"]["stock_bajo"] as $producto): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?php echo htmlspecialchars($producto["nombre"]); ?></strong>
                            <br>
                            <small class="text-muted"><?php echo $producto["marca"]; ?> - <?php echo $producto["deporte"]; ?></small>
                        </div>
                        <span class="badge bg-warning text-dark">
                            Stock: <?php echo $producto["stock"]; ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Sin Stock -->
    <?php if(!empty($dataToView["data"]["sin_stock"])): ?>
    <div class="col-md-6">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="bi bi-x-circle-fill"></i> 
                    Productos Sin Stock
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php foreach($dataToView["data"]["sin_stock"] as $producto): ?>
                    <div class="list-group-item">
                        <strong><?php echo htmlspecialchars($producto["nombre"]); ?></strong>
                        <br>
                        <small class="text-muted"><?php echo $producto["marca"]; ?> - <?php echo $producto["deporte"]; ?></small>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Productos Más Caros y Ventas Recientes -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-star-fill"></i> 
                    Top 5 Productos Más Caros
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php foreach($dataToView["data"]["productos_caros"] as $index => $producto): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-secondary">#<?php echo $index + 1; ?></span>
                            <strong class="ms-2"><?php echo htmlspecialchars($producto["nombre"]); ?></strong>
                            <br>
                            <small class="text-muted ms-4"><?php echo $producto["marca"]; ?></small>
                        </div>
                        <span class="badge bg-success" style="font-size: 1rem;">
                            <?php echo constant("CURRENCY"); ?><?php echo number_format($producto["precio"], 2); ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history"></i> 
                    Ventas Recientes
                </h5>
            </div>
            <div class="card-body">
                <?php if(!empty($dataToView["data"]["ventas_recientes"])): ?>
                <div class="list-group list-group-flush">
                    <?php foreach($dataToView["data"]["ventas_recientes"] as $venta): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?php echo htmlspecialchars($venta["cliente_nombre"]); ?></strong>
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> 
                                <?php echo date('d/m/Y H:i', strtotime($venta["fecha_venta"])); ?>
                            </small>
                        </div>
                        <span class="badge bg-success" style="font-size: 1rem;">
                            <?php echo constant("CURRENCY"); ?><?php echo number_format($venta["total"], 2); ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                    <p class="mt-2">No hay ventas registradas</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Gráfico de productos por deporte
const deporteData = <?php echo json_encode($dataToView["data"]["productos_por_deporte"]); ?>;
const deporteLabels = deporteData.map(item => item.deporte);
const deporteCantidades = deporteData.map(item => item.cantidad);

const ctx = document.getElementById('deporteChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: deporteLabels,
        datasets: [{
            data: deporteCantidades,
            backgroundColor: [
                '#667eea',
                '#f093fb',
                '#4facfe',
                '#43e97b',
                '#fa709a',
                '#feca57'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            },
            title: {
                display: false
            }
        }
    }
});
</script>