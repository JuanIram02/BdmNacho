CREATE DATABASE IF NOT EXISTS cursO;
USE cursO;

CREATE TABLE IF NOT EXISTS Usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificación numérica del usuario',
    email VARCHAR(255) UNIQUE COMMENT 'Correo del usuario',
    nombre_usuario VARCHAR(50) UNIQUE COMMENT 'Nombre de usuario del usuario',
    contrasena VARCHAR(255) COMMENT 'Contraseña del usuario',
    tipo ENUM('Instructor', 'Estudiante', 'Administrador', 'Superadministrador') COMMENT 'Rol del usuario',
    avatar MEDIUMBLOB COMMENT 'Imagen del usuario',
    nombre VARCHAR(100) COMMENT 'Nombre del usuario',
    apellido_P VARCHAR(100) COMMENT 'Apellido paterno del usuario',
    apellido_M VARCHAR(100) COMMENT 'Apellido materno del usuario',
    fecha_Nacimiento DATE COMMENT 'Fecha de nacimiento',
    genero ENUM('Masculino', 'Femenino') COMMENT 'Género del usuario',
    fecha_Registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro',
    estado ENUM('Activo', 'Inactivo') COMMENT 'Estado del usuario (Activo/Inactivo)'
);
select * from Usuario;
INSERT INTO Usuario (nombre_usuario, nombre, apellido_P, apellido_M, genero, fecha_Nacimiento, avatar, email, contrasena, tipo, estado)
         VALUES ("Admin", "Admin", "Admin", "Admin", "Masculino", "2002-09-16", null, "admin@gmail.com", "Contraseña123@", "Administrador", "Activo");
         
CREATE TABLE IF NOT EXISTS Categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Clave de identificación de la categoría',
    NombreCategoria VARCHAR(100) COMMENT 'Nombre de la categoría',
    Descripcion TEXT COMMENT 'Descripción de la categoría',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación',
    IDUsuario INT COMMENT 'Identificación del usuario que creó la categoría',
    FOREIGN KEY (IDUsuario) REFERENCES Usuario(id_usuario) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Curso (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificación del curso',
    titulo VARCHAR(255) NOT NULL COMMENT 'Título del curso',
    descripcion TEXT COMMENT 'Descripción del curso',
    imagen MEDIUMBLOB COMMENT 'Imagen del curso',
    costo DECIMAL(10, 2) NOT NULL COMMENT 'Costo del curso',
    curso_completo CHAR(1) DEFAULT 'C' COMMENT 'Indica si el curso está completo',
    estado CHAR(1) DEFAULT 'A' COMMENT 'Estado del curso (A: Activo, I: Inactivo)',
    categoria_id INT NOT NULL COMMENT 'ID de la categoría del curso',
    instructor_id INT NOT NULL COMMENT 'ID del instructor del curso',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del curso',
    alumnos INT DEFAULT 0 COMMENT 'Número de alumnos inscritos en el curso',
    
    FOREIGN KEY (categoria_id) REFERENCES Categoria(id_categoria) ON DELETE CASCADE,
    FOREIGN KEY (instructor_id) REFERENCES Usuario(id_usuario) ON DELETE CASCADE
);

INSERT INTO INSERT INTO `categoria` (`NombreCategoria`, `Descripcion`, `fecha_creacion`, `IDUsuario`) 
    VALUES ( "root", "root", current_timestamp(), 1);

CREATE TABLE IF NOT EXISTS CursoCategoria (
    curso_id INT NOT NULL COMMENT 'ID del curso',
    categoria_id INT NOT NULL COMMENT 'ID de la categoría',
    
    PRIMARY KEY (curso_id, categoria_id),
    FOREIGN KEY (curso_id) REFERENCES Curso(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES Categoria(id_categoria) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Nivel (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificación del nivel',
    curso_id INT NOT NULL COMMENT 'ID del curso relacionado',
    nivel INT NOT NULL COMMENT 'Número del nivel',
    descripcion TEXT COMMENT 'Descripción del nivel',
    precio DECIMAL(10, 2) NOT NULL DEFAULT 0 COMMENT 'Precio del nivel',
    
    FOREIGN KEY (curso_id) REFERENCES Curso(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS NivelVideo (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificación del video',
    nivel_id INT NOT NULL COMMENT 'ID del nivel relacionado',
    url_video VARCHAR(255) NOT NULL COMMENT 'URL del video',
    descripcion TEXT COMMENT 'Descripción del video',
    duracion TIME COMMENT 'Duración del video',
    
    FOREIGN KEY (nivel_id) REFERENCES Nivel(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Inscripcion (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificación de la inscripción',
    curso_id INT NOT NULL COMMENT 'ID del curso',
    estudiante_id INT NOT NULL COMMENT 'ID del estudiante',
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de inscripción',
    fecha_ultima TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de la última actividad',
    fecha_terminacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de finalización',
    progreso_curso INT DEFAULT 0 COMMENT 'Progreso del curso en porcentaje',
    estado CHAR(1) DEFAULT 'P' COMMENT 'Estado de la inscripción (P: Pendiente, C: Completada)',
    precio_pagado DECIMAL(10, 2) COMMENT 'Monto pagado por la inscripción',
    
    FOREIGN KEY (curso_id) REFERENCES Curso(id) ON DELETE CASCADE,
    FOREIGN KEY (estudiante_id) REFERENCES Usuario(id_usuario) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Certificado (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificación del certificado',
    estudiante_id INT NOT NULL COMMENT 'ID del estudiante',
    curso_id INT NOT NULL COMMENT 'ID del curso',
    fecha_emision DATE NOT NULL COMMENT 'Fecha de emisión del certificado',
    nombre_estudiante VARCHAR(100) NOT NULL COMMENT 'Nombre del estudiante',
    nombre_curso VARCHAR(255) NOT NULL COMMENT 'Nombre del curso',
    nombre_instructor VARCHAR(100) NOT NULL COMMENT 'Nombre del instructor',
    
    FOREIGN KEY (estudiante_id) REFERENCES Usuario(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES Curso(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Mensaje (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificación del mensaje',
    remitente_id INT NOT NULL COMMENT 'ID del remitente',
    destinatario_id INT DEFAULT NULL COMMENT 'ID del destinatario',
    curso_id INT NOT NULL COMMENT 'ID del curso',
    contenido TEXT NOT NULL COMMENT 'Contenido del mensaje',
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de envío',
    estado INT DEFAULT 1 COMMENT 'Estado del mensaje (1: Enviado, 0: Leído)',
    
    FOREIGN KEY (remitente_id) REFERENCES Usuario(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (destinatario_id) REFERENCES Usuario(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES Curso(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Comentario (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificación del comentario',
    curso_id INT NOT NULL COMMENT 'ID del curso',
    usuario_id INT NOT NULL COMMENT 'ID del usuario',
    contenido TEXT NOT NULL COMMENT 'Contenido del comentario',
    calificacion INT COMMENT 'Calificación del curso',
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha del comentario',
    estado INT DEFAULT 1 COMMENT 'Estado del comentario (1: Activo, 0: Inactivo)',
    
    FOREIGN KEY (curso_id) REFERENCES Curso(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Pago (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificación del pago',
    curso_id INT NOT NULL COMMENT 'ID del curso',
    estudiante_id INT NOT NULL COMMENT 'ID del estudiante',
    monto DECIMAL(10, 2) NOT NULL COMMENT 'Monto del pago',
    forma_pago CHAR(1) NOT NULL COMMENT 'Forma de pago',
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha del pago',
    
    FOREIGN KEY (curso_id) REFERENCES Curso(id) ON DELETE CASCADE,
    FOREIGN KEY (estudiante_id) REFERENCES Usuario(id_usuario) ON DELETE CASCADE
);

SELECT 
    TABLE_NAME,        -- Nombre de la tabla
    COLUMN_NAME,       -- Nombre de la columna
    DATA_TYPE,         -- Tipo de dato
    CHARACTER_MAXIMUM_LENGTH AS max_length,  -- Longitud máxima (solo para tipos de texto)
    IS_NULLABLE,       -- Si permite valores nulos
    COLUMN_DEFAULT,    -- Valor por defecto
    COLUMN_KEY,        -- Si es clave primaria o única
    EXTRA              -- Información adicional
    COLUMN_COMMENT   -- Descripción de la columna
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'curso'
ORDER BY TABLE_NAME, ORDINAL_POSITION;
