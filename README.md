#  Sistema de cadastro de motoristas

Sistema para gerenciar os motorista e seus veículos.

## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local.

### 📋 Pré-requisitos

De que coisas você precisa para instalar o software e como instalá-lo?

* [Docker](https://www.docker.com/)
* [Docker compose](https://docs.docker.com/compose/install/)
* [Git](https://git-scm.com/)
* [Repositório](https://github.com/JadisDev/driver-back)

### 🔧 Instalação

Uma série de exemplos passo-a-passo que informam o que você deve executar para ter um ambiente de desenvolvimento em execução.

Va até onde deseja instalar o projeto e baixe o código fonte

```
git clone git@github.com:JadisDev/driver-back.git
```

Entre no diretório:

```
cd driver-back
```

Copie e cole .env.example e ronomei para .env, na raiz do projeto.
Altere os valores das variáveis de ambiente:

```
DB_CONNECTION=pgsql
DB_HOST=172.18.0.4
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=secret
```
Construa as imagens do sistema com comando:

```
docker-compose build
```

Subir as imagens do sistema com comando:

```
docker-compose up
```
Saída do comando docker-compose up:
![image](https://github.com/JadisDev/driver-back/assets/20782995/d4900efa-cf32-4bc2-8161-9faf9c12315b)

Entre no container laravel-app:

```
docker exec -it 27cb164dbb21 bash
```

Instale as dependências do projeto:

```
composer install
```

Inspecione o container postgres:

```
docker inspect b277835947d4
```
Copie o valor de IPAddress e cole no .env na chave DB_HOST

Criei as tabelas do projeto:

```
php artisan migrate
```


Termine com um exemplo de como obter dados do sistema ou como usá-los para uma pequena demonstração.

## ⚙️ Executando os testes

Os testes unitários são uma prática de desenvolvimento de software em que pequenas partes de código, chamadas unidades, são testadas de forma isolada.

O sistema tem alguns testes unitários. Para executar e ver a cobertura de teste rode o comando de dentro do container laravel-app

```
vendor/bin/phpunit --coverage-html coverage
```
Esse comando irá criar um aquivo em coverage/index.html.
Para ver a cobertura de testes, abra esse aquivo no navegadir.
Exemplo de saída:
![image](https://github.com/JadisDev/driver-back/assets/20782995/764204e8-8015-4cef-81ab-490902a8a909)

## 🛠️ Construído com

Ferramentas usadas no projeto

* [PHP >= 7.3 || >= 8.0](http://www.dropwizard.io/1.0.2/docs/](https://www.php.net/) - Linguagem
* [laravel/lumen-framework](https://lumen.laravel.com/docs/10.x) - Framework
* [Phpunit](https://phpunit.de/) - Usada para testar

## ✒️ Autor

* **Desenvolvedor responsável** [Jadis Jale](https://github.com/JadisDev)


---
⌨️ com ❤️ por [Jadis Jale](https://github.com/JadisDev) 😊