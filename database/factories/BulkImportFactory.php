<?php

namespace Database\Factories;

use App\Models\BulkImport;
use Illuminate\Database\Eloquent\Factories\Factory;

class BulkImportFactory extends Factory
{
    protected $model = BulkImport::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'batches' => [],
        ];
    }
}
