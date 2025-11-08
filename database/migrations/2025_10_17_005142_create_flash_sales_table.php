<?php

use App\Models\FlashSale;
use App\Models\Library;
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
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Library::class)->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('discount_type')->default(FlashSale::DEFAULT_TYPE);
            $table->decimal('discount_value', 8, 2);
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->boolean('applies_to_all_books')->default(0);
            $table->unsignedTinyInteger('status')->default(FlashSale::DEFAULT_STATUS);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sales');
    }
};
