<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkImportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('bulk_imports', function (Blueprint $table): void {
            $table->id();
            $table->json('batches')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulk_imports');
    }
}
