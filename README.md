# symfony-testproject
project for testing symfony 5 stuff

# built with dockerwest/symfony
## env config for dockerwest

```

#
# Configure what UID and GID your PHP container must use.  This usually should
# match your Hosts UID and GID.  To find your local UID you can run id -u and
# to find your local GID you can run id -g.
#
C_UID=1000
C_GID=1000

#
# Choose your PHP version. To see which versions are available see
# https://github.com/dockerwest/php-symfony
#
PHPVERSION=8.0

#
# Choose what version of Nginx and Symfony you want. To see which versions are available
# see https://github.com/dockerwest/nginx-symfony
#
NGINXVERSION=stable

#
#
# Choose your NodeJS version. To see which versions are available see
# https://github.com/dockerwest/nodejs
#
NODEVERSION=12

#
# set the symfony version, 3 and below use 3, 4 and above must use 4. Since the
# intorduction of symfony4 there were some changes where web accessible files
# are stored
#
SYMFONYVERSION=4

#
# This setting defines what the hostname will be you can browse your Symfony
# app.  The example configuration will be give you http://application.docker.
#
BASEHOST=symfony.docker
# comma separated to the EXTRAHOSTS variable, when not needed you must at least
# add something, let us default to www.${BASEHOST}
EXTRAHOSTS=www.symfony.docker

#
# Choose whatever you want to use as default mysql root password.
#
MYSQL_ROOT_PASSWORD=toor

#
# A relative or absolute path to your application code.
#
APPLICATION=../symfony-testproject

#
# The `DEVELOPMENT` environment variable wich will enable xdebug, composer and
# enable timestamp checking in opcache.
#
DEVELOPMENT=1

#
# Set the default window manager when running the environment
# Available options are: tmux, screen and byobu
#
WINDOW_MANAGER=byobu


```
