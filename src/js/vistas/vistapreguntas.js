
import { Vista } from "./vista.js";
/**
 * Clase para la gestión de la vistaPreguntas
 */
export class VistaPreguntas extends Vista{
    /**
     * Constructor para el instanciamiento de objetos de la clase VistaPreguntas
     * @param {Controlador} controlador 
     * @param {HTMLElement} div 
     */
    constructor(controlador,div){
        super(div);
        this.controlador=controlador;
        
    }
}