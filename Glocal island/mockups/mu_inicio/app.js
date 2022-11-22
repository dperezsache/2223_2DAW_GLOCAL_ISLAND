"use script" //activo modo estricto
import {Modelo} from './modelo.js'
import {VistaJuego} from './vistajuego.js'
import {VistaInicio} from './vistainicio.js'
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
		console.log('iniciar')
		this.modelo=new Modelo(this, this.iniciarVistas.bind(this))

	}
	/**
	 * Método iniciarVistar que se ejecuta al iniciar el modelo
	 */
	iniciarVistas(){
		console.log(this)
		this.divjuego=document.getElementById('divCanvas')
		this.vistaJuego=new VistaJuego(this.divjuego)
		this.divinicio=document.getElementById('divInicio')
		this.vistaInicio=new VistaInicio(this.divinicio)
		
		this.vistaJuego.mostrar(false)
	}

	/**
	 * Método que oculta todas las vistas
	 */
	ocultarVistas(){
		this.divinicio.mostrar(false)
		this.vistaJuego.mostrar(false)
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

