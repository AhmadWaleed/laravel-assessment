<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 50);
            $table->string('email', 120);
            $table->bigInteger(column: 'account', unsigned: true);
            $table->string('interest', 150)->nullable();
            $table->mediumText('address');
            $table->boolean('checked');
            $table->longText('description')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->json('credit_card')->nullable();
            $table->unsignedBigInteger('import_transaction_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
}
