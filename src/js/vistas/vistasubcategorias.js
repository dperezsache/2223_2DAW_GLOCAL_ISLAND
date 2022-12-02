"use strict" 
import {Vista} from './vista.js'
/**
 * Clase VistaSubcategorias que muestra el CRUD de subcategorías
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaSubcategorias extends Vista {

	/**
     * Contructor de la clase VistaSubcategorias
     * @param {HTMLDivElement} div Div de la vista
     * @param {Object} controlador Controlador de la vista
     */
	constructor(div, controlador) {
		super(div)
          this.controlador = controlador
	}
}