<?php
// add_to_cart.php

include 'db_connection.php';
include 'functions.php';

// Verificar si se recibieron los datos necesarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Verificar si el producto existe y si hay suficiente stock
    $product = getProductDetails($conn, $product_id);

    if ($product && $quantity > 0 && $quantity <= $product['stock']) {
        // Obtener el ID del usuario (aquí puedes utilizar la sesión o un ID fijo para la prueba)
        session_start();
        $user_id = $_SESSION['id_usuario']; // Asegúrate de que el usuario esté autenticado

        // Verificar si el usuario ya tiene un carrito creado
        $cart_id = getUserCartId($conn, $user_id);

        if (!$cart_id) {
            // Crear un nuevo carrito si no existe
            $cart_id = createCart($conn, $user_id);
        }

        // Agregar el producto al carrito o actualizar la cantidad si ya existe
        if (addProductToCart($conn, $cart_id, $product_id, $quantity)) {
            // Actualizar el stock del producto
            updateProductStock($conn, $product_id, $product['stock'] - $quantity);
            
            // Enviar una respuesta JSON de éxito
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo agregar el producto al carrito.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Stock insuficiente o producto no encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
}

$conn->close();
?>
