<?php

namespace Modules\Record\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Modules\Core\Infrastructure\Traits\HandlesErrors;
use Modules\Record\Application\DTOs\Record\RecordCreateDTO;
use Modules\Record\Application\DTOs\Record\RecordUpdateDTO;
use Modules\Record\Application\UseCases\Record\ListRecordsService;
use Modules\Record\Application\UseCases\Record\DeleteRecord;
use Modules\Record\Application\UseCases\Record\GetRecord;
use Modules\Record\Application\UseCases\Record\RegisterRecord;
use Modules\Record\Application\UseCases\Record\UpdateRecord;
use Modules\Record\Application\UseCases\RecordCategory\GetAllRecordsCategories;
use Modules\Record\Application\UseCases\RecordStatus\GetAllRecordsStatus;
use Modules\Record\Infrastructure\Requests\Record\StoreRecordRequest;
use Modules\Record\Infrastructure\Requests\Record\UpdateRecordRequest;
use Exception;

class RecordController extends Controller
{
    use HandlesErrors;

    public function index(ListRecordsService $listRecordService)
    {
        try {
            return view('record::Record.index', $listRecordService->execute());
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function create(GetAllRecordsCategories $getAllRecordsCategories, GetAllRecordsStatus $getAllRecordsStatus)
    {
        return view('record::Record.form', [
            'categories' => $getAllRecordsCategories->execute() ?? [],
            'status' => $getAllRecordsStatus->execute() ?? []
        ]);
    }

    public function get(GetRecord $getUseCase, GetAllRecordsCategories $getCategoriesUseCase, GetAllRecordsStatus $getAllRecordsStatus, int $id)
    {
        try {
            return view('record::Record.form', [
                'record' => $getUseCase->execute($id),
                'categories' => $getCategoriesUseCase->execute() ?? [],
                'status' => $getAllRecordsStatus->execute() ?? []
            ]);
        } catch (Exception $e) {
            return $this->handleException($e, 'record.index');
        }
    }

    public function store(RegisterRecord $registerUseCase, StoreRecordRequest $request)
    {
        try {
            $dto = RecordCreateDTO::fromRequest($request);
            $registerUseCase->execute($dto);

            return redirect()->route('record.index')->with('success', 'Registro inserido!');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function update(int $id, UpdateRecord $updateUseCase, UpdateRecordRequest $request)
    {
        try {
            $dto = RecordUpdateDTO::fromRequest($request, $id);
            $updateUseCase->execute($dto);

            return redirect()->route('record.index')->with('success', 'Registro atualizado!');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function delete(DeleteRecord $deleteUseCase, int $id)
    {
        try {
            $deleteUseCase->execute($id);
            return redirect()->route('record.index')->with('success', 'Registro removido!');
        } catch (Exception $e) {
            return $this->handleException($e, 'record.index');
        }
    }
}
