# Desafio  Vibbra

API implementada em função do desafio proposto pela [Vibbra](https://www.vibbra.com.br/) como pré-requisito para entrar na plataforma como profissional Vibbrante (profissional freelancer que aceitou ter suas competências validada).

### 📋 Pré-requisitos

São pré-requisitos para implantar essa API:
1. [GIT](https://git-scm.com/downloads) - para clonar o repositório de fontes
2. [Composer](https://getcomposer.org/download/) - para instalar as dependências do projeto
3. [Apache](https://www.apachefriends.org/pt_br/index.html) - servidor web sugerido para expor a API
4. [Insomnia](https://insomnia.rest/download) - ferramenta visual sugerida para consumir a API

### 🔧 Instalação

Após devidamente instalados os pré-requisitos acima citados, siga o passo-a-passo para implantar o serviço de API

MySQL
```
# Criar um banco de dados
$ CREATE DATABASE vibbra;

# Criar o usuário empiricus
$ CREATE USER 'vibbra'@'localhost' IDENTIFIED BY 'vibbra';

# Conceder privilégios
GRANT ALL PRIVILEGES ON vibbra.* TO 'vibbra'@'localhost';
FLUSH PRIVILEGES;
```

API
```
# Clone o repositório
$ https://github.com/timoteobega/backend-vibbra.git

# Entre no diretório do projeto
$ cd backend-vibbra

# Instalando as depedências do projeto
$ composer install

# Rode as migrações
$ php artisan migrate --seed

# Execute a API localmente
$ php artisan serve
```

## ⚙️ Executando os testes via Insomnia

Vídeo demonstrando o consumo de todos os endpoints da API 
[![Assista o vídeo]](https://youtu.be/u27T4NZV_Ac)

## ✒️ Autor
**Timóteo Bega** - (https://www.linkedin.com/in/timoteobega/)
