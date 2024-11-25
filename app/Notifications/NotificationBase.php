<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

abstract class NotificationBase extends Notification
{
    protected $message;
    protected $timestamp;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
        $this->timestamp = now();
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    // Абстрактные методы, которые будут реализованы в дочерних классах
    abstract public function getNotificationType();
    abstract public function render();
    abstract public function executeAction();
}
