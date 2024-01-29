<?php
declare(strict_types=1);

namespace App\Service\Parser;

use InvalidArgumentException;

class ParcerFactory implements ParserFactoryInterface {
    public function createParser(string $bankName): ParserInterface
    {
        $parserName = 'App\Service\Parser\\' . $bankName;
        if (!class_exists($parserName)) {
            throw new InvalidArgumentException("Class $bankName not exist");
        }
        return new $parserName();
    }
}
