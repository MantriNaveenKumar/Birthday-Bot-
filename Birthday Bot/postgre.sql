
CREATE DATABASE birthday;

CREATE TABLE IF NOT EXISTS birthday_details (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    dob DATE NOT NULL
);

CREATE TABLE admin(
    id SERIAL PRIMARY key,
    adminname VARCHAR(255) not NULL,
    email_id  VARCHAR(255) NOT NULL,
       password VARCHAR(255) NOT NULL
);


