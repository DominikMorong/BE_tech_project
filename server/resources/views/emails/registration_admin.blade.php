<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New user registred to conference</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
        }

        .message {
            padding: 20px;
            background-color: #ffffff;
        }

        .message p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        
        <div class="message">
            <p>Person with email: {{ $mailData['email'] }} just joined our conference</p>
        </div>
        
    </div>
</body>

</html>