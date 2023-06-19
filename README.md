# Backend do Teste Grupo Plan Marketing

Este é o backend do projeto Teste Plan Marketing.
Requisitos

 Certifique-se de ter os seguintes requisitos instalados em seu ambiente de desenvolvimento:

    Docker
    Docker Compose

# Configuração

1. Clone este repositório para o seu ambiente local.

```
git clone https://github.com/LuanaRipardo/-teste-plan-marketing-backend.git
```

2. Navegue até o diretório do backend.

```
cd -teste-plan-marketing-backend
```

3. Copie o arquivo de exemplo .env.example para .env.

```
cp .env.example .env
```

4. Edite o arquivo .env para configurar as variáveis de ambiente necessárias, como conexão com banco de dados e outras configurações específicas.

5. Inicie os contêineres Docker.

```
docker-compose up -d
```

# Banco de Dados

O backend utiliza um contêiner Docker MySQL para o banco de dados. As configurações padrão para o banco de dados são as seguintes:

    Host: mysql
    Porta: 3306
    Nome do banco de dados: plan-marketing
    Usuário: plan-marketing
    Senha: password

Certifique-se de que essas configurações estejam alinhadas com as configurações fornecidas no arquivo .env do backend.
