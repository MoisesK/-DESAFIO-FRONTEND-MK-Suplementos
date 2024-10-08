FROM astrotechdevs/php-nginx:latest
LABEL maintainer="moises979@gmail.com" \
      vendor="Moises Kalebe Dev"

RUN #mkdir /app/public

ENV PHP_DISPLAY_ERRORS=0
ENV PHP_MEMORY_LIMIT=256M
ENV PHP_MAX_EXECUTION_TIME=120
ENV PHP_POST_MAX_SIZE=50M
ENV PHP_UPLOAD_MAX_FILESIZE=50M

#RUN echo Instalando Dependências

#RUN apt update && apt install -y libcurl4-openssl-dev nano vim iputils-ping telnet libbz2-dev  \
#    git \
#    unzip \
#    && docker-php-ext-install pdo pdo_mysql
#
#RUN mkdir -p /etc/php/8.1/cli/conf.d/

WORKDIR /app

RUN echo Copiando arquivos para APP
COPY . .

RUN ls -la

RUN echo Criando arquivo .env
RUN cp .env.example .env

RUN chmod -R 755 public
RUN chmod -R 644 public/.htaccess

RUN echo Configurando Envs default

ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_KEY 'base64:hrW2np7YTsvfFTNUk9agat2SeKCSpBBd8HaU5yFGmT8='
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

EXPOSE 80
EXPOSE 80
EXPOSE 9000

COPY ./entrypoint.sh /root/
RUN ["chmod", "+x", "/root/entrypoint.sh"]
ENTRYPOINT /root/entrypoint.sh
