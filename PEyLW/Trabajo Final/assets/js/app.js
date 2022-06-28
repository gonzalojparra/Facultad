// Variables
const btnSwitch = document.querySelector('#switch');

const carrito = document.querySelector('#carrito');
const contenedorCarrito = document.querySelector('#lista-carrito');
const vaciarCarritoBtn = document.querySelector('#vaciar-carrito');
const listaTracks1 = document.querySelector('#tracks1');
const listaTracks2 = document.querySelector('#tracks2');
let   articulosCarrito = [];

cargarEventListeners();
function cargarEventListeners() {
    // Arrow function para Dark Mode
    btnSwitch.addEventListener('click', () => {
        document.body.classList.toggle('dark');
        btnSwitch.classList.toggle('active');
    });

    // Cuando agregas un track dando click en "Añadir al carrito"
    listaTracks1.addEventListener('click', agregarTrack);
    listaTracks2.addEventListener('click', agregarTrack);

    // Vaciar carrito
    vaciarCarritoBtn.addEventListener('click', () => {
        articulosCarrito = []; // Reseseat el array
        limpiarHTML(); // Eliminamos todo el contenido del HTML
    })
}

// Funciones
function agregarTrack(e) {
    e.preventDefault();
    if( e.target.classList.contains('tracks__button')) {
        const trackSeleccionado = e.target.parentElement
        leerDatosTrack( trackSeleccionado );
    }
}

/**
 * Método que lee el contenido del HTML al que le dimos click
 * Extrae info del track seleccionado
*/
function leerDatosTrack( track ) {
    // Crear un objeto con el content del track
    const infoTrack = {
        imagen: track.querySelector('img').src,
        titulo: track.querySelector('h3').textContent,
        precio: track.querySelector('.tracks__price').textContent,
        id:     track.querySelector('button').getAttribute('data-id'),
    }

    // Verifica si un elemento ya existe en el carrito
    const existe = articulosCarrito.some( track => track.id === infoTrack.id );
    if( existe ) {
        // Actualizamos la cantidad
        const tracks = articulosCarrito.map( track => {
            if(track.id === infoTrack.id) {
                track.cantidad++;
                return track;
            } else {
                return track;
            }
        });
        articulosCarrito = [...tracks];
    } else {
        // Agrega elementos al array de carrito
        articulosCarrito = [...articulosCarrito, infoTrack];
    }

    carritoHTML();
}

// Muestra el carrito en el HTML
function carritoHTML() {

    // Limpiar el HTML
    limpiarHTML();

    // Recorre el carrito y genera el HTML
    articulosCarrito.forEach( track => {
        const { imagen, titulo, precio } = track; // Destructuring
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><img src="${imagen}" width="300"></td>
            <td>${titulo}</td>
            <td>${precio}</td>
        `;

        // Agrega el HTML del carrito en el tbody
        contenedorCarrito.appendChild( row );
    })
}

// Elimina los tracks del tbody
function limpiarHTML() {
    // Forma lenta
    /* contenedorCarrito.innerHTML = ''; */

    // Forma mas cheta
    while( contenedorCarrito.firstChild ) {
        contenedorCarrito.removeChild( contenedorCarrito.firstChild );
    }
}