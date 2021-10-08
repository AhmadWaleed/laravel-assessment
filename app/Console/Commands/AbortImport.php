<?php

namespace App\Console\Commands;

use App\Models\BulkImport;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Bus;

class AbortImport extends Command
{
    protected $signature = 'abort:import {id}';

    protected $description = 'Abort import operation for given transaction id.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Connection $connection): int
    {
        $import = BulkImport::findOrFail($this->argument('id'));

        $pending = 0;

        foreach ($import->batches as $id) {
            $batch = Bus::findBatch($id);
            if ($batch->canceled()) {
                continue;
            }

            $pending++;
            $batch->cancel();
        }

        $this->info("Total: $pending import operations cancelled out of: ".count($import->batches));

        $this->info("Rolling back imported records....");
        $connection->table('contacts')->where('import_transaction_id', $import->id)->delete();
        $this->info("Records roll backed successfully.");

        return 0;
    }
}
