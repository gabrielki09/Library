<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Enums\Book\BookLoansStatus;
use Illuminate\Support\Facades\DB;

#[Signature('book-loans:mark-late')]
#[Description('Marca empréstimos como vencidos se a data de vencimento for inferior ao dia atual.')]
class MarkLateBookCommand extends Command
{

/**
     * Execute the console command.
     */
    public function handle()
    {
        $update = DB::connection('postgres')->table('book_loans')
        ->where('due_date', '<', now()->toDateString())
        ->whereNotIn('status', [
            'returned',
            'late',
            'canceled',
        ])
        ->update([
            'status' => BookLoansStatus::LATE->value,
            'updated_at' => now()
        ]);

        $this->info("Empréstimos marcados como atrasados: {$update}");

        return self::SUCCESS;
    }
}
