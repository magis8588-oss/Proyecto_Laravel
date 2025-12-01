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
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
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
            border-left: 4px solid #ef4444;
            border-radius: 4px;
        }
        .info-row {
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #dc2626;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 20px;
            font-weight: bold;
        }
        .alert-warning {
            background: #fef3c7;
            border: 1px solid #fbbf24;
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
        <h1>❌ Cita No Disponible</h1>
        <p>Información sobre su solicitud de cita</p>
    </div>
    
    <div class="content">
        <p>Estimado/a <strong>{{ $appointment->patient_name }}</strong>,</p>
        
        <p>Lamentamos informarle que su solicitud de cita <strong>no puede ser confirmada</strong> en este momento.</p>
        
        <div class="info-box">
            <div class="info-row">
                <span class="label">Estado:</span>
                <span class="status-badge">✗ NO DISPONIBLE</span>
            </div>
            
            <div class="info-row">
                <span class="label">Médico solicitado:</span>
                Dr(a). {{ $appointment->doctor->name }}
            </div>
            
            <div class="info-row">
                <span class="label">Especialidad:</span>
                {{ $appointment->doctor->specialty }}
            </div>
            
            <div class="info-row">
                <span class="label">Fecha/Hora solicitada:</span>
                {{ $appointment->start_time->format('l, j \d\e F \d\e Y \a \l\a\s h:i A') }}
            </div>
            
            @if($appointment->admin_notes)
            <div class="info-row">
                <span class="label">Motivo:</span>
                {{ $appointment->admin_notes }}
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">Número de referencia:</span>
                #{{ $appointment->id }}
            </div>
        </div>
        
        <div class="alert-warning">
            <strong>💡 ¿Qué puede hacer ahora?</strong>
            <ul style="margin: 10px 0;">
                <li>Revisar otros horarios disponibles en nuestro sistema</li>
                <li>Consultar con otro especialista de la clínica</li>
                <li>Contactarnos directamente para buscar alternativas</li>
            </ul>
        </div>
        
        <p><strong>📞 Estamos aquí para ayudarle:</strong></p>
        <ul>
            <li>Email: {{ $appointment->doctor->email }}</li>
            <li>Teléfono: {{ $appointment->doctor->phone }}</li>
        </ul>
        
        <p>Nuestro equipo está disponible para asistirle en encontrar un horario que se ajuste a sus necesidades.</p>
        
        <p>Agradecemos su comprensión.</p>
    </div>
    
    <div class="footer">
        <p>Este es un correo automático, por favor no responda a este mensaje.</p>
        <p>&copy; {{ date('Y') }} Clínica Oftalmológica - Todos los derechos reservados</p>
    </div>
</body>
</html>
