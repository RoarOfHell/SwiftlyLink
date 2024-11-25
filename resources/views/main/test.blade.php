<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voice Chat</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .chat-box {
            margin: 0 auto;
            width: 80%;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="chat-box">
        <input type="text" name="user_id" id="user_id">
        <input type="button" value="Connect" onclick="test()">
    </div>

    <script src="./js/test/test.js"></script>
</body>
</html>
