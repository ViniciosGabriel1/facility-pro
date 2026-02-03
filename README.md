# 🦷 Facility Pro — Clínica Odontológica (Laravel API)

**Facility Pro** é uma API REST desenvolvida em Laravel com foco em **boas práticas de arquitetura backend**, padronização de respostas e organização de regras de negócio para sistemas clínicos.

Este projeto foi construído como laboratório prático para aplicar padrões reais utilizados em ambientes profissionais.

---

## 🚀 Objetivo

Criar uma base sólida para um sistema de gestão odontológica, incluindo:

- Clínicas  
- Dentistas  
- Secretárias (via perfil de usuário)  
- Pacientes  
- Serviços  
- Consultas com múltiplos serviços vinculados  

O foco principal foi desenvolver uma API consistente, escalável e bem estruturada.

---

## 📦 Stack

- PHP 8+  
- Laravel 11  
- MySQL  
- Laravel Sanctum (Autenticação)  
- Service Layer Pattern  
- Domain Exceptions  
- API Response Standard  
- Pivot Tables (Many-to-Many)

---

## ✅ Funcionalidades Implementadas

### CRUD Completo

- Clínicas  
- Dentistas  
- Pacientes  
- Serviços  

---

### Consultas com múltiplos serviços (Pivot)

Uma consulta pode possuir vários serviços associados, armazenando dados adicionais:

- quantidade  
- valor_unitario  
- subtotal  

#### Exemplo de retorno:

```json
{
  "servicos": [
    {
      "id": 2,
      "nome": "Limpeza Dental",
      "pivot": {
        "quantidade": 2,
        "valor_unitario": "150.00",
        "subtotal": "300.00"
      }
    }
  ]
}

```
---

## 🔐 Autenticação

A API utiliza **Laravel Sanctum** para autenticação via token:

- Login  
- Logout  
- Rotas protegidas com middleware `auth:sanctum`

---

## 🧱 Arquitetura do Projeto

O projeto segue uma separação clara de responsabilidades.

---

### Controllers (Camada fina)

Controllers lidam apenas com:

- Validação via FormRequest  
- Chamada do Service  
- Retorno padronizado


Exemplo:

return ApiResponse::success(
    $clinica,
    'Clínica criada com sucesso.',
    201
);

### Service Layer (Regra de Negócio)

Toda regra de domínio fica concentrada em:

App\Services\

Responsabilidades típicas:

- validação de clínica ativa
- atualização controlada
- criação de consultas com pivot
- regras futuras de negócio

### ⚠️ Tratamento Profissional de Erros

O projeto implementa um padrão baseado em Domain Exceptions.
DomainException Base

abstract class DomainException extends Exception
{
    abstract public function status(): int;
    abstract public function keyCode(): string;

    public function payload(): array
    {
        return [];
    }
}

Exemplo de Exceção

class ClinicaInativaException extends DomainException
{
    public function status(): int
    {
        return 403;
    }

    public function keyCode(): string
    {
        return 'CLINICA_INATIVA';
    }
}

### Renderização Centralizada

## Todas as exceções são tratadas no Handler:

return response()->json([
    'message' => $e->getMessage(),
    'keyCode' => $e->keyCode(),
    'errors'  => $e->payload(),
], $e->status());

### 📤 Padronização de Resposta da API

## Todas as respostas seguem o mesmo contrato:

{
  "success": true,
  "message": "Operação realizada com sucesso.",
  "data": {},
  "meta": {}
}

Paginação Padronizada

"meta": {
  "pagination": {
    "current_page": 1,
    "last_page": 5,
    "total": 25,
    "has_next": true
  }
}

### 🏥 Multi-Tenancy Inicial (Por Clínica)

## Todos os registros são vinculados via:

    clinica_id

Foi criada uma Trait reutilizável:
BelongsToClinica

Responsável por:

- aplicar filtro global por clínica autenticada

- preencher automaticamente o clinica_id ao criar registros

⚙️ Automação com Stubs (Scaffolding Interno)

Para acelerar a criação de módulos CRUD, foi implementado um sistema interno de stubs personalizados.

Ele gera automaticamente:

- Controllers

- Services

- Requests (Store/Update)

- Exceptions de domínio

- Estrutura padronizada de API

📌 Exemplo de comando

php artisan make:crud-api Servico

📂 Estrutura gerada automaticamente

app/
- - Http/Controllers/ServicoController.php
- - Services/ServicoService.php
- - Http/Requests/CriarServicoRequest.php
- - Http/Requests/AtualizarServicoRequest.php
- - Exceptions/ServicoNaoEncontradoException.php

Benefícios

✅ Desenvolvimento mais rápido
✅ Código consistente
✅ Estrutura semelhante a projetos reais
✅ Facilita expansão futura
✅ Rotas Principais
### Clínicas
Método	Endpoint	Descrição
GET	/api/clinicas	Listagem paginada
POST	/api/clinicas	Criar clínica
PUT	/api/clinicas/{id}	Atualizar clínica
DELETE	/api/clinicas/{id}	Remover clínica
Consultas
Método	Endpoint	Descrição
POST	/api/consultas	Criar consulta com serviços vinculados
### 🧪 Próximos Passos (Ideias Futuras)

    Agenda diária por dentista

    Controle de fila e atendimento

    Pagamentos e formas de cobrança

    Painel para secretárias

    Testes automatizados (Pest/PHPUnit)

    Logs e auditoria clínica

👨‍💻 Autor

Projeto desenvolvido por Vinícios Oliveira
Backend Developer — PHP | Laravel
📄 Licença

Projeto desenvolvido para fins educacionais e portfólio.


---

Se quiser, eu posso também:

✅ criar uma versão com badges (Laravel, PHP, Sanctum, etc.)  
✅ adicionar seção de instalação e execução (`docker`, `.env`, migrations)  
✅ deixar ele 100% padrão de projeto open-source profissional