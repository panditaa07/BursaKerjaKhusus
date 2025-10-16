<x-mail::message>
# Halo {{ $applicantName }},

Lamaran Anda untuk posisi **{{ $jobTitle }}** di **{{ $companyName }}** memiliki status baru:

@if($status == 'apply')
✅ Lamaran Anda telah kami terima.
@elseif($status == 'accepted')
🎉 Selamat! Lamaran Anda diterima.
@elseif($status == 'rejected')
❌ Mohon maaf, lamaran Anda belum berhasil.
@elseif($status == 'interview')
🎯 Selamat! Anda lolos ke tahap wawancara.
@elseif($status == 'test1')
📝 Selamat! Anda lolos ke tahap test 1.
@elseif($status == 'test2')
📝 Selamat! Anda lolos ke tahap test 2.
@elseif($status == 'submitted')
⏳ Lamaran Anda sedang dalam proses peninjauan.
@elseif($status == 'reviewed')
👀 Lamaran Anda sedang ditinjau.
@endif

<x-mail::button :url="$applicationLink">
Lihat Detail Lamaran
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
