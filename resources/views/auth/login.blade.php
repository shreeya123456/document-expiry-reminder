
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Document Expiry Reminder</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: white;
            width: 380px;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #1d4ed8;
        }

        button:disabled {
            background: #94a3b8;
        }

        #message {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
        }

        .register-link a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <h2>Document Reminder</h2>
        <p class="subtitle">Login to your account</p>

        <form id="loginForm">

            <label>Email Address</label>
            <input type="email" name="email"
                   placeholder="Enter your email" required>

            <label>Password</label>
            <input type="password" name="password"
                   placeholder="Enter your password" required>

            <button type="submit" id="loginButton">Login</button>

        </form>

        <div id="message"></div>

        <p class="register-link">
            Don't have an account?
            <a href="/register">Register</a>
        </p>

    </div>

    
<script>
    const form = document.getElementById('loginForm');
    const message = document.getElementById('message');
    const button = document.getElementById('loginButton');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        message.style.color = 'blue';
        message.textContent = 'Checking your account...';
        button.disabled = true;

        const formData = new FormData(form);

        const data = {
            email: formData.get('email'),
            password: formData.get('password')
        };

        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            let raw = await response.text();

raw = raw.trim();

if (raw.startsWith('\\{')) {
    raw = raw.substring(1);
}

let result = JSON.parse(raw);

if (typeof result === 'string') {
    result = JSON.parse(result);
}

            if (response.ok) {
                localStorage.setItem('auth_token', result.token);
                message.style.color = 'green';
                message.textContent = 'Login successful!';

                setTimeout(function() {
                    window.location.href = '/dashboard';
                }, 1000);
            } else {
                message.style.color = 'red';
                message.textContent = result.message || 'Login failed.';
            }

        } catch (error) {
            console.error('Login Error:', error);
            message.style.color = 'red';
            message.textContent = 'Error: ' + error.message;
        }

        button.disabled = false;
    });
</script>


</body>
</html>
