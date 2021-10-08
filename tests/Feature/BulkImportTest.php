<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Contact;
use App\Models\BulkImport;
use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BulkImportTest extends TestCase
{
    use DatabaseTransactions;

    public function testBulkImportJson(): void
    {
        Bus::fake();

        $this->artisan('import:json', [
            'filepath' => $this->app->basePath('tests/data/example.json'),
        ]);

        Bus::assertBatched(function (PendingBatch $batch) {
            $this->assertSame(4, $batch->jobs->count());

            return $batch->name == 'import-json';
        });

        $import = BulkImport::first();
        $this->assertCount(1, $import->batches);
    }

    public function testProcessBulkImportInMultipleBatches(): void
    {
        Bus::fake();

        $this->artisan('import:json', [
            'filepath' => $this->app->basePath('tests/data/example.json'),
            '--chunk-size' => 2,
        ]);

        Bus::assertBatched(function (PendingBatch $batch) {
            $this->assertSame(2, $batch->jobs->count());

            return $batch->name == 'import-json';
        });

        $import = BulkImport::first();
        $this->assertCount(2, $import->batches);
    }

    public function testBulkImportRecordsIntoDatabase(): void
    {
        $this->artisan('import:json', [
            'filepath' => $this->app->basePath('tests/data/example.json'),
        ]);

        $this->assertCount(1, BulkImport::first()->batches);
        $this->assertSame(4, Contact::count());
    }

    public function testAbortImport(): void
    {
        $this->artisan('import:json', [
            'filepath' => $this->app->basePath('tests/data/example.json'),
        ]);

        $this->assertSame(4, Contact::count());

        $this->artisan('abort:import', [
            'id' => BulkImport::first()->id,
        ]);

        $this->assertSame(0, Contact::count());
    }
}
