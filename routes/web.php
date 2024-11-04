<?php

use App\Http\Controllers\Admin\ActiveController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ArticalController;
use App\Http\Controllers\Admin\AssignQuestionController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ConceptController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GuidelineController;
use App\Http\Controllers\Admin\LdapController;
use App\Http\Controllers\Admin\LeadershipController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\Office365Controller;
use App\Http\Controllers\Admin\PathAssignController;
use App\Http\Controllers\Admin\PosterController;
use App\Http\Controllers\Admin\ProcedureController;
use App\Http\Controllers\Admin\RandomQuestionResultsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\WizardConrtoller;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ExcelController;
use App\Http\Controllers\Admin\AssignController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\PathController;
use App\Http\Controllers\Admin\YASRController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\Office365AuthControlle;
use App\Http\Controllers\Front\ConceptsController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\ArticleController;
use App\Http\Controllers\Front\BackgroundController;
use App\Http\Controllers\Front\CoursesController;
use App\Http\Controllers\Front\GuidelinesController;
use App\Http\Controllers\Front\lessonsController;
use App\Http\Controllers\Front\NoteController;
use App\Http\Controllers\Front\PathControllers;
use App\Http\Controllers\Front\PoliciesController;
use App\Http\Controllers\Front\PostersController;
use App\Http\Controllers\Front\ProceduresController;
use App\Http\Controllers\Front\UsersController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Front\VisitController;
use App\Http\Controllers\Phishaware\CampaignsController;
use App\Http\Controllers\Phishaware\PagesController;
use App\Http\Controllers\Phishaware\ProfilesController;
use App\Http\Controllers\Phishaware\TemplatesController;
use App\Http\Controllers\Phishaware\HomeController;
use App\Http\Controllers\Phishaware\GroupsController;
use App\Http\Controllers\Admin\PolcyController;
use App\Http\Controllers\Admin\QuestionPoolController;
use App\Http\Controllers\Admin\UsersAnalysisController;
use App\Http\Controllers\Office365AuthController;



use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Route;

use GuzzleHttp\Client;



Route::get('test', function () {
    //    return view('frontend.test');
    return view('twofactor.tow_factor');
});



// Route::post('login', [CustomLoginController::class, 'login']);

// Route::post('/login', [CustomLoginController::class,'login'] );


Route::post('/custom-logout', [CustomLoginController::class, 'logout'])->name('custom.logout');

Route::post('auth/azure', [Office365AuthController::class, 'redirectToAzureProvider'])->name('azure.login');
Route::get('auth/azure/callback', [Office365AuthController::class, 'handleAzureProviderCallback']);
Route::get('reports', [ReportController::class, 'handelAllReports']);

Route::post('/activity-log', [App\Http\Controllers\Admin\ActivityLogController::class, 'logActivity']);
Route::get('/two-factor-auth', [CustomLoginController::class, 'twoFactorAuth']);
Route::post('/two-factor-auth/callback', [CustomLoginController::class, 'twoFactorAuthCallback'])->name('twoFactorAuthCallback');
Route::get('users/change-passowrd', [UsersController::class, 'resetPassword'])->name('user.change.password')->middleware('add.logo.config');
Route::put('changePassword/{id}', [UsersController::class, 'update'])->name('changePassword');
Route::post('/import-site', [PagesController::class, 'importSite'])->name('importSite');
Route::get('fix_policy_user_table', [PoliciesController::class, 'fixPolicyUserTable']);
// Route::post('received_behaver_data',[ReportController::class,'receivedDataExtension']);
// Route::get('getCookie/{cookie_name}',[ReportController::class,'getCookie']);

Route::prefix('/')->middleware(['auth', 'add.company.id', 'license', 'front.role'])->name('web.')->group(function () {

    Route::get('/random_question/{id}', [RandomQuestionResultsController::class, 'show'])->name('random_question.show');
    Route::post('/random_question/store_result', [RandomQuestionResultsController::class, 'store'])->name('random_question.store');
    Route::get('/', [FrontController::class, 'index'])->name('home');
    Route::get('/home', [FrontController::class, 'index'])->name('home');
    Route::get('/yaser_Ai', [FrontController::class, 'yaserAi'])->name('yaser.index');
    Route::get('/yaser_Ai/{chat_id}', [FrontController::class, 'get_chat']);
    Route::post('/yaser_Ai/add_message', [FrontController::class, 'get_message']);
    Route::post('/yaser_Ai/add_chat', [FrontController::class, 'add_chat']);
    Route::delete('/yaser_Ai/delete_chat/{chat_id}', [FrontController::class, 'delete_chat']);
    Route::post('/yaser_Ai/change_chat_name', [FrontController::class, 'change_chat_name']);
    Route::get('/news/{slug}', [FrontController::class, 'showNews'])->name('news.show');

    Route::resource('/newsletters', ArticleController::class);
    Route::resource('/posters', PostersController::class);
    Route::resource('/guidelines', GuidelinesController::class);
    Route::resource('/policies', PoliciesController::class);
    Route::post('/policies/{slug}', [PoliciesController::class, 'store']);
    Route::resource('/procedures', ProceduresController::class);
    Route::resource('/concepts', ConceptsController::class);

    Route::resource('/wallpapers', BackgroundController::class);
    Route::get('/image-download/{id}', [BackgroundController::class, 'store'])->name('image-download');

    Route::get('/mypaths', [PathControllers::class, 'students'])->name('paths.students.index');
    Route::get('/mypaths/courseOpen/check/{course_id}/{path_id}', [PathControllers::class, 'checkIfCanOpenCourse'])->name('checkIfCanOpenCourse');
    Route::resource('/paths', PathControllers::class);
    Route::resource('/background', BackgroundController::class);
    Route::get('/user/change-passowrd', [UsersController::class, 'changePassword'])->name('user.change.password');
    Route::get('/user/edit-account', [UsersController::class, 'editAccount'])->name('user.edit.account');
    Route::get('/leadership/profile', [UsersController::class, 'profile'])->name('user.profile');
    Route::get('/user/edit-notification', [UsersController::class, 'notification'])->name('user.edit.notification');
    Route::put('/user/update-account/{id}', [UsersController::class, 'updateAccount'])->name('user.update.account');
    Route::resource('/changes', UsersController::class);

    Route::resource('/notes', NoteController::class);
    Route::get('/course/reset/{id}', [CoursesController::class, 'reset'])->name('course.reset');
    Route::get('/course/reset/{id}/{path_id}', [CoursesController::class, 'reset'])->name('course.reset.path');
    Route::resource('/Courses', CoursesController::class);
    Route::get('/Courses/{slug}/{path_slug}', [CoursesController::class, 'show'])->name('Courses.show.path');
    Route::resource('/lessons', lessonsController::class);
    Route::get('/test-result-questions/{id}', [lessonsController::class, 'getResultsQuestions']);
    Route::get('/lessons/{slug}/{id}/review', [lessonsController::class, 'TestReview'])->name('lesson.review');
    Route::get('/lessons/{slug}/{id}/review/{nextId}', [lessonsController::class, 'TestReview'])->name('lesson.review');
    Route::get('/lessons/{slug}/{id}', [lessonsController::class, 'lessonTestShow'])->name('lesson.show');
    Route::get('/lessons/{slug}/{id}/{path_slug}', [lessonsController::class, 'lessonTestShow'])->name('lesson.show.path');
    Route::get('/question/{Id}', [lessonsController::class, 'nextOrPreviousQuestion'])->name('nextOrPreviousQuestion');
    Route::post('/testStore', [lessonsController::class, 'testStore'])->name('testStore');
    Route::post('/checkRetake', [lessonsController::class, 'checkRetake'])->name('checkRetake');
    Route::post('/addRetake', [lessonsController::class, 'addRetake'])->name('addRetake');
    Route::post('/btncheckRetake', [lessonsController::class, 'checkRetake'])->name('btncheckRetake');
    Route::post('/newTest', [lessonsController::class, 'newTest'])->name('newTest');
    Route::post('/getLessonTest', [LessonsController::class, 'getLessonTest'])->name('getLessonTest');

    Route::post('/changeEnrollment', [lessonsController::class, 'changeEnrollment'])->name('changeEnrollment');
    Route::post('/generateCertificate', [lessonsController::class, 'generateCertificate'])->name('generateCertificate');
    Route::get('/Course/chart/front', [FrontController::class, 'courseChart'])->name('CourseChart-front'); //->middleware('verified');

    Route::get('/course/{course}/progress', [lessonsController::class, 'getCourseProgress'])->name('course.progress');

    //--------------------Visit Controller---------
    Route::post('/visit/users', [VisitController::class, 'visitUsers'])->name('visit.users');


});
Route::get('/change-lang/{language}', [DashboardController::class, 'changeLanguage'])->name('dashboard.change-language');
Route::get('/change-website-lang/{language}', [DashboardController::class, 'changeWebsiteLanguage'])->middleware('add.company.id');

Route::prefix('phishaware')->name('phishaware.')->middleware(['auth', 'role', 'add.company.id'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('phisher.index');
    Route::resource('/campaigns', CampaignsController::class);
    Route::get('/campaign/copy/{id}', [CampaignsController::class, 'copyRecord']);
    Route::resource('/templates', TemplatesController::class);
    Route::get('/templates/copy/{id}', [TemplatesController::class, 'copyRecord']);


    Route::resource('/landing_pages', PagesController::class);
    Route::get('/landing_pages/copy/{id}', [PagesController::class, 'copyRecord']);


    Route::post('/landing/update', [PagesController::class, 'update'])->name('page.update');
    Route::resource('/sending_profiles', ProfilesController::class);
    Route::get('/sending_profiles/copy/{id}', [ProfilesController::class, 'copyRecord']);
    Route::resource('/groups', GroupsController::class);


});

Route::prefix('admin')->middleware(['auth', 'license', 'role', 'add.company.id'])->group(function () { //

    Route::get('/', [DashboardController::class, 'showDashboard'])->name('dashboard'); //->middleware('verified');
    Route::get('fetchData', [DashboardController::class, 'fetchData']);
    Route::get('phishing/chart/{selectId}', [DashboardController::class, 'get_phishing_chart']);
    Route::get('/Course/chart', [DashboardController::class, 'CourseChart'])->name('CourseChart');
    Route::get('/getUserReport', [DashboardController::class, 'getUserReport'])->name('getUserReport');
    Route::get('/Course/chart/assigned', [DashboardController::class, 'CourseAssingChart'])->name('CourseAssingChart');
    Route::get('/Course/chart/enrollerment', [DashboardController::class, 'CourseEnrollermentChart'])->name('CourseEnrollermentChart');
    Route::get('/activity/logs', [DashboardController::class, 'activityLogChart'])->name('activityLogChart');
    Route::get('/security_culture', [DashboardController::class, 'security_culture_chart'])->name('security_culture_chart');
    Route::get('/phishingCampaigns', [DashboardController::class, 'phishingCampaigns'])->name('chart.phishing_campaigns');
    Route::get('/courses/lessons/tests', [DashboardController::class, 'lessonAndTestChart'])->name('coursesChart.lesson.test');
    Route::get('/security/Culture/Chart', [DashboardController::class, 'securityCultureChart'])->name('securityCultureChart');
    Route::get('/risk/LevelChart/Chart', [DashboardController::class, 'riskLevelChart'])->name('riskLevelChart');

    /**********************USER ROUTE******************************/

    Route::resource('users', UserController::class);
    Route::post('users/enable2fa', [UserController::class, 'enable2fa'])->name('enable2fa');
    Route::post('users/disable2fa', [UserController::class, 'disable2fa'])->name('disable2fa');
    Route::post('users/deleteUsers', [UserController::class, 'deleteUsers'])->name('deleteUsers');
    Route::post('users/reset2fa', [UserController::class, 'reset2fa'])->name('reset2fa');
    Route::post('users/enable_user', [UserController::class, 'enable_user'])->name('enable_user');
    Route::post('users/disable_user', [UserController::class, 'disable_user'])->name('disable_user');
    Route::put('users/resetPasswords/{id}', [UserController::class, 'resetPasswords'])->name('resetPasswords');
    Route::post('users/export', [UserController::class, 'export'])->name('users.export');

    /**********************USER Analysis ROUTE******************************/

    Route::resource('users_analysis', UsersAnalysisController::class);
    Route::post('users_analysis/export', [UsersAnalysisController::class, 'export'])->name('users_analysis.export');

    /**********************Groups ROUTE******************************/

    Route::resource('groups', GroupController::class);
    /************************** SETTING ROUTE *********************/

    Route::get('setting/general', [SettingController::class, 'general'])->name('setting.general');
    Route::post('setting/logos', [SettingController::class, 'store_logos'])->name('logos.store');
    Route::get('setting/mail/Configuration', [SettingController::class, 'mail_Confiragions'])->name('setting.mail_Confiragions');
    // License api

    Route::get('setting/License', [LicenseController::class, 'License'])->name('setting.License');
    Route::put('setting/license/update/{id}', [LicenseController::class, 'update'])->name('setting.EditLicense');
    Route::post('/setting/License/create', [LicenseController::class, 'create_license'])->name('setting.createLicense');
    Route::delete('/setting/License/delete/{id}', [LicenseController::class, 'delete_license'])->name('setting.deleteLicense');
    Route::post('setting/license/verify_license', [LicenseController::class, 'verifyLicense']);

    Route::get('setting/system/setting', [SettingController::class, 'system_setting'])->name('setting.system');
    Route::post('setting/general', [SettingController::class, 'store'])->name('setting.general.store');
    Route::post('setting/phishawareTestConnection', [SettingController::class, 'phishawareTestConnection'])->name('setting.phishawareTestConnection');
    Route::post('setting/phishawareStore', [SettingController::class, 'storePhishing'])->name('setting.storePhishing');
    Route::post('setting/pull/phishaware', [SettingController::class, 'importPhishingUsers']);


    Route::get('setting/general/system-update', [SettingController::class, 'system_update'])->name('setting.system.update');
    Route::post('setting/general/git/pull', [SettingController::class, 'git_pull'])->name('setting.general.git.pull');
    Route::post('setting/general/git/check/update', [SettingController::class, 'check_update'])->name('setting.general.git.check.update');
    Route::get('setting/general/update_description', [SettingController::class, 'update_description'])->name('setting.update_description');

    Route::post('setting/store_mail', [SettingController::class, 'store_mail_config'])->name('setting.store.mail.store');
    Route::post('setting/test_mail', [SettingController::class, 'mail_test'])->name('setting.test.mail.store');
    Route::post('setting/store_sliders', [SettingController::class, 'store_sliders'])->name('setting.store.sliders');
    Route::post('setting/edit_sliders', [SettingController::class, 'edit_sliders'])->name('setting.edit.sliders');
    Route::delete('setting/delete_sliders/{id}', [SettingController::class, 'destroy_sliders'])->name('setting.store.sliders');
    Route::post('setting/store_ad_settings', [ActiveController::class, 'store'])->name('setting.general.store_ad_settings');
    Route::get('setting/ad/update/{id}', [ActiveController::class, 'edit'])->name('setting.show_ad_settings');
    Route::post('setting/ad/update', [ActiveController::class, 'update'])->name('setting.update_ad_settings');
    Route::delete('setting/ad/delete/{id}', [ActiveController::class, 'destroy'])->name('setting.delete_ad_settings');
    Route::put('setting/ad/pull/{id}', [ActiveController::class, 'pull_employee'])->name('setting.pull_ad_settings');
    Route::post('setting/store/office', [Office365Controller::class, 'store'])->name('setting.office.store');
    Route::post('setting/pull/office/', [Office365Controller::class, 'importOffice365Users'])->name('setting.office.pull');
    Route::post('setting/update/office', [Office365Controller::class, 'update'])->name('setting.office.update');
    Route::delete('setting/offices/delete', [Office365Controller::class, 'destroy'])->name('setting.offices.delete');
    Route::get('setting/offices/{id}', [Office365Controller::class, 'edit'])->name('setting.offices.edit');
    Route::get('setting/system_logs', [SettingController::class, 'system_logs'])->name('setting.system_logs');
    Route::post('setting/system_logs/export', [SettingController::class, 'systemLogsExport'])->name('setting.system_logs.export');


    /************************** Roles & Permissions ROUTE *********************/
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::put('roles/{role}/permission', [\App\Http\Controllers\Admin\RolePermissionController::class, 'update'])->name('role-permission.update');

    //        Route::get('users/{id}/permission', [UserPermissionController::class, 'edit'])->name('user-permissions.edit');
//        Route::put('users/{id}/permission', [UserPermissionController::class, 'update'])->name('user-permissions.update');

    /************************** security ROUTE *********************/
    Route::post('change/status/{id}', [GalleryController::class, 'changeStatus'])->name('gallerys.change.status');
    Route::resource('wallpapers', GalleryController::class);
    Route::get('articles/{id}/delete_image', [ArticalController::class, 'deleteFile'])->name('article.delete_file');
    Route::post('change/article/status/{id}', [ArticalController::class, 'changeStatus'])->name('article.change.status');

    Route::resource('articles', ArticalController::class);
    Route::post('change/poster/status/{id}', [PosterController::class, 'changeStatus'])->name('poster.change.status');
    Route::resource('posters', PosterController::class);
    Route::get('policies/{id}/delete_image', [PolcyController::class, 'deleteFile'])->name('policies.delete_file');
    Route::post('change/policy/status/{id}', [PolcyController::class, 'changeStatus'])->name('policy.change.status');

    Route::resource('policies', PolcyController::class);
    Route::get('procedures/{id}/delete_image', [ProcedureController::class, 'deleteFile'])->name('procedures.delete_file');
    Route::post('change/procedure/status/{id}', [ProcedureController::class, 'changeStatus'])->name('procedure.change.status');

    Route::resource('procedures', ProcedureController::class);
    Route::get('guidelines/{id}/delete_image', [GuidelineController::class, 'deleteFile'])->name('guidelines.delete_file');
    Route::post('change/guideline/status/{id}', [GuidelineController::class, 'changeStatus'])->name('procedure.change.status');
    Route::resource('guidelines', GuidelineController::class);
    Route::post('change/concept/status/{id}', [ConceptController::class, 'changeStatus'])->name('concept.change.status');

    Route::resource('concepts', ConceptController::class);

    /***************************CATEGORY ROUTE ******************/
    Route::resource('categories', CategoryController::class);

    /***************************YASR ROUTE ******************/
    Route::resource('YASER_AI', YASRController::class);

    /***************************leaderships ROUTE ******************/

    Route::resource('leaderships', LeadershipController::class);
    /***************************Sections ROUTE ******************/
    // Route::get('sections/{id}', [SectionController::class,'show'])->name('sections.show');
    Route::resource('sections', SectionController::class);
    /***************************Courses ROUTE ******************/
    Route::post('change/course/status/{id}', [CourseController::class, 'changeStatus'])->name('course.change.status');
    Route::get('/unassigns/{slug}/users', [AssignController::class, 'edit'])->name('unassigns.users.show');
    Route::put('/unassigns/users/{slug}', [AssignController::class, 'unassign'])->name('unassigns.users.update');
    Route::resource('assigns', AssignController::class);
    Route::put('check_users_assigns/{id}', [AssignController::class, 'check_users_assign']);

    Route::patch('courses-order/{course}/update-order', [CourseController::class, 'updateOrder'])->name('courses.update-order');
    //Route::post('/courses-order/{course}/update-order', [CourseController::class, 'updateOrder'])->name('courses.update_order');

    Route::resource('assigns-paths', PathAssignController::class);
    Route::put('check_users_path_assigns/{id}', [PathAssignController::class, 'check_users_assign']);
    Route::get('unassigns-paths/{id}', [PathAssignController::class, 'unasign'])->name('unasign.paths');
    Route::post('unassigns-paths-users/{id}', [PathAssignController::class, 'unasignPath'])->name('unasign.paths.users');
    Route::resource('paths', PathController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('path', WizardConrtoller::class);
    Route::post('lessonStore', [WizardConrtoller::class, 'lessonStore']);


    /***************************Lessons ROUTE ******************/
    Route::get('/get-Lessons-test-data/{id}', [LessonController::class, 'getLessons'])->name('lesson.getLessons');

    Route::get('lessons/{id}/delete_file', [LessonController::class, 'deleteFile'])->name('lesson.delete_file');
    Route::get('lessons/{id}/delete_image', [LessonController::class, 'deleteImage'])->name('lesson.delete_image');
    Route::get('lessons/{id}/delete_upload_video', [LessonController::class, 'deleteUploadFile'])->name('lesson.delete_upload_video');
    Route::get('course/{id}/delete_image', [CourseController::class, 'deleteImage'])->name('course.delete_image');

    Route::resource('lessons', LessonController::class);
    Route::post('lessons/update/{id}', [LessonController::class, 'updateLesson']);

    /***************************Test ROUTE ******************/
    Route::resource('tests', TestController::class);
    Route::post('tests_question/export/{id}', [TestController::class, 'showQuestionExport'])->name('tests.showQuestion.export');

    /***************************news ROUTE ******************/
    Route::post('change/news/status/{id}', [NewsController::class, 'changeStatus'])->name('news.change.status');

    Route::resource('news', NewsController::class);
    /***************************Certificate ROUTE ******************/
    Route::resource('certificates', CertificateController::class);
    Route::post('certificates/export', [CertificateController::class, 'export'])->name('certificates.export');
    Route::post('certificates/show', [CertificateController::class, 'show'])->name('certificates.showCertificates');
    Route::delete('certificates/delete_cert_list/{id}', [CertificateController::class, 'delete'])->name('certificates.delete');
    Route::post('certificates/update_cert_list/{id}', [CertificateController::class, 'update_cert_list']);
    /***************************question ROUTE ******************/
    Route::resource('questions', QuestionController::class);
    Route::get('/questions/export/data', [QuestionController::class, 'export'])->name('questions.export');
    ;

    /***************************Menu ROUTE ******************/
    Route::resource('menus', MenuController::class);
    Route::post('user/upload', [ExcelController::class, 'store'])->name('users,upload');

    // Route::get('permissions',[PermissionController::class,'index'])->name('permissions');
    /***************************Report ROUTE ******************/
    Route::get('courses_progress', [ReportController::class, 'courseReport'])->name('course.report');
    Route::get('policy_reports', [ReportController::class, 'policy_reports'])->name('policy.report');
    Route::post('policy_reports/export', [ReportController::class, 'policy_reports_export'])->name('policy.report.export');
    Route::get('learning_paths_reports', [ReportController::class, 'learning_paths_reports'])->name('path.report');
    Route::post('learning_paths_reports/export', [ReportController::class, 'learning_paths_reports_export'])->name('path.report.export');
    Route::get('courses_tests_progress', [ReportController::class, 'courseTestReport'])->name('course.tests.report');
    Route::get('courses_assignment', [ReportController::class, 'assignmentReport'])->name('assignment.report');
    Route::get('tests_report', [ReportController::class, 'testReport'])->name('tests.reports');
    Route::get('tests_details', [ReportController::class, 'allTestReport'])->name('tests.reports.all');
    Route::get('tests_report_details/{id}/{test_id}', [ReportController::class, 'testDetailsReport'])->name('test.report.details');

    Route::get('course_details_report/{id}', [ReportController::class, 'courseDetailsReport'])->name('course.details.report.all');
    Route::get('activity_login_report', [ReportController::class, 'loginActivityReport'])->name('login.activity.report');
    Route::get('Behind_Schedule', [ReportController::class, 'OutOfScopeEmployeesReport'])->name('Out.Scope.report');
    Route::post('coursesReport/export', [ReportController::class, 'coursesReport'])->name('report.coursesReport');
    Route::post('coursesTestReport/export', [ReportController::class, 'coursesTestReport'])->name('report.coursesTestReport');
    Route::post('TestsReport/export', [ReportController::class, 'TestsReport'])->name('report.TestsReport');
    Route::post('allTestsReports/export', [ReportController::class, 'allTestsReports'])->name('report.allTestsReports');
    Route::post('assignCoursesReport/export', [ReportController::class, 'assignCoursesReport'])->name('report.assignCoursesReport');
    Route::post('Behind_ScheduleReport/export', [ReportController::class, 'Behind_ScheduleReport'])->name('report.Behind_ScheduleReport');
    Route::post('activityLoginReport/export', [ReportController::class, 'activityLoginReport'])->name('report.activityLoginReport');
    Route::get('updates_report', [ReportController::class, 'updatesReport'])->name('update.report');
    Route::post('updates_report/export', [ReportController::class, 'updatesReportExport'])->name('update.report.export');
    /***************************Companies ROUTE ******************/
    Route::resource('companies', CompaniesController::class);
    Route::delete('/companies/delete/{id}', [CompaniesController::class, 'destroy']);
    Route::post('/companies/update/{id}', [CompaniesController::class, 'update']);

    /***************************Random Question ROUTE ******************/
    Route::resource('assign_question', AssignQuestionController::class);
    Route::resource('question_pool', QuestionPoolController::class);
    Route::resource('random_results', RandomQuestionResultsController::class);
    Route::post('random_results/export', [RandomQuestionResultsController::class, 'export'])->name('random_results.export');

});

Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');

    return 'all clear';
});
