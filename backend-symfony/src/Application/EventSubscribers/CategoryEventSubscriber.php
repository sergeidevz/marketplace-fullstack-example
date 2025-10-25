<?php

namespace App\Application\EventSubscribers;

use App\Domain\Event\CategoryCreated;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CategoryEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CategoryCreated::class => 'onCategoryCreated',
        ];
    }

    public function onCategoryCreated(CategoryCreated $event)
    {
        $this->logger->error('Category created', ['category' => $event->getCategory()]);
    }
}
