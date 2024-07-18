-- TABLAS

CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE,
    contrasena VARCHAR(100),
    tipo_usuario VARCHAR(50)
);

CREATE TABLE Terapeutas (
    id_terapeuta INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    especialidad VARCHAR(100),
    correo VARCHAR(100)
);

CREATE TABLE Terapias (
    id_terapia INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    descripcion VARCHAR(500),
    precio DECIMAL(8,2)
);

CREATE TABLE Citas (
    id_cita INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    id_terapeuta INT,
    fecha_hora DATETIME,
    id_terapia INT,
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_terapeuta) REFERENCES Terapeutas(id_terapeuta),
    FOREIGN KEY (id_terapia) REFERENCES Terapias(id_terapia)
);

CREATE TABLE Pagos (
    id_pago INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    id_terapia INT,
    monto DECIMAL(8,2),
    fecha_pago TIMESTAMP,
    metodo_pago VARCHAR(50),
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_terapia) REFERENCES Terapias(id_terapia)
);

CREATE TABLE SesionesMindfulness (
    id_sesion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_terapeuta INT,
    fecha_hora TIMESTAMP,
    duracion_minutos INT,
    notas VARCHAR(500),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_terapeuta) REFERENCES Terapeutas(id_terapeuta)
);

CREATE TABLE HistorialSesiones (
    id_sesion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_terapeuta INT,
    fecha_hora TIMESTAMP,
    duracion_minutos INT,
    notas VARCHAR(1000),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_terapeuta) REFERENCES Terapeutas(id_terapeuta)
);

CREATE TABLE Calificaciones (
    id_calificacion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_terapia INT,
    valoracion DECIMAL(2,1),
    comentario VARCHAR(1000),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_terapia) REFERENCES Terapias(id_terapia)
);

INSERT INTO Usuarios (nombre, correo, contrasena, tipo_usuario)
VALUES
('Cliente 1', 'cliente1@example.com', 'contraseña123', 'usuario'),
('Cliente 2', 'cliente2@example.com', 'contraseña456', 'usuario'),
('Cliente 3', 'cliente3@example.com', 'contraseña789', 'usuario'),
('Cliente 4', 'cliente4@example.com', 'contraseñaabc', 'usuario'),
('Cliente 5', 'cliente5@example.com', 'contraseñadef', 'usuario');

INSERT INTO Terapeutas (nombre, especialidad)
VALUES
('Terapeuta 1', 'Psicología'),
('Terapeuta 2', 'Psiquiatría'),
('Terapeuta 3', 'Terapia familiar'),
('Terapeuta 4', 'Terapia cognitivo-conductual'),
('Terapeuta 5', 'Mindfulness');

INSERT INTO Terapias (nombre, descripcion, precio)
VALUES
('Terapia Cognitiva', 'Terapia enfocada en cambiar patrones de pensamiento negativos.', 80.00),
('Terapia de Pareja', 'Ayuda a mejorar la comunicación y resolver conflictos en la pareja.', 100.00),
('Terapia Infantil', 'Dirigida a niños y adolescentes para tratar problemas emocionales y conductuales.', 70.00),
('Mindfulness', 'Técnica de meditación que ayuda a reducir el estrés y mejorar el bienestar emocional.', 90.00),
('Psicoterapia Gestalt', 'Enfoque terapéutico que enfatiza la importancia del "aquí y ahora".', 85.00);
