-- Script creación de BBDD y tablas de Glocal Island
CREATE DATABASE GlocalIsland;
USE GlocalIsland;

CREATE TABLE Administrador(
    nombre VARCHAR(60) NOT NULL,
    clave VARCHAR(255) NOT NULL,
    perfil CHAR(2) NOT NULL CHECK(perfil='GI' OR perfil='LP' OR perfil='AC' OR perfil='DM')
);

CREATE TABLE Categorias(
    id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    icono VARCHAR(30) NOT NULL,
    CONSTRAINT PK_idCategoria PRIMARY KEY(id),
    CONSTRAINT UQ_nombreCategoria UNIQUE(nombre)
);

CREATE TABLE Subcategorias(
    idCategoria TINYINT UNSIGNED,
    id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    CONSTRAINT UQ_id UNIQUE(id),
    CONSTRAINT FK_Subcategorias_idCategoria FOREIGN KEY(idCategoria) REFERENCES Categorias(id),
    CONSTRAINT PK_idSubCategoria PRIMARY KEY(idCategoria, numSub),
    CONSTRAINT UQ_nombreSubcategoria UNIQUE(nombre)
);

CREATE TABLE Preguntas(
    numPregunta TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    pregunta VARCHAR(300) NOT NULL,
    imagen VARCHAR(30),
    idSubcategoria TINYINT UNSIGNED NOT NULL,
    CONSTRAINT FK_Preguntas_idCategoria FOREIGN KEY(idSubcategoria) REFERENCES Subcategorias(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT PK_Preguntas PRIMARY KEY(idSubcategoria,id),
    CONSTRAINT UQ_pregunta UNIQUE(pregunta)
    
);

CREATE TABLE Respuestas(
    idSubcategoria TINYINT UNSIGNED NOT NULL,
    numPregunta TINYINT UNSIGNED NOT NULL,
    numRespuesta TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    respuesta VARCHAR(300) NOT NULL,
    correcta BIT NOT NULL,
    CONSTRAINT UQ_numRespuesta UNIQUE(numRespuesta),
    CONSTRAINT FK_Respuestas_numPregunta FOREIGN KEY(idPregunta) REFERENCES Preguntas(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT FK_Respuestas_idSubcategoria FOREIGN KEY(idSubcategoria) REFERENCES Subcategorias(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT PK_Respuesta PRIMARY KEY(idSubcategoria,numPregunta, numRespuesta)
);

CREATE TABLE Clasificacion(
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    alias VARCHAR(30) NOT NULL,
    puntuacion TINYINT UNSIGNED NOT NULL CHECK(puntuacion >= 0),
    fechaHora TIMESTAMP NOT NULL,
    CONSTRAINT PK_idClasificacion PRIMARY KEY(id)
);

CREATE TABLE Reflexiones(
    id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    texto VARCHAR(1000) NOT NULL,
    numPreguntas TINYINT UNSIGNED NOT NULL,
    idCategoria TINYINT not null,
    CONSTRAINT PK_idReflexiones PRIMARY KEY(id),
    CONSTRAINT FK_idCategoria_Categorias FOREIGN KEY(idCategoria) REFERENCES Categorias(id)
);