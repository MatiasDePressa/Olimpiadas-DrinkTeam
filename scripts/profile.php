<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta nombre="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <!-- Enlace al archivo CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Estilos/perfil.css">
</head>
<body>

<!-- Barra de Navegación -->
<?php include 'navbar.php' ?>

<!-- Cuerpo de la Página -->
<div class="container my-5">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title text-center mb-4">Mi perfil</h1>
            <div class="row">
                <center>
                <!-- Información del Usuario -->
                <div class="col-md-8">
                    <div class="card mb-3" style="border: solid, 0px;">
                        <div class="card-body" >
                            <label for="usuario" class="form-label">Usuario </label>
                            <div class="d-flex align-items-center">
                                <p class="small mb-0 me-3" id="usuario">Juankt</p>
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3" style="border: solid, 0px;">
                        <div class="card-body">
                            <label for="nombre" class="form-label">Nombre y apellido</label>
                            <div class="d-flex align-items-center">
                                <p class="small mb-0 me-3" id="nombre">Juan Pérez</p>
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3" style="border: solid, 0px;">
                        <div class="card-body">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <div class="d-flex align-items-center">
                                <p class="small mb-0 me-3" id="email">juan.perez@example.com</p>
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                </center>
            </div>
            <!-- Botones debajo del perfil -->
            <div class="d-flex justify-content-around mt-4">
                <a href="historial_pedidos.html" class="btn btn-primary">Historial de pedidos</a>
                <a href="cambiarContra.html" class="btn btn-secondary">Cambiar Contraseña</a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cerrar_sesion">Cerrar sesión</button>
                <a href="bajaUsuarios.html" class="btn btn-outline-danger">Eliminar cuenta</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmar Cierre de Sesión -->
<div class="modal fade" id="cerrar_sesion" tabindex="-1" aria-labelledby="cerrar_sesionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cerrar_sesionLabel">¿Estás seguro que quieres cerrar sesión?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger">Cerrar sesión</button>
            </div>
        </div>
    </div>
</div>

<!--Modal para editar la foto-->
<div class="modal fade" id="foto_edit" tabindex="-1" aria-labelledby="foto_editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="foto_editLabel">Quieres cambiar la foto?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger">Elegir archivos</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    