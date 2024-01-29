<?php
declare(strict_types=1);

namespace App\Service\Notify;

use App\DTO\MessageInput;

interface NotifyInterface
{
    public function send(MessageInput $messageInput);
}
