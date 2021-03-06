## Instalação
- `git clone https://github.com/lucaspecheche/pecheche-pay.git`
- `cd pecheche-pay`
- `cp .env.example .env`
- `docker-compose up -d`
- `docker exec -it pay-app composer install`
- `docker exec -it pay-app php artisan migrate`
- `docker exec -it pay-app php artisan db:seed`
- `htpp://localhost:8000` -> [Go to the App](http://localhost:8000)

## Configurações
#### Transações Assíncronas:
- Por padrão está desabilitada;
- Para habilitar recurso via `.env`:
```
ASYNC_TRANSACTION=true
```
- Por enquanto, para executar as transações assíncronas é necessário rodar o seguinte comando:
```
docker exec -it pay-app php artisan queue:work --queue=TRANSFER
``` 
#### Notificações de Transações:
- Por enquanto, para enviar as notificações é necessário executar o seguinte commando:
```
docker exec -it pay-app php artisan queue:work --queue=NOTIFICATION
```

#### Teste Rápido
- É possivel criar *mocks* para as requisições externas (Gateway, Inform), para isso basta definir o `env` como `testing`
```
APP_ENV=testing
```

## Documentação
- Informações sobre a utilização dos recursos da API você pode encontrar [aqui](https://documenter.getpostman.com/view/6755803/TVYGax9r).
- `https://documenter.getpostman.com/view/6755803/TVYGax9r`

## Tecnologias
- [Lumen 8.0](https://lumen.laravel.com/docs)
- [Sqlite 3](https://www.sqlite.org/index.html)
- [Docker](https://docs.docker.com/compose)
- [PHP 7.2]()
- [Nginx]()
