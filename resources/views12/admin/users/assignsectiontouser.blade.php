@extends('layouts.admin')
@section('title')
	Edit {{ $user->name }}'s Settings
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit {{ $user->name }}'s Settings</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
        @include('admin.components.statuses')
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit {{ $user->name }}'s Settings
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.assignsection.users.section', ['user' => $user->id]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <label>Assigned Sections</label>
                            <br>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <select class="form-control" name="sections[]" id="sections" multiple>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" @if(!empty($user->sections) && !empty($user->sections->where('id', $section->id)->first())) selected @endif>{{ $section->name }}</option>
                                    @endforeach
                                </select>
                                <span class="pull-right">
                                    <a onclick="select_all();">Select All</a> | <a onclick="deselect_all();">Deselect All</a>
                                  </span>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <br>
                                <span class="pull-right">
                                    <button class="btn btn-success" type="submit">Update</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  function select_all(){
    $("#sections option").prop("selected", "selected");
  }
  function deselect_all(){
    $("#sections option:selected").removeAttr("selected");
  }
   $(document).ready(function() {
        $(document).on('click',".onoffswitch-checkbox", function() {
            console.log($(this).attr("data-user"));
            var a_active = this.checked;
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
            }
            var b_active = this.checked;
            if(a_active == b_active){
                var user = $(this).attr("data-user");
                var active = 0;
                if(b_active){
                    active = 1;
                }
                data = $(this.form).serialize();
                // data.push({level: active});
                $.ajax({ // create an AJAX call...
                    data: data, // get the form data
                    type: $(this.form).attr('method'), // GET or POST
                    url: $(this.form).attr('action'), // the file to call
                    success: function(json) {
                        if(json.error){
                            html = '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Warning! </strong>'+ json.error +'</span>';
                            $('.statuses').prepend(html);
                        }else if(json.status){
                            html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Success! </strong>'+ json.status +'</span>';
                            $('.statuses .alert').remove();
                            $('.statuses').prepend(html);
                        }
                        // setTimeout(
                        //     function(){
                        //         $('.statuses .alert').remove();
                        //     }, 2000);
                    },
                    error: function(error){
                        $('.statuses .alert').remove();
                    }
                });

            }
        });
    });
</script>

@endsection
