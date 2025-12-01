# Railway Deployment Helper Script (PowerShell)
# Ejecutar desde la raíz del proyecto en PowerShell

Write-Host "🚀 Preparando proyecto para Railway..." -ForegroundColor Cyan

# 1. Limpiar caché
Write-Host "`n🧹 Limpiando caché..." -ForegroundColor Yellow
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 2. Optimizar para producción
Write-Host "`n⚡ Optimizando..." -ForegroundColor Yellow
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Compilar assets
Write-Host "`n🎨 Compilando assets..." -ForegroundColor Yellow
npm ci
npm run build

# 4. Verificar archivos necesarios
Write-Host "`n📋 Verificando archivos..." -ForegroundColor Yellow
$files = @("Procfile", "nixpacks.toml", ".railwayignore", "railway.json")
$allFilesExist = $true

foreach ($file in $files) {
    if (Test-Path $file) {
        Write-Host "  ✅ $file existe" -ForegroundColor Green
    } else {
        Write-Host "  ❌ $file NO encontrado" -ForegroundColor Red
        $allFilesExist = $false
    }
}

if (-not $allFilesExist) {
    Write-Host "`n❌ Faltan archivos necesarios. Abortando." -ForegroundColor Red
    exit 1
}

# 5. Verificar git
Write-Host "`n📦 Verificando Git..." -ForegroundColor Yellow
if (Test-Path ".git") {
    Write-Host "  ✅ Repositorio Git inicializado" -ForegroundColor Green
    
    # Verificar si hay cambios sin commitear
    $gitStatus = git status --porcelain
    if ($gitStatus) {
        Write-Host "  ⚠️  Hay cambios sin commitear" -ForegroundColor Yellow
        Write-Host "  Ejecuta: git add . && git commit -m 'Preparar despliegue'" -ForegroundColor Yellow
    } else {
        Write-Host "  ✅ Todo está commiteado" -ForegroundColor Green
    }
} else {
    Write-Host "  ❌ No es un repositorio Git" -ForegroundColor Red
    Write-Host "  Ejecuta: git init && git add . && git commit -m 'Initial commit'" -ForegroundColor Yellow
    exit 1
}

# 6. Generar APP_KEY para mostrar
Write-Host "`n🔑 APP_KEY para Railway:" -ForegroundColor Cyan
php artisan key:generate --show

Write-Host "`n✅ ¡Proyecto listo para desplegar en Railway!" -ForegroundColor Green
Write-Host "`n📝 Próximos pasos:" -ForegroundColor Cyan
Write-Host "1. git push origin main" -ForegroundColor White
Write-Host "2. Ve a https://railway.app" -ForegroundColor White
Write-Host "3. Conecta tu repositorio" -ForegroundColor White
Write-Host "4. Agrega PostgreSQL" -ForegroundColor White
Write-Host "5. Configura las variables de entorno (ver .env.production.example)" -ForegroundColor White
Write-Host "6. ¡Despliega!" -ForegroundColor White
