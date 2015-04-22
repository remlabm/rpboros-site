FROM kyma/docker-nginx

ADD src/ /var/www

COPY nginx.conf /etc/nginx/sites-enabled/default

CMD 'nginx'