
import { Vista } from "./vista.js";
/**
 * Clase para la gestión de la vistaCrudSubcategoria
 */
export class VistaCrudSubCategorias extends Vista{
    /**
     * Constructor para el intanciamiento de objetos de la clase VistaCrudSubcategorias
     * @param {Controlador} controlador 
     * @param {HTMLElement} div 
     */
    constructor(controlador,div){
        super(div)
        this.controlador=controlador
    }
}