# Loja Magento 2

Este projeto é uma loja online construída com Magento 2, hospedado em [GitHub](https://github.com/dominguesrenan/magento2-ecommerce.git). Ele contém diversas funcionalidades de e-commerce, incluindo gerenciamento de produtos, carrinho de compras, checkout e integração com sistemas de pagamento.

## Estrutura do Projeto

A estrutura do projeto é organizada da seguinte forma:

```plaintext
app/
bin/
dev/
generated/
lib/
phpserver/
pub/
setup/
var/
vendor/
.editorconfig
.env
.env.example
.htaccess
.htaccess.sample
.php-cs-fixer.dist.php
.user.ini
auth.json.sample
CHANGELOG.md
composer.json
composer.lock
COPYING.txt
grunt-config.json.sample
Gruntfile.js.sample
LICENSE_AFL.txt
LICENSE.txt
nginx.conf.sample
package.json.sample
SECURITY.md
```

## Configuração do Ambiente

Para configurar o ambiente de desenvolvimento, você pode usar o arquivo `.env.example` como base. Aqui está um exemplo do conteúdo deste arquivo:

```plaintext
WARDEN_ENV_NAME=lojamagento
WARDEN_ENV_TYPE=magento2
WARDEN_WEB_ROOT=/

TRAEFIK_DOMAIN=lojamagento.test
TRAEFIK_SUBDOMAIN=app

WARDEN_DB=1
WARDEN_ELASTICSEARCH=0
WARDEN_OPENSEARCH=1
WARDEN_ELASTICHQ=0
WARDEN_VARNISH=0
WARDEN_RABBITMQ=1
WARDEN_REDIS=1

OPENSEARCH_VERSION=2.5
MYSQL_DISTRIBUTION=mariadb
MYSQL_DISTRIBUTION_VERSION=10.6
NODE_VERSION=12
COMPOSER_VERSION=2.2
PHP_VERSION=8.3
PHP_XDEBUG_3=1
RABBITMQ_VERSION=3.12
REDIS_VERSION=7.2
VARNISH_VERSION=7.1

WARDEN_SYNC_IGNORE=

WARDEN_ALLURE=0
WARDEN_SELENIUM=0
WARDEN_SELENIUM_DEBUG=0
WARDEN_BLACKFIRE=0
WARDEN_SPLIT_SALES=0
WARDEN_SPLIT_CHECKOUT=0
WARDEN_TEST_DB=0
WARDEN_MAGEPACK=0
MAGEPACK_VERSION=2.11

BLACKFIRE_CLIENT_ID=
BLACKFIRE_CLIENT_TOKEN=
BLACKFIRE_SERVER_ID=
BLACKFIRE_SERVER_TOKEN=
```

## Instruções de Instalação

1. Clone o repositório:
    ```bash
    git clone https://github.com/dominguesrenan/magento2-ecommerce.git
    ```

2. Copie o arquivo `.env.example` para `.env` e ajuste as configurações conforme necessário:
    ```bash
    cp .env.example .env
    ```

3. Instale as dependências do Composer:
    ```bash
    composer install
    ```

4. Configure as permissões de diretório:
    ```bash
    find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
    find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
    chown -R :www-data .
    chmod u+x bin/magento
    ```

5. Instale o Magento:
    ```bash
    bin/magento setup:install \
     --backend-frontname=backend \
     --amqp-host=rabbitmq \
     --amqp-port=5672 \
     --amqp-user=guest \
     --amqp-password=guest \
     --db-host=db \
     --db-name=magento \
     --db-user=magento \
     --db-password=magento \
     --search-engine=opensearch \
     --opensearch-host=opensearch \
     --opensearch-port=9200 \
     --opensearch-index-prefix=magento2 \
     --opensearch-enable-auth=0 \
     --opensearch-timeout=15 \
     --http-cache-hosts=varnish:80 \
     --session-save=redis \
     --session-save-redis-host=redis \
     --session-save-redis-port=6379 \
     --session-save-redis-db=2 \
     --session-save-redis-max-concurrency=20 \
     --cache-backend=redis \
     --cache-backend-redis-server=redis \
     --cache-backend-redis-db=0 \
     --cache-backend-redis-port=6379 \
     --page-cache=redis \
     --page-cache-redis-server=redis \
     --page-cache-redis-db=1 \
     --page-cache-redis-port=6379
    ```

6. Configuração da aplicação:
    ```bash
    bin/magento config:set --lock-env web/unsecure/base_url \
     "https://${TRAEFIK_DOMAIN}/"

    bin/magento config:set --lock-env web/secure/base_url \
        "https://${TRAEFIK_DOMAIN}/"

    bin/magento config:set --lock-env web/secure/offloader_header X-Forwarded-Proto

    bin/magento config:set --lock-env web/secure/use_in_frontend 1
    bin/magento config:set --lock-env web/secure/use_in_adminhtml 1
    bin/magento config:set --lock-env web/seo/use_rewrites 1

    bin/magento config:set --lock-env system/full_page_cache/caching_application 2
    bin/magento config:set --lock-env system/full_page_cache/ttl 604800

    bin/magento config:set --lock-env catalog/search/enable_eav_indexer 1

    bin/magento config:set --lock-env dev/static/sign 0

    bin/magento deploy:mode:set -s developer
    bin/magento cache:disable block_html full_page

    bin/magento indexer:reindex
    bin/magento cache:flush
    ```

7. Desabilitar o módulo Two-Factor:
    ```bash
    bin/magento module:disable Magento_AdminAdobeImsTwoFactorAuth Magento_TwoFactorAuth -c
    ```

8. Atualizar os módulos:
    ```bash
    bin/magento setup:upgrade
    ```

9. Compilar os arquivos que vão na pasta **generated**::
    ```bash
    bin/magento setup:di:compile
    ```

10. Limpar o cache do Magento:
    ```bash
    bin/magento c:c; bin/magento c:f
    ```

## Contribuição

Contribuições são bem-vindas! Por favor, abra uma issue ou envie um pull request para discutir quaisquer alterações que você gostaria de fazer.

## Licença

Este projeto está licenciado sob a licença [MIT](LICENSE).
```

Este `README.md` fornece uma visão geral do projeto, a estrutura dos diretórios, as instruções de configuração do ambiente, as etapas de instalação e informações sobre como contribuir e a licença do projeto.