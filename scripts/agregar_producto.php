<?php
//agregar_producto.php
include 'db_connection.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $id_categoria = $_POST['id_categoria'];

    // Insertar datos en la base de datos
    $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, id_categoria) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdii', $nombre, $descripcion, $precio, $stock, $id_categoria);

    if ($stmt->execute()) {
        $message = "Producto agregado correctamente.";
    } else {
        $message = "Error al agregar el producto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<!-- Barra de Navegación -->
<?php include 'navbar.php'; ?>

<!-- Contenido Principal -->
<div class="container mt-5">
    <h2>Agregar Producto</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
        </div>
        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría</label>
            <select id="id_categoria" name="id_categoria" class="form-select" required>
                <?php
                // Consultar categorías
                $sql = "SELECT id_categoria, nombre_categoria FROM categorias";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id_categoria'] . '">' . htmlspecialchars($row['nombre_categoria']) . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </form>
</div>
</body>
</html>
