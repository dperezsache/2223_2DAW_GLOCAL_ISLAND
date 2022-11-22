"use script" //activo modo estricto
import {Vista} from './vista.js'
/**
 * Clase VistaJuego que muestra el juego
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaInicio extends Vista{

	/**
     * Contructor de la clase VistaInicio
     * @param {Objeto} divinicio 
     */
	constructor(divinicio){
		super(divinicio)
        this.btncomenzar=document.getElementsByTagName('button')[0]
        this.btnranking=document.getElementsByTagName('button')[1]

        
	}
}