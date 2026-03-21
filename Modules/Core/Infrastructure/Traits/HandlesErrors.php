<?php

namespace Modules\Core\Infrastructure\Traits;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

trait HandlesErrors
{
    protected function handleException(Exception $e, ?string $route = null)
    {
        if ($e instanceof ValidationException) {
            throw $e;
        }

        Log::error("[Error] " . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro interno.',
                'error'   => $e->getMessage()
            ], 500);
        }

        $redirect = $route ? redirect()->route($route) : back();
        return $redirect->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}
