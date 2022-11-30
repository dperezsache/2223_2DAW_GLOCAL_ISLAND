

import { Vista } from "./vista.js";

export class VistaListado extends Vista{
    constructor(controlador,div){
        super(div);
        this.controlador=controlador;
        
    }
}