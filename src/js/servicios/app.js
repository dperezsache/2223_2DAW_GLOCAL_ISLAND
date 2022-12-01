"use script" //activo modo estricto
import {Modelo} from '../modelos/modelo.js'
import {VistaJuego} from '../vistas/vistajuego.js'
import {VistaInicio} from '../vistas/vistainicio.js'
/**
 * Clase Controlador que administra las vistas
 */
class Controlador{
	/**
	 * Constructor de la clase Controlador
	 * Cuando carga la web ejecuta el método iniciar
	 */
	constructor(){
		window.onload=this.iniciar.bind(this)
	}

	/**
	 * Método iniciar que es el primero en ejecutarse cuando se carga la pantalla
	 */
	iniciar(){
		console.log('¡Bienvenido a Glocal Island!')
		this.modelo=new Modelo(this, this.iniciarVistas.bind(this))
	}

	/**
	 * Método iniciarVistar que se ejecuta al iniciar el modelo
	 */
	iniciarVistas(){
		this.divjuego=document.getElementById('divCanvas')
		this.vistaJuego=new VistaJuego(this.divjuego, this)
		this.divinicio=document.getElementById('divInicio')
		this.vistaInicio=new VistaInicio(this.divinicio, this)
		
		this.vistaInicio.mostrar(true)
		this.vistaJuego.mostrar(false)
		
	}
	/**
	 * Método para la obtencion de las preguntas y respuestas
	 */
	getPreguntasRespuestas(){
		console.log("PULSA COMENZAR")
		this.modelo.obtenerPreguntasRespuestas()
	 	
	}
	/**
	 * Método para el envio a la vista juego de las preguntas y respuestas del juego
	 * @param {Object} objetoPreguntas 
	 */
	setearPreguntas(objetoPreguntas){
		console.log("AQUÍ HAY COSAAAA",objetoPreguntas)
		this.vistaJuego.setPreguntas(objetoPreguntas)
	}
	/**
	 * Método que oculta todas las vistas
	 */
	ocultarVistas(){
		this.vistaInicio.mostrar(false)
		this.vistaJuego.mostrar(false)
	}

	/**
	 * Método pulsarLogo que oculta las vistas y muestra la del inicio
	 */
	pulsarLogo(){
		this.ocultarVistas()
		this.vistaInicio.mostrar(true)
	}

	/**
	 * Método pulsarComenzarInicio quer oculta las vistas y muestra la del juego
	 */
	pulsarComenzarInicio(){
		this.ocultarVistas()
		this.getPreguntasRespuestas();
		this.vistaJuego.mostrar(true)
	}

	/**
	 * Método getModelo, devuelve el modelo de la aplicación
	 * @return {Modelo} El modelo de la aplicación
	 **/
	getModelo(){
		return this.modelo
	}
}
const app= new Controlador()

