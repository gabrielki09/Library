<?php

use App\Book\BookLoansStatus;
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
        Schema::create('book_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->foreignId('reader_id')->constrained('readers')->cascadeOnDelete();
            $table->enum('status', [array_column(BookLoansStatus::cases(), 'value')]);
            $table->timestamp('loan_date');
            $table->date('due_date');
            $table->timestamp('returned_at')->nullable();
            $table->decimal('fine_amount', 10, 2);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_loans');
    }
};
