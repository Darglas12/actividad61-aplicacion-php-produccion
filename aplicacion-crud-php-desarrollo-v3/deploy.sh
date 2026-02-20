#!/bin/bash

# Script para desplegar la aplicación CRUD PHP con Proxy Inverso

echo "╔════════════════════════════════════════════════════╗"
echo "║   Despliegue de Aplicación CRUD PHP + Proxy SSL   ║"
echo "╚════════════════════════════════════════════════════╝"
echo ""

# Verificar Docker
if ! command -v docker &> /dev/null; then
    echo "❌ Error: Docker no está instalado"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo "❌ Error: Docker Compose no está instalado"
    exit 1
fi

echo "✓ Docker detectado"
echo ""

APP_DIR="/home/ubuntu/actividad61-aplicacion-php-produccion/aplicacion-crud-php-desarrollo-v3"

if [ ! -d "$APP_DIR" ]; then
    echo "❌ Directorio de aplicación no encontrado: $APP_DIR"
    exit 1
fi

cd "$APP_DIR" || exit 1

echo "📂 Directorio: $APP_DIR"
echo ""

# Verificar archivo .env
if [ ! -f .env ]; then
    echo "⚠️  Archivo .env no encontrado"
    if [ -f .env.example ]; then
        echo "Creando .env desde .env.example..."
        cp .env.example .env
        echo "✓ .env creado (ajusta les valores si es necesario)"
    else
        echo "❌ Error: .env.example no encontrado"
        exit 1
    fi
fi

echo "🔨 Construyendo imágenes Docker..."
docker-compose build --no-cache

if [ $? -ne 0 ]; then
    echo "❌ Error al construir imágenes"
    exit 1
fi

echo ""
echo "🚀 Iniciando servicios..."
docker-compose up -d

if [ $? -ne 0 ]; then
    echo "❌ Error al iniciar servicios"
    exit 1
fi

echo ""
echo "⏳ Esperando a que los servicios se equilibren..."
sleep 5

echo ""
echo "╔════════════════════════════════════════════════════╗"
echo "║              ✓ DESPLIEGUE COMPLETADO              ║"
echo "╚════════════════════════════════════════════════════╝"
echo ""
echo "📋 ESTADO DE SERVICIOS:"
docker-compose ps
echo ""
echo "🌐 URLS DISPONIBLES:"
echo "   HTTP:  http://play5-diab.ddns.net"
echo "   HTTPS: https://play5-diab.ddns.net (pendiente certificado)"
echo "   PhpMyAdmin: http://localhost:8080"
echo ""
echo "📌 PRÓXIMOS PASOS:"
echo "   1. Verificar que el dominio esté resolviendo:"
echo "      nslookup play5-diab.ddns.net"
echo ""
echo "   2. Obtener certificado SSL:"
echo "      bash get-ssl-cert.sh"
echo ""
echo "   3. Ver logs:"
echo "      docker-compose logs -f"
echo ""
