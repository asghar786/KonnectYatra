<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\IternaryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminLogoutController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\GurdwaraController;
use App\Http\Controllers\Admin\PackagesController;
use App\Http\Controllers\AdminVisaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PackagesController as UserPackages;
use App\Http\Controllers\VisaController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserVisaController;
use App\Http\Controllers\UserPakagesController;
use App\Http\Controllers\CreateStudentController;
use App\Http\Controllers\ItenariesController;
use App\Http\Controllers\ItenaryTicketDetailsController;
use App\Http\Controllers\PassportNicopController;
use App\Http\Controllers\PassportInfoController;
use App\Http\Controllers\Admin\AccountingController;
use App\Http\Controllers\Admin\BalanceController;
use App\Http\Controllers\Admin\ChargesController;
use App\Http\Controllers\Admin\PageBannerController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\IntegrationController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SubscriberController;
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
Route::get('/',[HomeController::class, 'index'])->name('index');
Auth::routes();

// Route::view('/test', 'test');
Route::get('/our-info',[HomeController::class, 'our_info'])->name('our_info');
Route::get('/home',[HomeController::class,'index'])->name('home');
Route::get('/visa-form',[HomeController::class,'visa_form'])->name('visa-form');
Route::get('/gurdwaras',[HomeController::class,'gurdwaras'])->name('gurdwaras');
Route::get('/visa',[VisaController::class, 'index'])->name('visa');
Route::get('/contactus',[ContactUsController::class, 'index'])->name('contactus');
Route::post('/contactus',[ContactUsController::class, 'index'])->name('contactus');
Route::get('/aboutus',[AboutUsController::class, 'index'])->name('aboutus');
Route::get('/itinerary',[IternaryController::class, 'index'])->name('itinerary');
Route::post('itinerary',[IternaryController::class, 'store']);
Route::get('/login', [HomeController::class, 'showLoginForm'])->name('login');
Route::post('/login', [HomeController::class, 'showLoginForm']);
Route::get('/register', [HomeController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [HomeController::class, 'showRegisterForm']);
Route::get('/logout', [LogoutController::class, 'Logout'])->name('user_logout');
Route::get('/packages/{id}',[UserPackages::class, 'index'])->name('packages');
Route::get('/packages/apply/{id}',[UserPackages::class, 'apply'])->name('apply');
Route::post('/store-yatri-visa',[UserPackages::class,'store_yatri_visa'])->name('store-yatri-visa');
Route::post('/store-special-package',[UserPackages::class,'store_special_package'])->name('store-special-package');
Route::post('/save-initial-info',[UserPackages::class,'save_initial_info'])->name('save-initial-info');

Route::get('/all-packages',[UserPackages::class, 'all_package'])->name('all_package');
Route::get('/agreement/{id}',[UserPackages::class, 'agreement'])->name('agreement');
Route::get('/all-packages/{id}',[UserPackages::class, 'package'])->name('package');
Route::get('/all-packages/{id}/apply',[UserPackages::class, 'package_apply'])->name('package-apply');
Route::get('/special-package',[UserPackages::class, 'specialPackage'])->name('special-package');
Route::get('/special-package/{id}/apply',[UserPackages::class, 'bookSpecialPackage'])->name('book-special-package');
Route::get('/all-packages/payment/{id}',[UserPackages::class, 'payment'])->name('payment');
Route::post('/all-packages/payment/{id}',[UserPackages::class, 'payment'])->name('payment');
Route::get('/our-info',[HomeController::class, 'our_info'])->name('our-info');
Route::get('/thank-you',[UserPackages::class, 'thank_you'])->name('thank-you');


Route::get('/hotel-detail/{id}', [UserPackages::class, 'hotel_detail'])->name('hotel_detail');
Route::get('/location-detail/{id}', [UserPackages::class, 'location_detail'])->name('location_detail');
Route::get('/event-detail/{id}', [UserPackages::class, 'event_detail'])->name('event_detail');
Route::get('/news-detail/{id}', [UserPackages::class, 'news_detail'])->name('news_detail');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog_detail');

Route::post('/save-info', [UserPackages::class, 'save_info'])->name('save_info');

// Newsletter subscription (public)
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

// Admin Part //
Route::get('/admin_login',[AdminLoginController::class, 'index'])->name('admin_login');
Route::post('/admin_login',[AdminLoginController::class, 'store']);
Route::get('/admin_logout',[AdminLogoutController::class, 'index'])->name('admin_logout');
// Route::get('/admin_register',[AdminRegisterController::class, 'index'])->name('admin_register');
// Route::post('/admin_register',[AdminRegisterController::class, 'store']);
Route::group(['middleware'=>'prevent-back-history'],function(){

Route::group(['prefix' => 'admin',
'middleware' => ['admin']
], function(){
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin_gurdwara',[GurdwaraController::class, 'index'])->name('admin_gurdwara');
    Route::get('/admin_gurdwaras',[GurdwaraController::class, 'gurdwaras'])->name('admin_gurdwaras');
    Route::get('/undertaking',[GurdwaraController::class, 'undertaking'])->name('undertaking');
    Route::post('admin_gurdwara',[GurdwaraController::class, 'store']);
    Route::get('/create_gurdwara',[GurdwaraController::class, 'create_gurdwara'])->name('create-gurdwara');
    Route::get('/admin_gurdwara/{id}',[GurdwaraController::class, 'gurdwara_delete'])->name('delete-gurdwara');
    Route::get('/edit_gurdwara/{id}',[GurdwaraController::class, 'edit_gurdwara'])->name('edit-gurdwara');
    Route::post('/update_gurdwara/{id}',[GurdwaraController::class, 'update_gurdwara'])->name('update-gurdwara');
    Route::get('/apply_packages',[PackagesController::class, 'index'])->name('apply_packages');
    Route::get('/apply_packages/create',[PackagesController::class, 'create'])->name('create_packages');
    Route::post('/apply_packages/create',[PackagesController::class, 'create'])->name('create_packages');
    Route::get('/apply_packages/edit/{id}',[PackagesController::class, 'edit'])->name('edit_packages');
    Route::post('/apply_packages/edit/{id}',[PackagesController::class, 'edit'])->name('edit_packages');
    Route::get('/apply_packages/delete/{id}',[PackagesController::class, 'delete'])->name('apply-package-delete');
    Route::post('/apply_packages',[PackagesController::class, 'store']);
    Route::get('/yatri-visa',[PackagesController::class, 'yatri_visa'])->name('yatri-visa');
    Route::get('/yatri-visa-delete/{id}',[PackagesController::class, 'delete_yatri'])->name('yatri-visa-delete');
    Route::get('/yatri-visa-edit/{id}',[PackagesController::class, 'edit_yatri_visa'])->name('yatri-visa-edit');
    Route::get('/yatri-visa-view/{id}',[PackagesController::class, 'view_yatri_visa'])->name('yatri-visa-view');
    Route::get('/yatri-package-edit/{id}',[PackagesController::class, 'edit_yatri_package']);
    Route::post('/yatri-visa-update/{id}',[PackagesController::class, 'yatri_visa_update'])->name('yatri_visa_update');
    Route::get('/reports',[PackagesController::class, 'passenger_list'])->name('reports');
    Route::get('/users',[PackagesController::class, 'users'])->name('users');
    Route::get('/users/delete/{id}',[PackagesController::class, 'delete_users'])->name('delete-users');

    Route::get('/payment/{id}',[PackagesController::class, 'payment'])->name('admin_payment');
    Route::post('/payment/{id}',[PackagesController::class, 'payment'])->name('admin_payment');

    Route::get('/add-remarks/{id}',[PackagesController::class, 'add_remarks'])->name('add-remarks');
    Route::post('/add-remarks/{id}',[PackagesController::class, 'add_remarks'])->name('add-remarks');

    Route::get('/news',[PackagesController::class, 'news'])->name('news');
    Route::get('/news/create',[PackagesController::class, 'create_news'])->name('create_news');
    Route::post('/news/create',[PackagesController::class, 'create_news'])->name('create_news');
    Route::get('/news/edit/{id}',[PackagesController::class, 'edit_news'])->name('edit_news');
    Route::post('/news/edit/{id}',[PackagesController::class, 'edit_news'])->name('edit_news');
    Route::get('/news/delete/{id}',[PackagesController::class, 'delete_news'])->name('delete_news');

    // Analytics
    Route::get('/analytics',[AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/realtime',[AnalyticsController::class, 'realtime'])->name('analytics_realtime');
    Route::get('/analytics/export',[AnalyticsController::class, 'export'])->name('analytics_export');

    // Integrations (GA4 etc.)
    Route::get('/integrations',[IntegrationController::class, 'index'])->name('integrations');
    Route::post('/integrations',[IntegrationController::class, 'update'])->name('integrations_update');

    // Newsletter subscribers
    Route::get('/subscribers',[SubscriberController::class, 'index'])->name('subscribers');
    Route::get('/subscribers/delete/{id}',[SubscriberController::class, 'destroy'])->name('subscribers_delete');

    // Page banners
    Route::get('/page-banners',[PageBannerController::class, 'index'])->name('page_banners');
    Route::post('/page-banners/{id}',[PageBannerController::class, 'update'])->name('page_banners_update');

    // Blogs
    Route::get('/blogs',[AdminBlogController::class, 'index'])->name('blogs_admin');
    Route::get('/blogs/create',[AdminBlogController::class, 'create'])->name('create_blog');
    Route::post('/blogs/create',[AdminBlogController::class, 'create']);
    Route::get('/blogs/edit/{id}',[AdminBlogController::class, 'edit'])->name('edit_blog');
    Route::post('/blogs/edit/{id}',[AdminBlogController::class, 'edit']);
    Route::get('/blogs/delete/{id}',[AdminBlogController::class, 'delete'])->name('delete_blog');

    Route::get('/ids',[PackagesController::class, 'ids'])->name('ids');
    Route::get('/ids/create',[PackagesController::class, 'create_ids'])->name('create_ids');
    Route::post('/ids/create',[PackagesController::class, 'create_ids'])->name('create_ids');
    Route::get('/ids/edit/{id}',[PackagesController::class, 'edit_ids'])->name('edit_ids');
    Route::post('/ids/edit/{id}',[PackagesController::class, 'update_ids'])->name('edit_ids');
    Route::get('/ids/delete/{id}',[PackagesController::class, 'delete_ids'])->name('delete_ids');

    Route::get('/yatri-id/{id}',[PackagesController::class, 'yatri_id'])->name('yatri_id');
    Route::get('/back-view',[PackagesController::class, 'back_view'])->name('back_view');
    Route::view('/admin-id', 'admin.ids.admin_id')->name('admin_id');
    Route::get('/admin-back-view', [PackagesController::class, 'admin_back_view'])->name('admin_back_view');

    Route::get('/events',[PackagesController::class, 'events'])->name('events');
    Route::get('/events/create',[PackagesController::class, 'create_events'])->name('create_events');
    Route::post('/events/create',[PackagesController::class, 'create_events'])->name('create_events');
    Route::get('/events/edit/{id}',[PackagesController::class, 'edit_events'])->name('edit_events');
    Route::post('/events/edit/{id}',[PackagesController::class, 'edit_events'])->name('edit_events');
    Route::get('/events/delete/{id}',[PackagesController::class, 'delete_events'])->name('delete_events');

    Route::get('/hotels',[PackagesController::class, 'hotels'])->name('hotels');
    Route::get('/hotels/create',[PackagesController::class, 'create_hotels'])->name('create_hotels');
    Route::post('/hotels/create',[PackagesController::class, 'create_hotels'])->name('create_hotels');
    Route::get('/hotels/edit/{id}',[PackagesController::class, 'edit_hotels'])->name('edit_hotels');
    Route::post('/hotels/edit/{id}',[PackagesController::class, 'edit_hotels'])->name('edit_hotels');
    Route::get('/hotels/delete/{id}',[PackagesController::class, 'delete_hotels'])->name('delete_hotels');

    Route::get('/bus',[PackagesController::class, 'bus'])->name('bus');
    Route::get('/bus/create',[PackagesController::class, 'create_bus'])->name('create_bus');
    Route::post('/bus/create',[PackagesController::class, 'create_bus'])->name('create_bus');
    Route::get('/bus/edit/{id}',[PackagesController::class, 'edit_bus'])->name('edit_bus');
    Route::post('/bus/edit/{id}',[PackagesController::class, 'edit_bus'])->name('edit_bus');
    Route::get('/bus/delete/{id}',[PackagesController::class, 'delete_bus'])->name('delete_bus');

    Route::get('/seasons',[PackagesController::class, 'seasons'])->name('seasons');
    Route::get('/seasons/create',[PackagesController::class, 'create_seasons'])->name('create_seasons');
    Route::post('/seasons/create',[PackagesController::class, 'create_seasons'])->name('create_seasons');
    Route::get('/seasons/edit/{id}',[PackagesController::class, 'edit_seasons'])->name('edit_seasons');
    Route::post('/seasons/edit/{id}',[PackagesController::class, 'edit_seasons'])->name('edit_seasons');
    Route::get('/seasons/delete/{id}',[PackagesController::class, 'delete_seasons'])->name('delete_seasons');

    Route::get('/staff_ids/{id}',[PackagesController::class, 'staff_ids'])->name('staff_ids');

    Route::get('/gallery',[PackagesController::class, 'gallery'])->name('gallery');
    Route::get('/gallery/create',[PackagesController::class, 'create_gallery'])->name('create_gallery');
    Route::post('/gallery/create',[PackagesController::class, 'create_gallery'])->name('create_gallery');
    Route::get('/gallery/edit/{id}',[PackagesController::class, 'edit_gallery'])->name('edit_gallery');
    Route::post('/gallery/edit/{id}',[PackagesController::class, 'edit_gallery'])->name('edit_gallery');
    Route::get('/gallery/delete/{id}',[PackagesController::class, 'delete_gallery'])->name('delete_gallery');

    Route::get('/locations',[PackagesController::class, 'locations'])->name('locations');
    Route::get('/locations/create',[PackagesController::class, 'create_locations'])->name('create_locations');
    Route::post('/locations/create',[PackagesController::class, 'create_locations'])->name('create_locations');
    Route::get('/locations/edit/{id}',[PackagesController::class, 'edit_locations'])->name('edit_locations');
    Route::post('/locations/edit/{id}',[PackagesController::class, 'edit_locations'])->name('edit_locations');
    Route::get('/locations/delete/{id}',[PackagesController::class, 'delete_locations'])->name('delete_locations');
    
    Route::post('/assign-hotel',[PackagesController::class, 'assign_hotel'])->name('assign-hotel');
    Route::post('/assign-bus',[PackagesController::class, 'assign_bus'])->name('assign-bus');

    Route::get('/booking-detail/{id}',[PackagesController::class, 'booking_detail'])->name('booking-detail');
    Route::get('/visa',[PackagesController::class, 'visa'])->name('visa');
    Route::get('/visa-detail/{id}',[PackagesController::class, 'visa_detail'])->name('visa-detail');
    Route::get('/sub-visa-detail/{id}',[PackagesController::class, 'sub_visa_detail'])->name('sub-visa-detail');
    Route::get('/invitation-detail',[PackagesController::class, 'invitation_detail'])->name('invitation-detail');
    Route::get('/airline-list',[PackagesController::class, 'airline_list'])->name('airline-list');
    
    Route::get('/profile',[PackagesController::class, 'profile'])->name('profile');
    Route::post('/profile',[PackagesController::class, 'profile'])->name('profile');

    Route::get('/itenaries',[ItenariesController::class, 'index'])->name('itenaries');
    Route::get('/itenaries/delete/{id}',[ItenariesController::class,'delete'])->name('itenaries-delete');
    Route::get('/itenaries/ticket/{id}',[ItenaryTicketDetailsController::class, 'index'])->name('ticket');
    Route::get('/iternaries-list',[ItenariesController::class, 'iternaries_list'])->name('iternaries-list');
    Route::get('/apply_visa',[AdminVisaController::class, 'index'])->name('apply_visa');
    Route::get('/pdf/mypdf/{id}',[PdfController::class, 'getpdf']);
    Route::get('/apply_visa/delete/{id}',[AdminVisaController::class, 'delete'])->name('apply-visa-delete');
    Route::get('/apply_visa/edit/{id}',[AdminVisaController::class,'showdata']);
    Route::post('edit',[AdminVisaController::class,'update']);
    Route::get('/passport_nicop',[PassportNicopController::class, 'index'])->name('passport_nicop');
    Route::post('/passport_nicop',[PassportNicopController::class, 'store']);
    Route::get('/passportinfo', [PassportInfoController::class, 'index'])->name('passportinfo');
    Route::get('/passportinfo/delete/{id}',[PassportInfoController::class, 'delete'])->name('passportinfo-delete');
    Route::get('/passportedit/showdata/{id}', [PassportInfoController::class, 'showdata']);
    Route::post('/passportedit/showdata/{id}',[PassportInfoController::class, 'update']);
    
    Route::get('/accounting',[AccountingController::class, 'index'])->name('accounting');
    
    Route::get('/payable/create',[AccountingController::class, 'create_payable'])->name('create_payable');
    Route::post('/payable/create',[AccountingController::class, 'create_payable'])->name('create_payable');
    Route::get('/payable/edit/{id}',[AccountingController::class, 'edit_payable'])->name('edit_payable');
    Route::post('/payable/edit/{id}',[AccountingController::class, 'edit_payable'])->name('edit_payable');
    Route::get('/payable/delete/{id}',[AccountingController::class, 'delete_payable'])->name('delete_payable');
    Route::get('/receivable/view/{id}',[AccountingController::class, 'view_receivable'])->name('view_receivable');

    Route::get('/receivable/create',[AccountingController::class, 'create_receivable'])->name('create_receivable');
    Route::post('/receivable/create',[AccountingController::class, 'create_receivable'])->name('create_receivable');
    Route::get('/receivable/edit/{id}',[AccountingController::class, 'edit_receivable'])->name('edit_receivable');
    Route::post('/receivable/edit/{id}',[AccountingController::class, 'edit_receivable'])->name('edit_receivable');
    Route::get('/receivable/delete/{id}',[AccountingController::class, 'delete_receivable'])->name('delete_receivable');

    Route::get('/account-head',[AccountingController::class, 'account_head'])->name('account_head');

    Route::get('/account-head/create',[AccountingController::class, 'create_account_head'])->name('create_account_head');
    Route::post('/account-head/create',[AccountingController::class, 'create_account_head'])->name('create_account_head');
    Route::get('/account-head/edit/{id}',[AccountingController::class, 'edit_account_head'])->name('edit_account_head');
    Route::post('/account-head/edit/{id}',[AccountingController::class, 'edit_account_head'])->name('edit_account_head');
    Route::get('/account-head/delete/{id}',[AccountingController::class, 'delete_account_head'])->name('delete_account-head');
    Route::get('/foreigners_registration/{id}',[PackagesController::class, 'foreigners_registration'])->name('foreigners_egistration');
    Route::get('/add-balance/{id}',[BalanceController::class, 'index'])->name('add-balance');
    Route::post('/insert_balance',[BalanceController::class, 'store'])->name('insert_balance');
    Route::get('/balance-edit/{id}',[BalanceController::class, 'edit'])->name('edit');
    Route::post('/balance-update/{id}',[BalanceController::class, 'update'])->name('balance-update');
    Route::get('/balance-delete/{id}',[BalanceController::class, 'destroy'])->name('destroy');

    Route::get('/ids/back',[PackagesController::class, 'ids_back'])->name('back');
    Route::post('/create_ids_back/',[PackagesController::class, 'create_ids_back'])->name('create_ids_back');

    Route::get('/charges', [ChargesController::class, 'charges'])->name('charges');
    Route::get('/charges/create', [ChargesController::class, 'create_charges'])->name('create_charges');
    Route::post('/charges/create', [ChargesController::class, 'create_charges'])->name('create_charges');
    Route::get('/charges/edit/{id}', [ChargesController::class, 'edit_charges'])->name('edit_charges');
    Route::post('/charges/edit/{id}', [ChargesController::class, 'edit_charges'])->name('edit_charges');
    Route::get('/charges/delete/{id}', [ChargesController::class, 'delete_charges'])->name('delete_charges');

    Route::get('/manage-charges/{id}', [ChargesController::class, 'manage_charges'])->name('manage_charges');
    Route::get('/manage-charges/create/{id}', [ChargesController::class, 'create_manage_charges'])->name('create_manage_charges');
    Route::post('/manage-charges/create/{id}', [ChargesController::class, 'create_manage_charges'])->name('create_manage_charges');
    Route::get('/manage-charges/edit/{id}', [ChargesController::class, 'edit_manage_charges'])->name('edit_manage_charge');
    Route::post('/manage-charges/edit/{id}', [ChargesController::class, 'edit_manage_charges'])->name('edit_manage_charges');
    Route::get('/manage-charges/delete/{id}', [ChargesController::class, 'delete_manage_charges'])->name('delete_manage_charges');
});

    Route::get('/account-head/edit/{id}',[AccountingController::class, 'edit_account_head'])->name('edit_account_head');
// User Part //
Route::group(['prefix' => 'user','middleware' => ['user']], function(){
    Route::get('/user_dashboard',[UserDashboardController::class, 'index'])->name('user_dashboard');
    Route::get('user_visa',[UserVisaController::class, 'index'])->name('user_visa');
    Route::post('user_visa',[UserVisaController::class, 'store']);
    Route::get('/user_packages',[UserPakagesController::class, 'index'])->name('user_packages');
    Route::get('/yatri-list',[UserPakagesController::class, 'yatri_list'])->name('yatri-list');
    Route::get('/add-booking',[UserPakagesController::class, 'add_booking'])->name('add-booking');
    Route::get('/bookings',[UserPakagesController::class, 'bookings'])->name('bookings');

    Route::get('/profile',[UserPakagesController::class, 'profile'])->name('user-profile');
    Route::post('/profile',[UserPakagesController::class, 'profile'])->name('user-post-profile');

    Route::get('/all-packages',[UserDashboardController::class, 'all_package'])->name('user_all_package');
    Route::get('/all-packages/{id}',[UserDashboardController::class, 'package'])->name('user_package');
    Route::get('/all-packages/{id}/apply',[UserDashboardController::class, 'package_apply'])->name('user-package-apply');
    Route::post('/store-yatri-visa',[UserDashboardController::class,'store_yatri_visa'])->name('user-store-yatri-visa');
    Route::get('/all-packages/payment/{id}',[UserDashboardController::class, 'payment'])->name('user-payment');
    Route::post('/all-packages/payment/{id}',[UserDashboardController::class, 'payment'])->name('user-post-payment');
    Route::get('/payment/{id}',[UserDashboardController::class, 'payment'])->name('later-payment');
    Route::post('/payment/{id}',[UserDashboardController::class, 'payment'])->name('post-later-payment');
    Route::get('/thank-you',[UserDashboardController::class, 'thank_you'])->name('user-thank-you');
});

});





