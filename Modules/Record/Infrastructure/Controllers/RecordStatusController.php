<?php

namespace Modules\Record\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Modules\Record\Application\DTOs\RecordStatus\RecordStatusDTO;
use Modules\Record\Application\UseCases\RecordStatus\DeleteRecordStatus;
use Modules\Record\Application\UseCases\RecordStatus\GetAllRecordsStatus;
use Modules\Record\Application\UseCases\RecordStatus\RegisterRecordStatus;
use Modules\Record\Infrastructure\Requests\RecordStatus\StoreRecordStatusRequest;

class RecordStatusController extends Controller
{
    public function index(GetAllRecordsStatus $useCase)
    {
        $status = $useCase->execute();
        return view('record::status.index', compact('status'));
    }

    public function store(StoreRecordStatusRequest $request, RegisterRecordStatus $useCase)
    {
        $dto = RecordStatusDTO::fromRequest($request);
        $useCase->execute($dto);

        return redirect()->back()->with('success', 'Status salvo com sucesso!');
    }

    public function destroy(int $id, DeleteRecordStatus $useCase)
    {
        try {
            $useCase->execute($id);
            return redirect()->route('record-status.index')
                ->with('success', 'Status excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('record-status.index')
                ->with('error', 'Não é possível excluir: existem registros vinculados a este status.');
        }
    }
}
