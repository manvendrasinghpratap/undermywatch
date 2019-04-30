@extends('layouts.newadmintemplate')
@section('content')
  <section class="section-container">
         <!-- Page content-->
         <div class="content-wrapper">
            <div class="content-heading">
               <div>Creating New Shield</div><!-- START Language list-->
               <div class="ml-auto">
                 @if(Auth::user()->level == config('app.superadminlevel'))
                 <button class="btn btn-labeled btn-success" type="button"><a href="{{route('superadmin.sections.index')}}" class="btn-label whitetext"><i class="fa fa-plus"></i></a>List Of Shield</button>
               @endif
              </div><!-- END Language list-->
            </div>
            <div class="row">
              <div class="col-md-12">
                  <div class="card card-default">
                     <div class="card-body">
                       <form action="{{ route('superadmin.sections.create') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                           <div class="form-group"><label>Shield Name</label>
                             <input class="form-control" type="text" name="name" {{ old('name') }} placeholder="Enter Shield Name" required>
                           </div>
                           <div class="form-group"><label>Slug</label><input class="form-control" name="slug" type="text" placeholder="Enter slug for your Shield"></div>
                           <div class="form-group"><label>Notes</label><input class="form-control" type="text" name="notes" placeholder="Enter any notes"></div>
                           <div class="form-group"><label>Add Thumbnail</label>
                          <input class="form-control filestyle" type="file" name="image" data-classbutton="btn btn-secondary" data-classinput="form-control inline" data-icon="<span class='fa fa-upload mr-2'></span>">
                        </div>

                           <!--- Section Part --->
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Campaign Name" value="1" name="setting[7][enable]"
                                          @if(
                                                !empty(old('setting'))
                                                && !empty(old('setting')[7])
                                                && !empty(old('setting')[7]['enable'])
                                                && old('setting')[7]["enable"])
                                              checked
                                          @endif />
                                            <span class="fa fa-check"></span>Campaign Name
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[7][field]" value="campaign_name">
                            <input type="text" class="form-control" name="setting[7][field_title]" placeholder="Title" value="@if(!empty(old('setting')) && !empty(old('setting')[7]) && !empty(old('setting')[7]['field_title']) && old('setting')[7]["field_title"]){{ old('setting')[7]["field_title"] }} @else Campaign Name @endif" >
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[7][is_hidden]"    @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[7])
                                          && !empty(old('setting')[7]['is_hidden'])
                                          && old('setting')[7]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>


                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Custom Slug" value="1" name="setting[1][enable]"  @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[1])
                                          && !empty(old('setting')[1]['enable'])
                                          && old('setting')[1]["enable"])
                                              checked
                                          @endif />
                                                <span class="fa fa-check">
                                                </span>
                                                Campaign Slug
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[1][field]" value="slug">
                            <input type="text" class="form-control" name="setting[1][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[1]) && !empty(old('setting')[1]['field_title']) && old('setting')[1]["field_title"]){{ old('setting')[1]["field_title"] }} @else Slug @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[1][is_hidden]"  @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[1])
                                          && !empty(old('setting')[1]['is_hidden'])
                                          && old('setting')[1]["is_hidden"])
                                              checked
                                          @endif />
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="hidden" name="setting[0][enable]" value="1">
                                          <input type="checkbox" aria-label="Enable Domain" value="1"  checked = true  disabled = true name="setting[0][enable]" />

                                                <span class="fa fa-check">
                                                </span>
                                                Domain Name
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[0][field]" value="domain">
                            <input type="text" class="form-control" name="setting[0][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[0]) && !empty(old('setting')[0]['field_title']) && old('setting')[0]['field_title']){{ old('setting')[0]['field_title'] }} @else Domain @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[0][is_hidden]"  @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[0])
                                          && !empty(old('setting')[0]['is_hidden'])
                                          && old('setting')[0]["is_hidden"])
                                              checked
                                          @endif />
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Safe Page" value="1" name="setting[2][enable]"  @if(
                                            !empty(old('setting'))
                                            && !empty(old('setting')[2])
                                            && !empty(old('setting')[2]['enable'])
                                            && old('setting')[2]["enable"])
                                                checked
                                            @endif />
                                                <span class="fa fa-check">
                                                </span>
                                                Safe Page
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[2][field]" value="main_url">
                            <input type="text" class="form-control" name="setting[2][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[2]) && !empty(old('setting')[2]['field_title']) && old('setting')[2]['field_title']){{ old('setting')[2]['field_title'] }}@else Safe Page @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>

                                                  <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[2][is_hidden]"  @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[2])
                                          && !empty(old('setting')[2]['is_hidden'])
                                          && old('setting')[2]["is_hidden"])
                                              checked
                                          @endif />
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Main URL" value="1" name="setting[3][enable]"  @if(
                                            !empty(old('setting'))
                                            && !empty(old('setting')[3])
                                            && !empty(old('setting')[3]['enable'])
                                            && old('setting')[3]["enable"])
                                                checked
                                            @endif />
                                                <span class="fa fa-check">
                                                </span>
                                                Offer Page
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[3][field]" value="money_url">
                            <input type="text" class="form-control" name="setting[3][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[7]) && !empty(old('setting')[3]['field_title']) && old('setting')[3]["field_title"]){{ old('setting')[3]["field_title"] }}@else Offer Page @endif">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[3][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[3])
                                          && !empty(old('setting')[3]['is_hidden'])
                                          && old('setting')[3]["is_hidden"])
                                              checked
                                          @endif />
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Landing Page" value="1" name="setting[8][enable]"  @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[8])
                                          && !empty(old('setting')[8]['enable'])
                                          && old('setting')[8]["enable"])
                                              checked
                                          @endif>
                                                <span class="fa fa-check"></span>
                                                Landing Page
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[8][field]" value="landing_page">
                            <input type="text" class="form-control" name="setting[8][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[8]) && !empty(old('setting')[8]['field_title']) && old('setting')[8]["field_title"]){{ old('setting')[8]["field_title"] }}@else Landing Page @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                                <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[8][is_hidden]"   @if(
                                                !empty(old('setting'))
                                                && !empty(old('setting')[8])
                                                && !empty(old('setting')[8]['is_hidden'])
                                                && old('setting')[8]["is_hidden"])
                                                checked
                                                @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Landing Page" value="1" name="setting[30][enable]"  @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[30])
                                          && !empty(old('setting')[30]['enable'])
                                          && old('setting')[30]["enable"])
                                              checked
                                          @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Enable JCI
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[30][field]" value="enable_jci" >
                            <input type="text" class="form-control" name="setting[30][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[30]) && !empty(old('setting')[30]['field_title']) && old('setting')[30]["field_title"]){{ old('setting')[30]["field_title"] }}@else JCI Campaign Code @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Landing Page" value="1" name="setting[30][is_hidden]"  @if(
                                              !empty(old('setting'))
                                              && !empty(old('setting')[30])
                                              && !empty(old('setting')[30]['is_hidden'])
                                              && old('setting')[30]["is_hidden"])
                                                  checked
                                              @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Firewall" value="1" name="setting[11][enable]"  @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[11])
                                          && !empty(old('setting')[11]['enable'])
                                          && old('setting')[11]["enable"])
                                              checked
                                          @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                FireWall
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[11][field]" value="enable_firewall">
                            <input type="text" class="form-control" name="setting[11][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[11]) && !empty(old('setting')[11]['field_title']) && old('setting')[11]["field_title"]){{ old('setting')[11]["field_title"] }}@else Enable FireWall @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" name="setting[11][default]" value="1" @if(
                                            !empty(old('setting'))
                                            && !empty(old('setting')[11])
                                            && !empty(old('setting')[11]['default'])
                                            && old('setting')[11]["default"])
                                                checked
                                            @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                                    <input type="checkbox" name="setting[11][is_hidden]" value="1" @if(
                                                    !empty(old('setting'))
                                                    && !empty(old('setting')[11])
                                                    && !empty(old('setting')[11]['is_hidden'])
                                                    && old('setting')[11]["is_hidden"])
                                                    checked
                                                    @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Gclid" value="1" name="setting[17][enable]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[17])
                                          && !empty(old('setting')[17]['enable'])
                                          && old('setting')[17]["enable"])
                                              checked
                                          @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Track GCLID
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[17][field]" value="gclid_exists">
                                            <input type="text" class="form-control" name="setting[17][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[17]) && !empty(old('setting')[17]['field_title']) && old('setting')[17]["field_title"]){{ old('setting')[17]["field_title"] }} @else Track GCLID (Enable Autotagging in Adwords) @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" name="setting[17][default]" value="1"
                                                   @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[17])
                                          && !empty(old('setting')[17]['default'])
                                          && old('setting')[17]["default"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" name="setting[17][is_hidden]" value="1"
                                                     @if(
                                                    !empty(old('setting'))
                                                    && !empty(old('setting')[17])
                                                    && !empty(old('setting')[17]['is_hidden'])
                                                    && old('setting')[17]["is_hidden"])
                                                    checked
                                                    @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[21][enable]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[21])
                                          && !empty(old('setting')[21]['enable'])
                                          && old('setting')[21]["enable"])
                                              checked
                                          @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Unique GCLID
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                                <input type="hidden" name="setting[21][field]" value="unique_gclid_exists">
                                <input type="text" class="form-control" name="setting[21][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[21]) && !empty(old('setting')[21]['field_title']) && old('setting')[21]["field_title"]){{ old('setting')[21]["field_title"] }}@else Enable Unique GCLID @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[21][default]" @if(
                                              !empty(old('setting'))
                                              && !empty(old('setting')[21])
                                              && !empty(old('setting')[21]['default'])
                                              && old('setting')[21]["default"])
                                                  checked
                                              @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[21][is_hidden]" @if(
                                              !empty(old('setting'))
                                              && !empty(old('setting')[21])
                                              && !empty(old('setting')[21]['is_hidden'])
                                              && old('setting')[21]["is_hidden"])
                                                  checked
                                              @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[31][enable]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[31])
                                          && !empty(old('setting')[31]['enable'])
                                          && old('setting')[31]["enable"])
                                              checked
                                          @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Whitelist ISP's
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[31][field]" value="bypass_whitelisted_isp">
                            <input type="text" class="form-control" name="setting[31][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[31]) && !empty(old('setting')[31]['field_title']) && old('setting')[31]["field_title"]){{ old('setting')[31]["field_title"] }} @else Allow only Whitelisted ISP's @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[31][default]" @if(
                                              !empty(old('setting'))
                                              && !empty(old('setting')[31])
                                              && !empty(old('setting')[31]['default'])
                                              && old('setting')[31]["default"])
                                                  checked
                                              @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[31][is_hidden]" @if(
                                              !empty(old('setting'))
                                              && !empty(old('setting')[31])
                                              && !empty(old('setting')[31]['is_hidden'])
                                              && old('setting')[31]["is_hidden"])
                                                  checked
                                              @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[15][enable]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[15])
                                          && !empty(old('setting')[15]['enable'])
                                          && old('setting')[15]["enable"])
                                              checked
                                          @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Empty Referral
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[15][field]" value="referral_exists">
                            <input type="text" class="form-control" name="setting[15][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[15]) && !empty(old('setting')[15]['field_title']) && old('setting')[15]["field_title"]){{ old('setting')[15]["field_title"] }}@else Block Empty Referral @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[15][default]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[15])
                                          && !empty(old('setting')[15]['default'])
                                          && old('setting')[15]["default"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                                  <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[15][is_hidden]" @if(
                                                  !empty(old('setting'))
                                                  && !empty(old('setting')[15])
                                                  && !empty(old('setting')[15]['is_hidden'])
                                                  && old('setting')[15]["is_hidden"])
                                                  checked
                                                  @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[32][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[32])
                                      && !empty(old('setting')[32]['enable'])
                                      && old('setting')[32]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Double Meta (DM)
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                                <input type="hidden" name="setting[32][field]" value="double_meta">
                                <input type="text" class="form-control" name="setting[32][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[32]) && !empty(old('setting')[32]['field_title']) && old('setting')[32]["field_title"]){{ old('setting')[32]["field_title"] }} @else Enable Double Meta Refresh @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[32][default]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[32])
                                          && !empty(old('setting')[32]['default'])
                                          && old('setting')[32]["default"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[32][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[32])
                                          && !empty(old('setting')[32]['is_hidden'])
                                          && old('setting')[32]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[33][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[33])
                                      && !empty(old('setting')[33]['enable'])
                                      && old('setting')[33]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                TimeZone + DM
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[33][field]" value="timezone_check">
                                            <input type="text" class="form-control" name="setting[33][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[33]) && !empty(old('setting')[33]['field_title']) && old('setting')[33]["field_title"]){{ old('setting')[16]["field_title"] }} @else Enable Timezone Check (Double Meta by default) @endif">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[33][default]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[33])
                                          && !empty(old('setting')[33]['default'])
                                          && old('setting')[33]["default"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[33][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[33])
                                          && !empty(old('setting')[33]['is_hidden'])
                                          && old('setting')[33]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[34][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[34])
                                      && !empty(old('setting')[34]['enable'])
                                      && old('setting')[34]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Block Referrals
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[34][field]" value="referer_firewall">
                                            <input type="text" class="form-control" name="setting[34][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[34]) && !empty(old('setting')[34]['field_title']) && old('setting')[34]["field_title"]){{ old('setting')[34]["field_title"] }} @else Block Suspicious Referrals @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[34][default]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[34])
                                          && !empty(old('setting')[34]['default'])
                                          && old('setting')[34]["default"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[34][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[34])
                                          && !empty(old('setting')[34]['is_hidden'])
                                          && old('setting')[34]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[35][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[35])
                                      && !empty(old('setting')[35]['enable'])
                                      && old('setting')[35]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Mobile Only
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[35][field]" value="mobile_only">
                                            <input type="text" class="form-control" name="setting[35][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[35]) && !empty(old('setting')[35]['field_title']) && old('setting')[35]["field_title"]){{ old('setting')[35]["field_title"] }} @else Mobile Only Campaign @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[35][default]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[35])
                                          && !empty(old('setting')[35]['default'])
                                          && old('setting')[35]["default"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[35][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[35])
                                          && !empty(old('setting')[35]['is_hidden'])
                                          && old('setting')[35]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[36][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[36])
                                      && !empty(old('setting')[36]['enable'])
                                      && old('setting')[36]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Proxify Safe Page
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[36][field]" value="proxified_original">
                                            <input type="text" class="form-control" name="setting[36][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[36]) && !empty(old('setting')[36]['field_title']) && old('setting')[36]["field_title"]){{ old('setting')[36]["field_title"] }} @else Proxify Safe Page @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[36][default]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[36])
                                          && !empty(old('setting')[36]['default'])
                                          && old('setting')[36]["default"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[36][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[36])
                                          && !empty(old('setting')[36]['is_hidden'])
                                          && old('setting')[36]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[37][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[37])
                                      && !empty(old('setting')[37]['enable'])
                                      && old('setting')[37]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Proxify Offer Page
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[37][field]" value="proxified_money">
                                            <input type="text" class="form-control" name="setting[37][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[37]) && !empty(old('setting')[37]['field_title']) && old('setting')[37]["field_title"]){{ old('setting')[37]["field_title"] }}@else Proxify Offer Page @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[37][default]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[37])
                                          && !empty(old('setting')[37]['default'])
                                          && old('setting')[37]["default"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[37][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[37])
                                          && !empty(old('setting')[37]['is_hidden'])
                                          && old('setting')[37]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[38][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[38])
                                      && !empty(old('setting')[38]['enable'])
                                      && old('setting')[38]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Enable Logs
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[38][field]" value="loglink">
                                            <input type="text" class="form-control" name="setting[38][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[38]) && !empty(old('setting')[38]['field_title']) && old('setting')[38]["field_title"]){{ old('setting')[16]["field_title"] }}@else Enable Logs @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[38][default]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[38])
                                          && !empty(old('setting')[38]['default'])
                                          && old('setting')[38]["default"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Default
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[38][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[38])
                                          && !empty(old('setting')[38]['is_hidden'])
                                          && old('setting')[38]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[39][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[39])
                                      && !empty(old('setting')[39]['enable'])
                                      && old('setting')[39]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Allowed Referrals
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[39][field]" value="allowed_referers">
                                            <input type="text" class="form-control" name="setting[38][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[39]) && !empty(old('setting')[39]['field_title']) && old('setting')[39]["field_title"]){{ old('setting')[39]["field_title"] }}@else Enter referrals you want to allow like google.com, facebook.com @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[39][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[39])
                                          && !empty(old('setting')[39]['is_hidden'])
                                          && old('setting')[39]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[40][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[40])
                                      && !empty(old('setting')[40]['enable'])
                                      && old('setting')[40]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Block UserAgents
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[40][field]" value="user_agent_filter">
                                            <input type="text" class="form-control" name="setting[40][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[40]) && !empty(old('setting')[40]['field_title']) && old('setting')[40]["field_title"]){{ old('setting')[40]["field_title"] }} @else Enter UserAgents you want to block like BrandVerity @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[40][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[40])
                                          && !empty(old('setting')[40]['is_hidden'])
                                          && old('setting')[40]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[41][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[41])
                                      && !empty(old('setting')[41]['enable'])
                                      && old('setting')[41]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Notes
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                                <input type="hidden" name="setting[41][field]" value="extra_notes">
                                <input type="text" class="form-control" name="setting[41][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[41]) && !empty(old('setting')[41]['field_title']) && old('setting')[41]["field_title"]){{ old('setting')[16]["field_title"] }} @else Extra Notes @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[41][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[41])
                                          && !empty(old('setting')[41]['is_hidden'])
                                          && old('setting')[41]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[42][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[42])
                                      && !empty(old('setting')[42]['enable'])
                                      && old('setting')[42]["enable"])
                                          checked
                                      @endif>
                                                <span class="fa fa-check">
                                                </span>
                                                Click Limit
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[42][field]" value="click_limit">
                            <input type="text" class="form-control" name="setting[42][field_title]" placeholder="Title"   value="@if(!empty(old('setting')) && !empty(old('setting')[42]) && !empty(old('setting')[42]['field_title']) && old('setting')[42]["field_title"]){{ old('setting')[42]["field_title"] }} @else Click Limit @endif">
                            <div class="input-group-append">
                                 <input class="form-control" placeholder="Enter Title" type="text" value="10" style="width: 80px;border-radius: 0;" name="setting[42][default]">
                                    <span class="input-group-text shield"> <label> Default </label></span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[42][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[42])
                                          && !empty(old('setting')[42]['is_hidden'])
                                          && old('setting')[42]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                        <!--- Section Part --->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Bloack IP V 6" value="1" name="setting[43][enable]" @if(
                                      !empty(old('setting'))
                                      && !empty(old('setting')[43])
                                      && !empty(old('setting')[43]['enable'])
                                      && old('setting')[43]["enable"])
                                          checked
                                      @endif >
                                                <span class="fa fa-check">
                                                </span>
                                                Block IP V 6
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[43][field]" value="blockipv6">
                                            <input type="text" class="form-control" name="setting[43][field_title]" placeholder="Title" value="@if(!empty(old('setting')) && !empty(old('setting')[43]) && !empty(old('setting')[43]['field_title']) && old('setting')[43]["field_title"]){{ old('setting')[43]["field_title"] }} @else Block IP V 6 @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[43][is_hidden]" @if(
                                          !empty(old('setting'))
                                          && !empty(old('setting')[43])
                                          && !empty(old('setting')[43]['is_hidden'])
                                          && old('setting')[43]["is_hidden"])
                                              checked
                                          @endif>
                                                    <span class="fa fa-check">
                                                    </span>
                                                    Hidden
                                                </input>
                                            </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                           <button class="btn btn-success btn-lg" type="submit" style="width:100%;">Create Shield</button>
                     </div>
                  </div><!-- END card-->

               </div>
            </div>
         </div>
  </section>

@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap3-wysi/bootstrap3-wysihtml5.min.css') }}">
<script type="text/javascript" src="{{ asset('assets/vendor/bootstrap3-wysi/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script type="text/javascript">
    $('#wysi').wysihtml5();
</script>
@endsection
