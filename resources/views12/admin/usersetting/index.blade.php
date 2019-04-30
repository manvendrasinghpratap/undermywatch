@extends('layouts.newadmintemplate')
@section('content')
	<!-- Main section Start-->
	@php
	$active = 'profile';
	if(Request::get('tab')=='profile')
	$active = 'profile';
	elseif(Request::get('tab')=='account')
	$active = 'account';
	elseif(Request::get('tab')=='shield')
	$active = 'shield';
	elseif(Request::get('tab')=='campaign')
	$active = 'campaign';
	else
	$active = 'profile';
@endphp


	<section class="section-container">
		 <!-- Page content-->
		 <div class="content-wrapper">
				<div class="content-heading">
					 <div>{{@$userDetails['name']}} - {{@$userDetails->companyname->company_name}} <small>{{@$userDetails['email']}}</small></div><!-- START Language list-->


					 <div class="ml-auto" style="margin-top: -21px;">
								<a href="dashboard" class="btn btn-default btn-lg dash-navi"><em class="fa fa-rainbow success-circle"></em> Dashboard</a>
								<a href="{{route('admin.usersetting.campaign',['userId' => base64_encode(@$userDetails['id'])])}}" class="btn btn-default btn-lg dash-navi"><em class="fa fa-mask success-circle"></em> Campaigns</a>
								<a href="{{ route('admin.stats.userstatsUserId', ['userId' => base64_encode(@$userDetails['id'])]) }}?tab=shield" class="btn btn-default btn-lg dash-navi"><em class="fa fa-chart-line success-circle"></em> Reports</a>
								<a href="{{ route('admin.usersetting.user', ['user'=>base64_encode(@$userDetails['id'])]) }}?tab=profile" class="btn btn-default btn-lg dash-navi"><em class="fa fa-user-ninja success-circle"></em> Profile</a>
					 </div>
				</div>

				<div class="row">
							<div class="col-lg-3">
								 <div class="card b">
										<div class="card-header bg-gray-lighter text-bold">Personal Settings</div>
										<div class="list-group"><a class="list-group-item list-group-item-action @if($active=='profile') active @endif" href="#tabSetting1" data-toggle="tab">Profile</a><a class="list-group-item list-group-item-action @if($active=='account') active @endif" href="#tabSetting2" data-toggle="tab">Account</a><a class="list-group-item list-group-item-action @if($active=='shield') active @endif" href="#tabSetting5" data-toggle="tab">Shields</a>
										<a class="list-group-item list-group-item-action @if($active=='campaign') active @endif" href="#tabSetting6" data-toggle="tab" style="display:none">Campagin</a></div>
								 </div>
							</div>
							<div class="col-lg-9">
								 <div class="tab-content p-0 b0">
										<div class="tab-pane @if($active=='profile') active @endif" id="tabSetting1">
											 <div class="card b">
													<div class="card-header bg-gray-lighter text-bold">Profile</div>
													<div class="card-body">
															 <form  action="{{ route('admin.usersetting.updateprofile', ['userId' => base64_encode(@$userDetails['id'])]) }}" method="POST" enctype="multipart/form-data">
				                        {{ csrf_field() }}
																<input type="hidden" name="userid" value="{{@$userDetails['id']}}" id="userid"/>
																<div class="form-group"><label>Name</label>
																	<input class="form-control" placeholder="Enter Name" type="text" name="name_" value="{{@$userDetails['name']}}" required autocomplete="false" >
																</div>
																<div class="form-group"><label>Email</label>
																	<input class="form-control" placeholder="Enter Email" type="email" name="email" value="{{@$userDetails['email']}}" required autocomplete="false" />
																</div>
																<div class="form-group"><label>Skype</label>
																	<input class="form-control" placeholder="Enter Skype ID" type="text" name="skypeid" value="{{@$userDetails['skypeid']}}" required autocomplete="false" />
																</div>
																<div class="form-group"><label>Company</label>
																	 <select class="form-control" id="select2-3"  name="company_id">
																		 @if(count($companies)>0)
																			 	@foreach($companies as $key=>$value)
																					<option @if(@$userDetails['company_id']== $key) selected = true @endif  value="{{$key}}">{{$value}}</option>
																				@endforeach
																		 @endif
																	 </select>
																</div>
																<div class="form-group"><label>Notes</label>
																	<input class="form-control" placeholder="Enter Notes" type="text" name = "notes" value = "{{@$userDetails['notes']}}" autocomplete="false" />
																</div>
															 <button class="btn btn-success" type="submit">Update Profile</button>
														 </form>
													</div>
											 </div>
										</div>
										<div class="tab-pane @if($active=='account') active @endif " id="tabSetting2">
											 <div class="card b">
													<div class="card-header bg-gray-lighter text-bold ">Account</div>
													<div class="card-body">
														 <form action="#" id="validatedForm">
																<div class="form-group"><label>New password</label><input class="form-control" type="password" id="newpassword" autocomplete = "false"  value="" ></div>
																<div class="form-group"><label>Confirm new password</label><input class="form-control" type="password" id="password_confirm" value="" ></div>
																<button class="btn btn-success upatepassword" type="button">Reset Password</button>
														 </form>
													</div>
											 </div>
											 <div class="card b">
													<div class="card-header bg-grey text-bold">User Status</div>
													<div class="card-body bt">
														 <div class="row">
														 <div class="form-group col-lg-6">
																	 <div class="input-group">
														 <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
														 <input class="form-control" type="text" value="{{@$userType}}" disabled id="usertypedata">
														 <div class="input-group-append">
															 <input type="hidden" value="{{base64_encode(@$userDetails['level'])}}" id= "userlevel">
															 <button data-change-type = "{{$userchangeType}}" data-text-to-change = "{{@$texttochange}}" data-current-level = "{{@$currentLevel}}" class="btn btn-labeled btn-success" type="button" id="changelevel" ><span class="btn-label"><i class="fa fa-random"></i></span>{{@$switchToUserType}}</button></div>
													</div>
														 </div>
															<div class="form-group col-lg-6">
																	 <div class="input-group">
														 <div class="input-group-prepend"><span class="input-group-text">Status</span></div><input class="form-control" type="text" value="{{@$userStatus}}" disabled>
														 <div class="input-group-append"><button data-user-status = "{{@$userDetails['status']}}" id="changestatus" class="btn btn-labeled @if($userDetails['status']=='1') btn-danger @else btn-success @endif" type="button"><span class="btn-label"><i class="fa fa-dizzy"></i></span>{{$enableOrDisableUser}}</button></div>
													</div>
														 </div>
													</div>
													</div>
											 </div>
										</div>

										<div class="tab-pane @if($active=='shield') active @endif" id="tabSetting5">
											 <div class="card b">
													<div class="card-header bg-gray-lighter text-bold">Active Shields</div>
													<div class="card-body">
														 <div class="list-group">
															 @php $sectionsArray = array(); @endphp
															 @foreach($userDetails->sections as $section)
																 @php $sectionsArray[] = $section['id'] @endphp
																<div class="list-group-item d-flex align-items-center">
																	<?php	if($section['image']==''){
																			$imagename= 'default.jpg';
																		}elseif(file_exists('storage/'.$section['image'])){
																			$imagename= $section['image'];
																		}else{
																			$imagename= 'default.jpg';
																		}
																		 ?>
																		 <img class="shield-img" src="{{url('storage/'.$imagename)}}" alt="" style="width: 150px;height: 80px;">
																	 <div style="padding-left: 150px;">
																			<p class="text-bold mb-0">{{@$section['name']}}</p><small>{{@$section['slug']}}</small>
																	 </div>
																	 <div class="ml-auto">
																		 <form method="post" action="{{route('admin.usersetting.deleteUserSection',[base64_encode($section['id']),'&?tab=shield'])}}">
																			 <input type="hidden" name="user_id" value="{{base64_encode($userDetails['id'])}}">
																			 <input type="hidden" name="section_id" value="{{base64_encode($section['id'])}}">
																			 <button class="btn btn-warning" type="submit"> <strong>Revoke</strong> </button>
																	 </form>
																	 </div>
																</div>
															@endforeach
														 </div>
													</div>
											 </div>
											 <?php //echo '<pre>'; print_r($sectionsArray); echo '</pre>';	 ?>
											 <div class="card b">
													<div class="card-header bg-grey text-bold">InActive Shields</div>
													<div class="card-body">
														<div class="list-group">
															@foreach($companySection->sections as $section)
																@php if (!in_array($section['id'], $sectionsArray)) {  @endphp
																@php $imagename= 'default.jpg'; @endphp
																<?php	if($section['image']==''){
																		$imagename= 'default.jpg';
																	}elseif(file_exists('storage/'.$section['image'])){
																		$imagename= $section['image'];
																	}else{
																		$imagename= 'default.jpg';
																	}
																	 ?>
                                    <div class="list-group-item d-flex align-items-center">
																			<img class="shield-img" src="{{url('storage/'.$imagename)}}" alt="" style="width: 150px;height: 80px;">
																			<div style="padding-left: 150px;">
																				 <p class="text-bold mb-0">{{@$section['name']}}</p><small>{{@$section['slug']}}</small>
																			</div>
                                       <div class="ml-auto">
																				 <form method="post" action="{{route('admin.usersetting.assignUserSection',[base64_encode($section['id']),'&?tab=shield'])}}">
																					 <input type="hidden" name="user_id" value="{{base64_encode($userDetails['id'])}}"/>
																					 <input type="hidden" name="section_id" value="{{base64_encode($section['id'])}}"/>
																					 <button class="btn btn-success" type="submit"><strong>Grant</strong></button>
																			 </form>
																			 </div>
                                    </div>
																@php	} @endphp
																		@endforeach
                                 </div>
													</div>
											 </div>
										</div>

								 </div>
							</div>

					 </div>
		 </div>
	</section>
	<!-- Main section End-->
@endsection

@section('scripts')
    <script>
    $(document).ready(function() {
        $('.datatable1').DataTable({
            responsive: true
        });
				$.ajaxSetup({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
						}
				});
				$('#changestatus').click(function(){
					var deleteMsg = 'User status change Successfully';
					var targetModel = 'modal-alert';
					var userStatus =  $(this).attr("data-user-status");
					$('#'+targetModel).find('.modal-body').html(deleteMsg).end().modal('show');
					var userid 								= 	$('#userid').val();
					$.ajax({
						url: '{{route("changeuserstatus")}}',
						data: {"userStatus": userStatus,"userid":userid},
						type: 'POST',
						success: function(result)
							 {
								 var obj = JSON.parse(result);
								if(result==0)
									var deleteMsg = 'Oops something went wrong!!';
							 }
					});
				});
				$('#changelevel').click(function(){
					var deleteMsg = 'User Level change Successfully';
					var targetModel = 'modal-alert';
					var texttochange =  $(this).attr("data-text-to-change");
					var usertypedata =  $(this).attr("data-change-type");
					var currentlevel =  $(this).attr("data-current-level");
					$('#'+targetModel).find('.modal-body').html(deleteMsg).end().modal('show');
					var userid 								= 	$('#userid').val();
					$.ajax({
						url: '{{route("changeuserlevel")}}',
						data: {"currentlevel": currentlevel,"userid":userid},
						type: 'POST',
						success: function(result)
							 {
								 var obj = JSON.parse(result);
								if(result==0)
									var deleteMsg = 'Oops something went wrong!!';
							 }
					});
					$('#usertypedata').val(usertypedata);
					$("#changelevel").html("<span class='btn-label'><i class='fa fa-random'></i></span> "+texttochange);
				});
				//data-siteurl ="{{ url('/')}}"
				$('.upatepassword').click(function(){
					var targetModel 					= 	'modal-alert';
					var deleteMsg				 			= 	'Password Changed Successfully ';
					var password 							= 	$('#newpassword').val();
					var password_confirm 			= 	$('#password_confirm').val();
					var userid 								= 	$('#userid').val();
					if((password !='') && (password_confirm !='')){
						if(password == password_confirm){
							$.ajax({
								url: '{{route("changepassword")}}',
								data: {"password": password,"userid":userid},
								type: 'POST',
								success: function(result)
							     {
										if(result==0)
											var deleteMsg = 'Oops something went wrong!!';
							     }
							});
						}else {
							var deleteMsg = 'Password mismatch. !!';
						}
					}
					else{
							var deleteMsg = 'Password should not be blank. !!';
					}
					$('#'+targetModel).find('.modal-body').html(deleteMsg).end().modal('show');
					$('#newpassword').val('');
					$('#password_confirm').val('');
				});
    });

    </script>
@endsection
