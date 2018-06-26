-- Create database and its owner

create database palettemaker;
create user palettemakeruser with password 'palettepalettepalette';
alter database palettemaker owner to palettemakeruser;
revoke connect on database palettemaker from public;
grant all privileges on database palettemaker to palettemakeruser;


-- Set up tables

create table color (
	id serial primary key,
	name varchar(50) unique not null,
	hex char(6) unique not null
);

create table palette (
	id serial primary key,
	name varchar(50) unique not null
);

create table color_palette (
	id serial primary key,
	color_id integer references color(id),
	palette_id integer references palette(id)
);


-- Seed tables with initial data

INSERT INTO color (name, hex) VALUES ('Red', 'ee2560');
INSERT INTO color (name, hex) VALUES ('Orange', 'e97f02');
INSERT INTO color (name, hex) VALUES ('Yellow', 'f8ca00');
INSERT INTO color (name, hex) VALUES ('Green', '3ac569');
INSERT INTO color (name, hex) VALUES ('Blue', '47b8e0');
INSERT INTO color (name, hex) VALUES ('Purple', '7200da');
INSERT INTO color (name, hex) VALUES ('White', 'FFFFFF');
INSERT INTO color (name, hex) VALUES ('Light Grey', 'CCCCCC');
INSERT INTO color (name, hex) VALUES ('Grey', '666666');
INSERT INTO color (name, hex) VALUES ('Dark Grey', '333333');
INSERT INTO color (name, hex) VALUES ('Black', '000000');

INSERT INTO palette (name) VALUES ('Rainbow');
INSERT INTO palette (name) VALUES ('Greyscale');
INSERT INTO palette (name) VALUES ('4th of July');
INSERT INTO palette (name) VALUES ('Halloween');


INSERT INTO color_palette (color_id, palette_id) VALUES (1, 1);
INSERT INTO color_palette (color_id, palette_id) VALUES (2, 1);
INSERT INTO color_palette (color_id, palette_id) VALUES (3, 1);
INSERT INTO color_palette (color_id, palette_id) VALUES (4, 1);
INSERT INTO color_palette (color_id, palette_id) VALUES (5, 1);
INSERT INTO color_palette (color_id, palette_id) VALUES (6, 1);

INSERT INTO color_palette (color_id, palette_id) VALUES (1, 3);
INSERT INTO color_palette (color_id, palette_id) VALUES (5, 3);
INSERT INTO color_palette (color_id, palette_id) VALUES (7, 3);

INSERT INTO color_palette (color_id, palette_id) VALUES (7, 2);
INSERT INTO color_palette (color_id, palette_id) VALUES (8, 2);
INSERT INTO color_palette (color_id, palette_id) VALUES (9, 2);
INSERT INTO color_palette (color_id, palette_id) VALUES (10, 2);
INSERT INTO color_palette (color_id, palette_id) VALUES (11, 2);

INSERT INTO color_palette (color_id, palette_id) VALUES (2, 4);
INSERT INTO color_palette (color_id, palette_id) VALUES (11, 4);


-- Select to get all the complete list of palette contents

SELECT palette.name, color.name, color.hex
FROM palette JOIN color_palette ON palette.id = color_palette.palette_id
JOIN color ON color.id = color_palette.color_id;

