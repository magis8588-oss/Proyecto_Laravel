# 🚀 Guía de Despliegue en Railway

## ¿Por qué Railway?
- ✅ **Totalmente GRATIS** para empezar (plan Hobby)
- ✅ Base de datos PostgreSQL incluida
- ✅ 500 horas de ejecución al mes gratis
- ✅ Dominio HTTPS automático
- ✅ Despliegue automático desde GitHub
- ✅ Variables de entorno fáciles de configurar

## 📋 Pasos para Desplegar

### 1. Preparar tu Repositorio
```bash
# Asegúrate de que todo esté committeado
git add .
git commit -m "Preparar para despliegue en Railway"
git push origin main
```

### 2. Crear Cuenta en Railway
1. Ve a [railway.app](https://railway.app)
2. Regístrate con tu cuenta de GitHub (es gratis)

### 3. Crear Nuevo Proyecto
1. Click en "New Project"
2. Selecciona "Deploy from GitHub repo"
3. Autoriza Railway a acceder a tus repos
4. Selecciona tu repositorio `Proyecto_Laravel`

### 4. Agregar Base de Datos PostgreSQL
1. En tu proyecto, click en "+ New"
2. Selecciona "Database" → "Add PostgreSQL"
3. Railway creará automáticamente la base de datos

### 5. Configurar Variables de Entorno
En tu servicio de Laravel, ve a "Variables" y agrega:

```env
APP_NAME=SistemaCitas
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-app.up.railway.app

# Laravel generará esta automáticamente, pero puedes usar:
APP_KEY=base64:TU_CLAVE_AQUI

# Database (Railway las conecta automáticamente)
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

# Session y Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (usa Mailtrap gratis o Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-password-de-aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Jetstream
FORTIFY_FEATURES=registration,reset-passwords,email-verification,update-profile-information,update-passwords,two-factor-authentication
```

### 6. Generar APP_KEY
En Railway, ve a la pestaña "Settings" → "Deploy" y ejecuta:
```bash
php artisan key:generate --show
```
Copia el resultado y agrégalo como variable `APP_KEY`

### 7. Desplegar
1. Railway desplegará automáticamente
2. Espera 3-5 minutos
3. Tu app estará disponible en el dominio generado

### 8. Verificar Despliegue
1. Ve a "Deployments" y revisa los logs
2. Verifica que las migraciones se ejecutaron correctamente
3. Prueba tu aplicación en el dominio generado

## 🔧 Configuración de Correo

### Opción 1: Gmail (Gratis)
1. Habilita "Verificación en 2 pasos" en tu cuenta de Google
2. Genera una "Contraseña de aplicación" en: https://myaccount.google.com/apppasswords
3. Usa esa contraseña en `MAIL_PASSWORD`

### Opción 2: Mailtrap (Gratis para desarrollo)
1. Crea cuenta en [mailtrap.io](https://mailtrap.io)
2. Copia las credenciales SMTP
3. Úsalas en tus variables de entorno

### Opción 3: Resend (Gratis hasta 3000 emails/mes)
1. Crea cuenta en [resend.com](https://resend.com)
2. Obtén tu API key
3. Configura:
```env
MAIL_MAILER=resend
RESEND_KEY=tu-api-key
```

## 🐛 Solución de Problemas

### Error: "No application encryption key"
```bash
# En Railway Settings → Deploy, ejecuta:
php artisan key:generate
```

### Error de Base de Datos
Verifica que las variables `${{Postgres.*}}` estén correctamente configuradas

### Assets no se cargan
Asegúrate de que `npm run build` se ejecutó correctamente en los logs

### Error 500
Revisa los logs en Railway → Deployments → View Logs

## 📊 Monitoreo
- **Logs en tiempo real**: Railway → Deployments → View Logs
- **Métricas**: Railway → Metrics (CPU, RAM, Network)
- **Base de datos**: Railway → PostgreSQL → Query

## 💰 Costos
- **Plan Hobby**: $0/mes - 500 horas de ejecución
- **Plan Developer**: $5/mes - Uso ilimitado
- Tu proyecto debería funcionar perfectamente en el plan gratuito

## 🔄 Actualizaciones
Railway desplegará automáticamente cuando hagas push a tu rama principal:
```bash
git add .
git commit -m "Actualización"
git push origin main
```

## 🌐 Alternativas Gratuitas

### Render.com
- Gratis pero más lento
- Tiene "sleep" después de 15 minutos de inactividad

### Fly.io
- Más complejo de configurar
- Requiere tarjeta de crédito

### Heroku
- Ya no tiene plan gratuito

## ✅ Railway es la MEJOR opción actual para Laravel
