from django.shortcuts import render, get_object_or_404
from .models import Producto

def producto_detalle(request, producto_id):
    producto = get_object_or_404(Producto, id_producto=producto_id)
    return render(request, 'producto_detalle.html', {'producto': producto})