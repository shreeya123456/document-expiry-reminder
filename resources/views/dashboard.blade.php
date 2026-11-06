
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
            background: #f5f7fc;
            color: #1e293b;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 245px;
            background: #172554;
            color: white;
            padding: 28px 18px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 21px;
            font-weight: bold;
            padding: 0 10px 35px;
            line-height: 1.5;
        }

        .brand span {
            color: #93c5fd;
        }

        .menu-title {
            color: #94a3b8;
            font-size: 11px;
            letter-spacing: 1.5px;
            padding: 10px;
            margin-bottom: 8px;
        }

        .menu a {
            display: block;
            padding: 13px 14px;
            margin-bottom: 8px;
            color: #dbeafe;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
        }

        .menu a.active,
        .menu a:hover {
            background: #2563eb;
            color: white;
        }

        .sidebar-bottom {
            margin-top: 55px;
            border-top: 1px solid #334155;
            padding-top: 20px;
        }

        .sidebar-bottom button {
            width: 100%;
            background: #dc2626;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 20px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }

        .topbar h3 {
            color: #172554;
            font-size: 20px;
        }

        .user-label {
            color: #64748b;
            font-size: 13px;
        }

        .content {
            padding: 35px;
        }

        .welcome {
            margin-bottom: 28px;
        }

        .welcome h1 {
            font-size: 27px;
            color: #172554;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #64748b;
            font-size: 14px;
        }

        button {
            border: none;
            padding: 11px 17px;
            border-radius: 7px;
            color: white;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
        }

        button:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }

        .primary-btn {
            background: #2563eb;
        }

        /* PDF Report Button */
        .report-btn {
            background: #2563eb;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 15px;
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.2);
        }

        .report-btn:hover {
            background: #172554;
        }

        .edit-btn {
            background: #0d9488;
            padding: 8px 12px;
        }

        .delete-btn {
            background: #ef4444;
            padding: 8px 12px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 23px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(15,23,42,0.04);
            border: 1px solid #eef2f7;
            border-left: 4px solid #2563eb;
        }

        .stat-card.active-card {
            border-left-color: #16a34a;
        }

        .stat-card.upcoming-card {
            border-left-color: #f59e0b;
        }

        .stat-card.expired-card {
            border-left-color: #ef4444;
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .stat-card h3 {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #dbeafe;
            color: #2563eb;
            font-size: 18px;
        }

        .active-card .stat-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .upcoming-card .stat-icon {
            background: #fef3c7;
            color: #d97706;
        }

        .expired-card .stat-icon {
            background: #fee2e2;
            color: #dc2626;
        }

        .stat-card p {
            font-size: 30px;
            font-weight: bold;
            color: #172554;
        }

        .panel {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(15,23,42,0.04);
            border: 1px solid #eef2f7;
            margin-bottom: 28px;
        }

        .panel-heading {
            margin-bottom: 22px;
        }

        .panel-heading h2 {
            font-size: 19px;
            color: #172554;
            margin-bottom: 6px;
        }

        .panel-heading p {
            font-size: 13px;
            color: #94a3b8;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            color: #475569;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
            outline: none;
            background: #fff;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        .form-actions {
            margin-top: 22px;
        }

        #documentMessage {
            margin-top: 15px;
            font-size: 13px;
        }

        .table-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .search-box {
            max-width: 260px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        th {
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 15px 12px;
            text-align: left;
        }

        td {
            padding: 15px 12px;
            border-bottom: 1px solid #edf0f5;
            font-size: 13px;
            color: #475569;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            white-space: nowrap;
        }

        .status-active {
            background: #dcfce7;
            color: #15803d;
        }

        .status-upcoming {
            background: #fef3c7;
            color: #b45309;
        }

        .status-expired {
            background: #fee2e2;
            color: #b91c1c;
        }

        .file-link {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
        }

        .file-link:hover {
            text-decoration: underline;
        }

        .empty-message {
            text-align: center;
            padding: 30px;
            color: #94a3b8;
        }

        footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            padding: 15px;
        }

        @media (max-width: 1000px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
                padding: 18px;
            }

            .brand {
                padding-bottom: 15px;
            }

            .menu {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }

            .menu-title {
                display: none;
            }

            .menu a {
                margin: 0;
                padding: 10px;
            }

            .sidebar-bottom {
                margin-top: 12px;
                padding-top: 12px;
            }

            .sidebar-bottom button {
                width: auto;
            }

            .topbar {
                padding: 17px;
            }

            .content {
                padding: 18px;
            }

            .cards {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-card p {
                font-size: 25px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .panel {
                padding: 18px;
            }

            .table-heading {
                align-items: stretch;
                flex-direction: column;
            }

            .search-box {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <div class="brand">
            DOCUMENT<br>
            <span>REMINDER</span>
        </div>

        <p class="menu-title">MAIN MENU</p>

        <nav class="menu">
            <a href="#dashboard" class="active">▦ Dashboard</a>
            <a href="#add-document">＋ Add Document</a>
            <a href="#my-documents">▤ My Documents</a>
            <a href="/calendar">📅 Calendar</a>
        </nav>

        <div class="sidebar-bottom">
            <button onclick="logout()">Logout</button>
        </div>

    </aside>

    <main class="main">

        <header class="topbar">
            <h3>Dashboard</h3>
            <span class="user-label">Document Management System</span>
        </header>

        <div class="content" id="dashboard">

            <section class="welcome">
                <h1>Welcome to Your Dashboard!</h1>

                <button onclick="downloadPDFReport()" class="report-btn">
                    📄 Download PDF Report
                </button>

                <p>Manage and track all your important documents in one place.</p>
            </section>

            <!-- Statistics -->
            <section class="cards">

                <div class="stat-card">
                    <div class="stat-top">
                        <h3>Total Documents</h3>
                        <div class="stat-icon">▤</div>
                    </div>
                    <p id="total">0</p>
                </div>

                <div class="stat-card active-card">
                    <div class="stat-top">
                        <h3>Active Documents</h3>
                        <div class="stat-icon">✓</div>
                    </div>
                    <p id="active">0</p>
                </div>

                <div class="stat-card upcoming-card">
                    <div class="stat-top">
                        <h3>Expiring Soon</h3>
                        <div class="stat-icon">◷</div>
                    </div>
                    <p id="upcoming">0</p>
                </div>

                <div class="stat-card expired-card">
                    <div class="stat-top">
                        <h3>Expired Documents</h3>
                        <div class="stat-icon">!</div>
                    </div>
                    <p id="expired">0</p>
                </div>

            </section>

            <!-- Add Document -->
            <section class="panel" id="add-document">

                <div class="panel-heading">
                    <h2>＋ Add New Document</h2>
                    <p>Enter your document information below.</p>
                </div>

                <form id="documentForm">

                    <div class="form-grid">

                        <div class="form-group">
                            <label>Document Name *</label>
                            <input type="text" name="document_name"
                                placeholder="e.g. Passport" required>
                        </div>

                        <div class="form-group">
                            <label>Document Type *</label>
                            <input type="text" name="document_type"
                                placeholder="e.g. Personal" required>
                        </div>

                        <div class="form-group">
                            <label>Document Number</label>
                            <input type="text" name="document_number"
                                placeholder="Enter document number">
                        </div>

                        <div class="form-group">
                            <label>Issue Date</label>
                            <input type="date" name="issue_date" id="issue_date">
                        </div>

                        <div class="form-group">
                            <label>Expiry Date *</label>
                            <input type="date" name="expiry_date"
                                id="expiry_date" required>
                        </div>

                        <div class="form-group">
                            <label>Reminder Days *</label>
                            <input type="number" name="reminder_days"
                                value="30" min="1" required>
                        </div>

                        <!-- Document File Upload -->
                        <div class="form-group">
                            <label>Upload Document (PDF / Image)</label>
                            <input type="file" name="document_file"
                                id="document_file"
                                accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="submit" class="primary-btn">
                            Add Document
                        </button>
                    </div>

                </form>

                <p id="documentMessage"></p>

            </section>

            <!-- My Documents -->
            <section class="panel" id="my-documents">

                <div class="table-heading">

                    <div class="panel-heading" style="margin:0;">
                        <h2>My Documents</h2>
                        <p>View and manage your saved documents.</p>
                    </div>

                    <input type="text" id="searchInput"
                        class="search-box"
                        placeholder="Search documents...">

                </div>

                <div class="table-wrapper">

                    <table id="documentsTable">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Document Number</th>
                                <th>Issue Date</th>
                                <th>Expiry Date</th>
                                <th>Days Remaining</th>
                                <th>Status</th>
                                <th>File</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="documentsList">
                            <tr>
                                <td colspan="9" class="empty-message">
                                    Loading documents...
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

            </section>

        </div>

        <footer>
            Document Expiry Reminder System | © 2026
        </footer>

    </main>

</div>

<script>

    // Get authentication token
    const token = localStorage.getItem('auth_token');

    if (!token) {
        window.location.href = '/';
    }

    // Read JSON response safely
    async function readJson(response) {

        let raw = await response.text();

        raw = raw.trim();
        raw = raw.replace(/^\\+/, '');

        let result = JSON.parse(raw);

        if (typeof result === 'string') {
            result = JSON.parse(result);
        }

        return result;
    }

    // Escape document values
    function escapeHtml(value) {

        return String(value ?? '').replace(/[&<>"']/g, function(char) {

            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];

        });
    }

    // Store documents for searching
    let allDocuments = [];

    // Calculate remaining days
    function calculateDaysRemaining(expiryDate) {

        if (!expiryDate) {
            return null;
        }

        const today = new Date();

        const todayUTC = Date.UTC(
            today.getFullYear(),
            today.getMonth(),
            today.getDate()
        );

        const parts = expiryDate.substring(0, 10).split('-');

        if (parts.length !== 3 || parts.some(part => !/^\d+$/.test(part))) {
            return null;
        }

        const expiryUTC = Date.UTC(
            Number(parts[0]),
            Number(parts[1]) - 1,
            Number(parts[2])
        );

        return Math.round(
            (expiryUTC - todayUTC) / (1000 * 60 * 60 * 24)
        );
    }

    // Get document expiry status
    function getDocumentStatus(expiryDate) {

        const remainingDays = calculateDaysRemaining(expiryDate);

        if (remainingDays === null) {
            return {
                text: 'Unknown',
                className: 'status-expired',
                remainingDays: '-'
            };
        }

        if (remainingDays < 0) {

            const daysAgo = Math.abs(remainingDays);

            return {
                text: 'Expired',
                className: 'status-expired',
                remainingDays: daysAgo +
                    (daysAgo === 1 ? ' day ago' : ' days ago')
            };
        }

        if (remainingDays <= 30) {
            return {
                text: 'Expiring Soon',
                className: 'status-upcoming',
                remainingDays: remainingDays + ' days'
            };
        }

        return {
            text: 'Active',
            className: 'status-active',
            remainingDays: remainingDays + ' days'
        };
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

    // Prevent expiry date from being earlier than issue date
    const issueDateInput = document.getElementById('issue_date');
    const expiryDateInput = document.getElementById('expiry_date');

    issueDateInput.addEventListener('change', function () {

        expiryDateInput.min = this.value;

        if (expiryDateInput.value && expiryDateInput.value < this.value) {
            expiryDateInput.value = '';
        }
    });

    expiryDateInput.addEventListener('change', function () {

        if (issueDateInput.value && this.value < issueDateInput.value) {
            alert('Expiry date cannot be earlier than issue date.');
            this.value = '';
        }
    });

    const documentMessage = document.getElementById('documentMessage');

    documentForm.addEventListener('submit', async function(e) {

        e.preventDefault();

        // Collect all form fields, including the uploaded file
        const formData = new FormData(documentForm);

        try {

            const response = await fetch('/api/documents', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: formData
            });

            const result = await readJson(response);

            if (response.ok) {

                documentMessage.style.color = '#15803d';
                documentMessage.textContent =
                    'Document added successfully!';

                documentForm.reset();

                await loadStatistics();
                await loadDocuments();

            } else {

                documentMessage.style.color = '#dc2626';
                documentMessage.textContent =
                    result.message || 'Failed to add document.';

            }

        } catch (error) {

            console.error('Document error:', error);

            documentMessage.style.color = '#dc2626';
            documentMessage.textContent = error.message;

        }

    });

    // Display documents in table
    function displayDocuments(documents) {

        const documentsList =
            document.getElementById('documentsList');

        if (!documents || documents.length === 0) {

            documentsList.innerHTML = `
                <tr>
                    <td colspan="9" class="empty-message">
                        No documents found.
                    </td>
                </tr>
            `;

            return;
        }

        documentsList.innerHTML = '';

        documents.forEach(function(doc) {

            const expiryDate = doc.expiry_date
                ? doc.expiry_date.substring(0, 10)
                : '';

            const status = getDocumentStatus(expiryDate);

            const fileLink = doc.document_file
                ? `<a class="file-link"
                    href="/storage/${escapeHtml(doc.document_file)}"
                    target="_blank" rel="noopener">View File</a>`
                : '-';

            documentsList.innerHTML += `

                <tr>

                    <td>
                        <strong>${escapeHtml(doc.document_name)}</strong>
                    </td>

                    <td>${escapeHtml(doc.document_type)}</td>

                    <td>${escapeHtml(doc.document_number || '-')}</td>

                    <td>
                        ${escapeHtml(
                            doc.issue_date
                                ? doc.issue_date.substring(0, 10)
                                : '-'
                        )}
                    </td>

                    <td>${escapeHtml(expiryDate || '-')}</td>

                    <td>${escapeHtml(status.remainingDays)}</td>

                    <td>
                        <span class="status ${status.className}">
                            ${status.text}
                        </span>
                    </td>

                    <td>${fileLink}</td>

                    <td>
                        <button class="edit-btn"
                            onclick="editDocument(${Number(doc.id)})">
                            Edit
                        </button>

                        <button class="delete-btn"
                            onclick="deleteDocument(${Number(doc.id)})">
                            Delete
                        </button>
                    </td>

                </tr>

            `;

        });

    }

    // Load all saved documents
    async function loadDocuments() {

        try {

            const response = await fetch('/api/documents', {
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

            const documents = await readJson(response);

            if (!response.ok) {
                throw new Error('Failed to load documents.');
            }

            allDocuments = documents;

            displayDocuments(allDocuments);

        } catch (error) {

            console.error('Load documents error:', error);

            document.getElementById('documentsList').innerHTML = `
                <tr>
                    <td colspan="9" class="empty-message">
                        Failed to load documents.
                    </td>
                </tr>
            `;

        }
    }

    // Search documents
    document.getElementById('searchInput')
        .addEventListener('input', function() {

            const searchValue = this.value.toLowerCase();

            const filteredDocuments = allDocuments.filter(function(doc) {

                return (
                    String(doc.document_name || '').toLowerCase().includes(searchValue) ||
                    String(doc.document_type || '').toLowerCase().includes(searchValue) ||
                    String(doc.document_number || '').toLowerCase().includes(searchValue)
                );

            });

            displayDocuments(filteredDocuments);

        });

    // Delete document
    async function deleteDocument(id) {

        if (!confirm('Are you sure you want to delete this document?')) {
            return;
        }

        try {

            const response = await fetch(`/api/documents/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            if (response.ok) {

                alert('Document deleted successfully!');

                await loadDocuments();
                await loadStatistics();

            } else {

                alert('Failed to delete document.');

            }

        } catch (error) {

            console.error('Delete error:', error);

        }
    }

    // Edit document
    async function editDocument(id) {

        try {

            const response = await fetch(`/api/documents/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            const doc = await readJson(response);

            if (!response.ok) {
                alert('Failed to load document.');
                return;
            }

            const name = prompt('Document Name:', doc.document_name);
            if (name === null) return;

            const type = prompt('Document Type:', doc.document_type);
            if (type === null) return;

            const number = prompt(
                'Document Number:',
                doc.document_number || ''
            );
            if (number === null) return;

            const issueDate = prompt(
                'Issue Date (YYYY-MM-DD):',
                doc.issue_date ? doc.issue_date.substring(0, 10) : ''
            );
            if (issueDate === null) return;

            const expiryDate = prompt(
                'Expiry Date (YYYY-MM-DD):',
                doc.expiry_date ? doc.expiry_date.substring(0, 10) : ''
            );
            if (expiryDate === null) return;

            // Validate issue date and expiry date
            if (issueDate && expiryDate && expiryDate < issueDate) {
                alert('Expiry date cannot be earlier than issue date.');
                return;
            }

            const reminderDays = prompt(
                'Reminder Days:',
                doc.reminder_days
            );
            if (reminderDays === null) return;

            const updateResponse = await fetch(`/api/documents/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                body: JSON.stringify({
                    document_name: name,
                    document_type: type,
                    document_number: number || null,
                    issue_date: issueDate || null,
                    expiry_date: expiryDate,
                    reminder_days: Number(reminderDays)
                })
            });

            const result = await readJson(updateResponse);

            if (updateResponse.ok) {

                alert('Document updated successfully!');

                await loadDocuments();
                await loadStatistics();

            } else {

                alert(result.message || 'Failed to update document.');

            }

        } catch (error) {

            console.error('Edit error:', error);
            alert(error.message);

        }
    }

    // Download PDF Report
    async function downloadPDFReport() {

        try {

            const token = localStorage.getItem('auth_token');

            const response = await fetch('/api/reports/pdf', {
                headers: {
                    'Accept': 'application/pdf',
                    'Authorization': 'Bearer ' + token
                }
            });

            if (!response.ok) {
                alert('Could not download PDF report.');
                return;
            }

            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);

            const link = document.createElement('a');
            link.href = url;
            link.download = 'document-report.pdf';

            document.body.appendChild(link);
            link.click();
            link.remove();

            window.URL.revokeObjectURL(url);

        } catch (error) {

            console.error('PDF download error:', error);
            alert('Something went wrong while downloading the PDF.');

        }
    }

    // Load data when dashboard opens
    loadStatistics();
    loadDocuments();

</script>

</body>
</html>
