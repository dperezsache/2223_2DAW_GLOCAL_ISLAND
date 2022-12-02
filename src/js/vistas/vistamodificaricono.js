"use strict"
import {Vista} from './vista.js'
/**
 * Clase VistaModificarIcono que muestra la pantalla de modificación de iconos
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaModificarIcono extends Vista {

	/**
     * Contructor de la clase VistaModificar
     * @param {HTMLDivElement} div Div de la vista
     * @param {Object} controlador Controlador de la vista
     */
	constructor(div, controlador) {
		super(div)
        this.controlador = controlador

        this.formulario = this.div.getElementsByTagName('form')[0]
        this.campoIcono = this.div.getElementsByTagName('input')[2]

        this.formulario.addEventListener('submit', this.comprobarModificacion.bind(this))
	}

    /**
     * Comprobar que la modificación del icono sea válida.
     * @param {Event} e Evento del formulario.
     */
    comprobarModificacion(e) {
        const archivo = this.campoIcono.files[0]
        const extension = archivo['type']
        const formatos = ['image/gif', 'image/jpeg', 'image/png']
        let correcto = false
        let errorTexto = ''

        if (archivo == null) errorTexto = 'No has seleccionado nada.'
        else if (!formatos.includes(extension)) errorTexto = 'No has seleccionado una imagen, o no tiene un formato válido'
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