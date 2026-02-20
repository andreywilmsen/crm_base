<?php

namespace Modules\Record\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Modules\Record\Application\DTOs\RecordCategory\RecordCategoryDTO;
use Modules\Record\Application\UseCases\RecordCategory\DeleteRecordCategory;
use Modules\Record\Application\UseCases\RecordCategory\GetAllRecordsCategories;
use Modules\Record\Application\UseCases\RecordCategory\RegisterRecordCategory;
use Symfony\Component\HttpFoundation\Request;

class RecordCategoryController extends Controller
{
    public function index(GetAllRecordsCategories $useCase)
    {
        $categories = $useCase->execute();
        return view('record::categories.index', compact('categories'));
    }

    public function store(Request $request, RegisterRecordCategory $useCase)
    {
        $dto = RecordCategoryDTO::fromRequest($request);
        $useCase->execute($dto);

        return redirect()->back()->with('success', 'Categoria salva com sucesso!');
    }

    public function destroy(int $id, DeleteRecordCategory $useCase)
    {
        $useCase->execute($id);
        return redirect()->back()->with('success', 'Categoria removida!');
    }
}
