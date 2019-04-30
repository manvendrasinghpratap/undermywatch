<?php

namespace App\Http\Controllers\User;

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
    	$this->middleware('user');
    }

    public function index(){
        if($this->user()->level==config('app.superadminlevel'))
            $domains = Domains::latest()->get();
        else{
            $companyAdmins = User::where('company_id',$this->user()->company_id)->where('level',config('app.adminlevel'))->pluck('id','id');
            $domains = Domains::where('addedby_id',$this->user()->id)
                      ->orwhere(function($query) use($companyAdmins){
                        $query->whereIn('is_public',[0]);
                        $query->whereIn('addedby_id',$companyAdmins);
                      })
                      ->latest()->get();
              }
    	return view('user.domains.index')
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
            //$domain->is_public = $request->get('is_public');
            $domain->is_public = 1;
            $domain->note = $request->get('note');
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
