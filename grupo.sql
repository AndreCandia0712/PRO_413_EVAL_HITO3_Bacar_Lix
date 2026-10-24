-- =========================================================
-- PRO-413 - HITO 3
-- SISTEMA DE GESTION ESCOLAR BACARLIX
-- BASE DE DATOS DEL GRUPO - MYSQL DOCKER
--
-- Responsable: Pablo Medina
--
-- Tablas:
--   estudiantes
--   asignaturas
--   inscripciones
--   calificaciones
--
-- No crear aqui tablas institucionales.
-- =========================================================

CREATE DATABASE IF NOT EXISTS gestion_escolar
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE gestion_escolar;

-- =========================================================
-- 1. ESTUDIANTES
-- =========================================================

CREATE TABLE IF NOT EXISTS estudiantes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    fecha_nacimiento DATE NULL
) ENGINE=InnoDB;

-- =========================================================
-- 2. ASIGNATURAS
-- =========================================================

CREATE TABLE IF NOT EXISTS asignaturas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    codigo VARCHAR(30) NOT NULL UNIQUE,
    creditos INT UNSIGNED NOT NULL DEFAULT 4
) ENGINE=InnoDB;

-- =========================================================
-- 3. INSCRIPCIONES
-- =========================================================

CREATE TABLE IF NOT EXISTS inscripciones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    estudiante_id BIGINT UNSIGNED NOT NULL,
    asignatura_id BIGINT UNSIGNED NOT NULL,
    fecha_inscripcion DATE NOT NULL,
    estado ENUM('activa', 'retirada', 'finalizada')
        NOT NULL DEFAULT 'activa',

    CONSTRAINT fk_inscripcion_estudiante
        FOREIGN KEY (estudiante_id)
        REFERENCES estudiantes(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_inscripcion_asignatura
        FOREIGN KEY (asignatura_id)
        REFERENCES asignaturas(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT uq_estudiante_asignatura
        UNIQUE (estudiante_id, asignatura_id)
) ENGINE=InnoDB;

-- =========================================================
-- 4. CALIFICACIONES
-- =========================================================

CREATE TABLE IF NOT EXISTS calificaciones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    inscripcion_id BIGINT UNSIGNED NOT NULL,
    nota DECIMAL(5,2) NOT NULL,
    observacion VARCHAR(255) NULL,

    CONSTRAINT fk_calificacion_inscripcion
        FOREIGN KEY (inscripcion_id)
        REFERENCES inscripciones(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT chk_nota_rango
        CHECK (nota >= 0 AND nota <= 100)
) ENGINE=InnoDB;

-- =========================================================
-- 5. DATOS DE PRUEBA: ESTUDIANTES
-- =========================================================

INSERT INTO estudiantes
    (id, nombres, apellidos, correo, fecha_nacimiento)
VALUES
    (1, 'Carlos', 'Mamani', 'carlos@example.com', '2005-03-12'),
    (2, 'Lucia', 'Quispe', 'lucia@example.com', '2004-08-25'),
    (3, 'Pedro', 'Flores', 'pedro@example.com', '2005-11-10'),
    (4, 'Maria', 'Condori', 'maria@example.com', '2006-01-18'),
    (5, 'Ana', 'Vargas', 'ana@example.com', '2004-06-05')
ON DUPLICATE KEY UPDATE
    nombres = VALUES(nombres),
    apellidos = VALUES(apellidos),
    correo = VALUES(correo),
    fecha_nacimiento = VALUES(fecha_nacimiento);

-- =========================================================
-- 6. DATOS DE PRUEBA: ASIGNATURAS
-- =========================================================

INSERT INTO asignaturas
    (id, nombre, codigo, creditos)
VALUES
    (1, 'Matematicas', 'MAT101', 5),
    (2, 'Lenguaje', 'LEN101', 4),
    (3, 'Programacion', 'PRO101', 5),
    (4, 'Fisica', 'FIS101', 4),
    (5, 'Historia', 'HIS101', 3)
ON DUPLICATE KEY UPDATE
    nombre = VALUES(nombre),
    codigo = VALUES(codigo),
    creditos = VALUES(creditos);

-- =========================================================
-- 7. DATOS DE PRUEBA: INSCRIPCIONES
-- =========================================================

INSERT INTO inscripciones
    (id, estudiante_id, asignatura_id, fecha_inscripcion, estado)
VALUES
    (1, 1, 1, '2026-02-10', 'activa'),
    (2, 1, 3, '2026-02-10', 'activa'),
    (3, 2, 2, '2026-02-11', 'activa'),
    (4, 3, 3, '2026-02-12', 'activa'),
    (5, 4, 4, '2026-02-12', 'activa'),
    (6, 5, 5, '2026-02-13', 'activa')
ON DUPLICATE KEY UPDATE
    estudiante_id = VALUES(estudiante_id),
    asignatura_id = VALUES(asignatura_id),
    fecha_inscripcion = VALUES(fecha_inscripcion),
    estado = VALUES(estado);

-- =========================================================
-- 8. DATOS DE PRUEBA: CALIFICACIONES
-- =========================================================

INSERT INTO calificaciones
    (id, inscripcion_id, nota, observacion)
VALUES
    (1, 1, 85.00, 'Buen rendimiento'),
    (2, 2, 92.00, 'Excelente trabajo'),
    (3, 3, 78.00, 'Aprobado'),
    (4, 4, 88.00, 'Muy buen avance'),
    (5, 5, 70.00, 'Debe reforzar algunos temas'),
    (6, 6, 95.00, 'Excelente participacion')
ON DUPLICATE KEY UPDATE
    inscripcion_id = VALUES(inscripcion_id),
    nota = VALUES(nota),
    observacion = VALUES(observacion);

-- =========================================================
-- 9. VERIFICACION
-- =========================================================

SHOW TABLES;

SELECT 'estudiantes' AS tabla, COUNT(*) AS total
FROM estudiantes

UNION ALL

SELECT 'asignaturas', COUNT(*)
FROM asignaturas

UNION ALL

SELECT 'inscripciones', COUNT(*)
FROM inscripciones

UNION ALL

SELECT 'calificaciones', COUNT(*)
FROM calificaciones;