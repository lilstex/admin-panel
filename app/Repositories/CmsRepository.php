<?php 

namespace App\Repositories;

use App\Contracts\CmsInterface;
use App\Models\Admin;
use App\Models\CmsPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class CmsRepository implements CmsInterface {
    public function all() {
        return CmsPage::all();
    }

    public function create(array $data) {
        return CmsPage::create([
            'title' => $data['title'],
            'desc' => $data['description'],
            'url' => $data['url'],
            'meta_desc' => $data['meta_description'],
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
            'status' => 1,
        ]);
    }

    public function show($id) {
        return CmsPage::find($id);
    }

    public function update($id, array $data) {
        $cmsPage = CmsPage::find($id);
        return $cmsPage->update([
            'title' => $data['title'],
            'desc' => $data['description'],
            'url' => $data['url'],
            'meta_desc' => $data['meta_description'],
            'meta_title' => $data['meta_title'],
            'meta_keywords' => $data['meta_keywords'],
        ]);
    }

    public function updateStatus(array $data) {
        if($data['status'] == 'Active') {
            $status = 0;
        } else {
            $status = 1;
        }
        $id = (int)$data['page_id'];
        $cmsPage = CmsPage::where('id', $id)->update(['status' => $status]);
        return $cmsPage;
    }

    
    public function delete($id) {
        return CmsPage::destroy($id);
    }
}