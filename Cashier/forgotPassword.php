<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="image-section">
            <img src="D:\IS\2 nd year\1 st semester\group\figma\IMG_2739.jpg" alt="Cookies" class="cookies-image">
        </div>
        <div class="login-section">
            <div class="logo">
                <!-- Add your logo image here -->
                <img src="F:\Downloads\WhatsApp_Image_2024-07-05_at_21.20.45_b979e253-removebg-preview (1).png" alt="Logo" class="logo-image">
                <h1>FROSTINE</h1>
                <p>From Oven to Doorstep, Effortlessly YC</p>
            </div>
            <h2>Reset Password!</h2>
            <form action="send-password-reset.php" method="POST">
                <div class="input-group">
                    <input type="email"name="email" placeholder="Email" required>
                </div>
               <!-- <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>-->
                <button type="submit" class="login-btn">Send</button>
            </form>
           <!-- <a href="#" class="forgot-password">Forgot Password?</a>-->
        </div>
    </div>
</body>
</html>
