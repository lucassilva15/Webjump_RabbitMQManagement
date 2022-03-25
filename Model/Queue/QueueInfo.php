<?php
/**
 * PHP version 7
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\RabbitMQManagement\Model\Queue;

use JsonSerializable;

class QueueInfo implements JsonSerializable
{
    const ENABLED_FIELD = 'enabled';
    const QUEUE_FIELD = 'queue';
    const MAX_CONSUMERS_FIELD = 'max_consumers';
    const MAX_MESSAGES_TO_READ_FIELD = 'max_messages_to_read';
    const ACTIVE_CONSUMERS_FIELD = 'active_consumers';
    const MESSAGES_IN_QUEUE_FIELD = 'messages_in_queue';

    /** @var bool */
    private $enabled = false;

    /** @var string|null */
    private $queueName = null;

    /** @var int */
    private $maxConsumers = 0;

    /** @var int */
    private $maxMessagesToRead = 0;

    /** @var int */
    private $activeConsumers = 0;

    /** @var int */
    private $messagesInQueue = 0;

    /**
     * Enabled method
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Enabled method
     *
     * @param bool $enabled
     *
     * @return void
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * Queue method
     *
     * @return string|null
     */
    public function getQueueName(): ?string
    {
        return $this->queueName;
    }

    /**
     * Queue method
     *
     * @param string|null $queueName
     *
     * @return void
     */
    public function setQueueName(?string $queueName): void
    {
        $this->queueName = $queueName;
    }

    /**
     * MaxConsumers method
     *
     * @return int
     */
    public function getMaxConsumers(): int
    {
        return $this->maxConsumers;
    }

    /**
     * MaxConsumers method
     *
     * @param int $maxConsumers
     *
     * @return void
     */
    public function setMaxConsumers(int $maxConsumers): void
    {
        $this->maxConsumers = $maxConsumers;
    }

    /**
     * MaxMessagesToRead method
     *
     * @return int
     */
    public function getMaxMessagesToRead(): int
    {
        return $this->maxMessagesToRead;
    }

    /**
     * MaxMessagesToRead method
     *
     * @param int $maxMessagesToRead
     *
     * @return void
     */
    public function setMaxMessagesToRead(int $maxMessagesToRead): void
    {
        $this->maxMessagesToRead = $maxMessagesToRead;
    }

    /**
     * ActiveConsumers method
     *
     * @return int
     */
    public function getActiveConsumers(): int
    {
        return $this->activeConsumers;
    }

    /**
     * ActiveConsumers method
     *
     * @param int $activeConsumers
     *
     * @return void
     */
    public function setActiveConsumers(int $activeConsumers): void
    {
        $this->activeConsumers = $activeConsumers;
    }

    /**
     * MessagesInQueue method
     *
     * @return int
     */
    public function getMessagesInQueue(): int
    {
        return $this->messagesInQueue;
    }

    /**
     * MessagesInQueue method
     *
     * @param int $messagesInQueue
     *
     * @return void
     */
    public function setMessagesInQueue(int $messagesInQueue): void
    {
        $this->messagesInQueue = $messagesInQueue;
    }

    /**
     * ToArray method
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::ENABLED_FIELD => $this->isEnabled(),
            self::ACTIVE_CONSUMERS_FIELD => $this->getActiveConsumers(),
            self::MAX_CONSUMERS_FIELD => $this->getMaxConsumers(),
            self::MAX_MESSAGES_TO_READ_FIELD => $this->getMaxMessagesToRead(),
            self::QUEUE_FIELD => $this->getQueueName(),
            self::MESSAGES_IN_QUEUE_FIELD => $this->getMessagesInQueue(),
        ];
    }

    /**
     * SetData method
     *
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data): void
    {
        $this->setEnabled((bool) ($data[self::ENABLED_FIELD] ?? false));
        $this->setQueueName($data[self::QUEUE_FIELD] ?? null);
        $this->setMaxConsumers((int) ($data[self::MAX_CONSUMERS_FIELD] ?? 0));
        $this->setMaxMessagesToRead((int) ($data[self::MAX_MESSAGES_TO_READ_FIELD] ?? 0));
        $this->setActiveConsumers((int) ($data[self::ACTIVE_CONSUMERS_FIELD] ?? 0));
        $this->setMessagesInQueue((int) ($data[self::MESSAGES_IN_QUEUE_FIELD] ?? 0));
    }

    /**
     * GetNeededConsumers method
     *
     * @return int
     */
    public function getNeededConsumers(): int
    {
        $messagesInQueue = $this->getMessagesInQueue();
        $maxMessagesToRead = $this->getMaxMessagesToRead();

        if (in_array(0, [$messagesInQueue, $maxMessagesToRead])) {
            return 0;
        }

        $neededConsumersFloat = (float) ($messagesInQueue / $maxMessagesToRead);
        $neededConsumers = (int) ceil($neededConsumersFloat);

        $maxConsumers = $this->getMaxConsumers();
        $activeConsumers = $this->getActiveConsumers();
        if ($neededConsumers > $maxConsumers) {
            return $maxConsumers - $activeConsumers;
        }

        return $neededConsumers - $activeConsumers;
    }

    /**
     * JsonSerialize method
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
