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
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
    </style>
</head>

<body dir="rtl">
    <div class="container">
        <div class="header">
            <img class="logo" src="{{ asset('logo-ar.webp') }}" alt="شعار">
            <h1>جدول الناخبين</h1>
            <div class="actions">
                <form method="POST" action="{{ route('voters.reset') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">مسح الأصوات</button>
                </form>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>رقم</th>
                    <th>اسم الناخب</th>
                    <th>عدد الأصوات</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voters as $voter)
                    <tr>
                        <td>{{ $voter->number }}</td>
                        <td>{{ $voter->name }}</td>
                        <td>{{ $voter->votes }}</td>
                        <td>
                            <form method="POST" action="{{ route('voters.increment', $voter->id) }}">
                                @csrf
                                <button type="submit" class="btn">زيادة صوت : {{ $voter->number }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="total-row">إجمالي : {{ $totalVotes }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="stats">
            <div class="stat-card stat-valid">
                <p class="label">إجمالي الأصوات الصحيحة </p>
                <p class="value">{{ $quarter }}</p>
            </div>
            <div class="stat-card stat-invalid">
                <p class="label">عدد الأصوات الباطلة</p>
                <p class="value">{{ $invalidVotes }}</p>
            </div>
            <div class="stat-card stat-total">
                <p class="label">إجمالي من أدلى بصوته (صحيح + باطل)</p>
                <p class="value">{{ $quarter + $invalidVotes }}</p>
            </div>
            <div class="stat-card stat-valid">
                <p class="label">نسبة الاصوات الصحيحه من إجمالي ٩٨٧٢ ناخب</p>
                <p class="value">
                    {{ number_format((($quarter) / 9872) * 100, 2) }}%
                </p>
            </div>
            <div class="stat-card stat-invalid">
                <p class="label">نسبة الاصوات الباطله من إجمالي ٩٨٧٢ ناخب</p>
                <p class="value">
                    {{ number_format((($invalidVotes) / 9872) * 100, 2) }}%
                </p>
            </div>
            <div class="stat-card stat-percentage">
                <p class="label">نسبة التصويت من إجمالي ٩٨٧٢ ناخب</p>
                <p class="value">
                    {{ number_format((($quarter + $invalidVotes) / 9872) * 100, 2) }}%
                </p>
            </div>
        </div>
        <div class="actions-row">
            <form method="POST" action="{{ route('invalid_votes.increment') }}">
                @csrf
                <button type="submit" class="btn">إضافة صوت باطل</button>
            </form>
            <form method="POST" action="{{ route('invalid_votes.reset') }}">
                @csrf
                <button type="submit" class="btn btn-danger">مسح الأصوات الباطلة</button>
            </form>
        </div>
        @php
            $topVoters = $voters->sortByDesc('votes')->take(4);
        @endphp
        <div class="top-voters-card">
            <h3>أكثر ٤ ناخبين أصواتاً</h3>
            <ul class="top-voters-list">
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
</body>

</html>
