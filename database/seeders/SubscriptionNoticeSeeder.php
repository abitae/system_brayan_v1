<?php

namespace Database\Seeders;

use App\Models\Configuration\SubscriptionNotice;
use Illuminate\Database\Seeder;

class SubscriptionNoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscriptionNotice::query()->firstOrCreate(
            ['id' => 1],
            [
                'fecha_vencimiento' => null,
                'is_activo' => false,
                'is_close' => false,
            ]
        );
    }
}
