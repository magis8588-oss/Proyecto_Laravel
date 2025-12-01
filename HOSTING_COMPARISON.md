# 🌐 Comparación de Plataformas de Hosting Gratuitas para Laravel

## 🏆 Recomendación Principal: Railway.app

| Característica | Railway | Render | Fly.io | Heroku | Vercel/Netlify |
|---------------|---------|--------|--------|--------|----------------|
| **Plan Gratuito** | ✅ 500hrs/mes | ✅ Limitado | ✅ Limitado | ❌ No gratuito | ⚠️ Solo frontend |
| **Base de Datos Incluida** | ✅ PostgreSQL | ✅ PostgreSQL | ✅ PostgreSQL | 💰 Pago | ❌ No |
| **Facilidad de Uso** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐ | N/A |
| **Tiempo de Setup** | 5 min | 10 min | 15 min | 10 min | N/A |
| **Dominio HTTPS** | ✅ Automático | ✅ Automático | ✅ Automático | ✅ Automático | ✅ Automático |
| **Deploy Automático** | ✅ Git | ✅ Git | ✅ Git | ✅ Git | ✅ Git |
| **Cold Start** | ❌ No | ⚠️ Después 15min | ⚠️ Sí | ❌ No | N/A |
| **Soporte Email** | ✅ SMTP | ✅ SMTP | ✅ SMTP | ✅ SMTP | ❌ |
| **CLI Tool** | ✅ railway | ✅ render | ✅ flyctl | ✅ heroku | ✅ vercel/netlify |

---

## 1. 🚂 Railway.app (RECOMENDADO ⭐)

### ✅ Pros
- **Totalmente gratis** hasta 500 horas/mes
- PostgreSQL incluido sin costo
- Sin "cold starts" (app siempre activa)
- Deploy automático desde GitHub
- UI súper intuitiva
- Variables de entorno fáciles
- Logs en tiempo real
- Soporte para Laravel out-of-the-box

### ❌ Contras
- Límite de 500 horas/mes (≈ 20 días)
- Requiere tarjeta para plan Developer ($5/mes ilimitado)

### 💰 Costos
- **Hobby (Gratuito)**: $0/mes - 500 horas ejecución
- **Developer**: $5/mes - Uso ilimitado
- **Team**: $20/mes - Múltiples proyectos

### 📖 Guía
Ver [DEPLOYMENT.md](./DEPLOYMENT.md) para instrucciones completas.

### 🔗 Links
- Website: https://railway.app
- Docs: https://docs.railway.app
- Dashboard: https://railway.app/dashboard

---

## 2. 🎨 Render.com

### ✅ Pros
- PostgreSQL gratuito incluido
- Deploy automático desde Git
- SSL automático
- Buena documentación

### ❌ Contras
- **"Cold start"** después de 15 minutos de inactividad (app se duerme)
- La primera petición puede tardar 30-60 segundos
- Recursos limitados en plan gratuito
- Más lento que Railway

### 💰 Costos
- **Free**: $0/mes - Con sleep después de inactividad
- **Starter**: $7/mes - Sin sleep, más recursos

### 📋 Setup Rápido
```yaml
# render.yaml
services:
  - type: web
    name: laravel-app
    env: docker
    buildCommand: composer install && npm run build
    startCommand: php artisan serve --host=0.0.0.0 --port=$PORT
    envVars:
      - key: APP_KEY
        generateValue: true
      - key: DB_CONNECTION
        value: pgsql

databases:
  - name: postgres
    plan: free
```

### 🔗 Links
- Website: https://render.com
- Docs: https://render.com/docs

---

## 3. ✈️ Fly.io

### ✅ Pros
- Muy potente y escalable
- Red global de servidores
- PostgreSQL incluido
- CLI poderosa

### ❌ Contras
- **Requiere tarjeta de crédito** (aunque no cobran si no pasas límite)
- Curva de aprendizaje más pronunciada
- Configuración más compleja
- Cold starts en plan gratuito

### 💰 Costos
- **Hobby**: $0/mes - 3 VMs pequeñas
- Requiere tarjeta aunque sea gratuito

### 📋 Setup
Requiere crear `fly.toml` y usar CLI:
```bash
flyctl launch
flyctl deploy
```

### 🔗 Links
- Website: https://fly.io
- Docs: https://fly.io/docs

---

## 4. 💜 Heroku (Ya NO es gratuito)

### ⚠️ Aviso
Heroku eliminó su plan gratuito en noviembre 2022.

### 💰 Costos
- **Eco**: $5/mes - 1000 horas
- **Basic**: $7/mes - Por dyno
- **PostgreSQL**: $5/mes adicional

**No recomendado** por costo y hay mejores alternativas.

---

## 5. ⚡ Vercel / Netlify (NO recomendado para Laravel)

### ❌ Por qué NO usar
- **Solo sirven aplicaciones frontend** estáticas
- No soportan PHP nativo
- No tienen servidor persistente
- Solo serverless functions (limitadas)

### ✅ Alternativa
Si quieres usar Vercel/Netlify:
1. Deploy Laravel en Railway (backend)
2. Deploy Vue/React app en Vercel (frontend)
3. Conectarlos via API

---

## 📊 Comparación Detallada

### Velocidad de Deploy
```
Railway:  ⚡⚡⚡⚡⚡ (2-3 min)
Render:   ⚡⚡⚡⚡ (3-5 min)
Fly.io:   ⚡⚡⚡ (5-7 min)
```

### Facilidad de Uso
```
Railway:  ⭐⭐⭐⭐⭐ (Muy fácil)
Render:   ⭐⭐⭐⭐ (Fácil)
Fly.io:   ⭐⭐⭐ (Moderado)
```

### Confiabilidad
```
Railway:  ✅✅✅✅ (Sin sleep)
Fly.io:   ✅✅✅✅ (Sin sleep en plan pago)
Render:   ✅✅✅ (Sleep en plan free)
```

---

## 🎯 ¿Cuál Elegir?

### Para tu Proyecto Laravel de Citas

#### ✅ Elige Railway si:
- Quieres algo simple y rápido ✅
- No quieres "cold starts" ✅
- Necesitas base de datos gratis ✅
- Tu proyecto es académico/demo ✅
- **RECOMENDADO PARA TI** ✅

#### ⚠️ Elige Render si:
- No te importa el sleep de 15 min
- Tu proyecto tiene poco tráfico
- Quieres algo gratuito permanente

#### ⚠️ Elige Fly.io si:
- Tienes tarjeta de crédito
- Necesitas control avanzado
- Planeas escalar globalmente

#### ❌ NO elijas Heroku:
- Es más caro que las alternativas
- No tiene plan gratuito

---

## 🚀 Mi Recomendación para tu Proyecto

### 🏆 Opción 1: Railway (MEJOR)

**Por qué:**
- ✅ Setup en 5 minutos
- ✅ PostgreSQL incluido
- ✅ Sin cold starts
- ✅ 500 horas gratis (suficiente para demos)
- ✅ Fácil de usar
- ✅ Perfecto para proyectos académicos

**Cuándo pagar:**
Si tu proyecto se vuelve popular, $5/mes es muy barato.

### 🥈 Opción 2: Render (ALTERNATIVA)

**Por qué:**
- ✅ Completamente gratis
- ✅ PostgreSQL incluido
- ⚠️ Tiene sleep (30-60s primera carga)

**Ideal para:**
- Proyectos de portafolio
- Demos ocasionales
- No necesitas respuesta inmediata

---

## 📝 Guías de Deploy

### Railway
Ver [DEPLOYMENT.md](./DEPLOYMENT.md) ✅ **YA PREPARADO**

### Render
```bash
# 1. Crear cuenta en render.com
# 2. Conectar GitHub repo
# 3. Crear Web Service
# 4. Agregar PostgreSQL Database
# 5. Configurar variables de entorno
# 6. Deploy!
```

### Fly.io
```bash
# 1. Instalar flyctl
curl -L https://fly.io/install.sh | sh

# 2. Login
flyctl auth login

# 3. Launch app
flyctl launch

# 4. Deploy
flyctl deploy
```

---

## 🔒 Servicios Adicionales Gratuitos

### Email
- **Mailtrap** (dev/testing): https://mailtrap.io
- **Resend** (3000 emails/mes): https://resend.com
- **SendGrid** (100 emails/día): https://sendgrid.com
- **Gmail SMTP** (ilimitado): Gmail App Password

### Storage/CDN
- **Cloudinary** (10GB): https://cloudinary.com
- **ImageKit** (20GB): https://imagekit.io
- **AWS S3** (5GB free tier): https://aws.amazon.com/s3/

### Monitoreo
- **UptimeRobot** (50 monitores): https://uptimerobot.com
- **Better Uptime** (gratis): https://betteruptime.com
- **Sentry** (5k errores/mes): https://sentry.io

### Analytics
- **Google Analytics**: https://analytics.google.com
- **Plausible** (10k views/mes): https://plausible.io

---

## 💡 Tips Finales

1. **Empieza con Railway** - Es la opción más fácil
2. **Configura email** - Usa Gmail o Resend gratis
3. **Monitorea tu app** - Usa UptimeRobot
4. **Haz backups** - Descarga tu BD periódicamente
5. **Dominio custom** - Más adelante puedes comprarlo ($12/año)

---

## 🆘 ¿Necesitas Ayuda?

### Railway
- Discord: https://discord.gg/railway
- Docs: https://docs.railway.app

### Laravel
- Discord: https://discord.gg/laravel
- Foros: https://laracasts.com/discuss

### Este Proyecto
- GitHub Issues: https://github.com/EdisonGrGr/Proyecto_Laravel/issues
- Email: admin@oftalmo.ucaldas.edu.co

---

## ✅ Resumen Ejecutivo

| Plataforma | Costo | Setup | Performance | Recomendación |
|------------|-------|-------|-------------|---------------|
| **Railway** | $0 (500hrs) | 5 min | ⭐⭐⭐⭐⭐ | ✅ **USAR ESTA** |
| Render | $0 (con sleep) | 10 min | ⭐⭐⭐ | Alternativa |
| Fly.io | $0 (requiere TC) | 15 min | ⭐⭐⭐⭐ | Avanzado |
| Heroku | $5/mes | 10 min | ⭐⭐⭐⭐ | ❌ Mejor Railway |

**Decisión:** Usa Railway siguiendo [DEPLOYMENT.md](./DEPLOYMENT.md)
