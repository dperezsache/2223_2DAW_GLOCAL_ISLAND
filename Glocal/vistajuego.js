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
        this.juego=document.getElementById('divJuego')
        this.pregunta=document.getElementById('divPregunta')
        this.respuesta1=document.getElementById('divRespuesta1')
        this.respuesta2=document.getElementById('divRespuesta2')

        this.btnlogo=document.getElementById('logo')
        this.btnlogo.onclick=this.pulsarLogo.bind(this)
        this.arrastrar()
        this.iniciar()
	}

    /**
     * Método pulsarLogo que se inicia al pulsar el logo de la esquina izquierda y llama al controlador
     */
    pulsarLogo(){
        this.controlador.pulsarLogo()
    }

    /**
     * Método iniciar que crea los objetos y el canvas
     */
    iniciar(){
        this.isla=new Image()
        this.sol=new Image()
        this.luna=new Image()
        this.nube=new Image()
        this.agua=new Image()

        this.isla.src='img/isla.png'
        this.sol.src='img/sol.png'
        this.luna.src='img/luna.png'
        this.nube.src='img/nube.png'
        this.agua.src='img/agua.png'

        this.xnube1=0
        this.xnube2=-300
        this.xagua=-50

        //Creación del canvas
        this.canva=document.createElement('canvas')
        this.ctx=this.canva.getContext('2d')
        this.juego.appendChild(this.canva)
        this.canva.width=820
        this.canva.height=692

        this.draw.bind(this)
        this.movimiento=setInterval(this.moverAgua.bind(this),40)
        setInterval(this.moverNubes.bind(this), 25)
    }

    /**
     * Método draw que pinta los objetos de la isla
     */
    draw(){
        this.ctx.fillStyle='#473DFF'
        this.ctx.fillRect(0,520,900,150)
        this.ctx.drawImage(this.isla, 0, 60, 750, 700)
        this.ctx.drawImage(this.nube,this.xnube1,100,100,50)
        this.ctx.drawImage(this.nube,this.xnube2,150,200,100)
        this.ctx.drawImage(this.agua,this.xagua,560,900,130)
    }

    /**
     * Método mover que borra el lienzo y pinta moviendo los objetos
     */
    moverNubes(){
        this.ctx.clearRect(0,0,this.canva.width, this.canva.height)
        if(this.xnube1==800){
            this.xnube1=-100
        }
        else if(this.xnube2==800){
            this.xnube2=-150
        }
        else{
            this.xnube1=this.xnube1+1
            this.xnube2=this.xnube2+1
        }
        this.draw()
    }

    /**
     * Método moverAgua que que borra el lienzo y dibuja moviendo el elemento del agua
     */
    moverAgua(){
        this.ctx.clearRect(0,0,this.canva.width, this.canva.height)
        if(this.xagua==0){
            this.intervalo=setInterval(this.moverAguaAtras.bind(this),40)
        }
        else{
            this.xagua=this.xagua+1
        }
        this.draw()
    }
    
    /**
     * Método moverAguaAtras que mueve el elemento del agua hacia la izquierda
     */
    moverAguaAtras(){
        /* this.ctx.clearRect(0,0,this.canva.width, this.canva.height)
        if(this.xagua==-70){
            // let intervalo=setInterval(this.moverAgua.bind(this),40)
        }
        else{
            this.xagua=this.xagua-1
            this.draw()
        } */
        
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
        if(e.target.tagName=='DIV'){        //Solo dejamos que entren div
             //Control de error cuando soltamos la respuesta en la caja en la que ya está
            if(e.target.attributes.length==2){
                e.target.appendChild(draggable)			//lo añadimos al objeto
                let pregunta=document.getElementById('divPregunta')
                pregunta.classList.add('drop-pregunta')
            }
        }
    }
}