<?php
include 'db_connection.php';
include 'functions.php';

// Obtener el ID del producto de la URL y validarlo
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
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

    // Redirigir al carrito
    header("Location: carrito.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['nombre']); ?></title>
    <link rel="stylesheet" href="Carrito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Barra de Navegación -->
    <?php include 'navbar.php'; ?>

    <!-- Contenido del producto -->
    <div class="container mt-4">
        <form action="" method="post">
            <h1><?php echo htmlspecialchars($product['nombre']); ?></h1>
            <img src="<?php echo htmlspecialchars($product['imagen']); ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>" class="img-fluid">
            <p><?php echo htmlspecialchars($product['descripcion']); ?></p>
            <p>Precio: $<?php echo number_format($product['precio'], 2); ?></p>
            <p>Stock disponible: <?php echo htmlspecialchars($product['stock']); ?></p>
            <div class="input-group mb-3">
                <button class="btn btn-danger btn-sm" type="button" id="menos">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                    </svg>
                </button>
                <input type="number" name="quantity" class="form-control text-center" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>" value="1" style="width: 100px;">
                <button class="btn btn-success btn-sm" type="button" id="mas">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                    </svg>
                </button>
            </div>
            <button type="submit" class="btn btn-primary">Agregar al carrito</button>
        </form>
    </div>
</body>
</html>
