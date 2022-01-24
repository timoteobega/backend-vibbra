# Desafio  Vibbra

API implementada em função do desafio proposto pela [Vibbra](https://www.vibbra.com.br/) como pré-requisito para entrar na plataforma como profissional Vibbrante (profissional freelancer que aceitou ter suas competências validada).

### Esforço estimado

|           |          |        |            Vibbra Challenge           |                                          |       |
|:---------:|:--------:|:------:|:-------------------------------------:|:----------------------------------------:|:-----:|
| Must have |  Entity  | Method |                  URI                  |                 Comments                 | Hours |
|     Y     |    N/A   |   N/A  |                  N/A                  |              Especification              |   4   |
|     Y     |    N/A   |   N/A  |                  N/A                  |                 Analysis                 |   4   |
|     Y     |  Revenue |  POST  |    /api/v{n}/revenues/{customerID}    |                  Create                  |   2   |
|     Y     |  Revenue |   PUT  |     /api/v{n}/revenues/{revenueID}    |                  Update                  |   2   |
|     Y     |  Revenue | DELETE |     /api/v{n}/revenues/{revenueID}    |                  Delete                  |   2   |
|     Y     |  Revenue |  POST  |    /api/v{n}/reports/total-revenue    |        Read total revenue per year       |   2   |
|     Y     |  Revenue |  POST  |   /api/v{n}/reports/revenue-by-month  | Read total revenue per month of the year |   2   |
|     Y     |  Revenue |  POST  | /api/v{n}/reports/revenue-by-customer |  Read total revenue by customer per year |   2   |
|     N     | Settings |   PUT  |           /api/v{n}/settings          |                  Update                  |   2   |
|     N     | Settings |   GET  |           /api/v{n}/settings          |                    Get                   |   2   |
|     Y     |   User   |  POST  |             /api/v{n}/auth            |               Request token              |   4   |
|     Y     |   User   |  POST  |            /api/v{n}/users            |                  Create                  |   2   |
|     Y     |   User   |   GET  |          /api/v{n}/users/{ID}         |                   Read                   |   2   |
|     Y     | Customer |  POST  |          /api/v{n}/customers          |                  Create                  |   2   |
|     Y     | Customer |   GET  |    /api/v{n}/customers/{customerID}   |                Read by ID                |   2   |
|     Y     | Customer |   GET  |  Cust/api/v{n}/customers?name={NAME}  |               Read by name               |   2   |
|     Y     | Customer |   PUT  |    /api/v{n}/customers?cnpj={CNPJ}    |               Read by CNPJ               |   2   |
|     Y     | Customer | DELETE |    /api/v{n}/customers/{customerID}   |           Archive (soft delete)          |   2   |
|     N     |   User   |   PUT  |          /api/v{n}/users/{ID}         |                  Update                  |   2   |
|     N     |  Expense |  POST  |    /api/v{n}/expenses/{categoryID}    |                  Create                  |   2   |
|     N     |  Expense |   PUT  |     /api/v{n}/expenses/{expenseID}    |                  Update                  |   2   |
|     N     |  Expense | DELETE |     /api/v{n}/expenses/{expenseID}    |                  Delete                  |   2   |
|     N     | Category |  POST  |        Cate/api/v{n}/categories       |                  Create                  |   2   |
|     N     | Category |   GET  |   /api/v{n}/categories/{categoryID}   |                   Read                   |   2   |
|     N     | Category |   GET  |     /api/v{n}/categories?name=NAME    |               Read by name               |   2   |
|     N     | Category |   PUT  |   /api/v{1}/categories/{categoryID}   |           Archive (soft delete)          |   2   |
|     N     | Category |   PUT  |   /api/v{1}/categories/{categoryID}   |                  Update                  |   2   |
|     Y     |    N/A   |   N/A  |                  N/A                  |          Testing and Refactoring         |   4   |
|     Y     |    N/A   |   N/A  |                  N/A                  |                  Deploy                  |   2   |
|           |          |        |                                       |                         Estimated Hours: |   74  |

### 📋 Pré-requisitos

São pré-requisitos para implantar essa API:
1. [GIT](https://git-scm.com/downloads) - para clonar o repositório de fontes
2. [Composer](https://getcomposer.org/download/) - para instalar as dependências do projeto
3. [Apache](https://www.apachefriends.org/pt_br/index.html) - servidor web sugerido para expor a API
4. [Insomnia](https://insomnia.rest/download) - ferramenta visual sugerida para consumir a API

### Tecnologias

1. PHP
2. Laravel
3. MySQL
4. Composer
5. Git

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
$ git clone https://github.com/timoteobega/backend-vibbra.git

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
