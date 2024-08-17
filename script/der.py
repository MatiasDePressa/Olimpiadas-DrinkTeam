import matplotlib.pyplot as plt

# Crear figura y axes
fig, ax = plt.subplots(figsize=(12, 8))

# Tabla Usuarios
ax.plot([1, 2], [1, 1], 'bo-', label='Usuarios')
ax.text(1.5, 1.2, 'id_usuario', ha='center')
ax.text(1.5, 1.0, 'nombre', ha='center')
ax.text(1.5, 0.8, 'apellido', ha='center')
ax.text(1.5, 0.6, 'email', ha='center')
ax.text(1.5, 0.4, 'contraseña', ha='center')
ax.text(1.5, 0.2, 'rol', ha='center')

# Tabla Productos
ax.plot([3, 4], [2, 2], 'ro-', label='Productos')
ax.text(3.5, 2.2, 'id_producto', ha='center')
ax.text(3.5, 2.0, 'nombre', ha='center')
ax.text(3.5, 1.8, 'descripcion', ha='center')
ax.text(3.5, 1.6, 'precio', ha='center')
ax.text(3.5, 1.4, 'imagen', ha='center')

# Tabla Pedidos
ax.plot([5, 6], [3, 3], 'go-', label='Pedidos')
ax.text(5.5, 3.2, 'id_pedido', ha='center')
ax.text(5.5, 3.0, 'id_usuario', ha='center')
ax.text(5.5, 2.8, 'fecha_pedido', ha='center')
ax.text(5.5, 2.6, 'estado_pedido', ha='center')

# Tabla Detalles de pedidos
ax.plot([7, 8], [4, 4], 'co-', label='Detalles de pedidos')
ax.text(7.5, 4.2, 'id_detalle_pedido', ha='center')
ax.text(7.5, 4.0, 'id_pedido', ha='center')
ax.text(7.5, 3.8, 'id_producto', ha='center')
ax.text(7.5, 3.6, 'cantidad', ha='center')
ax.text(7.5, 3.4, 'precio_unitario', ha='center')

# Tabla Pagos
ax.plot([9, 10], [5, 5], 'mo-', label='Pagos')
ax.text(9.5, 5.2, 'id_pago', ha='center')
ax.text(9.5, 5.0, 'id_pedido', ha='center')
ax.text(9.5, 4.8, 'fecha_pago', ha='center')
ax.text(9.5, 4.6, 'monto_pago', ha='center')

# Tabla Historial de pedidos
ax.plot([11, 12], [6, 6], 'yo-', label='Historial de pedidos')
ax.text(11.5, 6.2, 'id_historial_pedido', ha='center')
ax.text(11.5, 6.0, 'id_usuario', ha='center')
ax.text(11.5, 5.8, 'id_pedido', ha='center')
ax.text(11.5, 5.6, 'fecha_pedido', ha='center')
ax.text(11.5, 5.4, 'estado_pedido', ha='center')

# Tabla Estado de cuenta
ax.plot([13, 14], [7, 7], 'ko-', label='Estado de cuenta')
ax.text(13.5, 7.2, 'id_estado_cuenta', ha='center')
ax.text(13.5, 7.0, 'id_usuario', ha='center')
ax.text(13.5, 6.8, 'fecha_estado_cuenta', ha='center')
ax.text(13.5, 6.6, 'monto_pendiente', ha='center')
ax.text(13.5, 6.4, 'monto_pagado', ha='center')

# Relaciones entre tablas
ax.plot([2, 5], [1, 3], 'k-')  # Usuarios -> Pedidos
ax.plot([4, 7], [2, 4], 'k-')  # Productos -> Detalles de pedidos
ax.plot([6, 9], [3, 5], 'k-')  # Pedidos -> Pagos
ax.plot([7, 11], [4, 6], 'k-')  # Detalles de pedidos -> Historial de pedidos
ax.plot([9, 13], [5, 7], 'k-')  # Pagos -> Estado de cuenta
ax.plot([11, 13], [6, 7], 'k-')  # Historial de pedidos -> Estado de cuenta

# Mostrar leyenda
ax.legend(loc='upper right')

# Mostrar gráfica
plt.show()