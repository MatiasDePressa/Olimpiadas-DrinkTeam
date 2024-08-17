from django.conf import settings
from django.conf.urls.static import static
from django.urls import path
from .views import producto_detalle

urlpatterns = [
    path('producto/<int:producto_id>/', producto_detalle, name='producto_detalle'),
    # Otras URLs
]

if settings.DEBUG:
    urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
