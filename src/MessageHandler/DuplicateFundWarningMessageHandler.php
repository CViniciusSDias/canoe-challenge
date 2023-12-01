<?php

namespace App\MessageHandler;

use App\Message\DuplicateFundWarningMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DuplicateFundWarningMessageHandler
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(DuplicateFundWarningMessage $message)
    {
        $this->logger->warning('A duplicate fund was detected.', [
            'fundName' => $message->fundName,
            'fundAliases' => $message->fundAliases,
            'fundManagerId' => $message->fundManagerId,
        ]);
    }
}
