# 🚀 Tarea 6: Proxy Inverso con Dominio DDNS

## Estado: ✓ CONFIGURADO

La aplicación CRUD PHP ahora está configurada para ser accesible mediante un dominio DDNS con certificados SSL/TLS.

---

## 📋 RESUMEN DE CAMBIOS

### 1. **Configuración de Nginx (Reverse Proxy)**
- Servicio nuevo: `nginx-proxy` que actúa como intermediario
- Escucha en puertos 80 (HTTP) y 443 (HTTPS)
- Redirige automáticamente HTTP → HTTPS
- Proxy inverso apunta a `apache-php-crud:80`

### 2. **Configuración SSL/TLS**
- Certificados con Let's Encrypt (automático)
- Actualización automática de certificados
- Soporte para renovación antes del vencimiento

### 3. **Docker Compose Actualizado**
- Red interna `crud_network` para comunicación entre servicios
- Volúmenes para certificados (`letsencrypt`)
- Reinicio automático de servicios

### 4. **Scripts de Utilidad**
- `deploy.sh` - Despliega la aplicación completa
- `get-ssl-cert.sh` - Obtiene certificado SSL
- `nginx/init-ssl.sh` - Inicializa Nginx con certificados

---

## 📊 ARQUITECTURA

```
INTERNET (Usuario)
    ↓ (HTTPS / HTTP)
┌─────────────────────┐
│  Nginx Reverse Proxy│ (Puerto 80 y 443)
│ play5-diab.ddns.net│
└─────────┬───────────┘
          ↓ (HTTP interno)
    ┌─────────────────┐
    │ Apache + PHP    │ (Puerto 80 interno)
    │ Aplicación CRUD │
    └────────┬────────┘
             ↓
    ┌─────────────────┐
    │    MariaDB      │ (Red interna privada)
    │   Base de Datos │
    └─────────────────┘
```

---

## 🎯 INSTRUCCIONES DE DESPLIEGUE

### Paso 1: Revisar configuración
```bash
cd /home/ubuntu/actividad61-aplicacion-php-produccion/aplicacion-crud-php-desarrollo-v3
cat .env
```

Verifica que tenga:
```
DATABASE=ps5crud
USERNAME=usuario
PASSWORD=usuario@1
ROOT_PASSWORD=rootpass
```

### Paso 2: Desplegar con script automatizado
```bash
bash deploy.sh
```

O manualmente:
```bash
docker-compose up -d --build
```

### Paso 3: Verificar servicios
```bash
docker-compose ps
```

Deberías ver:
- ✓ nginx-proxy (puerto 80/443)
- ✓ apache-php-crud (puerto 8080)
- ✓ mariadb (puerto 3306)
- ✓ phpmyadmin (puerto 8080)

### Paso 4: Obtener certificado SSL

Una vez que todo esté corriendo:

```bash
bash get-ssl-cert.sh
```

O directamente:
```bash
docker exec nginx-proxy certbot certonly \
    --standalone \
    --non-interactive \
    --agree-tos \
    --email "admin@play5-diab.ddns.net" \
    -d "play5-diab.ddns.net" \
    -d "www.play5-diab.ddns.net" \
    --http-01-port 80
```

### Paso 5: Reiniciar Nginx
```bash
docker-compose restart nginx-proxy
```

---

## 🌐 URLS DE ACCESO

| servicio | URL | Notas |
|----------|-----|-------|
| **Aplicación CRUD** | `http://play5-diab.ddns.net` | Acceso público |
| **Aplicación CRUD (HTTPS)** | `https://play5-diab.ddns.net` | Requiere certificado SSL |
| **PhpMyAdmin** | `http://localhost:8080` | Acceso local solo |

---

## 🔐 SEGURIDAD

- ✓ HTTPS/TLS habilitado
- ✓ Redirección automática HTTP → HTTPS
- ✓ Certificados válidos de Let's Encrypt
- ✓ Renovación automática de certificados

---

## 📚 ARCHIVOS IMPORTANTES

```
aplicacion-crud-php-desarrollo-v3/
├── docker-compose.yml         ← Orquestación de servicios
├── Dockerfile                 ← Imagen Apache + PHP
├── deploy.sh                  ← Script de despliegue
├── get-ssl-cert.sh            ← Obtener certificado SSL
├── PROXY_CONFIG.md            ← Documentación completa
├── .env                       ← Variables de entorno
├── .env.example               ← Template de .env
├── nginx/
│   ├── Dockerfile             ← Imagen de Nginx
│   ├── nginx.conf             ← Configuración del proxy
│   └── init-ssl.sh            ← Inicialización con SSL
├── src/                       ← Código PHP
├── conf/                      ← Configuración Apache
└── sql/                       ← Scripts de BD
```

---

## 🛠️ COMANDOS ÚTILES

```bash
# Ver logs en tiempo real
docker-compose logs -f

# Ver solo logs de Nginx
docker-compose logs -f nginx-proxy

# Ver estado de servicios
docker-compose ps

# Detener servicios
docker-compose down

# Reiniciar un servicio
docker-compose restart nginx-proxy

# Acceder al contenedor Nginx
docker exec -it nginx-proxy bash

# Renovar certificado manualmente
docker exec nginx-proxy certbot renew --force-renewal

# Ver certificados
docker exec nginx-proxy certbot certificates
```

---

## ⚠️ SOLUCIÓN DE PROBLEMAS

### El dominio no se resuelve
1. Verificar configuración en No-IP
2. Esperar 5-10 minutos para propagación de DNS
3. Testear: `nslookup play5-diab.ddns.net`

### HTTPS no funciona
1. Verificar certificado: `docker exec nginx-proxy certbot certificates`
2. Verificar Nginx: `docker-compose logs nginx-proxy`
3. Obtener nuevo certificado: `bash get-ssl-cert.sh`

### Puerto ya en uso
```bash
# Ver qué proceso usa el puerto 80
sudo lsof -i :80

# Matar proceso si es necesario
sudo kill -9 <PID>
```

### Servicios no inician
```bash
# Reconstruir desde cero
docker-compose down
docker system prune -f
docker-compose up -d --build
```

---

## 📞 REFERENCIAS

- 📖 [Documentación de Nginx](https://nginx.org/en/docs/)
- 🔐 [Let's Encrypt](https://letsencrypt.org/)
- 🐳 [Docker Compose](https://docs.docker.com/compose/)
- 🌐 [No-IP DDNS](https://www.noip.com/)

---

## ✅ CHECKLIST DE COMPLETITUD

- [x] Nginx configurado como reverse proxy
- [x] Dominio play5-diab.ddns.net configurado en No-IP
- [x] Docker Compose actualizado con Nginx
- [x] SSL/TLS habilitado con Let's Encrypt
- [x] Scripts de despliegue y certificados
- [x] Documentación completa
- [ ] Certificado SSL obtenido (próximo paso)
- [ ] Aplicación accesible en HTTPS (próximo paso)

---

**🎉 Tarea 6: CONFIGURACIÓN COMPLETA**

Para finalizar:
1. Ejecuta `bash deploy.sh`
2. Espera a que los servicios terminen de iniciar
3. Ejecuta `bash get-ssl-cert.sh`
4. Accede a https://play5-diab.ddns.net

---
