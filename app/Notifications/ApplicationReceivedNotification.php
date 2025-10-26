<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Application;
use App\Models\JobPost;

class ApplicationReceivedNotification extends Notification
{
    use Queueable;

    protected $application;
    protected $jobPost;

    /**
     * Create a new notification instance.
     */
    public function __construct(Application $application, JobPost $jobPost)
    {
        $this->application = $application;
        $this->jobPost = $jobPost;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pemberitahuan Lamaran Kerja Baru: ' . $this->jobPost->title)
            ->greeting('Yth. Bapak/Ibu Pimpinan ' . $notifiable->name . ',')
            ->line('Kami ingin memberitahukan bahwa terdapat lamaran kerja baru untuk posisi yang Anda iklankan.')
            ->line('Berikut adalah detail lamaran:')
            ->line('**Posisi Dilamar:** ' . $this->jobPost->title)
            ->line('**Nama Pelamar:** ' . $this->application->user->name)
            ->line('**Email Pelamar:** ' . $this->application->user->email)
            ->line('**Tanggal Lamaran:** ' . $this->application->created_at->format('d F Y H:i'))
            ->action('Lihat Detail Lamaran', route('company.applications.show.company', $this->application->id))
            ->line('Mohon segera tinjau lamaran ini melalui dashboard perusahaan Anda.')
            ->salutation('Hormat kami,')
            ->salutation('Tim Bursa Kerja Khusus');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_post_id' => $this->jobPost->id,
            'job_post_title' => $this->jobPost->title,
            'applicant_name' => $this->application->user->name,
        ];
    }
}