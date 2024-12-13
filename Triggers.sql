DELIMITER //

CREATE TRIGGER trgInscripcion
AFTER INSERT ON Pago
FOR EACH ROW
BEGIN
    IF NOT EXISTS (
        SELECT 1 
        FROM Inscripcion
        WHERE curso_id = NEW.curso_id AND estudiante_id = NEW.estudiante_id
    ) THEN
        INSERT INTO Inscripcion (curso_id, estudiante_id, fecha_inscripcion, estado, precio_pagado)
        VALUES (NEW.curso_id, NEW.estudiante_id, NOW(), 'P', NEW.monto);
    END IF;
END;
//

DELIMITER ;

DELIMITER //

CREATE TRIGGER trgFechaTerminacion
AFTER INSERT ON Certificado
FOR EACH ROW
BEGIN
    -- Actualizar la fecha de terminación en la tabla Inscripcion
    UPDATE Inscripcion
    SET fecha_terminacion = NEW.fecha_emision
    WHERE curso_id = NEW.curso_id 
      AND estudiante_id = NEW.estudiante_id;
END;
//

DELIMITER ;

