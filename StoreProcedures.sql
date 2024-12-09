DELIMITER //
 CREATE DEFINER=`root`@`localhost` PROCEDURE `SpUsuario`(
     IN p_id_usuario INT,
     IN p_nombre_usuario VARCHAR(100),
     IN p_nombre VARCHAR(100),
     IN p_apellido_P VARCHAR(100),
     IN p_apellido_M VARCHAR(100),
     IN p_genero ENUM('Masculino', 'Femenino', 'Otro',''),
     IN p_fecha_nacimiento DATE,
     IN p_avatar mediumblob,
     IN p_email VARCHAR(100),
     IN p_contrasena VARCHAR(255),
     IN p_tipo ENUM('Instructor','Estudiante', 'Administrador', 'Superadministrador',''),
     IN p_estado ENUM('Activo', 'Inactivo',''),
     IN p_operacion VARCHAR(20)
 )
 BEGIN
     IF p_operacion = 'INSERT' THEN
         INSERT INTO Usuario (nombre_Usuario, nombre, apellido_P, apellido_M, genero, fecha_Nacimiento, avatar, email, contrasena, tipo, estado)
         VALUES (p_nombre_usuario, p_nombre, p_apellido_P, p_apellido_M, p_genero, p_fecha_nacimiento, p_avatar, p_email, p_contrasena, p_tipo, p_estado);
     ELSEIF p_operacion = 'UPDATE' THEN
         UPDATE Usuario
         SET nombre_usuario = p_nombre_usuario,
             nombre = p_nombre,
             apellido_P = p_apellido_P,
             apellido_M = p_apellido_M,
             genero = p_genero,
             fecha_nacimiento = p_fecha_nacimiento,
             email = p_email,
             contrasena = p_contrasena
         WHERE id_usuario = p_id_usuario;
	ELSEIF p_operacion = 'UPDATE_PHOTO' THEN
         UPDATE Usuario
         SET avatar = p_avatar
         WHERE id_usuario = p_id_usuario;
     ELSEIF p_operacion = 'DELETE' THEN
         DELETE FROM Usuario
         WHERE id_usuario = p_id_usuario;
     ELSEIF p_operacion = 'SELECT' THEN
         SELECT id_usuario, nombre_usuario, nombre, apellido_P, apellido_M, genero, fecha_nacimiento, avatar, email, contrasena, fecha_registro, tipo, estado
         FROM Usuario
         WHERE id_usuario = p_id_usuario;
     END IF;
 END
 //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE spInicioSesion(
   IN p_email VARCHAR(100),
   IN p_contrasena VARCHAR(255),
   OUT p_id_usuario INT,
   OUT p_nombre_usuario_res VARCHAR(100),
   OUT p_tipo VARCHAR(50),
   OUT p_mensaje VARCHAR(100)
 )
 BEGIN
   DECLARE v_id_usuario INT;
   DECLARE v_nombre_usuario VARCHAR(100);
   DECLARE v_tipo VARCHAR(50);

   -- Verificar si el nombre de usuario y la contraseña son válidos
   SELECT id_usuario, nombre_usuario, tipo INTO v_id_usuario, v_nombre_usuario, v_tipo
   FROM Usuario
   WHERE email = p_email AND contrasena = p_contrasena AND estado = 'Activo';

   -- Verificar si se encontró un usuario con las credenciales proporcionadas
   IF v_id_usuario IS NOT NULL THEN
     SET p_id_usuario = v_id_usuario;
     SET p_nombre_usuario_res = v_nombre_usuario;
     SET p_tipo = v_tipo;
     SET p_mensaje = 'Inicio de sesión exitoso';
   ELSE
     SET p_id_usuario = NULL;
     SET p_nombre_usuario_res = NULL;
     SET p_tipo = NULL;
     SET p_mensaje = 'Usuario o contraseña incorrectos';
   END IF;
 END 
 //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE SpUsuarioUpdate (
    IN p_id_usuario INT,
    IN p_nombre_usuario VARCHAR(100),
    IN p_genero ENUM('Masculino', 'Femenino', 'Otro',''),
    IN p_fecha_nacimiento DATE,
    IN p_password VARCHAR(255)
)
BEGIN
    -- Actualiza los campos del usuario basados en el ID
    UPDATE usuarios
    SET 
        nombre_usuario = p_nombre_usuario,
        genero = p_genero,
        fecha_nacimiento = p_fecha_nacimiento,
        password = p_password
    WHERE id_usuario = p_id_usuario;

    IF ROW_COUNT() > 0 THEN
        SELECT 'Actualización exitosa' AS mensaje;
    ELSE
        SELECT 'No se actualizó ningún dato' AS mensaje;
    END IF;
END
//
DELIMITER ;

DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpCurso`(
    IN p_id INT,
    IN p_titulo VARCHAR(255),
    IN p_descripcion TEXT,
    IN p_imagen MEDIUMBLOB,
    IN p_costo DECIMAL(10, 2),
    IN p_curso_completo CHAR(1),
    IN p_estado CHAR(1),
    IN p_categoria_id INT,
    IN p_instructor_id INT,
    IN p_fecha_inicio DATE, 
    IN p_fecha_fin DATE,    
    IN p_operacion VARCHAR(20)
)
BEGIN
    IF p_operacion = 'INSERT' THEN
        INSERT INTO Curso (titulo, descripcion, imagen, costo, curso_completo, estado, categoria_id, instructor_id)
        VALUES (p_titulo, p_descripcion, p_imagen, p_costo, p_curso_completo, p_estado, p_categoria_id, p_instructor_id);
    ELSEIF p_operacion = 'UPDATE' THEN
        UPDATE Curso
        SET titulo = p_titulo,
            descripcion = p_descripcion,
            imagen = p_imagen,
            costo = p_costo,
            curso_completo = p_curso_completo,
            estado = p_estado,
            categoria_id = p_categoria_id,
            instructor_id = p_instructor_id
        WHERE id = p_id;
    ELSEIF p_operacion = 'DELETE' THEN
        DELETE FROM Curso
        WHERE id = p_id;
    ELSEIF p_operacion = 'SELECT_BY_ID' THEN
        SELECT * FROM Curso
        WHERE id = p_id;
    ELSEIF p_operacion = 'SELECT_ALL' THEN
        SELECT * FROM Curso;
    ELSEIF p_operacion = 'SELECT_BY_CATEGORY' THEN
        SELECT Curso.*
        FROM Curso
        INNER JOIN CursoCategoria ON Curso.id = CursoCategoria.curso_id
        WHERE CursoCategoria.categoria_id = p_categoria_id;
    ELSEIF p_operacion = 'SELECT_BY_NAME' THEN
        SELECT * FROM Curso
        WHERE titulo LIKE CONCAT('%', p_titulo, '%'); 
    ELSEIF p_operacion = 'SELECT_BY_DATE' THEN
        SELECT * FROM Curso
        WHERE fecha_creacion BETWEEN p_fecha_inicio AND p_fecha_fin; 
    END IF;
END;
//
DELIMITER ;



DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `SpCategoria`(
    IN p_id_categoria INT,
    IN p_nombre_categoria VARCHAR(100),
    IN p_descripcion TEXT,
    IN p_id_usuario INT,
    IN p_operacion VARCHAR(20)
)
BEGIN
    IF p_operacion = 'INSERT' THEN
        INSERT INTO Categoria (NombreCategoria, Descripcion, IDUsuario)
        VALUES (p_nombre_categoria, p_descripcion, p_id_usuario);
        
    ELSEIF p_operacion = 'UPDATE' THEN
        UPDATE Categoria
        SET NombreCategoria = p_nombre_categoria,
            Descripcion = p_descripcion,
            IDUsuario = p_id_usuario
        WHERE id_categoria = p_id_categoria;
        
    ELSEIF p_operacion = 'DELETE' THEN
        DELETE FROM Categoria
        WHERE id_categoria = p_id_categoria;
        
    ELSEIF p_operacion = 'SELECT_BY_ID' THEN
        SELECT * FROM Categoria
        WHERE id_categoria = p_id_categoria;
        
    ELSEIF p_operacion = 'SELECT_ALL' THEN
        SELECT * FROM Categoria;
    END IF;
END;
//
DELIMITER ;
