"use script" //activo modo estricto
import {Vista} from './vista.js'
/**
 * Clase VistaJuego que muestra el juego
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaJuego extends Vista{
	/**
     * Contructor de la clase VistaJuego
     * @param {Objeto} divinicio div de la vista
     */
	constructor(divinicio){
		super(divinicio)
        //Declaración de elementos
        this.pregunta=document.getElementById('divPregunta')
        this.respuesta1=document.getElementById('divRespuesta1')
        this.respuesta2=document.getElementById('divRespuesta2')
        this.arrastrar()
	}

	/**
     * Método arrastrar que determina los elementos que se pueden arrastrar y dónde pueden ser soltados
     */
    arrastrar(){
        this.pregunta.addEventListener('dragstart', this.dragStart)

        this.respuesta1.addEventListener('dragenter', this.dragEnter)
		this.respuesta1.addEventListener('dragover', this.dragOver)
		this.respuesta1.addEventListener('dragleave', this.dragLeave)
		this.respuesta1.addEventListener('drop', this.drop)
		
		this.respuesta2.addEventListener('dragenter', this.dragEnter)
		this.respuesta2.addEventListener('dragover', this.dragOver)
		this.respuesta2.addEventListener('dragleave', this.dragLeave)
		this.respuesta2.addEventListener('drop', this.drop)
    }

        
    /**
     * Método  dragStart que se ejecuta cuando se coge la pregunta y se arrastra
     * @param {Objeto} e DragEvent
     */
    dragStart(e) {
        e.dataTransfer.setData('text/plain', e.target.id)
    }

    /**
     * Método dragEnter que se ejecuta cuando la pregunta entra en uno de los div de respuesta
     * @param {Objeto} e DragEvent
     */
    dragEnter(e) {
        e.preventDefault()
        //Damos el estilo drag-over
        e.target.classList.add('drag-over')
    }

    /**
     * Método dragOver que se ejecuta cuando arrastramos la pregunta encima de los div de respuesta
     * @param {Objeto} e DragEvent
     */
    dragOver(e) {
        e.preventDefault()

    }

    /**
     * Método dragLeave que se ejecuta cuando la pregunta sale de los div de respuesta
     * @param {Objeto} e DragEvent
     */
    dragLeave(e) {
        e.target.classList.remove('drag-over')
    }

    /**
     * Método que se ejecuta cuando el div pregunta es soltado en uno de los div respuesta
     * @param {Objeto} e DragEvent
     */
    drop(e) {
        e.target.classList.remove('drag-over')
        // Coger elelemento draggable
        const id = e.dataTransfer.getData('text/plain')
        const draggable = document.getElementById(id)

        e.target.appendChild(draggable)			//lo añadimos al objeto
        let pregunta=document.getElementById('divPregunta')
        pregunta.classList.add('drop-pregunta')
    }

}