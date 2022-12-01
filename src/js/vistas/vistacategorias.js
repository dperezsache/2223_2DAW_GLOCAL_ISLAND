
import { Vista } from "./vista.js";
/**
 * Clase para la gestión de las vistasCategorias
 */
export class VistaCategorias extends Vista{
    /**
     * Contructor para el instanciamiento de la clase VistaCategorias
     * @param {Controlador} controlador 
     * @param {HTMLElement} div 
     */
    constructor(controlador,div){
        super(div);
        this.controlador=controlador;
        
    }
}