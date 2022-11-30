'use strict'

import {ModeloAdmin} from "../modelos/modeloadmin.js";
import {VistaCategorias} from "../vistas/vistacategorias.js";
import {VistaCrudCategorias} from "../vistas/vistacrudcategorias.js";
import {VistaCrudSubCategorias} from "../vistas/vistacrudsubcategorias.js";
import {VistaListado} from "../vistas/vistalistado.js";
import {VistaPreguntas} from "../vistas/vistapreguntas.js";
/**
 * Clase Controlador que administra las vistas
 */
console.log("conectado")
export class ControladorAdmin{
    /**
	 * Constructor de la clase ControladorAdmin
	 * Cuando carga la web ejecuta el método iniciar
	 */
    constructor(){
        window.onload=this.iniciar.bind(this)
    }
    /**
	 * Método iniciar que es el primero en ejecutarse cuando se carga la pantalla
	 */
    iniciar(){
        this.modelo=new ModeloAdmin(this,this.iniciarVistas.bind(this));
        //METODO PARA LA COMPROBACIÓN DE UNS VISTA U OTRA DENTRO DE LA VISTA DE CATEGORIAS
       //this.mostrarCatOsub()
    }
    /**
	 * Método iniciarVistar que se ejecuta al iniciar el modelo
	 */
    iniciarVistas(){
        console.log("iniciandoVistas")
        this.divListado=document.getElementById("divListado");
        this.divListado=new VistaListado(this,this.divListado)

        this.divCategorias=document.getElementById("divCategorias");
        this.divCategorias=new VistaCategorias(this,this.divCategorias)

        //SETEO DE LAS DISTINTAS VISTAS DENTRO DE LA VISTA CATEGORIAS(LOS DISTINTOS DIVS QUE HAY)
        this.divCrudCategorias=document.getElementById("divCrudCategorias");
        this.divCrudCategorias=new VistaCrudCategorias(this,this.divCrudCategorias);

        this.divCrudSubCategorias=document.getElementById("divCrudSubcategorias");
        this.divCrudSubCategorias=new VistaCrudCategorias(this,this.divCrudSubCategorias);

    

        this.divPreguntas=document.getElementById("divListado");
        this.divPreguntas=new VistaPreguntas(this,this.divPreguntas)

        console.log(this.divListado)
        console.log(this.divCategorias)
        console.log(this.divPreguntas)

        this.divListado.mostrar(false)
        this.divCategorias.mostrar(false)
        this.divPreguntas.mostrar(false)

        //ASIGNACIÓN DE EVENTOS A LOS BOTONES DEL NAV
        this.liListado=document.getElementById('liListado')
        this.liListado.onclick=this.mostrarVistaListado.bind(this)

        this.liCategorias=document.getElementById('liCategorias')
        this.liCategorias.onclick=this.mostrarVistaCategorias.bind(this);

        this.liPreguntas=document.getElementById('liPreguntas')
        this.liPreguntas.onclick=this.mostrarVistaPreguntas.bind(this);
    }
    /**
     * Método para la visualización de la vista listado
     */
    mostrarVistaListado(){
        console.log("CAMBIANDO VISTA A LISTADO")
        this.divListado.mostrar(true)
        this.divCategorias.mostrar(false)
        this.divPreguntas.mostrar(false)
    }
    /**
     * Método para la visualización de la vista categorias
     */
    mostrarVistaCategorias(){
        console.log("CAMBIANDO VISTA A CATEGORIAS")
        console.log("VISTA CRUD CATEGORIAS: ",this.divCrudCategorias)
        console.log("VISTA CRUD SUBCATEGORIAS: ",this.divCrudSubCategorias)
       // this.modelo.avisar()
        this.divListado.mostrar(false)
        this.divCategorias.mostrar(true)
        this.divPreguntas.mostrar(false)
    }
    /**
     * Método para mostrar la vistaCrudCategorias o vistaCrudSubcategoría a través de ajax
     */
    mostrarCatOsub(valor){
        console.log("MONTANDO VISTA",valor)
        if(valor==1){
            this.divCrudSubCategorias.mostrar(true)
            this.divCrudCategorias.mostrar(false)
        }else{
            this.divCrudCategorias.mostrar(true)
            this.divCrudSubCategorias.mostrar(false)
        }
    }
    /**
     * Método para la visualización de la vista preguntas
     */
    mostrarVistaPreguntas(){
        console.log("CAMBIANDO VISTA A PREGUNTAS")
        this.divListado.mostrar(false)
        this.divCategorias.mostrar(false)
        this.divPreguntas.mostrar(true)
    }

}
const app=new ControladorAdmin();