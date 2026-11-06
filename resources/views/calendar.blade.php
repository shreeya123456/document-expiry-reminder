<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Expiry Calendar</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6fb;
            padding: 30px;
            color: #263248;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        h1 {
            color: #172554;
            margin-bottom: 8px;
        }

        .back-btn {
            background: #172554;
            color: white;
            padding: 11px 18px;
            text-decoration: none;
            border-radius: 6px;
        }

        .calendar-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-header button {
            border: none;
            background: #172554;
            color: white;
            padding: 9px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        #monthYear {
            font-size: 22px;
            font-weight: bold;
        }

        .weekdays, .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .weekdays div {
            text-align: center;
            font-weight: bold;
            padding: 12px 0;
            color: #475569;
        }

        .day {
            min-height: 105px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            padding: 8px;
        }

        .date-number {
            font-weight: bold;
            margin-bottom: 7px;
        }

        .empty {
            background: transparent;
            border: none;
        }

        .event {
            font-size: 11px;
            padding: 5px;
            margin-top: 4px;
            border-radius: 4px;
            color: white;
            overflow-wrap: anywhere;
        }

        .active-event {
            background: #16a34a;
        }

        .soon-event {
            background: #e99b18;
        }

        .expired-event {
            background: #dc2626;
        }

        .legend {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
            font-size: 13px;
        }

        .legend span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        @media(max-width: 600px) {
            body {
                padding: 12px;
            }

            .calendar-box {
                padding: 10px;
            }

            .day {
                min-height: 75px;
                padding: 4px;
            }

            .event {
                font-size: 9px;
                padding: 3px;
            }

            .weekdays div {
                font-size: 11px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Document Expiry Calendar</h1>
            <p>View your document expiry dates.</p>
        </div>

        <a href="/dashboard" class="back-btn">Back to Dashboard</a>
    </div>

    <div class="calendar-box">

        <div class="calendar-header">
            <button onclick="changeMonth(-1)">Previous</button>
            <div id="monthYear"></div>
            <button onclick="changeMonth(1)">Next</button>
        </div>

        <div class="weekdays">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>

        <div class="days" id="calendarDays"></div>

        <div class="legend">
            <span><i class="dot active-event"></i> Active</span>
            <span><i class="dot soon-event"></i> Expiring Soon</span>
            <span><i class="dot expired-event"></i> Expired</span>
        </div>

    </div>
</div>

<script>
    let currentDate = new Date();
    let documents = [];

   const token = localStorage.getItem('auth_token');

    async function loadDocuments() {
        if (!token) {
            alert('Please log in first.');
            window.location.href = '/login';
            return;
        }

        try {
            const response = await fetch('/api/documents', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            if (!response.ok) {
                throw new Error('Could not load documents.');
            }

            documents = await response.json();
            renderCalendar();

        } catch (error) {
            alert(error.message);
        }
    }

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const monthNames = [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
        ];

        document.getElementById('monthYear').textContent =
            monthNames[month] + ' ' + year;

        const firstDay = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        const calendarDays = document.getElementById('calendarDays');
        calendarDays.innerHTML = '';

        for (let i = 0; i < firstDay; i++) {
            const empty = document.createElement('div');
            empty.className = 'day empty';
            calendarDays.appendChild(empty);
        }

        for (let day = 1; day <= totalDays; day++) {
            const cell = document.createElement('div');
            cell.className = 'day';

            const number = document.createElement('div');
            number.className = 'date-number';
            number.textContent = day;
            cell.appendChild(number);

            documents.forEach(doc => {
                if (!doc.expiry_date) return;

                const expiry = doc.expiry_date.substring(0, 10);
                const parts = expiry.split('-').map(Number);

                if (
                    parts[0] === year &&
                    parts[1] === month + 1 &&
                    parts[2] === day
                ) {
                    const event = document.createElement('div');
                    event.className = 'event';

                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    const expiryDate = new Date(year, month, day);
                    const difference = Math.round(
                        (expiryDate - today) / 86400000
                    );

                    if (difference < 0) {
                        event.classList.add('expired-event');
                    } else if (difference <= 30) {
                        event.classList.add('soon-event');
                    } else {
                        event.classList.add('active-event');
                    }

                    event.textContent = doc.document_name;
                    cell.appendChild(event);
                }
            });

            calendarDays.appendChild(cell);
        }
    }

    function changeMonth(amount) {
        currentDate.setMonth(currentDate.getMonth() + amount);
        renderCalendar();
    }

    loadDocuments();
</script>

</body>
</html>