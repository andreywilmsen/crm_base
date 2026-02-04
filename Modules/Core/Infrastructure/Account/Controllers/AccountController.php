<?php

namespace Modules\Core\Infrastructure\Account\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\Application\Account\UseCases\GetUser;
use Modules\Core\Application\Account\UseCases\UpdateUser;
use Modules\Core\Application\Account\DTOs\ProfileUpdateDTO;

class AccountController extends Controller
{
    public function __construct(
        private GetUser $getUserUseCase,
        private UpdateUser $updateUserUseCase
    ) {}

    public function index()
    {
        $user = $this->getUserUseCase->execute(auth()->id());
        
        return view('account::index', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|min:8|confirmed', 
        ]);

        try {
            $dto = new ProfileUpdateDTO(
                id: auth()->id(),
                name: $validated['name'],
                email: $validated['email'],
                password: $validated['password'] ?? null
            );

            $this->updateUserUseCase->execute($dto);

            return redirect()->route('account.index')->with('success', 'Perfil atualizado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao atualizar: ' . $e->getMessage()]);
        }
    }
}