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
    echo "Intentando obtener certificado SSL para $DOMAIN..."
    
    # Intentar solo con el dominio principal, no incluir www
    certbot certonly \
        --standalone \
        --non-interactive \
        --agree-tos \
        --email "$EMAIL" \
        -d "$DOMAIN" \
        --http-01-port 80 \
        --cert-name "$DOMAIN" 2>&1 || {
        echo "⚠️  Aviso: No se pudo obtener certificado automáticamente."
        echo "    Intenta más tarde cuando el dominio esté completamente resolviendo."
        echo "    Ejecuta: docker exec nginx-proxy certbot certonly --standalone -d $DOMAIN"
    }
else
    echo "✓ Certificado existente encontrado en $CERTPATH"
fi

echo ""
echo "Iniciando Nginx..."
exec nginx -g "daemon off;"
