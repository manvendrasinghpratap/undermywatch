@extends('layouts.newadmintemplate')
@section('content')
  <section class="section-container">
         <!-- Page content-->
         <div class="content-wrapper">
            <div class="content-heading">
               <div>Edit Campaign: {{@$link->name}}</div><!-- START Language list-->
               <div class="ml-auto">
                 <button class="btn btn-labeled btn-success" type="button"><a href="{{route('superadmin.campaign.index')}}" class="btn-label whitetext"><i class="fa fa-plus"></i></a>List Of Campaign</button>
              </div><!-- END Language list-->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- START card-->
                    <div class="card card-default">
                        <form method="POST" action="{{ route('admin.links.linkupdate', ['link'=>$link->id]) }}">
                         {{ csrf_field() }}
                       <div class="card-body">
                         <!-- Sharing URL Begin -->
                         <div class="form-group">
                           <label>Sharing Link</label>
                           <input type="text" class="form-control" @if(!empty($link->domain))value="https://{{ $link->domain->domain ?? ''}}/{{ $link->slug }}" @endif readonly="readonly">
                         </div>

                         <!-- Sharing URL End-->
                          @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'campaign_name')->first()))
                             <div class="form-group" style="@if($link->section->settings->where('field', 'campaign_name')->first()->is_hidden) display: none; @endif">
                               <label>{{ $link->section->settings->where('field', 'campaign_name')->first()->field_title }}</label>
                               <input type="text" class="form-control" name="campaign_name" value="{{ $link->name ?? $link->section->settings->where('field', 'campaign_name')->first()->default}}" placeholder="Enter Campaign Name">
                             </div>
                          @endif
                          @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'slug')->first()))
                             <div class="form-group" style="@if($link->section->settings->where('field', 'slug')->first()->is_hidden) display: none; @endif">
                               <label>{{ $link->section->settings->where('field', 'slug')->first()->field_title }}</label>
                               <input type="text" class="form-control" name="slug" value="{{ $link->slug ?? $link->section->settings->where('field', 'slug')->first()->default}}" placeholder="Enter slug for your campaign">
                             </div>
                          @endif
                          @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'domain')->first()))
                              <div class="form-group" style="@if($link->section->settings->where('field', 'domain')->first()->is_hidden) display: none; @endif">
                                      <label style="margin:0;">{{ $link->section->settings->where('field', 'domain')->first()->field_title }}</label>
                                  <div>
                                      <select type="text" class="domains form-control" name="domain" id="select2-1">
                                        @foreach($domains as $domain)
                                            <option value="{{ $domain->id }}" @if(($link->domain->id ?? $link->section->settings->where('field', 'domain')->first()->default) == $domain->id) selected @endif>{{ $domain->domain }} @if(!empty($domain->note)) &nbsp;&nbsp;({{ $domain->note }}) @endif</option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>
                          @endif
                          @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'landing_page')->first()))
                              <div class="form-group" style="@if($link->section->settings->where('field', 'landing_page')->first()->is_hidden) display: none; @endif">
                                      <label style="margin:0;">{{ $link->section->settings->where('field', 'landing_page')->first()->field_title }}</label>
                                  <div>
                                      <select type="text" class="form-control" name="landing_page" id="select2-2">
                                          @foreach($landingpages as $lp)
                                              <option value="{{ $lp }}" @if($link->landingpage == $lp) checked @endif>{{ $lp }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                          @endif

                        @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'main_url')->first()))
                            <div class="form-group" style="@if($link->section->settings->where('field', 'main_url')->first()->is_hidden) display: none; @endif">
                                    <label style="margin:0;">{{ $link->section->settings->where('field', 'main_url')->first()->field_title }}</label>
                                <div>
                                    <input type="text" placeholder="https://safepage.com" class="form-control" name="main_url" value="{{ $link->safe_link ?? $link->section->settings->where('field', 'main_url')->first()->default }}">
                                </div>
                            </div>
                        @endif
                        @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'money_url')->first()))
                            <div class="form-group" style="@if($link->section->settings->where('field', 'money_url')->first()->is_hidden) display: none; @endif">
                                    <label style="margin:0;">{{ $link->section->settings->where('field', 'money_url')->first()->field_title }}</label>
                                <div>
                                    <input type="text" class="form-control" name="money_url" value="{{ $link->money_link ?? $link->section->settings->where('field', 'money_url')->first()->default }}" placeholder="https://offerpage.com">
                                </div>
                            </div>
                        @endif
                        @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'enable_jci')->first()))
                            <div class="form-group" style="@if($link->section->settings->where('field', 'enable_jci')->first()->is_hidden) display: none; @endif">
                                    <label style="margin:0;">{{ $link->section->settings->where('field', 'enable_jci')->first()->field_title }}</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Enter JCI Campaign Code" name="enable_jci" value="{{ $link->settings->where('setting_name', 'enable_jci')->first()->value ?? $link->section->settings->where('field', 'enable_jci')->first()->default }}">
                                </div>
                            </div>
                        @endif
                        <div class="form-group"><label>Countries</label>
                          @php $countriesData = @$link->settings->where('setting_name', 'countries')->first()->value;

                          if($countriesData!=='')
                            $countryArray = explode(',',$countriesData);
                          @endphp
                              <select class="form-control" id="select2-3" multiple="multiple" name="countries[]">
                                  <optgroup id="country-optgroup-Africa" label="Africa">
                                  <option value="DZ" @if(in_array('DZ',$countryArray)) selected=selected @endif label="Algeria">Algeria</option>
                                  <option value="AO" @if(in_array('AO',$countryArray)) selected=selected @endif  label="Angola">Angola</option>
                                  <option value="BJ" @if(in_array('BJ',$countryArray)) selected=selected @endif label="Benin">Benin</option>
                                  <option value="BW" @if(in_array('BW',$countryArray)) selected=selected @endif label="Botswana">Botswana</option>
                                  <option value="BF" @if(in_array('BF',$countryArray)) selected=selected @endif label="Burkina Faso">Burkina Faso</option>
                                  <option value="BI"  @if(in_array('BI',$countryArray)) selected=selected @endif label="Burundi">Burundi</option>
                                  <option value="CM"  @if(in_array('CM',$countryArray)) selected=selected @endif label="Cameroon">Cameroon</option>
                                  <option value="CV" @if(in_array('CV',$countryArray)) selected=selected @endif  label="Cape Verde">Cape Verde</option>
                                  <option value="CF" @if(in_array('CF',$countryArray)) selected=selected @endif  label="Central African Republic">Central African Republic</option>
                                  <option value="TD" @if(in_array('TD',$countryArray)) selected=selected @endif  label="Chad">Chad</option>
                                  <option value="KM" @if(in_array('KM',$countryArray)) selected=selected @endif  label="Comoros">Comoros</option>
                                  <option value="CG" @if(in_array('CG',$countryArray)) selected=selected @endif  label="Congo - Brazzaville">Congo - Brazzaville</option>
                                  <option value="CD"  @if(in_array('CD',$countryArray)) selected=selected @endif label="Congo - Kinshasa">Congo - Kinshasa</option>
                                  <option value="CI" @if(in_array('CI',$countryArray)) selected=selected @endif  label="Côte d’Ivoire">Côte d’Ivoire</option>
                                  <option value="DJ" @if(in_array('DJ',$countryArray)) selected=selected @endif  label="Djibouti">Djibouti</option>
                                  <option value="EG" @if(in_array('EG',$countryArray)) selected=selected @endif  label="Egypt">Egypt</option>
                                  <option value="GQ" @if(in_array('GQ',$countryArray)) selected=selected @endif  label="Equatorial Guinea">Equatorial Guinea</option>
                                  <option value="ER" @if(in_array('E',$countryArray)) selected=selected @endif  label="Eritrea">Eritrea</option>
                                  <option value="ET" @if(in_array('ET',$countryArray)) selected=selected @endif  label="Ethiopia">Ethiopia</option>
                                  <option value="GA" @if(in_array('GA',$countryArray)) selected=selected @endif  label="Gabon">Gabon</option>
                                  <option value="GM"  @if(in_array('GM',$countryArray)) selected=selected @endif label="Gambia">Gambia</option>
                                  <option value="GH"  @if(in_array('GH',$countryArray)) selected=selected @endif label="Ghana">Ghana</option>
                                  <option value="GN" @if(in_array('GN',$countryArray)) selected=selected @endif  label="Guinea">Guinea</option>
                                  <option value="GW" @if(in_array('GW',$countryArray)) selected=selected @endif  label="Guinea-Bissau">Guinea-Bissau</option>
                                  <option value="KE" @if(in_array('KE',$countryArray)) selected=selected @endif  label="Kenya">Kenya</option>
                                  <option value="LS"  @if(in_array('LS',$countryArray)) selected=selected @endif label="Lesotho">Lesotho</option>
                                  <option value="LR"  @if(in_array('LR',$countryArray)) selected=selected @endif label="Liberia">Liberia</option>
                                  <option value="LY"  @if(in_array('LY',$countryArray)) selected=selected @endif label="Libya">Libya</option>
                                  <option value="MG"  @if(in_array('MG',$countryArray)) selected=selected @endif label="Madagascar">Madagascar</option>
                                  <option value="MW"  @if(in_array('MW',$countryArray)) selected=selected @endif label="Malawi">Malawi</option>
                                  <option value="ML"  @if(in_array('ML',$countryArray)) selected=selected @endif label="Mali">Mali</option>
                                  <option value="MR" @if(in_array('MR',$countryArray)) selected=selected @endif  label="Mauritania">Mauritania</option>
                                  <option value="MU"  @if(in_array('MU',$countryArray)) selected=selected @endif label="Mauritius">Mauritius</option>
                                  <option value="YT"  @if(in_array('YT',$countryArray)) selected=selected @endif label="Mayotte">Mayotte</option>
                                  <option value="MA"  @if(in_array('MA',$countryArray)) selected=selected @endif label="Morocco">Morocco</option>
                                  <option value="MZ"  @if(in_array('MZ',$countryArray)) selected=selected @endif label="Mozambique">Mozambique</option>
                                  <option value="NA"  @if(in_array('NA',$countryArray)) selected=selected @endif label="Namibia">Namibia</option>
                                  <option value="NE" @if(in_array('NE',$countryArray)) selected=selected @endif  label="Niger">Niger</option>
                                  <option value="NG" @if(in_array('NG',$countryArray)) selected=selected @endif  label="Nigeria">Nigeria</option>
                                  <option value="RW"  @if(in_array('RW',$countryArray)) selected=selected @endif label="Rwanda">Rwanda</option>
                                  <option value="RE"  @if(in_array('RE',$countryArray)) selected=selected @endif label="Réunion">Réunion</option>
                                  <option value="SH"  @if(in_array('SH',$countryArray)) selected=selected @endif label="Saint Helena">Saint Helena</option>
                                  <option value="SN" @if(in_array('SN',$countryArray)) selected=selected @endif  label="Senegal">Senegal</option>
                                  <option value="SC"  @if(in_array('SC',$countryArray)) selected=selected @endif label="Seychelles">Seychelles</option>
                                  <option value="SL" @if(in_array('SL',$countryArray)) selected=selected @endif  label="Sierra Leone">Sierra Leone</option>
                                  <option value="SO" @if(in_array('SO',$countryArray)) selected=selected @endif  label="Somalia">Somalia</option>
                                  <option value="ZA" @if(in_array('ZA',$countryArray)) selected=selected @endif  label="South Africa">South Africa</option>
                                  <option value="SD" @if(in_array('SD',$countryArray)) selected=selected @endif  label="Sudan">Sudan</option>
                                  <option value="SZ"  @if(in_array('SZ',$countryArray)) selected=selected @endif label="Swaziland">Swaziland</option>
                                  <option value="ST"  @if(in_array('ST',$countryArray)) selected=selected @endif label="São Tomé and Príncipe">São Tomé and Príncipe</option>
                                  <option value="TZ"  @if(in_array('TZ',$countryArray)) selected=selected @endif label="Tanzania">Tanzania</option>
                                  <option value="TG"  @if(in_array('TG',$countryArray)) selected=selected @endif label="Togo">Togo</option>
                                  <option value="TN" @if(in_array('TN',$countryArray)) selected=selected @endif  label="Tunisia">Tunisia</option>
                                  <option value="UG" @if(in_array('UG',$countryArray)) selected=selected @endif  label="Uganda">Uganda</option>
                                  <option value="EH" @if(in_array('EH',$countryArray)) selected=selected @endif  label="Western Sahara">Western Sahara</option>
                                  <option value="ZM" @if(in_array('ZM',$countryArray)) selected=selected @endif  label="Zambia">Zambia</option>
                                  <option value="ZW" @if(in_array('ZW',$countryArray)) selected=selected @endif  label="Zimbabwe">Zimbabwe</option>
                                  </optgroup>
                                  <optgroup id="country-optgroup-Americas" label="Americas">
                                  <option value="AI"  @if(in_array('AI',$countryArray)) selected=selected @endif label="Anguilla">Anguilla</option>
                                  <option value="AG"  @if(in_array('AG',$countryArray)) selected=selected @endif label="Antigua and Barbuda">Antigua and Barbuda</option>
                                  <option value="AR"  @if(in_array('AR',$countryArray)) selected=selected @endif label="Argentina">Argentina</option>
                                  <option value="AW"  @if(in_array('AW',$countryArray)) selected=selected @endif label="Aruba">Aruba</option>
                                  <option value="BS"  @if(in_array('BS',$countryArray)) selected=selected @endif label="Bahamas">Bahamas</option>
                                  <option value="BB"  @if(in_array('BB',$countryArray)) selected=selected @endif label="Barbados">Barbados</option>
                                  <option value="BZ"  @if(in_array('BZ',$countryArray)) selected=selected @endif label="Belize">Belize</option>
                                  <option value="BM"  @if(in_array('BM',$countryArray)) selected=selected @endif label="Bermuda">Bermuda</option>
                                  <option value="BO"  @if(in_array('BO',$countryArray)) selected=selected @endif label="Bolivia">Bolivia</option>
                                  <option value="BR"  @if(in_array('BR',$countryArray)) selected=selected @endif label="Brazil">Brazil</option>
                                  <option value="VG"  @if(in_array('VG',$countryArray)) selected=selected @endif label="British Virgin Islands">British Virgin Islands</option>
                                  <option value="CA"  @if(in_array('CA',$countryArray)) selected=selected @endif label="Canada">Canada</option>
                                  <option value="KY"  @if(in_array('KY',$countryArray)) selected=selected @endif label="Cayman Islands">Cayman Islands</option>
                                  <option value="CL"  @if(in_array('CL',$countryArray)) selected=selected @endif label="Chile">Chile</option>
                                  <option value="CO"  @if(in_array('CO',$countryArray)) selected=selected @endif label="Colombia">Colombia</option>
                                  <option value="CR"  @if(in_array('CR',$countryArray)) selected=selected @endif label="Costa Rica">Costa Rica</option>
                                  <option value="CU"  @if(in_array('CU',$countryArray)) selected=selected @endif label="Cuba">Cuba</option>
                                  <option value="DM"  @if(in_array('DM',$countryArray)) selected=selected @endif label="Dominica">Dominica</option>
                                  <option value="DO" @if(in_array('DO',$countryArray)) selected=selected @endif  label="Dominican Republic">Dominican Republic</option>
                                  <option value="EC" @if(in_array('EC',$countryArray)) selected=selected @endif  label="Ecuador">Ecuador</option>
                                  <option value="SV" @if(in_array('SV',$countryArray)) selected=selected @endif  label="El Salvador">El Salvador</option>
                                  <option value="FK" @if(in_array('FK',$countryArray)) selected=selected @endif  label="Falkland Islands">Falkland Islands</option>
                                  <option value="GF" @if(in_array('GF',$countryArray)) selected=selected @endif  label="French Guiana">French Guiana</option>
                                  <option value="GL" @if(in_array('GL',$countryArray)) selected=selected @endif  label="Greenland">Greenland</option>
                                  <option value="GD" @if(in_array('GD',$countryArray)) selected=selected @endif  label="Grenada">Grenada</option>
                                  <option value="GP"  @if(in_array('GP',$countryArray)) selected=selected @endif label="Guadeloupe">Guadeloupe</option>
                                  <option value="GT" @if(in_array('GT',$countryArray)) selected=selected @endif  label="Guatemala">Guatemala</option>
                                  <option value="GY"  @if(in_array('GY',$countryArray)) selected=selected @endif label="Guyana">Guyana</option>
                                  <option value="HT"  @if(in_array('HT',$countryArray)) selected=selected @endif label="Haiti">Haiti</option>
                                  <option value="HN"  @if(in_array('HN',$countryArray)) selected=selected @endif label="Honduras">Honduras</option>
                                  <option value="JM"  @if(in_array('JM',$countryArray)) selected=selected @endif label="Jamaica">Jamaica</option>
                                  <option value="MQ"  @if(in_array('MQ',$countryArray)) selected=selected @endif label="Martinique">Martinique</option>
                                  <option value="MX"  @if(in_array('MX',$countryArray)) selected=selected @endif label="Mexico">Mexico</option>
                                  <option value="MS"  @if(in_array('MS',$countryArray)) selected=selected @endif label="Montserrat">Montserrat</option>
                                  <option value="AN"  @if(in_array('AN',$countryArray)) selected=selected @endif label="Netherlands Antilles">Netherlands Antilles</option>
                                  <option value="NI" @if(in_array('NI',$countryArray)) selected=selected @endif  label="Nicaragua">Nicaragua</option>
                                  <option value="PA" @if(in_array('PA',$countryArray)) selected=selected @endif  label="Panama">Panama</option>
                                  <option value="PY" @if(in_array('PY',$countryArray)) selected=selected @endif  label="Paraguay">Paraguay</option>
                                  <option value="PE" @if(in_array('PE',$countryArray)) selected=selected @endif  label="Peru">Peru</option>
                                  <option value="PR"  @if(in_array('PR',$countryArray)) selected=selected @endif label="Puerto Rico">Puerto Rico</option>
                                  <option value="BL"  @if(in_array('BL',$countryArray)) selected=selected @endif label="Saint Barthélemy">Saint Barthélemy</option>
                                  <option value="KN"  @if(in_array('KN',$countryArray)) selected=selected @endif label="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                  <option value="LC"  @if(in_array('LC',$countryArray)) selected=selected @endif label="Saint Lucia">Saint Lucia</option>
                                  <option value="MF"  @if(in_array('MF',$countryArray)) selected=selected @endif label="Saint Martin">Saint Martin</option>
                                  <option value="PM"  @if(in_array('PM',$countryArray)) selected=selected @endif label="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                  <option value="VC"  @if(in_array('VC',$countryArray)) selected=selected @endif label="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                  <option value="SR"  @if(in_array('SR',$countryArray)) selected=selected @endif label="Suriname">Suriname</option>
                                  <option value="TT"  @if(in_array('TT',$countryArray)) selected=selected @endif label="Trinidad and Tobago">Trinidad and Tobago</option>
                                  <option value="TC"  @if(in_array('TC',$countryArray)) selected=selected @endif label="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                  <option value="VI"  @if(in_array('VI',$countryArray)) selected=selected @endif label="U.S. Virgin Islands">U.S. Virgin Islands</option>
                                  <option value="US"  @if(in_array('US',$countryArray)) selected=selected @endif label="United States">United States</option>
                                  <option value="UY"  @if(in_array('UY',$countryArray)) selected=selected @endif label="Uruguay">Uruguay</option>
                                  <option value="VE"  @if(in_array('VE',$countryArray)) selected=selected @endif label="Venezuela">Venezuela</option>
                                  </optgroup>
                                  <optgroup id="country-optgroup-Asia" label="Asia">
                                  <option value="AF"  @if(in_array('AF',$countryArray)) selected=selected @endif label="Afghanistan">Afghanistan</option>
                                  <option value="AM" @if(in_array('AM',$countryArray)) selected=selected @endif  label="Armenia">Armenia</option>
                                  <option value="AZ" @if(in_array('AZ',$countryArray)) selected=selected @endif  label="Azerbaijan">Azerbaijan</option>
                                  <option value="BH" @if(in_array('BH',$countryArray)) selected=selected @endif  label="Bahrain">Bahrain</option>
                                  <option value="BD"  @if(in_array('BD',$countryArray)) selected=selected @endif label="Bangladesh">Bangladesh</option>
                                  <option value="BT"  @if(in_array('BT',$countryArray)) selected=selected @endif label="Bhutan">Bhutan</option>
                                  <option value="BN"  @if(in_array('BN',$countryArray)) selected=selected @endif label="Brunei">Brunei</option>
                                  <option value="KH"  @if(in_array('KH',$countryArray)) selected=selected @endif label="Cambodia">Cambodia</option>
                                  <option value="CN"  @if(in_array('CN',$countryArray)) selected=selected @endif label="China">China</option>
                                  <option value="CY"  @if(in_array('CY',$countryArray)) selected=selected @endif label="Cyprus">Cyprus</option>
                                  <option value="GE"  @if(in_array('GE',$countryArray)) selected=selected @endif label="Georgia">Georgia</option>
                                  <option value="HK" @if(in_array('HK',$countryArray)) selected=selected @endif  label="Hong Kong SAR China">Hong Kong SAR China</option>
                                  <option value="IN" @if(in_array('IN',$countryArray)) selected=selected @endif  label="India">India</option>
                                  <option value="ID" @if(in_array('ID',$countryArray)) selected=selected @endif  label="Indonesia">Indonesia</option>
                                  <option value="IR"  @if(in_array('IR',$countryArray)) selected=selected @endif label="Iran">Iran</option>
                                  <option value="IQ" @if(in_array('IQ',$countryArray)) selected=selected @endif  label="Iraq">Iraq</option>
                                  <option value="IL" @if(in_array('IL',$countryArray)) selected=selected @endif  label="Israel">Israel</option>
                                  <option value="JP"  @if(in_array('JP',$countryArray)) selected=selected @endif label="Japan">Japan</option>
                                  <option value="JO"  @if(in_array('JO',$countryArray)) selected=selected @endif label="Jordan">Jordan</option>
                                  <option value="KZ"  @if(in_array('KZ',$countryArray)) selected=selected @endif label="Kazakhstan">Kazakhstan</option>
                                  <option value="KW"  @if(in_array('KW',$countryArray)) selected=selected @endif label="Kuwait">Kuwait</option>
                                  <option value="KG"  @if(in_array('KG',$countryArray)) selected=selected @endif label="Kyrgyzstan">Kyrgyzstan</option>
                                  <option value="LA" @if(in_array('LA',$countryArray)) selected=selected @endif  label="Laos">Laos</option>
                                  <option value="LB" @if(in_array('LB',$countryArray)) selected=selected @endif  label="Lebanon">Lebanon</option>
                                  <option value="MO"  @if(in_array('MO',$countryArray)) selected=selected @endif label="Macau SAR China">Macau SAR China</option>
                                  <option value="MY"  @if(in_array('MY',$countryArray)) selected=selected @endif label="Malaysia">Malaysia</option>
                                  <option value="MV" @if(in_array('MV',$countryArray)) selected=selected @endif  label="Maldives">Maldives</option>
                                  <option value="MN"  @if(in_array('MN',$countryArray)) selected=selected @endif label="Mongolia">Mongolia</option>
                                  <option value="MM"  @if(in_array('MM',$countryArray)) selected=selected @endif label="Myanmar [Burma]">Myanmar [Burma]</option>
                                  <option value="NP" @if(in_array('NP',$countryArray)) selected=selected @endif  label="Nepal">Nepal</option>
                                  <option value="NT" @if(in_array('NT',$countryArray)) selected=selected @endif  label="Neutral Zone">Neutral Zone</option>
                                  <option value="KP" @if(in_array('KP',$countryArray)) selected=selected @endif  label="North Korea">North Korea</option>
                                  <option value="OM"  @if(in_array('OM',$countryArray)) selected=selected @endif label="Oman">Oman</option>
                                  <option value="PK"  @if(in_array('PK',$countryArray)) selected=selected @endif label="Pakistan">Pakistan</option>
                                  <option value="PS"  @if(in_array('PS',$countryArray)) selected=selected @endif label="Palestinian Territories">Palestinian Territories</option>
                                  <option value="YD"  @if(in_array('YD',$countryArray)) selected=selected @endif label="People's Democratic Republic of Yemen">People's Democratic Republic of Yemen</option>
                                  <option value="PH" @if(in_array('PH',$countryArray)) selected=selected @endif  label="Philippines">Philippines</option>
                                  <option value="QA" @if(in_array('QA',$countryArray)) selected=selected @endif  label="Qatar">Qatar</option>
                                  <option value="SA" @if(in_array('SA',$countryArray)) selected=selected @endif  label="Saudi Arabia">Saudi Arabia</option>
                                  <option value="SG" @if(in_array('SG',$countryArray)) selected=selected @endif  label="Singapore">Singapore</option>
                                  <option value="KR" @if(in_array('KR',$countryArray)) selected=selected @endif  label="South Korea">South Korea</option>
                                  <option value="LK" @if(in_array('LK',$countryArray)) selected=selected @endif  label="Sri Lanka">Sri Lanka</option>
                                  <option value="SY"  @if(in_array('SY',$countryArray)) selected=selected @endif label="Syria">Syria</option>
                                  <option value="TW"  @if(in_array('TW',$countryArray)) selected=selected @endif label="Taiwan">Taiwan</option>
                                  <option value="TJ"  @if(in_array('TJ',$countryArray)) selected=selected @endif label="Tajikistan">Tajikistan</option>
                                  <option value="TH"  @if(in_array('TH',$countryArray)) selected=selected @endif label="Thailand">Thailand</option>
                                  <option value="TL" @if(in_array('TL',$countryArray)) selected=selected @endif  label="Timor-Leste">Timor-Leste</option>
                                  <option value="TR" @if(in_array('TR',$countryArray)) selected=selected @endif  label="Turkey">Turkey</option>
                                  <option value="TM"  @if(in_array('TM',$countryArray)) selected=selected @endif label="Turkmenistan">Turkmenistan</option>
                                  <option value="AE"  @if(in_array('AE',$countryArray)) selected=selected @endif label="United Arab Emirates">United Arab Emirates</option>
                                  <option value="UZ"  @if(in_array('UZ',$countryArray)) selected=selected @endif label="Uzbekistan">Uzbekistan</option>
                                  <option value="VN" @if(in_array('VN',$countryArray)) selected=selected @endif  label="Vietnam">Vietnam</option>
                                  <option value="YE" @if(in_array('YE',$countryArray)) selected=selected @endif  label="Yemen">Yemen</option>
                                  </optgroup>
                                  <optgroup id="country-optgroup-Europe" label="Europe">
                                  <option value="AL"  @if(in_array('AL',$countryArray)) selected=selected @endif label="Albania">Albania</option>
                                  <option value="AD"  @if(in_array('AD',$countryArray)) selected=selected @endif label="Andorra">Andorra</option>
                                  <option value="AT"  @if(in_array('AT',$countryArray)) selected=selected @endif label="Austria">Austria</option>
                                  <option value="BY"  @if(in_array('BY',$countryArray)) selected=selected @endif label="Belarus">Belarus</option>
                                  <option value="BE"  @if(in_array('BE',$countryArray)) selected=selected @endif label="Belgium">Belgium</option>
                                  <option value="BA"  @if(in_array('BA',$countryArray)) selected=selected @endif label="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                  <option value="BG"  @if(in_array('BG',$countryArray)) selected=selected @endif label="Bulgaria">Bulgaria</option>
                                  <option value="HR"  @if(in_array('HR',$countryArray)) selected=selected @endif label="Croatia">Croatia</option>
                                  <option value="CY"  @if(in_array('CY',$countryArray)) selected=selected @endif label="Cyprus">Cyprus</option>
                                  <option value="CZ"  @if(in_array('CZ',$countryArray)) selected=selected @endif label="Czech Republic">Czech Republic</option>
                                  <option value="DK"  @if(in_array('DK',$countryArray)) selected=selected @endif label="Denmark">Denmark</option>
                                  <option value="DD"  @if(in_array('DD',$countryArray)) selected=selected @endif  label="East Germany">East Germany</option>
                                  <option value="EE"  @if(in_array('EE',$countryArray)) selected=selected @endif label="Estonia">Estonia</option>
                                  <option value="FO"  @if(in_array('FO',$countryArray)) selected=selected @endif label="Faroe Islands">Faroe Islands</option>
                                  <option value="FI" @if(in_array('FI',$countryArray)) selected=selected @endif  label="Finland">Finland</option>
                                  <option value="FR"  @if(in_array('FR',$countryArray)) selected=selected @endif label="France">France</option>
                                  <option value="DE"  @if(in_array('DE',$countryArray)) selected=selected @endif label="Germany">Germany</option>
                                  <option value="GI"  @if(in_array('GI',$countryArray)) selected=selected @endif label="Gibraltar">Gibraltar</option>
                                  <option value="GR"  @if(in_array('GR',$countryArray)) selected=selected @endif label="Greece">Greece</option>
                                  <option value="GG"  @if(in_array('GG',$countryArray)) selected=selected @endif label="Guernsey">Guernsey</option>
                                  <option value="HU"  @if(in_array('HU',$countryArray)) selected=selected @endif label="Hungary">Hungary</option>
                                  <option value="IS"  @if(in_array('IS',$countryArray)) selected=selected @endif label="Iceland">Iceland</option>
                                  <option value="IE"  @if(in_array('IE',$countryArray)) selected=selected @endif label="Ireland">Ireland</option>
                                  <option value="IM"  @if(in_array('IM',$countryArray)) selected=selected @endif label="Isle of Man">Isle of Man</option>
                                  <option value="IT"  @if(in_array('IT',$countryArray)) selected=selected @endif label="Italy">Italy</option>
                                  <option value="JE"  @if(in_array('JE',$countryArray)) selected=selected @endif label="Jersey">Jersey</option>
                                  <option value="LV"  @if(in_array('LV',$countryArray)) selected=selected @endif label="Latvia">Latvia</option>
                                  <option value="LI"  @if(in_array('LI',$countryArray)) selected=selected @endif label="Liechtenstein">Liechtenstein</option>
                                  <option value="LT"  @if(in_array('LT',$countryArray)) selected=selected @endif label="Lithuania">Lithuania</option>
                                  <option value="LU"  @if(in_array('LU',$countryArray)) selected=selected @endif label="Luxembourg">Luxembourg</option>
                                  <option value="MK"  @if(in_array('MK',$countryArray)) selected=selected @endif label="Macedonia">Macedonia</option>
                                  <option value="MT"  @if(in_array('MT',$countryArray)) selected=selected @endif label="Malta">Malta</option>
                                  <option value="FX"  @if(in_array('FX',$countryArray)) selected=selected @endif label="Metropolitan France">Metropolitan France</option>
                                  <option value="MD"  @if(in_array('MD',$countryArray)) selected=selected @endif label="Moldova">Moldova</option>
                                  <option value="MC"  @if(in_array('MC',$countryArray)) selected=selected @endif label="Monaco">Monaco</option>
                                  <option value="ME"  @if(in_array('ME',$countryArray)) selected=selected @endif label="Montenegro">Montenegro</option>
                                  <option value="NL"  @if(in_array('NL',$countryArray)) selected=selected @endif label="Netherlands">Netherlands</option>
                                  <option value="NO"  @if(in_array('NO',$countryArray)) selected=selected @endif label="Norway">Norway</option>
                                  <option value="PL"  @if(in_array('PL',$countryArray)) selected=selected @endif  label="Poland">Poland</option>
                                  <option value="PT" @if(in_array('PT',$countryArray)) selected=selected @endif  label="Portugal">Portugal</option>
                                  <option value="RO"  @if(in_array('RO',$countryArray)) selected=selected @endif label="Romania">Romania</option>
                                  <option value="RU" @if(in_array('RU',$countryArray)) selected=selected @endif  label="Russia">Russia</option>
                                  <option value="SM" @if(in_array('SM',$countryArray)) selected=selected @endif  label="San Marino">San Marino</option>
                                  <option value="RS"  @if(in_array('RS',$countryArray)) selected=selected @endif label="Serbia">Serbia</option>
                                  <option value="CS"  @if(in_array('CS',$countryArray)) selected=selected @endif label="Serbia and Montenegro">Serbia and Montenegro</option>
                                  <option value="SK"  @if(in_array('SK',$countryArray)) selected=selected @endif label="Slovakia">Slovakia</option>
                                  <option value="SI"  @if(in_array('SI',$countryArray)) selected=selected @endif label="Slovenia">Slovenia</option>
                                  <option value="ES"  @if(in_array('ES',$countryArray)) selected=selected @endif label="Spain">Spain</option>
                                  <option value="SJ"  @if(in_array('SJ',$countryArray)) selected=selected @endif label="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                  <option value="SE"  @if(in_array('SE',$countryArray)) selected=selected @endif label="Sweden">Sweden</option>
                                  <option value="CH"  @if(in_array('CH',$countryArray)) selected=selected @endif label="Switzerland">Switzerland</option>
                                  <option value="UA"  @if(in_array('UA',$countryArray)) selected=selected @endif label="Ukraine">Ukraine</option>
                                  <option value="SU"  @if(in_array('SU',$countryArray)) selected=selected @endif label="Union of Soviet Socialist Republics">Union of Soviet Socialist Republics</option>
                                  <option value="GB"  @if(in_array('GB',$countryArray)) selected=selected @endif label="United Kingdom">United Kingdom</option>
                                  <option value="VA"  @if(in_array('VA',$countryArray)) selected=selected @endif label="Vatican City">Vatican City</option>
                                  <option value="AX"  @if(in_array('AX',$countryArray)) selected=selected @endif label="Åland Islands">Åland Islands</option>
                                  </optgroup>
                                  <optgroup id="country-optgroup-Oceania" label="Oceania">
                                  <option value="AS" @if(in_array('AS',$countryArray)) selected=selected @endif  label="American Samoa">American Samoa</option>
                                  <option value="AQ"  @if(in_array('AQ',$countryArray)) selected=selected @endif label="Antarctica">Antarctica</option>
                                  <option value="AU"  @if(in_array('AU',$countryArray)) selected=selected @endif label="Australia">Australia</option>
                                  <option value="BV"  @if(in_array('BV',$countryArray)) selected=selected @endif label="Bouvet Island">Bouvet Island</option>
                                  <option value="IO"  @if(in_array('IO',$countryArray)) selected=selected @endif label="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                  <option value="CX"  @if(in_array('CX',$countryArray)) selected=selected @endif label="Christmas Island">Christmas Island</option>
                                  <option value="CC"  @if(in_array('CC',$countryArray)) selected=selected @endif label="Cocos [Keeling] Islands">Cocos [Keeling] Islands</option>
                                  <option value="CK"  @if(in_array('CK',$countryArray)) selected=selected @endif label="Cook Islands">Cook Islands</option>
                                  <option value="FJ"  @if(in_array('FJ',$countryArray)) selected=selected @endif label="Fiji">Fiji</option>
                                  <option value="PF"  @if(in_array('PF',$countryArray)) selected=selected @endif label="French Polynesia">French Polynesia</option>
                                  <option value="TF"  @if(in_array('TF',$countryArray)) selected=selected @endif label="French Southern Territories">French Southern Territories</option>
                                  <option value="GU"  @if(in_array('GU',$countryArray)) selected=selected @endif label="Guam">Guam</option>
                                  <option value="HM"  @if(in_array('HM',$countryArray)) selected=selected @endif label="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                                  <option value="KI"  @if(in_array('KI',$countryArray)) selected=selected @endif label="Kiribati">Kiribati</option>
                                  <option value="MH"  @if(in_array('MH',$countryArray)) selected=selected @endif label="Marshall Islands">Marshall Islands</option>
                                  <option value="FM"  @if(in_array('FM',$countryArray)) selected=selected @endif label="Micronesia">Micronesia</option>
                                  <option value="NR"  @if(in_array('NR',$countryArray)) selected=selected @endif label="Nauru">Nauru</option>
                                  <option value="NC"  @if(in_array('NC',$countryArray)) selected=selected @endif label="New Caledonia">New Caledonia</option>
                                  <option value="NZ"  @if(in_array('NZ',$countryArray)) selected=selected @endif label="New Zealand">New Zealand</option>
                                  <option value="NU"  @if(in_array('NU',$countryArray)) selected=selected @endif label="Niue">Niue</option>
                                  <option value="NF"  @if(in_array('NF',$countryArray)) selected=selected @endif label="Norfolk Island">Norfolk Island</option>
                                  <option value="MP"  @if(in_array('MP',$countryArray)) selected=selected @endif label="Northern Mariana Islands">Northern Mariana Islands</option>
                                  <option value="PW"  @if(in_array('PW',$countryArray)) selected=selected @endif label="Palau">Palau</option>
                                  <option value="PG"  @if(in_array('PG',$countryArray)) selected=selected @endif label="Papua New Guinea">Papua New Guinea</option>
                                  <option value="PN"  @if(in_array('PN',$countryArray)) selected=selected @endif label="Pitcairn Islands">Pitcairn Islands</option>
                                  <option value="WS"  @if(in_array('WS',$countryArray)) selected=selected @endif label="Samoa">Samoa</option>
                                  <option value="SB"  @if(in_array('SB',$countryArray)) selected=selected @endif label="Solomon Islands">Solomon Islands</option>
                                  <option value="GS"  @if(in_array('GS',$countryArray)) selected=selected @endif label="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                  <option value="TK"  @if(in_array('TK',$countryArray)) selected=selected @endif label="Tokelau">Tokelau</option>
                                  <option value="TO" @if(in_array('TO',$countryArray)) selected=selected @endif  label="Tonga">Tonga</option>
                                  <option value="TV"  @if(in_array('TV',$countryArray)) selected=selected @endif label="Tuvalu">Tuvalu</option>
                                  <option value="UM"  @if(in_array('UM',$countryArray)) selected=selected @endif label="U.S. Minor Outlying Islands">U.S. Minor Outlying Islands</option>
                                  <option value="VU"  @if(in_array('VU',$countryArray)) selected=selected @endif label="Vanuatu">Vanuatu</option>
                                  <option value="WF"  @if(in_array('WF',$countryArray)) selected=selected @endif label="Wallis and Futuna">Wallis and Futuna</option>
                                  </optgroup>
                                  </select>
                        </div>
                             <div class="form-group row">
                                <div class="col-xl-10">
                                   <div class="checkbox c-checkbox"><label><input type="checkbox" checked="true"  value= "1" id = "is_countries_blocked" name="is_countries_blocked" ><span class="fa fa-check"></span> Exclude Above Countries</label></div>
                                </div>
                             </div>
                       </div>
                    </div><!-- END card-->
                 </div>
                 <div class="col-md-6">
                    <!-- START card-->
                    <div class="card card-default">
                       <div class="card-body">
                          <div class="form-group row">
                                <div class="col-xl-10">

                                  @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'enable_firewall')->first()))
                                    <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'enable_firewall')->first()->is_hidden) display: none; @endif">
                                      <label><input type="hidden" name="enable_firewall" value="0"><input type="checkbox" value="1" name="enable_firewall" @if($link->settings->where('setting_name', 'enable_firewall')->first()->value ?? $link->section->settings->where('field', 'enable_firewall')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'enable_firewall')->first()->field_title }}</label>
                                    </div>
                                  @endif

                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'gclid_exists')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'gclid_exists')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="gclid_exists" value="0"><input type="checkbox" value="1" name="gclid_exists" @if($link->settings->where('setting_name', 'gclid_exists')->first()->value ?? $link->section->settings->where('field', 'gclid_exists')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'gclid_exists')->first()->field_title }}</label>
                                     </div>
                                   @endif

                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'unique_gclid_exists')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'unique_gclid_exists')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="unique_gclid_exists" value="0"><input type="checkbox" value="1" name="unique_gclid_exists" @if($link->settings->where('setting_name', 'unique_gclid_exists')->first()->value ?? $link->section->settings->where('field', 'unique_gclid_exists')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'unique_gclid_exists')->first()->field_title }}</label>
                                     </div>
                                   @endif

                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'bypass_whitelisted_isp')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'bypass_whitelisted_isp')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="bypass_whitelisted_isp" value="0"><input type="checkbox" value="1" name="bypass_whitelisted_isp" @if($link->settings->where('setting_name', 'bypass_whitelisted_isp')->first()->value ?? $link->section->settings->where('field', 'bypass_whitelisted_isp')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'bypass_whitelisted_isp')->first()->field_title }}</label>
                                     </div>
                                   @endif

                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'referral_exists')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'referral_exists')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="referral_exists" value="0"><input type="checkbox" value="1" name="referral_exists" @if($link->settings->where('setting_name', 'referral_exists')->first()->value ?? $link->section->settings->where('field', 'referral_exists')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'referral_exists')->first()->field_title }}</label>
                                     </div>
                                   @endif
                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'double_meta')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'double_meta')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="double_meta" value="0"><input type="checkbox" value="1" name="double_meta" @if($link->settings->where('setting_name', 'double_meta')->first()->value ?? $link->section->settings->where('field', 'double_meta')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'double_meta')->first()->field_title }}</label>
                                     </div>
                                   @endif

                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'timezone_check')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'timezone_check')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="timezone_check" value="0"><input type="checkbox" value="1" name="timezone_check" @if($link->settings->where('setting_name', 'timezone_check')->first()->value ?? $link->section->settings->where('field', 'timezone_check')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'timezone_check')->first()->field_title }}</label>
                                     </div>
                                   @endif
                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'referer_firewall')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'referer_firewall')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="referer_firewall" value="0"><input type="checkbox" value="1" name="referer_firewall" @if($link->settings->where('setting_name', 'referer_firewall')->first()->value ?? $link->section->settings->where('field', 'referer_firewall')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'referer_firewall')->first()->field_title }}</label>
                                     </div>
                                   @endif
                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'mobile_only')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'mobile_only')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="mobile_only" value="0"><input type="checkbox" value="1" name="mobile_only" @if($link->settings->where('setting_name', 'mobile_only')->first()->value ?? $link->section->settings->where('field', 'mobile_only')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'mobile_only')->first()->field_title }}</label>
                                     </div>
                                   @endif
                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'proxified_original')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'proxified_original')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="proxified_original" value="0"><input type="checkbox" value="1" name="proxified_original" @if($link->settings->where('setting_name', 'proxified_original')->first()->value ?? $link->section->settings->where('field', 'proxified_original')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'proxified_original')->first()->field_title }}</label>
                                     </div>
                                   @endif
                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'proxified_money')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'proxified_money')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="proxified_money" value="0"><input type="checkbox" value="1" name="proxified_money" @if($link->settings->where('setting_name', 'proxified_money')->first()->value ?? $link->section->settings->where('field', 'proxified_money')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'proxified_money')->first()->field_title }}</label>
                                     </div>
                                   @endif
                                   @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'loglink')->first()))
                                     <div class="checkbox c-checkbox" style="@if($link->section->settings->where('field', 'loglink')->first()->is_hidden) display: none; @endif">
                                       <label><input type="hidden" name="loglink" value="0"><input type="checkbox" value="1" name="loglink" @if($link->settings->where('setting_name', 'loglink')->first()->value ?? $link->section->settings->where('field', 'loglink')->first()->default) checked @endif><span class="fa fa-check"></span>{{ $link->section->settings->where('field', 'loglink')->first()->field_title }}</label>
                                     </div>
                                   @endif
                                </div>
                             </div>
                             @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'allowed_referers')->first()))
                                 <div class="form-group" style="@if($link->section->settings->where('field', 'allowed_referers')->first()->is_hidden) display: none; @endif">
                                         <label style="margin:0;">{{ $link->section->settings->where('field', 'allowed_referers')->first()->field_title }}</label>
                                     <div>
                                         <input type="text" class="form-control" name="allowed_referers" value="{{ $link->settings->where('setting_name', 'allowed_referers')->first()->value ?? $link->section->settings->where('field', 'allowed_referers')->first()->default }}" placeholder="Enter referrals you want to allow like google.com, facebook.com">
                                     </div>
                                 </div>
                             @endif
                             @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'user_agent_filter')->first()))
                                 <div class="form-group" style="@if($link->section->settings->where('field', 'user_agent_filter')->first()->is_hidden) display: none; @endif">
                                         <label style="margin:0;">{{ $link->section->settings->where('field', 'user_agent_filter')->first()->field_title }}</label>
                                     <div>
                                         <input type="text" class="form-control" name="user_agent_filter" value="{{ $link->settings->where('setting_name', 'user_agent_filter')->first()->value ?? $link->section->settings->where('field', 'user_agent_filter')->first()->default }}" placeholder="Enter UserAgents you want to block like BrandVerit">
                                     </div>
                                 </div>
                             @endif
                             @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'click_limit')->first()))
                                 <div class="input-group" style="margin-bottom:15px; @if($link->section->settings->where('field', 'click_limit')->first()->is_hidden) display: none; @endif">
                                   <div class="input-group-prepend"><span class="input-group-text">{{ $link->section->settings->where('field', 'click_limit')->first()->field_title }}</span></div>
                                   <input type="text" aria-label="Click Limit" placeholder="Click Limit" class="form-control" name="click_limit" value="{{ $link->click_limit ?? $link->section->settings->where('field', 'click_limit')->first()->default }}">

                                 </div>
                             @endif
                             @if(!empty($link->section->settings) && !empty($link->section->settings->where('field', 'extra_notes')->first()))
                                 <div class="input-group" style="margin-bottom:15px; @if($link->section->settings->where('field', 'extra_notes')->first()->is_hidden) display: none; @endif">
                                   <div class="input-group-prepend"><span class="input-group-text">{{ $link->section->settings->where('field', 'extra_notes')->first()->field_title }}</span></div>
                                   <input type="text" aria-label="Extra Notes" placeholder="Extra Notes" class="form-control" name="extra_notes" value="{{ $link->notes ?? $link->section->settings->where('field', 'extra_notes')->first()->default }}">

                                 </div>
                             @endif
                          <button class="btn btn-success btn-lg" type="submit" style="width:100%;">Update Campaign</button>
                       </div>
                     </form>
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
    $('#is_countries_blocked').change(function(){
     if($(this).attr('checked')){
          $(this).val('1');
     }else{
          $(this).val('0');
     }
});
</script>
@endsection
