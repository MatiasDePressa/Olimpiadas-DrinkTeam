<?php
//get_product_details.php
include 'db_connection.php';

// Obtener el ID del producto de la URL y validarlo
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    die("ID de producto inválido.");
}

// Consultar la base de datos para obtener los detalles del producto
$sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.imagen, p.stock, c.nombre_categoria
        FROM productos p
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
        WHERE p.id_producto = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el producto
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Producto no encontrado.");
}

$stmt->close();
$conn->close();
?>
