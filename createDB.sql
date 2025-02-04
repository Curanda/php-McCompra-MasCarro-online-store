
CREATE TABLE `mccompra_mascarro`.`products` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `subcategory` VARCHAR(100) NOT NULL,
    `imageURL` VARCHAR(2048) NOT NULL,
    `description` TEXT NOT NULL,
    `price` DOUBLE NOT NULL,
    `stock` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX (`category`),
    INDEX (`subcategory`),
    FOREIGN KEY (`category`) REFERENCES `categories`(`category`),
    FOREIGN KEY (`subcategory`) REFERENCES `subcategories`(`subcategory`)
) ENGINE = InnoDB;



CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `userName` VARCHAR(100) NOT NULL UNIQUE,
    `history` TEXT NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    PRIMARY KEY (`id`),
    INDEX (`userName`)
) ENGINE = InnoDB;

ALTER TABLE `users` ADD COLUMN `email` VARCHAR(100) NOT NULL;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    products TEXT NOT NULL,
    name VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    postalCode VARCHAR(10) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    status VARCHAR(20) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


SELECT * FROM `orders`;


INSERT INTO `products` (`name`, `category`, `subcategory`, `imageURL`, `description`, `price`, `stock`) VALUES ('Supreme Small Harmonizer', 'Quantum Harmonizing', 'Small Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum1.png?raw=true', 'This common small harmonizer is a powerful tool for
                    harmonizing the quantum field.', 3997, 25),
                    ('Advanced Small Harmonizer', 'Quantum Harmonizing', 'Small Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum1.png?raw=true', 'This advanced small harmonizer is a powerful tool for
                    harmonizing the quantum field.', 2997, 40),
                    ('Common Small Harmonizer', 'Quantum Harmonizing', 'Small Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum1.png?raw=true', 'This common small harmonizer is a powerful tool for
                    harmonizing the quantum field.', 1997, 50),
                    ('Supreme Medium Harmonizer', 'Quantum Harmonizing', 'Medium Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum2.png?raw=true', 'This common small harmonizer is a powerful tool for
                    harmonizing the quantum field.', 4997, 5),
                    ('Advanced Medium Harmonizer', 'Quantum Harmonizing', 'Medium Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum2.png?raw=true', 'This advanced small harmonizer is a powerful tool for
                    harmonizing the quantum field.', 3997, 10),
                    ('Common Medium Harmonizer', 'Quantum Harmonizing', 'Medium Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum2.png?raw=true', 'This common small harmonizer is a powerful tool for
                    harmonizing the quantum field.', 2997, 15),
                    ('Supreme Large Harmonizer', 'Quantum Harmonizing', 'Large Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum3.png?raw=true', 'This common small harmonizer is a powerful tool for
                    harmonizing the quantum field.', 5997, 1),
                    ('Advanced Large Harmonizer', 'Quantum Harmonizing', 'Large Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum3.png?raw=true', 'This common small harmonizer is a powerful tool for
                    harmonizing the quantum field.', 4997, 3),
                    ('Common Large Harmonizer', 'Quantum Harmonizing', 'Large Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum3.png?raw=true', 'This common small harmonizer is a powerful tool for
                    harmonizing the quantum field.', 3997, 5);

                    SELECT * FROM `products`;

                    DROP TABLE `products`;

                    TRUNCATE TABLE `users`;
                    INSERT INTO `users` (`userName`, `history`, `password`, `email`) VALUES ('admin', '', 'admin', 'admin@gmail.com');
                    INSERT INTO `users` (`userName`, `history`, `password`, `email`) VALUES ('admin2', '', 'admin2', 'admin2@gmail.com');

                    DROP TABLE `users`;
                    DROP TABLE `orders`;

                    DROP TABLE `categories`;
                    DROP TABLE `subcategories`;

                    CREATE TABLE `categories` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `category` VARCHAR(100) NOT NULL UNIQUE,
                        PRIMARY KEY (`id`),
                        INDEX (`category`)
                    ) ENGINE = InnoDB;

                    INSERT INTO `categories` (`category`) VALUES ('Quantum Harmonizing'), ('Void Anchoring & Stabilization'), ('Temporal Flux & Phasing'), ('Molecular Binding & Fusion');


                        CREATE TABLE `subcategories` (
                            `id` INT NOT NULL AUTO_INCREMENT,
                            `category` VARCHAR(100) NOT NULL,
                            `subcategory` VARCHAR(100) NOT NULL UNIQUE,
                            `imageURL` VARCHAR(2048) NOT NULL,
                            PRIMARY KEY (`id`),
                            FOREIGN KEY (`category`) REFERENCES `categories`(`category`)
                        ) ENGINE = InnoDB;

                    INSERT INTO `subcategories` (`category`, `subcategory`, `imageURL`) VALUES ('Quantum Harmonizing', 'Small Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum1.png?raw=true'), ('Quantum Harmonizing', 'Medium Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum2.png?raw=true'), ('Quantum Harmonizing', 'Large Harmonizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum3.png?raw=true');
                    INSERT INTO `subcategories` (`category`, `subcategory`, `imageURL`) VALUES ('Void Anchoring & Stabilization', 'Void Anchors', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum4.png?raw=true'), ('Void Anchoring & Stabilization', 'Stabilizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum4.png?raw=true');

                    INSERT INTO `subcategories` (`category`, `subcategory`, `imageURL`) VALUES ('Temporal Flux & Phasing', 'Flux Generators', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum5.png?raw=true'), ('Temporal Flux & Phasing', 'Phasers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum5.png?raw=true');
                    INSERT INTO `subcategories` (`category`, `subcategory`, `imageURL`) VALUES ('Molecular Binding & Fusion', 'Binding Agents', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum6.png?raw=true'), ('Molecular Binding & Fusion', 'Fusion Cells', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/quantum6.png?raw=true');

                    SELECT * FROM `products`;

                    SELECT * FROM `categories`;

                    SELECT * FROM `subcategories`;

                    SELECT * FROM `users`;