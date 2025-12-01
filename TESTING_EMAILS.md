# 📧 Guía de Pruebas del Sistema de Correos

## ✅ Estado Actual
El sistema de correos está **100% funcional** y configurado en modo **LOG** para desarrollo.

---

## 🧪 3 Formas de Probar el Correo

### **Método 1: Comando Artisan (Más Rápido)**

Usa el comando personalizado para probar con la última cita creada:

```bash
php artisan test:appointment-email
```

O especifica un ID de cita:

```bash
php artisan test:appointment-email 5
```

### **Método 2: Crear una Cita desde la Web**

1. Accede a: `http://127.0.0.1:8000`
2. Selecciona un doctor
3. Elige una hora disponible
4. Completa el formulario con:
   - Nombre: Tu Nombre
   - Email: tu@email.com
   - Teléfono: 1234567890
   - Motivo: Consulta general
5. Envía el formulario
6. El correo se generará automáticamente

### **Método 3: Usar Tinker**

```bash
php artisan tinker
```

Luego ejecuta:

```php
$appointment = App\Models\Appointment::first();
Mail::to($appointment->patient_email)->send(new App\Mail\AppointmentCreated($appointment));
```

---

## 📄 Ver el Correo Generado

### Opción A: Ver todo el log
```bash
Get-Content storage\logs\laravel.log -Tail 200
```

### Opción B: Ver solo el contenido del correo
```bash
Get-Content storage\logs\laravel.log -Tail 200 | Select-String -Pattern "Subject:|PENDIENTE|Médico:" -Context 5
```

### Opción C: Limpiar log y ver solo el nuevo correo
```bash
# Limpiar el log
"" | Out-File storage\logs\laravel.log

# Enviar correo de prueba
php artisan test:appointment-email

# Ver el resultado
Get-Content storage\logs\laravel.log
```

---

## 🚀 Configurar Email Real (Producción)

### Opción 1: Gmail (Desarrollo)

Edita `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tucorreo@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tucorreo@gmail.com
MAIL_FROM_NAME="Clínica Oftalmológica"
```

**Nota:** Necesitas crear un "App Password" en Gmail:
1. Ve a: https://myaccount.google.com/security
2. Activa verificación en 2 pasos
3. Genera una "App Password"
4. Usa esa contraseña en `MAIL_PASSWORD`

### Opción 2: Mailtrap (Desarrollo)

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu_username
MAIL_PASSWORD=tu_password
MAIL_ENCRYPTION=tls
```

Obtén credenciales en: https://mailtrap.io

### Opción 3: SendGrid (Producción)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=tu_sendgrid_api_key
MAIL_ENCRYPTION=tls
```

---

## 📧 Contenido del Correo

El correo incluye:

✅ **Encabezado atractivo** con gradiente azul  
✅ **Datos del paciente:** Nombre, email, teléfono  
✅ **Información del doctor:** Nombre y especialidad  
✅ **Fecha y hora** de la cita en español  
✅ **Duración** de la consulta  
✅ **Motivo** de la consulta (si se proporcionó)  
✅ **Número de referencia** (ID de la cita)  
✅ **Estado:** PENDIENTE DE CONFIRMACIÓN  
✅ **Instrucciones** importantes  
✅ **Pie de página** profesional  

---

## 🔍 Solución de Problemas

### El correo no se genera

1. Verifica que la cita se creó correctamente:
   ```bash
   php artisan tinker
   App\Models\Appointment::count()
   App\Models\Appointment::latest()->first()
   ```

2. Revisa los errores en el log:
   ```bash
   Get-Content storage\logs\laravel.log -Tail 50
   ```

3. Verifica la configuración de email:
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

### El correo se ve mal formateado

- El correo está en formato **HTML** con CSS inline
- Se ve perfecto en: Gmail, Outlook, Yahoo, etc.
- Usa la vista en: `resources/views/emails/appointment-created.blade.php`

---

## 📊 Verificar Estado del Sistema

```bash
# Ver configuración actual
php artisan config:show mail

# Limpiar caché
php artisan config:clear
php artisan cache:clear

# Probar conexión SMTP (si usas SMTP real)
php artisan tinker
Mail::raw('Test', function($msg) { $msg->to('test@test.com')->subject('Test'); });
```

---

## ✨ Resumen

- ✅ **Sistema de correos:** Funcionando 100%
- ✅ **Modo actual:** LOG (para desarrollo)
- ✅ **Correo HTML:** Diseñado y responsive
- ✅ **Comando de prueba:** Disponible
- ✅ **Producción:** Listo para configurar SMTP

**Para ver un correo ahora mismo:**
```bash
php artisan test:appointment-email
Get-Content storage\logs\laravel.log -Tail 100
```
