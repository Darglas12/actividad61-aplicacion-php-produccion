# Aplicación web CRUD dockerizada desarrollada en vanilla php a implantar en un servidor de desarrollo

>IES Miguel Herrero (Torrelavega) - Curso 2025/2026
>Módulo: IAW - Implantación de Aplicaciones Web  
>Ciclo: CFGS Administración de Sistemas Informáticos en Red  

Este repositorio es una **guía ejemplo** para la realización de la **actividad 6.1** de IAW en lo que se refiere al despliegue de la aplicación CRUD en <u>DESARROLLO</u>. 

Contiene lo siguiente: 

* Directorio */.github/workflows*: Contiene ejemplos de flujos de trabajo o "workflows" (Github Actions de GitHub). Orientados a la implementación de "pipeline" o tuberías CI/CD.
* Directorio */conf*: Contiene el archivo de configuración sitio web por defecto en Apache.
* Directorio */sql*: Contiene un archivo con un script SQL para la inicialización de la BD de MariaDB
* Directorio */src*: Contiene un ejemplo de código correspondiente a la Aplicación web CRUD PHP . Implementa altas, bajas, modificaciones y listado de una pequeña tabla. Servirá de modelo para la realización de esta actividad.
* Directorio /src/html: Contiene el modelo de Aplicación web anterior pero solo la parte ESTÁTICA (sin PHP).
* Archivo .env: Configuración de variables de entorno (Contraseña Root, nombre BD, usuario BD y contraseña BD) utilizadas por el archivo docker-compose.yml.
* Archivo Dockerfile: Instrucciones para la construcción de la imagen correspondiente a la aplicación web.
* Archivo docker-compose.yml: Modelo escenario de contenedores para el despliegue de la aplicación PHP. Contiene 3 servicios: 
1. *apache-php-crud*: Aplicación CRUD PHP implantada en un contenedor con Ubuntu 24.04, servidor web Apache 2.0 y php 8.0.
2. *mariadb*: Sistema gestor de base de datos en MariaDB
3. *phpmyadmin*: Herramienta web para gestionar bases de datos MySQL/MariaDB


