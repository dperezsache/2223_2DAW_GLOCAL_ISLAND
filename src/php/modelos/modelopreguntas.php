<?php
require_once('../config/conexion.php');
/**
     * Clase para la gestión de ModeloPreguntas desde servidor
     */
class ModeloPreguntas{
    /**
         * Constructor para el instanciamiento de objetos de tipo ModeloPreguntas
         */
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

    public function insertarPreguntayRespuesta($preguntaYrespuesta){
        $this->conectar();
        $sw=0;
        $consulta=$this->conexion->prepare('INSERT INTO Preguntas(idSubcategoria,pregunta,imagen) VALUES(?,?,?)');
        
        $idSubCat=$preguntaYrespuesta['subcategoria'];
        $pregunta=$preguntaYrespuesta['pregunta'];
        if(!empty($preguntaYrespuesta['imagenPregunta'])){
            $imagen=$preguntaYrespuesta['imagenPregunta'];
        }else{
            $imagen='NULL';
        }

        $respuesta1=$preguntaYrespuesta['respuesta1'];
        $respuesta2=$preguntaYrespuesta['respuesta2'];
        $correcta=0;
        
        $consulta->bind_Param('sss',$idSubCat,$pregunta,$imagen);
        $arrayIndices=array_keys($preguntaYrespuesta);
       for($i=0;$i<sizeof($arrayIndices);$i++){
            if($arrayIndices[$i]=="respuesta1"){
                if($arrayIndices[$i+1]=="btnCorrecta"){
                    $correcta=1;
                    $sw=1;
                }else{
                    $correcta=0;
                    $sw=0;
                }
            }
       }
       $consulta->execute();
        //Con esto obtenemos el ultimo id insertado tras la consulta para poder hacer la siguiente insercción de las respuestas asociadas a pregunta
        $ultimoID=$this->conexion->insert_id;
        $this->conexion->close();
        //INSERCCIÓN DE LAS RESPUESTAS
        $this->conectar();
        $consulta=$this->conexion->prepare('INSERT INTO Respuestas(idSubcategoria,numPregunta,respuesta,correcta) VALUES(?,?,?,?)');
        $consulta->bind_Param('sssi',$idSubCat,$ultimoID,$respuesta1,$correcta);
        $consulta->execute();
        if($sw==1){
            $correcta=0;
        }else{
            $correcta=1;
        }
        $consulta->bind_Param('sssi',$idSubCat,$ultimoID,$respuesta2,$correcta);
        $consulta->execute();
        $this->conexion->close();
        header('Location:../cruds_categorias/index.php');
    }

    public function obtenerSubcategorias(){
        $this->conectar();
        $consulta="SELEC id,nombre FROM Subcategorias";
        $respuesta=$this->conexion->query($consulta);
        return $respuesta;

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
        $consultaAntique = 'SELECT imagen FROM Preguntas
        WHERE idSubcategoria="'.$datos['categoriaPregunta'].' AND numPregunta='.$datos['numPregunta'].'"';

        $nombres=$this->conexion->query($consultaAntique);
        while($fila = $nombres->fetch_array()){
            $imagenAntigua = $fila['imagen'];
        }

        $nom_archivo = $_FILES['imagenPregunta']['name'];

        $ruta = "../../img/subidas_bbdd/".$nom_archivo;

        $archivo=$_FILES['imagenPregunta']['tmp_name'];
        $subir=move_uploaded_file($archivo,$ruta);
        echo $imagenAntigua;
        unlink(realpath("../../img/subidas_bbdd/".$imagenAntigua));

        if(isset($datos['imagenPregunta'])){
            $consultaPregunta= "UPDATE Preguntas SET pregunta='".$datos['nuevaPregunta']."', imagen='".$nom_archivo."' WHERE Preguntas.idSubcategoria=".$datos['categoriaPregunta']." AND Preguntas.numPregunta=".$datos['numPregunta'].";";
        }
        else{
            $consultaPregunta= "UPDATE Preguntas SET pregunta='".$datos['nuevaPregunta']."' WHERE Preguntas.idSubcategoria=".$datos['categoriaPregunta']." AND Preguntas.numPregunta=".$datos['numPregunta'].";";
        }
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

    /**
     * 
     */
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

    public function sacarListadoSubcategorias(){
        $this->conectar();
        $consultaSub= "SELECT S.nombre, S.id FROM Subcategorias S;";
        $id=$this->conexion->query($consultaSub);
        return $id;
        $this->conexion->close();
    }
}

?>