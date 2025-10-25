<?php

namespace App\MessageHandler;

use App\Message\Notification;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NotificationHandler
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(Notification $notification)
    {
        $this->logger->info($notification->getNotification());
    }
}
