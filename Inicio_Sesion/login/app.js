"use script" //activo modo estricto
import {Modelo} from './modelo.js'
import {VistaLogin} from './vistalogin.js'
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
		this.divInicioSesion=document.getElementById('divInicioSesion')
		this.vistaLogin=new VistaLogin(this.divInicioSesion, this)
		
		this.vistaLogin.mostrar(true)
	}

	/**
	 * Método que oculta todas las vistas
	 */
	ocultarVistas(){
		this.vistaLogin.mostrar(false)
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

