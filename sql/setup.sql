DROP DATABASE IF EXISTS contacts_app;

CREATE DATABASE contacts_app;

USE contacts_app;

CREATE TABLE users
(
    id            INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(255) NOT NULL,
    email         VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE address
(
    id          INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    street      VARCHAR(255) NOT NULL,
    city        VARCHAR(255) NOT NULL,
    state       VARCHAR(255) NOT NULL,
    postal_code INT          NOT NULL,
    country     VARCHAR(255) NOT NULL
);

CREATE TABLE contacts
(
    id           INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(255) NOT NULL,
    phone_number VARCHAR(255) NOT NULL,
    user_id      INT          NOT NULL,
    address_id      INT          NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (address_id) REFERENCES address (id)
);


