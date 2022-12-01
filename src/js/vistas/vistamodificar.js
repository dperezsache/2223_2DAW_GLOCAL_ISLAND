"use strict"
import {Vista} from './vista.js'
/**
 * Clase VistaModificar que muestra la pantalla de modificación de subcategorías
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaModificar extends Vista {

	/**
     * Contructor de la clase VistaModificar
     * @param {HTMLDivElement} div Div de la vista
     * @param {Object} controlador Controlador de la vista
     */
	constructor(div, controlador) {
		super(div)
        this.controlador = controlador

        this.botonCancelar = this.div.getElementsByTagName('button')[0]
        this.formulario = this.div.getElementsByTagName('form')[0]
        this.campoTexto = this.div.getElementsByTagName('input')[0]

        this.botonCancelar.addEventListener('click', this.cancelar.bind(this))
        this.formulario.addEventListener('submit', this.comprobarModificacion.bind(this))
	}

    /**
     * Limpiar los campos del formulario.
     */
    cancelar() {
        this.campoTexto.value = ''
    }

    /**
     * Comprobar que la modificación sea válida.
     * @param {Event} e Evento del formulario.
     */
    comprobarModificacion(e) {
        let correcto = true
        e.preventDefault()  // Detener el submit

        // Comprobaciones
        if (this.campoTexto.value == '' || this.campoTexto.value.length > 50) {
            correcto = false
        }

        if (!correcto) {
            alert('Los datos introducidos en el formulario no son válidos.')
            this.cancelar()
        }
        else {
            e.currentTarget.submit()            // Continuar con el submit
            window.location.href = 'index.php'  // Volver a la página principal
        }
    }
}