# 🚂 Comandos Útiles para Railway

## Comandos Railway CLI (Opcional)

### Instalar Railway CLI
```bash
# Windows (PowerShell)
iwr https://railway.app/install.ps1 | iex

# macOS/Linux
curl -fsSL https://railway.app/install.sh | sh
```

### Comandos Básicos
```bash
# Iniciar sesión
railway login

# Vincular proyecto existente
railway link

# Ver logs en tiempo real
railway logs

# Ejecutar comandos en el servidor
railway run php artisan migrate
railway run php artisan tinker

# Abrir en navegador
railway open

# Ver variables de entorno
railway variables

# Agregar variable
railway variables set APP_DEBUG=false
```

## Comandos Laravel para Producción

### En tu computadora (antes de deploy)
```bash
# Preparar proyecto
./prepare-railway.ps1  # En Windows PowerShell
# o
bash prepare-railway.sh  # En Linux/Mac

# Generar APP_KEY
php artisan key:generate --show

# Verificar que todo compile
npm run build

# Optimizar autoloader
composer install --no-dev --optimize-autoloader
```

### En Railway (usando Railway CLI)
```bash
# Ejecutar migraciones
railway run php artisan migrate --force

# Ejecutar seeders
railway run php artisan db:seed --force

# Limpiar caché
railway run php artisan cache:clear
railway run php artisan config:clear
railway run php artisan view:clear

# Optimizar
railway run php artisan optimize

# Crear usuario admin
railway run php artisan tinker
```

## Comandos Git

### Preparar despliegue
```bash
# Ver estado
git status

# Agregar todos los archivos
git add .

# Commit
git commit -m "Preparar para despliegue en Railway"

# Push (esto activará el despliegue en Railway)
git push origin main
```

### Desplegar una rama específica
```bash
# Cambiar de rama en Railway
railway environment

# O especificar rama en settings de Railway
```

## Base de Datos PostgreSQL

### Conectar a la base de datos de Railway
```bash
# Obtener URL de conexión
railway variables | grep DATABASE_URL

# Conectar con psql
railway run psql $DATABASE_URL

# O copiar credenciales y usar pgAdmin
```

### Comandos SQL útiles
```sql
-- Ver todas las tablas
\dt

-- Ver estructura de una tabla
\d appointments

-- Ver registros
SELECT * FROM users;
SELECT * FROM doctors;
SELECT * FROM appointments;

-- Crear usuario admin manualmente
INSERT INTO users (name, email, email_verified_at, password, created_at, updated_at)
VALUES (
    'Administrador',
    'admin@oftalmo.app',
    NOW(),
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: password
    NOW(),
    NOW()
);
```

## Debugging en Railway

### Ver logs en tiempo real
```bash
# Todos los logs
railway logs

# Últimos 100 logs
railway logs --limit 100

# Filtrar por texto
railway logs | grep ERROR
```

### Ver uso de recursos
```bash
# Abrir dashboard
railway open
# Luego ir a Metrics
```

### Ejecutar comandos de debugging
```bash
# Ver configuración de Laravel
railway run php artisan config:show

# Ver rutas
railway run php artisan route:list

# Verificar conexión a BD
railway run php artisan migrate:status

# Ejecutar tinker (REPL de Laravel)
railway run php artisan tinker
```

## Comandos de Email Testing

### Enviar email de prueba
```bash
# Localmente
php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# En Railway
railway run php artisan tinker
>>> Mail::raw('Test email', function($msg) { $msg->to('test@example.com')->subject('Test'); });
```

### Ver cola de emails
```bash
# Si usas queue
railway run php artisan queue:work --once
```

## Rollback y Recuperación

### Revertir migraciones
```bash
# En Railway
railway run php artisan migrate:rollback

# Revertir todas
railway run php artisan migrate:reset

# Resetear y volver a migrar
railway run php artisan migrate:fresh --force
```

### Revertir a commit anterior
```bash
# Ver historial
git log --oneline

# Revertir a commit específico
git revert <commit-hash>
git push origin main
```

## Mantenimiento

### Poner en modo mantenimiento
```bash
railway run php artisan down --secret="mi-secret-token"
# Acceder: https://tu-app.railway.app/mi-secret-token
```

### Salir de modo mantenimiento
```bash
railway run php artisan up
```

### Limpiar todo el caché
```bash
railway run php artisan optimize:clear
```

## Backup de Base de Datos

### Crear backup
```bash
# Obtener DATABASE_URL de Railway
railway variables | grep DATABASE_URL

# Hacer dump con pg_dump (instalar PostgreSQL client)
pg_dump "postgresql://user:pass@host:port/db" > backup.sql
```

### Restaurar backup
```bash
psql "postgresql://user:pass@host:port/db" < backup.sql
```

## Monitoreo

### Ver estado del servicio
```bash
railway status
```

### Ver variables de entorno
```bash
railway variables
```

### Abrir dashboard web
```bash
railway open
```

## Tips de Performance

### Cachear configuración
```bash
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache
```

### Ver tamaño de base de datos
```sql
SELECT
    pg_size_pretty(pg_database_size(current_database())) as db_size;
```

### Optimizar base de datos
```sql
VACUUM ANALYZE;
```

## Troubleshooting Común

### Error: "No application encryption key"
```bash
# Generar key
php artisan key:generate --show

# Copiar el resultado y agregarlo a Railway variables
railway variables set APP_KEY="base64:..."
```

### Error: "Class not found"
```bash
railway run composer dump-autoload
railway run php artisan optimize:clear
```

### Error: "Storage not linked"
```bash
railway run php artisan storage:link
```

### 500 Internal Server Error
```bash
# Ver logs detallados
railway logs

# Habilitar debug temporalmente (solo para investigar)
railway variables set APP_DEBUG=true
# No olvides volver a false después
railway variables set APP_DEBUG=false
```

## Scripts de Automatización

### Script de despliegue completo
```bash
#!/bin/bash
echo "🚀 Desplegando a Railway..."

# Optimizar localmente
composer install --no-dev --optimize-autoloader
npm run build

# Commit y push
git add .
git commit -m "Deploy: $(date +%Y-%m-%d)"
git push origin main

# Esperar y verificar
echo "⏳ Esperando despliegue..."
sleep 30
railway logs --limit 20

echo "✅ Despliegue completado"
```

---

## 📚 Referencias

- Railway Docs: https://docs.railway.app
- Laravel Docs: https://laravel.com/docs
- PostgreSQL Docs: https://www.postgresql.org/docs/
