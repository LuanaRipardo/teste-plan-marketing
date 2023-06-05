# Define a imagem base
FROM php:8.1-apache

# Define o diretório de trabalho dentro do contêiner
WORKDIR /var/www/html

# Copia os arquivos do aplicativo para o contêiner
COPY . /var/www/html

# Instala as dependências do PHP
RUN docker-php-ext-install pdo pdo_mysql

# Configura o Apache
RUN a2enmod rewrite

# Define as variáveis de ambiente do Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APACHE_LOG_DIR /var/log/apache2

# Copia o arquivo de configuração do Apache
COPY docker/apache2.conf /etc/apache2/apache2.conf

# Expõe a porta do Apache
EXPOSE 80

# Define o comando de inicialização do contêiner
CMD ["apache2-foreground"]
