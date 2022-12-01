"use strict" //activo modo estricto
import {VistaModificarIcono} from '../vistas/vistamodificaricono.js'
import {VistaNavAdmin} from '../vistas/vistanavadmin.js'

/**
 * Clase Controlador que administra las vistas de modificación de subcategorías del administrador
 */
class ControladorModificarIcono {
	/**
	 * Constructor de la clase Controlador de modificación de subcategorías
	 */
	constructor() {
		window.onload = this.iniciar.bind(this)
	}

	/**
	 * Método iniciarVistar que se ejecuta al iniciar el modelo
	 */
	iniciar() {
		this.nav = document.getElementsByTagName('nav')[0]
		this.vistaNav = new VistaNavAdmin(this.nav, this)

		this.divModificarIcono = document.getElementById('divModSubcategorias')
		this.vistaModificarIcono = new VistaModificarIcono(this.divModificarIcono, this)
	}

	/**
	 * Atención a la pulsación sobre el logo
	 */
	pulsarNavLogo() {
		window.location.href = '../../../index.php/html/index.html'
	}

	/**
	 * Atención a la pulsación sobre el enlace de categorías
	 */
	pulsarNavListado() {
		window.location.href = 'index.php'
	}

	/**
	 * Atención a la pulsación sobre el enlace de categorías
	 */
	pulsarNavCategorias() {
		window.location.href = 'index.php'
	}

	/*
	pulsarNavReflexiones() {
		window.location.href = 'index.php'
	}
	*/

	/**
	 * Atención a la pulsación sobre el enlace de preguntas
	 */
	pulsarNavPreguntas() {
		window.location.href = 'index.php'
	}

	/**
	 * Atención a la pulsación sobre el enlace de cerrar sesión
	 */
	pulsarNavCerrarSesion() {
		window.location.href = '../../../index.php/html/logout.php'
	}
}
const app = new ControladorModificarIcono()

