<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route::get('/test', "SnapAppController@test")->name('test');
/*\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    echo'<pre>';
    var_dump($query->sql);
    var_dump($query->bindings);
    var_dump($query->time);
    echo'</pre>';
});
*/
/*User route start 12 march 2019 */




Route::prefix('user')->group(function () {
	//die('aaaa');
	Auth::routes();

	// Route::get('/test', "Admin\AdminController@test")->name('admin.test');
	Route::get('/', 'User\AdminController@home')->name('user.home');
	Route::get('/dashboard', 'User\AdminController@home')->name('home');

	Route::get('/domains', 'User\DomainController@index')->name('user.domains.index');
	Route::post('/domains', 'User\DomainController@create')->name('user.domains.create');
	// Route::post('/domains/{domain}', 'Admin\DomainController@update')->name('admin.domains.update');
	Route::post('/domains/{domain}/delete', 'User\DomainController@delete')->name('user.domains.delete');
	Route::post('/domains/{domain}', 'User\DomainController@update')->name('user.domains.update');
	Route::post('/domains/{domain}/logenable', 'User\DomainController@enable_log')->name('user.domains.enablelog');
	Route::post('/domains/{domain}/logdisable', 'User\DomainController@disable_log')->name('user.domains.disablelog');

	Route::get('/sections', 'User\SectionController@index')->name('user.sections.index');
	Route::get('/section/{section}', 'User\SectionController@section')->name('user.sections.section');
	// Route::get('/section/{section}/newlink', 'Admin\SectionController@newlink')->name('admin.section.new-link');
	Route::post('/section/{section}', 'User\SectionController@createlink')->name('user.links.createnewlink');
	Route::get('/link/{link}', 'User\SectionController@link')->name('user.links.link');
	Route::post('/link/{link}', 'User\SectionController@linkupdate')->name('user.links.linkupdate');
	Route::post('/link/{link}/delete', 'User\SectionController@linkdelete')->name('user.links.linkdelete');
	Route::get('/link/{link}/scrape', 'User\SectionController@linkscrape')->name('user.links.linkscrape');

	Route::get('/firewall/isps', 'User\FirewallController@isps')->name('user.firewall.isps');
	Route::post('/firewall/isps', 'User\FirewallController@addisp')->name('user.firewall.addisp');
	Route::post('/firewall/isp/{isp}/delete', 'User\FirewallController@deleteisp')->name('user.firewall.deleteisp');

	Route::get('/firewall/ips', 'User\FirewallController@ips')->name('user.firewall.ips');
	Route::post('/firewall/ips', 'User\FirewallController@addips')->name('user.firewall.addips');
	Route::post('/firewall/ip/{ip}/delete', 'User\FirewallController@deleteip')->name('user.firewall.deleteip');
	Route::post('/firewall/ip/{ip}/permanent', 'User\FirewallController@blockpermanent')->name('user.firewall.blockpermanent');
	Route::post('/firewall/ip/{ip}/temporary', 'User\FirewallController@blocktemporary')->name('user.firewall.blocktemporary');



	Route::get('/link/{link}/logs', 'User\LogController@linklogs')->name('user.logs.link');
	Route::get('/domain/{domain}/logs', 'User\LogController@domainlogs')->name('user.logs.domain');
	Route::get('/showlog', 'User\LogController@showlogs')->name('user.logs.show');
	Route::get('/deletelog', 'User\LogController@deletelog')->name('user.logs.delete');

		/*Code on 12 MArch 2019 End*/
  Route::get('/userstats', 'SuperAdmin\StatsController@userstats')->name('user.stats.userstats')->middleware('user');
	  Route::get('/downloadcsv/', 'User\LogController@downloadcsv')->name('user.logs.downloadcsv');

});


/*User route start 12 march 2019  ends*/




Route::prefix('admin')->group(function () {
	Auth::routes();
	// Route::get('/test', "Admin\AdminController@test")->name('admin.test');
	Route::get('/', 'Admin\AdminController@admindashboard')->name('admin.home');
	Route::get('/dashboard', 'Admin\AdminController@home')->name('home');
	Route::get('/admindashboard', 'Admin\AdminController@admindashboard')->name('admindashboard');
	Route::get('/domains', 'Admin\DomainController@index')->name('admin.domains.index');
	Route::post('/domains', 'Admin\DomainController@create')->name('admin.domains.create');
	// Route::post('/domains/{domain}', 'Admin\DomainController@update')->name('admin.domains.update');
	Route::post('/domains/{domain}/delete', 'Admin\DomainController@delete')->name('admin.domains.delete');
	Route::post('/domains/{domain}', 'Admin\DomainController@update')->name('admin.domains.update');
	Route::post('/domains/{domain}/logenable', 'Admin\DomainController@enable_log')->name('admin.domains.enablelog');
	Route::post('/domains/{domain}/logdisable', 'Admin\DomainController@disable_log')->name('admin.domains.disablelog');

	Route::get('/sections', 'Admin\SectionController@index')->name('admin.sections.index');
	Route::get('/section/{section}', 'Admin\SectionController@section')->name('admin.sections.section');
	// Route::get('/section/{section}/newlink', 'Admin\SectionController@newlink')->name('admin.section.new-link');
	Route::post('/section/{section}', 'Admin\SectionController@createlink')->name('admin.links.createlink');
	Route::get('/link/{link}', 'Admin\SectionController@link')->name('admin.links.link');
	Route::post('/link/{link}', 'Admin\SectionController@linkupdate')->name('admin.links.linkupdate');
	Route::post('/link/{link}/delete', 'Admin\SectionController@linkdelete')->name('admin.links.linkdelete');
	Route::get('/link/{link}/scrape', 'Admin\SectionController@linkscrape')->name('admin.links.linkscrape');

	Route::get('/firewall/isps', 'Admin\FirewallController@isps')->name('admin.firewall.isps');
	Route::post('/firewall/isps', 'Admin\FirewallController@addisp')->name('admin.firewall.addisp');
	Route::post('/firewall/isp/{isp}/delete', 'Admin\FirewallController@deleteisp')->name('admin.firewall.deleteisp');

	Route::get('/firewall/whiteisps', 'Admin\FirewallController@whiteisps')->name('admin.firewall.whiteisps');
	Route::post('/firewall/whiteisps', 'Admin\FirewallController@addwhiteisps')->name('admin.firewall.addwhiteisps');
	Route::post('/firewall/whiteisps/{whiteisp}/delete', 'Admin\FirewallController@deletewhiteisp')->name('admin.firewall.deletewhiteisp');

	Route::get('/firewall/ips', 'Admin\FirewallController@ips')->name('admin.firewall.ips');
	Route::post('/firewall/ips', 'Admin\FirewallController@addips')->name('admin.firewall.addips');
	Route::post('/firewall/ip/{ip}/delete', 'Admin\FirewallController@deleteip')->name('admin.firewall.deleteip');
	Route::post('/firewall/ip/{ip}/permanent', 'Admin\FirewallController@blockpermanent')->name('admin.firewall.blockpermanent');
	Route::post('/firewall/ip/{ip}/temporary', 'Admin\FirewallController@blocktemporary')->name('admin.firewall.blocktemporary');

	/*Firewall block range Begins*/
	Route::post('/firewall/ip/{ip}/blockrange', 'Admin\FirewallController@blockrange')->name('admin.firewall.blockrange');
	Route::post('/firewall/ip/{ip}/blockisp', 'Admin\FirewallController@blockisp')->name('admin.firewall.blockisp');
	/*Firewall block range Ends*/



	Route::get('/link/{link}/logs', 'Admin\LogController@linklogs')->name('admin.logs.link');
	Route::get('/domain/{domain}/logs', 'Admin\LogController@domainlogs')->name('admin.logs.domain');
	Route::get('/showlog', 'Admin\LogController@showlogs')->name('admin.logs.show');
	Route::get('/deletelog', 'Admin\LogController@deletelog')->name('admin.logs.delete');
    /* this code is written on 26 Feb 2019 begin */
	Route::get('/stats', 'SuperAdmin\StatsController@index')->name('admin.stats.index')->middleware('superadmin');
	Route::get('/companystats', 'SuperAdmin\StatsController@companystats')->name('admin.stats.companystats')->middleware('admin');
	Route::get('/companystatssuperadmin/{companyId}', 'SuperAdmin\StatsController@companystatssuperadmin')->name('admin.stats.companystatssuperadmin')->middleware('superadmin');
	Route::get('/userstatsByUserId/{userId}', 'SuperAdmin\StatsController@userstatsByUserId')->name('admin.stats.userstatsByUserId')->middleware('superadmin');
	Route::get('/userstatsUserId/{userId}', 'SuperAdmin\StatsController@userstatsUserId')->name('admin.stats.userstatsUserId')->middleware('admin');

      /* this code is written on 26 Feb 2019 end */

	/* this code is written on 26 Feb 2019 begin */
  Route::get('/downloadcsv/', 'Admin\LogController@downloadcsv')->name('admin.logs.downloadcsv');
    /* this code is written on 26 Feb 2019 end */

		/*Code on 12 MArch 2019 Begin*/
	Route::get('/users', 'Admin\AdminController@index')->name('admin.users.index');
	Route::get('/users/create', 'Admin\AdminController@create')->name('admin.users.create');
	Route::post('/users/store', 'Admin\AdminController@store')->name('admin.users.store');
	Route::post('/users/destroy/{id}', 'Admin\AdminController@destroy')->name('admin.users.destroy');
		/*Code on 12 MArch 2019 End*/
		/*Code On 13 March 2019 Begin Section */
		Route::get('/company/assignedsection', 'Admin\AdminController@assignedsection')->name('admin.company.assignedsection');
		/*Code On 13 March 2019 end Section */
		Route::get('/user/{user}', 'Admin\UsersManager@singleuser')->name('admin.assignsection.user');
		Route::post('/user/{user}/section', 'Admin\UsersManager@section')->name('admin.assignsection.users.section');


		Route::get('usersetting/profile/{userid}','Admin\UsersettingController@index')->name('admin.usersetting.user');
		Route::get('usersetting/campaign/{userid}','Admin\UsersettingController@campaign')->name('admin.usersetting.campaign');
		Route::post('usersetting/updateprofile/{userid}','Admin\UsersettingController@updateprofile')->name('admin.usersetting.updateprofile');
		Route::post('usersetting/deleteUserSection/{sectionId}','Admin\UsersettingController@deleteUserSection')->name('admin.usersetting.deleteUserSection');
		Route::post('usersetting/assignUserSection/{sectionId}','Admin\UsersettingController@assignUserSection')->name('admin.usersetting.assignUserSection');

});

Route::prefix('superadmin')->group(function () {
	Route::get('/', 'Admin\AdminController@home')->name('superadmin.home');
	Route::get('/dashboard', 'Admin\AdminController@home')->name('home');;
	Route::get('/sections', 'SuperAdmin\SectionController@index')->name('superadmin.sections.index');
	Route::get('/sections/new', 'SuperAdmin\SectionController@new')->name('superadmin.sections.new');
	Route::post('/sections', 'SuperAdmin\SectionController@create')->name('superadmin.sections.create');
	Route::get('/section/{section}', 'SuperAdmin\SectionController@section')->name('superadmin.sections.section');
	Route::post('/section/{section}', 'SuperAdmin\SectionController@update')->name('superadmin.sections.update');
	Route::post('/section/{section}/delete', 'SuperAdmin\SectionController@delete')->name('superadmin.sections.delete');
	Route::get('/section/{section}/users', 'SuperAdmin\SectionController@users')->name('superadmin.sections.users');
	Route::post('/section/{section}/users', 'SuperAdmin\SectionController@updateusers')->name('superadmin.sections.users');

	Route::get('/users', 'SuperAdmin\UsersManager@index')->name('superadmin.users.index');
	Route::get('/user/{user}', 'SuperAdmin\UsersManager@singleuser')->name('superadmin.users.user');
	Route::post('/user/{user}/section', 'SuperAdmin\UsersManager@section')->name('superadmin.users.section');
	Route::post('/user/{user}/status', 'SuperAdmin\UsersManager@activatedeactivate')->name('superadmin.users.status');



	/* Code done on 11 march 2019 by Manvendra begin*/

	Route::get('/company', 'SuperAdmin\CompanyController@index')->name('superadmin.company.index');
	Route::get('/company/create', 'SuperAdmin\CompanyController@create')->name('superadmin.company.create');
	Route::post('/company/store', 'SuperAdmin\CompanyController@store')->name('superadmin.company.store');
	Route::get('/company/edit/{id}', 'SuperAdmin\CompanyController@edit')->name('superadmin.company.edit');
	Route::post('/company/edit/{id}', 'SuperAdmin\CompanyController@edit')->name('superadmin.company.edit');

	Route::post('/company/update/{id}', 'SuperAdmin\CompanyController@update')->name('superadmin.company.update');
	Route::post('/company/delete/{id}', 'SuperAdmin\CompanyController@destroy')->name('superadmin.company.delete');
	Route::post('/company/changecompanystatus', 'SuperAdmin\CompanyController@changecompanystatus')->name('superadmin.company.changecompanystatus');
	/* Code done on 11 march 2019 by Manvendra end*/

	/* Code done on 12 march 2019 by Manvendra begin*/
	Route::get('/company/users', 'SuperAdmin\CompanyController@index')->name('superadmin.company.users');
	Route::get('/company/addNewUser', 'SuperAdmin\CompanyController@addNewUser')->name('superadmin.company.addNewUser');
	Route::post('/company/saveNewUser', 'SuperAdmin\CompanyController@saveNewUser')->name('superadmin.company.saveNewUser');

	Route::get('/company/edituser/{user}', 'SuperAdmin\CompanyController@editsingleuser')->name('superadmin.company.edituser');
	Route::post('/company/updateUser', 'SuperAdmin\CompanyController@updateUser')->name('superadmin.company.updateUser');


			/* Code done on 12 march 2019 by Manvendra End*/

	/* Code done on 13 march 2019 by Manvendra begin*/
	Route::get('/company/section', 'SuperAdmin\CompaniesSectionController@index')->name('superadmin.company.section');
	//Route::post('/company/saveNewUser', 'SuperAdmin\CompaniesSectionController@saveNewUser')->name('superadmin.company.saveNewUser');
			/* Code done on 12 march 2019 by Manvendra End*/
	/*Add Companies and section begin*/
	Route::get('/company/section/create/{id}', 'SuperAdmin\CompaniesSectionController@create')->name('superadmin.company.section.create');
	Route::post('/companysection/{company}/section', 'SuperAdmin\CompaniesSectionController@section')->name('superadmin.companysection.section');
	Route::post('companysetting/deleteCompanySection/{sectionId}','SuperAdmin\CompaniesSectionController@deletecompanysection')->name('superadmin.companysetting.deleteCompanySection');
	Route::post('companysetting/assigncompanysection/{sectionId}','SuperAdmin\CompaniesSectionController@assigncompanysection')->name('superadmin.companysetting.assigncompanysection');
	Route::get('companysetting/campaign/{companyId}','SuperAdmin\CompaniesSectionController@campaign')->name('superadmin.companiescection.campaign');
	/*Add Companies and section End*/

	/*Support and Guide Routes start */
	Route::get('/support/index','SupportController@index')->name('superadmin.support.index')->middleware('superadmin');
	Route::get('/guide/index','GuideController@index')->name('superadmin.guide.index')->middleware('superadmin');
	Route::get('/affiliates/index','SuperAdmin\AffiliateController@index')->name('superadmin.affiliates.index')->middleware('superadmin');
	/*Support and Guide Routes end */
	Route::get('campaigns','CampaignController@index')->name('superadmin.campaign.index')->middleware('superadmin');
	Route::get('campaign/create','CampaignController@create')->name('superadmin.campaign.create');
	Route::post('campaign/store','CampaignController@store')->name('superadmin.campaign.store');

	/* Superadmin changes individual user details begin */

	Route::get('usersetting/profile/{userid}','SuperAdmin\UsersettingController@index')->name('superadmin.usersetting.user');
	Route::get('usersetting/campaign/{userid}','SuperAdmin\UsersettingController@campaign')->name('superadmin.usersetting.campaign');
	Route::post('usersetting/updateprofile/{userid}','SuperAdmin\UsersettingController@updateprofile')->name('superadmin.usersetting.updateprofile');
	Route::post('usersetting/deleteUserSection/{sectionId}','SuperAdmin\UsersettingController@deleteUserSection')->name('superadmin.usersetting.deleteUserSection');
	Route::post('usersetting/assignUserSection/{sectionId}','SuperAdmin\UsersettingController@assignUserSection')->name('superadmin.usersetting.assignUserSection');
		//Route::get('/user/{user}', 'SuperAdmin\UsersManager@singleuser')->name('superadmin.users.user');


	/* Superadmin changes individual user details End */
});

Route::get('ajax/destroy/{name}/{id}/{deletetype}','AjaxController@destroy');
Route::get('ajax/destroyByCustomColumn/{name}/{id}/{columnName}','AjaxController@destroyByCustomColumn');
Route::post('ajax/changepassword','AjaxController@changepassword')->name('changepassword');
Route::post('ajax/changeuserlevel','AjaxController@changeuserlevel')->name('changeuserlevel');
Route::post('ajax/changeuserstatus','AjaxController@changeuserstatus')->name('changeuserstatus');

Route::get('/{link}', "SnapAppController@direct")->name('link');
Route::get('/', "SnapAppController@root")->name('root');
Route::post('redirect/out', "SnapAppController@redirector")->name('redirector');
Route::get('/path/restricted', 'RestrictController@index')->name('restricted');
