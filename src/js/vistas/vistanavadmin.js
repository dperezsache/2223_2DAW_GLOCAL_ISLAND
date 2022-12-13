"use strict"
/**
 *	Implementa una vista del menú de navegación del administrador.
 */
export class VistaNavAdmin
{
	/**
	 *	Constructor de la clase.
	 *	@param {HTMLElement} nav Nav de HTML en el que se desplegará la vista.
	 *	@param {Object} controlador Controlador de la vista del administrador.
	 */
	constructor(nav, controlador) {
		this.controlador = controlador
		this.nav = nav
		
		this.liLogo = this.nav.getElementsByTagName('li')[0]
		this.liListado = this.nav.getElementsByTagName('li')[1]
		this.liCategorias = this.nav.getElementsByTagName('li')[2]
		this.liReflexiones = this.nav.getElementsByTagName('li')[3]
		this.liPreguntas = this.nav.getElementsByTagName('li')[4]
		this.liCerrarSesion = this.nav.getElementsByTagName('li')[5]
		
		this.liLogo.onclick = this.pulsarLogo.bind(this)
		this.liListado.onclick = this.pulsarListado.bind(this)
		this.liCategorias.onclick = this.pulsarCategorias.bind(this)
		this.liReflexiones.onclick = this.pulsarReflexiones.bind(this)
		this.liPreguntas.onclick = this.pulsarPreguntas.bind(this)
		this.liCerrarSesion.onclick = this.pulsarCerrarSesion.bind(this)
	}

	/**
	 *	Atención a la pulsación sobre el logo
	 */
	pulsarLogo() {
		this.controlador.pulsarNavLogo()
	}

	/**
	 *	Atención a la pulsación sobre el enlace del listado
	 */
	pulsarListado() {
		this.controlador.pulsarNavListado()
	}

	/**
	 *	Atención a la pulsación sobre el enlace de categorías
	 */
	pulsarCategorias() {
		this.controlador.pulsarNavCategorias()
	}

	/**
	 *	Atención a la pulsación sobre el enlace de reflexiones
	 */
	pulsarReflexiones() {
		this.controlador.pulsarNavReflexiones()
	}
	
	
	/**
	 *	Atención a la pulsación sobre el enlace de preguntas
	 */
	pulsarPreguntas() {
		this.controlador.pulsarNavPreguntas()
	}

	/**
	 *	Atención a la pulsación sobre el enlace de cerrar sesión
	 */
	pulsarCerrarSesion() {
		this.controlador.pulsarNavCerrarSesion()
	}
}