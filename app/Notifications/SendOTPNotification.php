<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOTPNotification extends Notification
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Mã xác thực OTP')
            ->line('Mã OTP của bạn là:')
            ->line('🔐 ' . $this->otp)
            ->line('Mã có hiệu lực trong 5 phút.')
            ->line('Vui lòng không chia sẻ mã này cho bất kỳ ai.');
    }
}
