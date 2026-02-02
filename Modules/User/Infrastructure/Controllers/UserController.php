<?php

namespace Modules\User\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Application\DTOs\UserCreateDTO;
use Modules\User\Application\DTOs\UserUpdateDTO;
use Modules\User\Application\UseCases\DeleteUser;
use Modules\User\Application\UseCases\GetAllUsers;
use Modules\User\Application\UseCases\GetUser;
use Modules\User\Application\UseCases\RegisterUser;
use Modules\User\Application\UseCases\ResetPasswordUser;
use Modules\User\Application\UseCases\UpdateUser;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(GetAllUsers $getAllUseCase)
    {
        try {
            $users = $getAllUseCase->execute();
            $usersArray = array_map(fn($user) => $user->toArray(), $users);
            return view('user::index', [
                'users' => $usersArray
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }

    public function create()
    {
        $roles = Role::all();
        return view('user::form', compact('roles'));
    }

    public function get(GetUser $getUseCase, int $id)
    {
        try {
            $user = $getUseCase->execute($id);
            $roles = Role::all();

            return view('user::form', [
                'user' => $user->toArray(),
                'roles' => $roles
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }

    public function store(RegisterUser $registerUseCase, Request $request)
    {
        try {
            $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|unique:users,email', 'password' => 'required|confirmed|min:8', 'role' => 'required']);

            $dto = UserCreateDTO::fromRequest($request);
            $user = $registerUseCase->execute($dto);

            return redirect()
                ->route('user.index')
                ->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }


    public function update(int $id, UpdateUser $updateUseCase, Request $request)
    {
        try {
            $dto = UserUpdateDTO::fromRequest($request, $id);
            $user = $updateUseCase->execute($dto);

            if (auth()->id() === $id) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('info', 'Sua permissão foi alterada. Por favor, faça login novamente.');
            }

            return redirect()
                ->route('user.index')
                ->with('success', 'Usuário atualizado com sucesso!');
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }

    public function delete(DeleteUser $deleteUseCase, int $id)
    {
        try {
            $deleteUseCase->execute($id);
            return redirect()->route('user.index')->with('success', 'Usuário removido com sucesso!');
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }

    public function resetPassword(int $id, ResetPasswordUser $resetPasswordUseCase)
    {
        try {
            $resetPasswordUseCase->execute($id);

            return redirect()
                ->route('user.index')
                ->with('success', 'Senha redefinida com sucesso para o padrão do sistema!');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Não foi possível resetar a senha. Tente novamente.']);
        }
    }
}
