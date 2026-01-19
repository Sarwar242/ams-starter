<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Design & Supervision Department',
                'description' => 'Responsible for design and supervision tasks.',
                'created' => 1,
                'modified' => 1,
            ],
            [
                'name' => 'Production Design Department',
                'description' => 'Handles production design and related tasks.',
                'created' => 1,
                'modified' => 1,
            ],
            [
                'name' => 'Planning Department',
                'description' => 'Handles project planning and scheduling.',
                'created' => 1,
                'modified' => 1,
            ],
            [
                'name' => 'Administration Department',
                'description' => 'Handles HR, finance, and administrative work.',
                'created' => 1,
                'modified' => 1,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
