create database if not exists gestion_tareas;
use gestion_tareas;

create table if not exists users(
    id       int(255) auto_increment not null,
    role     varchar(255),
    name     varchar(255),
    surname  varchar(255),
    email    varchar(255),
    password varchar(255),
    created_at datetime,
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

insert into users values(null,'role_user','eduard','colmenares','eduard@gmail.com','12345678', CURTIME());
insert into users values(null,'role_user','ramon','peres','pere@gmail.com','12345678', CURTIME());
insert into users values(null,'role_user','sofia','oslo','sofia@gmail.com','12345678', CURTIME());


create table if not exists tasks(
    id          int(255) auto_increment not null,
    user_id     int(255) not null,
    tittle      varchar(255),
    content     text,
    priority    varchar(255),
    hours       int(255),
    created_at datetime,
CONSTRAINT PK_tasks PRIMARY KEY(id),
CONSTRAINT Fk_tasks_users FOREIGN KEY(user_id) REFERENCES users(id)

)ENGINE=InnoDb;

insert into tasks values(null,1,'tarea 1','contenido de prueba 1','high',40, CURTIME());
insert into tasks values(null,1,'tarea 2','contenido de prueba 2','high',30, CURTIME());
insert into tasks values(null,2,'tarea 3','contenido de prueba 3','high',50, CURTIME());
insert into tasks values(null,3,'tarea 4','contenido de prueba 4','high',30, CURTIME());