<?php

namespace Modules\Record\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Modules\Record\Application\DTOs\RecordStatus\RecordStatusDTO;
use Modules\Record\Application\UseCases\RecordStatus\DeleteRecordStatus;
use Modules\Record\Application\UseCases\RecordStatus\GetAllRecordsStatus;
use Modules\Record\Application\UseCases\RecordStatus\RegisterRecordStatus;
use Symfony\Component\HttpFoundation\Request;

class RecordStatusController extends Controller
{
    public function index(GetAllRecordsStatus $useCase)
    {
        $status = $useCase->execute();
        return view('record::status.index', compact('status'));
    }

    public function store(Request $request, RegisterRecordStatus $useCase)
    {
        $dto = RecordStatusDTO::fromRequest($request);
        $useCase->execute($dto);

        return redirect()->back()->with('success', 'Categoria salva com sucesso!');
    }

    public function destroy(int $id, DeleteRecordStatus $useCase)
    {
        $useCase->execute($id);
        return redirect()->back()->with('success', 'Categoria removida!');
    }
}
