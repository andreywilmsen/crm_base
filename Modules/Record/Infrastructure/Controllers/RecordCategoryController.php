<?php

namespace Modules\Record\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Modules\Record\Application\DTOs\RecordCategory\RecordCategoryDTO;
use Modules\Record\Application\UseCases\RecordCategory\DeleteRecordCategory;
use Modules\Record\Application\UseCases\RecordCategory\GetAllRecordsCategories;
use Modules\Record\Application\UseCases\RecordCategory\GetRecordCategory;
use Modules\Record\Application\UseCases\RecordCategory\RegisterRecordCategory;
use Modules\Record\Application\UseCases\RecordCategory\UpdateRecordCategory;
use Modules\Record\Infrastructure\Requests\RecordCategory\RecordCategoryRequest;

class RecordCategoryController extends Controller
{
    public function index(GetAllRecordsCategories $useCase)
    {
        try {
            $categories = $useCase->execute();
            return view('record::categories.index', compact('categories'));
        } catch (\Exception $e) {
            $errors = new \Illuminate\Support\MessageBag(['error' => 'Não foi possível carregar as categorias.']);
            return view('record-category::index', ['categories' => []])->with('errors', $errors);
        }
    }

    public function create(GetAllRecordsCategories $getAllRecordsCategories)
    {
        try {
            $categories = $getAllRecordsCategories->execute() ?? [];

            return view('record::Categories.form', [
                'categories' => $categories,
            ]);
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record-category.index')->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('record-category.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
    }

    public function store(RecordCategoryRequest $request, RegisterRecordCategory $useCase)
    {
        try {
            $dto = RecordCategoryDTO::fromRequest($request);
            $useCase->execute($dto);

            return redirect()
                ->route('record-category.index')
                ->with('success', 'Categoria salva com sucesso!');
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record-category.index')->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('record-category.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
    }

    public function update(RecordCategoryRequest $request, UpdateRecordCategory $useCase, int $id)
    {
        try {
            $dto = RecordCategoryDTO::fromRequest($request, $id);
            $useCase->execute($dto);

            return redirect()
                ->route('record-category.index')
                ->with('success', 'Categoria atualizada com sucesso!');
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record-category.index')->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('record-category.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
    }

    public function get(GetRecordCategory $getCategoryUseCase, int $id)
    {
        try {
            $category = $getCategoryUseCase->execute($id);

            return view('record::Categories.form', [
                'category' => $category,
            ]);
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('record-category.index')->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('record-category.index')->withErrors(['error' => 'Erro interno do servidor.']);
        }
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
