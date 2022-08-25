<?php

namespace Database\Seeders;

use App\Models\t_admin;
use Illuminate\Database\Seeder;

class akunseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'username' => 'superadmin',
                'name' => 'Fadel',
                'email' => 'andimuhfadel@gmail.com',
                'level' => '1',
                'password' => bcrypt('admin123')
            ],
            [
                'username' => 'Admin',
                'name' => 'admin skp',
                'email' => 'unm@gmail.com',
                'level' => '2',
                'password' => bcrypt('admin456')
            ]

        ];
        foreach ($user as  $value) {
            t_admin::create($value);
        }
    }
}
