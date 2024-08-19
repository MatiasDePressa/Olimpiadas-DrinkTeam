<?php
//function.php
error_reporting(E_ALL & ~E_WARNING);
require_once 'db_connection.php'; // Incluir el archivo de conexión

function getProductDetails($id) {
    global $conn; // Declarar la variable $conn como global
    $query = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    return $product;
}


function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Función para obtener la lista de productos
function getProducts() {
    global $conn; // Declarar la variable $conn como global
    $query = "SELECT * FROM productos";
    $result = $conn->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $result->free();
    return $products;
}

// Función para obtener la información de un producto por ID
function getProductById($id) {
    global $conn; // Declarar la variable $conn como global
    $query = "SELECT * FROM productos WHERE id_producto = '$id'";
    $result = $conn->query($query);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $product = $result->fetch_assoc();
    $result->free();
    return $product;
}

// Función para agregar un nuevo producto
function addProduct($nombre, $descripcion, $precio) {
    global $conn; // Declarar la variable $conn como global
    $query = "INSERT INTO productos (nombre_producto, descripcion, precio) VALUES ('$nombre', '$descripcion', '$precio')";
    $result = $conn->query($query);

    if (!$result) {
        die("Error al agregar producto: " . $conn->error);
    }

    return $conn->insert_id;
}



// Función para actualizar un producto
function updateProduct($id, $nombre, $descripcion, $precio) {
    global $conn; // Declarar la variable $conn como global
    $query = "UPDATE productos SET nombre_producto = '$nombre', descripcion = '$descripcion', precio = '$precio' WHERE id_producto = '$id'";
    $result = $conn->query($query);

    if (!$result) {
        die("Error al actualizar producto: " . $conn->error);
    }

    return true;
}

// Función para eliminar un producto
function deleteProduct($id) {
    global $conn; // Declarar la variable $conn como global
    $query = "DELETE FROM productos WHERE id_producto = '$id'";
    $result = $conn->query($query);

    if (!$result) {
        die("Error al eliminar producto: " . $conn->error);
    }

    return true;
}

// Función para actualizar la cantidad de un producto en el carrito
function updateCart($product_id, $quantity) {
    if (!isset($_SESSION['carrito'][$product_id])) {
        $_SESSION['carrito'][$product_id] = 0;
    }

    $_SESSION['carrito'][$product_id] += $quantity;

    // Verificar el stock del producto y actualizarlo en la base de datos
    $product = getProductById($product_id);
    if ($product && $product['stock'] < $_SESSION['carrito'][$product_id]) {
        $_SESSION['carrito'][$product_id] = $product['stock'];
    }
}

function addToCart($product_id, $quantity) {
    // Iniciar la sesión si no está ya iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Verificar si el carrito ya existe en la sesión
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Si el producto ya está en el carrito, incrementar la cantidad
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        // Si no, agregar el producto con la cantidad seleccionada
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

function updateProductStock($conn, $product_id, $new_stock) {
    $stmt = $conn->prepare("UPDATE productos SET stock = ? WHERE id_producto = ?");
    $stmt->bind_param("ii", $new_stock, $product_id);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


function getUserCartId($conn, $user_id) {
    $stmt = $conn->prepare("SELECT id_carrito FROM carritos WHERE id_usuario = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($cart_id);
    $stmt->fetch();
    $stmt->close();
    return $cart_id;
}

function createCart($conn, $user_id) {
    $stmt = $conn->prepare("INSERT INTO carritos (id_usuario, fecha) VALUES (?, NOW())");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->insert_id;
    $stmt->close();
    return $cart_id;
}

function addProductToCart($conn, $cart_id, $product_id, $quantity) {
    // Verificar si el producto ya está en el carrito
    $stmt = $conn->prepare("SELECT cantidad FROM detalle_carrito WHERE id_carrito = ? AND id_producto = ?");
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
    $stmt->bind_result($existing_quantity);
    $stmt->fetch();
    $stmt->close();

    if ($existing_quantity !== null) {
        // Si ya existe, actualizar la cantidad
        $new_quantity = $existing_quantity + $quantity;
        $stmt = $conn->prepare("UPDATE detalle_carrito SET cantidad = ? WHERE id_carrito = ? AND id_producto = ?");
        $stmt->bind_param("iii", $new_quantity, $cart_id, $product_id);
    } else {
        // Si no existe, agregar una nueva fila
        $stmt = $conn->prepare("INSERT INTO detalle_carrito (id_carrito, id_producto, cantidad) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
    }
    
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
?>

