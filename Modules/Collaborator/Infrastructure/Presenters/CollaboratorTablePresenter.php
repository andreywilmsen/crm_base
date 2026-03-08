<?php

namespace Modules\Collaborator\Infrastructure\Presenters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Application\Table\UseCases\TableUseCase;
use Modules\Core\Domain\Table\Entities\TableColumn;
use Modules\Collaborator\Infrastructure\Mappers\CollaboratorMapper;

// Filtros
use Modules\Collaborator\Infrastructure\Filters\NameFilter;

class CollaboratorTablePresenter
{
    public function __construct(
        private TableUseCase $tableUseCase
    ) {}

    /**
     * Aceita a Query que vem do ListCollaboratorsService como primeiro parâmetro
     * 
     * Todas as opções que devem ser carregadas em um dropdown de filtro deve ser carregada no
     * service e se passada por parâmetro para o presenter
     * 
     */
    public function render(Builder $query, array $options = []): array
    {
        $categories = $options['categories'] ?? [];
        $status = $options['status'] ?? [];

        // 1. Define colunas (Variável correspondente no mapper (passo 4)), Título, Tipo de input).
        $columns = [
            new TableColumn('id', '#', 'text', [], false),
            new TableColumn('name', 'Nome', 'text'),
        ];

        // 2. Define os filtros (Infrastructure/Filters)
        $filters = [
            new NameFilter(),
        ];

        // 3. Chama o service do Core usando a Query injetada 
        // (Chama o TableUseCase para orquestrar a filtragem via Pipeline, aplicar a paginação e retornar os dados brutos junto com a definição das colunas.)
        $tableData = $this->tableUseCase->make(
            query: $query,
            columns: $columns,
            filters: $filters,
            perPage: 15
        );

        // 4. Mapeia os resultados
        // (Transforma os registros brutos do banco de dados (Models) em objetos formatados (DTOs) através do Mapper, 
        // garantindo que os dados correspondam exatamente aos nomes das colunas definidas para a interface, sem perder a paginação.)
        // 
        // Atribui os registros a tableData['Collaborators']
        $tableData['records']->setCollection(
            $tableData['records']->getCollection()->map(fn($model) => CollaboratorMapper::toResponseDTO($model))
        );

        return $tableData;
    }
}
