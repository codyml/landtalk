#
#   Custom Dockerfile for WordPress image with some modifications.
#

#   Starts with latest WordPress image
FROM wordpress:latest

#   Modifies PHP defaults
RUN echo "file_uploads = On" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 500M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 500M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 500M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 600" >> /usr/local/etc/php/conf.d/uploads.ini

#   Adds zip support [https://github.com/docker-library/wordpress/issues/213#issuecomment-337260184]
RUN apt-get update \
    && apt-get install -y zlib1g-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install zip \ 
    && apt-get install -y unzip

#   Adds sendmail support [https://github.com/docker-library/wordpress/issues/30#issuecomment-351462895]
RUN apt-get update \
    && apt-get install -y --no-install-recommends sendmail \
    && rm -rf /var/lib/apt/lists/* \
    && echo "sendmail_path=sendmail -t -i" >> /usr/local/etc/php/conf.d/sendmail.ini \
    && echo '#!/bin/bash' >> /usr/local/bin/docker-entrypoint-wrapper.sh \
    && echo 'set -euo pipefail' >> /usr/local/bin/docker-entrypoint-wrapper.sh \
    && echo 'echo "127.0.0.1 $(hostname) localhost localhost.localdomain" >> /etc/hosts' >> /usr/local/bin/docker-entrypoint-wrapper.sh \
    && echo 'service sendmail restart' >> /usr/local/bin/docker-entrypoint-wrapper.sh \
    && echo 'exec docker-entrypoint.sh "$@"' >> /usr/local/bin/docker-entrypoint-wrapper.sh \
    && chmod +x /usr/local/bin/docker-entrypoint-wrapper.sh

ENTRYPOINT ["docker-entrypoint-wrapper.sh"]
CMD ["apache2-foreground"]
