"use strict"
/**
 * Clase Modelo para el administrador de la aplicación
 */ 
export class ModeloAdmin {
	/**
	 * Constructor de la clase
	 * @param {Object} controlador para que el modelo mire al controlador
	 * @param {Function} callback método inicar del controlador
	 */
	constructor(controlador, callback) {
		this.controlador = controlador
		this.callback = callback
		this.callbacks = []	// Array de callbacks para implementar el observador
		this.mostrarCatSubcat()
		callback()
	}
	
	/**
	* Método registrar que registra un objeto para informarle de los cambios en el Modelo
	* @param {Function} Función de callback que será llamada cuando cambien los datos
	*/
	registrar(callback) {
        this.callbacks.push(callback)
	}

	/**
	* Método avisar que ejecuta todos los callback registrados.
	*/
	avisar() {
	    for(let callback of this.callbacks) {
			callback()
		}
	}

	/**
	 * Método para la comprobación de que mostrar en vista categorías.
	 * @return {Boolean} true para mostrar sólo subcategorías, false para mostrar sólo las categorías.
	 */
	mostrarCatSubcat() {
		fetch('../../php/cruds_categorias/ajax.php')
			.then(respuesta => respuesta.json())
			.then(datos => this.controlador.mostrarCatSubcat(datos.valor))
	}
}