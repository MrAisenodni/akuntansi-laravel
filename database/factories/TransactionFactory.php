<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'title'         => 'Shopping',
            'amount'        => 1000000,
            'type'          => 'expense',
            'disabled'      => 0,
            'created_by'    => 'Testing',
            'updated_at'    => NULL,
        ];
    }
}
