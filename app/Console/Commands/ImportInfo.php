<?php

namespace App\Console\Commands;

use App\Models\BulkImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class ImportInfo extends Command
{
    protected $signature = 'import:info {id}';

    protected $description = 'Provided bulk import info like how many records has been processed or remaining.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $import = BulkImport::findOrFail($this->argument('id'));

        $rows = [];
        foreach ($import->batches as $id) {
            $batch = Bus::findBatch($id);
            if (is_null($batch)) {
                $this->confirmToProceed($id);
            }

            $rows[] = [
                'ID' => $batch->id,
                'Total' => $batch->totalJobs,
                'Pending' => $batch->pendingJobs,
                'Failed' => $batch->failedJobs,
                'Processed' => $batch->processedJobs(),
                'Progress' => $batch->progress(),
                'Processed At' => $batch->createdAt->toDateTimeString(),
                'Finished At' => $batch->finishedAt->toDateTimeString(),
            ];
        }

        $headers = [
            'ID',
            'Total',
            'Pending',
            'Failed',
            'Processed',
            'Progress',
            'Processed At',
            'Finished At',
        ];

        $this->table($headers, $rows);

        return 0;
    }

    public function confirmToProceed(int $id): void
    {
        $warn = "No batch found with ID: $id, Would you still like to continue anyway?";
        if (! $this->ask($warn, false)) {
            throw new \UnexpectedValueException("No batch found with ID: $id");
        }
    }
}
