

import { Vista } from "./vista.js";
/**
 * Clase VistaJuego que muestra el juego
 * Gestiona los elementos y métodos de esta Vista
 */
export class VistaCrudCategorias extends Vista{
    /**
     * Constructor parametrizado para la instancia de la vista de creud categorias
     * @param {object} controlador 
     * @param {HTMLDivElement} div 
     */
    constructor(controlador,div){
        super(div)
        this.controlador=controlador
        this.botonEnviar=document.getElementById("botonEnviarCategoria");
        this.botonEnviar.onclick=this.enviarCategoria.bind(this)
    }
    enviarCategoria(){
       event.preventDefault();
        console.log("EEEL EVEEEENTO CARIIIIÑO",event)
        let formulario=document.getElementById("formNuevaCategoria")
        try{
            this.validarCategoria()
            formulario.submit()
        }catch(excepcion){
            console.log(excepcion)
            window.alert('Error al introducir datos: '+excepcion)
        }
    }
    validarCategoria(){
        const expresion=new RegExp('^[A-Z][a-z]{1,48}[^0-9]');

        let nombreCategoria=document.getElementById("nuevaCategoria").value
        let icono=document.getElementById("icono").value
        let subCategoria1=document.getElementById("subcategoria1").value;
        let subCategoria2=document.getElementById("subcategoria2").value;
        let subCategoria3=document.getElementById("subcategoria3").value;

        if(nombreCategoria=='' || icono==''|| subCategoria1=='' || subCategoria2=='' || subCategoria3=='')
            throw 'Alguno de los campos no está relleno, por favor complete el formulario.'
            
        if(!nombreCategoria.match(expresion))
            throw 'Nombre de la nueva categoria mal introducida, debe contener una mayúscula al inicio y ningun numero o caracter especial, máximo 50 caracteres';
    
        if(!subCategoria1.match(expresion) || !subCategoria2.match(expresion) || !subCategoria3.match(expresion))
            throw 'Nombre de la nueva categoria mal introducida, debe contener una mayúscula al inicio y ningun numero o caracter especial, máximo 50 caracteres';
        
        if(subCategoria1==subCategoria2)
            throw 'Nombre de dos subcategorias iguales, introduce otra distinta.'

        if(subCategoria1==subCategoria3)
            throw 'Nombre de dos subcategorias iguales, introduce otra distinta.'
        
        if(subCategoria2==subCategoria3)
            throw 'Nombre de dos subcategorias iguales, introduce otra distinta.'
    }
}