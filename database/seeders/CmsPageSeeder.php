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
            ['id' => 1, 'title' => 'Contact Us', 'url' => 'contact-us', 'desc' => 'This is contact us page',
            'meta_title' => 'contact us', 'meta_desc' => 'This is contact us content', 'meta_keywords' => 'contact us, contact, address', 'status' => 1
            ],
            ['id' => 2, 'title' => 'About Us', 'url' => 'about-us', 'desc' => 'This is about us page',
            'meta_title' => 'about us', 'meta_desc' => 'This is about us content', 'meta_keywords' => 'about us, about', 'status' => 1
            ],
            ['id' => 3, 'title' => 'Gallery', 'url' => 'gallery', 'desc' => 'This is gallery page',
            'meta_title' => 'gallery', 'meta_desc' => 'This is gallery page', 'meta_keywords' => 'gallery, images, pictures', 'status' => 1
            ],
            ['id' => 4, 'title' => 'Service', 'url' => 'service', 'desc' => 'This is service page',
            'meta_title' => 'service', 'meta_desc' => 'This is service page', 'meta_keywords' => 'service, job', 'status' => 1
            ],
        ];

        CmsPage::insert($cmsPageRecord);
    }
}
