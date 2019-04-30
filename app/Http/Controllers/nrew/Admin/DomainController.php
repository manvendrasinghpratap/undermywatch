<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains;
use Auth;
use App\User;
class DomainController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('admin');
    }

    public function index(){
         $this->user()->level; //die();
         $superadminlevel = config('app.superadminlevel');
         $adminlevel = config('app.adminlevel');
        if($this->user()->level==$superadminlevel)
            $domains = Domains::latest()->get();
        elseif ($this->user()->level==$adminlevel) {
            $getUserId = User::whereCompany_id($this->user()->company_id)->pluck('id','id');
            $domains = Domains::whereIn('addedby_id',$getUserId)->latest()->get();
        }
        else
            $domains = Domains::where('addedby_id',$this->user()->id)->latest()->get();
            //echo '<pre>'; print_r($domains); echo '</pre>'; die();
    	return view('admin.domains.index')
                ->with('domains',$domains);
    }

    public function create(Request $request){
    	$_domain = trim($request->get('domain', "") ?: "");
    	$domain = Domains::wheredomain($_domain)->first();
    	if(!empty($domain) || empty($_domain)){
    		if($request->ajax()){
                return response()->json(['error' => "Domain Already exists or empty"]);
    		}else{
                return redirect()->back()->withInput()->with('error', "Domain Already exists or empty");
            }
    	}else{
            $domain = new Domains;
            $domain->domain = $_domain;
            $domain->is_public = $request->get('is_public');
            $domain->note = $request->get('note');
            //$domain->is_public = 1;
            $domain->addedby_id = $this->user()->id;
            if($domain->save()){
                if($request->ajax()){
                    return response()->json(['status' => "Successfully Saved", "domain" => $domain]);
                }else{
                    return redirect()->back()->with('status', "Successfully Saved");
                }
            }else{
                if($request->ajax()){
                    return response()->json(['status' => "Domain Already exists or empty"]);
                }else{
                    return redirect()->back()->withInput()->with('error', "Domain Already exists or empty");
                }
            }
        }
    }

    public function update(Domains $domain, Request $request){
    	$domain->note = $request->get('note', $domain->note);
        if($domain->save()){
                if($request->ajax()){
                    return response()->json(['status' => "Successfully Updated", "domain" => $domain]);
                }else{
                    return redirect()->back()->with('status', "Successfully Updated");
                }
            }else{
                if($request->ajax()){
                    return response()->json(['status' => "Unable to update"]);
                }else{
                    return redirect()->back()->withInput()->with('error', "Unable to update");
                }
            }
    }

    public function delete(Domains $domain, Request $request){
    	if($domain->delete()){
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully removed domain"]);
    		}else{
    			return redirect()->back()->with('status', "Successfully removed domain");
    		}
    	}else{
    		if($request->ajax()){
    			return response()->json(['error' => "Unable to remove"]);
    		}else{
    			return redirect()->back()->with('error', "Unable to remove");
    		}
    	}
    }

    public function enable_log(Domains $domain, Request $request){
        $domain->enable_log = 1;
    	if($domain->save()){
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully Enabled Logging"]);
    		}else{
    			return redirect()->back()->with('status', "Successfully Enabled Logging");
    		}
    	}else{
    		if($request->ajax()){
    			return response()->json(['error' => "Unable to enable logging"]);
    		}else{
    			return redirect()->back()->with('error', "Unable to enable logging");
    		}
    	}
    }

    public function disable_log(Domains $domain, Request $request){
        $domain->enable_log = 0;
    	if($domain->save()){
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully Disabked Logging"]);
    		}else{
    			return redirect()->back()->with('status', "Successfully Disabked Logging");
    		}
    	}else{
    		if($request->ajax()){
    			return response()->json(['error' => "Unable to disable loggin"]);
    		}else{
    			return redirect()->back()->with('error', "Unable to disable logging");
    		}
    	}
    }

    public function user(){
        return Auth::user();
    }

}
