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
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
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
            border-left: 4px solid #10b981;
            border-radius: 4px;
        }
        .info-row {
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #059669;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 20px;
            font-weight: bold;
        }
        .alert-success {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
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
        <h1>✅ Cita Confirmada</h1>
        <p>Su cita ha sido confirmada exitosamente</p>
    </div>
    
    <div class="content">
        <div class="alert-success">
            <strong>¡Excelente!</strong> Su cita médica ha sido confirmada por nuestro equipo.
        </div>
        
        <p>Estimado/a <strong>{{ $appointment->patient_name }}</strong>,</p>
        
        <p>Nos complace informarle que su cita ha sido <strong>CONFIRMADA</strong>. Por favor, revise los detalles a continuación:</p>
        
        <div class="info-box">
            <div class="info-row">
                <span class="label">Estado:</span>
                <span class="status-badge">✓ CONFIRMADA</span>
            </div>
            
            <div class="info-row">
                <span class="label">Médico:</span>
                Dr(a). {{ $appointment->doctor->name }}
            </div>
            
            <div class="info-row">
                <span class="label">Especialidad:</span>
                {{ $appointment->doctor->specialty }}
            </div>
            
            <div class="info-row">
                <span class="label">Fecha y Hora:</span>
                {{ $appointment->start_time->format('l, j \d\e F \d\e Y') }}<br>
                <strong>{{ $appointment->start_time->format('h:i A') }}</strong>
            </div>
            
            <div class="info-row">
                <span class="label">Duración estimada:</span>
                {{ $appointment->start_time->diffInMinutes($appointment->end_time) }} minutos
            </div>
            
            @if($appointment->admin_notes)
            <div class="info-row">
                <span class="label">Notas importantes:</span>
                {{ $appointment->admin_notes }}
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">Número de cita:</span>
                #{{ $appointment->id }}
            </div>
        </div>
        
        <p><strong>📋 Recomendaciones antes de su cita:</strong></p>
        <ul>
            <li>Llegue 15 minutos antes de su hora programada</li>
            <li>Traiga su documento de identidad</li>
            <li>Si usa lentes de contacto, traiga su estuche</li>
            <li>Traiga sus lentes actuales (si los usa)</li>
            <li>Lista de medicamentos que está tomando actualmente</li>
            <li>Resultados de exámenes previos (si los tiene)</li>
        </ul>
        
        <p><strong>📍 Ubicación de la clínica:</strong></p>
        <p>{{ $appointment->doctor->email }}<br>
        Teléfono: {{ $appointment->doctor->phone }}</p>
        
        <p><strong>⚠️ Si necesita cancelar o reprogramar:</strong></p>
        <p>Por favor, contáctenos con al menos 24 horas de anticipación.</p>
    </div>
    
    <div class="footer">
        <p>Este es un correo automático, por favor no responda a este mensaje.</p>
        <p>&copy; {{ date('Y') }} Clínica Oftalmológica - Todos los derechos reservados</p>
    </div>
</body>
</html>
