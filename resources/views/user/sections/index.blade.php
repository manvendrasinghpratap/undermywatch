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
												 <a  href="{{ route('user.links.createnewlink', ['section' =>$section['slug']]) }}" style="text-decoration: none;">
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
										 <div class="col-lg-4">
											 <button class="btn btn-success" type="submit">Search</button>
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
																<th>Action</th>
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
															<td>
															  <button class="btn btn-xs btn-default"><i class="fa fa-copy"></i></button>
															  <a href="{{ route('user.links.link', ['link' => $link->id]) }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
															  @if(Auth::user()->id == $link->createdby->id)
															      <a href="{{ route('user.links.linkscrape', ['link' => $link->id]) }}" class="btn btn-xs btn-secondary"><i class="fa fa-cloud-download-alt"></i></a>
															      <form action="{{ route('user.links.linkdelete', ['link' => $link->id]) }}" method="POST" style="display:inline-block;">
															          {{ csrf_field() }}
															          <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
															      </form>
															  @endif
															  <a href="{{ route('user.logs.link', ['link'=> $link->id]) }}" class="btn btn-xs btn-secondary"><i class="fa fa-eye"></i></a>
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


@section('content_')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Sections</h1>
    </div>
</div>
<div class="row">
    @include('user.components.statuses')
	<div class="col-lg-12 col-md-12">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sections
                </div>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover datatable1">
                        <thead>
                            <tr>
                                <th>Sections</th>
                                <th>Links Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($user->sections as $section)
	                            <tr>
                                    <td><a href="{{ route('user.sections.section', ['section'=> $section->slug]) }}">{{ $section->name }}</a></td>
                                    <td>@if(!empty($section->links)){{ $section->links->where('createdby_id', $user->id)->count() }}@else 0 @endif</td>
                                    <td><a href="{{ route('user.sections.section', ['section'=> $section->slug]) }}" class="btn btn-xs btn-primary"><i class="fa fa-link">&nbsp;</i></a></td>
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
