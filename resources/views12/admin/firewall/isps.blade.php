@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
	         <!-- Page content-->
	         <div class="content-wrapper">
	            <div class="content-heading">
	               <div>Blacklisted ISP's</div>
	               <!-- START Language list-->
	            </div>
	            <div class="row">
	               <div class="col-lg-12">
	               <div class="card card-default">
	               <div class="card-body">
	                  <form method="POST" action="{{ route('admin.firewall.addisp') }}">
											{{ csrf_field() }}
	                     <div class="form-row align-items-center">
	                        <div class="col-lg-4"><label class="sr-only" for="inlineFormInput">Enter ISP Name</label>
														<input class="form-control" id="isp" name="isp" type="text" placeholder="Enter ISP Name" style="height: 2.375rem;"></div>
	                        <div class="col-lg-4">
	                           <select class="form-control" id="select2-1">
															  @foreach($type as $key=> $value)
																		<option value="{{$key}}">{{$value}}</option>
																@endforeach
	                            </select>
	                        </div>
	                        <div class="col-lg-4">
	                           <button class="btn btn-success" type="submit" style="width: 100%;">Block ISP</button>
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
	                        <table class="table table-striped my-4 w-100" id="datatable2">
	                           <thead>
	                              <tr>
	                                 <th>ISP Name</th>
	                                 <th>Reason</th>
	                                 <th>Actions</th>
	                                 <th>Blocked By</th>
	                                 <th>Date Blacklisted</th>
	                              </tr>
	                           </thead>
	                           <tbody>
			                         	@foreach($isps as $isp)
			 	                            <tr id="hide_{{ $isp->id }}">
																			<td>{{ $isp->isp }}</td>
																			<td>{{ $isp->isp }}</td>
																			<td>
																				<form action="{{ route('admin.firewall.deleteisp', ['isp' => $isp->id]) }}" method="POST" style="display:inline-block;">
																					{{ csrf_field() }}
																					<button type="button" class="btn btn-danger btn-xs confirmDelete" data-siteurl ="{{ url('/')}}" data-tablename="blacklist_isps" data-record-id="{{ $isp->id }}" data-record-title="Are you sure you want to delete this Blacklisted ISP ?" data-toggle="modal" data-target="modal-confirm" data-succuss="Blacklisted ISP deleted successfully" data-deletetype="permanent"><i class="fa fa-trash"></i></button>
																				</form>
																			</td>
																			<td>{{ $isp->isp }}</td>
																			<td>{{ @$isp->created_at->format(config('app.dateformat')) }}</td>
			 	                            </tr>
			                             @endforeach
																			<tr>
																					<td>Google.com</td>
																					<td>DCH</td>
																					<td>
																					<button type="submit" title="Unblock ISP" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
																					</td>
																					<td>Sahil Garg</td>
																					<td>24 April, 2019</td>
																			</tr>

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
@section('title')
	Blocked ISPs
@endsection

@section('content_')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Blocked ISPs</h1>
    </div>
</div>
<div class="row">
    @include('admin.components.statuses')
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Blocked ISPs
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="row">
                            <form method="POST" action="{{ route('admin.firewall.addisp') }}">
                                {{ csrf_field() }}
                                <div class="col-sm-9">
                                    <input class="form-control" name="isp" placeholder="ISP">
                                </div>
                                <div class="col-sm-3">
                                    <input type="submit" class="btn btn-danger" value="Block ISP">
                                </div>
                            </form>
                        </div>
                        <hr>
                        <br>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover datatable1">
                        <thead>
                            <tr>
                                <th>ISP</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($isps as $isp)
	                            <tr>
	                                <td>{{ $isp->isp }}</td>
	                                <td>
	                                	<form action="{{ route('admin.firewall.deleteisp', ['isp' => $isp->id]) }}" method="POST" style="display:inline-block;">
	                                		{{ csrf_field() }}
	                                		<button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
	                                	</form>
                                	</td>
	                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: center;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
    $(document).ready(function() {
        $('.datatable1').DataTable({
            responsive: true
        });
    });
    </script>
@endsection
