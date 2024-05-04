<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CmsInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CmsPageStoreRequest;
use App\Http\Requests\CmsPageUpdateRequest;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CmsPageController extends Controller
{
    public $cmsPage;

     /**
     * Assingning the cms interface to the cmsPage
     */
    public function __construct(CmsInterface $cmsInterface) {
        $this->cmsPage = $cmsInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'cms-page');
        $data = $this->cmsPage->all();
        $allPages = $data['pages'];
        $permissions = $data['permissions'];
        if($permissions['view_access'] == 1 || $permissions['edit_access'] == 1 || $permissions['full_access'] == 1) {
            return view('admin.pages.index')->with(compact('allPages', 'permissions'));
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Unauthorised to view the resource']);
        }
    }

     /**
     * Update cms page status
     */
    public function updateCmsStatus(Request $request)
    {
        if($request->ajax()) {
            $data = $request->all();
            $isChanged = $this->cmsPage->updateStatus($data);

            if($isChanged) {
                return response()->json(['status' => $data['status'], 'page_id' => $data['page_id']]);
            } else {
                return redirect()->back()->withErrors(['error_message' => 'Failed to update admin profile']);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Session::put('page', 'cms-page');
        $title = 'Add CMS Page';
        return view('admin.pages.create')->with(compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CmsPageStoreRequest $request)
    {
        $validated = $request->validated();
        $newCmsPage = $this->cmsPage->create($validated);
        
        if($newCmsPage) {
            return redirect('admin/cms_page')->with(['success_message' => 'New CMS Page added successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to add CMS Page']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CmsPage $cmsPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        Session::put('page', 'cms-page');
        $title = 'Edit CMS Page';
        $cmsPage = $this->cmsPage->show($id);
        return view('admin.pages.create')->with(compact('title', 'cmsPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CmsPageUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $updatedCmsPage = $this->cmsPage->update($id, $validated);
        
        if($updatedCmsPage) {
            return redirect('admin/cms_page')->with(['success_message' => 'CMS Page updated successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to update CMS Page']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deletedCmsPage = $this->cmsPage->delete($id);
        
        if($deletedCmsPage) {
            return redirect()->back()->with(['success_message' => 'CMS Page deleted successfully']);
        } else {
            return redirect()->back()->withErrors(['error_message' => 'Failed to update CMS Page']);
        }
    }
}
