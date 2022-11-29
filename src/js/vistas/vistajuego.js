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
        this.divPuntuacion=document.createElement('div');
        this.divPuntuacion.id="divPuntuacion";
        this.divCronometro=document.createElement('div');
        this.divCronometro.id="divCronometro";

        this.btnlogo=document.getElementById('logo')
        this.btnlogo.onclick=this.pulsarLogo.bind(this)
        this.arrastrar()
        this.iniciar()
        this.puntuacionGlobal=0;
        this.rachaAciertos=0;

        this.tiempoRespuesta=setInterval(this.tiempoRestante.bind(this),1000);

        //CONTADOR ERRORES Y ACIERTOS
        this.contadorErrores={
            "agua":0,
            "tierra":0,
            "aire":0
        }
        this.contadorAciertos={
            "agua":0,
            "tierra":0,
            "aire":0
        }
        //CONTADOR PARA HACER APARECER UN NUMERO POR RESPUESTA, BORRAR AQUI Y EN LA CREACIÓN DINÁMICA DE LAS CARTAS (THIS.NUEVAPREGUNTA())
        this.contadorProvisional=0;
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
        //CREACION DEL SPRITE TORNADO
        this.sprtTornado=new Image()
        this.sprtTornado.src='../../img/sprites/tornado/tornado.png'

        //CREACIÓN DEL SPRITE TORMENTA
        this.sprtTormenta1=new Image()
        this.sprtTormenta1.src='../../img/sprites/rayo/rayo.png'

        this.sprtTormenta2=new Image()
        this.sprtTormenta2.src='../../img/sprites/rayo/rayo.png'


        this.isla.src='../../img/isla.png'
        this.sol.src='../../img/sol.png'
        this.luna.src='../../img/luna.png'
        this.nube.src='../../img/nube.png'

        this.xnube1=0
        this.xnube2=-300
        this.xagua=-50
        this.anchoAgua=560
        this.swAgua=1;
        
        //Creación del canvas
        this.canva=document.createElement('canvas')
        this.ctx=this.canva.getContext('2d')
        this.juego.appendChild(this.canva)
        this.canva.width=820
        this.canva.height=692

        this.draw.bind(this)
        setInterval(this.moverNubes.bind(this), 25)
        this.tiempoRespuesta=60;

        //VARIABLES PARA EL MONTAJE DEL AGUA DINAMICA
        this.start = { x: -1000,    y: 750  };
        this.cp1 =   { x: 305,   y: 600  };
        this.cp2 =   { x: 410,   y: 750  };
        this.end =   { x: this.canva.width+1000,   y: 600 };
        this.swAgua=0;
        this.alturaAgua=200;

        //VARIABLE PARA LOS FRAMES DEL SPRTTORNADO
        this.indiceFrameTornado=1;
        this.tornadoIzq=0
        this.swTornado=1
        setInterval(this.movTornado.bind(this),70)

        //VARIABLES PARA FRAMES DE TORMENTA
        this.indiceFrameTormenta=6;
        this.tormentaPeq=0;
        this.tormentaGr=0
        this.swTormenta=1;
        setInterval(this.aparicionTormenta.bind(this),100);
        
    }

    /**
     * Método draw que pinta los objetos de la isla
     */
    draw(){
        if(this.contadorErrores["aire"]>=9){
            this.ctx.drawImage(this.sprtTornado,this.indiceFrameTornado*191,0,191,173,this.tornadoIzq,-100,191,830)
        }
        if(this.contadorErrores["aire"]>=6){
            this.ctx.drawImage(this.sprtTormenta1,this.indiceFrameTormenta*66,0,66,224,this.tormentaIzq+50,90,91,830)
            this.ctx.drawImage(this.sprtTormenta2,this.indiceFrameTormenta*66,0,66,224,this.tormentaGr+50,120,111,830)
        }
       
        //this.indiceFrameTormenta++
        
        this.ctx.fillStyle='#473DFF'
        this.ctx.fillRect(0,520,900,150)
        this.ctx.drawImage(this.isla, 0, 60, 750, 700)
        this.ctx.drawImage(this.nube,this.xnube1,100,100,50)
        this.ctx.drawImage(this.nube,this.xnube2,150,200,100)
        this.ctx.drawImage(this.agua,this.xagua,560,this.anchoAgua,130)
        
        if(this.cp1.x>2000)
            this.swAgua=0;
        if(this.cp2.x<-200)
            this.swAgua=1

        if(this.swAgua==1){
            this.cp1.x+=10;
            this.cp2.x+=10;
        }else{
            this.cp1.x-=10;
            this.cp2.x-=10;
        }
       


        this.ctx.beginPath();
        this.ctx.moveTo(this.start.x, this.start.y);
        this.ctx.bezierCurveTo(this.cp1.x, this.cp1.y, this.cp2.x, this.cp2.y, this.end.x, this.end.y);
        this.ctx.lineWidth=this.alturaAgua;
        this.ctx.strokeStyle="#3673A7";
        this.ctx.stroke();
        
    }
    aparicionTormenta(){
        this.ctx.clearRect(0,0,this.canva.width, this.canva.height)
        this.indiceFrameTormenta++
        this.draw();
        if(this.indiceFrameTormenta==7){
            this.indiceFrameTormenta=0;
            this.tormentaIzq=this.xnube1
            this.tormentaGr=this.xnube2
            console.log("direccion de la tormenta",this.tormentaIzq)
        }
        
    }
    /**
     * Método para la creación del movimiento del sprite del tornado
     */
    movTornado(){
        this.ctx.clearRect(0,0,this.canva.width, this.canva.height)
        //CONDICIÓN PARA LA VUELTA DEL SPRT TORNADO
       if(this.indiceFrameTornado==4)
        this.indiceFrameTornado=1;

        this.indiceFrameTornado++

        if(this.tornadoIzq==1000)
            this.swTornado=0
        if(this.tornadoIzq==-1000)
            this.swTornado=1

        if(this.swTornado==1)
         this.tornadoIzq+=5

        if(this.swTornado==0)
         this.tornadoIzq-=5

        
        
        
        //console.log(this.framesTornado)
        this.draw()
    }
    /**
     * Método mover que borra el lienzo y pinta moviendo los objetos
     */
    moverNubes(){
       /* console.log('Moviendo nubes')*/
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
     * Método arrastrar que determina los elementos que se pueden arrastrar y dónde pueden ser soltados
     */
    arrastrar(){
        this.pregunta.addEventListener('dragstart', this.dragStart.bind(this))

        this.respuesta1.addEventListener('dragenter', this.dragEnter.bind(this))
		this.respuesta1.addEventListener('dragover', this.dragOver.bind(this))
		this.respuesta1.addEventListener('dragleave', this.dragLeave.bind(this))
		this.respuesta1.addEventListener('drop', this.drop.bind(this))
		
		this.respuesta2.addEventListener('dragenter', this.dragEnter.bind(this))
		this.respuesta2.addEventListener('dragover', this.dragOver.bind(this))
		this.respuesta2.addEventListener('dragleave', this.dragLeave.bind(this))
		this.respuesta2.addEventListener('drop', this.drop.bind(this))
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
            let div=e.path[0]
            console.log(e);
            if(div.getAttribute('value')=="Correcto"){
                
                this.rachaAciertos++
                this.contadorAciertos[draggable.getAttribute('value')]++;
                console.log("CONTADOR DE ACIERTOS: ",this.contadorAciertos)
                clearInterval(this.tiempoRespuesta);
                this.sumarPuntuacion(this.tiempoRespuesta*this.rachaAciertos);
                
            }else{
                this.eventosErrores(draggable.getAttribute('value'))
                this.rachaAciertos=0;
            }
               
            
        }
        
        this.nuevaPregunta()

        
    }
    nuevaPregunta(){
        this.borrarPregunta();
        this.pregunta.remove();
        this.respuesta1.remove();
        this.respuesta2.remove();
        this.divJuegoCartas=document.getElementById('divCanvas')

        this.pregunta=document.createElement('div')
        this.pregunta.id="divPregunta";
        this.pregunta.draggable=true;
        this.pregunta.setAttribute("value","aire")
        this.divJuegoCartas.appendChild(this.pregunta)

        let p=document.createElement('p')
        this.pregunta.appendChild(p)
        p.appendChild(document.createTextNode('Nueva pregunta'))
       
        this.respuesta1=document.createElement('div');
        this.respuesta1.setAttribute("value","Correcto");
        this.respuesta1.className="respuestas";
        

        let respuestaBuena=document.createElement('p');
        respuestaBuena.id="textoRespuesta";
        this.respuesta1.appendChild(respuestaBuena)
        respuestaBuena.appendChild(document.createTextNode('respuesta '+this.contadorProvisional))
        this.divJuegoCartas.appendChild(this.respuesta1)

        this.respuesta2=document.createElement('div');
        this.respuesta2.className="respuestas";
        this.respuesta2.setAttribute("value","Error");
        let respuestaMala=document.createElement('p');
        this.respuesta2.appendChild(respuestaMala)
        respuestaMala.appendChild(document.createTextNode('respuesta '+this.contadorProvisional))
        this.divJuegoCartas.appendChild(this.respuesta2);

        this.divJuegoCartas.appendChild(this.divPuntuacion);
        this.divJuegoCartas.appendChild(this.divCronometro);

        this.contadorProvisional++;
        this.tiempoRespuesta=20;
        this.arrastrar();
    }
    tiempoRestante(){
        if(this.tiempoRespuesta>0){
            this.tiempoRespuesta--;
         }
         this.borrarCrono();
         let p=document.createElement('p');
         p.appendChild(document.createTextNode(this.tiempoRespuesta))
         this.divCronometro.appendChild(p)

    }
    sumarPuntuacion(puntuacion){
        this.puntuacionGlobal+=puntuacion
        this.borrarPuntuacion();
        
        let p=document.createElement('p');
        this.divPuntuacion.appendChild(p);
        p.appendChild(document.createTextNode(this.puntuacionGlobal));
    }
    eventosErrores(categoria){
        let coloresCielo={
            3:'#D1D4D7',
            6:'#D1B487',
            9:'#F3B960'
        }
        this.contadorErrores[categoria]++
        console.log("La categoria es: ",categoria)
        console.log("CONTADOR DE ERRORES: ",this.contadorErrores)

        
        if(this.contadorErrores["agua"]%3==0 && this.contadorErrores["agua"]!=0){
            if(this.alturaAgua<320)
                this.alturaAgua+=10;
        }
        if(this.contadorErrores["tierra"]%3==0 && this.contadorErrores["tierra"]!=0){
            //this.contadorErrores["tierra"]=0;
            console.log("ERROR DE TIERRA")
        }
        if(this.contadorErrores["aire"]%3==0 && this.contadorErrores["aire"]!=0){
            //this.contadorErrores["aire"]=0
            console.log("ERROR DE AIRE")
            this.juego.style.backgroundColor=coloresCielo[this.contadorErrores["aire"]];
        }
        
        
    }
    borrarCrono(){
        while(this.divCronometro.firstElementChild)
            this.divCronometro.firstElementChild.remove()
    }
    borrarPuntuacion(){
        while(this.divPuntuacion.firstElementChild)
            this.divPuntuacion.firstElementChild.remove()
    }
    borrarPregunta(){
        while (this.pregunta.firstElementChild)
	        this.pregunta.firstElementChild.remove()
         while (this.respuesta1.firstElementChild)
	        this.respuesta1.firstElementChild.remove()
        while (this.respuesta2.firstElementChild)
	        this.respuesta2.firstElementChild.remove()
    }
}