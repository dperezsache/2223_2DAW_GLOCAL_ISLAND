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
	constructor(divinicio, controlador){
		super(divinicio)
        this.controlador=controlador
        //Declaración de elementos
        this.pregunta=document.getElementById('divPregunta')
        this.respuesta1=document.getElementById('divRespuesta1')
        this.respuesta2=document.getElementById('divRespuesta2')

        this.btnlogo=document.getElementById('logo')
        this.btnlogo.onclick=this.pulsarLogo.bind(this)
        this.arrastrar()
	}

    pulsarLogo(){
        this.controlador.pulsarLogo()
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
        if(e.target.tagName=='DIV'){        //Solo permitimos que entre los div
            //Damos el estilo drag-over
            e.target.classList.add('drag-over')
        }
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
        if(e.target.tagName=='DIV'){
            //Control de error cuando soltamos la respuesta en la caja en la que ya está
            if(e.target.attributes.length==2){
                e.target.appendChild(draggable)			//lo añadimos al objeto
                let pregunta=document.getElementById('divPregunta')
                pregunta.classList.add('drop-pregunta')
            }
        }
    }

}