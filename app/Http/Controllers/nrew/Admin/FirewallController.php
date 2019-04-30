<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Links;
use App\Ips;
use App\Isps;
use Carbon\Carbon;

class FirewallController extends Controller
{
    //
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('admin');
    }

    public function isps(){
        $type = array('public'=>'DCH','private'=>'TOR','wordpress1'=>'VPN','wordpress2'=>'Proxy','wordpress3'=>'Others');
        return view('admin.firewall.isps')->with('isps', Isps::get())->with('type',$type);
    }

    public function addisp(Request $request){

      //$this->pp($request->all(),0);
        $_isp = $request->get('isp', "") ?: "";
        $isp = Isps::whereisp($_isp)->first();
        if(!empty($isp) || empty($_isp)){
            if($request->ajax()){
                return response()->json(['error' => "ISP already exists or Blank ISP"]);
            }else{
                return redirect()->back()->with('error', "ISP already exists or Blank ISP")->withInput();
            }
        }
        $isp = new Isps;
        $isp->isp = $_isp;
        if($isp->save()){
            if($request->ajax()){
                return response()->json(['status' => "Successfully added ISP", 'isp' => $isp]);
            }else{
                return redirect()->back()->with('status', "Successfully added ISP");
            }
        }
        if($request->ajax()){
            return response()->json(['error' => "Unable to add ISP"]);
        }else{
            return redirect()->back()->with('error', "Unable to add ISP")->withInput();
        }
    }

    public function ips(){
        return view('admin.firewall.ips')->with('ips', Ips::get());
    }

    public function addips(Request $request){
        $_start = $request->get('start', "0.0.0.0") ?: "0.0.0.0";
        $_end = $request->get('end', $_start) ?: $_start;
        $_start = $this->ip_address_to_number($_start);
        $_end = $this->ip_address_to_number($_end);
        // $_start = ip2long($_start);
        // $_end = ip2long($_end);
        $ip = Ips::where('start', '<=', $_start)->where('end', '>=', $_end)->first();
        if(!empty($ip) || $_start == 0 || $_start > $_end){
            if($request->ajax()){
                return response()->json(['error' => "IP range already exists or Invalid IP Range"]);
            }else{
                return redirect()->back()->with('error', "IP range already exists or Invalid IP Range")->withInput();
            }
        }
        $ip = new Ips;
        $ip->start = $_start;
        $ip->end = $_end;
        if($ip->save()){
            if($request->ajax()){
                return response()->json(['status' => "Successfully added IP Range", 'IP' => $ip]);
            }else{
                return redirect()->back()->with('status', "Successfully added ISP");
            }
        }
        if($request->ajax()){
            return response()->json(['error' => "Unable to add IP"]);
        }else{
            return redirect()->back()->with('error', "Unable to add IP")->withInput();
        }
    }

    public function deleteisp(Isps $isp, Request $request){
		if($isp->delete()){
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully removed ISP"]);
    		}else{
    			return redirect()->back()->with('status', "Successfully removed ISP");
    		}
    	}else{
    		if($request->ajax()){
    			return response()->json(['error' => "Unable to remove"]);
    		}else{
    			return redirect()->back()->with('error', "Unable to remove");
    		}
    	}
    }

    public function deleteip(Ips $ip, Request $request){
        if($ip->delete()){
            if($request->ajax()){
                return response()->json(['status' => "Successfully removed IP"]);
            }else{
                return redirect()->back()->with('status', "Successfully removed IP");
            }
        }else{
            if($request->ajax()){
                return response()->json(['error' => "Unable to remove"]);
            }else{
                return redirect()->back()->with('error', "Unable to remove");
            }
        }
    }

    public function deleteips(Request $request){
        $rep = (int)$request->get('repetition', 3) ?? 3;
        $ips = Ips::whereis_permanent(0)->where('updated_at', '<', Carbon::now()->subHours(3)->toDateTimeString())->where('repetition', "<", $rep);
    	if($ips->delete()){
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully removed IP"]);
    		}else{
    			return redirect()->back()->with('status', "Successfully removed IP");
    		}
    	}else{
    		if($request->ajax()){
    			return response()->json(['error' => "Unable to remove"]);
    		}else{
    			return redirect()->back()->with('error', "Unable to remove");
    		}
    	}
    }

    public function blockpermanent(Ips $ip, Request $request){
        $ip->is_permanent = 1;
    	if($ip->save()){
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully blocked IP permanently"]);
    		}else{
    			return redirect()->back()->with('status', "Successfully blocked IP permanently");
    		}
    	}else{
    		if($request->ajax()){
    			return response()->json(['error' => "Unable to blocked IP permanently"]);
    		}else{
    			return redirect()->back()->with('error', "Unable to blocked IP permanently");
    		}
    	}
    }

    public function blocktemporary(Ips $ip, Request $request){
        $ip->is_permanent = 0;
    	if($ip->save()){
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully blocked IP temporarily"]);
    		}else{
    			return redirect()->back()->with('status', "Successfully blocked IP temporarily");
    		}
    	}else{
    		if($request->ajax()){
    			return response()->json(['error' => "Unable to blocked IP temporarily"]);
    		}else{
    			return redirect()->back()->with('error', "Unable to blocked IP temporarily");
    		}
    	}
    }

    public function ip_address_to_number($IPaddress) {
    	return bindec(decbin(ip2long($IPaddress)));
	}


    public function whiteisps()
    {
      $type = array('public'=>'DCH','private'=>'TOR','wordpress1'=>'VPN','wordpress2'=>'Proxy','wordpress3'=>'Others');
      return view('admin.firewall.whiteisps')->with('isps', Isps::get())->with('type',$type);
    }

    public function addwhiteisps(Request $request)
    {
      //$this->pp($request->all(),1);
      $isp = new Isps;
      $isp->isp = $request->get('isp');
      if($isp->save()){
          if($request->ajax()){
              return response()->json(['status' => "Successfully added Whitelisted ISP", 'isp' => $isp]);
          }else{
              return redirect()->back()->with('status', "Successfully added Whitelisted ISP");
          }
      }
      if($request->ajax()){
          return response()->json(['error' => "Unable to add Whitelisted ISP"]);
      }else{
          return redirect()->back()->with('error', "Unable to add Whitelisted ISP")->withInput();
      }
    }
}
