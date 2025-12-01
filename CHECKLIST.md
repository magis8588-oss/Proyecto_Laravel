# ✅ Checklist Pre-Despliegue

## Antes de Desplegar en Railway

### 🔍 1. Verificar Archivos del Proyecto
- [ ] `Procfile` existe en la raíz
- [ ] `nixpacks.toml` existe en la raíz
- [ ] `.railwayignore` existe en la raíz
- [ ] `railway.json` existe en la raíz
- [ ] Todos los archivos están commiteados en Git

### 📦 2. Dependencias
- [ ] `composer.json` está actualizado
- [ ] `package.json` está actualizado
- [ ] No hay dependencias de desarrollo en producción

### 🗄️ 3. Base de Datos
- [ ] Las migraciones están probadas localmente
- [ ] Los seeders funcionan correctamente
- [ ] No hay migraciones pendientes

### 🔐 4. Configuración
- [ ] `.env.example` está actualizado
- [ ] `.env.production.example` está disponible
- [ ] Las credenciales sensibles NO están en el código

### 📧 5. Correo Electrónico
Elige una opción:
- [ ] Gmail configurado con contraseña de aplicación
- [ ] Mailtrap configurado (solo testing)
- [ ] Resend configurado
- [ ] SendGrid configurado

### 🎨 6. Assets Frontend
- [ ] `npm run build` funciona sin errores
- [ ] Los assets compilados están en `public/build`
- [ ] Vite está configurado correctamente

### 🔒 7. Seguridad
- [ ] `APP_DEBUG=false` en producción
- [ ] `APP_ENV=production` configurado
- [ ] Todas las rutas admin tienen middleware `auth`
- [ ] CSRF protection habilitado

### 🧪 8. Testing Local
```bash
# Probar con configuración de producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan serve
```
- [ ] La aplicación inicia sin errores
- [ ] Las rutas públicas funcionan
- [ ] El login funciona
- [ ] El dashboard carga correctamente
- [ ] Las notificaciones de email se envían

### 📝 9. Git
```bash
# Verificar estado
git status

# Asegurarse de que todo esté commiteado
git add .
git commit -m "Preparar para despliegue en Railway"
git push origin main
```
- [ ] Todo está commiteado
- [ ] El repositorio está en GitHub
- [ ] El branch principal es `main` o `master`

## Durante el Despliegue en Railway

### 🚂 1. Crear Proyecto
- [ ] Cuenta de Railway creada
- [ ] Nuevo proyecto creado
- [ ] Repositorio GitHub conectado

### 🐘 2. Base de Datos PostgreSQL
- [ ] PostgreSQL agregado al proyecto
- [ ] Variables de conexión automáticas configuradas

### ⚙️ 3. Variables de Entorno
Copiar de `.env.production.example` y configurar:

**Obligatorias:**
- [ ] `APP_NAME`
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` (generar con `php artisan key:generate --show`)
- [ ] `APP_URL` (el dominio que Railway te asigne)

**Base de Datos (Railway las configura automáticamente):**
- [ ] `DB_CONNECTION=pgsql`
- [ ] `DB_HOST=${{Postgres.PGHOST}}`
- [ ] `DB_PORT=${{Postgres.PGPORT}}`
- [ ] `DB_DATABASE=${{Postgres.PGDATABASE}}`
- [ ] `DB_USERNAME=${{Postgres.PGUSER}}`
- [ ] `DB_PASSWORD=${{Postgres.PGPASSWORD}}`

**Email (configurar una opción):**
- [ ] `MAIL_MAILER`
- [ ] `MAIL_HOST`
- [ ] `MAIL_PORT`
- [ ] `MAIL_USERNAME`
- [ ] `MAIL_PASSWORD`
- [ ] `MAIL_FROM_ADDRESS`
- [ ] `MAIL_FROM_NAME`

### 🚀 4. Iniciar Despliegue
- [ ] Railway inicia el build automáticamente
- [ ] El build completa sin errores
- [ ] Las migraciones se ejecutan correctamente
- [ ] Los seeders se ejecutan (si es primer despliegue)

## Después del Despliegue

### ✅ 1. Verificación Básica
- [ ] La aplicación está accesible en el dominio
- [ ] La página de inicio carga correctamente
- [ ] Los estilos se aplican correctamente
- [ ] Las imágenes cargan

### 🔐 2. Autenticación
- [ ] La página de login funciona
- [ ] Puedes iniciar sesión con las credenciales del seeder
- [ ] El dashboard del admin carga

### 📊 3. Funcionalidad
- [ ] Puedes ver la lista de médicos
- [ ] Puedes crear una nueva cita
- [ ] Las notificaciones de email funcionan
- [ ] El admin puede gestionar citas

### 📈 4. Logs y Monitoreo
- [ ] Revisar logs en Railway Dashboard
- [ ] No hay errores críticos
- [ ] La memoria y CPU están en rangos normales

### 🐛 5. Depuración (si hay errores)

**Error 500:**
```bash
# En Railway, ver logs detallados
railway logs

# Verificar APP_KEY
php artisan key:generate --show
```

**Error de Base de Datos:**
- Verificar que las variables `${{Postgres.*}}` estén correctamente configuradas
- Verificar que las migraciones se ejecutaron

**Assets no cargan:**
- Verificar que `npm run build` se ejecutó en los logs
- Verificar el `APP_URL` en las variables de entorno

**Emails no se envían:**
- Verificar credenciales MAIL_*
- Revisar logs de Railway
- Probar con Mailtrap primero

## 📞 Soporte

### Railway
- Documentación: https://docs.railway.app
- Discord: https://discord.gg/railway
- Status: https://status.railway.app

### Laravel
- Documentación: https://laravel.com/docs
- Foros: https://laracasts.com/discuss

## 🎉 ¡Despliegue Exitoso!

Si todos los checks están marcados, tu aplicación está funcionando correctamente en producción.

**URL de tu aplicación:** https://tu-app.up.railway.app

**Próximos pasos:**
1. Configurar dominio personalizado (opcional)
2. Configurar backups de base de datos
3. Monitorear uso de recursos
4. Configurar alertas

---

**Fecha de despliegue:** ___________
**Dominio:** ___________
**Versión:** ___________
