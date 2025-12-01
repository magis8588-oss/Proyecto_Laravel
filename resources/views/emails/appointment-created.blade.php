<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .info-box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #2563eb;
            border-radius: 4px;
        }
        .info-row {
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #2563eb;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background: #fef3c7;
            color: #92400e;
            border-radius: 20px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 Clínica Oftalmológica</h1>
        <p>Sistema de Agendamiento de Citas</p>
    </div>
    
    <div class="content">
        <h2>Cita Médica Creada</h2>
        
        <p>Estimado/a <strong>{{ $appointment->patient_name }}</strong>,</p>
        
        <p>Su solicitud de cita ha sido recibida exitosamente. Los detalles de su cita son los siguientes:</p>
        
        <div class="info-box">
            <div class="info-row">
                <span class="label">Estado:</span>
                <span class="status-badge">⏳ PENDIENTE DE CONFIRMACIÓN</span>
            </div>
            
            <div class="info-row">
                <span class="label">Médico:</span>
                {{ $appointment->doctor->name }}
            </div>
            
            <div class="info-row">
                <span class="label">Especialidad:</span>
                {{ $appointment->doctor->specialty }}
            </div>
            
            <div class="info-row">
                <span class="label">Fecha y Hora:</span>
                {{ $appointment->start_time->format('l, j \d\e F \d\e Y \a \l\a\s h:i A') }}
            </div>
            
            <div class="info-row">
                <span class="label">Duración:</span>
                {{ $appointment->start_time->diffInMinutes($appointment->end_time) }} minutos
            </div>
            
            @if($appointment->reason)
            <div class="info-row">
                <span class="label">Motivo de consulta:</span>
                {{ $appointment->reason }}
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">Número de referencia:</span>
                #{{ $appointment->id }}
            </div>
        </div>
        
        <p><strong>⚠️ Importante:</strong></p>
        <ul>
            <li>Su cita está <strong>pendiente de confirmación</strong> por parte del personal médico.</li>
            <li>Recibirá un correo de confirmación o rechazo en las próximas horas.</li>
            <li>Por favor, esté atento a su correo electrónico.</li>
        </ul>
        
        <p><strong>Datos de contacto:</strong></p>
        <ul>
            <li>Email: {{ $appointment->patient_email }}</li>
            <li>Teléfono: {{ $appointment->patient_phone }}</li>
        </ul>
        
        <p>Si necesita realizar algún cambio, por favor contáctenos.</p>
    </div>
    
    <div class="footer">
        <p>Este es un correo automático, por favor no responda a este mensaje.</p>
        <p>&copy; {{ date('Y') }} Clínica Oftalmológica - Todos los derechos reservados</p>
    </div>
</body>
</html>
