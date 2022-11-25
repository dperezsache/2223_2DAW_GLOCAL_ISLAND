"use script" //activo modo estricto
import {Vista} from './vista.js'
/**
 * Clase vistaLogin con métodos y atributos
*/
export class VistaLogin extends Vista{
	/**
	 * Contructor de la clase vistaLogin
	 * @param {Objeto} divinicio 
	 */
	constructor(divinicio, controlador){
		super(divinicio)
		this.controlador=controlador
		this.btnAceptar=document.getElementsByTagName('button')[0]
		this.btnAceptar.onclick=this.comprobarUser.bind(this)
	}
	
	comprobarUser(){
		let contenedor=document.getElementById('divInicioSesion')
		let admin=document.getElementsByTagName('input')[0].value
		let contra=document.getElementsByTagName('input')[1].value
		let exre=/^[A-Z]{1}([A-Za-z]{0,10}|[0-9]{0,10})*$/
		if(admin==''||contra==''){
			alert('Inserta todos los datos.')
		}
		else if(admin.match(exre)!=null && contra.match(exre)!=null){
			alert('Válido. Entrando')
		}
		else{
			alert('No válido. User y clave ej: Ejemplo1')
		}
	}
}