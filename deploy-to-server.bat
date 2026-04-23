@echo off
REM Script de Deploy para Financeiro Pro Whats (Windows)
REM Este script facilita o envio dos arquivos para o servidor via SSH

setlocal enabledelayedexpansion

echo.
echo ================================================================
echo.
echo         Deploy Financeiro Pro Whats via SSH
echo.
echo ================================================================
echo.

REM Verificar se o WinSCP está instalado
where winscp >nul 2>nul
if %errorlevel% neq 0 (
    echo.
    echo AVISO: WinSCP nao encontrado!
    echo.
    echo Este script funciona melhor com WinSCP instalado.
    echo Baixe em: https://winscp.net/
    echo.
    echo Alternativas:
    echo 1. Use FileZilla para enviar os arquivos manualmente
    echo 2. Use Git no servidor: git clone + git pull
    echo 3. Instale WinSCP e execute este script novamente
    echo.
    pause
    exit /b 1
)

REM Coletar informações
set /p SSH_USER="Digite o usuario SSH: "
set /p SSH_HOST="Digite o host/IP do servidor: "
set /p SSH_PORT="Digite a porta SSH (padrao 22): "
if "%SSH_PORT%"=="" set SSH_PORT=22
set /p REMOTE_PATH="Digite o caminho no servidor (ex: /home/usuario/public_html): "

echo.
echo Configuracao:
echo    Usuario: %SSH_USER%
echo    Host: %SSH_HOST%
echo    Porta: %SSH_PORT%
echo    Caminho: %REMOTE_PATH%
echo.
set /p CONFIRM="Confirma? (s/n): "

if /i not "%CONFIRM%"=="s" (
    echo.
    echo Deploy cancelado.
    pause
    exit /b 1
)

echo.
echo Preparando arquivos...
echo.

REM Compilar assets
echo Compilando assets...
call npm run build
if errorlevel 1 (
    echo.
    echo ERRO ao compilar assets!
    pause
    exit /b 1
)

REM Instalar dependências
echo.
echo Instalando dependencias do Composer...
call composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-curl --ignore-platform-req=ext-pcntl
if errorlevel 1 (
    echo.
    echo ERRO ao instalar dependencias!
    pause
    exit /b 1
)

REM Criar script WinSCP
echo.
echo Criando script de sincronizacao...
echo open sftp://%SSH_USER%@%SSH_HOST%:%SSH_PORT% > winscp_script.txt
echo option batch abort >> winscp_script.txt
echo option confirm off >> winscp_script.txt
echo synchronize remote -delete -criteria=time ^
    -filemask="|.git/;.env;node_modules/;storage/logs/*;storage/framework/cache/*;storage/framework/sessions/*;storage/framework/views/*;tests/;*.md;setup.bat;setup.sh;deploy-to-server.bat;deploy-to-server.sh" ^
    . %REMOTE_PATH% >> winscp_script.txt
echo close >> winscp_script.txt
echo exit >> winscp_script.txt

echo.
echo Enviando arquivos para o servidor...
echo Isso pode levar alguns minutos...
echo.

REM Executar WinSCP
winscp.com /script=winscp_script.txt

if errorlevel 1 (
    echo.
    echo ERRO ao enviar arquivos!
    echo Verifique suas credenciais SSH e tente novamente.
    del winscp_script.txt
    pause
    exit /b 1
)

REM Limpar
del winscp_script.txt

echo.
echo ================================================================
echo Arquivos enviados com sucesso!
echo ================================================================
echo.
echo Proximos passos no servidor:
echo.
echo 1. Conecte ao servidor via SSH
echo.
echo 2. Configure o .env:
echo    cp .env.example .env
echo    nano .env
echo.
echo 3. Gere a chave da aplicacao:
echo    php artisan key:generate
echo.
echo 4. Execute as migrations:
echo    php artisan migrate --force
echo    php artisan db:seed --force
echo.
echo 5. Configure permissoes:
echo    chmod -R 775 storage bootstrap/cache
echo.
echo 6. Otimize para producao:
echo    php artisan config:cache
echo    php artisan route:cache
echo    php artisan view:cache
echo.
echo Consulte DEPLOY_SSH.md para mais detalhes!
echo.
echo ================================================================
echo Deploy concluido!
echo ================================================================
echo.
pause
