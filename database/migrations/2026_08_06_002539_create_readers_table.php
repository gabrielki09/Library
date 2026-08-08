<?php

use App\Reader\ReadersStatus;
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
        Schema::create('readers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email')->unique('un_readers_email');
            $table->string('document', 20)->unique('un_readers_document');
            $table->string('phone', 20);
            $table->enum('status', [array_column(ReadersStatus::cases(), 'value')]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readers');
    }
};
