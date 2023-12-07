DROP DATABASE IF EXISTS contacts_app;

CREATE DATABASE contacts_app;

USE contacts_app;

CREATE TABLE contacts (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255) NOT NULL
);

INSERT INTO contacts (name, phone_number) VALUES ("edgar", "123123123");
INSERT INTO contacts (name, phone_number) VALUES ("ardila", "312535");
INSERT INTO contacts (name, phone_number) VALUES ("jordi", "123");
INSERT INTO contacts (name, phone_number) VALUES ("pasha", "12951581");