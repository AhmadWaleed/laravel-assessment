<?php

declare(strict_types=1);

namespace App;

use JsonCollectionParser\Parser;

class JsonCollectionReader implements Reader
{
    public function __construct(protected Parser $parser)
    {
    }

    public function read(string $filepath, callable $callback, int $chunkSize)
    {
        $this->parser->chunk($filepath, fn (array $item) => $callback($item), $chunkSize);
    }
}
