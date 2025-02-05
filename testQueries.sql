
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
                    INSERT INTO `subcategories` (`category`, `subcategory`, `imageURL`) VALUES ('Void Anchoring & Stabilization', 'Void Anchors', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Reticulan%20void%20anchor.png?raw=true'), ('Void Anchoring & Stabilization', 'Stabilizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Common%20quantum%20stabilizer.png?raw=true');

                    INSERT INTO `subcategories` (`category`, `subcategory`, `imageURL`) VALUES ('Temporal Flux & Phasing', 'Flux Generators', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Deuterium%20flux%20generator.png?raw=true'), ('Temporal Flux & Phasing', 'Phasers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Hexadecimal%20phaser.png?raw=true');
                    INSERT INTO `subcategories` (`category`, `subcategory`, `imageURL`) VALUES ('Molecular Binding & Fusion', 'Binding Agents', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Neutron%20binder.png?raw=true'), ('Molecular Binding & Fusion', 'Fusion Cells', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Bismuth%20cell.png?raw=true');

                

                    SELECT * FROM `products`;

                    SELECT * FROM `categories`;

                    SELECT * FROM `subcategories`;

                    SELECT * FROM `users`;

                    INSERT INTO `products` (`name`, `category`, `subcategory`, `imageURL`, `description`, `price`, `stock`) VALUES
('Advanced Quantum Stabilizer', 'Void Anchoring & Stabilization', 'Stabilizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Advanced%20quantum%20stablizier.png?raw=true', 'High-precision quantum field stabilization device for advanced particle containment', 2999.99, 5),

('Antimatter Flux Generator', 'Temporal Flux & Phasing', 'Flux Generators', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Antimatter%20flux%20generator.png?raw=true', 'Industrial-grade antimatter flux generation system', 4499.99, 3),

('Binary Phaser', 'Temporal Flux & Phasing', 'Phasers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Binary%20phaser.png?raw=true', 'Dual-mode temporal phase adjustment apparatus', 18999.99, 8),

('Bismuth Cell', 'Molecular Binding & Fusion', 'Fusion Cells', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Bismuth%20cell.png?raw=true', 'High-capacity bismuth-based fusion power cell', 15999.99, 12),

('Boron Cell', 'Molecular Binding & Fusion', 'Fusion Cells', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Boron%20cell.png?raw=true', 'Boron-enhanced molecular fusion cell', 13999.99, 15),

('Common Quantum Stabilizer', 'Void Anchoring & Stabilization', 'Stabilizers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Common%20quantum%20stabilizer.png?raw=true', 'Standard quantum field stabilization unit', 199.99, 20),

('Decimal Phaser', 'Temporal Flux & Phasing', 'Phasers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Decimal%20phaser.png?raw=true', 'Precision decimal-point temporal phase shifter', 2299.99, 7),

('Neutron Binder', 'Molecular Binding & Fusion', 'Binding Agents', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Neutron%20binder.png?raw=true', 'Heavy-duty neutron binding system', 2799.99, 6),

('Quark Binder', 'Molecular Binding & Fusion', 'Binding Agents', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Quark%20binder.png?raw=true', 'Subatomic particle binding apparatus', 3999.99, 4),

('Reticulan Void Anchor', 'Void Anchoring & Stabilization', 'Void Anchors', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Reticulan%20void%20anchor.png?raw=true', 'Advanced void space anchoring system', 4999.99, 2);

INSERT INTO `products` (`name`, `category`, `subcategory`, `imageURL`, `description`, `price`, `stock`) VALUES
('Cerium Cell', 'Molecular Binding & Fusion', 'Fusion Cells', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Cerium%20cell.png?raw=true', 'Rare earth cerium-based fusion cell', 17999.99, 8),

('Deuterium Flux Generator', 'Temporal Flux & Phasing', 'Flux Generators', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Deuterium%20flux%20generator.png?raw=true', 'Heavy hydrogen temporal flux system', 2899.99, 6),

('Hexadecimal Phaser', 'Temporal Flux & Phasing', 'Phasers', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Hexadecimal%20phaser.png?raw=true', '16-base temporal phase manipulator', 24999.99, 7),

('Photon Binder', 'Molecular Binding & Fusion', 'Binding Agents', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Photon%20binder.png?raw=true', 'Light particle binding unit', 19999.99, 10),

('Positron Binder', 'Molecular Binding & Fusion', 'Binding Agents', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Positron%20binder.png?raw=true', 'Antimatter particle binding system', 3999.99, 3),

('Promethium Cell', 'Molecular Binding & Fusion', 'Fusion Cells', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Promethium%20cell.png?raw=true', 'Radioactive promethium fusion cell', 2999.99, 4),

('Sirian Void Anchor', 'Void Anchoring & Stabilization', 'Void Anchors', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Stray%20void%20anchor.png?raw=true', 'Secondary void space anchor device', 34999.99, 5),

('Terbium Cell', 'Molecular Binding & Fusion', 'Fusion Cells', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Terbium%20cell.png?raw=true', 'Terbium-enhanced fusion power cell', 21999.99, 7),

('Thorium Cell', 'Molecular Binding & Fusion', 'Fusion Cells', 'https://github.com/Curanda/Curanda.github.io/blob/main/mccompra_mascarro/Thorium%20cell.png?raw=true', 'Thorium-based nuclear fusion cell', 25999.99, 6);







