 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Document Reminder</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f1f5f9;
        }

        header {
            background: #1e40af;
            color: white;
            padding: 20px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            padding: 35px;
        }

        h2 {
            color: #1e293b;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        }

        .card h3 {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 30px;
            font-weight: bold;
            color: #1e40af;
        }

        button {
            padding: 10px 18px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 7px;
            color: #334155;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 8px;
        }

        #documentForm button {
            margin-top: 15px;
            background: #2563eb;
        }

        #documentMessage {
            margin-top: 15px;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            header {
                padding: 18px;
            }

            .container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<header>
    <h2 style="color:white; margin:0;">Document Reminder</h2>
    <button onclick="logout()">Logout</button>
</header>

<div class="container">

    <h2>Welcome to Your Dashboard!</h2>
    <p class="subtitle">Manage your important documents in one place.</p>

    <div class="cards">

        <div class="card">
            <h3>Total Documents</h3>
            <p id="total">0</p>
        </div>

        <div class="card">
            <h3>Active Documents</h3>
            <p id="active">0</p>
        </div>

        <div class="card">
            <h3>Expiring Soon</h3>
            <p id="upcoming">0</p>
        </div>

        <div class="card">
            <h3>Expired Documents</h3>
            <p id="expired">0</p>
        </div>

    </div>

    <br><br>

    <div class="card">
        <h2>Add New Document</h2>

        <form id="documentForm">

            <label>Document Name</label>
            <input type="text" name="document_name"
                   placeholder="e.g. Passport" required>

            <label>Document Type</label>
            <input type="text" name="document_type"
                   placeholder="e.g. Personal" required>

            <label>Document Number</label>
            <input type="text" name="document_number"
                   placeholder="Enter document number">

            <label>Issue Date</label>
            <input type="date" name="issue_date">

            <label>Expiry Date</label>
            <input type="date" name="expiry_date" required>

            <label>Reminder Days</label>
            <input type="number" name="reminder_days"
                   value="30" min="1">

            <button type="submit">Add Document</button>

        </form>

        <p id="documentMessage"></p>
    </div>

</div>

<br><br>

<div class="card">
    <h2>My Documents</h2>

    <div style="overflow-x:auto;">
        <table border="1" width="100%" cellpadding="10"
               cellspacing="0" id="documentsTable">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Document Number</th>
                    <th>Issue Date</th>
                    <th>Expiry Date</th>
                    <th>Reminder Days</th>
                </tr>
            </thead>

            <tbody id="documentsList">
                <tr>
                    <td colspan="6">Loading documents...</td>
                </tr>
            </tbody>

        </table>
    </div>
</div>

<script>
    const token = localStorage.getItem('auth_token');

    if (!token) {
        window.location.href = '/';
    }

    // Read JSON response safely
    async function readJson(response) {
        let raw = await response.text();

        raw = raw.trim();

        // Remove extra backslash characters before JSON
        raw = raw.replace(/^\\+/, '');

        let result = JSON.parse(raw);

        // Handle JSON that is returned as a string
        if (typeof result === 'string') {
            result = JSON.parse(result);
        }

        return result;
    }

    // Load dashboard statistics
    async function loadStatistics() {
        try {
            const response = await fetch('/api/documents/statistics', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/';
                return;
            }

            const result = await readJson(response);

            console.log('Statistics:', result);

            if (response.ok) {
                document.getElementById('total').textContent =
                    result.total_documents ?? 0;

                document.getElementById('active').textContent =
                    result.active_documents ?? 0;

                document.getElementById('upcoming').textContent =
                    result.expiring_soon ?? 0;

                document.getElementById('expired').textContent =
                    result.expired_documents ?? 0;
            }

        } catch (error) {
            console.error('Statistics error:', error);
        }
    }

    // Logout
    async function logout() {
        try {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });
        } catch (error) {
            console.error(error);
        }

        localStorage.removeItem('auth_token');
        window.location.href = '/';
    }

    // Add new document
    const documentForm = document.getElementById('documentForm');
    const documentMessage = document.getElementById('documentMessage');

    documentForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(documentForm);

        const data = {
            document_name: formData.get('document_name'),
            document_type: formData.get('document_type'),
            document_number: formData.get('document_number'),
            issue_date: formData.get('issue_date') || null,
            expiry_date: formData.get('expiry_date'),
            reminder_days: Number(formData.get('reminder_days'))
        };

        try {
            const response = await fetch('/api/documents', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify(data)
            });

            const result = await readJson(response);

            if (response.ok) {
                documentMessage.style.color = 'green';
                documentMessage.textContent = 'Document added successfully!';

                documentForm.reset();

                await loadStatistics();

            } else {
                documentMessage.style.color = 'red';
                documentMessage.textContent =
                    result.message || 'Failed to add document.';
            }

        } catch (error) {
            console.error('Document error:', error);

            documentMessage.style.color = 'red';
            documentMessage.textContent = error.message;
        }
    });
// Load all saved documents
async function loadDocuments() {
    try {
        const response = await fetch('/api/documents', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            }
        });

        const documents = await readJson(response);

        const documentsList = document.getElementById('documentsList');

        if (!response.ok) {
            documentsList.innerHTML =
                '<tr><td colspan="6">Failed to load documents.</td></tr>';
            return;
        }

        if (documents.length === 0) {
            documentsList.innerHTML =
                '<tr><td colspan="6">No documents found.</td></tr>';
            return;
        }

        documentsList.innerHTML = '';

        documents.forEach(function(doc) {
            documentsList.innerHTML += `
                <tr>
                    <td>${doc.document_name}</td>
                    <td>${doc.document_type}</td>
                    <td>${doc.document_number || '-'}</td>
                    <td>${doc.issue_date ? doc.issue_date.substring(0, 10) : '-'}</td>
                    <td>${doc.expiry_date ? doc.expiry_date.substring(0, 10) : '-'}</td>
                    <td>${doc.reminder_days}</td>
                </tr>
            `;
        });

    } catch (error) {
        console.error('Load documents error:', error);
    }
}
    // Load statistics when dashboard opens
    loadStatistics();
    loadDocuments();
</script>

</body>
</html>