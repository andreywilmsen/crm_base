<?php

namespace Modules\Record\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Modules\Record\Application\DTOs\RecordCategory\RecordCategoryDTO;
use Modules\Record\Application\UseCases\RecordCategory\DeleteRecordCategory;
use Modules\Record\Application\UseCases\RecordCategory\GetAllRecordsCategories;
use Modules\Record\Application\UseCases\RecordCategory\RegisterRecordCategory;
use Modules\Record\Infrastructure\Requests\RecordCategory\StoreRecordCategoryRequest;

class RecordCategoryController extends Controller
{
    public function index(GetAllRecordsCategories $useCase)
    {
        $categories = $useCase->execute();
        return view('record::categories.index', compact('categories'));
    }

    public function store(StoreRecordCategoryRequest $request, RegisterRecordCategory $useCase)
    {
        $dto = RecordCategoryDTO::fromRequest($request);
        $useCase->execute($dto);

        return redirect()->back()->with('success', 'Categoria salva com sucesso!');
    }


    public function destroy($id, DeleteRecordCategory $useCase)
    {
        try {
            $useCase->execute($id);

            return redirect()->route('record-category.index')
                ->with('success', 'Categoria excluída!');
        } catch (\Exception $e) {
            return redirect()->route('record-category.index')
                ->with('error', 'Não é possível excluir: existem registros vinculados a esta categoria.');
        }
    }
}
