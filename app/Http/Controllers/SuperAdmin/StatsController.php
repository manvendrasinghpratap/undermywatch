<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stats;
use Carbon\Carbon;
use App\Links;
use DB;
use Auth;
use App\User;
class StatsController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
              $reportrangeinput = $request->reportrangeinput;
              $link_id = $request->link_id;
              $is_safe = $request->is_safe;
              $from = $to = '';
              if($request->reportrangeinput !='') { $reportrangeinputArray = explode(' -- ',$request->reportrangeinput); $from = $reportrangeinputArray[0]; $to = $reportrangeinputArray[1]; }

              $noOfdaysFromToday = $this->getNoOfdaysFromToday($from);
              $noOfdaysToToday = $this->getNoOfdaysFromToday($to);
              $statsData = Stats::select('id',DB::raw('DATE(created_at) as date'),DB::raw('sum(CASE WHEN is_safe = 1 THEN 1 ELSE 0 END) AS safe'), DB::raw('count(*) as views'),'link_id')
                    ->when($request->is_safe,function($query) use ($request){
                        return $query->where('stats.is_safe', $request->is_safe);
                    } )
                    ->when($request->reportrangeinput,function($query) use ($request,$from,$to){
                         $query->whereDate('stats.created_at','>=', $from);
                         $query->whereDate('stats.created_at','<=', $to);
                    } )
                    ->when($request->link_id,function($query) use($request){
                        return $query->where('stats.link_id', $request->link_id);
                    })
                    ->groupBy('link_id')
                    ->get();
                return view('admin.stats.index')
                        ->with('is_safe',$is_safe)
                        ->with('reportrangeinput',$reportrangeinput)
                        ->with('noOfdaysFromToday',$noOfdaysFromToday)
                        ->with('noOfdaysToToday',$noOfdaysToToday)
                        ->with('link_id',$link_id)
                        ->with('data',$statsData);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function companystats(Request $request)
     {
               $reportrangeinput = $request->reportrangeinput;
               $link_id = $request->link_id;
               $is_safe = $request->is_safe;
               $from = $to = '';
               if($request->reportrangeinput !='') { $reportrangeinputArray = explode(' -- ',$request->reportrangeinput); $from = $reportrangeinputArray[0]; $to = $reportrangeinputArray[1]; }

               $noOfdaysFromToday = $this->getNoOfdaysFromToday($from);
               $noOfdaysToToday = $this->getNoOfdaysFromToday($to);
               $statsData = Stats::select('id',DB::raw('DATE(created_at) as date'),DB::raw('sum(CASE WHEN is_safe = 1 THEN 1 ELSE 0 END) AS safe'), DB::raw('count(*) as views'),'link_id')
                     ->when($request->is_safe,function($query) use ($request){
                         return $query->where('stats.is_safe', $request->is_safe);
                     } )
                     ->when($request->reportrangeinput,function($query) use ($request,$from,$to){
                          $query->whereDate('stats.created_at','>=', $from);
                          $query->whereDate('stats.created_at','<=', $to);
                     } )
                     ->when($request->link_id,function($query) use($request){
                         return $query->where('stats.link_id', $request->link_id);
                     })
                     ->whereCompany_id(Auth::user()->company_id)
                     ->groupBy('link_id')
                     ->get();
                 return view('admin.stats.index')
                         ->with('is_safe',$is_safe)
                         ->with('reportrangeinput',$reportrangeinput)
                         ->with('noOfdaysFromToday',$noOfdaysFromToday)
                         ->with('noOfdaysToToday',$noOfdaysToToday)
                         ->with('link_id',$link_id)
                         ->with('data',$statsData);
         //
     }

     public function companystatssuperadmin($company_id,Request $request)
     {
                $company_id = base64_decode($company_id);

               $reportrangeinput = $request->reportrangeinput;
               $link_id = $request->link_id;
               $is_safe = $request->is_safe;
               $from = $to = '';
               if($request->reportrangeinput !='') { $reportrangeinputArray = explode(' -- ',$request->reportrangeinput); $from = $reportrangeinputArray[0]; $to = $reportrangeinputArray[1]; }

               $noOfdaysFromToday = $this->getNoOfdaysFromToday($from);
               $noOfdaysToToday = $this->getNoOfdaysFromToday($to);
               $statsData = Stats::select('id',DB::raw('DATE(created_at) as date'),DB::raw('sum(CASE WHEN is_safe = 1 THEN 1 ELSE 0 END) AS safe'), DB::raw('count(*) as views'),'link_id')
                     ->when($request->is_safe,function($query) use ($request){
                         return $query->where('stats.is_safe', $request->is_safe);
                     } )
                     ->when($request->reportrangeinput,function($query) use ($request,$from,$to){
                          $query->whereDate('stats.created_at','>=', $from);
                          $query->whereDate('stats.created_at','<=', $to);
                     } )
                     ->when($request->link_id,function($query) use($request){
                         return $query->where('stats.link_id', $request->link_id);
                     })
                     ->whereCompany_id($company_id)
                     ->groupBy('link_id')
                     ->get();
                 return view('admin.stats.index')
                         ->with('is_safe',$is_safe)
                         ->with('reportrangeinput',$reportrangeinput)
                         ->with('noOfdaysFromToday',$noOfdaysFromToday)
                         ->with('noOfdaysToToday',$noOfdaysToToday)
                         ->with('link_id',$link_id)
                         ->with('data',$statsData);
         //
     }

public function userstatsUserId($userId,Request $request)
{
          $userId = base64_decode($userId);
          $UserDetails = User::find($userId);
          $company_id = $UserDetails->company_id;

          $reportrangeinput = $request->reportrangeinput;
          $link_id = $request->link_id;
          $is_safe = $request->is_safe;
          $from = $to = '';
          if($request->reportrangeinput !='') { $reportrangeinputArray = explode(' -- ',$request->reportrangeinput); $from = $reportrangeinputArray[0]; $to = $reportrangeinputArray[1]; }

          $noOfdaysFromToday = $this->getNoOfdaysFromToday($from);
          $noOfdaysToToday = $this->getNoOfdaysFromToday($to);
          $statsData = Stats::select('id',DB::raw('DATE(created_at) as date'),DB::raw('sum(CASE WHEN is_safe = 1 THEN 1 ELSE 0 END) AS safe'), DB::raw('count(*) as views'),'link_id')
                ->when($request->is_safe,function($query) use ($request){
                    return $query->where('stats.is_safe', $request->is_safe);
                } )
                ->when($request->reportrangeinput,function($query) use ($request,$from,$to){
                     $query->whereDate('stats.created_at','>=', $from);
                     $query->whereDate('stats.created_at','<=', $to);
                } )
                ->when($request->link_id,function($query) use($request){
                    return $query->where('stats.link_id', $request->link_id);
                })
                ->whereUser_id($userId)
                ->whereCompany_id($company_id)
                ->groupBy('link_id')
                ->get();
            return view('admin.stats.index')
                    ->with('is_safe',$is_safe)
                    ->with('reportrangeinput',$reportrangeinput)
                    ->with('noOfdaysFromToday',$noOfdaysFromToday)
                    ->with('noOfdaysToToday',$noOfdaysToToday)
                    ->with('link_id',$link_id)
                    ->with('data',$statsData);
    //
}

     public function userstatsByUserId($userId,Request $request)
     {
               $userId = base64_decode($userId);
               $UserDetails = User::find($userId);
               $company_id = $UserDetails->company_id;

               $reportrangeinput = $request->reportrangeinput;
               $link_id = $request->link_id;
               $is_safe = $request->is_safe;
               $from = $to = '';
               if($request->reportrangeinput !='') { $reportrangeinputArray = explode(' -- ',$request->reportrangeinput); $from = $reportrangeinputArray[0]; $to = $reportrangeinputArray[1]; }

               $noOfdaysFromToday = $this->getNoOfdaysFromToday($from);
               $noOfdaysToToday = $this->getNoOfdaysFromToday($to);
               $statsData = Stats::select('id',DB::raw('DATE(created_at) as date'),DB::raw('sum(CASE WHEN is_safe = 1 THEN 1 ELSE 0 END) AS safe'), DB::raw('count(*) as views'),'link_id')
                     ->when($request->is_safe,function($query) use ($request){
                         return $query->where('stats.is_safe', $request->is_safe);
                     } )
                     ->when($request->reportrangeinput,function($query) use ($request,$from,$to){
                          $query->whereDate('stats.created_at','>=', $from);
                          $query->whereDate('stats.created_at','<=', $to);
                     } )
                     ->when($request->link_id,function($query) use($request){
                         return $query->where('stats.link_id', $request->link_id);
                     })
                     ->whereUser_id($userId)
                     ->whereCompany_id($company_id)
                     ->groupBy('link_id')
                     ->get();
                 return view('admin.stats.index')
                         ->with('is_safe',$is_safe)
                         ->with('reportrangeinput',$reportrangeinput)
                         ->with('noOfdaysFromToday',$noOfdaysFromToday)
                         ->with('noOfdaysToToday',$noOfdaysToToday)
                         ->with('link_id',$link_id)
                         ->with('data',$statsData);
         //
     }

     public function userstats(Request $request)
     {
              // echo Auth::user()->id;
              // echo Auth::user()->level;
              // echo Auth::user()->company_id;
               $reportrangeinput = $request->reportrangeinput;
               $link_id = $request->link_id;
               $is_safe = $request->is_safe;
               $from = $to = '';
               if($request->reportrangeinput !='') { $reportrangeinputArray = explode(' -- ',$request->reportrangeinput); $from = $reportrangeinputArray[0]; $to = $reportrangeinputArray[1]; }

               $noOfdaysFromToday = $this->getNoOfdaysFromToday($from);
               $noOfdaysToToday = $this->getNoOfdaysFromToday($to);
               $statsData = Stats::select('id',DB::raw('DATE(created_at) as date'),DB::raw('sum(CASE WHEN is_safe = 1 THEN 1 ELSE 0 END) AS safe'), DB::raw('count(*) as views'),'link_id')
                     ->when($request->is_safe,function($query) use ($request){
                         return $query->where('stats.is_safe', $request->is_safe);
                     } )
                     ->when($request->reportrangeinput,function($query) use ($request,$from,$to){
                          $query->whereDate('stats.created_at','>=', $from);
                          $query->whereDate('stats.created_at','<=', $to);
                     } )
                     ->when($request->link_id,function($query) use($request){
                         return $query->where('stats.link_id', $request->link_id);
                     })
                     ->whereUser_id(Auth::user()->id)
                     ->whereCompany_id(Auth::user()->company_id)
                     ->groupBy('link_id')
                     ->get();
                 return view('admin.stats.index')
                         ->with('is_safe',$is_safe)
                         ->with('reportrangeinput',$reportrangeinput)
                         ->with('noOfdaysFromToday',$noOfdaysFromToday)
                         ->with('noOfdaysToToday',$noOfdaysToToday)
                         ->with('link_id',$link_id)
                         ->with('data',$statsData);
         //
     }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getNoOfdaysFromToday($date){
        $created = new Carbon($date);
        $now = Carbon::now();
        if($created>$now){
        return  '-'.$created->diff($now)->days-1;
        }else{
        return  $created->diff($now)->days;
        }

    }
}
