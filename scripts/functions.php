<?php
session_start();

// Conectar a la base de datos
include 'db_connection.php';

function getProductDetails($conn, $product_id) {
    $sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.imagen, p.stock, c.nombre_categoria
            FROM productos p
            LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
            WHERE p.id_producto = ? AND p.stock > 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function addToCart($product_id, $quantity) {
    global $conn;
    
    // Obtener detalles del producto
    $product = getProductDetails($conn, $product_id);
    
    if ($product && $quantity > 0) {
        $product_id = $product['id_producto'];
        $product_name = $product['nombre'];
        $product_price = $product['precio'];
        
        // Inicializar el carrito si no existe
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Agregar o actualizar el producto en el carrito
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = array(
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $quantity,
                'image' => $product['imagen'],
                'stock' => $product['stock']
            );
        }

        // Actualizar el stock del producto en el carrito
        if ($_SESSION['cart'][$product_id]['quantity'] > $product['stock']) {
            $_SESSION['cart'][$product_id]['quantity'] = $product['stock'];
        }
    }
}

function updateCart($product_id, $quantity) {
    global $conn;
    
    if (isset($_SESSION['cart'][$product_id])) {
        $product = getProductDetails($conn, $product_id);
        
        if ($product) {
            $stock = $product['stock'];
            if ($quantity > $stock) {
                $quantity = $stock;
            }
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        }
    }
}

function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

function clearCart() {
    unset($_SESSION['cart']);
}

function getCartTotal() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

function sortCart($sortBy, $order = 'asc') {
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    usort($cart, function($a, $b) use ($sortBy, $order) {
        if ($order == 'asc') {
            return $a[$sortBy] <=> $b[$sortBy];
        } else {
            return $b[$sortBy] <=> $a[$sortBy];
        }
    });
    $_SESSION['cart'] = $cart;
}
?>
