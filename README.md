# Sistema de gerenciamento de clientes 

### Este sistema foi desenvolvido para cadastrar, consultar, alterar e inativar clientes. Foi construído utilizando o framework Laravel v9.52.20 para o backend e Vue.js v3.5.13 para o frontend.

## Estrutura do Repositório
- backend: Contém a aplicação Laravel, responsável pela lógica de negócios e interação com o banco de dados.
- frontend: Contém a aplicação Vue.js, responsável pela interface do usuário.

## Tecnologias Utilizadas
- Backend:
  - Laravel v9.52.20
  - PHP 8.0.30
  -MySQL
- Frontend:
  - Vue.js v3.5.13
  - Vite
  - Bootstrap
 
 ## Pré-requisitos
- PHP 8.0 ou superior
- Composer
- Node.js (inclui o npm)
- MySQL
- Git

## Instruções de Instalação
1. Clonar o repositório
```bash
git clone https://github.com/kaegg/gerenciamento_de_cliente.git
cd gerenciamento_de_cliente
```

2. Configuração backend
```bash
cd backend
composer install
cp .env.example .env
```

3. Configurar a conexão com o banco de dados
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

4. Criar e popular tabelas
```bash
php artisan migrate
php artisan db:seed --class=ProfessionSeeder
php artisan db:seed --class=AddressSeeder
php artisan db:seed --class=ClientSeeder
```

5. Iniciar servidor backend que estará acessível em http://localhost:8000.
```bash
php artisan serve
```

6. Navegar até a pasta frontend e instalar as dependências do Vue.js
```bash
cd ../frontend
npm install
```

7. Iniciar servidor frontend que estará acessível em http://localhost:5173.
```bash
npm run dev
```

## Instruções de uso do sistema
Ao clicar em buscar ele irá retornar os clientes com o filtro digitado
![image](https://github.com/user-attachments/assets/5b58127e-cdf9-45bc-a27a-ea42cb394a36)

Ao clicar em Cadastrar ele irá abrir uma dialog para cadastro do cliente
![image](https://github.com/user-attachments/assets/c759ef1e-e46e-472c-9337-740dbc8a4f28)
![image](https://github.com/user-attachments/assets/f2000d1c-4286-40ae-850e-cbfd191b679e)

Ao clicar em Limpar ele irá limpar o filtro e a grid 
![image](https://github.com/user-attachments/assets/a4004908-6418-45db-98d2-1557cc417306)

Ao clicar sobre um registro ele irá abrir a dialog para edição
![image](https://github.com/user-attachments/assets/f30f6368-418c-4785-b1c0-6a932a497f4c)
![image](https://github.com/user-attachments/assets/c60ee7fa-4883-4f00-b464-b3fcb641db44)

## Endpoints da API
GET: http://localhost:8000/api/professions

Retorno:
```json
{
  "status": true,
  "professions": [
    {
      "id": 1,
      "profession_name": "Administração",
      "created_at": "2025-06-04T02:47:37.000000Z",
      "updated_at": "2025-06-04T02:47:37.000000Z"
    }
  ]
}
```

GET: http://localhost:8000/api/addresses

Retorno:
```json
{
  "status": true,
  "address": [
    {
      "id": 1,
      "address": "Rua das Flores",
      "number": 123,
      "neighborhood": "Jardim América",
      "complement": "Apto 101",
      "city": "São Paulo",
      "state": "SP",
      "created_at": "2025-06-04T02:47:41.000000Z",
      "updated_at": "2025-06-04T02:47:41.000000Z"
    }
  ]
}
```

GET: http://localhost:8000/api/clients

Retorno:
```json
{
  "status": true,
  "clients": [
    {
      "id": 1,
      "name": "Ana Maria",
      "birth_date": "1990-05-12",
      "person_type": "F",
      "cpf_cnpj": "111.222.333-44",
      "email": "ana.maria@example.com",
      "phone": "(44) 99999-1111",
      "address_id": 1,
      "profession_id": 2,
      "active": 1,
      "created_at": "2024-10-04T02:47:51.000000Z",
      "updated_at": "2025-06-04T02:47:51.000000Z",
      "profession": {
        "id": 2,
        "profession_name": "Consultor",
        "created_at": "2025-06-04T02:47:37.000000Z",
        "updated_at": "2025-06-04T02:47:37.000000Z"
      },
      "address": {
        "id": 1,
        "address": "Av. Paraná",
        "number": 442,
        "neighborhood": "Zona 07",
        "complement": "",
        "city": "Maringá",
        "state": "PR",
        "created_at": "2025-06-04T02:47:41.000000Z",
        "updated_at": "2025-06-04T02:47:41.000000Z"
      }
    }
  ]
}
```

POST: http://localhost:8000/api/professions

Requisição:

```json
{
  "profession_name": "Administração"
}
```

Retorno:
```json
{
    "status": true,
    "message": "Profissão criada com sucesso!",
    "profession": {
        "profession_name": "Administração",
        "updated_at": "2025-06-04T04:20:55.000000Z",
        "created_at": "2025-06-04T04:20:55.000000Z",
        "id": 1
    }
}
```

POST: http://localhost:8000/api/addresses

Requisição:

```json
{
    "address": "Rua dos testes",
    "number": "123",
    "neighborhood": "Bairro dos testes",
    "complement": "",
    "city": "Maringá",
    "state": "PR"
}
```

Retorno:
```json
{
    "status": true,
    "message": "Endereço criado com sucesso!",
    "address": {
        "address": "Rua dos testes",
        "number": "123",
        "neighborhood": "Bairro dos testes",
        "complement": null,
        "city": "Maringá",
        "state": "PR",
        "updated_at": "2025-06-04T04:23:27.000000Z",
        "created_at": "2025-06-04T04:23:27.000000Z",
        "id": 8
    }
}
```

POST: http://localhost:8000/api/clients

Requisição:

```json
{
    "name": "John Doe",
    "birth_date": "1997-04-03",
    "person_type": "F",
    "cpf_cnpj": "569.641.410-90",
    "email": "teste@teste.com",
    "phone": "44 999999999",
    "address": "Rua dos testes",
    "number": "123",
    "neighborhood": "Bairro dos testes",
    "complement": "",
    "city": "Maringá",
    "state": "PR",
    "profession_name": "Administração",
    "active": true
}
```

Retorno:
```json
{
    "status": true,
    "message": "Cliente cadastrado com sucesso!",
    "client": {
        "name": "John Doe",
        "birth_date": "1997-04-03",
        "person_type": "F",
        "cpf_cnpj": "569.641.410-90",
        "email": "teste@teste.com",
        "phone": "44 999999999",
        "address_id": 8,
        "profession_id": 13,
        "active": true,
        "updated_at": "2025-06-04T04:25:20.000000Z",
        "created_at": "2025-06-04T04:25:20.000000Z",
        "id": 7,
        "address": {
            "id": 8,
            "address": "Rua dos testes",
            "number": 123,
            "neighborhood": "Bairro dos testes",
            "complement": null,
            "city": "Maringá",
            "state": "PR",
            "created_at": "2025-06-04T04:23:27.000000Z",
            "updated_at": "2025-06-04T04:23:27.000000Z"
        },
        "profession": {
            "id": 13,
            "profession_name": "Administração",
            "created_at": "2025-06-04T04:20:55.000000Z",
            "updated_at": "2025-06-04T04:20:55.000000Z"
        }
    }
}
```

PUT: http://localhost:8000/api/clients/{id}

Requisição:

```json
{
    "name": "John Doe 123",
    "birth_date": "1997-04-03",
    "person_type": "F",
    "cpf_cnpj": "569.641.410-90",
    "email": "teste@teste.com",
    "phone": "44 999999999",
    "address": "Rua dos testes",
    "number": "123",
    "neighborhood": "Bairro dos testes",
    "complement": "",
    "city": "Maringá",
    "state": "PR",
    "profession_name": "Administração",
    "active": false
}
```

Retorno:
```json
{
    "status": true,
    "message": "Cliente atualizado com sucesso!",
    "client": {
        "id": 7,
        "name": "John Doe 123",
        "birth_date": "1997-04-03",
        "person_type": "F",
        "cpf_cnpj": "569.641.410-90",
        "email": "teste@teste.com",
        "phone": "44 999999999",
        "address_id": 8,
        "profession_id": 13,
        "active": false,
        "created_at": "2025-06-04T04:25:20.000000Z",
        "updated_at": "2025-06-04T04:28:34.000000Z",
        "address": {
            "id": 8,
            "address": "Rua dos testes",
            "number": 123,
            "neighborhood": "Bairro dos testes",
            "complement": null,
            "city": "Maringá",
            "state": "PR",
            "created_at": "2025-06-04T04:23:27.000000Z",
            "updated_at": "2025-06-04T04:23:27.000000Z"
        },
        "profession": {
            "id": 13,
            "profession_name": "Administração",
            "created_at": "2025-06-04T04:20:55.000000Z",
            "updated_at": "2025-06-04T04:20:55.000000Z"
        }
    }
}
```
