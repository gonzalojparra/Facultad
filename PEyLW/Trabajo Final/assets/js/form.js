// Variables
const btnEnviar = document.querySelector('#enviar');
const formulario = document.querySelector('#enviar-mail');

// Variables para campos
const nombre = document.querySelector('#nombre');
const email = document.querySelector('#email');
const asunto = document.querySelector('#asunto');
const mensaje = document.querySelector('#mensaje');
const expresionR = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

eventListeners();
function eventListeners() {
    // Cuando la app inicia
    document.addEventListener('DOMContentLoaded', iniciarApp);

    // Campos del formulario
    nombre.addEventListener('blur', validarFormulario);
    email.addEventListener('blur', validarFormulario);
    asunto.addEventListener('blur', validarFormulario);
    mensaje.addEventListener('blur', validarFormulario);

    // Enviar email
    formulario.addEventListener('submit', enviarEmail);
}

// Funciones
function iniciarApp() {
    btnEnviar.disabled = true;
}

// Valida el formulario
function validarFormulario(e) {

    if(e.target.value.length > 0) {
        // Elimina los errores
        const error = document.querySelector('p.error');
        if( error ) {
            error.remove();
        } 
        e.target.style.borderColor = 'green';
        
    } else {
        e.target.style.borderColor = 'red';
        mostrarError('Todos los campos son obligatorios');
    }
    
    if( e.target.type === 'email' ) {
        if( expresionR.test(e.target.value) ) {
            // Elimina los errores
            const error = document.querySelector('p.error');
            if( error ) {
            error.remove();
            } 
            e.target.style.borderColor = 'green';
        } else {
            e.target.style.borderColor = 'red';
            mostrarError('Email no válido');
        }
    }

    if( nombre.value !== '' && expresionR.test(email.value) && asunto.value !== '' && mensaje.value !== '' ) {
        btnEnviar.disabled = false;
    }
}

function mostrarError( mensaje ) {

    const mensajeError = document.createElement('p');
    mensajeError.textContent = mensaje;
    mensajeError.classList.add('error');
    mensajeError.style.color = 'white';
    mensajeError.style.marginTop = '20px';

    const errores = document.querySelectorAll('.error');
    if( errores.length === 0 ) {
        formulario.appendChild(mensajeError);
    }

}

// Envia el email
function enviarEmail( e ) {
    e.preventDefault();
    // Mostrar el spinner
    const spinner = document.querySelector('#spinner');
    spinner.style.display = 'flex';

    /// Después de 3 seg ocultar el spinner y mostrar mensaje
    setTimeout( () => {
       spinner.style.display = 'none';
       // Mensaje de envio
       const parrafo = document.createElement('p');
       parrafo.textContent = 'El mensaje se envió correctamente.';
       parrafo.style.textAlign = 'center';
       parrafo.style.padding = '2px';
       parrafo.style.backgroundColor = 'green';
       parrafo.style.color = 'white';
       parrafo.style.fontStyle = 'bold';
       parrafo.style.marginBottom = '25px';
       // Inserta el parrafo antes del spinner
       formulario.insertBefore(parrafo, spinner); 

       // Eliminar el mensaje de éxito
       setTimeout( () => {
        parrafo.remove();
       }, 5000);
    }, 3000);
}