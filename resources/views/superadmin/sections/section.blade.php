@extends('layouts.newadmintemplate')
@section('content')
  <section class="section-container">
         <!-- Page content-->
         <div class="content-wrapper">
            <div class="content-heading">
               <div>Edit Shield : {{ @$section->name }}</div><!-- START Language list-->
               <div class="ml-auto">
                 <button class="btn btn-labeled btn-success" type="button"><a href="{{route('superadmin.sections.index')}}" class="btn-label whitetext"><i class="fa fa-plus"></i></a>List Of Shield</button>
              </div><!-- END Language list-->
            </div>
            <div class="row">
              <div class="col-md-12">
                  <div class="card card-default">
                     <div class="card-body">
                       <form action="{{ route('superadmin.sections.section', ['section' => $section->slug]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                              <div class="form-group"><label>Shield Name</label>
                              <input class="form-control" type="text" name="name" value="{{ $section->name }}" placeholder="Enter Shield Name" required>
                              </div>
                              <div class="form-group"><label>Slug</label><input class="form-control" name="slug" type="text" value="{{ $section->slug }}" placeholder="Enter slug for your Shield"></div>
                              <div class="form-group"><label>Notes</label><input class="form-control" type="text" value="{{ $section->notes }}" name="notes" placeholder="Enter any notes"></div>
                              <div class="form-group"><label>Add Thumbnail</label>
                              <input class="form-control filestyle" type="file" name="image" data-classbutton="btn btn-secondary" data-classinput="form-control inline" data-icon="<span class='fa fa-upload mr-2'></span>">
                              </div>

                           <!--- Section Part --->
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <div class="checkbox c-checkbox shield">
                                        <label>
                                          <input type="checkbox" aria-label="Enable Campaign Name" value="1" name="setting[7][enable]"  <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','campaign_name')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                            <span class="fa fa-check"></span>Campaign Name
                                          </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[7][field]" value="campaign_name">
                            <input type="text" class="form-control" name="setting[7][field_title]" placeholder="Title" value="@if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','campaign_name')->first())
                                            && !empty($section->settings->where('field','campaign_name')->first()->field_title)){{ $section->settings->where('field','campaign_name')->first()->field_title }} @else campaign Name @endif" >
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[7][is_hidden]"
                                              <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','campaign_name')->first())
                                              && !empty($section->settings->where('field','campaign_name')->first()->is_hidden)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
                                                    <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Custom Slug" value="1" name="setting[1][enable]"
                                            <?php
                                              if(!empty($section->settings) && !empty($section->settings->where('field','slug')->first()))
                                              echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                <span class="fa fa-check"></span>
                                                Campaign Slug
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[1][field]" value="slug">
                            <input type="text" class="form-control" name="setting[1][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','slug')->first())
                              && !empty($section->settings->where('field','slug')->first()->field_title)){{ $section->settings->where('field','slug')->first()->field_title }} @else Slug @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[1][is_hidden]"
                                              <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','slug')->first())
                                              && !empty($section->settings->where('field','slug')->first()->is_hidden)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
                                                    <span class="fa fa-check"></span>
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
                            <input type="text" class="form-control" name="setting[0][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','domain')->first())
                              && !empty($section->settings->where('field','domain')->first()->field_title)){{ $section->settings->where('field','domain')->first()->field_title }} @else Domain @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[1][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','domain')->first())
                                            && !empty($section->settings->where('field','domain')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Safe Page" value="1" name="setting[2][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','main_url')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check"></span>
                                                Safe Page </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[2][field]" value="main_url">
                            <input type="text" class="form-control" name="setting[2][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','main_url')->first())
                              && !empty($section->settings->where('field','main_url')->first()->field_title)){{ $section->settings->where('field','main_url')->first()->field_title }} @else Safe Page @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[2][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','main_url')->first())
                                            && !empty($section->settings->where('field','main_url')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Main URL" value="1" name="setting[3][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','money_url')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Offer Page </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[3][field]" value="money_url">
                            <input type="text" class="form-control" name="setting[3][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','money_url')->first())
                              && !empty($section->settings->where('field','money_url')->first()->field_title)){{ $section->settings->where('field','money_url')->first()->field_title }} @else Offer Page @endif">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[3][is_hidden]"
                                                  <?php if(
                                                  !empty($section->settings)
                                                  && !empty($section->settings->where('field','money_url')->first())
                                                  && !empty($section->settings->where('field','money_url')->first()->is_hidden)
                                                  )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                                  ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Landing Page" value="1" name="setting[8][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','landing_page')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check"></span>
                                                Landing Page
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[8][field]" value="landing_page">
                            <input type="text" class="form-control" name="setting[8][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','landing_page')->first())
                              && !empty($section->settings->where('field','landing_page')->first()->field_title)){{ $section->settings->where('field','landing_page')->first()->field_title }} @else Landing Page @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[8][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','landing_page')->first())
                                            && !empty($section->settings->where('field','landing_page')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Landing Page" value="1" name="setting[30][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','enable_jci')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Enable JCI
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[30][field]" value="enable_jci" >
                            <input type="text" class="form-control" name="setting[30][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','enable_jci')->first())
                              && !empty($section->settings->where('field','enable_jci')->first()->field_title)){{ $section->settings->where('field','enable_jci')->first()->field_title }} @else JCI Campaign Code @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[30][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','enable_jci')->first())
                                            && !empty($section->settings->where('field','enable_jci')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
                                                  Hidden
                                              </input>
                                          </label>
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
                                          <input type="checkbox" aria-label="Enable Firewall" value="1" name="setting[11][enable]"  <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','enable_firewall')->first())
                                            )
                                              echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                <span class="fa fa-check">
                                                </span>
                                                FireWall
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[11][field]" value="enable_firewall">
                            <input type="text" class="form-control" name="setting[11][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','enable_firewall')->first())
                              && !empty($section->settings->where('field','enable_firewall')->first()->field_title)){{ $section->settings->where('field','enable_firewall')->first()->field_title }} @else Enable FireWall @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" name="setting[11][default]" value="1"   <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','enable_firewall')->first())
                                              && !empty($section->settings->where('field','enable_firewall')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[11][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','enable_firewall')->first())
                                            && !empty($section->settings->where('field','enable_firewall')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Gclid" value="1" name="setting[17][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','gclid_exists')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Track GCLID
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[17][field]" value="gclid_exists">
                                            <input type="text" class="form-control" name="setting[17][field_title]" placeholder="Title"   value="@if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','gclid_exists')->first())
                                              && !empty($section->settings->where('field','gclid_exists')->first()->field_title)){{ $section->settings->where('field','gclid_exists')->first()->field_title }} @else Track GCLID (Enable Autotagging in Adwords) @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" name="setting[17][default]" value="1"
                                              <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','gclid_exists')->first())
                                              && !empty($section->settings->where('field','gclid_exists')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[17][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','gclid_exists')->first())
                                            && !empty($section->settings->where('field','gclid_exists')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[21][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','unique_gclid_exists')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Unique GCLID
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                                <input type="hidden" name="setting[21][field]" value="unique_gclid_exists">
                                <input type="text" class="form-control" name="setting[21][field_title]" placeholder="Title"   value="@if(
                                  !empty($section->settings)
                                  && !empty($section->settings->where('field','unique_gclid_exists')->first())
                                  && !empty($section->settings->where('field','unique_gclid_exists')->first()->field_title)){{ $section->settings->where('field','unique_gclid_exists')->first()->field_title }} @else Enable Unique GCLID @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[21][default]"   <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','unique_gclid_exists')->first())
                                              && !empty($section->settings->where('field','unique_gclid_exists')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[21][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first())
                                            && !empty($section->settings->where('field','unique_gclid_exists')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[31][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','bypass_whitelisted_isp')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check"></span>
                                                Whitelist ISP's
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[31][field]" value="bypass_whitelisted_isp">
                            <input type="text" class="form-control" name="setting[31][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','bypass_whitelisted_isp')->first())
                              && !empty($section->settings->where('field','bypass_whitelisted_isp')->first()->field_title)){{ $section->settings->where('field','bypass_whitelisted_isp')->first()->field_title }} @else Allow only Whitelisted ISP's @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Unique Check Gclid" value="1" name="setting[31][default]"  <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','bypass_whitelisted_isp')->first())
                                              && !empty($section->settings->where('field','bypass_whitelisted_isp')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[31][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','bypass_whitelisted_isp')->first())
                                            && !empty($section->settings->where('field','bypass_whitelisted_isp')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[15][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','referral_exists')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>Block Empty Referral
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[15][field]" value="referral_exists">
                            <input type="text" class="form-control" name="setting[15][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','referral_exists')->first())
                              && !empty($section->settings->where('field','referral_exists')->first()->field_title)){{ $section->settings->where('field','referral_exists')->first()->field_title }}  @else Block Empty Referral  @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[15][default]"  <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','referral_exists')->first())
                                              && !empty($section->settings->where('field','referral_exists')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[15][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','referral_exists')->first())
                                            && !empty($section->settings->where('field','referral_exists')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[32][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','double_meta')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check"></span>
                                                Double Meta (DM)
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                                <input type="hidden" name="setting[32][field]" value="double_meta">
                                <input type="text" class="form-control" name="setting[32][field_title]" placeholder="Title"   value="@if(
                                  !empty($section->settings)
                                  && !empty($section->settings->where('field','double_meta')->first())
                                  && !empty($section->settings->where('field','double_meta')->first()->field_title)){{ $section->settings->where('field','double_meta')->first()->field_title }} @else Enable Double Meta Refresh @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[32][default]"   <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','double_meta')->first())
                                              && !empty($section->settings->where('field','double_meta')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[32][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','double_meta')->first())
                                            && !empty($section->settings->where('field','double_meta')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[33][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','timezone_check')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                TimeZone + DM
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[33][field]" value="timezone_check">
                                            <input type="text" class="form-control" name="setting[33][field_title]" placeholder="Title"   value="@if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','timezone_check')->first())
                                              && !empty($section->settings->where('field','timezone_check')->first()->field_title)){{ $section->settings->where('field','timezone_check')->first()->field_title }}  @else Enable Timezone Check (Double Meta by default) @endif">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[33][default]"   <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','timezone_check')->first())
                                              && !empty($section->settings->where('field','timezone_check')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[33][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','timezone_check')->first())
                                            && !empty($section->settings->where('field','timezone_check')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[34][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','referer_firewall')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Block Referrals
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[34][field]" value="referer_firewall">
                                            <input type="text" class="form-control" name="setting[34][field_title]" placeholder="Title"   value="@if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','referer_firewall')->first())
                                              && !empty($section->settings->where('field','referer_firewall')->first()->field_title)){{ $section->settings->where('field','referer_firewall')->first()->field_title }} @else Block Suspicious Referrals @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[34][default]"  <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','referer_firewall')->first())
                                              && !empty($section->settings->where('field','referer_firewall')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[34][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','referer_firewall')->first())
                                            && !empty($section->settings->where('field','referer_firewall')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[35][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','mobile_only')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Mobile Only
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[35][field]" value="mobile_only">
                                            <input type="text" class="form-control" name="setting[35][field_title]" placeholder="Title"   value="@if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','mobile_only')->first())
                                              && !empty($section->settings->where('field','mobile_only')->first()->field_title)){{ $section->settings->where('field','mobile_only')->first()->field_title }} @else Mobile Only Campaign @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[35][default]"  <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','mobile_only')->first())
                                              && !empty($section->settings->where('field','mobile_only')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[35][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','mobile_only')->first())
                                            && !empty($section->settings->where('field','mobile_only')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[36][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','proxified_original')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Proxify Safe Page
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[36][field]" value="proxified_original">
                                            <input type="text" class="form-control" name="setting[36][field_title]" placeholder="Title"   value="@if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','proxified_original')->first())
                                              && !empty($section->settings->where('field','proxified_original')->first()->field_title)){{ $section->settings->where('field','proxified_original')->first()->field_title }} @else Proxify Safe Page @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[36][default]"   <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','proxified_original')->first())
                                              && !empty($section->settings->where('field','proxified_original')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[36][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','proxified_original')->first())
                                            && !empty($section->settings->where('field','proxified_original')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[37][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','proxified_money')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Proxify Offer Page
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[37][field]" value="proxified_money">
                                            <input type="text" class="form-control" name="setting[37][field_title]" placeholder="Title"   value="@if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','proxified_money')->first())
                                              && !empty($section->settings->where('field','proxified_money')->first()->field_title)){{ $section->settings->where('field','proxified_money')->first()->field_title }} @else Proxify Offer Page @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[37][default]"   <?php if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','proxified_money')->first())
                                              && !empty($section->settings->where('field','proxified_money')->first()->default)
                                              )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[37][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','proxified_money')->first())
                                            && !empty($section->settings->where('field','proxified_money')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[38][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','loglink')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Enable Logs
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[38][field]" value="loglink">
                                            <input type="text" class="form-control" name="setting[38][field_title]" placeholder="Title"   value="@if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','loglink')->first())
                                              && !empty($section->settings->where('field','loglink')->first()->field_title)){{ $section->settings->where('field','loglink')->first()->field_title }}  @else Enable Logs @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                            <label>
                                              <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[38][default]"   <?php if(
                                                !empty($section->settings)
                                                && !empty($section->settings->where('field','loglink')->first())
                                                && !empty($section->settings->where('field','loglink')->first()->default)
                                                )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                              ?>
                                                     <span class="fa fa-check"></span>
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
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[38][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','loglink')->first())
                                            && !empty($section->settings->where('field','loglink')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[39][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','allowed_referers')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Allowed Referrals
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[39][field]" value="allowed_referers">
                                            <input type="text" class="form-control" name="setting[39][field_title]" placeholder="Title"   value="@if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','allowed_referers')->first())
                                              && !empty($section->settings->where('field','allowed_referers')->first()->field_title)){{ $section->settings->where('field','allowed_referers')->first()->field_title }} @else Enter referrals you want to allow like google.com, facebook.com @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[39][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','allowed_referers')->first())
                                            && !empty($section->settings->where('field','allowed_referers')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[40][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','user_agent_filter')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Block UserAgents
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[40][field]" value="user_agent_filter">
                                            <input type="text" class="form-control" name="setting[40][field_title]" placeholder="Title"   value="@if(
                                              !empty($section->settings)
                                              && !empty($section->settings->where('field','user_agent_filter')->first())
                                              && !empty($section->settings->where('field','user_agent_filter')->first()->field_title)){{ $section->settings->where('field','user_agent_filter')->first()->field_title }} @else  Enter UserAgents you want to block like BrandVerity @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[40][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','user_agent_filter')->first())
                                            && !empty($section->settings->where('field','user_agent_filter')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[41][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','extra_notes')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check">
                                                </span>
                                                Notes
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                                <input type="hidden" name="setting[41][field]" value="extra_notes">
                                <input type="text" class="form-control" name="setting[41][field_title]" placeholder="Title"   value="@if(
                                  !empty($section->settings)
                                  && !empty($section->settings->where('field','extra_notes')->first())
                                  && !empty($section->settings->where('field','extra_notes')->first()->field_title)){{ $section->settings->where('field','extra_notes')->first()->field_title }}  @else Extra Notes @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[41][is_hidden]"
                                            <?php if(
                                            !empty($section->settings)
                                            && !empty($section->settings->where('field','extra_notes')->first())
                                            && !empty($section->settings->where('field','extra_notes')->first()->is_hidden)
                                            )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                            ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[42][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','click_limit')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check"></span>
                                                Click Limit
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[42][field]" value="click_limit">
                            <input type="text" class="form-control" name="setting[42][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','click_limit')->first())
                              && !empty($section->settings->where('field','click_limit')->first()->field_title)){{ $section->settings->where('field','click_limit')->first()->field_title }} @else Click Limit @endif">
                            <div class="input-group-append">
                                 <input class="form-control" placeholder="Enter Title" type="text" value="@if(
                                 !empty($section->settings)
                                 && !empty($section->settings->where('field','click_limit')->first())
                               ){{ $section->settings->where('field','click_limit')->first()->default}}@endif" style="width: 80px;border-radius: 0;" name="setting[42][default]">
                                    <span class="input-group-text shield"> <label> Default </label></span>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[42][is_hidden]"
                                                  <?php if(
                                                  !empty($section->settings)
                                                  && !empty($section->settings->where('field','click_limit')->first())
                                                  && !empty($section->settings->where('field','click_limit')->first()->is_hidden)
                                                  )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                                  ?>
                                                  <span class="fa fa-check"></span>
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
                                          <input type="checkbox" aria-label="Enable Check Referral Existance" value="1" name="setting[43][enable]"
                                          <?php
                                            if(!empty($section->settings) && !empty($section->settings->where('field','blockipv6')->first()))
                                            echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                          ?>
                                                <span class="fa fa-check"></span>
                                                Block IP V 6
                                            </input>
                                        </label>
                                    </div>
                                </span>
                            </div>
                            <input type="hidden" name="setting[43][field]" value="blockipv6">
                            <input type="text" class="form-control" name="setting[43][field_title]" placeholder="Title"   value="@if(
                              !empty($section->settings)
                              && !empty($section->settings->where('field','blockipv6')->first())
                              && !empty($section->settings->where('field','blockipv6')->first()->field_title)){{ $section->settings->where('field','blockipv6')->first()->field_title }} @else Block IP V 6 @endif">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <div class="checkbox c-checkbox shield">
                                          <label>
                                            <input type="checkbox" aria-label="Is Hidden Field" value="1" name="setting[43][is_hidden]"
                                                  <?php if(
                                                  !empty($section->settings)
                                                  && !empty($section->settings->where('field','blockipv6')->first())
                                                  && !empty($section->settings->where('field','blockipv6')->first()->is_hidden)
                                                  )   echo 'checked= checked'; echo ' <span class="fa fa-check"></span>';
                                                  ?>
                                                  <span class="fa fa-check"></span>
                                                  Hidden
                                              </input>
                                          </label>
                                        </div>
                                    </span>
                                </div>
                            </input>
                        </div>
                        <!--- Section Part --->
                     <button class="btn btn-success btn-lg" type="submit" style="width:100%;">Update Shield</button>
                   </form>
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
