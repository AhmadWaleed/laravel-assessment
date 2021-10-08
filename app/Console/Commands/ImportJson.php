<?php

namespace App\Console\Commands;

use App\Reader;
use App\DTO\Contact;
use App\Models\BulkImport;
use App\Jobs\ImportContact;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Contracts\Foundation\Application;

class ImportJson extends Command
{
    protected $signature = 'import:json {filepath} {--chunk-size=1000} {--batch-size=500}';

    protected $description = 'This command will neatly transfers the contents of the JSON file to a database.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Reader $reader, Application $app): int
    {
        $filepath = $this->argument('filepath');

        $import = BulkImport::create();

        $reader->read($filepath, function (array $items) use (&$jobs, $import) {
            collect($items)->chunk($this->option('batch-size'))->each(function (Collection $values) use ($import) {
                $jobs = $values
                    ->map(fn (array $item) => array_merge($item, ['import_transaction_id' => $import->id]))
                    ->map(fn (array $item) => Contact::new($item))
                    ->map(fn (Contact $contact) => new ImportContact($contact->toArray()))
                    ->toArray();

                $batch = Bus::batch($jobs)
                    ->name("import-json")
                    ->dispatch();

                $import->refresh();

                if (! is_null($import->batches)) {
                    $import->batches = array_merge($import->batches, Arr::wrap($batch->id));
                } else {
                    $import->batches = Arr::wrap($batch->id);
                }

                $import->save();
            });
        }, $this->option('chunk-size'));

        return 0;
    }
}
