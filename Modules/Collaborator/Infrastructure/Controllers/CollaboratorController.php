<?php

namespace Modules\Collaborator\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Modules\Core\Infrastructure\Traits\HandlesErrors;
use Exception;
use Modules\Collaborator\Application\DTOs\CollaboratorCreateDTO;
use Modules\Collaborator\Application\DTOs\CollaboratorUpdateDTO;
use Modules\Collaborator\Application\UseCases\DeleteCollaborator;
use Modules\Collaborator\Application\UseCases\GetCollaborator;
use Modules\Collaborator\Application\UseCases\ListRecordsService;
use Modules\Collaborator\Application\UseCases\UpdateCollaborator;
use Modules\Collaborator\Application\UseCases\RegisterCollaborator;
use Modules\Collaborator\Infrastructure\Requests\StoreCollaboratorRequest;
use Modules\Collaborator\Infrastructure\Requests\UpdateCollaboratorRequest;

class CollaboratorController extends Controller
{
    use HandlesErrors;

    public function index(ListRecordsService $listCollaboratorService)
    {
        try {
            return view('collaborator::index', $listCollaboratorService->execute());
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function create()
    {
        return view('collaborator::form');
    }

    public function get(GetCollaborator $getUseCase, int $id)
    {
        try {
            return view('collaborator::form', [
                'collaborator' => $getUseCase->execute($id),
            ]);
        } catch (Exception $e) {
            return $this->handleException($e, 'collaborator.index');
        }
    }

    public function store(RegisterCollaborator $registerUseCase, StoreCollaboratorRequest $request)
    {
        try {
            $dto = CollaboratorCreateDTO::fromRequest($request);
            $registerUseCase->execute($dto);

            return redirect()->route('collaborator.index')->with('success', 'Colaborador inserido!');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function update(int $id, UpdateCollaborator $updateUseCase, UpdateCollaboratorRequest $request)
    {
        try {
            $dto = CollaboratorUpdateDTO::fromRequest($request, $id);
            $updateUseCase->execute($dto);

            return redirect()->route('collaborator.index')->with('success', 'Colaborador atualizado!');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function delete(DeleteCollaborator $deleteUseCase, int $id)
    {
        try {
            $deleteUseCase->execute($id);
            return redirect()->route('collaborator.index')->with('success', 'Colaborador removido!');
        } catch (Exception $e) {
            return $this->handleException($e, 'collaborator.index');
        }
    }
}
