"use strict"
import {Vista} from './vista.js'
/**
 * Clase VistaReflexiones que muestra el formulario de inserción de reflexiones
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaReflexiones extends Vista {

	/**
     * Contructor de la clase VistaReflexiones
     * @param {HTMLDivElement} div Div de la vista
     * @param {Object} controlador Controlador de la vista
     */
	constructor(div, controlador) {
		super(div)
          this.controlador = controlador

          this.formulario = this.div.getElementsByTagName('form')[0]
          this.campoReflexion= this.div.getElementsByTagName('textarea')[0]
          this.campoFallidas= this.div.getElementsByTagName('input')[0]

          this.formulario.addEventListener('submit', this.comprobarReflexiones.bind(this))
	}

     /**
     * Comprobar que la introducción de reflexiones sea válida.
     * @param {Event} e Evento del formulario.
     */
     comprobarReflexiones(e) {

          //Comprobación de campo reflexión
          let valor = this.campoReflexion.value
          let correcto = false
          let errorTexto = ''
  
          // Comprobaciones
        if (valor == '') errorTexto = 'El campo está vacío.'
        else if (valor.length > 500) errorTexto = 'Superado límite de caracteres permitidos (500).'
        else correcto = true
  
          if (correcto) {
              window.location.href = 'index.php'  // Volver a la página principal
          }
          else {
              alert(errorTexto)
              e.preventDefault()  // Detener el submit
              this.cancelar()
          }
          

          //Comprobación de campo respuestas fallidas
          let valor2 = this.campoFallidas.value
          let correcto2 = false
          let errorTexto2 = ''
  
          // Comprobaciones
          if (valor2 == '') errorTexto2 = 'El campo está vacío.'
          else correcto2 = true
  
          if (correcto2) {
              window.location.href = 'index.php'  // Volver a la página principal
          }
          else {
              alert(errorTexto2)
              e.preventDefault()  // Detener el submit
              this.cancelar()
          }
     }
}