"use strict" //activo modo estricto
import {Vista} from './vista.js'
/**
 * Clase VistaJuego que muestra el juego
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaJuego extends Vista {
	/**
     * Contructor de la clase VistaJuego
     * @param {Objeto} divinicio div de la vista
     */
	constructor(divinicio, controlador) {
		super(divinicio)
        this.controlador=controlador

        //Declaración de elementos
        this.juego=document.getElementById('divJuego')
        this.pregunta=document.getElementById('divPregunta')
        this.respuesta1=document.getElementById('divRespuesta1')
        this.respuesta2=document.getElementById('divRespuesta2')

        this.temporizadorPajaro1 = null
        this.pajaro1 = {
            img: null,
            x: 0,
            y: 0,
            width: 0,
            height: 0,
            frameActual: 0,
            totalFrames: 0
        }

        this.temporizadorPajaro2 = null
        this.pajaro2 = {
            img: null,
            x: 0,
            y: 0,
            width: 0,
            height: 0,
            frameActual: 0,
            totalFrames: 0
        }

        this.temporizadorPersona = null
        this.mostrado = false
        this.persona = {
            img: null,
            x: 0,
            y: 0,
            width: 0,
            height: 0,
            columna: 0,
            frameActual: 0,
            totalFrames: 0
        }

        this.temporizadorPez1 = null
        this.pez1 = {
            img: null,
            x: 0,
            y: 0,
            width: 0,
            height: 0,
            indiceImg: 0
        }

        this.temporizadorPez2 = null
        this.pez2 = {
            img: null,
            x: 0,
            y: 0,
            width: 0,
            height: 0,
            indiceImg: 0
        }

        this.textoEstado = ''

        this.btnlogo=document.getElementById('logo')
        this.btnlogo.onclick=this.pulsarLogo.bind(this)
        this.arrastrar()
        this.iniciar()
	}

    /**
     * Método pulsarLogo que se inicia al pulsar el logo de la esquina izquierda y llama al controlador
     */
    pulsarLogo() {
        this.controlador.pulsarLogo()
    }

    /**
     * Método iniciar que crea los objetos y el canvas
     */
    iniciar() {
        // Creación del canvas
        this.canva=document.createElement('canvas')
        this.ctx=this.canva.getContext('2d')
        this.juego.appendChild(this.canva)
        this.canva.width=820
        this.canva.height=692
        this.canva.addEventListener('mousemove', this.estadoIsla.bind(this))

        // Imágenes
        this.isla=new Image()
        this.sol=new Image()
        this.luna=new Image()
        this.nube=new Image()
        this.agua=new Image()

        this.isla.src='../../img/isla.png'
        this.sol.src='../../img/sol.png'
        this.luna.src='../../img/luna.png'
        this.nube.src='../../img/nube.png'
        //this.agua.src='../../img/agua.png'

        this.xnube1=0
        this.xnube2=-300
        this.xagua=-50
        this.anchoAgua=560
        this.swAgua=1;

        // Pájaros
        this.pajaro1.y = 100
        this.pajaro1.width = 32
        this.pajaro1.height =  32
        this.pajaro1.totalFrames = 6
        this.pajaro1.img = new Image()
        this.pajaro1.img.src = '../../img/sprites/pajaros/pajaro1/sprite_pajaro1.png'
        this.pajaro1.img.onload = this.moverPajaros.bind(this, this.pajaro1, this.temporizadorPajaro1)
        
        this.pajaro2.y = 150
        this.pajaro2.width = 32
        this.pajaro2.height =  32
        this.pajaro2.totalFrames = 6
        this.pajaro2.img = new Image()
        this.pajaro2.img.src = '../../img/sprites/pajaros/pajaro2/sprite_paloma.png'
        this.pajaro2.img.onload = this.moverPajaros.bind(this, this.pajaro2, this.temporizadorPajaro2)

        // Peces
        this.pez1.y = 620
        this.pez1.width = 32
        this.pez1.height = 12
        this.pez1.img = []
        this.pez1.img[0] = new Image()
        this.pez1.img[0].src = '../../img/sprites/peces/pez1_1.png'
        this.pez1.img[1] = new Image()
        this.pez1.img[1].src = '../../img/sprites/peces/pez1_2.png'
        this.pez1.img[1].onload = this.moverPeces.bind(this, this.pez1, this.temporizadorPez1)

        this.pez2.y = 660
        this.pez2.width = 32
        this.pez2.height = 12
        this.pez2.img = []
        this.pez2.img[0] = new Image()
        this.pez2.img[0].src = '../../img/sprites/peces/pez2_1.png'
        this.pez2.img[1] = new Image()
        this.pez2.img[1].src = '../../img/sprites/peces/pez2_2.png'
        this.pez2.img[1].onload = this.moverPeces.bind(this, this.pez2, this.temporizadorPez2)

        // Persona
        this.persona.x = 250
        this.persona.y = 430
        this.persona.width = 64
        this.persona.height = 64
        this.persona.img = new Image()
        this.persona.img.src = '../../img/sprites/personajes/personaje4/Download51878.png'
        this.persona.img.onload = this.animarPersona.bind(this, this.persona, this.temporizadorPersona)
        this.persona.img.onmouseover = this.estadoIsla.bind(this)

        // VARIABLES PARA EL MONTAJE DEL AGUA DINAMICA
        this.start = { x: -1000,    y: 750  };
        this.cp1 =   { x: 305,   y: 600  };
        this.cp2 =   { x: 410,   y: 750  };
        this.end =   { x: this.canva.width+1000,   y: 600 };
        this.swAgua=0;
        this.alturaAgua=200;

        this.draw.bind(this)
        this.movimiento=setInterval(this.moverAgua.bind(this), 40)
        setInterval(this.moverNubes.bind(this), 25)
    }

    /**
     * Método draw que pinta los objetos de la isla
     */
    draw() {
        this.ctx.fillStyle = '#473DFF'
        this.ctx.fillRect(0, 520, 900, 150)
        this.ctx.drawImage(this.isla, 0, 60, 750, 700)
        this.ctx.drawImage(this.nube, this.xnube1, 100, 100, 50)
        this.ctx.drawImage(this.nube, this.xnube2, 150, 200, 100)
        this.ctx.drawImage(this.agua, this.xagua, 560, this.anchoAgua, 130)

        // Pájaros
        this.ctx.drawImage(this.pajaro1.img, this.pajaro1.frameActual * this.pajaro1.width, 0, this.pajaro1.width, this.pajaro1.height, this.pajaro1.x, this.pajaro1.y, this.pajaro1.width, this.pajaro1.height)
        this.ctx.drawImage(this.pajaro2.img, this.pajaro2.frameActual * this.pajaro2.width, 0, this.pajaro2.width, this.pajaro2.height, this.pajaro2.x, this.pajaro2.y, this.pajaro2.width, this.pajaro2.height)

        // Persona
        this.ctx.fillStyle = "white"
        this.ctx.font = 'bold 15px Arial'
        this.ctx.fillText(this.textoEstado, this.persona.x,  this.persona.y)
        this.ctx.drawImage(this.persona.img, this.persona.frameActual * this.persona.width, this.persona.columna * this.persona.height, this.persona.width, this.persona.height, this.persona.x, this.persona.y, this.persona.width, this.persona.height)
   
        // AGUA
        if (this.cp1.x > 2000) {
            this.swAgua=0;
        }
        if (this.cp2.x <- 200) {
            this.swAgua=1
        }

        if (this.swAgua == 1) {
            this.cp1.x+=10;
            this.cp2.x+=10;
        }
        else {
            this.cp1.x -= 10;
            this.cp2.x -= 10;
        }
       
        this.ctx.beginPath();
        this.ctx.moveTo(this.start.x, this.start.y);
        this.ctx.bezierCurveTo(this.cp1.x, this.cp1.y, this.cp2.x, this.cp2.y, this.end.x, this.end.y);
        this.ctx.lineWidth=this.alturaAgua;
        this.ctx.strokeStyle="#3673A7";
        this.ctx.stroke();

        // Peces
        this.ctx.drawImage(this.pez1.img[this.pez1.indiceImg], this.pez1.x, this.pez1.y)
        this.ctx.drawImage(this.pez2.img[this.pez2.indiceImg], this.pez2.x, this.pez2.y)
    }

    /**
     * Muestra un mensaje con el estado actual de la isla.
     * @param {Event} e Evento de mousemove 
     */
    estadoIsla(e) {
        if(e.offsetX > this.persona.x && e.offsetX < this.persona.x + this.persona.width) {
            this.textoEstado = 'Hola mundo'
            this.draw()
        }
        else {
            this.textoEstado = ''
        }
        
    }

    /**
     * Darles un movimiento aleatorio a los pájaros.
     * @param {Object} pajaro Objeto del pájaro.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento del pájaro.
     */
    moverPajaros(pajaro, temporizador) {
        let opcion = Math.floor((Math.random() * (2 - 1 + 1)) + 1)  // Generar opción de movimiento random (1 o 2)
        let velocidad
        pajaro.frameActual = 0

        velocidad = Math.floor((Math.random() * (65 - 50 + 1)) + 50)    // Velocidad de refresco entre 50 y 65
        switch(opcion) {
            case 1:
                pajaro.x = -100
                temporizador = setInterval(function() {this.pajaroAnim1(pajaro, temporizador)}.bind(this), velocidad)
                break

            case 2:
                pajaro.x = 1000
                temporizador = setInterval(function() {this.pajaroAnim2(pajaro, temporizador)}.bind(this), 40)
                break
        }
    }

    /**
     * Darles un movimiento aleatorio a los peces.
     * @param {Object} pez Objeto del pez.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento del pez.
     */
    moverPeces(pez, temporizador) {
        let opcion = Math.floor((Math.random() * (2 - 1 + 1)) + 1)  // Generar opción de movimiento random (1 o 2)
        let velocidad
        
        velocidad = Math.floor((Math.random() * (80 - 60 + 1)) + 60)    // Velocidad de refresco entre 60 y 80
        switch(opcion) {
            case 1:
                pez.x = -25
                pez.indiceImg = 1
                temporizador = setInterval(function() {this.pezAnim1(pez, temporizador)}.bind(this), velocidad)
                break

            case 2:
                pez.x = 900
                pez.indiceImg = 0
                temporizador = setInterval(function() {this.pezAnim2(pez, temporizador)}.bind(this), velocidad)
                break
        }
    }

    /**
     * Le asigna una animación a la persona.
     * @param {Object} persona Objeto de la persona.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento del pájaro.
     */
    animarPersona(persona, temporizador) {
        let opcion = Math.floor((Math.random() * (3 - 1 + 1)) + 1)  // Generar opción de animación (1 a 4)
        let limiteX
        persona.frameActual = 0

        // Si la persona está al límite derecho o izquierdo de la isla, cambiar la dirección
        if (opcion == 1 || opcion == 2) {
            if (persona.x > 700)
                opcion = 2
            
            else if (persona.x < 170)
                opcion = 1
        }

        switch(opcion) {
            // Mover de izquierda a derecha de la isla
            case 1:
                limiteX = Math.floor((Math.random() * (600 - 350 + 1)) + 350)
                persona.columna = 11        // Asignar la columna del sprite dónde está la animación a realizar
                persona.totalFrames = 9     // Asignar el total de frames que tiene la columna del sprite
                temporizador = setInterval(function() {this.personaAnimacionAndar1(persona, temporizador, limiteX)}.bind(this), 60)
                break

            // Mover de derecha a izquierda de la isla
            case 2:
                limiteX = Math.floor((Math.random() * (250 - 130 + 1)) + 130)
                persona.columna = 9         // Asignar la columna del sprite dónde está la animación a realizar
                persona.totalFrames = 9     // Asignar el total de frames que tiene la columna del sprite
                temporizador = setInterval(function() {this.personaAnimacionAndar2(persona, temporizador, limiteX)}.bind(this), 60)
                break

            // Realiza una animación al azar
            case 3: 
                persona.columna = Math.floor((Math.random() * (4 - 1 + 1)) + 1)        // Asignar la columna del sprite dónde está la animación a realizar
                persona.totalFrames = 7     // Asignar el total de frames que tiene la columna del sprite
                temporizador = setInterval(function() {this.personaAnimacion(persona, temporizador)}.bind(this), 150)
                break
            
            default:
                break
        }
    }

    /**
     * Mover persona de izquierda a derecha de la isla
     * @param {Object} persona Objeto de la persona.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento de la persona.
     * @param {Number} limiteX Limite del eje X hasta dónde mover a la persona
     */
    personaAnimacionAndar1(persona, temporizador, limiteX) {
        persona.frameActual++
        if (persona.frameActual >= persona.totalFrames) {
            persona.frameActual = 0
        }

        if (persona.x >= limiteX) {
            clearInterval(temporizador)
            this.animarPersona(persona, temporizador)
            return
        }
        else {
            persona.x = persona.x + 2 
        }

        this.draw()
    }

    /**
     * Mover persona de derecha a izquierda de la isla
     * @param {Object} persona Objeto de la persona.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento de la persona.
     * @param {Number} limiteX Limite del eje X hasta dónde mover a la persona
     */
    personaAnimacionAndar2(persona, temporizador, limiteX) {
        persona.frameActual++
        if (persona.frameActual >= persona.totalFrames) {
            persona.frameActual = 0
        }

        if (persona.x <= limiteX) {
            clearInterval(temporizador)
            this.animarPersona(persona, temporizador)
            return
        }
        else {
            persona.x = persona.x - 2
        }

        this.draw()
    }

    /**
     * El personaje realiza una animación.
     * @param {Object} persona Objeto de la persona.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento de la persona.
     */
    personaAnimacion(persona, temporizador) {
        persona.frameActual++
        if (persona.frameActual >= persona.totalFrames) {
            clearInterval(temporizador)
            this.animarPersona(persona, temporizador)
            return
        }

        this.draw()
    }

    /**
     * Realiza el movimiento de principio a fin del canvas del pájaro pasado.
     * @param {Object} pajaro Objeto del pájaro.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento del pájaro.
     */
    pajaroAnim1(pajaro, temporizador) {
        pajaro.frameActual++
        if (pajaro.frameActual >= pajaro.totalFrames) {
            pajaro.frameActual = 0
        }

        // Una vez llegado al final del canvas, llamar a función para obtener otro movimiento.
        if (pajaro.x >= 1000) {
            clearInterval(temporizador)
            this.moverPajaros(pajaro, temporizador)
            return
        }
        else {
            pajaro.x = pajaro.x + 5
        }

        this.draw()
    }

    /**
     * Realiza el movimiento del final al principio del canvas del pájaro pasado.
     * @param {Object} pajaro Objeto del pájaro.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento del pájaro.
     */
    pajaroAnim2(pajaro, temporizador) {
        pajaro.frameActual++
        if (pajaro.frameActual >= pajaro.totalFrames) {
            pajaro.frameActual = 0
        }

        // Una vez llegado al inicio del canvas, llamar a función para obtener otro movimiento.
        if (pajaro.x <= -100) {
            clearInterval(temporizador)
            this.moverPajaros(pajaro, temporizador)
            return
        }
        else {
            pajaro.x = pajaro.x - 5
        }

        this.draw()
    }

    /**
     * Realiza el movimiento de principio a fin del canvas del pez pasado.
     * @param {Object} pez Objeto del pájaro.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento del pez.
     */
    pezAnim1(pez, temporizador) {
        if (pez.x >= 1000) {
            clearInterval(temporizador)
            this.moverPeces(pez, temporizador)
            return
        }
        else {
            pez.x = pez.x + 2
        }

        this.draw()
    }
    
    /**
     * Realiza el movimiento del final al principio del canvas del pez pasado.
     * @param {Object} pez Objeto del pez.
     * @param {Number} temporizador ID del setInterval, para poder detener movimiento del pez.
     */
    pezAnim2(pez, temporizador) {
        if (pez.x <= -100) {
            clearInterval(temporizador)
            this.moverPeces(pez, temporizador)
            return
        }
        else {
            pez.x = pez.x - 2
        }

        this.draw()
    }

    /**
     * Método mover que borra el lienzo y pinta moviendo los objetos
     */
    moverNubes() {
        this.ctx.clearRect(0,0,this.canva.width, this.canva.height)

        if(this.xnube1==800) {
            this.xnube1=-100
        }
        else if(this.xnube2==800) {
            this.xnube2=-150
        }
        else {
            this.xnube1=this.xnube1+1
            this.xnube2=this.xnube2+1
        }

        this.draw()
    }

    /**
     * Método moverAgua que que borra el lienzo y dibuja moviendo el elemento del agua
     */
    moverAgua() {
        /*  console.log('Moviendo aguaaaa')*/
        this.ctx.clearRect(0, 0, this.canva.width, this.canva.height)

        if (this.anchoAgua == 5000) {
            this.intervalo = setInterval(this.moverAguaAtras.bind(this), 40)
        }
        else {
            this.xagua = this.xagua
            this.anchoAgua = this.anchoAgua + 10;
        }
        this.draw()
    }
    
    /**
     * Método moverAguaAtras que mueve el elemento del agua hacia la izquierda
     */
    moverAguaAtras() {
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
    arrastrar() {
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
     * @param {Object} e DragEvent
     */
    dragStart(e) {
        e.dataTransfer.setData('text/plain', e.target.id)
    }

    /**
     * Método dragEnter que se ejecuta cuando la pregunta entra en uno de los div de respuesta
     * @param {Object} e DragEvent
     */
    dragEnter(e) {
        e.preventDefault()

        if(e.target.tagName=='DIV') {        //Solo permitimos que entre los div
            //Damos el estilo drag-over
            e.target.classList.add('drag-over')
        }
    }

    /**
     * Método dragOver que se ejecuta cuando arrastramos la pregunta encima de los div de respuesta
     * @param {Object} e DragEvent
     */
    dragOver(e) {
        e.preventDefault()

    }

    /**
     * Método dragLeave que se ejecuta cuando la pregunta sale de los div de respuesta
     * @param {Object} e DragEvent
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

        // Coger el elemento draggable
        const id = e.dataTransfer.getData('text/plain')
        const draggable = document.getElementById(id)

        if(e.target.tagName=='DIV') {        //Solo dejamos que entren div
             //Control de error cuando soltamos la respuesta en la caja en la que ya está
            if(e.target.attributes.length==2) {
                e.target.appendChild(draggable)			//lo añadimos al objeto
                let pregunta=document.getElementById('divPregunta')
                pregunta.classList.add('drop-pregunta')
            }
        }
    }
}