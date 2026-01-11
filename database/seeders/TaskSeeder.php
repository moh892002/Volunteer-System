<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'name' => 'Food Distribution',
                'description' => 'Distribute food packages to families in need',
            ],
            [
                'name' => 'Medical Assistance',
                'description' => 'Provide basic medical care and health checkups',
            ],
            [
                'name' => 'Educational Support',
                'description' => 'Tutor students and provide educational materials',
            ],
            [
                'name' => 'Community Cleanup',
                'description' => 'Organize and participate in neighborhood cleanup activities',
            ],
            [
                'name' => 'Elderly Care',
                'description' => 'Visit and assist elderly residents with daily tasks',
            ],
            [
                'name' => 'Youth Mentoring',
                'description' => 'Mentor young people and provide career guidance',
            ],
            [
                'name' => 'Fundraising Events',
                'description' => 'Organize and manage fundraising activities',
            ],
            [
                'name' => 'IT Support',
                'description' => 'Provide technical support and computer training',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
