from django.urls import path
from . import views

urlpatterns = [
    # Ruta para ver el detalle de un producto específico
    path('producto/<int:producto_id>/', views.detalle_producto, name='detalle_producto'),
]
