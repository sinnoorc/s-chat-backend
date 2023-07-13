<!DOCTYPE html>
<html>
<head>
    <title>API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            margin-top: 30px;
        }
        p {
            margin-bottom: 10px;
        }
        code {
            background-color: #f1f1f1;
            padding: 2px;
            font-family: Consolas, monospace;
        }
    </style>
</head>
<body>
    <h1>API Documentation</h1>

    <h2>Authentication Endpoints</h2>
    <p><strong>POST /v1/auth/login</strong></p>
    <p>Logs in the user and returns an authentication token.</p>

    <p><strong>POST /v1/auth/register</strong></p>
    <p>Registers a new user and returns an authentication token.</p>

    <h2>Authenticated Endpoints</h2>
    <p><strong>GET /v1/user</strong></p>
    <p>Returns the authenticated user's information.</p>

    <p><strong>POST /v1/logout</strong></p>
    <p>Logs out the authenticated user.</p>

    <h2>Chat Endpoints</h2>
    <p><strong>POST /v1/chat/widget</strong></p>
    <p>Creates a chat widget.</p>

    <p><strong>POST /v1/chat/send</strong></p>
    <p>Sends a message in the chat.</p>

    <p><strong>POST /v1/chat/delete</strong></p>
    <p>Deletes a message from the chat.</p>

    <script>
        // Sample JavaScript code for calling the API endpoints
        async function login() {
            const response = await fetch('/v1/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username: 'example', password: 'password' })
            });

            const data = await response.json();
            console.log(data);
        }

        async function getUser() {
            const token = 'YOUR_AUTH_TOKEN'; // Replace with the actual authentication token
            const response = await fetch('/v1/user', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            const data = await response.json();
            console.log(data);
        }

        // Call the functions as needed
        login();
        getUser();
    </script>
</body>
</html>
