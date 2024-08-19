<?php
//lista_productos.php
include 'db_connection.php';
include 'functions.php';

// Obtener la opción de ordenamiento y dirección de la URL o usar los valores predeterminados
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'nombre';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Validar las opciones de ordenamiento
$valid_sort_options = ['nombre', 'precio', 'categoria'];
if (!in_array($sort_by, $valid_sort_options)) {
    $sort_by = 'nombre';
}

// Validar la dirección de ordenamiento
$valid_sort_orders = ['asc', 'desc'];
if (!in_array($sort_order, $valid_sort_orders)) {
    $sort_order = 'asc';
}

// Consultar la base de datos para obtener los productos
$sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.imagen, p.stock, c.nombre_categoria
        FROM productos p
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
        WHERE p.stock > 0
        ORDER BY ";

switch ($sort_by) {
    case 'precio':
        $sql .= "p.precio";
        break;
    case 'categoria':
        $sql .= "c.nombre_categoria";
        break;
    default:
        $sql .= "p.nombre";
        break;
}

$sql .= $sort_order === 'asc' ? ' ASC' : ' DESC';

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../Estilos/registro.css">
</head>
<body>
<!-- Barra de Navegación -->
<?php include 'navbar.php'; ?>

<!-- Contenido Principal -->
<div class="container my-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Lista de Productos</h2>
            <form method="GET" class="mb-3">
                <div class="mb-2">
                    <label for="sort" class="form-label">Ordenar por:</label>
                    <select id="sort" name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="nombre" <?= $sort_by === 'nombre' ? 'selected' : '' ?>>Nombre</option>
                        <option value="precio" <?= $sort_by === 'precio' ? 'selected' : '' ?>>Precio</option>
                        <option value="categoria" <?= $sort_by === 'categoria' ? 'selected' : '' ?>>Categoría</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="order" class="form-label">Orden:</label>
                    <select id="order" name="order" class="form-select" onchange="this.form.submit()">
                        <option value="asc" <?= $sort_order === 'asc' ? 'selected' : '' ?>>Ascendente</option>
                        <option value="desc" <?= $sort_order === 'desc' ? 'selected' : '' ?>>Descendente</option>
                    </select>
                </div>
            </form>
            <ul class="list-group">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5><?= htmlspecialchars($product['nombre']) ?></h5>
                                <p>Precio: $<?= number_format($product['precio'], 2) ?></p>
                                <p>Categoria: <?= htmlspecialchars($product['nombre_categoria']) ?></p>
                                <a href="detalle_producto.php?id=<?= $product['id_producto'] ?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregar_carrito" data-producto-id="<?= $product['id_producto'] ?>" data-producto-nombre="<?= htmlspecialchars($product['nombre']) ?>" data-producto-precio="<?= number_format($product['precio'], 2) ?>" onclick="setModalProductData(this)">Agregar al carrito</button>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">No hay productos disponibles.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="agregar_carrito" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">¿Qué quieres hacer?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modal-product-name"></p>
                <p id="modal-product-price"></p>
                <form id="add-to-cart-form" method="post" action="carrito.php">
                    <input type="hidden" name="producto_id" id="modal-product-id">
                    <input type="number" name="cantidad" class="form-control" value="1" min="1" id="modal-product-quantity">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Seguir explorando</button>
                <button type="submit" class="btn btn-success" form="add-to-cart-form">Agregar al carrito</button>
            </div>
        </div>
    </div>
</div>

<script>
function setModalProductData(button) {
    var productId = button.getAttribute('data-producto-id');
    var productName = button.getAttribute('data-producto-nombre');
    var productPrice = button.getAttribute('data-producto-precio');

    document.getElementById('modal-product-id').value = productId;
    document.getElementById('modal-product-name').textContent = 'Nombre: ' + productName;
    document.getElementById('modal-product-price').textContent = 'Precio: $' + productPrice;
}
</script>

</body>
</html>