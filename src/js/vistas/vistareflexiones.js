
"use strict"
import {Vista} from './vista.js'
/**
 * Clase VistaReflexiones que muestra el CRUD
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaReflexiones extends Vista {

	/**
     * Contructor de la clase VistaReflexiones
     * @param {HTMLDivElement} div Div de la vista
     * @param {Object} controlador Controlador de la vista
     */
	constructor(div, controlador) {
		super(div)
          this.controlador = controlador
          this.btnEliminarReflexion=document.getElementById("eliminarReflexion");
          this.btnEliminarReflexion.addEventListener("onclick",this.confirmarEliminacion.bind(this))
	}
     confirmarEliminacion(){
          //event.preventDefault();
          console.log("HOLAAAAA MIARMAAAA");
     }
}