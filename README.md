# Teste Adoorei

Este é um projeto de teste para a empresa Adoorei.

## Requisitos

- PHP 7.4 ou superior
- Composer
- Docker e Docker Compose

## Configuração

1. Clone este repositório para o seu ambiente local.

git clone https://github.com/LuanaRipardo/teste-adoorei.git


2. Navegue até o diretório do projeto.

cd teste-adoorei


3. Instale as dependências do Composer.

composer install


4. Copie o arquivo de exemplo `.env.example` para `.env`.

cp .env.example .env


5. Gere uma chave de aplicativo Laravel.

php artisan key:generate


6. Inicie os contêineres Docker.

docker-compose up -d


7. Execute as migrações do banco de dados.


docker-compose exec laravel.test php artisan migrate


## Importação de Produtos

Para importar um produto individualmente, execute o seguinte comando:

docker-compose exec laravel.test php artisan products:import --id={ID_DO_PRODUTO}

Substitua `{ID_DO_PRODUTO}` pelo ID do produto que deseja importar.

## API

A API possui as seguintes rotas disponíveis:

- `GET /api/products`: Retorna a lista de produtos.
- `POST /api/products`: Cria um novo produto.
- `GET /api/products/{id}`: Retorna os detalhes de um produto específico.
- `PUT /api/products/{id}`: Atualiza um produto existente.
- `DELETE /api/products/{id}`: Exclui um produto existente.

## Documentação da API

A documentação da API está disponível em [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation) após iniciar o projeto.
