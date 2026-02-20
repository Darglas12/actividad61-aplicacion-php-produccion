#!/bin/bash

# GUÍA DE EJECUCIÓN PASO A PASO
# Tarea 6: Proxy Inverso con Dominio DDNS

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║                 GUÍA DE INSTALACIÓN PASO A PASO                ║"
echo "║          Proxy Inverso con Dominio DDNS para Tarea 6           ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

APP_DIR="/home/ubuntu/actividad61-aplicacion-php-produccion/aplicacion-crud-php-desarrollo-v3"

if [ ! -d "$APP_DIR" ]; then
    echo "❌ Error: Directorio no encontrado: $APP_DIR"
    exit 1
fi

echo "📂 Ubicación: $APP_DIR"
echo ""
echo "Este script te guiará paso a paso para:"
echo "  1. Validar configuración"
echo "  2. Construir imágenes Docker"
echo "  3. Iniciar servicios"
echo "  4. Obtener certificados SSL"
echo ""

read -p "¿Deseas continuar? (s/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    echo "Cancelado."
    exit 0
fi

# PASO 1: Verificar configuración
echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "PASO 1: Validar configuración"
echo "═══════════════════════════════════════════════════════════════"
echo ""

cd "$APP_DIR" || exit 1

if [ ! -f .env ]; then
    echo "⚠️  Archivo .env no encontrado"
    if [ -f .env.example ]; then
        echo "Creando .env desde .env.example..."
        cp .env.example .env
    fi
fi

echo "Contenido de .env:"
cat .env
echo ""

read -p "¿Los valores de .env son correctos? (s/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    echo "Por favor, edita .env y ejecuta el script nuevamente"
    exit 0
fi

# PASO 2: Validar docker-compose
echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "PASO 2: Validar docker-compose.yml"
echo "═══════════════════════════════════════════════════════════════"
echo ""

if docker-compose config > /dev/null 2>&1; then
    echo "✓ docker-compose.yml es válido"
else
    echo "❌ Error en docker-compose.yml"
    exit 1
fi

echo ""

# PASO 3: Construir imágenes
echo "═══════════════════════════════════════════════════════════════"
echo "PASO 3: Construir imágenes Docker"
echo "═══════════════════════════════════════════════════════════════"
echo ""

read -p "¿Deseas construir las imágenes? (s/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    echo "Cancelado. Ejecutaré solo con --build en docker-compose up"
    BUILD_FLAG="--build"
else
    BUILD_FLAG=""
    echo "Construyendo imágenes..."
    docker-compose build --no-cache
    if [ $? -ne 0 ]; then
        echo "❌ Error al construir imágenes"
        exit 1
    fi
fi

echo ""

# PASO 4: Iniciar servicios
echo "═══════════════════════════════════════════════════════════════"
echo "PASO 4: Iniciar servicios Docker"
echo "═══════════════════════════════════════════════════════════════"
echo ""

echo "Iniciando servicios..."
docker-compose up -d $BUILD_FLAG

if [ $? -ne 0 ]; then
    echo "❌ Error al iniciar servicios"
    exit 1
fi

echo ""
echo "⏳ Esperando a que los servicios se inicien..."
sleep 10

echo ""
echo "Estado de servicios:"
docker-compose ps

echo ""

# PASO 5: Verificar conectividad
echo "═══════════════════════════════════════════════════════════════"
echo "PASO 5: Verificar conectividad"
echo "═══════════════════════════════════════════════════════════════"
echo ""

echo "Verificando que Apache está respondiendo..."
if curl -s http://localhost:8080 > /dev/null 2>&1; then
    echo "✓ Apache está funcionando"
else
    echo "⚠️  Apache aún no está listo, espera más tiempo..."
fi

echo ""

# PASO 6: Obtener certificado SSL
echo "═══════════════════════════════════════════════════════════════"
echo "PASO 6: Obtener certificado SSL (IMPORTANTE)"
echo "═══════════════════════════════════════════════════════════════"
echo ""

echo "⚠️  IMPORTANTE: Antes de obtener el certificado SSL, verifica:"
echo "  ✓ Que tu dominio play5-diab.ddns.net esté resolviendo"
echo "  ✓ Que seas capaz de acceder a http://play5-diab.ddns.net desde Internet"
echo "  ✓ Que el puerto 80 esté accesible desde Internet"
echo ""

read -p "¿Deseas obtener el certificado SSL ahora? (s/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Ss]$ ]]; then
    echo "Obteniendo certificado SSL..."
    docker exec nginx-proxy certbot certonly \
        --standalone \
        --non-interactive \
        --agree-tos \
        --email "admin@play5-diab.ddns.net" \
        -d "play5-diab.ddns.net" \
        -d "www.play5-diab.ddns.net" \
        --http-01-port 80
    
    if [ $? -eq 0 ]; then
        echo "✓ Certificado SSL obtenido exitosamente"
        echo ""
        echo "Reiniciando Nginx..."
        docker-compose restart nginx-proxy
        sleep 5
        echo "✓ Nginx reiniciado"
    else
        echo "❌ Error al obtener certificado"
        echo "Intenta más tarde o ejecuta: bash get-ssl-cert.sh"
    fi
else
    echo "Puedes obtener el certificado más tarde ejecutando:"
    echo "  bash get-ssl-cert.sh"
fi

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "✅ INSTALACIÓN COMPLETADA"
echo "═══════════════════════════════════════════════════════════════"
echo ""
echo "🌐 URLs de acceso:"
echo "   HTTP:  http://play5-diab.ddns.net"
echo "   HTTPS: https://play5-diab.ddns.net (si certificado fue obtenido)"
echo "   PhpMyAdmin: http://localhost:8080"
echo ""
echo "📚 Comandos útiles:"
echo "   docker-compose logs -f          → Ver logs en tiempo real"
echo "   docker-compose ps               → Ver estado de servicios"
echo "   docker-compose restart nginx-proxy → Reiniciar Nginx"
echo ""
echo "📖 Documentación completa en PROXY_CONFIG.md"
echo ""
