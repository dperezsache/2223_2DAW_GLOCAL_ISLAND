"use strict" //activo modo estricto
import { ModeloAdmin } from '../modelos/modeloadmin.js'
import { VistaListado } from '../vistas/vistalistado.js'
import { VistaCategorias } from '../vistas/vistacategorias.js'
import { VistaPreguntas } from '../vistas/vistapreguntas.js'
import { VistaNavAdmin } from '../vistas/vistanavadmin.js'
import { VistaSubcategorias } from '../vistas/vistasubcategorias.js'

/**
 * Clase Controlador que administra las vistas del administrador
 */
class ControladorAdmin {
	/**
	 * Constructor de la clase Controlador
	 * Cuando carga la web ejecuta el método iniciar
	 */
	constructor() {
		window.onload = this.iniciar.bind(this)
	}

	/**
	 * Método iniciar que es el primero en ejecutarse cuando se carga la pantalla
	 */
	iniciar() {
		this.modelo = new ModeloAdmin(this, this.iniciarVistas.bind(this))
	}

	/**
	 * Método iniciarVistar que se ejecuta al iniciar el modelo
	 */
	iniciarVistas() {
		this.nav = document.getElementsByTagName('nav')[0]
		this.vistaNav = new VistaNavAdmin(this.nav, this)

        this.divListado = document.getElementById('divListado')
        this.vistaListado = new VistaListado(this.divListado, this)

        this.divCategorias = document.getElementById('divCrudCategorias')
        this.vistaCategorias = new VistaCategorias(this.divCategorias, this)

		this.divSubcategorias = document.getElementById('divCrudSubcategorias')
		this.vistaSubcategorias = new VistaSubcategorias(this.divSubcategorias, this)

        this.divPreguntas = document.getElementById('divPreguntas')
        this.vistaPreguntas = new VistaPreguntas(this.divPreguntas, this)

		this.pulsarNavListado()	// Iniciar en vista de listado
	}

	/**
	 * Atención a la pulsación sobre el enlace de categorías
	 */
	pulsarNavListado() {
		this.vistaListado.mostrar(true)
		this.vistaCategorias.mostrar(false)
		this.vistaSubcategorias.mostrar(false)
		this.vistaPreguntas.mostrar(false)
	}

	/**
	 * Atención a la pulsación sobre el enlace de categorías
	 */
	pulsarNavCategorias() {
        this.vistaListado.mostrar(false)
        this.vistaCategorias.mostrar(true)
		this.vistaSubcategorias.mostrar(true)
        this.vistaPreguntas.mostrar(false)
	}

	/**
	 * Atención a la pulsación sobre el enlace de preguntas
	 */
	pulsarNavPreguntas() {
        this.vistaListado.mostrar(false)
        this.vistaCategorias.mostrar(false)
		this.vistaSubcategorias.mostrar(false)
        this.vistaPreguntas.mostrar(true)
	}

	/**
	 * Atención a la pulsación sobre el enlace de cerrar sesión
	 */
	pulsarNavCerrarSesion() {
		console.log('Cerrar sesión')
	}

	/**
	 * Método getModelo, devuelve el modelo de la aplicación del administrador.
	 * @return {ModeloAdmin} El modelo de la aplicación.
	 */
	getModelo() {
		return this.modelo
	}
}
const app = new ControladorAdmin()

