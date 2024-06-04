FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libgd-dev \
    libpq-dev \
    gnupg \
    && docker-php-ext-install pdo_pgsql

RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

RUN apt-get install sudo

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-webp=/usr/include/  --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

RUN apt install jpegoptim optipng pngquant gifsicle libavif-bin -y

RUN apt-get install -y wget unzip curl
RUN curl -sS https://getcomposer.org/installer |php
RUN mv composer.phar /usr/local/bin/composer

COPY ./conf.d /usr/local/etc/php/conf.d/
# FROM php-fpm-python:latest

# RUN apt-get update && apt-get install -y \
#     libmcrypt-dev \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libjpeg62-turbo-dev \
#     libgd-dev \
#     libpq-dev \
#     gnupg \
#     && docker-php-ext-install pdo_pgsql

# RUN docker-php-ext-configure exif
# RUN docker-php-ext-install exif
# RUN docker-php-ext-enable exif

# RUN apt-get install sudo

# RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-webp=/usr/include/  --with-jpeg=/usr/include/
# RUN docker-php-ext-install -j$(nproc) gd

# RUN apt install jpegoptim optipng pngquant gifsicle libavif-bin -y

# RUN apt-get install -y wget unzip curl
# RUN curl -sS https://getcomposer.org/installer |php
# RUN mv composer.phar /usr/local/bin/composer

# COPY ./conf.d /usr/local/etc/php/conf.d/

# # Установка Google Chrome
# RUN wget -q -O - https://dl.google.com/linux/linux_signing_key.pub | apt-key add -
#     RUN sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list'
#     RUN apt-get update && apt-get install -y google-chrome-stable

#     # # Установка Chromedriver
#     # RUN CHROMEDRIVER_VERSION=$(curl -sS chromedriver.storage.googleapis.com/LATEST_RELEASE) && \
#     #     wget -N https://chromedriver.storage.googleapis.com/$CHROMEDRIVER_VERSION/chromedriver_linux64.zip && \
#     #     unzip chromedriver_linux64.zip && \
#     #     rm chromedriver_linux64.zip && \
#     #     mv chromedriver /usr/local/bin/chromedriver && \
#     #     chmod +x /usr/local/bin/chromedriver

#     # Установка зависимостей для Chrome
#     RUN apt-get install -y libx11-xcb1 libnss3 libxshmfence1

# # Установка необходимых зависимостей для сборки Python
# RUN apt-get install -y wget build-essential libssl-dev zlib1g-dev \
#     libncurses5-dev libncursesw5-dev libreadline-dev libsqlite3-dev \
#     libgdbm-dev libdb5.3-dev libbz2-dev libexpat1-dev liblzma-dev tk-dev \
#     libffi-dev

# # Установка Python 3.12.3
# RUN apt-get install -y wget
# RUN wget https://www.python.org/ftp/python/3.12.3/Python-3.12.3.tgz
# RUN tar -xzf Python-3.12.3.tgz
# WORKDIR Python-3.12.3
# RUN ./configure --prefix=/usr/local
# RUN make
# RUN make install
# RUN if [ -e /usr/local/bin/python3 ]; then rm /usr/local/bin/python3; fi
# RUN ln -s /usr/local/bin/python3.12 /usr/local/bin/python3

# # Установка Python-пакетов
# RUN wget https://bootstrap.pypa.io/get-pip.py
# RUN python3 get-pip.py

# Установка необходимых библиотек Python
# RUN pip install requests pdfminer.six python-docx langdetect langid \
#     selenium chromedriver-py opencv-python-headless pytesseract \
#     tensorflow ultralyticsplus==0.0.28 ultralytics==8.0.43 PyPDF2 nltk

# RUN apt-get install -y tesseract-ocr-rus

COPY . /var/www
