<?php

namespace Database\Seeders;

use App\Models\Role as ModelsRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        ModelsRole::firstOrCreate(['name' => 'Admin']);
        ModelsRole::firstOrCreate(['name' => 'Driver']);
        ModelsRole::firstOrCreate(['name' => 'Passenger']);
    }
}
