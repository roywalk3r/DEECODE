<?php

namespace Database\Seeders;

use App\Models\Attendances;
use App\Models\ClassGroups;
use App\Models\Discounts;
use App\Models\FeeStructures;
use App\Models\Guardians;
use App\Models\Invoices;
use App\Models\PaymentMethods;
use App\Models\Payments;
use App\Models\Students;
use App\Models\Teachers;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Couchbase\Role;
use Database\Factories\AttendancesFactory;
use Database\Factories\PaymentsFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $user = User::factory()->create([
            'name' => 'aerk',
            'email' => 'admin@developer.com',
        ]);
        // Assign the 'developer' role and 'super admin' permission to the user
        $user->assignRole('developer');
        User::factory(15)->create();
        Teachers::factory(15)->create();
        Students::factory()->count(15)->create();
        ClassGroups::factory()->count(15)->create();
        Guardians::factory()->count(15)->create();
        FeeStructures::factory()->count(15)->create();
        PaymentMethods::factory()->count(15)->create();
        Payments::factory()->count(15)->create();
        Invoices::factory()->count(15)->create();
        Attendances::factory()->count(15)->create();
        Discounts::factory()->count(15)->create();

    }
}
