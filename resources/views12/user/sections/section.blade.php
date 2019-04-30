@extends('layouts.admin')
@section('title')
    {{ $section->name }}'s Links
@endsection

@section('content')
<style type="text/css">
    .cbox_block {
      display: block;
      position: relative;
      /*padding-left: 35px;*/
      /*margin-bottom: 12px;*/
      cursor: pointer;
      font-size: 12px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    /* Hide the browser's default checkbox */
    .cbox_block input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
    }

    /* Create a custom checkbox */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 18px;
      width: 18px;
      background-color: #aaa;
    }

    /* On mouse-over, add a grey background color */
    .cbox_block:hover input ~ .checkmark {
      background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .cbox_block input:checked ~ .checkmark {
      background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the checkmark when checked */
    .cbox_block input:checked ~ .checkmark:after {
      display: block;
    }

    /* Style the checkmark/indicator */
    .cbox_block .checkmark:after {
        left: 6px;
        top: 1px;
        width: 7px;
        height: 14px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ $section->name }}'s Links</h1>
    </div>
</div>
<div class="row">
    @include('user.components.statuses')
    <div class="col-lg-12 col-md-12">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $section->name }}'s Links
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="row">
                            <form method="POST" action="{{ route('user.links.createlink', ['section' => $section->slug]) }}" class="AjaxForm">
                                {{ csrf_field() }}
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: #337ab7;color:white;">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" style="display:block; text-decoration:none;" href="#addlink">Add Link</a>
                                            </h4>
                                        </div>
                                        <div id="addlink" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'campaign_name')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'campaign_name')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'campaign_name')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <input type="text" class="form-control" name="campaign_name" value="{{ $section->settings->where('field', 'campaign_name')->first()->default }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'domain')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'domain')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'domain')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <select type="text" class="domains" name="domain">
                                                                @foreach($domains as $domain)
                                                                    <option value="{{ $domain->id }}">{{ $domain->domain }} @if(!empty($domain->note)) &nbsp;&nbsp;({{ $domain->note }}) @endif</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'slug')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'slug')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'slug')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <input type="text" class="form-control" name="slug" value="{{ $section->settings->where('field', 'slug')->first()->default }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'main_url')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'main_url')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'main_url')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <input type="text" class="form-control" name="main_url" value="{{ $section->settings->where('field', 'main_url')->first()->default }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'proxified_original')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'proxified_original')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'proxified_original')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                              <input type="hidden" name="proxified_original" value="0">
                                                              <input type="checkbox" value="1" name="proxified_original" @if($section->settings->where('field', 'proxified_original')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'money_url')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'money_url')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'money_url')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <input type="text" class="form-control" name="money_url" value="{{ $section->settings->where('field', 'money_url')->first()->default }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'proxified_money')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'proxified_money')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'proxified_money')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                                <input type="hidden" name="proxified_money" value="0">
                                                              <input type="checkbox" value="1" name="proxified_money" @if($section->settings->where('field', 'proxified_money')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'landing_page')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'landing_page')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'landing_page')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <select type="text" class="form-control" name="landing_page">
                                                                @foreach($landingpages as $lp)
                                                                    <option value="{{ $lp }}">{{ $lp }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'click_limit')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'click_limit')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'click_limit')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <input type="number" class="form-control" name="click_limit" value="{{ $section->settings->where('field', 'click_limit')->first()->default }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'countries_list')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'countries_list')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'countries_list')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <input type="text" class="form-control" name="countries_list" value="{{ $section->settings->where('field', 'countries_list')->first()->default }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'is_countries_blocked')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'is_countries_blocked')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'is_countries_blocked')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                                <input type="hidden" name="is_countries_blocked" value="0">
                                                              <input type="checkbox" value="1" name="is_countries_blocked" @if($section->settings->where('field', 'is_countries_blocked')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'enable_firewall')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'enable_firewall')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'enable_firewall')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                                <input type="hidden" name="enable_firewall" value="0">
                                                              <input type="checkbox" value="1" name="enable_firewall" @if($section->settings->where('field', 'enable_firewall')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'mobile_only')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'mobile_only')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'mobile_only')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                                <input type="hidden" name="mobile_only" value="0">
                                                              <input type="checkbox" value="1" name="mobile_only" @if($section->settings->where('field', 'mobile_only')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'custom_script')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'custom_script')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'custom_script')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <textarea class="form-control" name="custom_script" rows="4">{{ $section->settings->where('field', 'custom_script')->first()->default }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'user_agent_filter')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'user_agent_filter')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'user_agent_filter')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <input type="text" class="form-control" name="user_agent_filter" value="{{ $section->settings->where('field', 'user_agent_filter')->first()->default }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'gclid_exists')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'gclid_exists')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'gclid_exists')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                                <input type="hidden" name="gclid_exists" value="0">
                                                              <input type="checkbox" value="1" name="gclid_exists" @if($section->settings->where('field', 'gclid_exists')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif
                                                <!------ Add unique gcid column on 20 feb 2019 begin ---->

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'unique_gclid_exists')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'unique_gclid_exists')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'unique_gclid_exists')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                                <input type="hidden" name="unique_gclid_exists" value="0">
                                                              <input type="checkbox" value="1" name="unique_gclid_exists" @if($section->settings->where('field', 'unique_gclid_exists')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif

                                                <!------ Add unique gcid column on 20 feb 2019 End ---->
                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'spoof_referral')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'spoof_referral')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'spoof_referral')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                                <input type="hidden" name="spoof_referral" value="0">
                                                              <input type="checkbox" value="1" name="spoof_referral" @if($section->settings->where('field', 'spoof_referral')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'timezone_check')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'timezone_check')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'timezone_check')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                                <input type="hidden" name="timezone_check" value="0">
                                                              <input type="checkbox" value="1" name="timezone_check" @if($section->settings->where('field', 'timezone_check')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'referral_exists')->first()))
                                                <div class="col-sm-4 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'referral_exists')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'referral_exists')->first()->field_title }}</label>
                                                        </span>
                                                        <span class="input-group-addon">
                                                            <label class="cbox_block">
                                                                <input type="hidden" name="referral_exists" value="0">
                                                              <input type="checkbox" value="1" name="referral_exists" @if($section->settings->where('field', 'referral_exists')->first()->default) checked @endif>&nbsp;
                                                              <span class="checkmark"></span>
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif

                                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'filter_referral')->first()))
                                                <div class="col-sm-12 row">
                                                    <div class="form-group input-group" style="@if($section->settings->where('field', 'filter_referral')->first()->is_hidden) display: none; @endif">
                                                        <span class="input-group-addon">
                                                            <label style="margin:0;">{{ $section->settings->where('field', 'filter_referral')->first()->field_title }}</label>
                                                        </span>
                                                        <div>
                                                            <input type="text" class="form-control" name="filter_referral" value="{{ $section->settings->where('field', 'filter_referral')->first()->default }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                            </div>
                                            <div class="panel-footer">
                                                <input type="submit" class="btn btn-success" value="Save Link">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="pull-right">
                            @if(!Request::get("all", false) ?? false)<a href="{{ route('user.sections.section', ['section' => $section->slug, 'all' => 1]) }}" class="btn btn-primary">Show All</a> @else <a href="{{ route('user.sections.section', ['section' => $section->slug ]) }}" class="btn btn-primary">Show Mine</a> @endif
                        </div>
                        <br>
                        <br>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover datatable1">
                        <thead>
                            <tr>

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'campaign_name')->first()) && $section->settings->where('field', 'campaign_name')->first()->show_in_table)<th>{{ $section->settings->where('field', 'campaign_name')->first()->field_title }}</th>@endif

                                <th>Sharing Link</th>

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'main_url')->first()) && $section->settings->where('field', 'main_url')->first()->show_in_table)<th>{{ $section->settings->where('field', 'main_url')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'money_url')->first()) && $section->settings->where('field', 'money_url')->first()->show_in_table)<th>{{ $section->settings->where('field', 'money_url')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'landing_page')->first()) && $section->settings->where('field', 'landing_page')->first()->show_in_table)<th>{{ $section->settings->where('field', 'landing_page')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'proxified_original')->first()) && $section->settings->where('field', 'proxified_original')->first()->show_in_table)<th>{{ $section->settings->where('field', 'proxified_original')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'proxified_money')->first()) && $section->settings->where('field', 'proxified_money')->first()->show_in_table)<th>{{ $section->settings->where('field', 'proxified_money')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'enable_firewall')->first()) && $section->settings->where('field', 'enable_firewall')->first()->show_in_table)<th>{{ $section->settings->where('field', 'enable_firewall')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'mobile_only')->first()) && $section->settings->where('field', 'mobile_only')->first()->show_in_table)<th>{{ $section->settings->where('field', 'mobile_only')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'countries_list')->first()) && $section->settings->where('field', 'countries_list')->first()->show_in_table)<th>{{ $section->settings->where('field', 'countries_list')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'referral_exists')->first()) && $section->settings->where('field', 'referral_exists')->first()->show_in_table)<th>{{ $section->settings->where('field', 'referral_exists')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'gclid_exists')->first()) && $section->settings->where('field', 'gclid_exists')->first()->show_in_table)<th>{{ $section->settings->where('field', 'gclid_exists')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'spoof_referral')->first()) && $section->settings->where('field', 'spoof_referral')->first()->show_in_table)<th>{{ $section->settings->where('field', 'spoof_referral')->first()->field_title }}</th>@endif

                                @if(!empty($section->settings) && !empty($section->settings->where('field', 'timezone_check')->first()) && $section->settings->where('field', 'timezone_check')->first()->show_in_table)<th>{{ $section->settings->where('field', 'timezone_check')->first()->field_title }}</th>@endif

                                <th>Updated By</th>
                                <th>Added By</th>
                                <th>Clicks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($links as $link)
                                <tr>
                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'campaign_name')->first()) && $section->settings->where('field', 'campaign_name')->first()->show_in_table)<td>{{ $link->name ?? $section->settings->where('field', 'campaign_name')->first()->default }}</td>@endif

                                    <td>@if(!empty($link->domain)) https://{{ $link->domain->domain }}/{{ $link->slug }} @endif</td>
                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'main_url')->first()) && $section->settings->where('field', 'main_url')->first()->show_in_table)<td>{{ $link->safe_link ?? $section->settings->where('field', 'main_url')->first()->default }}</td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'money_url')->first()) && $section->settings->where('field', 'money_url')->first()->show_in_table)<td>{{ $link->money_link ?? $section->settings->where('field', 'money_url')->first()->default }}</td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'landing_page')->first()) && $section->settings->where('field', 'landing_page')->first()->show_in_table)<td>{{ $link->landingpage ?? $section->settings->where('field', 'landing_page')->first()->default }}</td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'proxified_original')->first()) && $section->settings->where('field', 'proxified_original')->first()->show_in_table)<td>@if((($section->settings->where('setting_name', 'proxified_original')->first()->value ?? $section->settings->where('field', 'proxified_original')->first()->default) && $section->settings->where('field', 'proxified_original')->first()->is_hidden) || (!($section->settings->where('field', 'proxified_original')->first()->is_hidden) && $section->settings->where('field', 'proxified_original')->first()->default)) Active @else Inactive @endif </td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'proxified_money')->first()) && $section->settings->where('field', 'proxified_money')->first()->show_in_table)<td>@if((($section->settings->where('setting_name', 'proxified_money')->first()->value ?? $section->settings->where('field', 'proxified_money')->first()->default) && $section->settings->where('field', 'proxified_money')->first()->is_hidden) || (!($section->settings->where('field', 'proxified_money')->first()->is_hidden) && $section->settings->where('field', 'proxified_money')->first()->default)) Active @else Inactive @endif </td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'enable_firewall')->first()) && $section->settings->where('field', 'enable_firewall')->first()->show_in_table)<td>@if((($section->settings->where('setting_name', 'enable_firewall')->first()->value ?? $section->settings->where('field', 'enable_firewall')->first()->default) && $section->settings->where('field', 'enable_firewall')->first()->is_hidden) || (!($section->settings->where('field', 'enable_firewall')->first()->is_hidden) && $section->settings->where('field', 'enable_firewall')->first()->default)) Active @else Inactive @endif</td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'mobile_only')->first()) && $section->settings->where('field', 'mobile_only')->first()->show_in_table)<td>@if((($section->settings->where('setting_name', 'mobile_only')->first()->value ?? $section->settings->where('field', 'mobile_only')->first()->default) && $section->settings->where('field', 'mobile_only')->first()->is_hidden) || (!($section->settings->where('field', 'mobile_only')->first()->is_hidden) && $section->settings->where('field', 'mobile_only')->first()->default)) Active @else Inactive @endif</td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'countries_list')->first()) && $section->settings->where('field', 'countries_list')->first()->show_in_table)<td @if((($section->settings->where('setting_name', 'is_countries_blocked')->first()->value ?? $section->settings->where('field', 'is_countries_blocked')->first()->default) && $section->settings->where('field', 'is_countries_blocked')->first()->is_hidden) || (!($section->settings->where('field', 'is_countries_blocked')->first()->is_hidden) && $section->settings->where('field', 'is_countries_blocked')->first()->default)) class="danger" @else class="success" @endif>@if(!$section->settings->where('field', 'countries_list')->first()->is_hidden){{ $link->settings->where('field', 'countries_list')->first()->value ?? $section->settings->where('field', 'countries_list')->first()->default }} @else {{ $section->settings->where('field', 'countries_list')->first()->default }}@endif</td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'referral_exists')->first()) && $section->settings->where('field', 'referral_exists')->first()->show_in_table)<td>@if((($section->settings->where('setting_name', 'referral_exists')->first()->value ?? $section->settings->where('field', 'referral_exists')->first()->default) && $section->settings->where('field', 'referral_exists')->first()->is_hidden) || (!($section->settings->where('field', 'referral_exists')->first()->is_hidden) && $section->settings->where('field', 'referral_exists')->first()->default)) Active @else Inactive @endif</td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'gclid_exists')->first()) && $section->settings->where('field', 'gclid_exists')->first()->show_in_table)<td>@if((($section->settings->where('setting_name', 'gclid_exists')->first()->value ?? $section->settings->where('field', 'gclid_exists')->first()->default) && $section->settings->where('field', 'gclid_exists')->first()->is_hidden) || (!($section->settings->where('field', 'gclid_exists')->first()->is_hidden) && $section->settings->where('field', 'gclid_exists')->first()->default)) Active @else Inactive @endif</td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'spoof_referral')->first()) && $section->settings->where('field', 'spoof_referral')->first()->show_in_table)<td>@if((($section->settings->where('setting_name', 'spoof_referral')->first()->value ?? $section->settings->where('field', 'spoof_referral')->first()->default) && $section->settings->where('field', 'spoof_referral')->first()->is_hidden) || (!($section->settings->where('field', 'spoof_referral')->first()->is_hidden) && $section->settings->where('field', 'spoof_referral')->first()->default)) Active @else Inactive @endif</td>@endif

                                    @if(!empty($section->settings) && !empty($section->settings->where('field', 'timezone_check')->first()) && $section->settings->where('field', 'timezone_check')->first()->show_in_table)<td>@if((($section->settings->where('setting_name', 'timezone_check')->first()->value ?? $section->settings->where('field', 'timezone_check')->first()->default) && $section->settings->where('field', 'timezone_check')->first()->is_hidden) || (!($section->settings->where('field', 'timezone_check')->first()->is_hidden) && $section->settings->where('field', 'timezone_check')->first()->default)) Active @else Inactive @endif</td>@endif

                                    <td>@if(!empty($link->updatedby)){{ $link->updatedby->name }}@endif</td>
                                    <td>{{ $link->createdby->name }}</td>
                                    <td>{{ $link->clicks }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-default"><i class="fa fa-copy"></i></button>
                                        <a href="{{ route('user.links.link', ['link' => $link->id]) }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                        @if(Auth::user()->id == $link->createdby->id)
                                            <a href="{{ route('user.links.linkscrape', ['link' => $link->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-cloud-download-alt"></i></a>
                                            <form action="{{ route('user.links.linkdelete', ['link' => $link->id]) }}" method="POST" style="display:inline-block;">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                        <a href="{{ route('user.logs.link', ['link'=> $link->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
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
    <script src="{{asset("assets/vendor/datatables/js/jquery.dataTables.min.js")}}"></script>
    <script src="{{asset("assets/vendor/datatables-plugins/dataTables.bootstrap.min.js")}}"></script>
    <script src="{{asset("assets/vendor/datatables-responsive/dataTables.responsive.js")}}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.domains').select2();
    });
    </script>
    <style>
        .select2-container{
            width:100% !important;
        }
    </style>
    <script>
    $(document).ready(function() {
        $('.datatable1').DataTable({
            responsive: true
        });
    });
    $(document).on('submit', 'form.AjaxForm', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            success: function( json ) {
                if(json.error){
                    html = '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Warning! </strong>'+ json.error +'</span>';
                    $('.statuses').prepend(html);
                }else if(json.status){
                    html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Success! </strong>'+ json.status +' <br> <a href="'+ json.url +'"target="__blank">'+ json.url +'</a></span>';
                    $('.statuses .alert').remove();
                    $('.statuses').prepend(html);
                }
            },
            error:function( xhr, err ) {
                html = '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Warning! </strong>Something Wrong occurred!!</span>';
                    $('.statuses').prepend(html);
            }
        });
        return false;
    });
    </script>
@endsection
