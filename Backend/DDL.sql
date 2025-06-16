--DDL Para la base de datos, esta en postgres
CREATE TABLE usuarios (
    id_usuario BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
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


CREATE TABLE articulos (
    id_articulo BIGINT PRIMARY KEY,
    titulo_articulo VARCHAR(100),
    conten_articulo TEXT,
    cate_articulo VARCHAR(100),
    subcate_articulo VARCHAR(100),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,   
    visibilidad VARCHAR(20) CHECK (visibilidad IN ('agente', 'publico')) DEFAULT 'publico',
    estado_publicacion BOOLEAN DEFAULT TRUE, -- Indica si el artículo está publicado o no
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

