<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
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
        $subject = 'Pendaftaran Akun Baru: ' . $this->user->name;
        $greeting = 'Halo Admin,';
        $body = 'Ada akun baru yang baru mendaftar dan menunggu verifikasi Anda:';
        $name = 'Nama: ' . $this->user->name;
        $email = 'Email: ' . $this->user->email;
        $role = 'Role: ' . $this->user->role->name;
        $actionText = 'Verifikasi Akun';
        $actionUrl = url('/admin/verifications/users/' . $this->user->id . '/edit'); // Assuming an admin verification route

        if ($this->user->role->name === 'company') {
            $actionUrl = url('/admin/verifications/companies/' . $this->user->company->id . '/edit'); // Assuming an admin verification route for companies
        }


        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($body)
            ->line($name)
            ->line($email)
            ->line($role)
            ->action($actionText, $actionUrl)
            ->line('Terima kasih.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
