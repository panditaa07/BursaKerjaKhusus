<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Application;

class ApplicationStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected $application;
    protected $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Application $application, string $newStatus)
    {
        $this->application = $application;
        $this->newStatus = $newStatus;
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
        $statusText = [
            'submitted' => 'Diajukan',
            'reviewed' => 'Ditinjau',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'interview' => 'Wawancara',
            'test1' => 'Tes Tahap 1',
            'test2' => 'Tes Tahap 2',
        ];

        $subject = 'Pembaruan Status Lamaran Anda untuk Posisi ' . $this->application->jobPost->title;
        $greeting = 'Yth. ' . $notifiable->name . ',';
        $line1 = 'Kami ingin memberitahukan bahwa status lamaran kerja Anda untuk posisi **' . $this->application->jobPost->title . '** di **' . $this->application->jobPost->company->name . '** telah diperbarui.';
        $line2 = 'Status terbaru lamaran Anda adalah: **' . ($statusText[$this->newStatus] ?? $this->newStatus) . '**';
        $actionText = 'Lihat Detail Lamaran';
        $actionUrl = route('user.applications.show', $this->application->id);
        $line3 = 'Mohon periksa dashboard Anda untuk informasi lebih lanjut.';
        $salutation = 'Hormat kami,';
        $salutation2 = 'Tim Bursa Kerja Khusus';

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($line1)
            ->line($line2)
            ->action($actionText, $actionUrl)
            ->line($line3)
            ->salutation($salutation)
            ->salutation($salutation2);
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
            'job_post_title' => $this->application->jobPost->title,
            'company_name' => $this->application->jobPost->company->name,
            'new_status' => $this->newStatus,
        ];
    }
}