<?php

namespace Modules\Core\Infrastructure\User\Presenters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Application\Table\UseCases\TableUseCase;
use Modules\Core\Domain\Table\Entities\TableColumn;
use Modules\Core\Infrastructure\User\Mappers\UserMapper;

// Filtros
use Modules\Core\Infrastructure\User\Filters\EmailFilter;
use Modules\Core\Infrastructure\User\Filters\NameFilter;


class UserTablePresenter
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
    public function render(Builder $query): array
    {
        // Define colunas (variável, Título, tipo de input).
        $columns = [
            new TableColumn('id', '#', 'text', [], false),
            new TableColumn('name', 'Nome', 'text'),
            new TableColumn('email', 'Email', 'email'),
        ];

        //Define os filtros (Infrastructure/Filters)
        $filters = [
            new NameFilter(),
            new EmailFilter()
        ];

        //Chama o service do Core usando a Query injetada
        $tableData = $this->tableUseCase->make(
            query: $query,
            columns: $columns,
            filters: $filters,
            perPage: 15
        );

        // Mapeia os resultados
        $tableData['records']->setCollection(
            $tableData['records']->getCollection()->map(function ($model) {
                $entity = UserMapper::toEntity($model);
                return UserMapper::toResponse($entity);
            })
        );

        $tableData['columns'] = $columns;

        return $tableData;
    }
}
