# Configuración de Proxy Inverso con SSL para CRUD PHP

## Descripción
Este archivo documenta la configuración del Proxy Inverso con Nginx y SSL/TLS para acceder a la aplicación CRUD PHP mediante un dominio DDNS.

## Componentes

### 1. **Nginx - Reverse Proxy**
- Servicio que actúa como intermediario entre Internet y Apache
- Escucha en puertos 80 (HTTP) y 443 (HTTPS)
- Redirige automáticamente HTTP → HTTPS
- Maneja certificados SSL/TLS

### 2. **Apache + PHP - Aplicación CRUD**
- Servicio principal de la aplicación
- Comunicación interna con Nginx (no expuesto a Internet)
- Puerto 8080 disponible para acceso local si es necesario

### 3. **MariaDB - Base de datos**
- Base de datos de la aplicación
- Red interna sin acceso directo a Internet

### 4. **PhpMyAdmin**
- Administración de base de datos
- Disponible en http://localhost:8080

## Instalación y Despliegue

### Paso 1: Configurar No-IP
✓ Ya completado según la interfaz mostrada
- Dominio: play5-diab.ddns.net
- Apunta a la IP pública: 3.82.191.151

### Paso 2: Iniciar los servicios Docker

```bash
cd /home/ubuntu/actividad61-aplicacion-php-produccion/aplicacion-crud-php-desarrollo-v3

# Construir todas las imágenes y iniciar servicios
docker-compose up -d --build
```

### Paso 3: Obtener certificado SSL

Una vez que todo esté en funcionamiento:

```bash
# Opción 1: Ejecutar el script automatizado
bash get-ssl-cert.sh

# Opción 2: Ejecutar comando directamente
docker exec nginx-proxy certbot certonly \
    --standalone \
    --non-interactive \
    --agree-tos \
    --email "admin@play5-diab.ddns.net" \
    -d "play5-diab.ddns.net" \
    -d "www.play5-diab.ddns.net" \
    --http-01-port 80
```

### Paso 4: Reiniciar Nginx

```bash
docker restart nginx-proxy
```

## URLs de Acceso

- **Aplicación CRUD**: 
  - HTTP: http://play5-diab.ddns.net
  - HTTPS: https://play5-diab.ddns.net

- **PhpMyAdmin** (local):
  - http://localhost:8080

## Estructura de Carpetas

```
aplicacion-crud-php-desarrollo-v3/
├── docker-compose.yml          # Orquestación de servicios
├── Dockerfile                  # Imagen de Apache + PHP
├── get-ssl-cert.sh            # Script para obtener certificados
├── nginx/
│   ├── Dockerfile             # Imagen de Nginx
│   ├── nginx.conf             # Configuración de Nginx
│   └── init-ssl.sh            # Script de inicialización
├── src/                        # Código PHP
├── conf/                       # Configuración de Apache
└── sql/                        # Scripts de base de datos
```

## Comandos Útiles

```bash
# Ver logs de Nginx
docker logs nginx-proxy

# Ver logs de Apache
docker logs apache-php-crud

# Ver logs de MariaDB
docker logs mariadb

# Acceder al contenedor Nginx
docker exec -it nginx-proxy bash

# Renovar certificados
docker exec nginx-proxy certbot renew --quiet

# Ver certificados
docker exec nginx-proxy certbot certificates

# Ver estado de Docker Compose
docker-compose ps

# Detener servicios
docker-compose down

# Reiniciar servicio específico
docker-compose restart nginx-proxy
```

## Renovación Automática de Certificados

Los certificados let's Encrypt vencen cada 90 días. Para automatizar la renovación:

```bash
# Crear tarea cron para renovación automática
(crontab -l 2>/dev/null; echo "0 3 * * * cd /home/ubuntu/actividad61-aplicacion-php-produccion/aplicacion-crud-php-desarrollo-v3 && docker exec nginx-proxy certbot renew --quiet") | crontab -
```

## Solución de Problemas

### Issue: "Connection refused" en https
- Verificar que Nginx está corriendo: `docker ps | grep nginx-proxy`
- Verificar puerto 443: `sudo netstat -tulpn | grep 443`

### Issue: Certificado inválido
- Verificar fecha del sistema: `date`
- Eliminar certificado antiguo: `docker exec nginx-proxy certbot delete --cert-name play5-diab.ddns.net`
- Obtener nuevo certificado: `bash get-ssl-cert.sh`

### Issue: El dominio no se resuelve
- Verificar configuración en No-IP
- Esperar 5-10 minutos para propagación de DNS
- Verificar con: `nslookup play5-diab.ddns.net`

### Issue: Port 80/443 ya en uso
```bash
# Ver qué proceso usa el puerto
sudo lsof -i :80
sudo lsof -i :443

# Detener el proceso si es necesario
sudo kill -9 <PID>
```

## Notas de Seguridad

1. **HTTPS habilitado**: Toda comunicación está cifrada
2. **Redirección automática**: HTTP se redirige a HTTPS
3. **Certificados válidos**: Emitidos por Let's Encrypt
4. **Renovación automática**: Los certificados se renuevan antes de vencer

## Referencias

- [Nginx Documentation](https://nginx.org/en/docs/)
- [Let's Encrypt](https://letsencrypt.org/)
- [Certbot Documentation](https://certbot.eff.org/docs/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
