@extends('layouts.newadmintemplate')
@section('content')
	<style>
	.daterangepicker .ranges ul{
		width: 691px !important;
	}
	</style>
	<section class="section-container">
	         <!-- Page content-->
	         <div class="content-wrapper">
	            <div class="content-heading">
	               <div>Statistics</div>
	               <!-- START Language list-->
	            </div>
	            <div class="row">
								<div class="col-lg-12">
										<div class="card card-default">
												<div class="card-body">
														<form method="get">
																<div class="form-row align-items-center">
																			<div class="col-lg-6">
																					<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
																					<i class="fa fa-calendar"></i>&nbsp;
																					<input type = "hidden" id='reportrangeinput' name="reportrangeinput" autocomplete="off" style="width:90%;border:none;"/>
																					<span></span><i class="fa fa-caret-down" style="padding-left: 430px;"></i>
																					</div>
																			</div>
																			<div class="col-lg-3">
																					<input type="submit" class="btn btn-success" value="Search" style="width: 25%;">
																					<input style="display:none;" type="reset" class="btn btn-info reset" value="Reset" style="width: 25%;">
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
																				<th>Name</th>
				                                <th>link</th>
																				<th>Blocked</th>
																				<th>Passed</th>
				                                <th>Click Count</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                        @if(count($data)>0)
				                        @foreach($data as $innerData)
					                            <tr>
																					<td>{{ @$innerData->link->name}}</td>
																					<td>@if(!empty(@$innerData->link->domain)) https://{{ @$innerData->link->domain->domain}}/{{@$innerData->link->slug }} @endif</td>
																					<td>{{ @$innerData->safe}}</td>
																					<td>{{ @$innerData->views-@$innerData->safe}} </td>
																					<td>{{ @$innerData->views }}</td>
					                            </tr>
				                            @endforeach
				                        @else
				                                <tr>
				                                    <td colspan="5">No Data Found</td>
				                                </tr>
				                        @endif
				                        </tbody>
				                        <tbody>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">
$(function() {

    var start = moment().subtract({{ $noOfdaysFromToday }}, 'days');
    var end = moment().subtract({{ $noOfdaysToToday }}, 'days');
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //$('#reportrangeinput').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#reportrangeinput').val(start.format('YYYY-MM-DD') + ' -- ' + end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    $(".reset" ).click(function() {
     window.location = "{{route('admin.stats.index')}}";
    });
});

</script>
<script>
$(document).ready(function() {
		$('.datatable1').DataTable({
				responsive: true,
				select: true
		});
});
</script>
@endsection
