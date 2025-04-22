<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    
    <!-- import styles -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="components/sidebar-chat/sidebar-chat.css">
    <link rel="stylesheet" href="components/main//main.css">
    <link rel="stylesheet" href="components/messages-coming/messages-coming.css">
    <link rel="stylesheet" href="components/messages-sending/messages-sending.css">
</head>
<body>
    
    <div id="sidebar">
        <div id="sidebar-content">
            <div id="sidebar-content-search">
                <input type="text">
            </div>
            <div id="sidebar-content-chats">
                <?php
                    for($i = 1; $i <= 5; $i++){
                        include('components/sidebar-chat/sidebar-chat.html');
                    }
                    
                ?>
            </div>
        </div>
    </div>

    <div id="main">
        <?php
            include('components/main/main.php');
        ?>
    </div>
    <!-- import js -->
    <script src="components/sidebar-chat/sidebar-chat.js"></script>
</body>
</html>