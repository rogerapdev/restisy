<?php

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = json_decode(file_get_contents(__DIR__ . '/../data/roles.json'), true);

        foreach ($roles as $role) {

            $foundRole = Role::where('slug', $role['slug'])->first();
            if (!$foundRole) {
                $foundRole = Role::create($role);
            }

            foreach ($role['permissions'] as $permission) {
                $foundPermission = Permission::where('action', $permission)->first();
                if ($foundPermission) {
                    
                }
            }

        }
    }
}
