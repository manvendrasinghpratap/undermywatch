<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sections;
use App\SectionSettings;
use Auth;
use App\User;
use App\UserSection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SectionController extends Controller
{
    //

    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('admin');
    	$this->middleware('superadmin');
    }

    public function index(Request $request){
    	$sections = Sections::get();
    	return view('superadmin.sections.index')->with('sections', $sections);
    }

    public function new(Request $request){
    	return view('superadmin.sections.new');
    }

    public function create(Request $request){
      //echo '<pre>'; print_r($request->all()); echo '</pre>';
      $avatar = 'default.jpg';
      if ($request->hasFile('image')) {
        $cover = $request->file('image');
        $extension = $cover->getClientOriginalExtension();
        Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));
      /*  $destinationPath = 'public/img/';
        $originalFile = $cover->getClientOriginalName();
        $cover->move($destinationPath, $originalFile);
        */

        $avatar         =   $cover->getFilename().'.'.$extension;
      }
      //$this->pp($request->all(),1);
      $superadminlevel = config('app.superadminlevel');
      $superAdmins = User::select('id')->whereLevel($superadminlevel)->get();
      $superAdminArray = $superAdmins->toArray();
      //echo '<pre>'; print_r($superAdminArray); echo '</pre>';

    	$section = new Sections;

      //  echo '<pre>'; print_r($request->get('setting')); echo '</pre>';  die();
    	 //var_dump($request->get('setting'));exit;


       /* To check slug unique Start*/
      $slug = $request->get("slug", "") ?: "";
     	$slug_exists = Sections::whereslug($slug)->first();
    	if(empty($slug) || !empty($slug_exists)){
    		if($request->ajax()){
    			return response()->json(['error' => "Slug Already Exists"]);
    		}else{
    			return back()
	    			->withInput()
	    			->with('error', 'slug already exists');
	    	}
    	}
      /* To check slug unique End */

      $section->name = $request->get('name', "") ?: "";
      $section->slug = $slug;
    	$section->notes = $request->get('notes');
    	$section->createdby_id = $this->user()->id;
    	$section->image  =   $avatar;


    	if($section->save()){
    		foreach(($request->get('setting', []) ?: []) as $index => $setting){
    			$sectionsetting = new SectionSettings;
    			$sectionsetting->section_id = $section->id;
    			$sectionsetting->is_hidden = $setting['is_hidden'] ?? 0;
    			$sectionsetting->show_in_table = $setting['show_in_table'] ?? 0;
    			$sectionsetting->field = $setting['field'] ?? "";
    			$sectionsetting->field_title = $setting['field_title'] ?? "";
    			$sectionsetting->field_description = $setting['field_description'] ?? "";
    			$sectionsetting->default = $setting['default'] ?? "";
    			if(($setting['enable'] ?? 0)){
    				$sectionsetting->save();
    			}
    		}
        foreach ($superAdminArray as $superadminuserid) {
          //echo $superadminuserid['id'];
          $insertSuperAdminUserIdInUserSectionTbl = new UserSection;
          $insertSuperAdminUserIdInUserSectionTbl->user_id = $superadminuserid['id'];
          $insertSuperAdminUserIdInUserSectionTbl->section_id = $section->id;
          $insertSuperAdminUserIdInUserSectionTbl->save();
        }

    		if($request->ajax()){
    			return response()->json(['status' => "Successfully created section", 'section' => $section]);
    		}else{
    			return redirect()->route('superadmin.sections.section', ['section' => $section->slug]);
    		}
    	}
    	if($request->ajax()){
			return response()->json(['error' => 'Unable to save section']);
		}else{
			return redirect()->back()->withInput()->with('error', 'Unable to save section');
		}
    }

    public function section(Sections $section, Request $request){
        return view('superadmin.sections.section')->with('section', $section);
    }

    public function update(Sections $section, Request $request){
    //  $this->pp($request->all(),'0');
    $avatar = 'default.jpg';
    if ($request->hasFile('image')) {
      $cover = $request->file('image');
      $extension = $cover->getClientOriginalExtension();
      Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));
      $avatar         =   $cover->getFilename().'.'.$extension;
    }

    	$slug = $request->get("slug", $section->slug) ?? $section->slug;
    	$slug_exists = Sections::whereslug($slug)->where('id',"!=", $section->id)->first();
    	if(empty($slug) || !empty($slug_exists)){
    		if($request->ajax()){
    			return response()->json(['error' => "Slug Already Exists"]);
    		}else{
    			return back()
	    			->withInput()
	    			->with('error', 'slug already exists');
	    	}
    	}
      $section->name = $request->get('name', $section->name) ?? $section->name;
      $section->slug = $slug;
      $section->notes = $request->get('notes');
		if($section->save()){
			$section->settings()->delete();
    		foreach(($request->get('setting', []) ?: []) as $index => $setting){
    			$sectionsetting = new SectionSettings;
    			$sectionsetting->section_id = $section->id;
    			$sectionsetting->is_hidden = $setting['is_hidden'] ?? 0;
    			$sectionsetting->show_in_table = $setting['show_in_table'] ?? 0;
    			$sectionsetting->field = $setting['field'] ?? "";
    			$sectionsetting->field_title = $setting['field_title'] ?? "";
    			$sectionsetting->field_description = $setting['field_description'] ?? "";
    			$sectionsetting->default = $setting['default'] ?? "";
    			if(($setting['enable'] ?? 0)){
    				$sectionsetting->save();
    			}
    		}
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully updated section", 'section' => $section]);
    		}else{
    			return redirect()->route('superadmin.sections.section', ['section' => $section->slug])->with('status', "Successfully Updated");
    		}
    	}
    	if($request->ajax()){
			return response()->json(['error' => 'Unable to update section']);
		}else{
			return redirect()->back()->withInput()->with('error', 'Unable to update section');
		}
    }

    public function delete(Sections $section, Request $request){
    	if($section->delete()){
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully removed section"]);
    		}else{
    			return redirect()->route('superadmin.sections.index')->with('status', "Successfully removed section");
    		}
    	}else{
    		if($request->ajax()){
    			return response()->json(['error' => "Unable to remove section"]);
    		}else{
    			return redirect()->back()->with('error', "Unable to remove section");
    		}
    	}
    }

    public function users(Sections $section, Request $request){
    	return view('admin.sections.users')->with('section', $section);
    }

    public function updateusers(Sections $section, Request $request){
    	$section->assignedto()->sync(($request->get('users', []) ?: []));
    	if($request->ajax()){
			return response()->json(['status' => 'Users Updated']);
		}else{
    		return redirect()->back()->with('status', "Users Updated");
		}
    }

    public function user(){
    	return Auth::user();
    }

}
