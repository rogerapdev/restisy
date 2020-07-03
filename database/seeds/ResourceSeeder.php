<?php

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = json_decode(file_get_contents(__DIR__ . '/../data/resources.json'), true);

        foreach ($resources as $resource) {

            $found = Resource::where('slug', $resource['slug'])->first();
            if (!$found) {
                Resource::create($resource);
            }
        }
    }
}
