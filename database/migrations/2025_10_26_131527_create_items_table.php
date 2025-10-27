<?php

use App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();

            $table->text('name')->index();
            $table->boolean('is_consumable');
            $table->boolean('is_lendable');
            $table->integer('amount');
            $table->jsonb('tags')->default('[]')->index();

            $table->foreignIdFor(Warehouse::class)
                ->references('id')
                ->on('places')
                ->restrictOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
