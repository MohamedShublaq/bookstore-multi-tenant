<?php

use App\Models\Coupon;
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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Library::class)->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->unsignedTinyInteger('discount_type')->default(Coupon::DEFAULT_TYPE);
            $table->decimal('discount_value', 8, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('applies_to_all_books')->default(0);
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('per_user_limit')->nullable();
            $table->unsignedTinyInteger('status')->default(Coupon::DEFAULT_STATUS);
            $table->unique(['library_id', 'code']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
