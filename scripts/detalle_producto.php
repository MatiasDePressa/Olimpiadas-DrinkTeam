<?php
//detalle_producto.php
include 'db_connection.php';
include 'functions.php';

// Obtener el ID del producto de la URL y validarlo
$product_id = $_GET['id']; // o cualquier otro método para obtener el ID del producto

$product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$product_id) {
    die("ID de producto inválido.");
}


// Consultar la base de datos para obtener los detalles del producto
$product = getProductDetails($conn, $product_id);

if (!$product) {
    die("Producto no encontrado.");
}

// Manejar la solicitud para agregar al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    // Validar la cantidad contra el stock disponible
    if ($quantity > $product['stock']) {
        $quantity = $product['stock'];
    }

    // Agregar al carrito
    addToCart($product_id, $quantity);

    // Restar la cantidad seleccionada del stock disponible
    $new_stock = $product['stock'] - $quantity;
    updateProductStock($conn, $product_id, $new_stock);

    // Redirigir al carrito
    header("Location: carrito.php?added=true");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
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
        <div class="col-md-6">
            <h1 class="mb-3"><?php echo htmlspecialchars($product['nombre']); ?></h1>
            <p class="mb-2"><?php echo htmlspecialchars($product['descripcion']); ?></p>
            <h4 class="text-primary mb-2">Precio: $<?php echo number_format($product['precio'], 2); ?></h4>
            <p class="text-muted mb-4">Stock disponible: <?php echo htmlspecialchars($product['stock']); ?></p>
            
            <form action="" method="post">
                <div class="input-group mb-3">
                    <button class="btn btn-outline-secondary" type="button" id="menos">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                        </svg>
                    </button>
                    <input type="number" name="quantity" class="form-control text-center" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>" value="1">
                    <button class="btn btn-outline-secondary" type="button" id="mas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg>
                    </button>
                </div>
                <button type="submit" class="btn btn-primary">Agregar al carrito</button>
            </form>
            
            <?php if (isset($_GET['added']) && $_GET['added'] == 'true'): ?>
                <p class="text-success mt-3">Producto agregado al carrito con éxito!</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Add event listeners to the quantity buttons
    document.getElementById('menos').addEventListener('click', function() {
        var quantityInput = document.querySelector('input[name="quantity"]');
        var currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    document.getElementById('mas').addEventListener('click', function() {
        var quantityInput = document.querySelector('input[name="quantity"]');
        var currentValue = parseInt(quantityInput.value);
        if (currentValue < <?php echo htmlspecialchars($product['stock']); ?>) {
            quantityInput.value = currentValue + 1;
        }
    });
</script>
<script>
function addToCart(productId, productName, productPrice, quantity) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_to_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert('Producto agregado al carrito');
            } else {
                alert('Error al agregar el producto al carrito: ' + response.message);
            }
        } else {
            alert('Error en la solicitud: ' + xhr.statusText);
        }
    };
    xhr.onerror = function() {
        alert('Error en la solicitud');
    };
    xhr.send('product_id=' + productId + '&quantity=' + quantity);
}

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();
    var productId = <?php echo htmlspecialchars($product['id_producto']); ?>;
    var productName = '<?php echo htmlspecialchars($product['nombre']); ?>';
    var productPrice = <?php echo htmlspecialchars($product['precio']); ?>;
    var quantity = document.querySelector('input[name="quantity"]').value;
    
    addToCart(productId, productName, productPrice, quantity);
});
</script>

</body>
</html>
