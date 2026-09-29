-- Schema do banco "laboratorio_agua"

CREATE DATABASE IF NOT EXISTS laboratorio_agua
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE laboratorio_agua;

CREATE TABLE IF NOT EXISTS amostras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    data_coleta DATE NOT NULL,
    local_coleta VARCHAR(150) NOT NULL,
    parecer VARCHAR(60) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS parametros_agua (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_amostra INT NOT NULL,

    ph DECIMAL(4,2) NOT NULL,
    ph_classificacao VARCHAR(20) NOT NULL,

    turbidez DECIMAL(6,2) NOT NULL,
    turbidez_classificacao VARCHAR(20) NOT NULL,

    cloro_residual DECIMAL(5,2) NOT NULL,
    cloro_classificacao VARCHAR(20) NOT NULL,

    dureza DECIMAL(7,2) NOT NULL,
    dureza_classificacao VARCHAR(20) NOT NULL,

    temperatura DECIMAL(5,1) NOT NULL,
    temperatura_classificacao VARCHAR(20) NOT NULL,

    FOREIGN KEY (id_amostra) REFERENCES amostras(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS biofiltro_resultados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_amostra INT NOT NULL,

    parametro VARCHAR(30) NOT NULL,
    valor_antes DECIMAL(8,2) NOT NULL,
    valor_depois DECIMAL(8,2) NOT NULL,
    eficiencia DECIMAL(6,2) NOT NULL,

    FOREIGN KEY (id_amostra) REFERENCES amostras(id)
        ON DELETE CASCADE
);
