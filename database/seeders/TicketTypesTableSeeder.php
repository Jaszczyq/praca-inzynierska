<?php

namespace Database\Seeders;

// database/seeds/TicketTypesTableSeeder.php

use Illuminate\Database\Seeder;
use App\Models\TicketType;

class TicketTypesTableSeeder extends Seeder
{
    public function run()
    {
        $ticket_types = [
            'Normalny',
            'Ulgowy',
            'Dla dzieci',
            'Grupowy'
        ];

        foreach ($ticket_types as $type) {
            TicketType::create(['name' => $type]);
        }
    }
}
