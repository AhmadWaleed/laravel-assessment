<?php

namespace Tests\Unit;

use App\Reader;
use App\JsonCollectionReader;
use PHPUnit\Framework\TestCase;

class JsonReaderTest extends TestCase
{
    protected Reader $reader;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Reader $reader */
        $this->reader = new JsonCollectionReader(new \JsonCollectionParser\Parser);
    }

    public function testReadsJsonDocument(): void
    {
        $data = [];
        $this->reader->read(__DIR__.'/../data/example.json', function (array $items) use (&$data) {
            foreach ($items as $item) {
                $data[] = $item;
            }
        }, 4);

        $this->assertSame(4, count($data));
    }

    public function testReadsJsonDocumentInChunks(): void
    {
        $chunk = 0;
        $this->reader->read(__DIR__.'/../data/example.json', function (array $items) use (&$chunk) {
            $chunk++;
        }, 1);

        $this->assertSame(4, $chunk);
    }

    public function testReadsEmptyArrayJsonDocument(): void
    {
        $chunk = 0;
        $this->reader->read(__DIR__.'/../data/empty.array.json', function (array $items) use (&$chunk) {
            $chunk++;
        }, 1);

        $this->assertSame(0, $chunk);
    }

    public function testReadsEmptyJsonDocument(): void
    {
        $chunk = 0;
        $this->reader->read(__DIR__.'/../data/empty.json', function (array $items) use (&$chunk) {
            $chunk++;
        }, 1);

        $this->assertSame(0, $chunk);
    }
}
