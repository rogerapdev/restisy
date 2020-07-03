<?php

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = json_decode(file_get_contents(__DIR__ . '/../data/types.json'), true);

        foreach ($types as $type) {

            $found = Type::where('slug', $type['slug'])->where('group', $type['group'])->first();
            if (!$found) {
                Type::create($type);
            }
        }
    }
}
