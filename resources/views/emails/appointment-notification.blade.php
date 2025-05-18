<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Appointment Status</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #2c2c2c;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        h2 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1a1a1a;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        strong {
            font-weight: 600;
            color: #1a1a1a;
        }
        .footer {
            font-size: 13px;
            color: #888;
            text-align: center;
            margin-top: 32px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Dear {{ $appointment->FirstName }} {{ $appointment->LastName }},</h2>

        @if($appointment->Status === 'Approved')
            <p>Your appointment for <strong>{{ $appointment->pets->Name ?? 'your pet' }}</strong> has been <strong>approved</strong>.</p>

            <p><strong>Date:</strong> {{ \Illuminate\Support\Carbon::parse($appointment->AppointmentDate)->format('F j, Y') }}</p>
            <p><strong>Time:</strong> {{ \Illuminate\Support\Carbon::parse($appointment->AppointmentTime)->format('g:i A') }}</p>

            @if(!empty($appointment->Description))
                <p><strong>Reason for Visit:</strong> {{ $appointment->Description }}</p>
            @endif

            <p>We look forward to seeing you and your pet at your scheduled time.</p>

        @elseif($appointment->Status === 'Declined')
            <p>Unfortunately, your appointment request for <strong>{{ $appointment->pets->Name ?? 'your pet' }}</strong> on <strong>{{ \Illuminate\Support\Carbon::parse($appointment->AppointmentDate)->format('F j, Y') }}</strong> at <strong>{{ \Illuminate\Support\Carbon::parse($appointment->AppointmentTime)->format('g:i A') }}</strong> has been <strong>declined</strong>.</p>

            <p><strong>Reason:</strong> The selected time slot is no longer available. We recommend choosing a different time.</p>

            @if(!empty($appointment->Description))
                <p><strong>Reason for Visit:</strong> {{ $appointment->Description }}</p>
            @endif

            <p>If you need help rescheduling, feel free to contact us anytime.</p>
        @endif

        <p>Thank you for choosing our clinic.</p>

        <div class="footer">
            &copy; {{ date('Y') }} Pet Health Vault. All rights reserved.
        </div>
    </div>
</body>
</html>
