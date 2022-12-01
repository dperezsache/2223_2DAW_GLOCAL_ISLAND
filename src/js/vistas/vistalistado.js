

import { Vista } from "./vista.js";

/**
 * Clase para la gestión de la vistaListado
 */
export class VistaListado extends Vista{
    /**
     * Contructor para el instaciamiento de objetos de la clase vistaListado
     * @param {Controlador} controlador 
     * @param {HTMLElement} div 
     */
    constructor(controlador,div){
        super(div);
        this.controlador=controlador;
        
    }
}