@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
	         <!-- Page content-->
	         <div class="content-wrapper">
	            <div class="content-heading">
	               <div>Blacklisted IP's</div>
	               <div class="ml-auto" style="margin-top: -21px;">
	                    <a href="{{route('admin.firewall.ips',['type=permanent'])}}" class="btn btn-default btn-lg dash-navi"><em class="fa fa-lock success-circle"></em> Permanent</a>
	                    <a href="{{route('admin.firewall.ips',['type=temporary'])}}" class="btn btn-default btn-lg dash-navi"><em class="fa fa-unlock success-circle"></em> Temporary</a>
	                    <a href="{{route('admin.firewall.ips',['type=review'])}}" class="btn btn-default btn-lg dash-navi"><em class="fa fa-search-dollar success-circle"></em> Review</a>

	               </div>
	               <!-- START Language list-->
	            </div>
	            <div class="row">
	               <div class="col-lg-12">
	               <div class="card card-default">
	               <div class="card-body">
									 <form method="POST" action="{{ route('admin.firewall.addips') }}">
											{{ csrf_field() }}
	                     <div class="form-row align-items-center">
	                        <div class="col-lg-3"><label class="sr-only" for="inlineFormInput">Enter IP Range Start</label>
														<input class="form-control" name="start" value="{{ old('start') }}" placeholder="Enter IP Start Range" required=true>
													</div>
	                        <div class="col-lg-3"><label class="sr-only" for="inlineFormInput">Enter IP Range End</label>
														<input class="form-control" name="end" placeholder="Enter IP End Range" required=true>
													</div>
	                         <div class="col-lg-3"><label class="sr-only" for="inlineFormInput">Any Notes</label>
														 <input class="form-control" id="inlineFormInput" name="note"  id = "note" type="text" placeholder="Enter Notes" style="height: 2.375rem;"></div>
	                        <div class="col-lg-3">
	                           <button class="btn btn-success" type="submit" style="width: 100%;">Block IP Range</button>
	                        </div>
	                     </div>
	                  </form>
	               </div>
	            </div>
	         </div>
	               <div class="col-lg-12">
	                  <div class="panel panel-default">
	                     <div class="panel-body">
	                        <div class="table-responsive">
	                        <table width="100%" class="table table-striped table-bordered table-hover datatable1">
	                           <thead>
	                              <tr>
	                                 <th>IP Range Start</th>
	                                 <th>IP Range End</th>
	                                 <th>IP Size</th>
	                                 <th>ISP Name</th>
	                                 <th>Clicks</th>
	                                 <th>Campaigns</th>
	                                 <th>Block Type</th>
	                                 <th>Action</th>
	                                 <th>Date Blacklisted</th>
	                              </tr>
	                           </thead>
	                           <tbody>
															 @foreach($ips as $ip)
		 	                            <tr>
																			<td>{{ long2ip((int)$ip->start) }}</td>
																			<td>{{ long2ip((int)$ip->end) }}</td>
																			<td>{{ $ip->end - $ip->start }}</td>
																			<td>{{ $ip->isp }}</td>
																			<td>{{ $ip->repetition }}</td>
																			<td>{{ $ip->campaigns->count() }}</td>
																			<td>
																				@if(($type=='permanent') || (($ip->is_permanent==1) && ($ip->isreviewed==1)))
																					Permanent
																				@elseif(($type=='temporary') || (($ip->is_permanent==0) && ($ip->isreviewed==1)))
																					Temporary
																				@elseif(($type=='review') || ($ip->isreviewed==0))
																					Review
																				@endif
																			</td>
																			<td>
																				<form action="{{ route('admin.firewall.blockrange', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
																						{{ csrf_field() }}
																						<button type="submit" title="Block Range" class="btn btn-purple btn-xs"><i class="fa fa-ring"></i></button>
																				</form>
																				<form action="{{ route('admin.firewall.blockisp', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
																						{{ csrf_field() }}
																						<button type="submit" title="Block ISP" class="btn btn-warning btn-xs"><i class="fa fa-network-wired"></i></button>
																				</form>

																			 @if(($type=='permanent') || (($ip->is_permanent==1) && ($ip->Isreviewed==1)))
																					 <form action="{{ route('admin.firewall.blocktemporary', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
																							 {{ csrf_field() }}
																							 <button type="submit" title="Block Temporary" class="btn btn-xs btn-primary"><i class="fa fa-lock-open"></i></button>
																					 </form>
																			 @elseif(($type=='temporary') || (($ip->is_permanent==0) && ($ip->Isreviewed==1)))
																					 <form action="{{ route('admin.firewall.blockpermanent', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
																							 {{ csrf_field() }}
																							 <button type="submit" title="Block Permanent" class="btn btn-inverse btn-xs"><i class="fa fa-lock"></i></button>
																					 </form>
																				@elseif(($type=='review') || ($ip->Isreviewed==0))
																					<form action="{{ route('admin.firewall.blocktemporary', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
																							{{ csrf_field() }}
																							<button type="submit" title="Block Temporary" class="btn btn-xs btn-primary"><i class="fa fa-lock-open"></i></button>
																					</form>
																					<form action="{{ route('admin.firewall.blockpermanent', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
																							{{ csrf_field() }}
																							<button type="submit" title="Block Permanent" class="btn btn-inverse btn-xs"><i class="fa fa-lock"></i></button>
																					</form>
																			 @endif
																			 <form action="{{ route('admin.firewall.deleteip', ['ip' => $ip->id]) }}" method="POST" style="display:inline-block;">
																					 {{ csrf_field() }}
																					 <button type="submit" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
																			 </form>
		 	                              </td>
																		<td>{{ @$ip->created_at->format(config('app.dateformat')) }}</td>
		 	                            </tr>
		                             @endforeach
	                           </tbody>
	                        </table>
	                        </div>
	                     </div>
	                  </div>
	               </div>
	            </div>
	         </div>
	      </section>
@endsection

@section('scripts')
    <script>
    $(document).ready(function() {
        $('.datatable1').DataTable({
            responsive: true,
						order: [[8, 'desc']],
        });
    });
    </script>
@endsection
