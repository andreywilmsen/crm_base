<?php

namespace Modules\Record\Infrastructure\Controllers;

use Modules\Record\Application\UseCases\RegisterRecord;
use App\Http\Controllers\Controller;
use Modules\Record\Application\DTOs\RecordCreateDTO;
use Modules\Record\Application\DTOs\RecordUpdateDTO;
use Modules\Record\Application\UseCases\DeleteRecord;
use Modules\Record\Application\UseCases\GetAllRecords;
use Modules\Record\Application\UseCases\GetRecord;
use Modules\Record\Application\UseCases\UpdateRecord;
use Modules\Record\Infrastructure\Requests\StoreRecordRequest;

class RecordController extends Controller
{
    public function index(GetAllRecords $getAllRecords)
    {
        try {
            $records = $getAllRecords->execute();
            $recordsArray = array_map(fn($record) => $record->toArray(), $records);
            return view('record::index', [
                'records' => $recordsArray
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }

    public function create()
    {
        return view('record::form');
    }

    public function get(GetRecord $getUseCase, int $id)
    {
        try {
            $record = $getUseCase->execute($id);

            return view('record::form', [
                'record' => $record->toArray(),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
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

    public function update(int $id, UpdateRecord $updateUseCase, StoreRecordRequest $request)
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
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }

    public function delete(DeleteRecord $deleteUseCase, int $id)
    {
        try {
            $deleteUseCase->execute($id);
            return redirect()->route('record.index')->with('success', 'Registro removido com sucesso!');
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }
}
