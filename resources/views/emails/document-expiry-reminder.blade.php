<!DOCTYPE html>
<html>
<head>
    <title>Document Expiry Reminder</title>
</head>
<body>

    <h2>Document Expiry Reminder</h2>

    <p>Hello {{ $document->user->name ?? 'User' }},</p>

    <p>This is a reminder that your document is going to expire soon.</p>

    <p><strong>Document Name:</strong> {{ $document->document_name }}</p>

    <p><strong>Document Type:</strong> {{ $document->document_type }}</p>

    <p><strong>Expiry Date:</strong> {{ $document->expiry_date->format('d M Y') }}</p>

    <p><strong>Days Remaining:</strong> {{ $days }} days</p>

    <p>Please renew your document before it expires.</p>

    <p>Thank you,<br>Document Expiry Reminder System</p>

</body>
</html>