const restarBtn = document.getElementById('restar');
const sumarBtn = document.getElementById('sumar');
const contador = document.getElementById('contador');
const precioTotal = document.getElementById('precioTotal');

let cantidad = 1;
const precioPorUnidad = {{ producto.precio }}; // Precio dinámico desde la base de datos

restarBtn.addEventListener('click', () => {
    if (cantidad > 1) {
        cantidad--; // Decrementa la cantidad
        actualizarCantidadYPrecio(); // Actualiza el contador y el precio total
    }
});

sumarBtn.addEventListener('click', () => {
    cantidad++; // Incrementa la cantidad
    actualizarCantidadYPrecio(); // Actualiza el contador y el precio total
});

function actualizarCantidadYPrecio() {
    contador.textContent = cantidad; // Actualiza la cantidad mostrada
    precioTotal.textContent = cantidad * precioPorUnidad; // Calcula y actualiza el precio total
}