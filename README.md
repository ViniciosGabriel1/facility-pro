# 🦷 Facility Pro — Clínica Odontológica (Laravel API)

Facility Pro é uma API REST desenvolvida em Laravel com foco em **boas práticas de arquitetura backend**, padronização de respostas e organização de regras de negócio para sistemas clínicos.

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

## 🧱 Stack

- PHP 8+
- Laravel 11
- MySQL
- Laravel Sanctum (Autenticação)
- Service Layer Pattern
- Domain Exceptions
- API Response Standard
- Pivot Tables (Many-to-Many)

---

## 📌 Funcionalidades Implementadas

### ✅ CRUD Completo

- Clínicas
- Dentistas
- Pacientes
- Serviços

### ✅ Consultas com Pivot (Many-to-Many)

Uma consulta pode possuir vários serviços associados, armazenando dados adicionais:

- quantidade
- valor_unitario
- subtotal

Exemplo de retorno:

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

🔐 Autenticação

A API utiliza Laravel Sanctum para autenticação via token:

    Login

    Logout

    Rotas protegidas com middleware auth:sanctum

📦 Estrutura e Arquitetura

Este projeto utiliza separação clara de responsabilidades:
Controller (Fino)

Controllers lidam apenas com:

    validação via FormRequest

    chamada do Service

    retorno padronizado

Exemplo:

return ApiResponse::success(
    $clinica,
    'Clínica criada com sucesso.',
    201
);

Service Layer (Regra de Negócio)

Toda regra de domínio fica concentrada em:

App\Services\

Exemplo:

    validações de clínica ativa

    atualização controlada

    criação de consulta com serviços pivot

⚠️ Tratamento Profissional de Erros

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

Renderização Centralizada

Todas as exceções são tratadas no Handler:

$exceptions->renderable(function (DomainException $e) {
    return response()->json([
        'message' => $e->getMessage(),
        'keyCode' => $e->keyCode(),
        'errors'  => $e->payload(),
    ], $e->status());
});

📤 Padronização de Resposta da API

Todas as respostas seguem o mesmo contrato:

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

🏥 Multi-Tenancy Inicial (Por Clínica)

Os registros são sempre vinculados a uma clínica via:

    clinica_id

Foi criada uma Trait reutilizável:

BelongsToClinica

Que aplica automaticamente:

    filtro global por clínica autenticada

    preenchimento automático do clinica_id ao criar registros

⚙️ Automação com Stubs (Scaffolding Interno)

Para acelerar a criação de módulos CRUD dentro do projeto, foi implementado um sistema interno de stubs personalizados.

Esses stubs permitem gerar automaticamente:

    Controllers

    Services

    Requests (Store/Update)

    Exceptions de domínio

    Estrutura padronizada de API

Exemplo de comando customizado

php artisan make:crud-api Servico

Esse comando gera a estrutura base seguindo o padrão adotado no projeto:

    Controller fino

    Service com regra de negócio

    Requests com validação

    Exceptions padronizadas com keyCode

Benefícios

    Desenvolvimento mais rápido

    Código previsível e consistente

    Estrutura semelhante a sistemas reais em produção

    Facilita expansão futura do sistema

📌 Rotas Principais
Clínicas
Método	Endpoint	Descrição
GET	/api/clinicas	Listagem paginada
POST	/api/clinicas	Criar clínica
PUT	/api/clinicas/{id}	Atualizar
DELETE	/api/clinicas/{id}	Remover
Consultas
Método	Endpoint	Descrição
POST	/api/consultas	Criar consulta com serviços
🧪 Próximos Passos (Ideias Futuras)

    Agenda diária por dentista

    Controle de fila e atendimento

    Pagamentos e formas de cobrança

    Painel para secretárias

    Testes automatizados (Pest/PHPUnit)

    Logs e auditoria clínica

👨‍💻 Autor

Projeto desenvolvido por Vinícios Oliveira
Estudante de ADS e desenvolvedor backend PHP/Laravel.
📄 Licença

Projeto construído para fins educacionais e portfólio.