<?php

use App\Item;
use App\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $items = Item::pluck('id');

        $transactions = factory(Transaction::class, 50)->create();

        $transactions->each(function ($transaction) use ($items) {
            $transaction->items()->attach($items->random(rand(1, 4)));
        });
    }
}
