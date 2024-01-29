<?php
declare(strict_types=1);

namespace App\DTO;

class MessageInput
{
    public function __construct(
        private string $title,
        private string $content,
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
