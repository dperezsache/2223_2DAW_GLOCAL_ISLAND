

export class ModeloAdmin{
    constructor(controlador,callback){
        this.controlador=controlador;
        this.callback=callback
        this.callbacks=[]
		
		this.mostrarCatOSub()
        callback()
		
		
    }
    /**
	* Método registrar que registra un objeto para informarle de los cambios en el Modelo
	* @param {Function} Función de callback que será llamada cuando cambien los datos
	**/
	registrar(callback){
        this.callbacks.push(callback)
	}

	/**
	* Método avisar que ejecuta todos los callback registrados.
	**/
	avisar(){
	     for(let callback of this.callbacks){
			console.log(callback)
			callback()
		 }
	        
	}
	/**
	 * Método para la comprobación de que vista mostrar en vista categorias
	 */
	mostrarCatOSub(){
		console.log("CRUDCATEGORIA O CRUDSUBCATEGORIA");
		fetch('../../../php/cruds_categorias/alta_categorias/ajax.php') //Hacemos la petición
			.then(respuesta => respuesta.json())  //Recibimos un objeto de tipo Response. respuesta.text devuelve una Promise
			.then(datos =>this.controlador.mostrarCatOsub(datos.valor))
	}
}