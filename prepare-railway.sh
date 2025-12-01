#!/usr/bin/env bash
# Railway Deployment Helper Script
# Ejecutar desde la raíz del proyecto

set -e

echo "🚀 Preparando proyecto para Railway..."

# 1. Limpiar caché
echo "🧹 Limpiando caché..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 2. Optimizar para producción
echo "⚡ Optimizando..."
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Compilar assets
echo "🎨 Compilando assets..."
npm ci
npm run build

# 4. Verificar archivos necesarios
echo "📋 Verificando archivos..."
files=("Procfile" "nixpacks.toml" ".railwayignore" "railway.json")
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "  ✅ $file existe"
    else
        echo "  ❌ $file NO encontrado"
        exit 1
    fi
done

# 5. Verificar git
echo "📦 Verificando Git..."
if [ -d ".git" ]; then
    echo "  ✅ Repositorio Git inicializado"
    
    # Verificar si hay cambios sin commitear
    if [ -n "$(git status --porcelain)" ]; then
        echo "  ⚠️  Hay cambios sin commitear"
        echo "  Ejecuta: git add . && git commit -m 'Preparar despliegue'"
    else
        echo "  ✅ Todo está commiteado"
    fi
else
    echo "  ❌ No es un repositorio Git"
    echo "  Ejecuta: git init && git add . && git commit -m 'Initial commit'"
    exit 1
fi

# 6. Generar APP_KEY para mostrar
echo ""
echo "🔑 APP_KEY para Railway:"
php artisan key:generate --show
echo ""

echo "✅ ¡Proyecto listo para desplegar en Railway!"
echo ""
echo "📝 Próximos pasos:"
echo "1. git push origin main"
echo "2. Ve a https://railway.app"
echo "3. Conecta tu repositorio"
echo "4. Agrega PostgreSQL"
echo "5. Configura las variables de entorno (ver .env.production.example)"
echo "6. ¡Despliega!"
