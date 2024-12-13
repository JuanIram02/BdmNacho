DELIMITER //

CREATE OR REPLACE VIEW vwInscripciones_Cursos AS
SELECT 
    i.id AS inscripcion_id,
    i.curso_id,
    c.titulo,
    c.descripcion,
    c.costo AS costo_curso,
    i.estudiante_id,
    i.fecha_inscripcion,
    i.fecha_ultima,
    i.fecha_terminacion,
    i.progreso_curso,
    i.estado AS estado_inscripcion,
    i.precio_pagado,
    c.imagen,
    c.instructor_id,
    c.curso_completo,
    c.estado AS estado_curso
FROM 
    Inscripcion i
INNER JOIN 
    Curso c
ON 
    i.curso_id = c.id;
//

DELIMITER ;

DELIMITER //

CREATE OR REPLACE VIEW vwKardex AS
SELECT 
    p.id AS pago_id,
    p.curso_id,
    cc.categoria_id,
    p.estudiante_id,
    p.monto AS monto_pago,
    p.forma_pago,
    p.fecha AS fecha_pago,
    i.id AS inscripcion_id,
    c.titulo AS titulo_curso,
    c.descripcion AS descripcion_curso,
    c.estado AS estado_curso,
    i.fecha_inscripcion,
    i.fecha_ultima,
    i.fecha_terminacion,
    i.progreso_curso,
    i.estado AS estado_inscripcion,
    i.precio_pagado
FROM 
    Pago p
INNER JOIN 
    Inscripcion i ON p.curso_id = i.curso_id AND p.estudiante_id = i.estudiante_id
INNER JOIN 
    Curso c ON p.curso_id = c.id
LEFT JOIN 
    CursoCategoria cc ON c.id = cc.curso_id;
//

DELIMITER ;

DELIMITER //

CREATE OR REPLACE VIEW vwReporteVentas AS
SELECT 
    c.titulo AS nombre_curso,
    COUNT(i.estudiante_id) AS alumnos_inscritos,            
    AVG(i.progreso_curso) AS nivel_promedio_cursado,        
    SUM(p.monto) AS total_ingresos,                         
    c.estado AS estado_curso,                               
    p.fecha AS fecha_pago,                                  
    cc.categoria_id,                                        
    p.forma_pago                                           
FROM 
    Pago p
INNER JOIN 
    Inscripcion i ON p.curso_id = i.curso_id AND p.estudiante_id = i.estudiante_id
INNER JOIN 
    Curso c ON p.curso_id = c.id
LEFT JOIN 
    CursoCategoria cc ON c.id = cc.curso_id
GROUP BY 
    c.id, c.estado, p.fecha, cc.categoria_id;

//

DELIMITER ;

DELIMITER //

CREATE OR REPLACE VIEW vwReportePagos AS
SELECT 
    CONCAT(u.nombre, ' ', u.apellido_P, ' ', u.apellido_M) AS nombre_alumno,              
    p.fecha AS fecha_inscripcion,          
    i.progreso_curso AS nivel_avance,      
    p.monto AS precio_pagado,             
    CASE 
        WHEN p.forma_pago = 'p' THEN 'Paypal' 
        WHEN p.forma_pago = 't' THEN 'Tarjeta'
        ELSE 'Desconocido' 
    END AS forma_pago      
FROM 
    Pago p
INNER JOIN 
    Usuario u ON p.estudiante_id = u.id_usuario
INNER JOIN 
    Inscripcion i ON p.estudiante_id = i.estudiante_id AND p.curso_id = i.curso_id;

//

DELIMITER ;


