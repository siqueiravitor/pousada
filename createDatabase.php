CREATE TABLE funcionario (
idFuncionario int(11) PRIMARY KEY AUTO_INCREMENT,
nome varchar(100),
login varchar(50),
senha varchar(32),
admin enum('s','n')
);

CREATE TABLE cliente (
idCliente int(11) PRIMARY KEY AUTO_INCREMENT,
nome varchar(100),
dataNasc date,
CPF varchar(11),
email varchar(100),
telefone varchar(11),
estado varchar(2),
cidade varchar(50),
status enum('s','n')
);

CREATE TABLE acomodacao (
idAcomodacao int(11) PRIMARY KEY AUTO_INCREMENT,
idCliente int(11),
nome varchar(50),
numero int(11),
tipo enum('b','s','m'),
valor float(10,2),
capMax int(11),
estacionamento enum('s','n')
status enum('s','n')
FOREIGN KEY(idCliente) REFERENCES cliente (idCliente)
);

CREATE TABLE frigobar (
idFrigobar int(11) PRIMARY KEY AUTO_INCREMENT,
idAcomodacao int(11),
FOREIGN KEY(idAcomodacao) REFERENCES acomodacao (idAcomodacao)
);

CREATE TABLE item (
idItem int(11) PRIMARY KEY AUTO_INCREMENT,
idFrigobar int(11),
nome varchar(50),
valor float(10,2),
quantidade int(11)
FOREIGN KEY(idFrigobar) REFERENCES frigobar (idFrigobar)
);

CREATE TABLE reserva (
idReserva int(11) PRIMARY KEY AUTO_INCREMENT,
idCliente int(11),
idAcomodacao int(11),
checkIn bool,
checkout bool,
dataInicio date,
dataFim date,
dataCheckIn datetime,
dataCheckOut datetime,

FOREIGN KEY(idCliente) REFERENCES cliente (idCliente),
FOREIGN KEY(idAcomodacao) REFERENCES acomodacao (idAcomodacao)
);