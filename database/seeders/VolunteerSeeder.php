<?php

namespace Database\Seeders;

use App\Models\Volunteer;
use Illuminate\Database\Seeder;

class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $volunteers = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1234567890',
                'skills' => 'Teaching, Mentoring, Public Speaking',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1234567891',
                'skills' => 'Healthcare, First Aid, Patient Care',
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael.j@example.com',
                'phone' => '+1234567892',
                'skills' => 'Construction, Carpentry, Electrical Work',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'phone' => '+1234567893',
                'skills' => 'Event Planning, Coordination, Marketing',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@example.com',
                'phone' => '+1234567894',
                'skills' => 'IT Support, Web Development, Database Management',
            ],
        ];

        foreach ($volunteers as $volunteer) {
            Volunteer::create($volunteer);
        }
    }
}
