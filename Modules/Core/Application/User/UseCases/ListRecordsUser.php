<?php

namespace Modules\Core\Application\User\UseCases;

use Modules\Core\Domain\User\Repositories\UserRepositoryInterface;
use Modules\Core\Infrastructure\User\Presenters\UserTablePresenter;

class ListRecordsUser
{
    public function __construct(private UserRepositoryInterface $userRepository, private GetAllUsers $getAllUsersUseCase, private UserTablePresenter $presenter) {}

    public function execute(): array
    {
        $query = $this->userRepository->getQueryBuilder();

        $users = $this->getAllUsersUseCase->execute();

        return $this->presenter->render($query, $users);
    }
}
