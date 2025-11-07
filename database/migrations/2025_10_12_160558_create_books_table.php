<?php

use App\Models\Author;
use App\Models\Category;
use App\Models\Language;
use App\Models\Library;
use App\Models\Publisher;
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Library::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('total_stock');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('pages');
            $table->float('rate');
            $table->year('publish_year');
            $table->float('price');
            $table->boolean('is_available')->default(1);
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Language::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Publisher::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Author::class)->nullable()->constrained()->nullOnDelete();
            $table->unique(['library_id', 'slug']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
