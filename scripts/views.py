from django.shortcuts import render, get_object_or_404
from .models import Producto  # Asegúrate de que el modelo Producto esté definido en models.py

def detalle_producto(request, producto_id):
    # Obtén el producto específico usando el ID proporcionado en la URL
    producto = get_object_or_404(Producto, pk=producto_id)
    
    # Pasa el producto a la plantilla detalleProducto.html
    return render(request, 'detalleProducto.html', {'producto': producto})
