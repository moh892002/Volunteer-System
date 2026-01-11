<?php

namespace Database\Seeders;

use App\Models\Workplace;
use Illuminate\Database\Seeder;

class WorkplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workplaces = [
            [
                'name' => 'Community Center Downtown',
                'address' => '123 Main Street, Downtown',
                'description' => 'Main community center serving the downtown area',
                'phone' => '+1234567800',
                'email' => 'downtown@community.org',
            ],
            [
                'name' => 'City Hospital',
                'address' => '456 Health Avenue, Medical District',
                'description' => 'Primary healthcare facility providing medical services',
                'phone' => '+1234567801',
                'email' => 'info@cityhospital.org',
            ],
            [
                'name' => 'Public Library',
                'address' => '789 Book Street, Education Quarter',
                'description' => 'Public library with educational programs and resources',
                'phone' => '+1234567802',
                'email' => 'contact@publiclibrary.org',
            ],
            [
                'name' => 'Senior Care Home',
                'address' => '321 Elder Road, Residential Area',
                'description' => 'Care facility for elderly residents',
                'phone' => '+1234567803',
                'email' => 'info@seniorcare.org',
            ],
            [
                'name' => 'Youth Center',
                'address' => '654 Youth Plaza, Recreation District',
                'description' => 'Center providing activities and programs for young people',
                'phone' => '+1234567804',
                'email' => 'contact@youthcenter.org',
            ],
        ];

        foreach ($workplaces as $workplace) {
            Workplace::create($workplace);
        }
    }
}
