"use strict"
import {Vista} from './vista.js'
/**
 * Clase VistaPreguntas que muestra el listado de preguntas y respuestas
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaPreguntas extends Vista {

	/**
     * Contructor de la clase VistaPreguntas
     * @param {HTMLDivElement} div Div de la vista
     * @param {Object} controlador Controlador de la vista
     */
	constructor(div, controlador) {
		super(div)
          this.controlador = controlador
	}
}