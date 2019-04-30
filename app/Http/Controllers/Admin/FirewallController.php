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
        $reason = array('DCH'=>'DCH','TOR'=>'TOR','VPN'=>'VPN','Proxy'=>'Proxy','Others'=>'Others');
        return view('admin.firewall.isps')->with('isps', Isps::where('isblocked',1)->get())->with('reason',$reason);
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
        $isp->reason = $request->get('reason');
        $isp->notes = $request->get('notes');
        $isp->isblocked = 1;
        $isp->isreviewed = 1;
        $isp->addedby_id = auth::user()->id;
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

    public function ips(Request $request){
      $type = $request->query('type');
      if($type=='permanent')
        $data = Ips::whereIs_permanent('1')->whereIsreviewed('1')->get();
      elseif($type=='temporary')
        $data = Ips::whereIs_permanent('0')->whereIsreviewed('1')->get();
      elseif($type=='review')
        $data = Ips::whereIsreviewed('0')->get();
      else
        $data = Ips::get();


        return view('admin.firewall.ips')->with('ips', $data)->with('type',$type);
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
        $ip->Isreviewed = 1;
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
    /*Block Range function start */
    public function blockrange(Ips $ip, Request $request){

      $start = floor(($ip->start)/256)*256;
      $end = ceil(($start+1)/256)*256 - 1;

      $ip->start = $start;
      $ip->end = $end;
      $ip->is_permanent = 1;
      $ip->Isreviewed = 1;
    	if($ip->save()){
    		if($request->ajax()){
    			return response()->json(['status' => "Successfully blocked IP permanently"]);
    		}else{
    			return redirect()->back()->with('status', "Successfully blocked IP range permanently");
    		}
    	}else{
    		if($request->ajax()){
    			return response()->json(['error' => "Unable to blocked IP permanently"]);
    		}else{
    			return redirect()->back()->with('error', "Unable to blocked IP permanently");
    		}
    	}
    }
    /*Block Range function End */
    /*Block Isp function start */
    public function blockisp(Ips $ip, Request $request){
      $ispsDetails = Isps::whereIsp($ip->isp)->first();
      $id = $ispsDetails['id'];
      if(($id !='') && ($ip->isp !='')){
        $data['notes']        = 'manually Blocked';
        $data['reason']       = 'Others';
        $data['isblocked']    = 1;
        $data['isreviewed']   = 1;
        Isps::where('id',  $id)->update($data);
        return redirect()->back()->with('status', "Successfully blocked IP permanently");
      }
      return redirect()->back()->with('error', "Unable to blocked IP permanently");
    }
    /*Block Isp function Ends */


    public function blocktemporary(Ips $ip, Request $request){
      $ip->is_permanent = 0;
      $ip->Isreviewed = 1;
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
      $popularity = array('high'=>'High','medium'=>'Medium','low'=>'Low','rare'=>'Rare');
      return view('admin.firewall.whiteisps')->with('isps', Isps::where('isblocked',0)->get())->with('popularity',$popularity);
    }

    public function addwhiteisps(Request $request)
    {
      //$this->pp($request->all(),1);
      $isp = new Isps;
      $isp->isp = $request->get('isp');
      $isp->popularity = $request->get('popularity');
      $isp->notes = $request->get('notes');
      $isp->isblocked = 0;
      $isp->isreviewed = 1;
      $isp->addedby_id = auth::user()->id;
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
