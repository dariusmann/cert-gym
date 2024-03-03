<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CategoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert categories from JSON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get JSON
        $json = Storage::get('categories/categories.json');

        // Decode JSON
        $data = json_decode($json, true);

        // Root category
        $root = Category::create([
            'name' => 'root',
            'short_code' => null,
            'description' => null,
            'parent_id' => null,
        ]);

        // Parent categories
        foreach ($data as $category) {
            $parent = Category::create([
                'name' => $category['topic'],
                'short_code' => $category['short_code'],
                'description' => null,
                'parent_id' => $root->id,
            ]);

            // Subcategories
            foreach ($category['subtopics'] as $subtopic) {
                Category::create([
                    'name' => $subtopic['short_code'],
                    'short_code' => $subtopic['short_code'],
                    'description' => $subtopic['topic'],
                    'parent_id' => $parent->id,
                ]);
            }
        }

        $this->info('Categories inserted successfully.');
    }
}
