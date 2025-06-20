--DDL Para la base de datos, esta en postgres

CREATE TABLE usuarios (
    id_usuario BIGSERIAL NOT NULL PRIMARY KEY,
    nom_usuario VARCHAR(50) NOT NULL,
    ape_usuario VARCHAR(50) NOT NULL,
    email_usuario VARCHAR(150) NOT NULL,
    pass_usuario VARCHAR(60) NOT NULL,
    tipo_usuario VARCHAR(20) CHECK (tipo_usuario IN ('usuario', 'agente'))
);

CREATE TABLE sla (
    id_sla BIGINT PRIMARY KEY,
    nom_sla VARCHAR(100),
    tiempo_sla INT
);

CREATE TABLE categorias (
    id_categoria BIGSERIAL PRIMARY KEY, 
    nom_categoria VARCHAR(100) NOT NULL,            
    id_padre BIGINT NULL,                           
    FOREIGN KEY (id_padre) REFERENCES categorias(id_categoria) ON DELETE CASCADE, 
    descripcion TEXT NULL                           
);

CREATE TABLE servicios (
    id_servicio BIGSERIAL PRIMARY KEY, -- Autoincremental
    nom_servicio VARCHAR(100) NOT NULL, 
    desc_servicio TEXT, 
    id_categoria BIGINT, 
    CONSTRAINT fk_servicio_categoria FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE SET NULL
);

CREATE TABLE articulos (
    id_articulo BIGINT PRIMARY KEY,
    titulo_articulo VARCHAR(100),
    conten_articulo TEXT,
    cate_articulo VARCHAR(100),
    subcate_articulo VARCHAR(100),
    fecha_articulo DATE,
    visibilidad VARCHAR(20) CHECK (visibilidad IN ('agente', 'publico')) DEFAULT 'publico',
    estado_articulo VARCHAR(20) CHECK (estado_articulo IN ('pendiente', 'publicado', 'obsoleto')) DEFAULT 'pendiente' -- Indica si el artículo está publicado o no
    url_documento TEXT,   --para links a otross documentos
    imagen_articulo TEXT, --Para imagenes en base64 o en url
    id_tecnico_creador BIGINT,
    CONSTRAINT fk_tecnico_articulo FOREIGN KEY (id_tecnico_creador) REFERENCES usuarios(id_usuario)
);


CREATE TABLE activos (
    id_activo BIGINT PRIMARY KEY,
    serial_activo VARCHAR(100),
    marca_activo VARCHAR(100),
    modelo_activo VARCHAR(100),
    cate_activo VARCHAR(100),
    subcate_activo VARCHAR(100),
    fec_compra DATE,
    estado_activo VARCHAR(50),
    ubica_activo VARCHAR(100),
    id_usuario_resp BIGINT,
    CONSTRAINT fk_usuario_responsable FOREIGN KEY (id_usuario_resp) REFERENCES usuarios(id_usuario)
);

CREATE TABLE cambios (
    id_cambio BIGINT PRIMARY KEY,
    titulo_cambio VARCHAR(200),
    desc_cambio TEXT,
    tipo_cambio VARCHAR(50),
    fecha_cambio TIMESTAMP,
    riesgo_cambio VARCHAR(50),
    estado_cambio VARCHAR(50),
    id_tecnico BIGINT,
    CONSTRAINT fk_tecnico_cambio FOREIGN KEY (id_tecnico) REFERENCES usuarios(id_usuario)
);

CREATE TABLE tickets (
    id_ticket BIGINT PRIMARY KEY,
    tipo_ticket VARCHAR(50),
    titulo_ticket VARCHAR(200),
    desc_ticket TEXT,
    fe_ini_ticket TIMESTAMP,
    fe_fin_ticket TIMESTAMP,
    estado_ticket VARCHAR(50),
    id_usuario BIGINT,
    id_agente BIGINT,
    id_articulo BIGINT,
    id_sla BIGINT,
    fe_lim_ticket TIMESTAMP,
    cump_sla BOOLEAN,
    CONSTRAINT fk_usuario_ticket FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_agente_ticket FOREIGN KEY (id_agente) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_articulo_ticket FOREIGN KEY (id_articulo) REFERENCES articulos(id_articulo),
    CONSTRAINT fk_sla_ticket FOREIGN KEY (id_sla) REFERENCES sla(id_sla)
);




--Inserts

-- Insertar categorías principales (sin padre)
INSERT INTO categorias (id_categoria, nom_categoria, id_padre, descripcion) VALUES
(1, 'Sistemas de TI', NULL, 'Categoría para servicios relacionados con sistemas de TI'),
(2, 'Soporte de Hardware y Dispositivos', NULL, 'Categoría para soporte de hardware y dispositivos'),
(3, 'SAP', 1, 'Sistema de gestión empresarial'),
(4, 'Educandus', 1, 'Plataforma de aprendizaje en línea'),
(5, 'Sistema de Biblioteca', 1, 'Sistema para la gestión de bibliotecas'),
(6, 'Talana RRHH', 1, 'Sistema de gestión de recursos humanos'),
(7, 'Microsoft 365', 1, 'Suite de productividad en la nube'),
(8, 'Computadoras', 2, 'Soporte para computadoras personales y portátiles'),
(9, 'Impresoras', 2, 'Soporte para impresoras y multifuncionales'),
(10, 'Proyectores', 2, 'Soporte para proyectores y pantallas'),
(11, 'Televisores', 2, 'Soporte para televisores y pantallas grandes'),
(12, 'Access Point (WiFi)', 2, 'Soporte para puntos de acceso WiFi y redes inalámbricas'),
(13, 'Biométricos de asistencia', 2, 'Soporte para dispositivos biométricos de asistencia'),
(14, 'Internet', 2, 'Soporte para conexión a Internet y redes');


--Insertar servicios con sus categorías
--DROP TABLE IF EXISTS servicios;
INSERT INTO servicios (nom_servicio, desc_servicio, id_categoria) VALUES
('SAP', 'Gestión de recursos empresariales', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Sistemas de TI')),
('Educandus', 'Plataforma de aprendizaje', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Sistemas de TI')),
('Sistema de Biblioteca', 'Gestión de préstamos y recursos', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Sistemas de TI')),
('Talana RRHH', 'Gestión de recursos humanos', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Sistemas de TI')),
('Microsoft 365', 'Office, OneDrive y Correo', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Sistemas de TI')),
('Computadoras', 'Soporte para computadoras', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Soporte de Hardware y Dispositivos')),
('Impresoras', 'Soporte para impresoras', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Soporte de Hardware y Dispositivos')),
('Proyectores', 'Soporte para proyectores', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Soporte de Hardware y Dispositivos')),
('Televisores', 'Soporte para televisores', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Soporte de Hardware y Dispositivos')),
('Access Point (WiFi)', 'Soporte para puntos de acceso WiFi', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Soporte de Hardware y Dispositivos')),
('Biométricos de asistencia', 'Soporte para dispositivos biométricos', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Soporte de Hardware y Dispositivos')),
('Internet', 'Soporte para conexión a Internet', (SELECT id_categoria FROM categorias WHERE nom_categoria = 'Soporte de Hardware y Dispositivos'));

-- Asumimos que el técnico creador con ID 1 ya existe en la tabla usuarios y es tipo 'agente'

INSERT INTO articulos (
    id_articulo, titulo_articulo, conten_articulo, cate_articulo, subcate_articulo,
    visibilidad, estado_publicacion, url_documento, imagen_articulo, id_tecnico_creador
) VALUES 
(1, 'Cómo reiniciar un router de forma segura',
    'Para reiniciar un router de forma segura, primero apague el dispositivo desde el botón de encendido, espere 10 segundos y vuelva a encenderlo. Esto soluciona la mayoría de problemas de conectividad.',
    'Redes', 'Router', 'publico', TRUE,
    'https://intranet.soporte.com/docs/reinicio_router.pdf',
    'https://intranet.soporte.com/img/reinicio_router.png',
    1),

(2, 'Procedimiento para cambio de tóner en impresoras HP',
    'Abra la tapa superior de la impresora, retire el tóner usado y coloque el nuevo. Asegúrese de que esté correctamente insertado y cierre la tapa. Reinicie la impresora si es necesario.',
    'Soporte de Hardware', 'Impresoras', 'publico', TRUE,
    'https://intranet.soporte.com/docs/cambio_toner.pdf',
    NULL,
    1),

(3, 'Mantenimiento preventivo para notebooks',
    'Se recomienda realizar limpieza externa semanal y limpieza interna (ventiladores y disipadores) cada 6 meses. Use aire comprimido y revise actualizaciones de BIOS y drivers.',
    'Soporte de Hardware', 'Notebook', 'publico', TRUE,
    NULL,
    NULL,
    1),

(4, 'Solución de problemas de conexión WiFi',
    'Verifique que el Access Point esté encendido. Revise que no haya conflictos de IP y asegúrese de estar usando la red correcta. Reinicie el adaptador de red si es necesario.',
    'Redes', 'Access Point (WiFi)', 'publico', TRUE,
    'https://intranet.soporte.com/docs/conexion_wifi.pdf',
    NULL,
    1),

(5, 'Política de reemplazo de equipos obsoletos',
    'Los equipos declarados como "obsoletos" deben ser reportados al área de TI para su evaluación. Si el equipo no cumple con los requerimientos mínimos, se procederá a su reemplazo.',
    'Gestión de Activos', 'Equipos obsoletos', 'agente', TRUE,
    NULL,
    NULL,
    1),

(6, 'Guía para instalación de impresoras en red',
    'Para instalar una impresora en red, acceda a "Dispositivos e impresoras" en Windows, seleccione "Agregar impresora", luego "La impresora deseada no está en la lista" y escriba la IP.',
    'Soporte de Hardware', 'Impresoras', 'publico', TRUE,
    NULL,
    'https://intranet.soporte.com/img/instalacion_impresora.png',
    1),

(7, 'Cómo identificar el número de serie de un PC',
    'El número de serie puede encontrarse en una etiqueta física en la parte trasera del PC o accediendo al símbolo del sistema (cmd) y escribiendo: wmic bios get serialnumber.',
    'Inventario de Activos', 'PC', 'publico', TRUE,
    NULL,
    NULL,
    1);

INSERT INTO sla (id_sla, nom_sla, tiempo_sla) VALUES
(1, 'SLA Incidente', 8),
(2, 'SLA Requerimiento', 24);