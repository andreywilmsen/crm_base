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
use Modules\User\Application\UseCases\UpdateUser;

class UserController extends Controller
{
    public function index(GetAllUsers $getAllUseCase)
    {
        try {
            $users = $getAllUseCase->execute();
            $usersArray = array_map(fn($user) => $user->toArray(), $users);
            return response()->json([
                'users' => $usersArray,
                'status' => 'Success'
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }

    public function get(GetUser $getUseCase, int $id)
    {
        try {
            $user = $getUseCase->execute($id);
            return response()->json([
                'users' => $user->toArray(),
                'status' => 'Success'
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }

    public function store(RegisterUser $registerUseCase, Request $request)
    {
        try {
            $dto = UserCreateDTO::fromRequest($request);
            $user = $registerUseCase->execute($dto);

            return response()->json([
                'user' => $user->toArray(),
                'status' => 'Success'
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }


    public function update(int $id, UpdateUser $updateUseCase, Request $request)
    {
        try {
            $dto = UserUpdateDTO::fromRequest($request, $id);
            $user = $updateUseCase->execute($dto);

            return response()->json([
                'user' => $user->toArray(),
                'status' => 'Success'
            ], 200);
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
            return response()->json([
                'message' => 'Usuário deletado com sucesso',
                'status' => 'Success'
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }
}
