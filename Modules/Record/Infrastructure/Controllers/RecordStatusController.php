<?php

namespace Modules\Record\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Modules\Record\Application\DTOs\RecordStatus\RecordStatusDTO;
use Modules\Record\Application\UseCases\RecordStatus\UpdateRecordStatus;
use Modules\Record\Application\UseCases\RecordStatus\DeleteRecordStatus;
use Modules\Record\Application\UseCases\RecordStatus\GetAllRecordsStatus;
use Modules\Record\Application\UseCases\RecordStatus\GetRecordStatus;
use Modules\Record\Application\UseCases\RecordStatus\RegisterRecordStatus;
use Modules\Record\Infrastructure\Requests\RecordStatus\RecordStatusRequest;

class RecordStatusController extends Controller
{
    public function index(GetAllRecordsStatus $useCase)
    {
        try {
            $status = $useCase->execute();
            return view('record::status.index', compact('status'));
        } catch (\Exception $e) {
            $errors = new \Illuminate\Support\MessageBag(['error' => 'Não foi possível carregar os status.']);
            return view('record-status::index', ['status' => []])->with('errors', $errors);
        }
    }

    public function create()
    {
        try {
            return view('record::Status.form', [
                'status' => null,
            ]);
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record-status.index')->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('record-status.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
    }

    public function store(RecordStatusRequest $request, RegisterRecordStatus $useCase)
    {
        try {
            $dto = RecordStatusDTO::fromRequest($request);
            $useCase->execute($dto);

            return redirect()
                ->route('record-status.index')
                ->with('success', 'Status salvo com sucesso!');
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record-status.index')->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('record-status.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
    }

    public function update(RecordStatusRequest $request, UpdateRecordStatus $useCase, int $id)
    {
        try {
            $dto = RecordStatusDTO::fromRequest($request, $id);
            $useCase->execute($dto);

            return redirect()
                ->route('record-status.index')
                ->with('success', 'Status atualizado com sucesso!');
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record-status.index')->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('record-status.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
    }

    public function get(GetRecordStatus $getStatusUseCase, int $id)
    {
        try {
            $status = $getStatusUseCase->execute($id);

            return view('record::Status.form', [
                'status' => $status,
            ]);
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record-status.index')->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('record-status.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
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
