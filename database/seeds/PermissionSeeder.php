<?php

use App\Models\Permission;
use App\Models\Resource;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = json_decode(file_get_contents(__DIR__ . '/../data/permissions.json'), true);

        foreach ($permissions as $key => $permission) {

            $found = Permission::where('action', $permission['action'])->first();
            if (!$found) {
                if (isset($permission['resource']) and $permission['resource']) {
                    $resource = Resource::where('slug', $permission['resource'])->first();
                    unset($permission['resource']);
                    $permission['resource_id'] = $resource->id;
                }
                $found = Permission::create($permission);
            }

        }
    }
}
