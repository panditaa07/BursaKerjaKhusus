<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Statistik Dashboard Admin</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .stats { display: flex; flex-wrap: wrap; gap: 20px; margin: 20px 0; }
        .stat-card { flex: 1 1 200px; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; }
        .stat-number { font-size: 24px; font-weight: bold; color: #007bff; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Statistik Dashboard Admin</h1>
        <p>Tanggal: {{ $date }}</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <h3>Total Pelamar</h3>
            <div class="stat-number">{{ $statistics['total_pelamar'] }}</div>
        </div>
        <div class="stat-card">
            <h3>Pelamar Bulan Ini</h3>
            <div class="stat-number">{{ $statistics['pelamar_bulan_ini'] }}</div>
        </div>
        <div class="stat-card">
            <h3>Lowongan Aktif</h3>
            <div class="stat-number">{{ $statistics['lowongan_aktif'] }}</div>
        </div>
        <div class="stat-card">
            <h3>Lowongan Tidak Aktif</h3>
            <div class="stat-number">{{ $statistics['lowongan_tidak_aktif'] }}</div>
        </div>
    </div>

    <h2>Pelamar Terbaru</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Perusahaan</th>
            <th>Lowongan</th>
            <th>Status</th>
        </tr>
        @foreach($daftar_pelamar_terbaru as $index => $app)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $app->user->name }}</td>
            <td>{{ $app->user->email }}</td>
            <td>{{ $app->user->phone }}</td>
            <td>{{ $app->jobPost->company->name }}</td>
            <td>{{ $app->jobPost->title }}</td>
            <td>{{ $app->status }}</td>
        </tr>
        @endforeach
    </table>

    <h2>Loker Terbaru</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Perusahaan</th>
            <th>No HRD</th>
            <th>Alamat</th>
            <th>Status</th>
        </tr>
        @foreach($loker_terbaru as $index => $job)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $job->company->name }}</td>
            <td>{{ $job->no_hrd }}</td>
            <td>{{ $job->alamat ?? $job->location }}</td>
            <td>{{ $job->status }}</td>
        </tr>
        @endforeach
    </table>

    <div class="footer">
        <p>Generated on {{ $date }} | Bursa Kerja Khusus Admin</p>
    </div>
</body>
</html>
