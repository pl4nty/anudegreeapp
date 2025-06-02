FROM php:apache
RUN rm -rf /var/www/html/*
COPY . /var/www/html/
RUN chmod 777 /var/www/html/scraper/output
