"use strict"
import {Vista} from './vista.js'
/**
 * Clase VistaListado que muestra el listado de categorías
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaListado extends Vista {

	/**
     * Contructor de la clase VistaListado
     * @param {HTMLDivElement} div Div de la vista
     * @param {Object} controlador Controlador de la vista
     */
	constructor(div, controlador) {
		super(div)
          this.controlador = controlador
	}
}