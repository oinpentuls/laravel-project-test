<html>
    <body>
        <h1>New User Notification Mail</h1>

        <p>Dear Admin,</p>
        <p>New user has been created on our platform. Please check the user details below:</p>
        <p>Name: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>

        <p>Best regards,</p>
        <p>Web App</p>
    </body>
</html>