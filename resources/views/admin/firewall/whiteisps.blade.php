@extends('layouts.newadmintemplate')
@section('content')
	<section class="section-container">
	         <!-- Page content-->
	         <div class="content-wrapper">
	            <div class="content-heading">
	               <div>Whitelisted ISP's</div>
	               <!-- START Language list-->
	            </div>
	            <div class="row">
	               <div class="col-lg-12">
	               <div class="card card-default">
	               <div class="card-body">
									 <form method="POST" action="{{ route('admin.firewall.addwhiteisps') }}">
											 {{ csrf_field() }}
	                     <div class="form-row align-items-center">
	                        <div class="col-lg-3"><label class="sr-only" for="inlineFormInput">Enter ISP Name</label>
														<input class="form-control" name="isp"  id="isp" type="text" placeholder="Enter ISP Name" style="height: 2.375rem;">
													</div>
	                        <div class="col-lg-3">
	                           <select class="form-control" id="select2-4" name="popularity">
															 @foreach ($popularity as $key => $value)
																 <option value="{{$key}}">{{$value}}</option>
															 @endforeach
	                              </select>
	                        </div>
	                         <div class="col-lg-3"><label class="sr-only" for="inlineFormInput">Any Notes</label><input class="form-control" name="notes" id="notes" type="text" placeholder="Enter Notes" style="height: 2.375rem;"></div>
	                        <div class="col-lg-3">
	                           <button class="btn btn-success" type="submit" style="width: 100%;">Whitelist ISP</button>
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
	                                 <th>Popularity</th>
	                                 <th>Actions</th>
	                                 <th>Blocked By</th>
	                                 <th>Date Whitelisted</th>
	                                 <th>Notes</th>
	                              </tr>
	                           </thead>
	                           <tbody>
															 @foreach($isps as $isp)
																	 <tr id="hide_{{ $isp->id }}">
																		 <td>{{ $isp->isp }}</td>
																		 <td>{{ @$isp->popularity }}</td>
																		 <td>
																			 <form action="{{ route('admin.firewall.deleteisp', ['isp' => $isp->id]) }}" method="POST" style="display:inline-block;">
																				 {{ csrf_field() }}
																				 <button type="button" class="btn btn-danger btn-xs confirmDelete" data-siteurl ="{{ url('/')}}" data-tablename="blacklist_isps" data-record-id="{{ $isp->id }}" data-record-title="Are you sure you want to delete this Blacklisted ISP ?" data-toggle="modal" data-target="modal-confirm" data-succuss="Blacklisted ISP deleted successfully" data-deletetype="permanent"><i class="fa fa-trash"></i></button>
																			 </form>
																		 </td>
																		 <td>{{ @$isp->addedby->name }}</td>
																		 <td>{{ @$isp->created_at->format(config('app.dateformat')) }}</td>
																		 <td><p title="{{ $isp->notes}}">{{ str_limit($isp->notes, 10,'...') }}</p></td>
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
            responsive: true
        });
    });
    </script>
@endsection
