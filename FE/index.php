<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
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

    <main>
        <div id="main-header">
            
        </div>
        <div id="main-chat">

        </div>
    </main>
</body>
</html>