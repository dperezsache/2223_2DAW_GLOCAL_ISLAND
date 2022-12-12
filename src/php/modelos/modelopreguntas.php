<?php
require_once('../config/conexion.php');
class ModeloPreguntas{
    function __construct(){
        $this->servidor = constant('SERVIDOR');
        $this->usuario = constant('USUARIO');
        $this->contrasenia = constant('CONTRASENIA');
        $this->bd = constant('BD');
    }

    /**
     * Iniciar conexión con la base de datos.
     */
    private function conectar()
    {     
        $this->conexion = new mysqli($this->servidor,  $this->usuario,  $this->contrasenia, $this->bd);
    }

    /**
     * Método para sacar las preguntas del listado
     */
    public function consultarPreguntas(){
        $this->conectar();
        $consultaPreguntas = "SELECT pregunta,respuesta, Preguntas.numPregunta, Subcategorias.nombre, Subcategorias.id AS sub, Categorias.id, Preguntas.idSubcategoria, correcta, numRespuesta,Categorias.nombre AS 'Cat'
        FROM Preguntas 
        INNER JOIN Subcategorias ON(Preguntas.idSubcategoria=Subcategorias.id)
        INNER JOIN Categorias ON(Subcategorias.idCategoria=Categorias.id)
        INNER JOIN Respuestas ON(Respuestas.numPregunta=Preguntas.numPregunta AND Respuestas.idSubcategoria=Preguntas.idSubcategoria)
        WHERE Respuestas.numRespuesta=1";

        $preguntas= $this->conexion->query($consultaPreguntas);
        return $preguntas;
        $this->conexion->close();
    }

    /**
     * Método para sacar la segunda respuesta
     */
    public function consultarPreguntas2($numPregunta, $idSubcategoria){
        $this->conectar();
        $consultaRespuesta= "SELECT pregunta,respuesta, S.id, Respuestas.numPregunta, numRespuesta FROM Preguntas 
            INNER JOIN Subcategorias S ON(Preguntas.idSubcategoria=S.id)
            INNER JOIN Categorias ON(S.idCategoria=Categorias.id)
            INNER JOIN Respuestas ON(Respuestas.numPregunta=Preguntas.numPregunta AND Respuestas.idSubcategoria=Preguntas.idSubcategoria)
            WHERE Respuestas.numRespuesta=2 AND Preguntas.numPregunta='".$numPregunta."' AND Preguntas.idSubcategoria='".$idSubcategoria."';";
        $respuesta=$this->conexion->query($consultaRespuesta);
        return $respuesta;
        $this->conexion->close();
    }

    public function modificarPreguntayRespuesta($datos){
        print_r ($datos);
        $this->conectar();
        $arrayIndices=array_keys($datos);
        for($i=0;$i<sizeof($arrayIndices);$i++){
            if($arrayIndices[$i]=="primeraRespuesta"){
                if($arrayIndices[$i+1]=="btnCorrecta"){
                    $correcta=1;
                    $sw=1;
                }else{
                    $correcta=0;
                    $sw=0;
                }
            }
        }
        $consultaPregunta= "UPDATE Preguntas SET pregunta='".$datos['nuevaPregunta']."' WHERE Preguntas.idSubcategoria=".$datos['categoriaPregunta']." AND Preguntas.numPregunta=".$datos['numPregunta'].";";
        $pregunta=$this->conexion->query($consultaPregunta);
        if($sw==1){     //si la respuesta correcta es la primera
            $consultaRespuesta= "UPDATE Respuestas SET respuesta='".$datos['primeraRespuesta']."', correcta=1 WHERE idSubcategoria=".$datos['categoriaPregunta']." AND numPregunta=".$datos['numPregunta']." AND Respuestas.numRespuesta=1;";
            $respuesta=$this->conexion->query($consultaRespuesta);
            $consultaRespuesta2= "UPDATE Respuestas SET respuesta='".$datos['segundaRespuesta']."', correcta=0 WHERE idSubcategoria=".$datos['categoriaPregunta']." AND numPregunta=".$datos['numPregunta']." AND Respuestas.numRespuesta=2;";
            $respuesta2=$this->conexion->query($consultaRespuesta2);
        }
        else{
            $consultaRespuesta= "UPDATE Respuestas SET respuesta='".$datos['primeraRespuesta']."', correcta=0 WHERE idSubcategoria=".$datos['categoriaPregunta']." AND numPregunta=".$datos['numPregunta']." AND Respuestas.numRespuesta=1;";
            $respuesta=$this->conexion->query($consultaRespuesta);
            $consultaRespuesta2= "UPDATE Respuestas SET respuesta='".$datos['segundaRespuesta']."', correcta=1 WHERE idSubcategoria=".$datos['categoriaPregunta']." AND numPregunta=".$datos['numPregunta']." AND Respuestas.numRespuesta=2;";
            $respuesta2=$this->conexion->query($consultaRespuesta2);
        }
       
        $this->conexion->close();
        header('location:../../cruds_categorias/index.php');
    }

    public function sacarSubcategoria($id){
        $this->conectar();
        $consultaSub= "SELECT S.nombre FROM Subcategorias S WHERE S.id=".$id.";";
        $id=$this->conexion->query($consultaSub);
        return $id;
        $this->conexion->close();
    }

    public function eliminarPreguntayRespuesta($datos){
        $this->conectar();
        $consultaEliminar= "DELETE FROM P, R USING Preguntas P, Respuestas R WHERE P.idSubcategoria=".$datos['idSubcategoria']." AND P.numPregunta=".$datos['numPregunta']." AND R.idSubcategoria=".$datos['idSubcategoria']." AND R.numPregunta=".$datos['numPregunta'].";";
        $resultado=$this->conexion->query($consultaEliminar);
        if($resultado>0){
            header('location:../../cruds_categorias/index.php');
        }
        else{
            header('ERROR 404 INTERNAL ERROR.');
        }
        $this->conexion->close();
    }
}

?>