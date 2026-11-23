
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('media_id')
                ->unique()
                ->constrained('media')
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('episodes');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_details');
    }
};
