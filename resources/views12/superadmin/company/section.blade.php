@extends('layouts.admin')
@section('title')
    Edit Section
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Section</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        @include('admin.components.statuses')
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Section
                </div>
                <div class="panel-body">
                    <form action="{{ route('superadmin.sections.section', ['section' => $section->slug]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <input class="form-control" type="text" name="name" placeholder="Name" value="{{ $section->name }}" required>
                            <br>
                            <input class="form-control" type="text" name="slug" placeholder="Slug" value="{{ $section->slug }}">
                            <br>

                            <div class="col-lg-9 col-sm-9 col-xs-12">
                                <div class="row">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Campaign Name" value="1" name="setting[7][enable]" 
                                            @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','campaign_name')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Campaign Name</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[7][field]" value="campaign_name">
                                            <input type="text" class="form-control" name="setting[7][field_title]" placeholder="Title" value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','campaign_name')->first()) 
                                            && !empty($section->settings->where('field','campaign_name')->first()->field_title)){{ $section->settings->where('field','campaign_name')->first()->field_title }}@endif">
                                            <input type="text" class="form-control" name="setting[7][default]" placeholder="Default Value"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','campaign_name')->first()) 
                                            && !empty($section->settings->where('field','campaign_name')->first()->default)){{ $section->settings->where('field','campaign_name')->first()->default }}@endif">
                                            <input type="text" class="form-control" name="setting[7][field_description]" placeholder="Field description"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','campaign_name')->first()) 
                                            && !empty($section->settings->where('field','campaign_name')->first()->field_description)){{ $section->settings->where('field','campaign_name')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[7][is_hidden]"     @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','campaign_name')->first()) 
                                            && !empty($section->settings->where('field','campaign_name')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[7][show_in_table]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','campaign_name')->first()) 
                                            && !empty($section->settings->where('field','campaign_name')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Custom Slug" value="1" name="setting[0][enable]" checked disabled>
                                            <input type="hidden" name="setting[0][enable]" value="1">
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Domain</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[0][field]" value="domain">
                                            <input type="text" class="form-control" name="setting[0][field_title]" placeholder="Title" value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','domain')->first()) 
                                            && !empty($section->settings->where('field','domain')->first()->field_title)){{ $section->settings->where('field','domain')->first()->field_title }}@endif">
                                            <input type="text" class="form-control" name="setting[0][field_description]" placeholder="Field description"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','domain')->first()) 
                                            && !empty($section->settings->where('field','domain')->first()->field_description)){{ $section->settings->where('field','domain')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[0][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','domain')->first()) 
                                            && !empty($section->settings->where('field','domain')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[0][show_in_table]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','domain')->first()) 
                                            && !empty($section->settings->where('field','domain')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Custom Slug" value="1" name="setting[1][enable]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','slug')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Slug</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[1][field]" value="slug">
                                            <input type="text" class="form-control" name="setting[1][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','slug')->first()) 
                                            && !empty($section->settings->where('field','slug')->first()->field_title)){{ $section->settings->where('field','slug')->first()->field_title }}@endif">
                                            <!-- <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Allow Empty Slug" value="1" name="setting[1][default]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','slug')->first()) 
                                            && !empty($section->settings->where('field','slug')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Allow Empty Slug</label>
                                                </span>
                                            </div> -->
                                            <input type="text" class="form-control" name="setting[1][field_description]" placeholder="Field description"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','slug')->first()) 
                                            && !empty($section->settings->where('field','slug')->first()->field_description)){{ $section->settings->where('field','slug')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[1][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','slug')->first()) 
                                            && !empty($section->settings->where('field','slug')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[1][show_in_table]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','slug')->first()) 
                                            && !empty($section->settings->where('field','slug')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Main URL" value="1" name="setting[2][enable]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','main_url')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Main URL</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[2][field]" value="main_url">
                                            <input type="text" class="form-control" name="setting[2][field_title]" placeholder="Title"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','main_url')->first()) 
                                            && !empty($section->settings->where('field','main_url')->first()->field_title)){{ $section->settings->where('field','main_url')->first()->field_title }}@endif">
                                            <input type="text" class="form-control" name="setting[2][default]" placeholder="Default Value"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','main_url')->first()) 
                                            && !empty($section->settings->where('field','main_url')->first()->default)){{ $section->settings->where('field','main_url')->first()->default }}@endif">
                                            <input type="text" class="form-control" name="setting[2][field_description]" placeholder="Field description"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','main_url')->first()) 
                                            && !empty($section->settings->where('field','main_url')->first()->field_description)){{ $section->settings->where('field','main_url')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[2][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','main_url')->first()) 
                                            && !empty($section->settings->where('field','main_url')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[2][show_in_table]" 
                                                   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','main_url')->first()) 
                                            && !empty($section->settings->where('field','main_url')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Main URL" value="1" name="setting[3][enable]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','money_url')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Money URL</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[3][field]" value="money_url">
                                            <input type="text" class="form-control" name="setting[3][field_title]" placeholder="Title"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','money_url')->first()) 
                                            && !empty($section->settings->where('field','money_url')->first()->field_title)){{ $section->settings->where('field','money_url')->first()->field_title }}@endif">
                                            <input type="text" class="form-control" name="setting[3][default]" placeholder="Default Value"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','money_url')->first()) 
                                            && !empty($section->settings->where('field','money_url')->first()->default)){{ $section->settings->where('field','money_url')->first()->default }}@endif">
                                            <input type="text" class="form-control" name="setting[3][field_description]" placeholder="Field description"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','money_url')->first()) 
                                            && !empty($section->settings->where('field','money_url')->first()->field_description)){{ $section->settings->where('field','money_url')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[3][is_hidden]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','money_url')->first()) 
                                            && !empty($section->settings->where('field','money_url')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[3][show_in_table]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','money_url')->first()) 
                                            && !empty($section->settings->where('field','money_url')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Landing Page" value="1" name="setting[8][enable]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','landing_page')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Landing Page</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[8][field]" value="landing_page">
                                            <input type="text" class="form-control" name="setting[8][field_title]" placeholder="Title"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','landing_page')->first()) 
                                            && !empty($section->settings->where('field','landing_page')->first()->field_title)){{ $section->settings->where('field','landing_page')->first()->field_title }}@endif">
                                            <input type="text" class="form-control" name="setting[8][field_description]" placeholder="Field description"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','landing_page')->first()) 
                                            && !empty($section->settings->where('field','landing_page')->first()->field_description)){{ $section->settings->where('field','landing_page')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[8][is_hidden]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','landing_page')->first()) 
                                            && !empty($section->settings->where('field','landing_page')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[8][show_in_table]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','landing_page')->first()) 
                                            && !empty($section->settings->where('field','landing_page')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Click Limit" value="1" name="setting[4][enable]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','click_limit')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Click Limit</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[4][field]" value="click_limit">
                                            <input type="text" class="form-control" name="setting[4][field_title]" placeholder="Title"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','click_limit')->first()) 
                                            && !empty($section->settings->where('field','click_limit')->first()->field_title)){{ $section->settings->where('field','click_limit')->first()->field_title }}@endif">
                                            <input type="text" class="form-control" name="setting[4][default]" placeholder="Default Value"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','click_limit')->first()) 
                                            && !empty($section->settings->where('field','click_limit')->first()->default)){{ $section->settings->where('field','click_limit')->first()->default }}@endif">

                                            <input type="text" class="form-control" name="setting[4][field_description]" placeholder="Field description"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','click_limit')->first()) 
                                            && !empty($section->settings->where('field','click_limit')->first()->field_description)){{ $section->settings->where('field','click_limit')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[4][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','click_limit')->first()) 
                                            && !empty($section->settings->where('field','click_limit')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[4][show_in_table]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','click_limit')->first()) 
                                            && !empty($section->settings->where('field','click_limit')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Custom Script" value="1" name="setting[5][enable]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','custom_script')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Custom Script</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[5][field]" value="custom_script">
                                            <input type="text" class="form-control" name="setting[5][field_title]" placeholder="Title"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','custom_script')->first()) 
                                            && !empty($section->settings->where('field','custom_script')->first()->field_title)){{ $section->settings->where('field','custom_script')->first()->field_title }}@endif">
                                            <textarea class="form-control" name="setting[5][default]" placeholder="Default Value">@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','custom_script')->first()) 
                                            && !empty($section->settings->where('field','custom_script')->first()->default)){{ $section->settings->where('field','custom_script')->first()->default }}@endif</textarea>
                                            <input type="text" class="form-control" name="setting[5][field_description]" placeholder="Field description"     value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','custom_script')->first()) 
                                            && !empty($section->settings->where('field','custom_script')->first()->field_description)){{ $section->settings->where('field','custom_script')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[5][is_hidden]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','custom_script')->first()) 
                                            && !empty($section->settings->where('field','custom_script')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[5][show_in_table]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','custom_script')->first()) 
                                            && !empty($section->settings->where('field','custom_script')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable User-Agent Filter" value="1" name="setting[6][enable]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">User-Agent Filter</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[6][field]" value="user_agent_filter">
                                            <input type="text" class="form-control" name="setting[6][field_title]" placeholder="Title"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()->field_title)){{ $section->settings->where('field','user_agent_filter')->first()->field_title }}@endif">
                                            <input type="text" class="form-control" name="setting[6][default]" placeholder="Default Value (Seperated by '|')"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()->default)){{ $section->settings->where('field','user_agent_filter')->first()->default }}@endif">
                                            <input type="text" class="form-control" name="setting[6][field_description]" placeholder="Field description"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()->field_description)){{ $section->settings->where('field','user_agent_filter')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[6][is_hidden]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[6][show_in_table]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()) 
                                            && !empty($section->settings->where('field','user_agent_filter')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Proxified Main Link Option" value="1" name="setting[9][enable]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_original')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Proxified Original</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[9][field]" value="proxified_original">
                                            <input type="text" class="form-control" name="setting[9][field_title]" placeholder="Title"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_original')->first()) 
                                            && !empty($section->settings->where('field','proxified_original')->first()->field_title)){{ $section->settings->where('field','proxified_original')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[9][default]" value="1"
                                                    @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_original')->first()) 
                                            && !empty($section->settings->where('field','proxified_original')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[9][field_description]" placeholder="Field description"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_original')->first()) 
                                            && !empty($section->settings->where('field','proxified_original')->first()->field_description)){{ $section->settings->where('field','proxified_original')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[9][is_hidden]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_original')->first()) 
                                            && !empty($section->settings->where('field','proxified_original')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[9][show_in_table]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_original')->first()) 
                                            && !empty($section->settings->where('field','proxified_original')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Proxified Money URL" value="1" name="setting[10][enable]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_money')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Proxified Money Link</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[10][field]" value="proxified_money">
                                            <input type="text" class="form-control" name="setting[10][field_title]" placeholder="Title"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_money')->first()) 
                                            && !empty($section->settings->where('field','proxified_money')->first()->field_title)){{ $section->settings->where('field','proxified_money')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[10][default]" value="1"
                                                    @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_money')->first()) 
                                            && !empty($section->settings->where('field','proxified_money')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[10][field_description]" placeholder="Field description"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_money')->first()) 
                                            && !empty($section->settings->where('field','proxified_money')->first()->field_description)){{ $section->settings->where('field','proxified_money')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[10][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_money')->first()) 
                                            && !empty($section->settings->where('field','proxified_money')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[10][show_in_table]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','proxified_money')->first()) 
                                            && !empty($section->settings->where('field','proxified_money')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Firewall" value="1" name="setting[11][enable]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Enable Firewall</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[11][field]" value="enable_firewall">
                                            <input type="text" class="form-control" name="setting[11][field_title]" placeholder="Title"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()->field_title)){{ $section->settings->where('field','enable_firewall')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[11][default]" value="1" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[11][field_description]" placeholder="Field description"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()->field_description)){{ $section->settings->where('field','enable_firewall')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[11][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[11][show_in_table]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()) 
                                            && !empty($section->settings->where('field','enable_firewall')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Mobile Only" value="1" name="setting[12][enable]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','mobile_only')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Mobile Only</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[12][field]" value="mobile_only">
                                            <input type="text" class="form-control" name="setting[12][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','mobile_only')->first()) 
                                            && !empty($section->settings->where('field','mobile_only')->first()->field_title)){{ $section->settings->where('field','mobile_only')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[12][default]" value="1"
                                                     @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','mobile_only')->first()) 
                                            && !empty($section->settings->where('field','mobile_only')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[12][field_description]" placeholder="Field description"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','mobile_only')->first()) 
                                            && !empty($section->settings->where('field','mobile_only')->first()->field_description)){{ $section->settings->where('field','mobile_only')->first()->field_description }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[12][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','mobile_only')->first()) 
                                            && !empty($section->settings->where('field','mobile_only')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[12][show_in_table]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','mobile_only')->first()) 
                                            && !empty($section->settings->where('field','mobile_only')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Blocked/Unblocked Countries" value="1" name="setting[13][enable]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','countries_list')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Blocked/Unblocked Countries</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[13][field]" value="countries_list">
                                            <input type="text" class="form-control" name="setting[13][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','countries_list')->first()) 
                                            && !empty($section->settings->where('field','countries_list')->first()->field_title)){{ $section->settings->where('field','countries_list')->first()->field_title }}@endif">
                                            
                                            <input type="text" class="form-control" name="setting[13][default]" placeholder="Default Value" value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','countries_list')->first()) 
                                            && !empty($section->settings->where('field','countries_list')->first()->default)){{ $section->settings->where('field','countries_list')->first()->default }}@endif">
                                               
                                            <input type="text" class="form-control" name="setting[13][field_description]" placeholder="Field description"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','countries_list')->first()) 
                                            && !empty($section->settings->where('field','countries_list')->first()->field_description)){{ $section->settings->where('field','countries_list')->first()->field_description }}@endif">
                                               
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[13][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','countries_list')->first()) 
                                            && !empty($section->settings->where('field','countries_list')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Value</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[13][show_in_table]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','countries_list')->first()) 
                                            && !empty($section->settings->where('field','countries_list')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Countried Block/Unblock" value="1" name="setting[14][enable]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Is Countries Blocked</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[14][field]" value="is_countries_blocked">
                                            <input type="text" class="form-control" name="setting[14][field_title]" placeholder="Title"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()->field_title)){{ $section->settings->where('field','is_countries_blocked')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[14][default]" value="1"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[14][field_description]" placeholder="Field description"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()->field_description)){{ $section->settings->where('field','is_countries_blocked')->first()->field_description }}@endif">
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[14][is_hidden]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[14][show_in_table]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()) 
                                            && !empty($section->settings->where('field','is_countries_blocked')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Check Referral Existance" value="1" name="setting[15][enable]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','referral_exists')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Check Referral Existance</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[15][field]" value="referral_exists">
                                            <input type="text" class="form-control" name="setting[15][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','referral_exists')->first()) 
                                            && !empty($section->settings->where('field','referral_exists')->first()->field_title)){{ $section->settings->where('field','referral_exists')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[15][default]" value="1"
                                                     @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','referral_exists')->first()) 
                                            && !empty($section->settings->where('field','referral_exists')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[15][field_description]" placeholder="Field description"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','referral_exists')->first()) 
                                            && !empty($section->settings->where('field','referral_exists')->first()->field_description)){{ $section->settings->where('field','referral_exists')->first()->field_description }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[15][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','referral_exists')->first()) 
                                            && !empty($section->settings->where('field','referral_exists')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[15][show_in_table]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','referral_exists')->first()) 
                                            && !empty($section->settings->where('field','referral_exists')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Filter Referral Existance" value="1" name="setting[16][enable]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','filter_referral')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Filter Referral Existance</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[16][field]" value="filter_referral">
                                            <input type="text" class="form-control" name="setting[16][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','filter_referral')->first()) 
                                            && !empty($section->settings->where('field','filter_referral')->first()->field_title)){{ $section->settings->where('field','filter_referral')->first()->field_title }}@endif">
                                            
                                            <input type="text" class="form-control" name="setting[16][default]" placeholder="Default Value" value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','filter_referral')->first()) 
                                            && !empty($section->settings->where('field','filter_referral')->first()->default)){{ $section->settings->where('field','filter_referral')->first()->default }}@endif">
                                               
                                            <input type="text" class="form-control" name="setting[16][field_description]" placeholder="Field description"   value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','filter_referral')->first()) 
                                            && !empty($section->settings->where('field','filter_referral')->first()->field_description)){{ $section->settings->where('field','filter_referral')->first()->field_description }}@endif">
                                               
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[16][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','filter_referral')->first()) 
                                            && !empty($section->settings->where('field','filter_referral')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Value</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[16][show_in_table]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','filter_referral')->first()) 
                                            && !empty($section->settings->where('field','filter_referral')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Check Gclid" value="1" name="setting[17][enable]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Check Gclid</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[17][field]" value="gclid_exists">
                                            <input type="text" class="form-control" name="setting[17][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()->field_title)){{ $section->settings->where('field','gclid_exists')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[17][default]" value="1"
                                                     @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[17][field_description]" placeholder="Field description"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()->field_description)){{ $section->settings->where('field','gclid_exists')->first()->field_description }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[17][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[17][show_in_table]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add new field unique gclid dated : 20 feb 2019 begin -->

                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[21][enable]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Unique Check Gclid</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[21][field]" value="unique_gclid_exists">
                                            <input type="text" class="form-control" name="setting[21][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()->field_title)){{ $section->settings->where('field','unique_gclid_exists')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[21][default]" value="1"
                                                     @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[21][field_description]" placeholder="Field description"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()->field_description)){{ $section->settings->where('field','unique_gclid_exists')->first()->field_description }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[21][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[21][show_in_table]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()) 
                                            && !empty($section->settings->where('field','gclid_exists')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- -->

                                     <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Log Link" value="1" name="setting[18][enable]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','loglink')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Log Link</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[18][field]" value="loglink">
                                            <input type="text" class="form-control" name="setting[18][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','loglink')->first()) 
                                            && !empty($section->settings->where('field','loglink')->first()->field_title)){{ $section->settings->where('field','loglink')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[18][default]" value="1"
                                                     @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','loglink')->first()) 
                                            && !empty($section->settings->where('field','loglink')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[18][field_description]" placeholder="Field description"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','loglink')->first()) 
                                            && !empty($section->settings->where('field','loglink')->first()->field_description)){{ $section->settings->where('field','loglink')->first()->field_description }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[18][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','loglink')->first()) 
                                            && !empty($section->settings->where('field','loglink')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[18][show_in_table]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','loglink')->first()) 
                                            && !empty($section->settings->where('field','loglink')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Spoof Referral" value="1" name="setting[19][enable]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Spoof Referral</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[19][field]" value="spoof_referral">
                                            <input type="text" class="form-control" name="setting[19][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()->field_title)){{ $section->settings->where('field','spoof_referral')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[19][default]" value="1"
                                                     @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[19][field_description]" placeholder="Field description"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()->field_description)){{ $section->settings->where('field','spoof_referral')->first()->field_description }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[19][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[19][show_in_table]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()) 
                                            && !empty($section->settings->where('field','spoof_referral')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" aria-label="Spoof Referral &amp; Timezone Check" value="1" name="setting[20][enable]" @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','timezone_check')->first()) 
                                            )
                                                checked 
                                            @endif>
                                        </span>
                                        <span class="input-group-addon">
                                            <label style="margin:0;">Spoof Referral &amp; Timezone Check</label>
                                        </span>
                                        <div>
                                            <input type="hidden" name="setting[20][field]" value="timezone_check">
                                            <input type="text" class="form-control" name="setting[20][field_title]" placeholder="Title"  value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','timezone_check')->first()) 
                                            && !empty($section->settings->where('field','timezone_check')->first()->field_title)){{ $section->settings->where('field','timezone_check')->first()->field_title }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="setting[20][default]" value="1"
                                                     @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','timezone_check')->first()) 
                                            && !empty($section->settings->where('field','timezone_check')->first()->default)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Default Value</label>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="setting[20][field_description]" placeholder="Field description"    value="@if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','timezone_check')->first()) 
                                            && !empty($section->settings->where('field','timezone_check')->first()->field_description)){{ $section->settings->where('field','timezone_check')->first()->field_description }}@endif">
                                            
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[20][is_hidden]"  @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','timezone_check')->first()) 
                                            && !empty($section->settings->where('field','timezone_check')->first()->is_hidden)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Hidden Field</label>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="input-group-addon">
                                                    <input type="checkbox" aria-label="Visible in Table" value="1" name="setting[20][show_in_table]"   @if(
                                            !empty($section->settings) 
                                            && !empty($section->settings->where('field','timezone_check')->first()) 
                                            && !empty($section->settings->where('field','timezone_check')->first()->show_in_table)
                                            )
                                                checked 
                                            @endif>
                                                </span>
                                                <span class="input-group-addon">
                                                    <label style="margin:0;">Table View</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-xs-12">
                                <button class="btn btn-success" type="submit">Save</button>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap3-wysi/bootstrap3-wysihtml5.min.css') }}">
<script type="text/javascript" src="{{ asset('assets/vendor/bootstrap3-wysi/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script type="text/javascript">
    $('#wysi').wysihtml5();
</script>
@endsection
