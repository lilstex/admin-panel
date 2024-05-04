<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cmsPageRecord = [
            ['id' => 5, 'title' => 'Contact Us', 'url' => 'contact-us', 'desc' => 'This is contact us page',
            'meta_title' => 'contact us', 'meta_desc' => 'This is contact us content', 'meta_keywords' => 'contact us, contact, address', 'status' => 1
            ],
        ];

        CmsPage::insert($cmsPageRecord);
    }
}
