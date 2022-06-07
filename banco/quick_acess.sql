create database quick_acess;
use quick_acess;
create table USUARIO(
	id_usuario int primary key auto_increment not null,
	nome varchar(120) not null,
	sobrenome varchar(120) not null,
	email varchar(150) unique  not null,
	frase char(40),
	img_perfil varchar(36),
	senha char(40) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table CONTA(
	id_conta int primary key auto_increment not null,
	senha varchar(100) not null,
	nome varchar(60) not null,
	email varchar(150) not null,
	dt_criacao date not null,
	fk_usuario int not null,
	foreign key(fk_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;