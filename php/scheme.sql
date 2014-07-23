
CREATE TABLE IF NOT EXISTS utente (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(32) NOT NULL,
    password varchar(32) NOT NULL,
    nome varchar(32) NOT NULL,
    cognome varchar(32) NOT NULL,
    email varchar(32) NOT NULL,
    ruolo varchar(32) NOT NULL
);

CREATE TABLE IF NOT EXISTS categoria (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome varchar(32) NOT NULL,
    descrizione varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS prodotto (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome varchar(32) NOT NULL,
    descrizione varchar(255) NOT NULL,
    costo float NOT NULL,
    iva float NOT NULL,
    prezzo_vendita float NOT NULL,
    quantità float NOT NULL,
    id_categoria bigint(20) unsigned NOT NULL,
    FOREIGN KEY(id_categoria) REFERENCES categoria(id) ON DELETE CASCADE ON UPDATE CASCADE
);