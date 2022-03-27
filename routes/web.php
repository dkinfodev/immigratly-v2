<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

// Cronjob
Route::group(array('prefix' => 'cron'), function () {
    Route::get('/backup-to-gdrive', [App\Http\Controllers\CronController::class, 'backupFilesToGdrive']);
    Route::get('/capture-screen', [App\Http\Controllers\CronController::class, 'captureScreen']);
    Route::get('/scrape', [App\Http\Controllers\CronController::class, 'scrape']);
});


Route::get('/assessment/u/{id}', [App\Http\Controllers\Frontend\FrontendController::class, 'externalAssessment'])->name("external-assessment");


Route::group(array('prefix' => 'quick-eligibility'), function () {
    Route::get('/', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'groupList']);
    Route::post('/group-ajax-list', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'groupAjaxList']);
    Route::get('/lists/{id}', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'list']);
    
    Route::post('/ajax-list', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'getAjaxList']);
    Route::get('/check/{id}', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'eligibilityCheck']);
    Route::post('/check/{id}', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'saveEligibilityScore']);
    Route::get('/view-history', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'userEligibilityHistory']);
    Route::post('/ajax-history', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'eligibilityAjaxHistory']);

    Route::get('/g/{id}', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'groupEligibilityCheck']);
    Route::post('/g/{id}', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'saveGroupEligibilityScore']);
    Route::get('/all-group-eligibility', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'allGroupEligibilityCheck']);
    Route::get('/group-eligibility-form', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'getGroupEligibilityForm']);
    Route::post('/fetch-conditional', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'fetchConditional']);
    Route::post('/fetch-group-conditional', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'fetchGroupConditional']);
    Route::get('/report/{id}', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'eligibilityReport']);
    Route::get('/all-eligibility', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'allEligibility']);
    Route::get('/eligibility-form', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'eligibilityForm']);
    Route::post('/check-pre-condition', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'checkPreCondition']);
    Route::post('/check-language-proficiency', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'checkLanguageProficiency']);
        

    
    Route::get('/download-report/{id}', [App\Http\Controllers\Frontend\QuickEligibilityConroller::class, 'downloadReport']);

});
Route::post('/assessment/u/{id}', [App\Http\Controllers\Frontend\FrontendController::class, 'saveExternalAssessment'])->name("save-external-assessment");
Route::group(array('middleware' => 'frontend'), function () {
    Route::get('/', [App\Http\Controllers\Frontend\FrontendController::class, 'index']);
    Route::get('/dbupdate', [App\Http\Controllers\Frontend\FrontendController::class, 'dbUpdate']);
    
    Route::get('/articles', [App\Http\Controllers\Frontend\FrontendController::class, 'articles']);
    Route::get('/articles/{slug}', [App\Http\Controllers\Frontend\FrontendController::class, 'articles']);
    Route::get('/article/{slug}', [App\Http\Controllers\Frontend\FrontendController::class, 'articleSingle']);
    Route::get('/webinars', [App\Http\Controllers\Frontend\FrontendController::class, 'webinars']);
    Route::get('/webinars/{slug}', [App\Http\Controllers\Frontend\FrontendController::class, 'webinars']);
    Route::get('/webinar/{slug}', [App\Http\Controllers\Frontend\FrontendController::class, 'webinarSingle']);
    Route::get('/discussions', [App\Http\Controllers\Frontend\FrontendController::class, 'discussions']);
    Route::get('/discussions/fetch-topics', [App\Http\Controllers\Frontend\FrontendController::class, 'fetchTopics']);
    Route::get('/topic/{slug}', [App\Http\Controllers\Frontend\FrontendController::class, 'topicDetails']);
    Route::post('/discussions/fetch-comments', [App\Http\Controllers\Frontend\FrontendController::class, 'fetchComments']);
    Route::post('/discussions/send-comment', [App\Http\Controllers\Frontend\FrontendController::class, 'sendComment']);
    
    //Professional
    Route::get('/professionals/', [App\Http\Controllers\Frontend\FrontendController::class, 'professionals']);
    Route::post('/professionals-list/', [App\Http\Controllers\Frontend\FrontendController::class, 'professionalAjaxList']);
    Route::get('/professional/{subdomain}', [App\Http\Controllers\Frontend\FrontendController::class, 'professionalDetail']);
    Route::get('/professional/write-review/{unique_id}', [App\Http\Controllers\Frontend\FrontendController::class, 'ReviewProfessional']);
    Route::post('/professional/send-review/{unique_id}', [App\Http\Controllers\Frontend\FrontendController::class, 'sendReviewProfessional']);
    

    // Visa Services
    Route::get('/visa-services/{slug}', [App\Http\Controllers\Frontend\FrontendController::class, 'visaServices']);
    
    //Eligibility Check front end
    Route::group(array('prefix' => 'check-eligibility'), function () {
        
        Route::get('/check/{id}', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'eligibilityCheck']);
        Route::post('/check/{id}', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'saveEligibilityScore']);

        Route::get('/g/{id}', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'groupEligibilityCheck']);
        Route::post('/g/{id}', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'saveGroupEligibilityScore']);
        Route::get('/g/report/{id}', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'groupEligibilityReport']);
        Route::get('/g/download-report/{id}', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'downloadGroupReport']);
        Route::get('/all-group-eligibility', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'allGroupEligibilityCheck']);
        Route::get('/group-eligibility-form', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'getGroupEligibilityForm']);
        Route::post('/fetch-conditional', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'fetchConditional']);
        Route::post('/fetch-group-conditional', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'fetchGroupConditional']);
        
        Route::get('/all-eligibility', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'allEligibility']);
        Route::get('/eligibility-form', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'eligibilityForm']);
 
        Route::get('/download-report/{id}', [App\Http\Controllers\Frontend\EligibilityCheckController::class, 'downloadReport']);
    });

    
});
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/random_number', [App\Http\Controllers\HomeController::class, 'random_number']);
Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'welcome_page']);
Route::get('/dbupgrade', [App\Http\Controllers\HomeController::class, 'dbupgrade']);
Route::get('/states', [App\Http\Controllers\CommonController::class, 'stateList']);
Route::get('/cities', [App\Http\Controllers\CommonController::class, 'cityList']);

Route::get('/licence-bodies', [App\Http\Controllers\CommonController::class, 'licenceBodies']);

Route::get('/signup/professional', [App\Http\Controllers\Auth\RegisterController::class, 'professionalSignup']);
Route::post('/signup/professional', [App\Http\Controllers\Auth\RegisterController::class, 'registerProfessional']);

Route::get('/signup/user', [App\Http\Controllers\Auth\RegisterController::class, 'userSignup']);
Route::post('/signup/user', [App\Http\Controllers\Auth\RegisterController::class, 'registerUser']);
Route::post("send-verify-code",[App\Http\Controllers\Frontend\FrontendController::class, 'sendVerifyCode']);
Route::post("verify-code",[App\Http\Controllers\Auth\RegisterController::class, 'verifyOtp']);


Route::get('/login/{provider}', [App\Http\Controllers\SocialLoginController::class, 'redirect']);
Route::get('/login/{provider}/callback', [App\Http\Controllers\SocialLoginController::class, 'Callback']);
Route::get('/google-callback', [App\Http\Controllers\SocialLoginController::class, 'googleCallback']);
Route::get('/dropbox-callback', [App\Http\Controllers\SocialLoginController::class, 'dropboxCallback']);
Route::get('/view-notification/{id}', [App\Http\Controllers\CommonController::class, 'readNotification']);


Route::post('/upload-files', [App\Http\Controllers\CommonController::class, 'uploadFiles']);

Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->middleware(['guest'])->name('password.request');

// Super Admin
Route::group(array('prefix' => 'super-admin', 'middleware' => 'super_admin'), function () {
    Route::get('/', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'dashboard']);
    Route::get('/edit-profile', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'editProfile']); 
    Route::post('/submit-profile', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'updateProfile']); 

    Route::get('/change-password', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'changePassword']);
    Route::post('/update-password', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'updatePassword']);

    Route::group(array('prefix' => 'licence-bodies'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'licenceBodies']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LicenceBodiesController::class, 'search']); 
    });

    Route::group(array('prefix' => 'languages'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'languages']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LanguagesController::class, 'search']); 
    });

    Route::group(array('prefix' => 'official-languages'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\OfficialLanguagesController::class, 'languages']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\OfficialLanguagesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\OfficialLanguagesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\OfficialLanguagesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\OfficialLanguagesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\OfficialLanguagesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\OfficialLanguagesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\OfficialLanguagesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\OfficialLanguagesController::class, 'search']); 
    });

    Route::group(array('prefix' => 'language-proficiency'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\LanguageProficiencyController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\LanguageProficiencyController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\LanguageProficiencyController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\LanguageProficiencyController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\LanguageProficiencyController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\LanguageProficiencyController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\LanguageProficiencyController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\LanguageProficiencyController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\LanguageProficiencyController::class, 'search']); 
    });
    
    Route::group(array('prefix' => 'visa-service-groups'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServiceGroupsController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\VisaServiceGroupsController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\VisaServiceGroupsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\VisaServiceGroupsController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\VisaServiceGroupsController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\VisaServiceGroupsController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServiceGroupsController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\VisaServiceGroupsController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\VisaServiceGroupsController::class, 'search']); 
    });

    Route::group(array('prefix' => 'visa-services'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaServices']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'search']); 
        Route::post('/fetch-questions', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'fetchQuestions']); 
        Route::post('/fetch-questions-with-components', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'fetchQuestionsWithComponents']); 
        
        Route::get('/fetch-educations', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'fetchEducations']); 
        Route::get('/fetch-proficiency', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'fetchProficiency']); 

        Route::post('/question-as-sequence', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'questionAsSequence']); 

        Route::group(array('prefix' => 'additional-information/{visa_service_id}'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'additionalInfo']);
            // Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaCutoffList']); 
            Route::get('/add-block', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'addBlock']);
            Route::post('/save-visa-block', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'saveVisaBlocks']); 
            Route::post('/delete-block', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteBlock']); 
            // Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteMultipleCutoff']); 
            Route::get('/edit-block/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'editBlock']); 
            Route::post('/update-visa-block/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'updateVisaBlocks']);
            Route::post('/string-replace', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'stringReplace']); 
        });



        Route::group(array('prefix' => 'cutoff/{visa_service_id}'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaServiceCutoff']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaCutoffList']); 
            Route::get('/add', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'addCutoff']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'saveCutoff']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteSingleCutoff']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteMultipleCutoff']); 
            Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'editCutoff']); 
            Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'updateCutoff']);
        });

        Route::group(array('prefix' => 'score-range/{visa_service_id}'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'scoreRanges']);
            Route::post('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'saveScoreRange']); 
        });

        Route::group(array('prefix' => 'eligibility-questions/{visa_service_id}'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'list']);
            Route::get('/fetch-options', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'fetchOptions']);
            Route::get('/fetch-question', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'fetchQuestion']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'getAjaxList']); 
            Route::get('/add', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'save']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteSingle']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteMultiple']); 
            Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'edit']); 
            Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'update']);

            Route::get('/set-conditions/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'setCondition']); 
            Route::post('/set-conditions/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveCondition']); 

            Route::get('/multi-option-groups/add/{component_id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'multipleGroupQuestions']); 
            Route::post('/multi-option-groups/save', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveMultipleOptionsGroup']); 
            Route::post('/fetch-group-options', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'fetchGroupOptions']); 
            Route::get('/multi-option-groups/delete/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteMultipleOptionsGroup']); 

            Route::get('/combinational-options/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'combinationalOptions']); 
            Route::post('/combinational-options/{id}/fetch-options', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'fetchCombinationalOptions']); 
            Route::post('/combinational-options/{id}/save', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveCombinationalOptions']); 
            Route::get('/combinational-options/{qid}/delete/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteCombinationOption']); 

            Route::get('/set-group-conditions/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'setGroupCondition']); 
            Route::post('/set-group-conditions/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveGroupCondition']); 

            Route::get('/set-pre-conditions/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'setPreConditions']); 
            Route::post('/set-pre-conditions/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'savePreConditions']); 

            Route::get('/arrange-questions', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'arrangeQuestions']); 
            Route::post('/arrange-questions', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveArrangedQuestions']); 

            Route::get('/arrange-groups', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'arrangeGroups']); 
            Route::post('/arrange-groups', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveArrangedGroups']); 


            Route::post('/fetch-questions', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'fetchQuestions']); 
            Route::post('/fetch-component-questions', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'fetchComponentQuestions']); 

            Route::get('/eligibility-pattern', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'groupEligibilityPattern']); 
            Route::get('/eligibility-pattern/delete/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'groupEligibilityPatternDelete']); 
            
            Route::get('/group-pattern/add', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'addGroupEligibilityPattern']); 
            // Route::post('/group-pattern/add', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveEligibilityPattern']); 
            Route::post('/fetch-group-conditional', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'fetchGroupConditional']);

            Route::get('/eligibility-pattern/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'editGroupEligibilityPattern']); 


            Route::post('/set-pattern', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'setEligibilityPattern']); 
            Route::post('/save-pattern', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveEligibilityPattern']); 

            Route::get('/eligibility-pattern/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'editEligibilityPattern']); 
            
            Route::group(array('prefix' => 'groups-questions'), function () {
                Route::get('/', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'groupsQuestions']);
                Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'groupsQuestionsAjaxList']); 
                Route::get('/add', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'addGroupQuestions']);
                Route::post('/save', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveGroupQuestions']); 
                Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteSingleGroup']); 
                Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteMultipleGroup']); 
                Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'editGroupQuestions']); 
                Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'updateGroupQuestions']);

                Route::get('/components/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'groupComponents']); 

                Route::get('/set-condition/{group_id}/{component_id}/{question_id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'setGroupCondition']); 
                Route::post('/set-condition/{group_id}/{component_id}/{question_id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveGroupCondition']); 
                

            });

            Route::group(array('prefix' => 'combination-questions'), function () {
                Route::get('/add/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'combinationQuestions']);
                Route::post('/fetch-combinations', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'fetchCombinationQuestions']); 
                Route::post('/save', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveCombinationQuestions']); 
                Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteSingleCombination']); 
                Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteMultipleCombination']); 
                Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'editCombinationQuestions']); 
                Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'updateCombinationQuestions']);
            });
        });

        Route::group(array('prefix' => 'component-questions/{visa_service_id}'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'componentQuestions']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'getComponentAjaxList']); 
            Route::post('/fetch-questions', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'fetchComponentQuestions']); 
            
            Route::get('/add', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'addComponent']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'saveComponent']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteSingleComponent']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'deleteMultipleComponent']); 
            Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'editComponent']); 
            Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\EligibilityQuestionsController::class, 'updateComponent']);
        });
        
        Route::group(array('prefix' => 'content/{visa_service_id}'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaServiceContent']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'visaContentList']); 
            Route::get('/add', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'addContent']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'saveContent']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteSingleContent']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'deleteMultipleContent']); 
            Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'editContent']); 
            Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\VisaServicesController::class, 'updateContent']);
        });
    });

    Route::group(array('prefix' => 'document-folder'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\DocumentFolderController::class, 'search']); 
    });

    
    Route::group(array('prefix' => 'assessments'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'index']);
        Route::get('/assigned', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'assigned']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'getAjaxList']);
        // Route::get('/add', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'add']);
        // Route::post('/save', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'save']);
        Route::get('/view/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'edit']);
        // Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'deleteMultiple']);
        Route::get('/assign-to-professional/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'assignToProfessional']);
        Route::post('/assign-to-professional/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'assignAssessment']);
        
        
        // Route::post('/payment-success', [App\Http\Controllers\SuperAdmin\TransactionController::class, 'assessmentPaymentSuccess']);
        // Route::post('/payment-failed', [App\Http\Controllers\SuperAdmin\TransactionController::class, 'assessmentPaymentFailed']);
        
        Route::post('/documents/{ass_id}/{doc_id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'fetchDocuments']);
        
        Route::group(array('prefix' => 'files'), function () {
            Route::post('/upload-documents', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'uploadDocuments']);
            Route::get('/view-document/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'viewDocument']);
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'deleteDocument']);
        });
        
        Route::group(array('prefix' => 'google-drive'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'fetchGoogleDrive']);
            Route::post('/files-list', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'googleDriveFilesList']);
            Route::post('/upload-from-gdrive', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'uploadFromGdrive']);
        });
        Route::group(array('prefix' => 'dropbox'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'fetchDropboxFolder']);
            Route::post('/files-list', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'dropboxFilesList']);
            Route::post('/upload-from-dropbox', [App\Http\Controllers\SuperAdmin\AssessmentsController::class, 'uploadFromDropbox']);
        });
        
    });
    Route::group(array('prefix' => 'professionals'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'activeProfessionals']);
        Route::post('/ajax-active', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'getActiveList']);
        Route::get('/inactive', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'inactiveProfessionals']);
        Route::post('/ajax-inactive', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'getPendingList']);
        Route::get('/update-all-databases', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'editAllDatabase']);
        Route::post('/update-all-databases', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'updateAllDatabase']);
        
        Route::post('/status/{status}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'changeStatus']);
        Route::post('/profile-status/{status}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'profileStatus']);

        Route::get('/view/{id}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'viewDetail']);
        Route::get('/add-notes/{id}', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'addNotes']);
        Route::post('/save-notes', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'saveNotes']);

        Route::post('/fetch-chats', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'fetchSupportChats']);
        Route::post('/send-message-to-support', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'sendChatToSupport']);
        Route::post('/send-file-to-support', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'saveDocumentChatFile']);
        Route::post('/update-database', [App\Http\Controllers\SuperAdmin\ProfessionalController::class, 'updateDatabase']);
    });
    Route::group(array('prefix' => 'privileges'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\PrivilegesController::class, 'search']); 

        Route::group(array('prefix' => 'action'), function () {  
            Route::get('/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'getAjaxList']); 
            Route::get('/{id}/add', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'save']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'deleteSingle']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'deleteMultiple']); 
            Route::get('/{mid}/edit/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'edit']); 
            Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\PrivilegesActionsController::class, 'update']);
        });
    });
    Route::group(array('prefix' => 'user'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\UserController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\UserController::class, 'getAjaxList']);
        Route::get('/add', [App\Http\Controllers\SuperAdmin\UserController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\UserController::class, 'save']);
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'edit']);
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\UserController::class, 'deleteMultiple']);
        Route::get('/change-password/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'changePassword']);
        Route::post('/update-password/{id}', [App\Http\Controllers\SuperAdmin\UserController::class, 'updatePassword']);
    });

    Route::group(array('prefix' => 'categories'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'category']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'edit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\CategoryController::class, 'update']);     
    }); 

    Route::group(array('prefix' => 'tags'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\TagsController::class, 'tags']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\TagsController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\TagsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\TagsController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\TagsController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\TagsController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\TagsController::class, 'edit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\TagsController::class, 'update']);     
    }); 

    Route::group(array('prefix' => 'news'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\NewsController::class, 'news']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\NewsController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\NewsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\NewsController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\NewsController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\NewsController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\NewsController::class, 'edit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\NewsController::class, 'update']);
        
    }); 

    Route::group(array('prefix' => 'news-category'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategory']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryGetAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryAdd']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategorySave']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryDeleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryDeleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryEdit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\NewsController::class, 'newsCategoryUpdate']);     
    });  

    Route::group(array('prefix' => 'noc-code'), function () {

        Route::get('/', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'list']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\NocCodeController::class, 'update']);     
    });

    Route::group(array('prefix' => 'primary-degree'), function () {

        Route::get('/', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'list']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'edit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\PrimaryDegreeController::class, 'update']);     
    });  

    Route::group(array('prefix' => 'staff'), function () {
            Route::get('/', [App\Http\Controllers\SuperAdmin\StaffController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\StaffController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\SuperAdmin\StaffController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\StaffController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'update']);
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\StaffController::class, 'deleteMultiple']);
            Route::get('/change-password/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'changePassword']);
            Route::post('/update-password/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'updatePassword']);
            Route::get('/privileges/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'setPrivileges']);
            Route::post('/privileges/{id}', [App\Http\Controllers\SuperAdmin\StaffController::class, 'savePrivileges']);
    });
    
    Route::group(array('prefix' => 'articles'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'publishArticles']);
        Route::get('/draft', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'draftArticles']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'getAjaxList']);
        Route::get('/add', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'save']);
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'edit']);
        Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'update']);
        Route::get('/remove-image/{id}', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'deleteImage']);
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\ArticlesController::class, 'deleteMultiple']);
    });

    Route::group(array('prefix' => 'webinar'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'getAjaxList']);
        Route::get('/add', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'save']);
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'edit']);
        Route::post('/edit/{id}', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'update']);
        Route::get('/remove-image/{id}', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'deleteImage']);
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\WebinarController::class, 'deleteMultiple']);
    });

    Route::group(array('prefix' => 'discussions'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'update']);     
        Route::post('/change-status', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'changeStatus']);
        Route::get('/comments/{id}', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'chatGroupComments']);
        Route::post('/send-comment', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'sendComment']);
        Route::get('/fetch-comments/{id}', [App\Http\Controllers\SuperAdmin\DiscussionsController::class, 'fetchComments']);
        
    }); 
   
    Route::group(array('prefix' => 'employee-privileges'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'update']);
        Route::post('/search/{key}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesController::class, 'search']); 

        Route::group(array('prefix' => 'action'), function () {  
            Route::get('/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'getAjaxList']); 
            Route::get('/{id}/add', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'save']); 
            Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'deleteSingle']); 
            Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'deleteMultiple']); 
            Route::get('/{mid}/edit/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'edit']); 
            Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\EmployeePrivilegesActionsController::class, 'update']);
        });
    });

    Route::group(array('prefix' => 'capture-category'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\CaptureCategoryController::class, 'category']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\CaptureCategoryController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\CaptureCategoryController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\CaptureCategoryController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\CaptureCategoryController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\CaptureCategoryController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\CaptureCategoryController::class, 'edit']); 
        Route::post('/update', [App\Http\Controllers\SuperAdmin\CaptureCategoryController::class, 'update']);     
    }); 

    Route::group(array('prefix' => 'screen-capture/{category_id}'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'addNew']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'update']);
        Route::get('/capture/{id}', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'captureScreen']);
        Route::get('/history/{id}', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'history']);
        Route::get('/delete-screenshot/{id}', [App\Http\Controllers\SuperAdmin\ScreenCaptureController::class, 'deleteScreenHistory']);
        
        // Route::post('/get-list', 'SuperAdmin\ScreenCaptureController@getList');
        // Route::get('/add', 'SuperAdmin\ScreenCaptureController@addNew');
        // Route::post('/add', 'SuperAdmin\ScreenCaptureController@save');

        // Route::get('/edit/{id}', 'SuperAdmin\ScreenCaptureController@edit');
        // Route::post('/edit/{id}', 'SuperAdmin\ScreenCaptureController@update');
        // Route::post('/delete', 'SuperAdmin\ScreenCaptureController@delete');
        // Route::get('/capture/{id}', 'SuperAdmin\ScreenCaptureController@captureScreen');
        // Route::get('/history/{id}', 'SuperAdmin\ScreenCaptureController@history');

        // Route::get('/add-comment/{id}', 'SuperAdmin\ScreenCaptureController@addComment');
        // Route::post('/add-comment/{id}', 'SuperAdmin\ScreenCaptureController@saveComment');
        // Route::post('/delete-comment/{id}', 'SuperAdmin\ScreenCaptureController@deleteComment');
    });

    Route::group(array('prefix' => 'cron-urls'), function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\CronUrlsController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\SuperAdmin\CronUrlsController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\SuperAdmin\CronUrlsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\SuperAdmin\CronUrlsController::class, 'save']); 
        Route::get('/history/{id}', [App\Http\Controllers\SuperAdmin\CronUrlsController::class, 'history']); 
        Route::get('/delete/{id}', [App\Http\Controllers\SuperAdmin\CronUrlsController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\SuperAdmin\CronUrlsController::class, 'deleteMultiple']); 
        Route::post('/show-img-diff', [App\Http\Controllers\SuperAdmin\CronUrlsController::class, 'showImgDiff']); 
        
        
    }); 
});
// Executive
Route::group(array('prefix' => 'executive'), function () {
    Route::group(array('middleware' => 'executive'), function () {
        Route::get('/', [App\Http\Controllers\Executive\DashboardController::class, 'dashboard']);
        Route::get('/notifications', [App\Http\Controllers\Executive\DashboardController::class, 'notifications']);
        Route::get('/edit-profile', [App\Http\Controllers\Executive\DashboardController::class, 'editProfile']);
        Route::post('/update-profile/', [App\Http\Controllers\Executive\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Executive\DashboardController::class, 'changePassword']);
        Route::post('/update-password', [App\Http\Controllers\Executive\DashboardController::class, 'updatePassword']);

        Route::group(array('prefix' => 'news'), function () {

            Route::get('/', [App\Http\Controllers\Executive\NewsController::class, 'news']);
            Route::post('/ajax-list', [App\Http\Controllers\Executive\NewsController::class, 'getAjaxList']); 
            Route::get('/add', [App\Http\Controllers\Executive\NewsController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Executive\NewsController::class, 'save']); 
            Route::get('/delete/{id}', [App\Http\Controllers\Executive\NewsController::class, 'deleteSingle']); 
            Route::post('/delete-multiple', [App\Http\Controllers\Executive\NewsController::class, 'deleteMultiple']); 
            Route::get('/edit/{id}', [App\Http\Controllers\Executive\NewsController::class, 'edit']); 
            Route::post('/update', [App\Http\Controllers\Executive\NewsController::class, 'update']);
            
        }); 

        Route::group(array('prefix' => 'news-category'), function () {

            Route::get('/', [App\Http\Controllers\Executive\NewsController::class, 'newsCategory']);
            Route::post('/ajax-list', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryGetAjaxList']); 
            Route::get('/add', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryAdd']);
            Route::post('/save', [App\Http\Controllers\Executive\NewsController::class, 'newsCategorySave']); 
            Route::get('/delete/{id}', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryDeleteSingle']); 
            Route::post('/delete-multiple', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryDeleteMultiple']); 
            Route::get('/edit/{id}', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryEdit']); 
            Route::post('/update', [App\Http\Controllers\Executive\NewsController::class, 'newsCategoryUpdate']);     
        }); 
        Route::group(array('prefix' => 'visa-services'), function () {
            Route::get('/', [App\Http\Controllers\Executive\VisaServicesController::class, 'visaServices']);
            Route::post('/ajax-list', [App\Http\Controllers\Executive\VisaServicesController::class, 'getAjaxList']); 
            Route::group(array('prefix' => 'content/{visa_service_id}'), function () {
                Route::get('/', [App\Http\Controllers\Executive\VisaServicesController::class, 'visaServiceContent']);
                Route::post('/ajax-list', [App\Http\Controllers\Executive\VisaServicesController::class, 'visaContentList']); 
                Route::get('/add', [App\Http\Controllers\Executive\VisaServicesController::class, 'addContent']);
                Route::post('/save', [App\Http\Controllers\Executive\VisaServicesController::class, 'saveContent']); 
                Route::get('/delete/{id}', [App\Http\Controllers\Executive\VisaServicesController::class, 'deleteSingleContent']); 
                Route::post('/delete-multiple', [App\Http\Controllers\Executive\VisaServicesController::class, 'deleteMultipleContent']); 
                Route::get('/edit/{id}', [App\Http\Controllers\Executive\VisaServicesController::class, 'editContent']); 
                Route::post('/edit/{id}', [App\Http\Controllers\Executive\VisaServicesController::class, 'updateContent']);
            });
        });
    });
});
// User
Route::group(array('prefix' => 'user', 'middleware' => 'user'), function () {

    Route::get('/professional/{subdomain}/book-appointment/{location}', [App\Http\Controllers\Frontend\FrontendController::class, 'bookAppointment']);

    Route::post('/professional/fetch-hours', [App\Http\Controllers\Frontend\FrontendController::class, 'fetchHours']);
    Route::post('/professional/fetch-available-slots', [App\Http\Controllers\Frontend\FrontendController::class, 'fetchAvailabilityHours']);
    Route::post('/place-booking', [App\Http\Controllers\Frontend\FrontendController::class, 'placeBooking']);
    
    Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'dashboard']);
    Route::get('/notifications', [App\Http\Controllers\User\DashboardController::class, 'notifications']);
    Route::get('/edit-profile', [App\Http\Controllers\User\DashboardController::class, 'editProfile']);
    Route::get('/fetch-proficiency', [App\Http\Controllers\User\DashboardController::class, 'fetchProficiency']);
    Route::post('/update-profile', [App\Http\Controllers\User\DashboardController::class, 'updateProfile']);
    Route::get('/change-password', [App\Http\Controllers\User\DashboardController::class, 'changePassword']);
    Route::post('/update-password', [App\Http\Controllers\User\DashboardController::class, 'updatePassword']);
    Route::get('/fetch-official-languages', [App\Http\Controllers\User\DashboardController::class, 'fetchOfficialLanguage']);

    Route::get('/complete-profile', [App\Http\Controllers\User\DashboardController::class, 'completeProfile'])->name("user-edit-profile");;
    Route::post('/complete-profile', [App\Http\Controllers\User\DashboardController::class, 'saveProfile'])->name("user-update-profile");;

    Route::group(array('prefix' => 'notes'), function () {
        Route::get('/', [App\Http\Controllers\User\ReminderNotesController::class, 'list']);
        Route::get('/add-reminder-note', [App\Http\Controllers\User\ReminderNotesController::class, 'addReminderNote']);
        Route::post('/add-reminder-note', [App\Http\Controllers\User\ReminderNotesController::class, 'saveReminderNote']);

        Route::get('/edit-reminder-note/{id}', [App\Http\Controllers\User\ReminderNotesController::class, 'editReminderNote']);
        Route::post('/edit-reminder-note/{id}', [App\Http\Controllers\User\ReminderNotesController::class, 'updateReminderNote']);

        Route::get('/delete/{id}', [App\Http\Controllers\User\ReminderNotesController::class, 'deleteRecord']);

    });
    Route::group(array('prefix' => 'eligibility-check'), function () {
        Route::get('/', [App\Http\Controllers\User\EligibilityCheckController::class, 'groupList']);
        Route::post('/group-ajax-list', [App\Http\Controllers\User\EligibilityCheckController::class, 'groupAjaxList']);
        Route::get('/lists/{id}', [App\Http\Controllers\User\EligibilityCheckController::class, 'list']);
        
        Route::post('/ajax-list', [App\Http\Controllers\User\EligibilityCheckController::class, 'getAjaxList']);
        Route::get('/check/{id}', [App\Http\Controllers\User\EligibilityCheckController::class, 'eligibilityCheck']);
        Route::post('/check/{id}', [App\Http\Controllers\User\EligibilityCheckController::class, 'saveEligibilityScore']);
        Route::get('/view-history', [App\Http\Controllers\User\EligibilityCheckController::class, 'userEligibilityHistory']);
        Route::post('/ajax-history', [App\Http\Controllers\User\EligibilityCheckController::class, 'eligibilityAjaxHistory']);

        Route::get('/g/{id}', [App\Http\Controllers\User\EligibilityCheckController::class, 'groupEligibilityCheck']);
        Route::post('/g/{id}', [App\Http\Controllers\User\EligibilityCheckController::class, 'saveGroupEligibilityScore']);
        Route::get('/all-group-eligibility', [App\Http\Controllers\User\EligibilityCheckController::class, 'allGroupEligibilityCheck']);
        Route::get('/group-eligibility-form', [App\Http\Controllers\User\EligibilityCheckController::class, 'getGroupEligibilityForm']);
        Route::post('/fetch-conditional', [App\Http\Controllers\User\EligibilityCheckController::class, 'fetchConditional']);
        Route::post('/fetch-group-conditional', [App\Http\Controllers\User\EligibilityCheckController::class, 'fetchGroupConditional']);
        Route::get('/report/{id}', [App\Http\Controllers\User\EligibilityCheckController::class, 'eligibilityReport']);
        Route::get('/all-eligibility', [App\Http\Controllers\User\EligibilityCheckController::class, 'allEligibility']);
        Route::get('/eligibility-form', [App\Http\Controllers\User\EligibilityCheckController::class, 'eligibilityForm']);
        Route::post('/check-pre-condition', [App\Http\Controllers\User\EligibilityCheckController::class, 'checkPreCondition']);
        
        Route::post('/check-language-proficiency', [App\Http\Controllers\User\EligibilityCheckController::class, 'checkLanguageProficiency']);
        
        Route::get('/download-report/{id}', [App\Http\Controllers\User\EligibilityCheckController::class, 'downloadReport']);

    });
    Route::get('/cv', [App\Http\Controllers\User\DashboardController::class, 'manageCv']);
    Route::get('/cv-old', [App\Http\Controllers\User\DashboardController::class, 'manageCvOld']);
    Route::post('/save-language-proficiency', [App\Http\Controllers\User\DashboardController::class, 'saveLanguageProficiency']);
    Route::group(array('prefix' => 'messages-center'), function () {
        Route::get('/', [App\Http\Controllers\User\MessagesCenterController::class, 'allMessages']);
        Route::post('/save-chat', [App\Http\Controllers\User\MessagesCenterController::class, 'saveChat']);
        Route::get('/general-chats', [App\Http\Controllers\User\MessagesCenterController::class, 'generalChats']);
        Route::get('/case-chats', [App\Http\Controllers\User\MessagesCenterController::class, 'caseChats']);
        Route::get('/document-chats', [App\Http\Controllers\User\MessagesCenterController::class, 'documentChats']);
    });
    Route::group(array('prefix' => 'chat-groups'), function () {
        Route::get('/', [App\Http\Controllers\User\ChatGroupsController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\User\ChatGroupsController::class, 'getAjaxList']); 
        Route::get('/add', [App\Http\Controllers\User\ChatGroupsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\User\ChatGroupsController::class, 'save']); 
        Route::get('/delete/{id}', [App\Http\Controllers\User\ChatGroupsController::class, 'deleteSingle']); 
        Route::post('/delete-multiple', [App\Http\Controllers\User\ChatGroupsController::class, 'deleteMultiple']); 
        Route::get('/edit/{id}', [App\Http\Controllers\User\ChatGroupsController::class, 'edit']); 
        Route::post('/update/{id}', [App\Http\Controllers\User\ChatGroupsController::class, 'update']);     
        Route::post('/change-status', [App\Http\Controllers\User\ChatGroupsController::class, 'changeStatus']);
        Route::get('/comments/{id}', [App\Http\Controllers\User\ChatGroupsController::class, 'chatGroupComments']);
        Route::post('/send-comment', [App\Http\Controllers\User\ChatGroupsController::class, 'sendComment']);
        Route::get('/fetch-comments/{id}', [App\Http\Controllers\User\ChatGroupsController::class, 'fetchComments']);
        
    }); 
    Route::group(array('prefix' => 'dependants'), function () {
        Route::get('/', [App\Http\Controllers\User\DependantsController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\User\DependantsController::class, 'getAjaxList']);
        Route::get('/add', [App\Http\Controllers\User\DependantsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\User\DependantsController::class, 'save']);
        Route::get('/edit/{id}', [App\Http\Controllers\User\DependantsController::class, 'edit']);
        Route::get('/view/{id}', [App\Http\Controllers\User\DependantsController::class, 'view']);
        Route::post('/update/{id}', [App\Http\Controllers\User\DependantsController::class, 'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\User\DependantsController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\User\DependantsController::class, 'deleteMultiple']);
    });
    Route::group(array('prefix' => 'assessments'), function () {
        Route::get('/', [App\Http\Controllers\User\AssessmentsController::class, 'index']);
        Route::post('/ajax-list', [App\Http\Controllers\User\AssessmentsController::class, 'getAjaxList']);
        Route::get('/add', [App\Http\Controllers\User\AssessmentsController::class, 'add']);
        Route::post('/save', [App\Http\Controllers\User\AssessmentsController::class, 'save']);
        Route::get('/edit/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'edit']);
        Route::get('/view/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'view']);
        Route::post('/update/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'update']);
        Route::get('/delete/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'deleteSingle']);
        Route::post('/delete-multiple', [App\Http\Controllers\User\AssessmentsController::class, 'deleteMultiple']);
        Route::post('/payment-success', [App\Http\Controllers\User\TransactionController::class, 'assessmentPaymentSuccess']);
        Route::post('/payment-failed', [App\Http\Controllers\User\TransactionController::class, 'assessmentPaymentFailed']);
        Route::post('/documents/{ass_id}/{doc_id}', [App\Http\Controllers\User\AssessmentsController::class, 'fetchDocuments']);
        Route::post('/find-professional', [App\Http\Controllers\User\AssessmentsController::class, 'findProfessional']);
        Route::post('/find-documents', [App\Http\Controllers\User\AssessmentsController::class, 'findDocuments']);
        
        Route::post('/fetch-notes', [App\Http\Controllers\User\AssessmentsController::class, 'fetchNotes']);
        Route::post('/save-notes', [App\Http\Controllers\User\AssessmentsController::class, 'saveAssessmentNote']);
        Route::post('/save-notes-file', [App\Http\Controllers\User\AssessmentsController::class, 'saveAssessmentFile']);
        
        Route::get('/visa-services', [App\Http\Controllers\User\AssessmentsController::class, 'visaServices']);

        Route::group(array('prefix' => 'forms/{assessment_id}'), function () {
            Route::get('/', [App\Http\Controllers\User\AssessmentsController::class, 'forms']);
            Route::post('/ajax-list', [App\Http\Controllers\User\AssessmentsController::class, 'getFormList']);
            Route::get('/view/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'viewForm']);
            Route::post('/save/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'saveForm']);
        });
        
        Route::group(array('prefix' => 'files'), function () {
            Route::post('/upload-documents', [App\Http\Controllers\User\AssessmentsController::class, 'uploadDocuments']);
            Route::get('/view-document/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'viewDocument']);
            Route::get('/delete/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'deleteDocument']);
        });
        
        Route::group(array('prefix' => 'google-drive'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'fetchGoogleDrive']);
            Route::post('/files-list', [App\Http\Controllers\User\AssessmentsController::class, 'googleDriveFilesList']);
            Route::post('/upload-from-gdrive', [App\Http\Controllers\User\AssessmentsController::class, 'uploadFromGdrive']);
        });
        Route::group(array('prefix' => 'dropbox'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'fetchDropboxFolder']);
            Route::post('/files-list', [App\Http\Controllers\User\AssessmentsController::class, 'dropboxFilesList']);
            Route::post('/upload-from-dropbox', [App\Http\Controllers\User\AssessmentsController::class, 'uploadFromDropbox']);
        });
        Route::get('/report/{id}', [App\Http\Controllers\User\AssessmentsController::class, 'downloadReport']);
    });
    Route::group(array('prefix' => 'connect-apps'), function () {
        Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'connectApps']);
        Route::get('/unlink/{app}', [App\Http\Controllers\User\DashboardController::class, 'unlinkApp']);
        Route::get('/google-auth', [App\Http\Controllers\User\DashboardController::class, 'googleAuthention']);
        Route::get('/connect-google', [App\Http\Controllers\User\DashboardController::class, 'connectGoogle']);
        Route::get('/dropbox-auth', [App\Http\Controllers\User\DashboardController::class, 'dropboxAuthention']);
        Route::get('/connect-dropbox', [App\Http\Controllers\User\DashboardController::class, 'connectDropbox']);

        Route::get('/google-setting', [App\Http\Controllers\User\DashboardController::class, 'googleSetting']);
        Route::get('/dropbox-setting', [App\Http\Controllers\User\DashboardController::class, 'dropboxSetting']);

        Route::post('/google-setting', [App\Http\Controllers\User\DashboardController::class, 'saveGoogleSetting']);
        Route::post('/dropbox-setting', [App\Http\Controllers\User\DashboardController::class, 'saveDropboxSetting']);

        
    });

    Route::group(array('prefix' => 'work-experiences'), function () {
        Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'workExperiences']);
        Route::get('/add', [App\Http\Controllers\User\DashboardController::class, 'addWorkExperience']);
        Route::post('/add', [App\Http\Controllers\User\DashboardController::class, 'saveWorkExperience']);
        Route::get('/edit/{id}', [App\Http\Controllers\User\DashboardController::class, 'editWorkExperience']);
        Route::post('/edit/{id}', [App\Http\Controllers\User\DashboardController::class, 'updateWorkExperience']);
        Route::get('/delete/{id}', [App\Http\Controllers\User\DashboardController::class, 'deleteExperience']);
    });
    
    Route::group(array('prefix' => 'educations'), function () {
        Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'educations']);
        Route::get('/add', [App\Http\Controllers\User\DashboardController::class, 'addEducation']);
        Route::post('/add', [App\Http\Controllers\User\DashboardController::class, 'saveEducation']);
        Route::get('/edit/{id}', [App\Http\Controllers\User\DashboardController::class, 'editEducation']);
        Route::post('/edit/{id}', [App\Http\Controllers\User\DashboardController::class, 'updateEducation']);
        Route::get('/delete/{id}', [App\Http\Controllers\User\DashboardController::class, 'deleteEducation']);
    });

    Route::get('/pay-now/{subdomain}/{transaction_id}', [App\Http\Controllers\User\TransactionController::class, 'payNow']);
    Route::post('/pay-now', [App\Http\Controllers\User\TransactionController::class, 'submitPayNow']);
    Route::post('/validate-pay-now', [App\Http\Controllers\User\TransactionController::class, 'validatePayNow']);
    Route::post('/payment-success', [App\Http\Controllers\User\TransactionController::class, 'paymentSuccess']);
    Route::post('/payment-failed', [App\Http\Controllers\User\TransactionController::class, 'paymentFailed']);

    Route::get('/professional/{subdomain}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'professionalProfile']);
    
    Route::group(array('prefix' => 'documents'), function () {
        Route::get('/', [App\Http\Controllers\User\MyDocumentsController::class, 'myFolders']);
        Route::get('/add-folder', [App\Http\Controllers\User\MyDocumentsController::class, 'addFolder']);
        Route::post('/add-folder', [App\Http\Controllers\User\MyDocumentsController::class, 'createFolder']);
        Route::get('/edit-folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'editFolder']);
        Route::post('/edit-folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'updateFolder']);
        Route::get('/delete-folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'deleteFolder']);

        Route::group(array('prefix' => 'google-drive'), function () {
            Route::get('/folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'fetchGoogleDrive']);
            Route::post('/files-list', [App\Http\Controllers\User\MyDocumentsController::class, 'googleDriveFilesList']);
            Route::post('/upload-from-gdrive', [App\Http\Controllers\User\MyDocumentsController::class, 'uploadFromGdrive']);
        });
        Route::group(array('prefix' => 'dropbox'), function () {
            Route::get('/folder/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'fetchDropboxFolder']);
            Route::post('/files-list', [App\Http\Controllers\User\MyDocumentsController::class, 'dropboxFilesList']);
            Route::post('/upload-from-dropbox', [App\Http\Controllers\User\MyDocumentsController::class, 'uploadFromDropbox']);
        });
        Route::group(array('prefix' => 'files'), function () {
            Route::get('/lists/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'folderFiles']);
            Route::get('/list-ajax', [App\Http\Controllers\User\MyDocumentsController::class, 'folderFilesAjax']);
            Route::post('/upload-documents', [App\Http\Controllers\User\MyDocumentsController::class, 'uploadDocuments']);
            Route::get('/delete/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'deleteDocument']);
            Route::post('/delete-multiple', [App\Http\Controllers\User\MyDocumentsController::class, 'deleteMultipleDocuments']);

            Route::get('/file-move-to/{file_id}', [App\Http\Controllers\User\MyDocumentsController::class, 'fileMoveTo']);
            Route::post('/file-move-to', [App\Http\Controllers\User\MyDocumentsController::class, 'moveFileToFolder']);

            Route::get('/move-files/{folder_id}', [App\Http\Controllers\User\MyDocumentsController::class, 'moveFiles']);
            Route::post('/move-files', [App\Http\Controllers\User\MyDocumentsController::class, 'moveMultipleFiles']);            

            Route::get('/view-document/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'viewDocument']);
            Route::post('/fetch-notes', [App\Http\Controllers\User\MyDocumentsController::class, 'fetchDocumentNotes']);
            Route::post('/save-notes', [App\Http\Controllers\User\MyDocumentsController::class, 'saveDocumentNote']);
            Route::post('/save-file-notes', [App\Http\Controllers\User\MyDocumentsController::class, 'saveDocumentNoteFile']);

            Route::get('/rename-file/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'renameFile']);

            Route::post('/rename-file/{id}', [App\Http\Controllers\User\MyDocumentsController::class, 'updateFilename']);

        });

        Route::get('/documents-exchanger', [App\Http\Controllers\User\MyDocumentsController::class, 'documentsExchanger']);
        Route::post('/documents-exchanger', [App\Http\Controllers\User\MyDocumentsController::class, 'saveExchangeDocuments']);
    });
     
    Route::group(array('prefix' => 'invoices'), function () {
        Route::get('/', [App\Http\Controllers\User\ProfessionalCasesController::class, 'allInvoices']);
    });
    Route::group(array('prefix' => 'tasks'), function () {
        Route::get('/', [App\Http\Controllers\User\ProfessionalCasesController::class, 'allTasks']);
    });
    Route::group(array('prefix' => 'cases'), function () {
        Route::get('/', [App\Http\Controllers\User\ProfessionalCasesController::class, 'cases']);
        Route::get('/pending', [App\Http\Controllers\User\ProfessionalCasesController::class, 'pendingCases']);
        
        Route::get('/dependants/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'caseDependants']);
        
        Route::post('/approve-case', [App\Http\Controllers\User\ProfessionalCasesController::class, 'approveCase']);
        Route::get('/tasks/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'caseTasks']);

        Route::get('/view/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'view']);
        Route::get('/activity/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'activityLog']);
        Route::get('/chats/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'chats']);
        Route::post('/fetch-chats', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchChats']);
        Route::post('/save-chat', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveChat']);
        Route::post('/save-chat-file', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveChatFile']);
        Route::get('/chat-demo', [App\Http\Controllers\User\ProfessionalCasesController::class, 'chatdemo']);
        
        Route::group(array('prefix' => 'google-drive'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchGoogleDrive']);
            Route::post('/files-list', [App\Http\Controllers\User\ProfessionalCasesController::class, 'googleDriveFilesList']);
            Route::post('/upload-from-gdrive', [App\Http\Controllers\User\ProfessionalCasesController::class, 'uploadFromGdrive']);
        });
        Route::group(array('prefix' => 'dropbox'), function () {
            Route::post('/folder/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchDropboxFolder']);
            Route::post('/files-list', [App\Http\Controllers\User\ProfessionalCasesController::class, 'dropboxFilesList']);
            Route::post('/upload-from-dropbox', [App\Http\Controllers\User\ProfessionalCasesController::class, 'uploadFromDropbox']);
        });
        Route::group(array('prefix' => 'documents'), function () {
            Route::get('/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'caseDocuments']);
            Route::get('/move-to-professional/{case_id}/{folder_id}/{subdomain}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'moveToProfessional']);
            Route::post('/move-to-professional/{case_id}/{folder_id}/{subdomain}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'copyToProfessional']);
            Route::post('/pin-case-folder', [App\Http\Controllers\User\ProfessionalCasesController::class, 'pinCaseFolder']);
            Route::get('/default/{subdomain}/{case_id}/{folder_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'defaultDocuments']);
            Route::get('/other/{subdomain}/{case_id}/{folder_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'otherDocuments']);
            Route::get('/extra/{subdomain}/{case_id}/{folder_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'extraDocuments']);
            Route::post('/copy-folder-to-extra', [App\Http\Controllers\User\ProfessionalCasesController::class, 'copyFolderToExtra']);
            Route::post('/fetch-documents', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchDocuments']);
            Route::post('/fetch-user-documents', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchUserDocuments']);
            Route::get('/remove-case-folder/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'removeCaseFolder']);
            
            Route::get('/file-move-to/{subdomain}/{case_id}/{doc_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fileMoveTo']);
            Route::get('/delete/{subdomain}/{doc_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'deleteDocument']);
            Route::post('/delete-multiple', [App\Http\Controllers\User\ProfessionalCasesController::class, 'deleteMultipleDocuments']);
            Route::post('/chats', [App\Http\Controllers\User\ProfessionalCasesController::class, 'documentChats']);
            Route::post('/fetch-chats', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchDocumentChats']);
            // Route::post('/fetch-document-chats', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchDocumentChats']);
            Route::post('/send-chats', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveDocumentChat']);
            Route::post('/send-chat-file', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveDocumentChatFile']);

            Route::get('/rename-file/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'renameFile']);
            Route::post('/rename-file/{subdomain}/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'updateFilename']);
        });
        Route::post('/upload-documents/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'uploadDocuments']);
        Route::get('/documents-exchanger/{subdomain}/{case_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'documentsExchanger']);
        Route::post('/documents-exchanger', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveExchangeDocuments']);
        Route::get('/my-documents-exchanger/{subdomain}/{case_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'myDocumentsExchanger']);
        Route::post('/my-documents-exchanger', [App\Http\Controllers\User\ProfessionalCasesController::class, 'exportMyDocuments']);
        Route::post('/remove-case-document', [App\Http\Controllers\User\ProfessionalCasesController::class, 'removeCaseDocument']);
        Route::get('/import-to-my-documents/{subdomain}/{case_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'importToMyDocuments']);
        Route::post('/import-documents', [App\Http\Controllers\User\ProfessionalCasesController::class, 'saveImportDocuments']);
        Route::post('/remove-user-document', [App\Http\Controllers\User\ProfessionalCasesController::class, 'removeUserDocument']);
        Route::get('/view-document/{case_id}/{doc_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'viewDocument']);
        Route::get('/preview-document/{case_id}/{doc_id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'previewDocument']);
        
        

        Route::group(array('prefix' => '{subdomain}/invoices'), function () {
            Route::get('/list/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'caseInvoices']);
            Route::post('/case-invoices', [App\Http\Controllers\User\ProfessionalCasesController::class, 'getCaseInvoice']);
            Route::get('/view/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'viewCaseInvoice']);
        });

        Route::group(array('prefix' => '{subdomain}/tasks'), function () {
            // Route::get('/list/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'caseInvoices']);
            Route::get('/fetch-comments/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'fetchTaskComments']);
            Route::get('/view/{id}', [App\Http\Controllers\User\ProfessionalCasesController::class, 'viewCaseTask']);
            Route::post('/send-comment', [App\Http\Controllers\User\ProfessionalCasesController::class, 'sendTaskComment']);
        });

    });
});

// Professional Admin
Route::group(array('prefix' => 'professional', 'middleware' => 'professional'), function () {
    Route::get('/', [App\Http\Controllers\Professional\DashboardController::class, 'dashboard']);
    Route::get('/profile', [App\Http\Controllers\Professional\DashboardController::class, 'profile']);
    Route::get('/articles', [App\Http\Controllers\Professional\DashboardController::class, 'articles']);
    Route::get('/events', [App\Http\Controllers\Professional\DashboardController::class, 'events']);
    Route::get('/services', [App\Http\Controllers\Professional\DashboardController::class, 'services']);
    Route::get('/complete-profile', [App\Http\Controllers\Professional\DashboardController::class, 'completeProfile']);
    Route::get('/edit-profile', [App\Http\Controllers\Professional\DashboardController::class, 'editProfile']);	
});


// Admin of Professional Side
// Route::group(array('middleware' => 'admin'), function () {
    
// });
Route::group(array('prefix' => 'admin'), function () {
  
    Route::group(array('middleware' => 'auth'), function () {
        Route::get('/complete-profile', [App\Http\Controllers\Admin\ProfileController::class, 'completeProfile']);
        Route::post('/save-profile', [App\Http\Controllers\Admin\ProfileController::class, 'saveProfile']);
        Route::post('/save-profile', [App\Http\Controllers\Admin\ProfileController::class, 'saveProfile']);

        Route::get('/edit-profile', [App\Http\Controllers\Admin\ProfileController::class, 'EditProfile']);
        Route::post('/update-profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile']);
        Route::post('/fetch-chats', [App\Http\Controllers\Admin\ProfileController::class, 'fetchSupportChats']);
        Route::post('/send-message-to-support', [App\Http\Controllers\Admin\ProfileController::class, 'sendChatToSupport']);
        Route::post('/send-file-to-support', [App\Http\Controllers\Admin\ProfileController::class, 'saveDocumentChatFile']);
    }); 
    Route::group(array('middleware' => 'admin'), function () {
        Route::get('/connect-apps', [App\Http\Controllers\Admin\DashboardController::class, 'connectApps']);
        Route::get('/google-auth', [App\Http\Controllers\Admin\DashboardController::class, 'googleAuthention']);
        Route::get('/connect-google', [App\Http\Controllers\Admin\DashboardController::class, 'connectGoogle']);
        Route::get('/notifications', [App\Http\Controllers\Admin\DashboardController::class, 'notifications']);
        Route::get('/role-privileges', [App\Http\Controllers\Admin\DashboardController::class, 'rolePrivileges']);
        Route::post('/role-privileges', [App\Http\Controllers\Admin\DashboardController::class, 'savePrivileges']);
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard']);
        Route::get('/profile', [App\Http\Controllers\Admin\DashboardController::class, 'profile']);

        Route::get('/add-reminder-note', [App\Http\Controllers\Admin\DashboardController::class, 'addReminderNote']);
        Route::post('/fetch-reminder-notes', [App\Http\Controllers\Admin\DashboardController::class, 'fetchReminderNotes']);
        Route::post('/add-reminder-note', [App\Http\Controllers\Admin\DashboardController::class, 'saveReminderNote']);

        Route::get('/edit-reminder-note/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'editReminderNote']);
        Route::post('/edit-reminder-note/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'updateReminderNote']);
        Route::get('/delete-reminder-note/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'deleteReminderNote']);
        
        

        Route::group(array('prefix' => 'services'), function () {
            Route::get('/', [App\Http\Controllers\Admin\ServicesController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\ServicesController::class, 'getAjaxList']); 
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'update']);
            Route::post('/select-services', [App\Http\Controllers\Admin\ServicesController::class, 'selectServices']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\ServicesController::class, 'deleteMultiple']);
            Route::get('/documents/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'serviceDocuments']);
            Route::get('/add-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'addFolder']);
            Route::post('/add-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'createFolder']);
            Route::get('/edit-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'editFolder']);
            Route::post('/edit-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'updateFolder']);
            Route::get('/delete-folder/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'deleteFolder']);

        });
        Route::group(array('prefix' => 'assessments'), function () {
            Route::get('/', [App\Http\Controllers\Admin\AssessmentsController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\AssessmentsController::class, 'getAjaxList']);
            Route::get('/view/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'view']);
            Route::post('/documents/{ass_id}/{doc_id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'fetchDocuments']);
            Route::post('/fetch-notes', [App\Http\Controllers\Admin\AssessmentsController::class, 'fetchNotes']);
            Route::post('/save-notes', [App\Http\Controllers\Admin\AssessmentsController::class, 'saveAssessmentNote']);
            Route::post('/save-notes-file', [App\Http\Controllers\Admin\AssessmentsController::class, 'saveAssessmentFile']);
            Route::get('/report/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'report']);
            Route::post('/report/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'saveReport']);
            Route::get('/files/view-document/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'viewDocument']);

            Route::group(array('prefix' => 'forms/{assessment_id}'), function () {
                Route::get('/', [App\Http\Controllers\Admin\AssessmentsController::class, 'forms']);
                Route::post('/ajax-list', [App\Http\Controllers\Admin\AssessmentsController::class, 'getFormList']);
                Route::get('/add', [App\Http\Controllers\Admin\AssessmentsController::class, 'addForm']);
                Route::post('/save', [App\Http\Controllers\Admin\AssessmentsController::class, 'saveForm']);
                Route::get('/edit/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'editForm']);
                Route::post('/update/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'updateForm']);
                Route::get('/delete/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'deleteFormSingle']);
                Route::post('/delete-multiple', [App\Http\Controllers\Admin\AssessmentsController::class, 'deleteMultiple']);
                Route::get('/view/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'viewForm']);
                Route::get('/send-form/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'sendAssessmentToMail']);
                Route::post('/send-form/{id}', [App\Http\Controllers\Admin\AssessmentsController::class, 'sendAssessmentLink']);
            });
        });
        Route::group(array('prefix' => 'articles'), function () {
            Route::get('/', [App\Http\Controllers\Admin\ArticlesController::class, 'publishArticles']);
            Route::get('/draft', [App\Http\Controllers\Admin\ArticlesController::class, 'draftArticles']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\ArticlesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\ArticlesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\ArticlesController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\ArticlesController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Admin\ArticlesController::class, 'update']);
            Route::get('/remove-image/{id}', [App\Http\Controllers\Admin\ArticlesController::class, 'deleteImage']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\ArticlesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\ArticlesController::class, 'deleteMultiple']);
        });
        
        Route::group(array('prefix' => 'webinar'), function () {
            Route::get('/', [App\Http\Controllers\Admin\WebinarController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\WebinarController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\WebinarController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\WebinarController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\WebinarController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Admin\WebinarController::class, 'update']);
            Route::get('/remove-image/{id}', [App\Http\Controllers\Admin\WebinarController::class, 'deleteImage']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\WebinarController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\WebinarController::class, 'deleteMultiple']);
        });

        Route::group(array('prefix' => 'staff'), function () {
            Route::get('/', [App\Http\Controllers\Admin\StaffController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\StaffController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\StaffController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\StaffController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\StaffController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Admin\StaffController::class, 'update']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\StaffController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\StaffController::class, 'deleteMultiple']);
            Route::get('/change-password/{id}', [App\Http\Controllers\Admin\StaffController::class, 'changePassword']);
            Route::post('/update-password/{id}', [App\Http\Controllers\Admin\StaffController::class, 'updatePassword']);
        });
        Route::group(array('prefix' => 'locations'), function () {
            Route::get('/', [App\Http\Controllers\Admin\LocationsController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\LocationsController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\LocationsController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\LocationsController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\LocationsController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Admin\LocationsController::class, 'update']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\LocationsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\LocationsController::class, 'deleteMultiple']);
        });
        Route::group(array('prefix' => 'time-duration'), function () {
            Route::get('/', [App\Http\Controllers\Admin\TimeDurationController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\TimeDurationController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\TimeDurationController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\TimeDurationController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\TimeDurationController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Admin\TimeDurationController::class, 'update']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\TimeDurationController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\TimeDurationController::class, 'deleteMultiple']);
        });

        Route::group(array('prefix' => 'appointment-types'), function () {
            Route::get('/', [App\Http\Controllers\Admin\AppointmentTypesController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\AppointmentTypesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\AppointmentTypesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\AppointmentTypesController::class, 'save']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\AppointmentTypesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Admin\AppointmentTypesController::class, 'update']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\AppointmentTypesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\AppointmentTypesController::class, 'deleteMultiple']);
        });


        Route::group(array('prefix' => 'events'), function () {

             Route::get('/', [App\Http\Controllers\Admin\AppointmentController::class, 'index']);
             Route::post('/event-ajax-list', [App\Http\Controllers\Admin\AppointmentController::class, 'getAjaxList']);

            Route::get('/add-event', [App\Http\Controllers\Admin\AppointmentController::class, 'addEvent']);
            Route::post('/save-event', [App\Http\Controllers\Admin\AppointmentController::class, 'saveEvent']); 

        });    

        Route::group(array('prefix' => 'appointment/{location_id}'), function () {
        
            // Route::get('/', [App\Http\Controllers\Admin\AppointmentController::class, 'index']);
            // Route::post('/event-ajax-list', [App\Http\Controllers\Admin\AppointmentController::class, 'getAjaxList']); 
            Route::get('/set-schedule', [App\Http\Controllers\Admin\AppointmentController::class, 'setSchedule']);
            Route::post('/save-schedule', [App\Http\Controllers\Admin\AppointmentController::class, 'saveSchedule']);
            Route::get('/add-event', [App\Http\Controllers\Admin\AppointmentController::class, 'addEvent']);
            Route::post('/save-event', [App\Http\Controllers\Admin\AppointmentController::class, 'saveEvent']);
        });

        Route::group(array('prefix' => 'custom-time/{location_id}'), function () {
        
            Route::get('/add', [App\Http\Controllers\Admin\AppointmentController::class, 'addCustomTime']);
            Route::post('/save', [App\Http\Controllers\Admin\AppointmentController::class, 'saveCustomTime']);
             Route::get('/edit/{id}', [App\Http\Controllers\Admin\AppointmentController::class, 'editCustomTime']);
             Route::post('/update', [App\Http\Controllers\Admin\AppointmentController::class, 'updateCustomTime']);
             Route::get('/delete/{id}', [App\Http\Controllers\Admin\AppointmentController::class, 'deleteCustomTime']);

        });

        Route::group(array('prefix' => 'leads'), function () {
            Route::get('/', [App\Http\Controllers\Admin\LeadsController::class, 'newLeads']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\LeadsController::class, 'getNewList']);
            Route::get('/clients', [App\Http\Controllers\Admin\LeadsController::class, 'leadsAsClient']);
            Route::get('/recommended', [App\Http\Controllers\Admin\LeadsController::class, 'recommendLeads']);
            Route::get('/quick-lead', [App\Http\Controllers\Admin\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Admin\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'update']);
            Route::get('/mark-as-client/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'markAsClient']);
            Route::post('/mark-as-client/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'confirmAsClient']);
            Route::get('/assign/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'assignLeads']);
            Route::post('/assign/save', [App\Http\Controllers\Admin\LeadsController::class, 'saveAssignLeads']);

            Route::get('/assessments/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'externalAssessments']);
            Route::post('/assesssments-list', [App\Http\Controllers\Admin\LeadsController::class, 'externalAssessmentsList']);
            Route::get('/assessments-view/{id}', [App\Http\Controllers\Admin\LeadsController::class, 'viewExternalAssessment']);
            Route::group(array('prefix' => 'dependants/{client_id}'), function () {
                Route::get('/', [App\Http\Controllers\Admin\DependantsController::class, 'index']);
                Route::post('/ajax-list', [App\Http\Controllers\Admin\DependantsController::class, 'getAjaxList']);
                Route::get('/add', [App\Http\Controllers\Admin\DependantsController::class, 'add']);
                Route::post('/save', [App\Http\Controllers\Admin\DependantsController::class, 'save']);
                Route::get('/edit/{id}', [App\Http\Controllers\Admin\DependantsController::class, 'edit']);
                Route::get('/view/{id}', [App\Http\Controllers\Admin\DependantsController::class, 'view']);
                Route::post('/update/{id}', [App\Http\Controllers\Admin\DependantsController::class, 'update']);
                Route::get('/delete/{id}', [App\Http\Controllers\Admin\DependantsController::class, 'deleteSingle']);
                Route::post('/delete-multiple', [App\Http\Controllers\Admin\DependantsController::class, 'deleteMultiple']);
            });
        });

        Route::group(array('prefix' => 'booked-appointments'), function () {
            Route::get('/', [App\Http\Controllers\Admin\BookedAppointmentsController::class, 'index']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\BookedAppointmentsController::class, 'getAjaxList']);
            Route::get('/status/{id}/{status}', [App\Http\Controllers\Admin\BookedAppointmentsController::class, 'changeStatus']);
            
        });
        
        Route::group(array('prefix' => 'messages-center'), function () {
            Route::get('/', [App\Http\Controllers\Admin\MessagesCenterController::class, 'allMessages']);
            Route::post('/save-chat', [App\Http\Controllers\Admin\MessagesCenterController::class, 'saveChat']);
            Route::get('/general-chats', [App\Http\Controllers\Admin\MessagesCenterController::class, 'generalChats']);
            Route::get('/case-chats', [App\Http\Controllers\Admin\MessagesCenterController::class, 'caseChats']);
            Route::get('/document-chats', [App\Http\Controllers\Admin\MessagesCenterController::class, 'documentChats']);
        });
        Route::group(array('prefix' => 'cases'), function () {
            Route::get('/', [App\Http\Controllers\Admin\CasesController::class, 'cases']);
            Route::post('/ajax-list', [App\Http\Controllers\Admin\CasesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Admin\CasesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Admin\CasesController::class, 'save']);
            Route::get('/add-group-case', [App\Http\Controllers\Admin\CasesController::class, 'addGroupCase']);
            Route::post('/add-group-case', [App\Http\Controllers\Admin\CasesController::class, 'saveGroupCase']);
            Route::get('/create-client', [App\Http\Controllers\Admin\CasesController::class, 'createClient']);
            Route::post('/create-client', [App\Http\Controllers\Admin\CasesController::class, 'createNewClient']);
            Route::post('/fetch-client-dependents', [App\Http\Controllers\Admin\CasesController::class, 'fetchClientDependents']);
            Route::get('/delete/{id}', [App\Http\Controllers\Admin\CasesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Admin\CasesController::class, 'deleteMultiple']);
            Route::get('/activity-logs/{id}', [App\Http\Controllers\Admin\CasesController::class, 'activityLog']);
            Route::get('/view/{id}', [App\Http\Controllers\Admin\CasesController::class, 'view']);
            
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\CasesController::class, 'edit']);
            Route::post('/update/{id}', [App\Http\Controllers\Admin\CasesController::class, 'update']);

            Route::get('/edit-group-case/{id}', [App\Http\Controllers\Admin\CasesController::class, 'editGroupCase']);
            Route::post('/update-group-case/{id}', [App\Http\Controllers\Admin\CasesController::class, 'updateGroupCase']);
            Route::get('/remove-assigned-user/{id}', [App\Http\Controllers\Admin\CasesController::class, 'removeAssignedUser']);

            Route::get('/view/{id}', [App\Http\Controllers\Admin\CasesController::class, 'view']);
            Route::get('/dependents/{id}', [App\Http\Controllers\Admin\CasesController::class, 'caseDependents']);
            Route::post('/remove-documents', [App\Http\Controllers\Admin\CasesController::class, 'removeDocuments']);
            Route::get('/chats/{id}', [App\Http\Controllers\Admin\CasesController::class, 'chats']);
            Route::post('/fetch-chats', [App\Http\Controllers\Admin\CasesController::class, 'fetchChats']);
            Route::post('/save-chat', [App\Http\Controllers\Admin\CasesController::class, 'saveChat']);
            Route::post('/save-chat-file', [App\Http\Controllers\Admin\CasesController::class, 'saveChatFile']);
            Route::post('/pinned-folder', [App\Http\Controllers\Admin\CasesController::class, 'pinnedFolder']);
            Route::post('/unpinned-folder', [App\Http\Controllers\Admin\CasesController::class, 'unpinnedFolder']);
            Route::group(array('prefix' => 'case-documents'), function () {
                Route::get('/preview-document/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'previewDocument']);
                Route::get('/documents/{id}', [App\Http\Controllers\Admin\CasesController::class, 'caseDocuments']);
                Route::get('/add-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'addFolder']);
                Route::post('/add-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'createFolder']);
                Route::get('/edit-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'editFolder']);
                Route::post('/edit-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'updateFolder']);
                Route::get('/delete-folder/{id}', [App\Http\Controllers\Admin\CasesController::class, 'deleteFolder']);
                Route::get('/default/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'defaultDocuments']);
                Route::get('/other/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'otherDocuments']);
                Route::get('/extra/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'extraDocuments']);
                Route::post('/upload-documents/{id}', [App\Http\Controllers\Admin\CasesController::class, 'uploadDocuments']);
                Route::get('/delete/{id}', [App\Http\Controllers\Admin\CasesController::class, 'deleteDocument']);
                Route::post('/delete-multiple', [App\Http\Controllers\Admin\CasesController::class, 'deleteMultipleDocuments']);
                Route::get('/view-document/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'viewDocument']);
                
                Route::get('/file-move-to/{file_id}/{case_id}/{doc_id}', [App\Http\Controllers\Admin\CasesController::class, 'fileMoveTo']);
                Route::post('/file-move-to', [App\Http\Controllers\Admin\CasesController::class, 'moveFileToFolder']);

                Route::get('/documents-exchanger/{case_id}', [App\Http\Controllers\Admin\CasesController::class, 'documentsExchanger']);
                Route::post('/documents-exchanger', [App\Http\Controllers\Admin\CasesController::class, 'saveExchangeDocuments']);

                Route::post('/fetch-chats', [App\Http\Controllers\Admin\CasesController::class, 'fetchDocumentChats']);
                Route::post('/send-chats', [App\Http\Controllers\Admin\CasesController::class, 'saveDocumentChat']);
                Route::post('/send-chat-file', [App\Http\Controllers\Admin\CasesController::class, 'saveDocumentChatFile']);

                Route::get('/rename-file/{id}', [App\Http\Controllers\Admin\CasesController::class, 'renameFile']);
                Route::post('/rename-file/{id}', [App\Http\Controllers\Admin\CasesController::class, 'updateFilename']);
            });
        
            Route::group(array('prefix' => 'invoices'), function () {
                Route::get('/list/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'caseInvoices']);
                Route::post('/case-invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'getCaseInvoice']);
                Route::get('/add/{case_id}', [App\Http\Controllers\Admin\InvoiceController::class, 'addCaseInvoice']);
                Route::post('/add/{case_id}', [App\Http\Controllers\Admin\InvoiceController::class, 'saveCaseInvoice']);
                Route::get('/edit/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'editCaseInvoice']);
                Route::post('/edit/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'updateCaseInvoice']);
                Route::get('/view/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'viewCaseInvoice']);
                Route::get('/delete/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'deleteSingle']);
                Route::post('/delete-multiple', [App\Http\Controllers\Admin\InvoiceController::class, 'deleteMultiple']);
            });
            
            Route::group(array('prefix' => 'tasks'), function () {
                Route::get('/list/{id}', [App\Http\Controllers\Admin\CasesController::class, 'tasks']);
                Route::post('/ajax-list', [App\Http\Controllers\Admin\CasesController::class, 'getTasksList']);
                Route::get('/add/{id}', [App\Http\Controllers\Admin\CasesController::class, 'addNewTask']);
                Route::post('/add/{id}', [App\Http\Controllers\Admin\CasesController::class, 'saveTask']);
                Route::get('/edit/{id}', [App\Http\Controllers\Admin\CasesController::class, 'editTask']);
                Route::post('/edit/{id}', [App\Http\Controllers\Admin\CasesController::class, 'updateTask']);
                Route::get('/delete/{id}', [App\Http\Controllers\Admin\CasesController::class, 'deleteSingleTask']);
                Route::post('/delete-multiple', [App\Http\Controllers\Admin\CasesController::class, 'deleteMultipleTasks']);
                Route::get('/view/{id}', [App\Http\Controllers\Admin\CasesController::class, 'viewTask']);
                Route::get('fetch-comments/{id}', [App\Http\Controllers\Admin\CasesController::class, 'fetchTaskComments']);
                Route::get('remove-file/{id}', [App\Http\Controllers\Admin\CasesController::class, 'removeTaskFile']);
                
                Route::post('/send-comment', [App\Http\Controllers\Admin\CasesController::class, 'sendTaskComment']);
                Route::post('/change-status', [App\Http\Controllers\Admin\CasesController::class, 'changeTaskComment']);
                
            });
        });

    });
});

// Manager of Professional Side
Route::group(array('prefix' => 'manager'), function () {
    Route::group(array('middleware' => 'manager'), function () {
        Route::get('/', [App\Http\Controllers\Manager\DashboardController::class, 'dashboard']);
        Route::get('/notifications', [App\Http\Controllers\Manager\DashboardController::class, 'notifications']);
        Route::get('/edit-profile', [App\Http\Controllers\Manager\DashboardController::class, 'editProfile']);
        Route::post('/update-profile/', [App\Http\Controllers\Manager\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Manager\DashboardController::class, 'changePassword']);
        Route::post('/update-password', [App\Http\Controllers\Manager\DashboardController::class, 'updatePassword']);

        Route::group(array('prefix' => 'leads'), function () {
            Route::get('/', [App\Http\Controllers\Manager\LeadsController::class, 'newLeads']);
            Route::post('/ajax-list', [App\Http\Controllers\Manager\LeadsController::class, 'getNewList']);
            Route::get('/assigned', [App\Http\Controllers\Manager\LeadsController::class, 'assignedLeads']);
            Route::get('/recommended', [App\Http\Controllers\Manager\LeadsController::class, 'recommendLeads']);
            Route::get('/quick-lead', [App\Http\Controllers\Manager\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Manager\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Manager\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'update']);
            Route::get('/recommend-as-client/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'recommendAsClient']);
            // Route::post('/mark-as-client/{id}', [App\Http\Controllers\Manager\LeadsController::class, 'confirmAsClient']);
        });

        Route::group(array('prefix' => 'cases'), function () {
            Route::get('/', [App\Http\Controllers\Manager\CasesController::class, 'cases']);
            Route::post('/ajax-list', [App\Http\Controllers\Manager\CasesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Manager\CasesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Manager\CasesController::class, 'save']);
            Route::get('/create-client', [App\Http\Controllers\Manager\CasesController::class, 'createClient']);
            Route::post('/create-client', [App\Http\Controllers\Manager\CasesController::class, 'createNewClient']);
            Route::get('/delete/{id}', [App\Http\Controllers\Manager\CasesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Manager\CasesController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Manager\CasesController::class, 'edit']);
            Route::get('/view/{id}', [App\Http\Controllers\Manager\CasesController::class, 'view']);
            Route::get('/activity-logs/{id}', [App\Http\Controllers\Manager\CasesController::class, 'activityLog']);
            Route::post('/update/{id}', [App\Http\Controllers\Manager\CasesController::class, 'update']);
            Route::post('/remove-documents', [App\Http\Controllers\Manager\CasesController::class, 'removeDocuments']);
            Route::get('/chats/{id}', [App\Http\Controllers\Manager\CasesController::class, 'chats']);
            Route::post('/fetch-chats', [App\Http\Controllers\Manager\CasesController::class, 'fetchChats']);
            Route::post('/save-chat', [App\Http\Controllers\Manager\CasesController::class, 'saveChat']);
            Route::post('/save-chat-file', [App\Http\Controllers\Manager\CasesController::class, 'saveChatFile']);
            Route::post('/pinned-folder', [App\Http\Controllers\Manager\CasesController::class, 'pinnedFolder']);
            Route::post('/unpinned-folder', [App\Http\Controllers\Manager\CasesController::class, 'unpinnedFolder']);

            Route::group(array('prefix' => 'invoices'), function () {
                Route::get('/list/{id}', [App\Http\Controllers\Manager\InvoiceController::class, 'caseInvoices']);
                Route::post('/case-invoices', [App\Http\Controllers\Manager\InvoiceController::class, 'getCaseInvoice']);
                Route::get('/add/{case_id}', [App\Http\Controllers\Manager\InvoiceController::class, 'addCaseInvoice']);
                Route::post('/add/{case_id}', [App\Http\Controllers\Manager\InvoiceController::class, 'saveCaseInvoice']);
                Route::get('/edit/{id}', [App\Http\Controllers\Manager\InvoiceController::class, 'editCaseInvoice']);
                Route::post('/edit/{id}', [App\Http\Controllers\Manager\InvoiceController::class, 'updateCaseInvoice']);
                Route::get('/view/{id}', [App\Http\Controllers\Manager\InvoiceController::class, 'viewCaseInvoice']);
                Route::get('/delete/{id}', [App\Http\Controllers\Manager\InvoiceController::class, 'deleteSingle']);
                Route::post('/delete-multiple', [App\Http\Controllers\Manager\InvoiceController::class, 'deleteMultiple']);
            });
            Route::group(array('prefix' => 'case-documents'), function () {
                Route::get('/preview-document/{case_id}/{doc_id}', [App\Http\Controllers\Manager\CasesController::class, 'previewDocument']);
                Route::get('/documents/{id}', [App\Http\Controllers\Manager\CasesController::class, 'caseDocuments']);
                Route::get('/add-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'addFolder']);
                Route::post('/add-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'createFolder']);
                Route::get('/edit-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'editFolder']);
                Route::post('/edit-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'updateFolder']);
                Route::get('/delete-folder/{id}', [App\Http\Controllers\Manager\CasesController::class, 'deleteFolder']);
                Route::get('/default/{case_id}/{doc_id}', [App\Http\Controllers\Manager\CasesController::class, 'defaultDocuments']);
                Route::get('/other/{case_id}/{doc_id}', [App\Http\Controllers\Manager\CasesController::class, 'otherDocuments']);
                Route::get('/extra/{case_id}/{doc_id}', [App\Http\Controllers\Manager\CasesController::class, 'extraDocuments']);
                Route::post('/upload-documents/{id}', [App\Http\Controllers\Manager\CasesController::class, 'uploadDocuments']);
                Route::get('/delete/{id}', [App\Http\Controllers\Manager\CasesController::class, 'deleteDocument']);
                Route::post('/delete-multiple', [App\Http\Controllers\Manager\CasesController::class, 'deleteMultipleDocuments']);

                Route::get('/file-move-to/{file_id}/{case_id}/{doc_id}', [App\Http\Controllers\Manager\CasesController::class, 'fileMoveTo']);
                Route::post('/file-move-to', [App\Http\Controllers\Manager\CasesController::class, 'moveFileToFolder']);

                Route::get('/documents-exchanger/{case_id}', [App\Http\Controllers\Manager\CasesController::class, 'documentsExchanger']);
                Route::post('/documents-exchanger', [App\Http\Controllers\Manager\CasesController::class, 'saveExchangeDocuments']);

                Route::post('/fetch-chats', [App\Http\Controllers\Manager\CasesController::class, 'fetchDocumentChats']);
                Route::post('/send-chats', [App\Http\Controllers\Manager\CasesController::class, 'saveDocumentChat']);
                Route::post('/send-chat-file', [App\Http\Controllers\Manager\CasesController::class, 'saveDocumentChatFile']);
            });
        });

        Route::group(array('prefix' => 'messages-center'), function () {
            Route::get('/', [App\Http\Controllers\Manager\MessagesCenterController::class, 'allMessages']);
            Route::post('/save-chat', [App\Http\Controllers\Manager\MessagesCenterController::class, 'saveChat']);
            Route::get('/general-chats', [App\Http\Controllers\Manager\MessagesCenterController::class, 'generalChats']);
            Route::get('/case-chats', [App\Http\Controllers\Manager\MessagesCenterController::class, 'caseChats']);
            Route::get('/document-chats', [App\Http\Controllers\Manager\MessagesCenterController::class, 'documentChats']);
        });
    });
});


// Telecaller of Professional Side
Route::group(array('prefix' => 'telecaller'), function () {
    Route::group(array('middleware' => 'telecaller'), function () {
        Route::get('/', [App\Http\Controllers\Telecaller\DashboardController::class, 'dashboard']);
        Route::get('/notifications', [App\Http\Controllers\Telecaller\DashboardController::class, 'notifications']);
        Route::get('/edit-profile', [App\Http\Controllers\Telecaller\DashboardController::class, 'editProfile']);
        Route::post('/update-profile', [App\Http\Controllers\Telecaller\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Telecaller\DashboardController::class, 'changePassword']);     
        Route::post('/update-password', [App\Http\Controllers\Telecaller\DashboardController::class, 'updatePassword']);

        Route::group(array('prefix' => 'leads'), function () {
            Route::get('/', [App\Http\Controllers\Telecaller\LeadsController::class, 'newLeads']);
            Route::post('/ajax-list', [App\Http\Controllers\Telecaller\LeadsController::class, 'getNewList']);
            Route::get('/assigned', [App\Http\Controllers\Telecaller\LeadsController::class, 'assignedLeads']);
            Route::get('/quick-lead', [App\Http\Controllers\Telecaller\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Telecaller\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Telecaller\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'update']);
            Route::get('/mark-as-client/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'markAsClient']);
            Route::post('/mark-as-client/{id}', [App\Http\Controllers\Telecaller\LeadsController::class, 'confirmAsClient']);
        });

        Route::group(array('prefix' => 'cases'), function () {
            Route::get('/', [App\Http\Controllers\Telecaller\CasesController::class, 'cases']);
            Route::post('/ajax-list', [App\Http\Controllers\Telecaller\CasesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Telecaller\CasesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Telecaller\CasesController::class, 'save']);
            Route::get('/create-client', [App\Http\Controllers\Telecaller\CasesController::class, 'createClient']);
            Route::post('/create-client', [App\Http\Controllers\Telecaller\CasesController::class, 'createNewClient']);
            Route::get('/delete/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'edit']);
            Route::get('/view/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'view']);
            Route::get('/activity-logs/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'activityLog']);

            Route::post('/update/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'update']);
            Route::post('/remove-documents', [App\Http\Controllers\Telecaller\CasesController::class, 'removeDocuments']);
            Route::get('/chats/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'chats']);
            Route::post('/fetch-chats', [App\Http\Controllers\Telecaller\CasesController::class, 'fetchChats']);
            Route::post('/save-chat', [App\Http\Controllers\Telecaller\CasesController::class, 'saveChat']);
            Route::post('/save-chat-file', [App\Http\Controllers\Telecaller\CasesController::class, 'saveChatFile']);
            Route::post('/pinned-folder', [App\Http\Controllers\Telecaller\CasesController::class, 'pinnedFolder']);
            Route::post('/unpinned-folder', [App\Http\Controllers\Telecaller\CasesController::class, 'unpinnedFolder']);

            Route::group(array('prefix' => 'invoices'), function () {
                Route::get('/list/{id}', [App\Http\Controllers\Telecaller\InvoiceController::class, 'caseInvoices']);
                Route::post('/case-invoices', [App\Http\Controllers\Telecaller\InvoiceController::class, 'getCaseInvoice']);
                Route::get('/add/{case_id}', [App\Http\Controllers\Telecaller\InvoiceController::class, 'addCaseInvoice']);
                Route::post('/add/{case_id}', [App\Http\Controllers\Telecaller\InvoiceController::class, 'saveCaseInvoice']);
                Route::get('/edit/{id}', [App\Http\Controllers\Telecaller\InvoiceController::class, 'editCaseInvoice']);
                Route::post('/edit/{id}', [App\Http\Controllers\Telecaller\InvoiceController::class, 'updateCaseInvoice']);
                Route::get('/view/{id}', [App\Http\Controllers\Telecaller\InvoiceController::class, 'viewCaseInvoice']);
                Route::get('/delete/{id}', [App\Http\Controllers\Telecaller\InvoiceController::class, 'deleteSingle']);
                Route::post('/delete-multiple', [App\Http\Controllers\Telecaller\InvoiceController::class, 'deleteMultiple']);
            });
            Route::group(array('prefix' => 'case-documents'), function () {

                Route::get('/preview-document/{case_id}/{doc_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'previewDocument']);

                Route::get('/documents/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'caseDocuments']);
                Route::get('/add-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'addFolder']);
                Route::post('/add-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'createFolder']);
                Route::get('/edit-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'editFolder']);
                Route::post('/edit-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'updateFolder']);
                Route::get('/delete-folder/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteFolder']);
                Route::get('/default/{case_id}/{doc_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'defaultDocuments']);
                Route::get('/other/{case_id}/{doc_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'otherDocuments']);
                Route::get('/extra/{case_id}/{doc_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'extraDocuments']);
                Route::post('/upload-documents/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'uploadDocuments']);
                Route::get('/delete/{id}', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteDocument']);
                Route::post('/delete-multiple', [App\Http\Controllers\Telecaller\CasesController::class, 'deleteMultipleDocuments']);

                Route::get('/file-move-to/{file_id}/{case_id}/{doc_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'fileMoveTo']);
                Route::post('/file-move-to', [App\Http\Controllers\Telecaller\CasesController::class, 'moveFileToFolder']);

                Route::get('/documents-exchanger/{case_id}', [App\Http\Controllers\Telecaller\CasesController::class, 'documentsExchanger']);
                Route::post('/documents-exchanger', [App\Http\Controllers\Telecaller\CasesController::class, 'saveExchangeDocuments']);

                Route::post('/fetch-chats', [App\Http\Controllers\Telecaller\CasesController::class, 'fetchDocumentChats']);
                Route::post('/send-chats', [App\Http\Controllers\Telecaller\CasesController::class, 'saveDocumentChat']);
                Route::post('/send-chat-file', [App\Http\Controllers\Telecaller\CasesController::class, 'saveDocumentChatFile']);
            });
        });
    });

    Route::group(array('prefix' => 'messages-center'), function () {
        Route::get('/', [App\Http\Controllers\Telecaller\MessagesCenterController::class, 'allMessages']);
        Route::post('/save-chat', [App\Http\Controllers\Telecaller\MessagesCenterController::class, 'saveChat']);
        Route::get('/general-chats', [App\Http\Controllers\Telecaller\MessagesCenterController::class, 'generalChats']);
        Route::get('/case-chats', [App\Http\Controllers\Telecaller\MessagesCenterController::class, 'caseChats']);
        Route::get('/document-chats', [App\Http\Controllers\Telecaller\MessagesCenterController::class, 'documentChats']);
    });
});

// Associate of Professional Side
Route::group(array('prefix' => 'associate'), function () {
    Route::group(array('middleware' => 'associate'), function () {
        Route::get('/', [App\Http\Controllers\Associate\DashboardController::class, 'dashboard']);
        Route::get('/notifications', [App\Http\Controllers\Associate\DashboardController::class, 'notifications']);
        Route::get('/edit-profile', [App\Http\Controllers\Associate\DashboardController::class, 'editProfile']);
        Route::post('/update-profile', [App\Http\Controllers\Associate\DashboardController::class, 'updateProfile']);
        Route::get('/change-password', [App\Http\Controllers\Associate\DashboardController::class, 'changePassword']);     
        Route::post('/update-password', [App\Http\Controllers\Associate\DashboardController::class, 'updatePassword']);
    });

    Route::group(array('prefix' => 'leads'), function () {
            Route::get('/', [App\Http\Controllers\Associate\LeadsController::class, 'newLeads']);
            Route::post('/ajax-list', [App\Http\Controllers\Associate\LeadsController::class, 'getNewList']);
            Route::get('/assigned', [App\Http\Controllers\Associate\LeadsController::class, 'assignedLeads']);
            Route::get('/quick-lead', [App\Http\Controllers\Associate\LeadsController::class, 'quickLead']);
            Route::post('/create-quick-lead', [App\Http\Controllers\Associate\LeadsController::class, 'createQuickLead']);
            Route::get('/delete/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Associate\LeadsController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'edit']);
            Route::post('/edit/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'update']);
            Route::get('/mark-as-client/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'markAsClient']);
            Route::post('/mark-as-client/{id}', [App\Http\Controllers\Associate\LeadsController::class, 'confirmAsClient']);
        });

        Route::group(array('prefix' => 'cases'), function () {
            Route::get('/', [App\Http\Controllers\Associate\CasesController::class, 'cases']);
            Route::post('/ajax-list', [App\Http\Controllers\Associate\CasesController::class, 'getAjaxList']);
            Route::get('/add', [App\Http\Controllers\Associate\CasesController::class, 'add']);
            Route::post('/save', [App\Http\Controllers\Associate\CasesController::class, 'save']);
            Route::get('/create-client', [App\Http\Controllers\Associate\CasesController::class, 'createClient']);
            Route::post('/create-client', [App\Http\Controllers\Associate\CasesController::class, 'createNewClient']);
            Route::get('/delete/{id}', [App\Http\Controllers\Associate\CasesController::class, 'deleteSingle']);
            Route::post('/delete-multiple', [App\Http\Controllers\Associate\CasesController::class, 'deleteMultiple']);
            Route::get('/edit/{id}', [App\Http\Controllers\Associate\CasesController::class, 'edit']);
            //ACTIVITY LOG ASSOCIATE
            Route::get('/activity-logs/{id}', [App\Http\Controllers\Associate\CasesController::class, 'activityLog']);

            Route::get('/view/{id}', [App\Http\Controllers\Associate\CasesController::class, 'view']);
            Route::post('/update/{id}', [App\Http\Controllers\Associate\CasesController::class, 'update']);
            Route::post('/remove-documents', [App\Http\Controllers\Associate\CasesController::class, 'removeDocuments']);
            Route::get('/chats/{id}', [App\Http\Controllers\Associate\CasesController::class, 'chats']);
            Route::post('/fetch-chats', [App\Http\Controllers\Associate\CasesController::class, 'fetchChats']);
            Route::post('/save-chat', [App\Http\Controllers\Associate\CasesController::class, 'saveChat']);
            Route::post('/save-chat-file', [App\Http\Controllers\Associate\CasesController::class, 'saveChatFile']);
            Route::post('/pinned-folder', [App\Http\Controllers\Associate\CasesController::class, 'pinnedFolder']);
            Route::post('/unpinned-folder', [App\Http\Controllers\Associate\CasesController::class, 'unpinnedFolder']);
            
            Route::group(array('prefix' => 'invoices'), function () {
                Route::get('/list/{id}', [App\Http\Controllers\Associate\InvoiceController::class, 'caseInvoices']);
                Route::post('/case-invoices', [App\Http\Controllers\Associate\InvoiceController::class, 'getCaseInvoice']);
                Route::get('/add/{case_id}', [App\Http\Controllers\Associate\InvoiceController::class, 'addCaseInvoice']);
                Route::post('/add/{case_id}', [App\Http\Controllers\Associate\InvoiceController::class, 'saveCaseInvoice']);
                Route::get('/edit/{id}', [App\Http\Controllers\Associate\InvoiceController::class, 'editCaseInvoice']);
                Route::post('/edit/{id}', [App\Http\Controllers\Associate\InvoiceController::class, 'updateCaseInvoice']);
                Route::get('/view/{id}', [App\Http\Controllers\Associate\InvoiceController::class, 'viewCaseInvoice']);
                Route::get('/delete/{id}', [App\Http\Controllers\Associate\InvoiceController::class, 'deleteSingle']);
                Route::post('/delete-multiple', [App\Http\Controllers\Associate\InvoiceController::class, 'deleteMultiple']);
            });

            Route::group(array('prefix' => 'case-documents'), function () {
                Route::get('/preview-document/{case_id}/{doc_id}', [App\Http\Controllers\Associate\CasesController::class, 'previewDocument']);
                Route::get('/documents/{id}', [App\Http\Controllers\Associate\CasesController::class, 'caseDocuments']);
                Route::get('/add-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'addFolder']);
                Route::post('/add-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'createFolder']);
                Route::get('/edit-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'editFolder']);
                Route::post('/edit-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'updateFolder']);
                Route::get('/delete-folder/{id}', [App\Http\Controllers\Associate\CasesController::class, 'deleteFolder']);
                Route::get('/default/{case_id}/{doc_id}', [App\Http\Controllers\Associate\CasesController::class, 'defaultDocuments']);
                Route::get('/other/{case_id}/{doc_id}', [App\Http\Controllers\Associate\CasesController::class, 'otherDocuments']);
                Route::get('/extra/{case_id}/{doc_id}', [App\Http\Controllers\Associate\CasesController::class, 'extraDocuments']);
                Route::post('/upload-documents/{id}', [App\Http\Controllers\Associate\CasesController::class, 'uploadDocuments']);
                Route::get('/delete/{id}', [App\Http\Controllers\Associate\CasesController::class, 'deleteDocument']);
                Route::post('/delete-multiple', [App\Http\Controllers\Associate\CasesController::class, 'deleteMultipleDocuments']);

                Route::get('/file-move-to/{file_id}/{case_id}/{doc_id}', [App\Http\Controllers\Associate\CasesController::class, 'fileMoveTo']);
                Route::post('/file-move-to', [App\Http\Controllers\Associate\CasesController::class, 'moveFileToFolder']);

                Route::get('/documents-exchanger/{case_id}', [App\Http\Controllers\Associate\CasesController::class, 'documentsExchanger']);
                Route::post('/documents-exchanger', [App\Http\Controllers\Associate\CasesController::class, 'saveExchangeDocuments']);

                Route::post('/fetch-chats', [App\Http\Controllers\Associate\CasesController::class, 'fetchDocumentChats']);
                Route::post('/send-chats', [App\Http\Controllers\Associate\CasesController::class, 'saveDocumentChat']);
                Route::post('/send-chat-file', [App\Http\Controllers\Associate\CasesController::class, 'saveDocumentChatFile']);
            });
        });

        Route::group(array('prefix' => 'messages-center'), function () {
            Route::get('/', [App\Http\Controllers\Associate\MessagesCenterController::class, 'allMessages']);
            Route::post('/save-chat', [App\Http\Controllers\Associate\MessagesCenterController::class, 'saveChat']);
            Route::get('/general-chats', [App\Http\Controllers\Associate\MessagesCenterController::class, 'generalChats']);
            Route::get('/case-chats', [App\Http\Controllers\Associate\MessagesCenterController::class, 'caseChats']);
            Route::get('/document-chats', [App\Http\Controllers\Associate\MessagesCenterController::class, 'documentChats']);
        });
});
