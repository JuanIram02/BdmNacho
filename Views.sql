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

CREATE OR REPLACE VIEW vwPagos_Inscripciones AS
SELECT 
    p.id AS pago_id,
    p.curso_id,
    p.estudiante_id,
    p.monto AS monto_pago,
    p.forma_pago,
    p.fecha AS fecha_pago,
    i.id AS inscripcion_id,
    i.fecha_inscripcion,
    i.fecha_ultima,
    i.fecha_terminacion,
    i.progreso_curso,
    i.estado AS estado_inscripcion,
    i.precio_pagado
FROM 
    Pago p
INNER JOIN 
    Inscripcion i
ON 
    p.curso_id = i.curso_id 
    AND p.estudiante_id = i.estudiante_id;
//

DELIMITER ;
