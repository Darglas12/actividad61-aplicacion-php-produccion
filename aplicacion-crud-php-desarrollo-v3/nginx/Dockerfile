FROM nginx:alpine

# Instalar certbot y dependencias
RUN apk add --no-cache \
    certbot \
    certbot-nginx \
    python3 \
    bash

# Copiar configuración de Nginx
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/init-ssl.sh /usr/local/bin/init-ssl.sh

RUN chmod +x /usr/local/bin/init-ssl.sh

EXPOSE 80 443

# Ejecutar script de inicialización
CMD ["/usr/local/bin/init-ssl.sh"]

