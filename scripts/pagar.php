<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Estilos/login.css">
  </head>
<body>
<!-- Barra de Navegación -->
<?php include 'navbar.php'; ?>

    <div class="card" style="margin-top: 2%; margin-left: 35%;margin-right: 35%; padding: 1%;">
        <h1 class="mb-3">Pago</h1>
        <form action="/procesar_pago" method="post">

            <div class="pago"> 
                <p><em> El pago NO se realizara a traves de la pagina, el vendedor tendra que comunicarse con usted para que el pago sea de manera particular. </em> </p>
            </div>

            <div>
                <br>
                <h3> Información de facturación </h3>
                <div class="input-group">
                    <div class="mt-3"style="margin-right: 10%;">
                      <label for="nombre" class="form-label">Nombre</label>
                      <input type="text" class="form-control" placeholder="Nombre completo del titular" id="nombre" required>
                    </div>
                    <div class="mt-3">
                      <label for="apellido" class="form-label">Apellido</label>
                      <input type="text" class="form-control" placeholder="Apellido completo del titular" id="apellido" required>
                    </div>
                  </div>

                <br>
                <label for="monto" class="form-label">País</label>
                <select id="pais" class="form-select">
                    <option value="argentina">Argentina</option>
                    <option value="brasil">Brasil</option>
                    <option value="chile">Chile</option>
                    <option value="colombia">Colombia</option>
                    <option value="peru">Perú</option>
                </select>

                <div class="input-group">
                    <div class="mt-3"style="margin-right: 10%;">
                      <label for="direccion" class="form-label">Dirección</label>
                      <input type="text" class="form-control" placeholder="Dirección" id="direccion" required>
                    </div>
                    <div class="mt-3">
                      <label for="codigo_postal" class="form-label">Codigo postal</label>
                      <input type="text" class="form-control" placeholder="Codigo postal" id="codigo_postal" required>
                    </div>
                </div>

                <br>
                <label for="monto" class="form-label">Monto a pagar:</label>
                <br>

            </div>
            <div class="text-end">
                <a class="btn btn-success" href="index.php">
                    Pagar
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4" viewBox="0 1 16 16">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                    </svg>
                </a>
            </div>
    </form>
    </div>
</body>
</html>

