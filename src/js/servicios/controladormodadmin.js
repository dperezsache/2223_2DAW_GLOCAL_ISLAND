"use strict" //activo modo estricto
import {VistaModificar} from '../vistas/vistamodificar.js'
import {VistaNavAdmin} from '../vistas/vistanavadmin.js'

/**
 * Clase Controlador que administra las vistas de modificación de subcategorías del administrador
 */
class ControladorAdminMod {
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

		this.divSubcategorias = document.getElementById('divCrudSubcategorias')
		this.vistaSubcategorias = new VistaModificar(this.divSubcategorias, this)
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

	/**
	 * Método getModelo, devuelve el modelo de la aplicación del administrador.
	 * @return {ModeloAdmin} El modelo de la aplicación.
	 */
	getModelo() {
		return this.modelo
	}
}
const app = new ControladorAdminMod()

