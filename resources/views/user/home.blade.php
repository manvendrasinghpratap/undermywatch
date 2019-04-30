@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
		 <!-- Page content-->
			 <div class="content-wrapper">
				 <div class="content-heading">
						<div> @if(isset($pageHeading)) {{ $pageHeading }}  @else Dashboard @endif<small data-localize="dashboard.welcome"></small></div><!-- START Language list-->
						<div class="ml-auto">
						</div><!-- END Language list-->
				 </div>
				 <div class="row">
               <div class="col-xl-4">
                  <!-- START List group-->
                  <div class="list-group mb-3">
                     <div class="list-group-item">
                        <div class="d-flex align-items-center py-3">
                           <div class="w-50 px-3">
                              <p class="m-0 lead">{{@$statisticsPassed}}</p>
                              <p class="m-0 text-sm">Clicks passed in last 7 days</p>
                           </div>
                           <div class="w-50 px-3 text-center">
                              <div data-sparkline="" data-bar-color="#444a69" data-height="60" data-bar-width="10" data-bar-spacing="6" data-chart-range-min="0" data-values="{{$blockedClick}}"></div>
                           </div>
                        </div>
                     </div>
                     <div class="list-group-item">
                        <div class="d-flex align-items-center py-3">
                           <div class="w-50 px-3">
                              <p class="m-0 lead">{{@$statisticsBlocked}}</p>
                              <p class="m-0 text-sm">Clicks blocked in last 7 days</p>
                           </div>
                           <div class="w-50 px-3 text-center">
                              <div data-sparkline="" data-type="line" data-height="60" data-width="80%" data-line-width="2" data-line-color="#7266ba" data-chart-range-min="0" data-spot-color="#888" data-min-spot-color="#7266ba" data-max-spot-color="#7266ba" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="3" data-values="{{$blockedClick}}" data-resize="true"></div>
                           </div>
                        </div>
                     </div>
                     <div class="list-group-item">
                        <div class="d-flex align-items-center py-3">
                           <div class="w-50 px-3">
                              <p class="m-0 lead">{{@$activeLinksCount}}</p>
                              <p class="m-0 text-sm">Active links in last 7 days</p>
                           </div>
                           <div class="w-50 px-3 text-center">
                              <div class="d-flex align-items-center flex-wrap justify-content-center"><a href="{{ route('user.sections.index') }}" data-toggle="tooltip" title="All Links"><em class="fa fa-link" style="color: #4d4287;font-size: 27px;"></em></a></div>
                           </div>
                        </div>
                     </div>
                  </div><!-- END List group-->
               </div>
               <div class="col-xl-8">
                  <!-- START bar chart-->
                  <div class="card" id="cardChart3">
                     <div class="card-header">
                        <div class="card-title">Clicks Report</div>
                     </div>
                     <div class="card-wrapper">
                        <div class="card-body">
                           <div class="chart-bar-stackedv2 flot-chart"></div>
                        </div>
                     </div>
                  </div><!-- END bar chart-->
               </div>
            </div>
             <!-- START Multiple List group-->
						 <?php
						 //echo '<pre>'; print_r($user->sections); echo '</pre>';
						 ?>
						 <?php if(count($user->sections)>0)  {
							 foreach($user->sections as $section){
							 ?>
            <div class="list-group mb-3"><a class="list-group-item" href="#" style="text-decoration: none;">
                  <table class="wd-wide">
                     <tbody>
                        <tr>
                           <td class="wd-xs">
                              <div class="px-2">
																	<?php	if($section['image']==''){
																		 $imagename= 'default.jpg';
																	 }elseif(file_exists('storage/'.$section['image'])){
																		 $imagename= $section['image'];
																	 }else{
																		 $imagename= 'default.jpg';
																	 }
																		?>
																		<img class="img-fluid rounded thumb64" src="{{url('storage/'.$imagename)}}" alt="" style="width: 150px;height: 80px;">

															</div>
                           </td>
                           <td>
                              <div class="px-2">
                                 <h4 class="mb-2">{{@$section['name']}}</h4><small class="text-muted">{{@$section['slug']}}</small>
                              </div>
                           </td>
                           <td class="wd-xs d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0 text-muted"><em class="icon-people mr-2 fa-lg"></em><?php $retunData = getTotalLinks($section['id'],Auth::user()->id);?> {{$retunData['totallinksCount'] }}</p>
                              </div>
                           </td>
                           <td class="wd-xs d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0 text-muted"><em class="icon-doc mr-2 fa-lg"></em>{{$retunData['totalClicks'] }}</p>
                              </div>
                           </td>
                           <td class="wd-sm">
                              <div class="px-2">
                                 <div class="progress-bar progress-xs bg-success" style="width: 80%"><span class="sr-only">80%</span></div>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </a>
						 </div>
						 <?php } } ?>
            <!-- END Multiple List group-->

			 </div>
		 </section>

@endsection

@section('scripts')
	<script>

$(function() {
        var e = {
                series: {
                    stack: !0,
                    bars: {
                        align: "center",
                        lineWidth: 0,
                        show: !0,
                        barWidth: .6,
                        fill: .9
                    }
                },
                grid: {
                    borderColor: "#eee",
                    borderWidth: 1,
                    hoverable: !0,
                    backgroundColor: "#fcfcfc"
                },
                tooltip: !0,
                tooltipOpts: {
                    content: function(label, t, n) {
                        return label + " : " + n
                    }
                },
                xaxis: {
                    tickColor: "#fcfcfc",
                    mode: "categories"
                },
                yaxis: {
                    tickColor: "#eee"
                },
                shadowSize: 0
            };
        var n = $(".chart-bar-stackedv2");
        n.length && $.plot(n, [{
            label: "Total Clicks",
            color: "#5cd560",
            data: [
                @foreach($gStats as $date => $st)
                    ["{{ date('M d', strtotime($date)) }}", {{$st['total']}}],
                @endforeach
            ]
        }, {
            label: "Passed",
            color: "#72e876",
            data: [
                @foreach($gStats as $date => $st)
                    ["{{ date('M d', strtotime($date)) }}", {{ $st['passed'] }}],
                @endforeach
            ]
        }, {
            label: "Blocked",
            color: "#94fe98",
            data: [
                @foreach($gStats as $date => $st)
                    ["{{ date('M d', strtotime($date)) }}", {{$st['blocked']}}],
                @endforeach
            ]
        }], e)
    });
</script>
@endsection
