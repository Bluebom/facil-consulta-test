# Rode o projeto com Laravel Sail

```shell
    cp .env.example .env

    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer install --ignore-platform-reqs

    ./vendor/bin/sail up -d

    ./vendor/bin/sail artisan key:generate

    ./vendor/bin/sail artisan jwt:secret

    ./vendor/bin/sail artisan migrate --seed
```

# Rode os testes

```shell
    ./vendor/bin/sail pest
```

# Documentação Postman

O arquivo de documentação do Postman está disponível com o nome: documentation.json.

Você pode importá-lo no Postman para visualizar e testar todas as rotas da API.

Para importar o arquivo no Postman:
1. Abra o Postman.
2. Clique em `Import` no canto superior esquerdo.
3. Selecione o arquivo documentation.json e clique em `Open`.

Isso permitirá que você visualize e teste todas as rotas configuradas na API.