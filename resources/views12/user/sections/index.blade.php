@extends('layouts.admin')
@section('title')
	Sections
@endsection

@section('content')
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

@section('scripts')
    <script src="{{asset("assets/vendor/datatables/js/jquery.dataTables.min.js")}}"></script>
    <script src="{{asset("assets/vendor/datatables-plugins/dataTables.bootstrap.min.js")}}"></script>
    <script src="{{asset("assets/vendor/datatables-responsive/dataTables.responsive.js")}}"></script>
    <script>
    $(document).ready(function() {
        $('.datatable1').DataTable({
            responsive: true
        });
    });
    </script>
@endsection
