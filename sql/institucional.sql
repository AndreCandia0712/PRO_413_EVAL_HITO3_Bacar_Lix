
CREATE TABLE IF NOT EXISTS docentes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    especialidad VARCHAR(100),
    correo VARCHAR(150) UNIQUE
);

CREATE TABLE IF NOT EXISTS gestiones_academicas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS aulas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(30) NOT NULL UNIQUE,
    capacidad INT UNSIGNED NOT NULL,
    ubicacion VARCHAR(100)
);


CREATE TABLE IF NOT EXISTS asignaciones_docentes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    docente_id BIGINT UNSIGNED NOT NULL,
    gestion_academica_id BIGINT UNSIGNED NOT NULL,
    aula_id BIGINT UNSIGNED NOT NULL,
    asignatura_id BIGINT UNSIGNED NOT NULL,

    INDEX idx_docente (docente_id),
    INDEX idx_gestion (gestion_academica_id),
    INDEX idx_aula (aula_id),
    INDEX idx_asignatura (asignatura_id)
);

