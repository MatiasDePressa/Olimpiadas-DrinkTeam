-- Creación de la tabla 'usuarios'
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL
);

-- Creación de la tabla 'roles'
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(100) NOT NULL
);

-- Creación de la tabla intermedia 'usuario_roles'
CREATE TABLE usuario_roles (
    id_usuario INT,
    id_rol INT,
    PRIMARY KEY (id_usuario, id_rol),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE CASCADE
);

-- Creación de la tabla 'categorias'
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL
);

-- Creación de la tabla 'productos' con columna 'codigo'
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    imagen VARCHAR(255),
    stock INT NOT NULL,
    id_categoria INT,
    codigo VARCHAR(50) UNIQUE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE SET NULL
);

-- Creación de la tabla 'pagos'
CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    monto DECIMAL(10, 2) NOT NULL,
    fecha DATETIME NOT NULL,
    estado VARCHAR(50) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);

-- Creación de la tabla 'pedidos'
CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    estado_entrega VARCHAR(50) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);

-- Creación de la tabla intermedia 'detalle_pedido'
CREATE TABLE detalle_pedido (
    id_pedido INT,
    id_producto INT,
    cantidad INT NOT NULL,
    PRIMARY KEY (id_pedido, id_producto),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
);

-- Creación de la tabla 'historial_pedidos'
CREATE TABLE historial_pedidos (
    id_historial INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    estado_cancelado BOOLEAN NOT NULL,
    descripcion_cancelacion TEXT,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido) ON DELETE CASCADE
);

-- Creación de la tabla 'carritos' (opcional)
CREATE TABLE carritos (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha DATETIME NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);

-- Creación de la tabla intermedia 'detalle_carrito' (opcional)
CREATE TABLE detalle_carrito (
    id_carrito INT,
    id_producto INT,
    cantidad INT NOT NULL,
    PRIMARY KEY (id_carrito, id_producto),
    FOREIGN KEY (id_carrito) REFERENCES carritos(id_carrito) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE
);

-- Insertar roles
INSERT INTO roles (nombre_rol) VALUES
('cliente'),
('empleado'),
('jefe');

-- Insertar datos de prueba
-- Insertar categorías
INSERT INTO categorias (nombre_categoria) VALUES ('Deportes'), ('Electrónica');

-- Insertar productos
INSERT INTO productos (nombre, descripcion, precio, imagen, stock, id_categoria, codigo) VALUES
('Zapatillas de running', 'Zapatillas para correr en asfalto.', 59.99, 'zapatillas.jpg', 20, 1, 'RUN123'),
('Reloj deportivo', 'Reloj con GPS y monitor de frecuencia cardíaca.', 199.99, 'reloj.jpg', 15, 2, 'WATCH456');

-- Insertar usuarios
INSERT INTO usuarios (nombre, apellido, correo, contraseña) VALUES
('Juan', 'Pérez', 'juan@example.com', 'contraseña123');

-- Asignar roles a usuarios
INSERT INTO usuario_roles (id_usuario, id_rol) VALUES
(1, 1); -- Asignar rol de cliente a Juan Pérez

-- Insertar pedidos y detalles
INSERT INTO pedidos (fecha, estado_entrega, id_usuario) VALUES
(NOW(), 'En preparación', 1);

INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad) VALUES
(1, 1, 2),
(1, 2, 1);
