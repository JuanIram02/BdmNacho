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
