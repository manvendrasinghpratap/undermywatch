@extends('layouts.admin')
@section('title')
    {{ $link->section->name }}'s Links
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
        <h1 class="page-header">Edit Link</h1>
    </div>
</div>
<div class="row">
    @include('user.components.statuses')
    <div class="col-lg-12 col-md-12">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('user.sections.section', ['section' => $link->section->slug]) }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left">&nbsp;</i></a>&nbsp;&nbsp;Edit Link
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="row">
                            <form method="POST" action="{{ route('user.links.linkupdate', ['link'=>$link->id]) }}">
                                {{ csrf_field() }}
                                <div class="panel-body">
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">Sharing Link</label>
                                            </span>
                                            <div>
                                                <input type="text" class="form-control" @if(!empty($link->domain))value="https://{{ $link->domain->domain ?? ''}}/{{ $link->slug }}" @endif readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'campaign_name')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'campaign_name')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'campaign_name')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <input type="text" class="form-control" name="campaign_name" value="{{ $link->name ?? $link->section->settings->where('field', 'campaign_name')->first()->default}}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'domain')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'domain')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'domain')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <select type="text" class="form-control domains" name="domain">
                                                    @foreach($domains as $domain)
                                                        <option value="{{ $domain->id }}" @if(($link->domain->id ?? $link->section->settings->where('field', 'domain')->first()->default) == $domain->id) selected @endif>{{ $domain->domain }} @if(!empty($domain->note)) &nbsp;&nbsp;({{ $domain->note }}) @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'slug')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'slug')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'slug')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <input type="text" class="form-control" name="slug"  value="{{ $link->slug }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'main_url')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'main_url')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'main_url')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <input type="text" class="form-control" name="main_url" value="{{ $link->safe_link }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'proxified_original')->first()))
                                    <div class="col-sm-4 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'proxified_original')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'proxified_original')->first()->field_title }}</label>
                                            </span>
                                            <span class="input-group-addon">
                                                <label class="cbox_block">
                                                  <input type="hidden" name="proxified_original" value="0">
                                                  <input type="checkbox" value="1" name="proxified_original" @if($link->settings->where('setting_name', 'proxified_original')->first()->value ?? $link->section->settings->where('field', 'proxified_original')->first()->default) checked @endif>&nbsp;
                                                  <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'money_url')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'money_url')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'money_url')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <input type="text" class="form-control" name="money_url" value="{{ $link->money_link }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'proxified_money')->first()))
                                    <div class="col-sm-4 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'proxified_money')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'proxified_money')->first()->field_title }}</label>
                                            </span>
                                            <span class="input-group-addon">
                                                <label class="cbox_block">
                                                  <input type="hidden" name="proxified_money" value="0">
                                                  <input type="checkbox" value="1" name="proxified_money" @if($link->settings->where('setting_name', 'proxified_money')->first()->value ?? $link->section->settings->where('field', 'proxified_money')->first()->default) checked @endif>&nbsp;
                                                  <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'landing_page')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'landing_page')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'landing_page')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <select type="text" class="form-control" name="landing_page">
                                                    @foreach($landingpages as $lp)
                                                        <option value="{{ $lp }}" @if($link->landingpage == $lp) checked @endif>{{ $lp }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'click_limit')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'click_limit')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'click_limit')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <input type="number" class="form-control" name="click_limit" value="{{ $link->click_limit ?? $link->section->settings->where('field', 'click_limit')->first()->default }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'countries_list')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'countries_list')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'countries_list')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <input type="text" class="form-control" name="countries_list" value="{{ $link->settings->where('setting_name', 'countries_list')->first()->value ?? $link->section->settings->where('field', 'countries_list')->first()->default }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'is_countries_blocked')->first()))
                                    <div class="col-sm-4 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'is_countries_blocked')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'is_countries_blocked')->first()->field_title }}</label>
                                            </span>
                                            <span class="input-group-addon">
                                                <label class="cbox_block">
                                                  <input type="hidden" name="is_countries_blocked" value="0">
                                                  <input type="checkbox" value="1" name="is_countries_blocked" @if($link->settings->where('setting_name', 'is_countries_blocked')->first()->value ?? $link->section->settings->where('field', 'is_countries_blocked')->first()->default) checked @endif>&nbsp;
                                                  <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'enable_firewall')->first()))
                                    <div class="col-sm-4 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'enable_firewall')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'enable_firewall')->first()->field_title }}</label>
                                            </span>
                                            <span class="input-group-addon">
                                                <label class="cbox_block">
                                                  <input type="hidden" name="enable_firewall" value="0">
                                                  <input type="checkbox" value="1" name="enable_firewall" @if($link->settings->where('setting_name', 'enable_firewall')->first()->value ?? $link->section->settings->where('field', 'enable_firewall')->first()->default) checked @endif>&nbsp;
                                                  <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'mobile_only')->first()))
                                    <div class="col-sm-4 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'mobile_only')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'mobile_only')->first()->field_title }}</label>
                                            </span>
                                            <span class="input-group-addon">
                                                <label class="cbox_block">
                                                  <input type="hidden" name="mobile_only" value="0">
                                                  <input type="checkbox" value="1" name="mobile_only" @if($link->settings->where('setting_name', 'mobile_only')->first()->value ?? $link->section->settings->where('field', 'mobile_only')->first()->default) checked @endif>&nbsp;
                                                  <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'custom_script')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'custom_script')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'custom_script')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <textarea class="form-control" name="custom_script" rows="4">{{ $link->settings->where('setting_name', 'custom_script')->first()->value ?? $link->section->settings->where('field', 'custom_script')->first()->default }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'user_agent_filter')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'user_agent_filter')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'user_agent_filter')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <input type="text" class="form-control" name="user_agent_filter" value="{{ $link->settings->where('setting_name', 'user_agent_filter')->first()->value ?? $link->section->settings->where('field', 'user_agent_filter')->first()->default }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'gclid_exists')->first()))
                                    <div class="col-sm-4 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'gclid_exists')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'gclid_exists')->first()->field_title }}</label>
                                            </span>
                                            <span class="input-group-addon">
                                                <label class="cbox_block">
                                                  <input type="hidden" name="gclid_exists" value="0">
                                                  <input type="checkbox" value="1" name="gclid_exists" @if($link->settings->where('setting_name', 'gclid_exists')->first()->value ?? $link->section->settings->where('field', 'gclid_exists')->first()->default) checked @endif>&nbsp;
                                                  <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'spoof_referral')->first()))
                                    <div class="col-sm-4 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'spoof_referral')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'spoof_referral')->first()->field_title }}</label>
                                            </span>
                                            <span class="input-group-addon">
                                                <label class="cbox_block">
                                                  <input type="hidden" name="spoof_referral" value="0">
                                                  <input type="checkbox" value="1" name="spoof_referral" @if($link->settings->where('setting_name', 'spoof_referral')->first()->value ?? $link->section->settings->where('field', 'spoof_referral')->first()->default) checked @endif>&nbsp;
                                                  <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'timezone_check')->first()))
                                    <div class="col-sm-4 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'timezone_check')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'timezone_check')->first()->field_title }}</label>
                                            </span>
                                            <span class="input-group-addon">
                                                <label class="cbox_block">
                                                  <input type="hidden" name="timezone_check" value="0">
                                                  <input type="checkbox" value="1" name="timezone_check" @if($link->settings->where('setting_name', 'timezone_check')->first()->value ?? $link->section->settings->where('field', 'timezone_check')->first()->default) checked @endif>&nbsp;
                                                  <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'referral_exists')->first()))
                                    <div class="col-sm-4 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'referral_exists')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'referral_exists')->first()->field_title }}</label>
                                            </span>
                                            <span class="input-group-addon">
                                                <label class="cbox_block">
                                                  <input type="hidden" name="referral_exists" value="0">
                                                  <input type="checkbox" value="1" name="referral_exists" @if($link->settings->where('setting_name', 'referral_exists')->first()->value ?? $link->section->settings->where('field', 'referral_exists')->first()->default) checked @endif>&nbsp;
                                                  <span class="checkmark"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'filter_referral')->first()))
                                    <div class="col-sm-12 row">
                                        <div class="form-group input-group" style="@if($link->section->settings->where('field', 'filter_referral')->first()->is_hidden) display: none; @endif">
                                            <span class="input-group-addon">
                                                <label style="margin:0;">{{ $link->section->settings->where('field', 'filter_referral')->first()->field_title }}</label>
                                            </span>
                                            <div>
                                                <input type="text" class="form-control" name="filter_referral" value="{{ $link->settings->where('setting_name', 'filter_referral')->first()->value ?? $link->section->settings->where('field', 'filter_referral')->first()->default }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <input type="submit" class="btn btn-success" value="Update">
                            </form>
                        </div>
                        <br>
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
    </script>
@endsection
