"use strict" //activo modo estricto
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
	constructor(divinicio, controlador){
		super(divinicio)
        this.controlador=controlador
        this.btncomenzar=document.getElementsByTagName('button')[0]
        this.btnranking=document.getElementsByTagName('button')[1]

        this.btncomenzar.onclick=this.pulsarComenzar.bind(this)
	}

    /**
     * Método pulsarComenzar que se ejecuta al dar clicl al logo y llama al método del controlador
     */
    pulsarComenzar(){
        this.controlador.pulsarComenzarInicio()
     }
}