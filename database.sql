CREATE DATABASE quiz_master;
USE quiz_master;

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    puntaje INT DEFAULT 0
);

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    color VARCHAR(20) NOT NULL,
    icono VARCHAR(10) NOT NULL
);

CREATE TABLE pregunta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    opcion_a VARCHAR(255) NOT NULL,
    opcion_b VARCHAR(255) NOT NULL,
    opcion_c VARCHAR(255) NOT NULL,
    opcion_d VARCHAR(255) NOT NULL,
    respuesta_correcta CHAR(1) NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id)
);

CREATE TABLE partida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    fecha DATETIME NOT NULL,
    resultado VARCHAR(20) NOT NULL,
    puntaje INT NOT NULL,
    id_categoria INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id),
    FOREIGN KEY (id_categoria) REFERENCES categoria(id)
);

CREATE TABLE respuesta_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_pregunta INT NOT NULL,
    respuesta_seleccionada CHAR(1) NOT NULL,
    es_correcta TINYINT(1) NOT NULL DEFAULT 0,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id),
    FOREIGN KEY (id_pregunta) REFERENCES pregunta(id)
);

INSERT INTO usuario(nombre, username, email, puntaje)
VALUES
('Danilo Tikak', 'danilo', 'danilo@mail.com', 1250),
('Juan Perez', 'juanp', 'juan@mail.com', 850),
('Sofia Gomez', 'sofiag', 'sofia@mail.com', 1420);

INSERT INTO categoria(nombre, color, icono)
VALUES
('Historia', '#f59e0b', '🏛️'),
('Deportes', '#22c55e', '⚽'),
('Ciencia', '#38bdf8', '🧪'),
('Cultura General', '#8b5cf6', '🎨');

INSERT INTO pregunta(texto, opcion_a, opcion_b, opcion_c, opcion_d, respuesta_correcta, id_categoria)
VALUES
('¿En qué año fue la Revolución de Mayo?', '1810', '1816', '1806', '1820', 'A', 1),
('¿Cuántos jugadores tiene un equipo de fútbol en cancha?', '9', '10', '11', '12', 'C', 2),
('¿Cuál es el planeta más cercano al Sol?', 'Venus', 'Mercurio', 'Marte', 'Júpiter', 'B', 3),
('¿Quién pintó la Mona Lisa?', 'Van Gogh', 'Picasso', 'Da Vinci', 'Miguel Ángel', 'C', 4);

INSERT INTO partida(id_usuario, categoria, fecha, resultado, puntaje)
VALUES
(1, 'Historia', '2026-05-31 18:30:00', 'VICTORIA', 10),
(1, 'Deportes', '2026-05-30 20:15:00', 'VICTORIA', 8),
(1, 'Ciencia', '2026-05-29 21:40:00', 'DERROTA', 4),
(1, 'Cultura General', '2026-05-28 19:05:00', 'VICTORIA', 15);