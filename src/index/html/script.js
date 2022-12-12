function obtenercosa(){
    //console.log("HOLAAAAMIARMAAAA");
    let contadorErrores={
        "Agua":2,
        "Aire":1,
        "Tierra":3
    }
    let datos = {
        'agua' : contadorErrores["Agua"],
        'aire' : contadorErrores["Aire"],
        'tierra' : contadorErrores["Tierra"]
    }
    let opciones = {
        method: 'POST',
        body: JSON.stringify(datos),
        headers:{ 'Content-Type': 'application/json'}
    }

 fetch("../../php/index.php/obtenerreflexiones",opciones)
    .then(respuesta=>respuesta.json())
    .then(datos=>mostrar(datos));
}
function mostrar(datos){
    console.log("LOS DATOS",datos)
}