# Project_S4_Restaurant

Common repository for the ESAIP 4th semester project

This repository contains the code for a restaurant management web application, coded in vanilla PHP.

## Requirements

Just Docker on the server.

## How to install

1. Copy this repository on the machine you wish to run the server from (it must have Docker installed)
1. Open a terminal, go to the `docker/` folder
1. Run `docker compose build` to build the images from the `Dockerfile`
1. Run `docker compose up [-d]` to launch the server (`-d` option to detach the terminal)
1. Go to PHPMyAdmin : `[server_ip]:5001`
1. Log in (`root` - `123456789`)
1. Go to the `import` tab
1. Import the `db.sql` file

The database data will be stored in the `docker/data` folder.

## How to use

1. Open Chrome or any other browser
1. Go to `[server_ip]:5000`
