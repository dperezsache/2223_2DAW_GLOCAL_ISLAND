"use strict"
import {Vista} from './vista.js'
/**
 * Clase VistaModificarSub que muestra la pantalla de modificación de subcategorías
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaModificarSub extends Vista {

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
        let valor = this.campoTexto.value
        let correcto = false
        let errorTexto = ''

        // Comprobaciones
        if (valor == '') errorTexto = 'El campo está vacío.'
        else if (valor.length > 50) errorTexto = 'Superado límite de caracteres permitidos (50).'
        else if (!valor.match(/^[A-Z]+$/i)) errorTexto = 'El formato introducido no es el correcto.'
        else correcto = true

        if (correcto) {
            window.location.href = 'index.php'  // Volver a la página principal
        }
        else {
            alert(errorTexto)
            e.preventDefault()  // Detener el submit
            this.cancelar()
        }
    }
}