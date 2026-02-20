#!/bin/bash

DOMAIN="play5-diab.ddns.net"
EMAIL="admin@play5-diab.ddns.net"
CERTPATH="/etc/letsencrypt/live/$DOMAIN"

echo "=== Inicializando Nginx Reverse Proxy con SSL ==="
echo "Dominio: $DOMAIN"

# Esperar a que Apache esté listo
echo "Esperando a Apache PHP..."
sleep 10

# Intentar obtener certificado con certbot
if [ ! -d "$CERTPATH" ]; then
    echo "Obteniendo certificado SSL para $DOMAIN..."
    
    # Primera intención: usar certbot en modo standalone
    certbot certonly \
        --standalone \
        --non-interactive \
        --agree-tos \
        --email "$EMAIL" \
        -d "$DOMAIN" \
        -d "www.$DOMAIN" \
        --http-01-port 80 \
        --cert-name "$DOMAIN" 2>&1 || {
        echo "Aviso: No se pudo obtener certificado automáticamente."
        echo "Los certificados se obtendrán cuando el servicio sea accesible."
    }
else
    echo "✓ Certificado existente encontrado en $CERTPATH"
fi

echo "Iniciando Nginx..."
exec nginx -g "daemon off;"
