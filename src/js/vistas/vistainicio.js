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
        this.btnInstrucciones=document.getElementsByTagName('button')[0]
        this.btncomenzar=document.getElementsByTagName('button')[1]
        this.btnranking=document.getElementsByTagName('button')[2]
        
        // Creación del div de instrucciones
        this.body=document.getElementsByTagName('body')[0]
        this.divinicio=document.getElementById('divInicio')
        let divInstrucciones = document.createElement('div')
        this.body.appendChild(divInstrucciones)
        
        //Aplicación de estilos al div de las instrucciones
        divInstrucciones.id="divInstrucciones"
        divInstrucciones.style.display = 'none'
        divInstrucciones.style.position = 'absolute'
        divInstrucciones.style.width = '30%'
        divInstrucciones.style.height = '65%'
        divInstrucciones.style.zIndex = '1'
        divInstrucciones.style.textAlign = 'center'
        divInstrucciones.style.padding = '70px'
        divInstrucciones.style.top = '15%'
        divInstrucciones.style.left = '30%'
        divInstrucciones.style.backgroundImage = 'url(../../img/cartaBambu.png)'
        divInstrucciones.style.backgroundSize = 'cover'
        divInstrucciones.style.backgroundRepeat = 'no-repeat'
        this.divinicio.style.zIndex = '0'

        //Creación del título de las instrucciones
        let tituloInstrucciones = document.createElement('h1')
        divInstrucciones.appendChild(tituloInstrucciones)
        tituloInstrucciones.appendChild(document.createTextNode('INSTRUCCIONES'))
        tituloInstrucciones.style.fontFamily = 'Mabook'

        //creación del texto de las instrucciones
        let textoInstrucciones = document.createElement('p')
        divInstrucciones.appendChild(textoInstrucciones)
        textoInstrucciones.appendChild(document.createTextNode('En este juego se contestarán preguntas sobre el cuidado del medio ambiente arrastrando la tarjeta de la pregunta a la tarjeta de la respuesta que quiera, la puntuación dependerá de la racha de aciertos y del tiempo que tarde en contestar,después podrá registrarse en un ranking para guardar su puntuación'))
        textoInstrucciones.style.fontSize = '29px'
        textoInstrucciones.style.marginTop = '15%'


        this.btnInstrucciones.onmouseover=this.instrucciones.bind(this)
        this.btnInstrucciones.onmouseout=this.quitarInstrucciones.bind(this)
        this.btncomenzar.onclick=this.pulsarComenzar.bind(this)
	}

    /**
     * Método pulsarComenzar que se ejecuta al dar click al logo y llama al método del controlador
     */
    pulsarComenzar(){
        this.controlador.pulsarComenzarInicio()
    }

    /**
     * Método para ver las instrucciones mediante un mouseover
     */
    instrucciones(){
        let divInstrucciones = document.getElementById('divInstrucciones')
        this.divinicio.style.filter = 'blur(8px)'
        divInstrucciones.style.display = 'block'
    }

    /**
     * Método para ocultar las instrucciones mediante un mouseout
     */
    quitarInstrucciones(){
        let divInstrucciones = document.getElementById('divInstrucciones')
        this.divinicio.style.filter = 'blur(0px)'
        divInstrucciones.style.display = 'none'
    }
}