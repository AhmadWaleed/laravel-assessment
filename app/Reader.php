<?php

declare(strict_types=1);

namespace App;

interface Reader
{
    public function read(string $filepath, callable $callback, int $chunkSize);
}
