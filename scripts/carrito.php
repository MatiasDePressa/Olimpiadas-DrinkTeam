<?php
//carrito.php
include 'db_connection.php';
include 'functions.php';

// Iniciar sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Manejo de actualizar cantidad
if (isset($_POST['update'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    updateCart($product_id, $quantity);
    header("Location: carrito.php");
    exit();
}

// Función para agregar producto al carrito
function agregarAlCarrito($productoId, $cantidad) {
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }
    if (isset($_SESSION['carrito'][$productoId])) {
        $_SESSION['carrito'][$productoId] += $cantidad;
    } else {
        $_SESSION['carrito'][$productoId] = $cantidad;
    }
}

// Función para eliminar producto del carrito
function eliminarDelCarrito($productoId) {
    if (isset($_SESSION['carrito'][$productoId])) {
        unset($_SESSION['carrito'][$productoId]);
    }
}

// Función para vaciar el carrito
function vaciarCarrito() {
    unset($_SESSION['carrito']);
}

// Manejar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        $productoId = intval($_POST['producto_id']);
        $cantidad = intval($_POST['cantidad']);
        agregarAlCarrito($productoId, $cantidad);
    } elseif (isset($_POST['eliminar'])) {
        $productoId = intval($_POST['producto_id']);
        eliminarDelCarrito($productoId);
    } elseif (isset($_POST['vaciar'])) {
        vaciarCarrito();
    }
}

// Consultar productos en el carrito
$productosCarrito = array();
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $productoId => $cantidad) {
        $sql = "SELECT * FROM productos WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $productoId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $producto = $result->fetch_assoc();
            $producto['cantidad'] = $cantidad;
            $productosCarrito[] = $producto;
        }
    }
}


function validarStockDisponible($product_id, $quantity) {
    $product = getProductById($product_id);
    return $product && $product['stock'] >= $quantity;
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carro de la compra</title>
    <link rel="stylesheet" href="styles/Carrito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<!-- Barra de Navegación -->
<?php include 'navbar.php'; ?>

<form action="carrito.php" method="post" style="padding-left: 20px; padding-right: 20px;">
    <h1 class="text-center">Carro de la compra</h1>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio por unidad</th>
                <th>Total</th>
                <th>Descripción</th>
                <th>Código de producto</th>
                <th>Entrega</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productosCarrito as $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                <td>
                    <div class="input-group mb-3">
                        <button class="btn btn-danger btn-sm" type="button" onclick="actualizarCantidad(<?php echo $producto['id_producto']; ?>, -1)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                            </svg>
                        </button>
                        <input type="number" class="text-center" id="cantidad_<?php echo $producto['id_producto']; ?>" value="<?php echo $producto['cantidad']; ?>" style="width: 50px;" readonly>
                        <button class="btn btn-success btn-sm" type="button" onclick="actualizarCantidad(<?php echo $producto['id_producto']; ?>, 1)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                            </svg>
                        </button>
                    </div>
                </td>
                <td><?php echo number_format($producto['precio'], 2); ?></td>
                <td><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></td>
                <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($producto['codigo']); ?></td>
                <td>Entregado</td>
                <td>
                    <form action="carrito.php" method="post" style="display: inline;">
                        <input type="hidden" name="producto_id" value="<?php echo $producto['id_producto']; ?>">
                        <button class="btn btn-danger" type="submit" name="eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="text-right"><strong>Total</strong></td>
                <td colspan="4" class="text-right"><strong>
                    <?php
                    $total = 0;
                    foreach ($productosCarrito as $producto) {
                        $total += $producto['precio'] * $producto['cantidad'];
                    }
                    echo number_format($total, 2);
                    ?>
                </strong></td>
            </tr>
        </tbody>
    </table>
    <div class="text-right">
        <button class="btn btn-success" style="position: absolute; left: 80%;" onclick="location.href='index.html'">Continuar Comprando</button>
        <button class="btn btn-danger" style="position: absolute; left: 90%;" type="submit" name="vaciar">Vaciar Carrito</button>
    </div>
</form>

<script>
function actualizarCantidad(productId, change) {
    var cantidadInput = document.getElementById('cantidad_' + productId);
    var cantidad = parseInt(cantidadInput.value);
    var nuevaCantidad = cantidad + change;

    if (nuevaCantidad < 1) {
        nuevaCantidad = 1;
    }

    cantidadInput.value = nuevaCantidad;

    // Aquí puedes agregar lógica para actualizar el carrito en el servidor
    var form = document.createElement('form');
    form.method = 'post';
    form.action = 'carrito.php';
    
    var inputProductId = document.createElement('input');
    inputProductId.type = 'hidden';
    inputProductId.name = 'producto_id';
    inputProductId.value = productId;
    form.appendChild(inputProductId);
    
    var inputCantidad = document.createElement('input');
    inputCantidad.type = 'hidden';
    inputCantidad.name = 'cantidad';
    inputCantidad.value = nuevaCantidad;
    form.appendChild(inputCantidad);

    var inputUpdate = document.createElement('input');
    inputUpdate.type = 'hidden';
    inputUpdate.name = 'update';
    form.appendChild(inputUpdate);

    document.body.appendChild(form);
    form.submit();
}
</script>

</body>
</html>
