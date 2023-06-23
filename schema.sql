# ########################################   SCHEMA   ########################################
CREATE DATABASE `bdt` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE bdt;
# ########################################   TABLAS   ########################################
CREATE TABLE `role` (
    `id` int NOT NULL,
    `roleName` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    UNIQUE KEY `role_name_UNIQUE` (`roleName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `categorias` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nombre` varchar(45) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nombre_UNIQUE` (`nombre`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `sub_categorias` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nombre` varchar(45) NOT NULL,
    `categoriasId` int NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nombre_UNIQUE` (`nombre`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    KEY `FK_subcat_categorias_idx` (`categoriasId`),
    CONSTRAINT `FK_subcat_categorias` FOREIGN KEY (`categoriasId`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `username` varchar(45) NOT NULL,
    `passw` varchar(100) DEFAULT NULL,
    `email` varchar(100) NOT NULL,
    `nombre` varchar(45) DEFAULT NULL,
    `apellidos` varchar(45) DEFAULT NULL,
    `poblacion` varchar(100) DEFAULT NULL,
    `horas` int DEFAULT '10',
    `role` int NOT NULL DEFAULT '2',
    PRIMARY KEY (`id`),
    UNIQUE KEY `username_UNIQUE` (`username`) /*!80000 INVISIBLE */,
    UNIQUE KEY `email_UNIQUE` (`email`),
    KEY `FK_users_role_idx` (`role`),
    CONSTRAINT `FK_users_role` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `ofertas` (
    `id` int NOT NULL AUTO_INCREMENT,
    `userId` int NOT NULL,
    `categoriaId` int NOT NULL,
    `subCatId` int NOT NULL,
    `descripcion` varchar(240) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `FK_oferta_users_idx` (`userId`),
    KEY `FK_oferta_categorias_idx` (`categoriaId`,`subCatId`),
    KEY `FK_oferta_subCategoria_idx` (`subCatId`),
    CONSTRAINT `FK_oferta_subCategoria` FOREIGN KEY (`subCatId`) REFERENCES `sub_categorias` (`id`),
    CONSTRAINT `FK_oferta_users` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `valoraciones` (
    `userId` int NOT NULL,
    `valoracion` decimal(4,2) DEFAULT '0.00',
    `votos` int DEFAULT '0',
    PRIMARY KEY (`userId`),
    UNIQUE KEY `userId_UNIQUE` (`userId`),
    KEY `idUser_idx` (`userId`),
    CONSTRAINT `FK_valoraciones_users` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


# ########################################   TRIGGERS   ########################################

CREATE DEFINER=`root`@`localhost` TRIGGER `users_AFTER_INSERT` AFTER INSERT ON `users` FOR EACH ROW
    INSERT INTO valoraciones (userId,  valoracion, votos) VALUES(new.id, 0, 0);

CREATE DEFINER=`root`@`localhost` TRIGGER `users_AFTER_INSERT` AFTER INSERT ON `users` FOR EACH ROW
BEGIN
    INSERT INTO valoraciones (userId,  valoracion, votos) VALUES(new.id, 0, 0);
END;


# ########################################   VISTAS   ########################################
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bdt`.`v_ofertas` AS select
    `bdt`.`ofertas`.`id` AS `id`,
    `bdt`.`ofertas`.`userId` AS `userId`,
    `bdt`.`ofertas`.`categoriaId` AS `categoriaId`,
    `bdt`.`categorias`.`nombre` AS `catNombre`,
    `bdt`.`ofertas`.`descripcion` AS `descripcion`,
    `bdt`.`users`.`nombre` AS `nombre`,
    `bdt`.`users`.`apellidos` AS `apellidos`,
    `bdt`.`users`.`username` AS `username`,
    `bdt`.`users`.`email` AS `email`,
    `bdt`.`users`.`poblacion` AS `poblacion`,
    `bdt`.`valoraciones`.`valoracion` AS `valoracion`,
    `bdt`.`valoraciones`.`votos` AS `votos`,
    `bdt`.`sub_categorias`.`id` AS `subCatId`,
    `bdt`.`sub_categorias`.`nombre` AS `subCatNombre`
    from ((((`bdt`.`ofertas`
        join `bdt`.`users` on((`bdt`.`ofertas`.`userId` = `bdt`.`users`.`id`)))
        join `bdt`.`categorias` on((`bdt`.`ofertas`.`categoriaId` = `bdt`.`categorias`.`id`)))
        join `bdt`.`sub_categorias` on((`bdt`.`ofertas`.`subCatId` = `bdt`.`sub_categorias`.`id`)))
        join `bdt`.`valoraciones` on((`bdt`.`users`.`id` = `bdt`.`valoraciones`.`userId`)));


CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bdt`.`v_users` AS select
    `bdt`.`users`.`id` AS `id`,
    `bdt`.`users`.`username` AS `username`,
    `bdt`.`users`.`passw` AS `passw`,
    `bdt`.`users`.`email` AS `email`,
    `bdt`.`users`.`nombre` AS `nombre`,
    `bdt`.`users`.`apellidos` AS `apellidos`,
    `bdt`.`users`.`poblacion` AS `poblacion`,
    `bdt`.`users`.`horas` AS `horas`,
    `bdt`.`role`.`id` AS `roleId`,
    `bdt`.`role`.`roleName` AS `roleName`,
    `bdt`.`valoraciones`.`userId` AS `userId`,
    `bdt`.`valoraciones`.`valoracion` AS `valoracion`,
    `bdt`.`valoraciones`.`votos` AS `votos`
    from ((`bdt`.`users`
        join `bdt`.`role` on((`bdt`.`users`.`role` = `bdt`.`role`.`id`)))
        join `bdt`.`valoraciones` on((`bdt`.`users`.`id` = `bdt`.`valoraciones`.`userId`)));


# ########################################   INSERTS   ########################################
INSERT INTO role (id, roleName) VALUES(1,'ADMIN'),(2, 'USER'),(3,'BANNED');
INSERT INTO users (id, username, passw, email, nombre, apellidos,  poblacion, horas, role)
VALUES  (1, "Nes", "BpeoQa/YNeJFk9/ZW9oQCw==", "nestito__@hotmail.com", "Nestor", "ibanez",  "Grn", 10, 1),
        (2, "admin", "BpeoQa/YNeJFk9/ZW9oQCw==", "admin@gmail.com", "nombre0", "Apellido",  "Bcn", 10, 1),
        (3, "user1", "BpeoQa/YNeJFk9/ZW9oQCw==", "user1@gmail.com", "nombre1", "Apellido1",  "Bcn", 10, 2),
        (4, "user2", "BpeoQa/YNeJFk9/ZW9oQCw==", "user2@gmail.com", "nombre2", "Apellido2",  "Bcn", 10, 2),
        (5, "user3", "BpeoQa/YNeJFk9/ZW9oQCw==", "user3@gmail.com", "nombre3", "Apellido3",  "Bcn", 10, 3);

INSERT INTO categorias(id, nombre) VALUES (1, "Informática"), (2, "Música"), (3, "Idiomas");
INSERT INTO sub_categorias (id, nombre, categoriasId)
VALUES  (1, "Programación c++",1),(2, "Programación Java", 1), (3, "Programación Python", 1),
        (4, "Guitarra", 2), (5, "Piano", 2), (6, "Flauta", 2),
        (7, "Catalán", 3), (8, "Inglés", 3), (9, "Francés", 3);

INSERT INTO ofertas (userId, categoriaId, subCatId, descripcion)
VALUES (1, 1, 1, "Clases de programación c++"),
       (1, 1, 2, "Clases de programación Java"),
       (1, 1, 3, "Clases de programación Python"),
       (1, 2, 4, "Clases de Guitarra"),
       (1, 2, 5, "Clases de Piano"),
       (1, 2, 6, "Clases de Flauta"),
       (1, 3, 7, "Clases de Catalán"),
       (1, 3, 8, "Clases de Ingles"),
       (1, 3, 9, "Clases de Frances"),
       (2, 1, 1, "Clases de programación c++"),
       (2, 1, 2, "Clases de programación Java"),
       (2, 1, 3, "Clases de programación Python"),
       (2, 2, 4, "Clases de Guitarra"),
       (2, 2, 5, "Clases de Piano"),
       (2, 2, 6, "Clases de Flauta"),
       (2, 3, 8, "Clases de Ingles"),
       (2, 3, 9, "Clases de Frances"),
       (3, 1, 1, "Clases de programación c++"),
       (3, 1, 3, "Clases de programación Python"),
       (3, 2, 4, "Clases de Guitarra"),
       (3, 2, 6, "Clases de Flauta"),
       (3, 3, 7, "Clases de Catalán"),
       (4, 1, 2, "Clases de programación Java"),
       (4, 2, 5, "Clases de Piano"),
       (4, 3, 7, "Clases de Catalán"),
       (5, 3, 9, "Clases de Frances");




