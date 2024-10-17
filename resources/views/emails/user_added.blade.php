<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Mool Ferme</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #dee2e6;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #28a745;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }
        .footer a {
            color: #28a745;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Mool Ferme</h1>
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            <p>Thank you for joining Mool Ferme! We are excited to have you on board. Our platform is designed to help you manage your farm effectively and efficiently.</p>
            <p>Here's what you can expect:</p>
            <ul>
                <li>Track and manage your livestock easily.</li>
                <li>Get insights and reports to optimize your farm operations.</li>
                <li>Access to expert advice and resources.</li>
            </ul>
            <p>To get started, log in to your account and explore the features available. If you have any questions or need assistance, feel free to contact our support team.</p>
            <p>Best regards,</p>
            <p>The Mool Ferme Team</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Mool Ferme. All rights reserved.</p>
            <p><a href="mailto:support@moolferme.com">Contact Support</a></p>
        </div>
    </div>
</body>
</html>
