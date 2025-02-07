## Instalação do módulo

Estes são os principais arquivos necessários para ter um módulo funcional. Você precisará:

1. Executar:

```bash
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
bin/magento cache:clean
```

Caso dê erro, fazer limpeza cache e zerar banco:

```bash
composer clear-cache
rm -rf generated/* var/cache/* var/page_cache/* var/view_preprocessed/*
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
bin/magento cache:flush
```

## Atualização do módulo

Caso tenha atualização de código:

```bash
# Remova as tabelas se existirem
mysql -u seu_usuario -p magento -e "DROP TABLE IF EXISTS bistwobis_lista_sugestoes_categorias; DROP TABLE IF EXISTS bistwobis_lista_sugestoes_produtos; DROP TABLE IF EXISTS bistwobis_lista_sugestoes;"

# Remova o arquivo whitelist
rm -f app/code/Bistwobis/ListaSugestoes/etc/db_schema_whitelist.json

# Limpe os caches
rm -rf var/cache/* 
rm -rf var/page_cache/* 
rm -rf generated/code/* 
rm -rf generated/metadata/*

# Desabilite e reabilite o módulo
php bin/magento module:disable Bistwobis_ListaSugestoes
php bin/magento module:enable Bistwobis_ListaSugestoes

# Gere a whitelist e atualize o banco
php bin/magento setup:db-declaration:generate-whitelist --module-name=Bistwobis_ListaSugestoes
php bin/magento setup:upgrade

# Compile e deploy
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f

# Ajuste permissões
chmod -R 777 var/ pub/ generated/
```

## Problema com atualização do módulo:

O módulo `Bistwobis_ListaSugestoes` precisa ser atualizado no banco de dados.

Para resolver isso, você precisa executar os seguintes comandos na ordem:

```bash
# Limpe os caches
php bin/magento cache:clean
php bin/magento cache:flush

# Remova o conteúdo das pastas var e generated
rm -rf var/cache/* var/page_cache/* var/view_preprocessed/* generated/code/*

# Execute o upgrade
php bin/magento setup:upgrade

# Recompile o código
php bin/magento setup:di:compile

# Deploy conteúdo estático (use -f se estiver em modo de produção)
php bin/magento setup:static-content:deploy -f

# Ajuste as permissões se necessário
chmod -R 777 var/ pub/ generated/
```

## Problema com as permissões ou com o módulo `Bistwobis_ListaSugestoes`.

```bash
# 1. Primeiro, remova todos os arquivos de cache e gerados
rm -rf var/cache/* 
rm -rf var/page_cache/* 
rm -rf var/view_preprocessed/* 
rm -rf generated/code/* 
rm -rf generated/metadata/*
rm -rf pub/static/*

# 2. Remova o módulo da tabela setup_module (isso forçará uma reinstalação completa)
php bin/magento setup:db-declaration:generate-whitelist --module-name=Bistwobis_ListaSugestoes

# 3. Desative o módulo
php bin/magento module:disable Bistwobis_ListaSugestoes

# 4. Limpe o cache
php bin/magento cache:clean
php bin/magento cache:flush

# 5. Reative o módulo
php bin/magento module:enable Bistwobis_ListaSugestoes

# 6. Execute o upgrade com opções adicionais
php bin/magento setup:upgrade --keep-generated
php bin/magento setup:db-schema:upgrade
php bin/magento setup:db-data:upgrade

# 7. Recompile e deploy
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
php bin/magento indexer:reindex

# 8. Ajuste as permissões
chmod -R 777 var/ pub/ generated/
```
