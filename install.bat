@echo off
echo ====================================================
echo   INSTALADOR COMPLETO: PHP + NODE + ADMINLTE
echo ====================================================

:: 1. PHP e Composer
echo [1/8] Instalando dependencias do PHP (Composer)...
call composer install

:: 2. Limpeza Pesada (O segredo para matar o erro de Reflection)
echo [2/8] Deletando arquivos de cache manualmente...
if exist "bootstrap\cache\config.php" del /f /q "bootstrap\cache\config.php"
if exist "bootstrap\cache\services.php" del /f /q "bootstrap\cache\services.php"
if exist "bootstrap\cache\packages.php" del /f /q "bootstrap\cache\packages.php"
if exist "bootstrap\cache\routes-v7.php" del /f /q "bootstrap\cache\routes-v7.php"

echo [3/8] Limpando caches via Artisan e otimizando Autoload...
call php artisan optimize:clear
call composer dump-autoload -o

:: 3. Node e Assets (Vite)
echo [4/8] Instalando dependencias do Node (NPM)...
call npm install

echo [5/8] Compilando assets para Producao (Vite Build)...
call npm run build

:: 4. Configurações Finais
echo [6/8] Verificando arquivo .env...
if not exist ".env" (
    copy .env.example .env
    echo .env criado a partir do exemplo.
)

echo [7/8] Gerando Key e linkando Storage...
call php artisan key:generate
call php artisan storage:link

echo ====================================================
echo   INSTALACAO CONCLUIDA!
echo ====================================================
echo   PROXIMOS PASSOS OBRIGATORIOS:
echo   1. Configurar .env (DB_DATABASE, DB_USERNAME, etc).
echo   2. Executar: php artisan migrate --seed
echo.
echo   NOTA: O comando --seed e essencial para criar os 
echo   perfis (Admin/Funcionario) e seu usuario de acesso.
echo ====================================================

echo [8/8] Abrindo o projeto...
:: Abre o navegador
start http://crm_base.test/login

pause