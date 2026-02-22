<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
</head>
<body style="margin:0; padding:0; background-color:#1a1a2e; font-family:'Segoe UI',Arial,sans-serif;">
    <div style="max-width:600px; margin:0 auto; padding:40px 20px;">
        <!-- Header -->
        <div style="text-align:center; padding:30px; background:linear-gradient(135deg,#064e3b,#065f46); border-radius:16px 16px 0 0;">
            <div style="font-size:48px; margin-bottom:10px;">🌙</div>
            <h1 style="color:#fde047; margin:0; font-size:24px;">Booking Confirmed!</h1>
            <p style="color:#a7f3d0; margin:5px 0 0 0; font-size:14px;">Ramadan Buffet 2026</p>
        </div>
        
        <!-- Body -->
        <div style="background-color:#1e293b; padding:30px; border-radius:0 0 16px 16px;">
            <p style="color:#e2e8f0; font-size:16px; margin-top:0;">Assalamualaikum <strong>{{ $booking->name }}</strong>,</p>
            <p style="color:#94a3b8; font-size:14px;">Thank you for your reservation! Here are your booking details:</p>
            
            <!-- Booking Details -->
            <div style="background-color:#0f172a; border-radius:12px; padding:20px; margin:20px 0;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="padding:8px 0; color:#94a3b8; font-size:14px;">Reference:</td>
                        <td style="padding:8px 0; color:#fde047; font-size:18px; font-weight:bold; text-align:right;">{{ $booking->booking_reference }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#94a3b8; font-size:14px; border-top:1px solid #1e293b;">Date:</td>
                        <td style="padding:8px 0; color:#e2e8f0; font-size:14px; text-align:right; border-top:1px solid #1e293b;">{{ $booking->booking_date->format('l, d M Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#94a3b8; font-size:14px; border-top:1px solid #1e293b;">Time:</td>
                        <td style="padding:8px 0; color:#e2e8f0; font-size:14px; text-align:right; border-top:1px solid #1e293b;">6:00 PM - 10:00 PM</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#94a3b8; font-size:14px; border-top:1px solid #1e293b;">Adults:</td>
                        <td style="padding:8px 0; color:#e2e8f0; font-size:14px; text-align:right; border-top:1px solid #1e293b;">{{ $booking->adults }} pax</td>
                    </tr>
                    @if($booking->children > 0)
                    <tr>
                        <td style="padding:8px 0; color:#94a3b8; font-size:14px; border-top:1px solid #1e293b;">Children:</td>
                        <td style="padding:8px 0; color:#e2e8f0; font-size:14px; text-align:right; border-top:1px solid #1e293b;">{{ $booking->children }} pax</td>
                    </tr>
                    @endif
                    @if($booking->oku > 0)
                    <tr>
                        <td style="padding:8px 0; color:#94a3b8; font-size:14px; border-top:1px solid #1e293b;">OKU:</td>
                        <td style="padding:8px 0; color:#e2e8f0; font-size:14px; text-align:right; border-top:1px solid #1e293b;">{{ $booking->oku }} pax</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding:12px 0 0; color:#e2e8f0; font-size:16px; font-weight:bold; border-top:2px solid #334155;">Total Pax:</td>
                        <td style="padding:12px 0 0; color:#fde047; font-size:16px; font-weight:bold; text-align:right; border-top:2px solid #334155;">{{ $booking->total_pax }} pax</td>
                    </tr>
                </table>
            </div>
            
            <p style="color:#94a3b8; font-size:13px;">📍 <strong>Venue:</strong> Venue Address Here</p>
            <p style="color:#94a3b8; font-size:13px;">📞 <strong>Contact:</strong> +60 12-345 6789</p>
            
            <div style="text-align:center; margin-top:20px;">
                <p style="color:#6ee7b7; font-size:12px;">Please arrive 15 minutes before iftar time.</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="text-align:center; padding:20px;">
            <p style="color:#475569; font-size:12px; margin:0;">&copy; {{ date('Y') }} Ramadan Buffet Booking. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
