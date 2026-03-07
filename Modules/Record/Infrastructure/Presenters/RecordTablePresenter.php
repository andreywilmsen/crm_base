<?php

namespace Modules\Record\Infrastructure\Presenters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Application\Table\UseCases\TableUseCase;
use Modules\Core\Domain\Table\Entities\TableColumn;
use Modules\Record\Infrastructure\Mappers\RecordMapper;

// Filtros
use Modules\Record\Infrastructure\Filters\TitleFilter;
use Modules\Record\Infrastructure\Filters\CategoryFilter;
use Modules\Record\Infrastructure\Filters\DateFilter;
use Modules\Record\Infrastructure\Filters\StatusFilter;
use Modules\Record\Infrastructure\Filters\ValueFilter;

class RecordTablePresenter
{
    public function __construct(
        private TableUseCase $tableUseCase
    ) {}

    /**
     * Aceita a Query que vem do ListRecordsService como primeiro parâmetro
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
            new TableColumn('title', 'Título', 'text'),
            new TableColumn(
                'categoryName',
                'Categoria',
                'select',
                collect($categories)->mapWithKeys(fn($i) => [$i->getName() => $i->getName()])->toArray()
            ),
            new TableColumn('referenceDate', 'Data Ref.', 'date'),
            new TableColumn('value', 'Valor', 'money'),
            new TableColumn(
                'statusName',
                'Status',
                'select',
                collect($status)->mapWithKeys(fn($s) => [$s->getName() => $s->getName()])->toArray()
            ),
        ];

        // 2. Define os filtros (Infrastructure/Filters)
        $filters = [
            new TitleFilter(),
            new CategoryFilter(),
            new StatusFilter(),
            new DateFilter(),
            new ValueFilter()
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
        // Atribui os registros a tableData['records']
        $tableData['records']->setCollection(
            $tableData['records']->getCollection()->map(fn($model) => RecordMapper::toResponseDTO($model))
        );

        return $tableData;
    }
}
