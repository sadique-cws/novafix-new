<!DOCTYPE html>
<html>
<head>
    <title>NovaFix - Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f3f4f6">
        <tr>
            <td align="center" style="padding: 30px 10px;">
                <!-- Main Container -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" bgcolor="#4f46e5" style="padding: 30px 20px;">
                            <h1 style="margin:0; font-size:28px; font-weight:bold; color:#ffffff;">NovaFix</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px 25px; color:#333333; font-size:16px; line-height:1.6;">
                            <h2 style="margin-top:0; font-size:22px; color:#111827; text-align:center;">Password Reset Request</h2>
                            <p style="margin:20px 0; text-align:center;">
                                You are receiving this email because we received a password reset request for your NovaFix account.
                            </p>
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ url('reset-password/' . $token . '?email=' . urlencode($email)) }}"
                                   style="background-color:#4f46e5; color:#ffffff; padding:14px 28px; font-size:16px; text-decoration:none; border-radius:6px; display:inline-block; font-weight:bold;">
                                    Reset Password
                                </a>
                            </div>
                            <p style="text-align:center; color:#6b7280; font-size:14px;">
                                This password reset link will expire in 60 minutes.
                            </p>
                            <p style="text-align:center; color:#6b7280; font-size:14px;">
                                If you did not request a password reset, no further action is required.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td bgcolor="#f9fafb" style="padding:20px; text-align:center; font-size:13px; color:#6b7280;">
                            &copy; {{ date('Y') }} NovaFix. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
