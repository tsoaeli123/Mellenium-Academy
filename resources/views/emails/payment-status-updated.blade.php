<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Status Update</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #1a472a;
            color: white;
            padding: 2rem;
            text-align: center;
            border-radius: 12px 12px 0 0;
        }
        .content {
            background: #f8fafc;
            padding: 2rem;
            border-radius: 0 0 12px 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            margin: 0.5rem 0;
        }
        .status-paid {
            background: #dcfce7;
            color: #166534;
        }
        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }
        .status-unpaid, .status-failed {
            background: #fee2e2;
            color: #dc2626;
        }
        .login-btn {
            display: inline-block;
            background: #1a472a;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 1rem 0;
            font-weight: 600;
        }
        .footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Millennium Academy</h1>
        <p>Payment Status Update</p>
    </div>

    <div class="content">
        <h2>Dear {{ $user->name }},</h2>

        <p>Your {{ $isEnrollment ? 'enrollment' : 'registration' }} payment status has been updated:</p>

        <div class="status-badge status-{{ $status }}">
            {{ ucfirst($status) }}
        </div>

        @if($status === 'paid')
            <div style="background: #dcfce7; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                <h3 style="color: #166534; margin-top: 0;">🎉 Payment Approved!</h3>
                <p>Your {{ $isEnrollment ? 'enrollment' : 'registration' }} payment has been approved. You can now login to your account and access all learning materials.</p>

                <a href="{{ url('/login') }}" class="login-btn">
                    Login to Your Account
                </a>
            </div>
        @elseif($status === 'pending')
            <div style="background: #fef3c7; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                <h3 style="color: #d97706; margin-top: 0;">⏳ Payment Under Review</h3>
                <p>Your payment is currently under review by our administration team. We'll notify you once it's processed.</p>
            </div>
        @elseif(in_array($status, ['unpaid', 'failed']))
            <div style="background: #fee2e2; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                <h3 style="color: #dc2626; margin-top: 0;">❌ Payment Issue</h3>
                <p>There seems to be an issue with your payment. Please contact administration or submit a new payment screenshot.</p>
            </div>
        @endif

        <p><strong>Student Details:</strong></p>
        <ul>
            <li><strong>Name:</strong> {{ $user->name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            @if(!$isEnrollment)
                <li><strong>Grade:</strong> {{ $user->grade ?? 'Not specified' }}</li>
            @endif
            <li><strong>Status Updated:</strong> {{ now()->format('F d, Y \a\t h:i A') }}</li>
        </ul>

        <p>If you have any questions, please contact our administration team.</p>

        <p>Best regards,<br>
        <strong>Millennium Academy Administration Team</strong></p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Millennium Academy. All rights reserved.</p>
        <p>"We either find a way or we make one. Yes we can."</p>
        <p>Powered by TechSolve</p>
    </div>
</body>
</html>
