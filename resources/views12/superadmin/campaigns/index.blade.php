@extends('layouts.newadmintemplate')
@section('content')

	<section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>Campaigns</div><!-- START Language list-->
					 <div class="ml-auto">
							<button id="swal-demo1" class="btn btn-labeled btn-success" type="button"><span class="btn-label"><i class="fa fa-plus"></i></span>Add New Campaign</button>
							<div class="card" id="user-shields" style="display: none;">
										<div class="row align-items-center">
											 <div class="col-xl-12">
											 <div class="list-group">
												 @if(count($sections)>0)
													 @foreach ($sections as $section)
												 <!-- section listing start -->
												 <a  href="{{ route('admin.links.createlink', ['section' =>$section['slug']]) }}" style="text-decoration: none;">
													<div class="list-group-item shield-list">
														 <div class="d-flex align-items-center">
																<div class="col-md-4">
																	 <p class="m-0 lead">
																		 <?php	if($section['image']==''){
	 																			$imagename= 'default.jpg';
	 																		}elseif(file_exists('storage/'.$section['image'])){
	 																			$imagename= $section['image'];
	 																		}else{
	 																			$imagename= 'default.jpg';
	 																		}
	 																		 ?>
	 																		 <img class="shield-img" src="{{url('storage/'.$imagename)}}" alt="" style="width: 150px;height: 80px;">																			 
																	 </p>
																</div>
																<div class="col-md-6 text-left">
																	 {{$section['name']}}
																</div>
																<div class="col-md-2 ">
																	 <p class="m-0 lead"><button type="submit" title="Create Campaign" class="btn btn-oval btn-success btn-xs"><i class="fa fa-atom"></i></button></p>
																</div>
														 </div>
													</div>
												</a>
													<!-- section ends -->
													@endforeach
												@endif
											 </div>
										</div>
										</div>
							</div>
								 </div><!-- END Language list-->
				</div>
				<div class="row">
					<div class="col-lg-12">
					<div class="card card-default">
					<div class="card-body">
						<form method="get" >
								<div class="form-row align-items-center">
									<div class="col-lg-4">
										 <select class="form-control" id="select2-3" name="section_id">
											 <option value="">--Select All Section--</option>
											 @if(count($sections)>0)
												 @foreach($sections as $section)
													 <option @if($querySectionString==base64_encode($section['id'])) selected=true @endif value="{{base64_encode($section['id'])}}">{{$section['name']}}</option>
												 @endforeach
											 @endif
												</select>
									</div>
									 <div class="col-lg-4" style="display:none;">
											<select class="form-control" id="select2-4" name="company_id">
														<option></option>
														<option value="public">High</option>
														<option value="private">Medium</option>
														<option value="wordpress">Low</option>
														<option value="wordpress">Rare</option>
												 </select>
									 </div>
										 <div class="col-lg-4">
											 <button class="btn btn-success" type="submit">Search</button>
											<a class="btn btn-success whitetext"  href="{{route('superadmin.campaign.index')}}" type="reset">Reset</a>
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
																<th>Campaign Name</th>
																<th>Section</th>
																<th style="text-align:right;">Status</th>
																<th>Link</th>
																<th class="sort-numeric">Clicks</th>
																<th>Creator(Company)</th>
																<th>Actions</th>
																<th>Last Edited</th>
																<th>Notes</th>
														 </tr>
													</thead>
											<tbody>
												@foreach($links as $link)
													<tr>
														<td>{{@$link->name}}</td>
														<td>{{@$link->section->name}}</td>
														<td><center><i class="fa fa-circle success-circle"></i></center></td>
														<td>@if(!empty($link->domain)) https://{{ $link->domain->domain }}/{{ $link->slug }} @endif</td>
														<td>{{@$link->clicks}}</td>
														<td>{{@$link->createdby->name}} ( {{@$link->createdby->companyname->company_name}} )</td>
														<td>
																<a href="{{ route('admin.links.link', ['link' => $link->id]) }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
																<button type="submit" title="Delete Campaign" class="btn btn-secondary btn-xs"><i class="fa fa-play"></i></button>
																<a href="{{ route('admin.logs.link', ['link'=> $link->id]) }}" title="Edit Campaign" class="btn btn-xs btn-secondary"><i class="fa fa-eye"></i></a>
																<form action="{{ route('admin.links.linkdelete', ['link' => $link->id]) }}" method="POST" style="display:inline-block;">
																		{{ csrf_field() }}
																		<button type="submit" title="Delete Campaign" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
																</form>
														</td>
														<td>{{$link->created_at->format(config('app.dateformat'))}}</td>
														<td><p title="{{ $link->notes}}">{{ str_limit($link->notes, 10,'...') }}</p></td>
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
