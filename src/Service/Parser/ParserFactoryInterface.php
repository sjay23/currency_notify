<?php
declare(strict_types=1);

namespace App\Service\Parser;

interface ParserFactoryInterface
{
    public function createParser(string $bankName): ParserInterface;
}
