CREATE TABLE administradores(
    id_administrador INT(50) auto_increment NOT NULL,
    adm_usuario VARCHAR(50) NOT NULL,
    adm_clave VARCHAR(255) NOT NULL,
    CONSTRAINT pk_administradores PRIMARY KEY(id_administrador)
)ENGINE=InnoDB;

CREATE TABLE contratos(
    id_contrato INT(50) auto_increment NOT NULL,
    con_descripcion VARCHAR(50) NOT NULL,
    con_precio INT(50) NOT NULL,
    con_maxusuarios INT(50) NOT NULL,
    con_duracionmeses INT(50) NOT NULL,
    con_activo TINYINT(1) NOT NULL,
    CONSTRAINT pk_contratos PRIMARY KEY(id_contrato),
    CONSTRAINT uq_descripcion UNIQUE(con_descripcion)
)ENGINE=InnoDB;

CREATE TABLE abm_contratos(
    id_abm_contrato INT(50) auto_increment NOT NULL,
    administrador_id INT(50) NOT NULL,
    contrato_id INT(50) NOT NULL,
    abmc_accion VARCHAR(50) NOT NULL,
    abmc_fecha DATE NOT NULL,
    CONSTRAINT pk_id_abm_contratos PRIMARY KEY(id_abm_contrato),
    CONSTRAINT fk_abm_contratos_administradores FOREIGN KEY(administrador_id) REFERENCES administradores(id_administrador),
    CONSTRAINT fk_abm_contratos_contratos FOREIGN KEY(contrato_id) REFERENCES contratos(id_contrato)
)ENGINE=InnoDB;

CREATE TABLE empresas(
    id_empresa INT(50) auto_increment NOT NULL,
    em_razonsocial VARCHAR(50) NOT NULL,
    em_cuit VARCHAR(50) NOT NULL,
    em_calle VARCHAR(50) NOT NULL,
    em_altura INT(50),
    em_piso VARCHAR(50),
    em_dpto VARCHAR(50),
    em_ciudad VARCHAR(50) NOT NULL,
    em_pais VARCHAR(50) NOT NULL,
    em_cp INT(50) NOT NULL,
    em_tel int(50),
    em_email VARCHAR(50) NOT NULL,
    em_activo TINYINT(1) NOT NULL,
    contrato_id INT(50) NOT NULL,
    CONSTRAINT pk_empresas PRIMARY KEY(id_empresa),
    CONSTRAINT uq_razonsocial UNIQUE(em_razonsocial),
    CONSTRAINT uq_cuit UNIQUE(em_cuit),
    CONSTRAINT uq_email UNIQUE(em_email),
    CONSTRAINT fk_empresas_contratos FOREIGN KEY(contrato_id) REFERENCES contratos(id_contrato)
)ENGINE=InnoDB;

CREATE TABLE usuarios(
    id_usuario INT(50) auto_increment NOT NULL,
    us_nombre VARCHAR(50) NOT NULL,
    us_apellido VARCHAR(50) NOT NULL,
    us_usuario VARCHAR(50) NOT NULL,
    us_email VARCHAR(50) NOT NULL,
    us_fecha DATE NOT NULL,
    us_dni INT(50) NOT NULL,
    us_sexo VARCHAR(1) NOT NULL,
    us_calle VARCHAR(50) NOT NULL,
    us_altura INT(50),
    us_piso VARCHAR(50),
    us_dpto VARCHAR(50),
    us_ciudad VARCHAR(50) NOT NULL,
    us_pais VARCHAR(50) NOT NULL,
    us_contrasena VARCHAR(255) NOT NULL,
    us_permiso VARCHAR(255) NOT NULL,
    us_activo TINYINT(1) NOT NULL,
    us_firstlogin TINYINT(1) NOT NULL,
    empresa_id INT(50) NOT NULL,
    CONSTRAINT pk_usuarios PRIMARY KEY(id_usuario),
    CONSTRAINT fk_usuarios_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa),
    CONSTRAINT uq_usuario UNIQUE(us_usuario),
    CONSTRAINT uq_email UNIQUE(us_email),
    CONSTRAINT uq_dni UNIQUE(us_dni)
)ENGINE=InnoDB;

CREATE TABLE recuperacion_tokens(
    id_recuperacion INT(50) auto_increment NOT NULL,
    usuario_id INT(50) NOT NULL,
    rec_token INT(6) NOT NULL,
    rec_fecha DATETIME NOT NULL,
    rec_expired TINYINT(1) NOT NULL,
    CONSTRAINT pk_recuperacion_tokens PRIMARY KEY(id_recuperacion),
    CONSTRAINT fk_recuperacion_tokens_usuarios FOREIGN KEY(usuario_id) REFERENCES usuarios(id_usuario)
)ENGINE=InnoDB;

CREATE TABLE abm_empresas(
    id_abm_empresa INT(50) auto_increment NOT NULL,
    administrador_id INT(50) NOT NULL,
    empresa_id INT(50) NOT NULL,
    abme_accion VARCHAR(50) NOT NULL,
    abme_fecha DATE NOT NULL,
    CONSTRAINT pk_abm_empresas PRIMARY KEY(id_abm_empresa),
    CONSTRAINT fk_abm_empresas_administradores FOREIGN KEY(administrador_id) REFERENCES administradores(id_administrador),
    CONSTRAINT fk_abm_empresas_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa)
)ENGINE=InnoDB;

CREATE TABLE abm_usuarios(
    id_abm_usuario INT(50) auto_increment NOT NULL,
    administrador_id INT(50) NOT NULL,
    usuario_id INT(50) NOT NULL,
    empresa_id INT(50) NOT NULL,
    abmu_accion VARCHAR(50) NOT NULL,
    abmu_fecha DATE NOT NULL,
    CONSTRAINT pk_abm_usuarios PRIMARY KEY(id_abm_usuario),
    CONSTRAINT fk_abm_administradores FOREIGN KEY(administrador_id) REFERENCES administradores(id_administrador),
    CONSTRAINT fk_abm_usuarios FOREIGN KEY(usuario_id) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_abm_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa)
)ENGINE=InnoDB;

CREATE TABLE talleres(
    id_taller INT(50) auto_increment NOT NULL,
    tal_nombre VARCHAR(50) NOT NULL,
    tal_calle VARCHAR(50) NOT NULL,
    tal_altura INT(50),
    tal_localidad VARCHAR(50) NOT NULL,
    tal_cp INT(50) NOT NULL,
    tal_tel INT(50),
    tal_email VARCHAR(50) NOT NULL,
    empresa_id INT(50) NOT NULL,
    CONSTRAINT pk_talleres PRIMARY KEY(id_taller),
    CONSTRAINT uq_email UNIQUE(tal_email),
    CONSTRAINT fk_talleres_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa)
)ENGINE=InnoDB;

CREATE TABLE puestos(
    id_puesto INT(50) auto_increment NOT NULL,
    pu_descripcion VARCHAR(50) NOT NULL,
    pu_basico INT(50) NOT NULL,
    pu_presentismo INT(50),
    pu_horextra INT(50) NOT NULL,
    CONSTRAINT pk_puestos PRIMARY KEY(id_puesto)
)ENGINE=InnoDB;

CREATE TABLE personal(
    id_personal INT(50) auto_increment NOT NULL,
    pe_nombre VARCHAR(50) NOT NULL,
    pe_apellido VARCHAR(50) NOT NULL,
    pe_dni INT(50) NOT NULL,
    pe_sexo VARCHAR(1) NOT NULL,
    pe_fecha DATE NOT NULL,
    pe_calle VARCHAR(50) NOT NULL,
    pe_altura INT(50),
    pe_cp INT(50) NOT NULL,
    pe_piso VARCHAR(50),
    pe_dpto VARCHAR(50),
    pe_ciudad VARCHAR(50) NOT NULL,
    pe_pais VARCHAR(50) NOT NULL,
    pe_tel INT(50),
    pe_email VARCHAR(50) NOT NULL,
    empresa_id INT(50) NOT NULL,
    puesto_id INT(50) NOT NULL,
    CONSTRAINT pk_personal PRIMARY KEY(id_personal),
    CONSTRAINT uq_dni UNIQUE(pe_dni),
    CONSTRAINT uq_email UNIQUE(pe_email),
    CONSTRAINT fk_personal_empresa FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa),
    CONSTRAINT fk_personal_puestos FOREIGN KEY(puesto_id) REFERENCES puestos(id_puesto)
)ENGINE=InnoDB;

CREATE TABLE asignacion_taller(
    id_asig_taller INT(50) auto_increment NOT NULL,
    taller_id INT(50) NOT NULL,
    personal_id INT(50) NOT NULL,
    usuario_id INT(50) NOT NULL,
    at_turno VARCHAR(50) NOT NULL,
    empresa_id INT(50) NOT NULL,
    CONSTRAINT pk_asignacion_taller PRIMARY KEY(id_asig_taller),
    CONSTRAINT fk_asignacion_taller_talleres FOREIGN KEY(taller_id) REFERENCES talleres(id_taller),
    CONSTRAINT fk_asignacion_taller_personal FOREIGN KEY(personal_id) REFERENCES personal(id_personal),
    CONSTRAINT fk_asignacion_taller_usuarios FOREIGN KEY(usuario_id) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_asignacion_taller_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa)
)ENGINE=InnoDB;

CREATE TABLE seguros(
    id_seguro INT(50) auto_increment NOT NULL,
    se_descripcion VARCHAR(50) NOT NULL,
    se_precio INT(50) NOT NULL,
    CONSTRAINT pk_seguros PRIMARY KEY(id_seguro)
)ENGINE=InnoDB;

CREATE TABLE vehiculos(
    id_patente INT(50) NOT NULL,
    vh_tipo VARCHAR(50) NOT NULL,
    vh_modelo VARCHAR(50) NOT NULL,
    vh_marca VARCHAR(50) NOT NULL,
    vh_chasis VARCHAR(50) NOT NULL,
    vh_motor INT(50) NOT NULL,
    vh_ven_vtv DATE NOT NULL,
    vh_ven_seg DATE NOT NULL,
    vh_matafuego INT(1) NOT NULL,
    empresa_id INT(50) NOT NULL,
    CONSTRAINT pk_vehiculos PRIMARY KEY(id_patente),
    CONSTRAINT uq_patente UNIQUE(id_patente),
    CONSTRAINT uq_motor UNIQUE(vh_motor),
    CONSTRAINT fk_vehiculos_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa)
)ENGINE=InnoDB;

CREATE TABLE insumos(
    id_insumo INT(50) auto_increment NOT NULL,
    in_descripcion VARCHAR(50) NOT NULL,
    in_stock INT(50) NOT NULL,
    in_minimo INT(50) NOT NULL,
    empresa_id INT(50) NOT NULL,
    taller_id INT(50) NOT NULL,
    CONSTRAINT pk_insumos PRIMARY KEY(id_insumo),
    CONSTRAINT fk_insumos_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa),
    CONSTRAINT fk_insumos_talleres FOREIGN KEY(taller_id) REFERENCES talleres(id_taller)
)ENGINE=InnoDB;

CREATE TABLE mantenimiento(
    id_mantenimiento INT(50) auto_increment NOT NULL,
    usuario_id INT(50) NOT NULL,
    patente_id INT(50) NOT NULL,
    personal_id INT(50) NOT NULL,
    taller_id INT(50) NOT NULL,
    insumo_id INT(50) NOT NULL,
    ma_descripcion VARCHAR(50) NOT NULL,
    ma_cantidad INT(50) NOT NULL,
    ma_fecha DATE NOT NULL,
    CONSTRAINT pk_mantenimiento PRIMARY KEY(id_mantenimiento),
    CONSTRAINT fk_mantenimiento_usuarios FOREIGN KEY(usuario_id) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_mantenimiento_vehiculos FOREIGN KEY(patente_id) REFERENCES vehiculos(id_patente),
    CONSTRAINT fk_mantenimiento_personal FOREIGN KEY(personal_id) REFERENCES personal(id_personal),
    CONSTRAINT fk_mantenimiento_talleres FOREIGN KEY(taller_id) REFERENCES talleres(id_taller),
    CONSTRAINT fk_mantenimiento_insumos FOREIGN KEY(insumo_id) REFERENCES insumos(id_insumo)
)ENGINE=InnoDB;

CREATE TABLE compras(
    id_compra INT(50) auto_increment NOT NULL,
    taller_id INT(50) NOT NULL,
    usuario_id INT(50) NOT NULL,
    empresa_id INT(50) NOT NULL,
    co_cantidad INT(50) NOT NULL,
    co_p_unitario INT(50) NOT NULL,
    co_total INT(50) NOT NULL,
    co_fecha DATE NOT NULL,
    CONSTRAINT pk_compras PRIMARY KEY(id_compra),
    CONSTRAINT fk_compras_talleres FOREIGN KEY(taller_id) REFERENCES talleres(id_taller),
    CONSTRAINT fk_compras_usuarios FOREIGN KEY(usuario_id) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_compras_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa)
)ENGINE=InnoDB;

CREATE TABLE categorias(
    id_categoria INT(50) auto_increment NOT NULL,
    cat_descripcion VARCHAR(50) NOT NULL,
    CONSTRAINT pk_categorias PRIMARY KEY(id_categoria)
)ENGINE=InnoDB;

CREATE TABLE choferes(
    id_legajo INT(50) auto_increment NOT NULL,
    ch_dni INT(50) NOT NULL,
    ch_cuil INT(50) NOT NULL,
    ch_nombre VARCHAR(50) NOT NULL,
    ch_apellido VARCHAR(50) NOT NULL,
    ch_fec_nac DATE NOT NULL,
    ch_direccion VARCHAR(50) NOT NULL,
    ch_localidad VARCHAR(50) NOT NULL,
    ch_cp INT(50) NOT NULL,
    ch_tel INT(50),
    ch_email VARCHAR(50) NOT NULL,
    ch_num_lic INT(50) NOT NULL,
    ch_fec_ven_inti DATE NOT NULL,
    ch_libreta_sanitaria INT(1) NOT NULL,
    ch_fec_ven_lib DATE NOT NULL,
    categoria_id INT(50) NOT NULL,
    seguro_id INT(50) NOT NULL,
    empresa_id INT(50) NOT NULL,
    CONSTRAINT pk_choferes PRIMARY KEY(id_legajo),
    CONSTRAINT uq_dni UNIQUE(ch_dni),
    CONSTRAINT uq_cuil UNIQUE(ch_cuil),
    CONSTRAINT uq_email UNIQUE(ch_email),
    CONSTRAINT uq_num_lic UNIQUE(ch_num_lic),
    CONSTRAINT fk_choferes_categorias FOREIGN KEY(categoria_id) REFERENCES categorias(id_categoria),
    CONSTRAINT fk_choferes_seguros FOREIGN KEY(seguro_id) REFERENCES seguros(id_seguro),
    CONSTRAINT fk_choferes_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa)
)ENGINE=InnoDB;

CREATE TABLE hoja_ruta(
    id_hoja_ruta INT(50) auto_increment NOT NULL,
    usuario_id INT(50) NOT NULL,
    patente_id INT(50) NOT NULL,
    chofer_id INT(50) NOT NULL,
    empresa_id INT(50) NOT NULL,
    hr_kilometros INT(50) NOT NULL,
    hr_fecha DATE NOT NULL,
    hr_destino VARCHAR(50) NOT NULL,
    CONSTRAINT pk_hoja_ruta PRIMARY KEY(id_hoja_ruta),
    CONSTRAINT fk_hoja_ruta_usuarios FOREIGN KEY(usuario_id) REFERENCES usuarios(id_usuario),
    CONSTRAINT fk_hoja_ruta_vehiculos FOREIGN KEY(patente_id) REFERENCES vehiculos(id_patente),
    CONSTRAINT fk_hoja_ruta_choferes FOREIGN KEY(chofer_id) REFERENCES choferes(id_legajo),
    CONSTRAINT fk_hoja_ruta_empresas FOREIGN KEY(empresa_id) REFERENCES empresas(id_empresa)
)ENGINE=InnoDB;



 


