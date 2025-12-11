<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>برنامج حصر الأصوات</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .logo {
            width: 90px;
            height: auto;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f3f4f6;
        }

        .btn {
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        .btn-danger {
            background-color: #b91c1c;
        }

        .btn-danger:hover {
            background-color: #991b1b;
        }

        .total-row {
            background-color: #fef3c7;
            color: #b45309;
            font-weight: 700;
        }

        .stats {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            margin-top: 16px;
        }

        .stat-card {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
            background: #f9fafb;
        }

        .stat-card .label {
            margin: 0;
            color: #4b5563;
            font-weight: 600;
        }

        .stat-card .value {
            margin: 6px 0 0;
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }

        .stat-valid {
            background: #ecfdf3;
            border-color: #a7f3d0;
        }

        .stat-invalid {
            background: #fef2f2;
            border-color: #fecdd3;
        }

        .stat-total {
            background: #eef2ff;
            border-color: #c7d2fe;
        }

        .stat-percentage {
            background: #e0f2fe;
            border-color: #bae6fd;
        }

        .invalid-box {
            border: 1px solid #fecdd3;
            background: #fef2f2;
            color: #7f1d1d;
        }

        .btn-invalid-add {
            background-color: #dc2626;
        }

        .btn-invalid-add:hover {
            background-color: #b91c1c;
        }

        .top-voters-card {
            margin-top: 20px;
            border: 1px solid #a7f3d0;
            background: #ecfdf3;
            border-radius: 6px;
            padding: 14px;
        }

        .top-voters-card h3 {
            margin: 0 0 8px;
            color: #166534;
            font-size: 1.05rem;
        }

        .top-voters-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .top-voters-list li {
            padding: 6px 0;
            border-bottom: 1px solid #d1fae5;
            color: #065f46;
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }

        .top-voters-list li:last-child {
            border-bottom: none;
        }

        .actions-row {
            margin-top: 20px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .buttons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }

        .button-card {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px;
            background: #f9fafb;
            text-align: center;
        }

        .button-card-number {
            font-weight: 700;
            margin-bottom: 4px;
            color: #111827;
        }

        .button-card-name {
            font-size: 0.85rem;
            margin-bottom: 6px;
            color: #4b5563;
        }

        .button-card-votes {
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 6px;
            color: #0f172a;
        }

        .btn-increment-voter {
            font-weight: 700;
            font-size: 1.5rem;
        }
    </style>
</head>

<body dir="rtl">
    <div class="container">
        <div class="header">
            <img class="logo" src="{{ asset('logo-ar.webp') }}" alt="شعار">
            <h1>جدول الناخبين</h1>
            <div class="actions">
                <button type="button" class="btn btn-danger btn-reset-voters" data-url="{{ route('voters.reset') }}">
                    مسح الأصوات الصحيحة
                </button>
                <button type="button" class="btn btn-danger btn-reset-invalid"
                    data-url="{{ route('invalid_votes.reset') }}">
                    مسح الأصوات الباطلة
                </button>
            </div>
        </div>

        <div class="buttons-grid">
            @foreach ($voters as $voter)
                <div class="button-card" data-voter-id="{{ $voter->id }}">

                    <div class="button-card-name">{{ $voter->name }}</div>
                    <div class="button-card-votes" data-voter-id="{{ $voter->id }}">
                        الأصوات: <span class="card-votes-value">{{ $voter->votes }}</span>
                    </div>
                    <button type="button" class="btn btn-increment-voter"
                        data-url="{{ route('voters.increment', $voter->id) }}">
                         {{ $voter->number }}
                    </button>
                </div>
            @endforeach
            <div class="actions-row">
                <div class="button-card invalid-box">
                    <div class="button-card-name">الأصوات الباطلة</div>
                    <div class="button-card-votes">
                        الإجمالي: <span id="invalidVotesBoxValue">{{ $invalidVotes }}</span>
                    </div>
                    <button type="button" class="btn btn-invalid-add"
                        data-url="{{ route('invalid_votes.increment') }}">
                        إضافة صوت باطل
                    </button>
                </div>
            </div>
        </div>



        <table>
            <thead>
                <tr>
                    <th>رقم</th>
                    <th>اسم الناخب</th>
                    <th>عدد الأصوات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voters as $voter)
                    <tr>
                        <td>{{ $voter->number }}</td>
                        <td>{{ $voter->name }}</td>
                        <td class="votes-cell" data-voter-id="{{ $voter->id }}">{{ $voter->votes }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total-row">
                        إجمالي : <span id="totalVotesValue">{{ $totalVotes }}</span>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="stats">
            <div class="stat-card stat-valid">
                <p class="label">إجمالي الأصوات الصحيحة</p>
                <p class="value" id="quarterValue">{{ $quarter }}</p>
            </div>
            <div class="stat-card stat-invalid">
                <p class="label">عدد الأصوات الباطلة</p>
                <p class="value" id="invalidVotesValue">{{ $invalidVotes }}</p>
            </div>
            <div class="stat-card stat-total">
                <p class="label">إجمالي من أدلى بصوته (صحيح + باطل)</p>
                <p class="value" id="totalParticipantsValue">{{ $quarter + $invalidVotes }}</p>
            </div>
            <div class="stat-card stat-valid">
                <p class="label">نسبة الأصوات الصحيحة من إجمالي ٩٨٧٢ ناخب</p>
                <p class="value" id="percentValidValue">
                    {{ number_format(($quarter / 9872) * 100, 2) }}%
                </p>
            </div>
            <div class="stat-card stat-invalid">
                <p class="label">نسبة الأصوات الباطلة من إجمالي ٩٨٧٢ ناخب</p>
                <p class="value" id="percentInvalidValue">
                    {{ number_format(($invalidVotes / 9872) * 100, 2) }}%
                </p>
            </div>
            <div class="stat-card stat-percentage">
                <p class="label">نسبة التصويت من إجمالي ٩٨٧٢ ناخب</p>
                <p class="value" id="percentTotalValue">
                    {{ number_format((($quarter + $invalidVotes) / 9872) * 100, 2) }}%
                </p>
            </div>
        </div>



        <div class="top-voters-card">
            <h3>أكثر ٤ ناخبين أصواتاً</h3>
            <ul class="top-voters-list" id="topVotersList">
                @forelse ($topVoters as $voter)
                    <li>
                        <span>{{ $voter->name }}</span>
                        <span>{{ $voter->votes }} صوت</span>
                    </li>
                @empty
                    <li>لا توجد بيانات.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        async function postAjax(url) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                console.error('Request failed', response.status);
                return null;
            }

            return await response.json();
        }

        function updateUI(data) {
            if (!data || !data.success) return;

            if (data.voters) {
                data.voters.forEach(v => {
                    const cell = document.querySelector('.votes-cell[data-voter-id="' + v.id + '"]');
                    if (cell) {
                        cell.textContent = v.votes;
                    }

                    const cardVotes = document.querySelector('.button-card-votes[data-voter-id="' + v.id +
                        '"] .card-votes-value');
                    if (cardVotes) {
                        cardVotes.textContent = v.votes;
                    }
                });
            }

            document.getElementById('totalVotesValue').textContent = data.totalVotes;
            document.getElementById('quarterValue').textContent = data.quarter;
            document.getElementById('invalidVotesValue').textContent = data.invalidVotes;
            const invalidBox = document.getElementById('invalidVotesBoxValue');
            if (invalidBox) invalidBox.textContent = data.invalidVotes;
            document.getElementById('totalParticipantsValue').textContent = data.totalParticipants;

            document.getElementById('percentValidValue').textContent = data.percentValid.toFixed(2) + '%';
            document.getElementById('percentInvalidValue').textContent = data.percentInvalid.toFixed(2) + '%';
            document.getElementById('percentTotalValue').textContent = data.percentTotal.toFixed(2) + '%';

            const list = document.getElementById('topVotersList');
            if (list && data.topVoters) {
                list.innerHTML = '';
                if (data.topVoters.length === 0) {
                    list.innerHTML = '<li>لا توجد بيانات.</li>';
                } else {
                    data.topVoters.forEach(v => {
                        const li = document.createElement('li');
                        li.innerHTML = `
                            <span>${v.name}</span>
                            <span>${v.votes} صوت</span>
                        `;
                        list.appendChild(li);
                    });
                }
            }
        }

        document.querySelectorAll('.btn-increment-voter').forEach(btn => {
            btn.addEventListener('click', async () => {
                const url = btn.getAttribute('data-url');
                const data = await postAjax(url);
                updateUI(data);
            });
        });

        const invalidAddBtn = document.querySelector('.btn-invalid-add');
        if (invalidAddBtn) {
            invalidAddBtn.addEventListener('click', async () => {
                const url = invalidAddBtn.getAttribute('data-url');
                const data = await postAjax(url);
                updateUI(data);
            });
        }

        const resetInvalidBtn = document.querySelector('.btn-reset-invalid');
        if (resetInvalidBtn) {
            resetInvalidBtn.addEventListener('click', async () => {
                if (!confirm('هل أنت متأكد من مسح الأصوات الباطلة؟')) return;
                const url = resetInvalidBtn.getAttribute('data-url');
                const data = await postAjax(url);
                updateUI(data);
            });
        }

        const resetVotersBtn = document.querySelector('.btn-reset-voters');
        if (resetVotersBtn) {
            resetVotersBtn.addEventListener('click', async () => {
                if (!confirm('هل أنت متأكد من مسح أصوات جميع الناخبين؟')) return;
                const url = resetVotersBtn.getAttribute('data-url');
                const data = await postAjax(url);
                updateUI(data);
            });
        }
    </script>
</body>

</html>
