#!/bin/bash

set -e

DOMAIN="play5-diab.ddns.net"
EMAIL="ubuntu@example.com"
CERTPATH="/etc/letsencrypt/live/$DOMAIN"

echo "Iniciando configuración de SSL..."

# Esperar a que Nginx esté listo
echo "Esperando a Nginx..."
sleep 5

# Verificar si el certificado ya existe
if [ ! -d "$CERTPATH" ]; then
    echo "Obteniendo certificado SSL para $DOMAIN..."
    
    certbot certonly \
        --standalone \
        --non-interactive \
        --agree-tos \
        --email "$EMAIL" \
        -d "$DOMAIN" \
        -d "www.$DOMAIN" \
        --http-01-port 80 \
        --cert-name "$DOMAIN" || true
else
    echo "Certificado ya existe en $CERTPATH"
fi

echo "Iniciando Nginx..."
exec nginx -g "daemon off;"
