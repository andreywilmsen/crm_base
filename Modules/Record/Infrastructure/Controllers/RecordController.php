<?php

namespace Modules\Record\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Modules\Record\Application\DTOs\Record\RecordCreateDTO;
use Modules\Record\Application\DTOs\Record\RecordUpdateDTO;
use Modules\Record\Application\UseCases\Record\DeleteRecord;
use Modules\Record\Application\UseCases\Record\GetAllRecords;
use Modules\Record\Application\UseCases\Record\GetRecord;
use Modules\Record\Application\UseCases\Record\RegisterRecord;
use Modules\Record\Application\UseCases\Record\UpdateRecord;
use Modules\Record\Application\UseCases\RecordCategory\GetAllRecordsCategories;
use Modules\Record\Application\UseCases\RecordStatus\GetAllRecordsStatus;
use Modules\Record\Infrastructure\Mappers\RecordMapper;
use Modules\Record\Infrastructure\Requests\Record\StoreRecordRequest;
use Modules\Record\Infrastructure\Requests\Record\UpdateRecordRequest;

class RecordController extends Controller
{
    public function index(GetAllRecords $getAllRecords)
    {
        try {
            $records = $getAllRecords->execute();
            $recordsArray = array_map(fn($record) => RecordMapper::toResponse($record), $records);

            return view('record::Record.index', ['records' => $recordsArray]);
        } catch (\Exception $e) {
            $errors = new \Illuminate\Support\MessageBag(['error' => 'Não foi possível carregar os registros.']);
            return view('record::index', ['records' => []])->with('errors', $errors);
        }
    }

    public function create(GetAllRecordsCategories $getAllRecordsCategories, GetAllRecordsStatus $getAllRecordsStatus)
    {
        $categories = $getAllRecordsCategories->execute() ?? [];
        $status = $getAllRecordsStatus->execute() ?? [];

        return view('record::Record.form', [
            'categories' => $categories,
            'status' => $status
        ]);
    }

    public function get(GetRecord $getUseCase, GetAllRecordsCategories $getCategoriesUseCase, GetAllRecordsStatus $getAllRecordsStatus, int $id)
    {
        try {
            $record = $getUseCase->execute($id);
            $categories = $getCategoriesUseCase->execute() ?? [];
            $status = $getAllRecordsStatus->execute() ?? [];

            return view('record::Record.form', [
                'record' => RecordMapper::toResponse($record),
                'categories' => $categories,
                'status' => $status
            ]);
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record.index')->withErrors(['error' => 'Registro não encontrado.']);
        } catch (\Exception $e) {
            return redirect()->route('record.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
    }

    public function store(RegisterRecord $registerUseCase, StoreRecordRequest $request)
    {
        try {
            $dto = RecordCreateDTO::fromRequest($request);
            $record = $registerUseCase->execute($dto);

            return redirect()
                ->route('record.index')
                ->with('success', 'Registro inserido com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function update(int $id, UpdateRecord $updateUseCase, UpdateRecordRequest $request)
    {
        try {
            $dto = RecordUpdateDTO::fromRequest($request, $id);
            $record = $updateUseCase->execute($dto);

            return redirect()
                ->route('record.index')
                ->with('success', 'Registro atualizado com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro interno ao atualizar.'])->withInput();
        }
    }

    public function delete(DeleteRecord $deleteUseCase, int $id)
    {
        try {
            $deleteUseCase->execute($id);
            return redirect()->route('record.index')->with('success', 'Registro removido com sucesso!');
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record.index')->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('record.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
    }
}
