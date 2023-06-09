<?php declare(strict_types=1);

namespace Shopware\Core\Framework\Test\MessageQueue\fixtures;

use Shopware\Core\Framework\MessageQueue\Handler\AbstractMessageHandler;

/**
 * @internal
 */
final class DummyHandler extends AbstractMessageHandler
{
    private object $lastMessage;

    private ?\Throwable $exceptionToThrow = null;

    public function handle($message): void
    {
        $this->lastMessage = $message;

        if ($this->exceptionToThrow) {
            throw $this->exceptionToThrow;
        }
    }

    public static function getHandledMessages(): iterable
    {
        return [
            TestMessage::class,
        ];
    }

    public function getLastMessage(): object
    {
        return $this->lastMessage;
    }

    public function willThrowException(\Throwable $e): self
    {
        $this->exceptionToThrow = $e;

        return $this;
    }
}
