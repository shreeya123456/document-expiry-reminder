
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Document Reminder</title>

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

        .register-container {
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
            cursor: not-allowed;
        }

        #message {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
        }

        .login-link a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="register-container">

        <h2>Create Account</h2>
        <p class="subtitle">Register for Document Reminder</p>

        <form id="registerForm">

            <label>Full Name</label>
            <input type="text" name="name"
                   placeholder="Enter your name" required>

            <label>Email Address</label>
            <input type="email" name="email"
                   placeholder="Enter your email" required>

            <label>Password</label>
            <input type="password" name="password"
                   placeholder="Create password" required minlength="8">

            <label>Confirm Password</label>
            <input type="password" name="password_confirmation"
                   placeholder="Confirm password" required>

            <button type="submit" id="registerButton">
                Register
            </button>

        </form>

        <div id="message"></div>

        <div class="login-link">
            Already have an account?
            <a href="/">Login</a>
        </div>

    </div>

    <script>
        const form = document.getElementById('registerForm');
        const message = document.getElementById('message');
        const button = document.getElementById('registerButton');

        form.addEventListener('submit', async function(e) {

            e.preventDefault();

            console.log('Register button clicked');

            message.style.color = '#2563eb';
            message.textContent = 'Creating your account...';
            button.disabled = true;

            const formData = new FormData(form);

            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation')
            };

            try {
                const response = await fetch('/api/register', {
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

const result = JSON.parse(raw);

                console.log('Status:', response.status);
                console.log('Response:', result);

                if (response.ok) {
                    message.style.color = 'green';
                    message.textContent = 'Registration successful!';

                    setTimeout(function() {
                        window.location.href = '/';
                    }, 1500);

                } else {
                    message.style.color = 'red';

                    if (result.errors) {
                        message.textContent =
                            Object.values(result.errors).flat().join(', ');
                    } else {
                        message.textContent =
                            result.message || 'Registration failed.';
                    }
                }

            } catch (error) {
                console.error(error);
                message.style.color = 'red';
                message.textContent =
                    'Something went wrong. Please try again.';
            }

            button.disabled = false;

        });
    </script>

</body>
</html>
