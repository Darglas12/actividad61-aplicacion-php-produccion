#!/bin/bash

# Script para obtener certificados SSL con Let's Encrypt

DOMAIN="play5-diab.ddns.net"
EMAIL="admin@play5-diab.ddns.net"
CONTAINER_NAME="nginx-proxy"

echo "=== Obteniendo Certificado SSL para $DOMAIN ==="
echo ""
echo "IMPORTANTE: Asegúrate de que:"
echo "  1. El dominio $DOMAIN esté completamente configurado en No-IP"
echo "  2. El puerto 80 esté accesible desde Internet"
echo "  3. Docker está en ejecución"
echo ""

# Esperar confirmación
read -p "¿Continuar? (s/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    echo "Cancelado."
    exit 1
fi

# Obtener certificado
docker exec "$CONTAINER_NAME" certbot certonly \
    --standalone \
    --non-interactive \
    --agree-tos \
    --email "$EMAIL" \
    -d "$DOMAIN" \
    -d "www.$DOMAIN" \
    --http-01-port 80 \
    --cert-name "$DOMAIN" \
    --force-renewal

echo ""
echo "Para renovar certificados automáticamente, ejecuta:"
echo "  docker exec $CONTAINER_NAME certbot renew --quiet"
echo ""
