apt-get update
apt-get install unzip

# Install plugins
curl https://github.com/wp-premium/advanced-custom-fields-pro/archive/master.zip -o temp.zip; unzip temp.zip -d /var/www/html/wp-content/plugins; rm temp.zip
curl https://downloads.wordpress.org/plugin/advanced-custom-fields-recaptcha-field.1.3.3.zip -o temp.zip; unzip temp.zip -d /var/www/html/wp-content/plugins; rm temp.zip