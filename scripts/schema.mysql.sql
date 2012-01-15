-- scripts/schema.mysql.sql
--
-- You will need load your database schema with this SQL.
 
CREATE TABLE guestbook (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(32) NOT NULL,
    comment TEXT NULL,
    created DATE NOT NULL
);
