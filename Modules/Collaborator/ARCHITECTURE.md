# Especificação Técnica do Módulo: Record

## 1. Padrão Arquitetural
Este módulo implementa os princípios de **Clean Architecture** com foco no desacoplamento da infraestrutura. A lógica de negócio reside no **Domínio**, enquanto o framework (Laravel) é tratado como um detalhe de implementação na camada de **Infraestrutura**.



## 2. Estrutura de Diretórios e Fluxo

### Domain (Independente)
* **Entities/**: Definição dos modelos de negócio. Objetos puros (POPO) sem dependência do Eloquent.
* **Repositories/**: Contratos (Interfaces). Definem os métodos de acesso aos dados exigidos pela aplicação.

### Application (Orquestração)
* **UseCases/**: Lógica procedural e orquestração. Recebe DTOs e coordena Entidades, Mappers e Repositórios.
* **DTOs/**: Objetos de transporte de dados imutáveis (`readonly`). Garantem a integridade e tipagem estrita.

### Infrastructure (Laravel-Dependent)
* **Persistence/Eloquent/**: Implementação de Models do framework e mapeamento físico de tabelas.
* **Mappers/**: Camada de tradução centralizada. Único componente autorizado a conhecer DTOs, Entities e Models simultaneamente.
* **Filters/**: Motores de query para tabelas dinâmicas. Cada classe isola a lógica de filtragem (`where`).
* **Presenters/**: Camada de formatação para UI (Blade/Vue). Responsável por máscaras e estados visuais.

## 3. Matriz de Conversão (Mappers)

| Método | Origem | Destino | Contexto de Uso |
| :--- | :--- | :--- | :--- |
| `fromDTO()` | DTO (Request) | Entity | UseCase (Escrita/Update) |
| `toPersistence()` | Entity | Array | Repository (Persistência) |
| `toEntity()` | Model (Eloquent) | Entity | Repository (Recuperação de dados) |
| `toResponseDTO()` | Model (Eloquent) | DTO (Response) | Presenter/Table (Listagem/Exibição) |



## 4. Sistema de Listagem e Tabelas Dinâmicas

A listagem de registros adota uma estratégia de **Lazy Loading** e **Filtragem Desacoplada**:

1.  **Filtros Estruturados**: Localizados em `Infrastructure/Filters`, cada classe (ex: `DateFilter`) implementa um contrato de aplicação de query sobre o `Eloquent Builder`.
2.  **Performance N+1**: O `EloquentRecordRepository` garante o *eager loading* dos relacionamentos (`status`, `category`) antes da hidratação dos objetos.
3.  **Visualização**: A View consome exclusivamente o `RecordResponseDTO` processado pelo `RecordTablePresenter`.

## 5. Protocolo de Duplicação

Ao replicar esta estrutura para novos módulos (ex: `Product`), seguir obrigatoriamente:

1.  **Contrato**: Definir a `Interface` do repositório no Domínio antes da implementação.
2.  **DTOs**: Criar DTOs distintos para `Store` e `Update`.
3.  **Mapper**: Implementar a lógica de conversão completa para impedir o vazamento de `Models` para UseCases.
4.  **Providers**: Registrar o bind da interface no `RecordServiceProvider`.

## 6. Restrições de Design (Guardrails)

* **Injeção de Request**: Proibido injetar `Illuminate\Http\Request` em UseCases ou Repositórios.
* **Encapsulamento**: Controllers não podem instanciar ou invocar métodos estáticos de Models.
* **Padrão de Resposta**: UseCases de escrita devem retornar a Entidade processada com estado atualizado.

---
*Documentação de referência para arquitetura modular - 2026*