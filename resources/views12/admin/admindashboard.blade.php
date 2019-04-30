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
                              <p class="m-0 lead">1204</p>
                              <p class="m-0 text-sm">Clicks passed in last 7 days</p>
                           </div>
                           <div class="w-50 px-3 text-center">
                              <div data-sparkline="" data-bar-color="#444a69" data-height="60" data-bar-width="10" data-bar-spacing="6" data-chart-range-min="0" data-values="3,6,7,8,4,5"></div>
                           </div>
                        </div>
                     </div>
                     <div class="list-group-item">
                        <div class="d-flex align-items-center py-3">
                           <div class="w-50 px-3">
                              <p class="m-0 lead"> 223</p>
                              <p class="m-0 text-sm">Clicks blocked in last 7 days</p>
                           </div>
                           <div class="w-50 px-3 text-center">
                              <div data-sparkline="" data-type="line" data-height="60" data-width="80%" data-line-width="2" data-line-color="#7266ba" data-chart-range-min="0" data-spot-color="#888" data-min-spot-color="#7266ba" data-max-spot-color="#7266ba" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="3" data-values="7,3,4,7,5,9,14,7,20,9,6,4" data-resize="true"></div>
                           </div>
                        </div>
                     </div>
                     <div class="list-group-item">
                        <div class="d-flex align-items-center py-3">
                           <div class="w-50 px-3">
                              <p class="m-0 lead">67</p>
                              <p class="m-0 text-sm">Active links in last 7 days</p>
                           </div>
                           <div class="w-50 px-3 text-center">
                              <div class="d-flex align-items-center flex-wrap justify-content-center"><a href="#" data-toggle="tooltip" title="All Links"><em class="fa fa-link" style="color: #4d4287;font-size: 27px;"></em></a></div>
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
            <div class="unwrap my-3">
               <!-- START chart-->
               <div class="card" id="cardChart9">
                  <div class="card-header">
                     <!-- START button group-->
                     <div class="card-title">Overall progress</div>
                  </div>
                  <div class="card-wrapper">
                     <div class="card-body">
                        <div class="chart-splinev2 flot-chart"></div>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-3 col-6 text-center">
                              <p>Projects</p>
                              <div class="h1">25</div>
                           </div>
                           <div class="col-md-3 col-6 text-center">
                              <p>Teammates</p>
                              <div class="h1">85</div>
                           </div>
                           <div class="col-md-3 col-6 text-center">
                              <p>Hours</p>
                              <div class="h1">380</div>
                           </div>
                           <div class="col-md-3 col-6 text-center">
                              <p>Budget</p>
                              <div class="h1 text-truncate">$ 10,000.00</div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div><!-- END chart-->
            </div><!-- START radial charts-->
             <!-- START Multiple List group-->
            <div class="list-group mb-3"><a class="list-group-item" href="#">
                  <table class="wd-wide">
                     <tbody>
                        <tr>
                           <td class="wd-xs">
                              <div class="px-2"><img class="img-fluid rounded thumb64" src="img/dummy.png" alt=""></div>
                           </td>
                           <td>
                              <div class="px-2">
                                 <h4 class="mb-2">Project A</h4><small class="text-muted">Vestibulum ante ipsum primis in faucibus orci</small>
                              </div>
                           </td>
                           <td class="wd-sm d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0">Last change</p><small class="text-muted">4 weeks ago</small>
                              </div>
                           </td>
                           <td class="wd-xs d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0 text-muted"><em class="icon-people mr-2 fa-lg"></em>26</p>
                              </div>
                           </td>
                           <td class="wd-xs d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0 text-muted"><em class="icon-doc mr-2 fa-lg"></em>3500</p>
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
               </a></div>
            <div class="list-group mb-3"><a class="list-group-item" href="#">
                  <table class="wd-wide">
                     <tbody>
                        <tr>
                           <td class="wd-xs">
                              <div class="px-2"><img class="img-fluid rounded thumb64" src="img/dummy.png" alt=""></div>
                           </td>
                           <td>
                              <div class="px-2">
                                 <h4 class="mb-2">Project X</h4><small class="text-muted">Vestibulum ante ipsum primis in faucibus orci</small>
                              </div>
                           </td>
                           <td class="wd-sm d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0">Last change</p><small class="text-muted">Today at 06:23 am</small>
                              </div>
                           </td>
                           <td class="wd-xs d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0 text-muted"><em class="icon-people mr-2 fa-lg"></em>3</p>
                              </div>
                           </td>
                           <td class="wd-xs d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0 text-muted"><em class="icon-doc mr-2 fa-lg"></em>150</p>
                              </div>
                           </td>
                           <td class="wd-sm">
                              <div class="px-2">
                                 <div class="progress-bar progress-xs bg-purple" style="width: 50%"><span class="sr-only">50%</span></div>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </a></div>
            <div class="list-group mb-3"><a class="list-group-item" href="#">
                  <table class="wd-wide">
                     <tbody>
                        <tr>
                           <td class="wd-xs">
                              <div class="px-2"><img class="img-fluid rounded thumb64" src="img/dummy.png" alt=""></div>
                           </td>
                           <td>
                              <div class="px-2">
                                 <h4 class="mb-2">Project Z</h4><small class="text-muted">Vestibulum ante ipsum primis in faucibus orci</small>
                              </div>
                           </td>
                           <td class="wd-sm d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0">Last change</p><small class="text-muted">Yesterday at 10:20 pm</small>
                              </div>
                           </td>
                           <td class="wd-xs d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0 text-muted"><em class="icon-people mr-2 fa-lg"></em>15</p>
                              </div>
                           </td>
                           <td class="wd-xs d-none d-lg-table-cell">
                              <div class="px-2">
                                 <p class="m-0 text-muted"><em class="icon-doc mr-2 fa-lg"></em>480</p>
                              </div>
                           </td>
                           <td class="wd-sm">
                              <div class="px-2">
                                 <div class="progress-bar progress-xs bg-green" style="width: 20%"><span class="sr-only">20%</span></div>
                              </div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </a><!-- END dashboard main content-->
            </div><!-- END Multiple List group-->

			 </div>
		 </section>

@endsection

@section('scripts')
@endsection
