<?php


use Illuminate\Support\Facades\Route;

// All roles
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DownloadController;

//-------------------------------------------------------//
//kanban
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\KanbanBoardsController;
use App\Http\Controllers\KanbanCardsController;

//-------------------------------------------------------//
//Events
use App\Http\Controllers\EventController;
use App\Http\Controllers\CalendarController;

//-------------------------------------------------------//
// PI and Manager specific
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\IaecProjectSubmissionController;
use App\Http\Controllers\EditIAECProjectController;

//-------------------------------------------------------//
// Manager specific
use App\Http\Controllers\ProjectsManagerController;
use App\Http\Controllers\UsageApprovalController;



//-------------------------------------------------------//
// Manager and Manager specific
use App\Http\Controllers\BillingController;
use App\Http\Controllers\StrainManagementController;

use App\Http\Controllers\AssignSlotsController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\InfrastructureController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\RackController;
use App\Http\Controllers\ReshuffleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomsnRacksController;
use App\Http\Controllers\VetController;
use App\Http\Controllers\FacilityHelpController;
use App\Http\Controllers\ReportsController;


//livewire - Facility Management
use App\Livewire\Occupancy;
use App\Livewire\Reorganize;
use App\Livewire\CompleteAllottment;

//livewire - Project Management
use App\Http\Controllers\Breeding\Cvhome\CVHomeController;
use App\Http\Controllers\Breeding\Cvhome\ColonyHomeController;

//livewire - Project Management
use App\Livewire\Iaec\IaecProjects;
use App\Livewire\Usage\IaecUsage;

//Breeding - Routes
use App\Http\Controllers\Breeding\BreedingHomeController;


//-------------------------------------------------------//
// Super Admin and Manager specific
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;


//livewire - Breeding/Colnoy management CV terms
use App\Livewire\Breeding\Cvterms\Approvedmatingstraincomp;
use App\Livewire\Breeding\Cvterms\Causeofdeathcomp;
use App\Livewire\Breeding\Cvterms\Coatcolorcomp;
use App\Livewire\Breeding\Cvterms\Dietcomp;
use App\Livewire\Breeding\Cvterms\Gclass;
use App\Livewire\Breeding\Cvterms\Genecomp;
use App\Livewire\Breeding\Cvterms\Generationcomp;
use App\Livewire\Breeding\Cvterms\GenotypeSpecimenLocationcomp;
use App\Livewire\Breeding\Cvterms\Lifestatuscomp;
use App\Livewire\Breeding\Cvterms\Mouseorigincomp;
use App\Livewire\Breeding\Cvterms\Mouseusecomp;
use App\Livewire\Breeding\Cvterms\Phenotypecomp;
use App\Livewire\Breeding\Cvterms\Straincomp;
use App\Livewire\Breeding\Cvterms\Strainstatuscomp;
use App\Livewire\Breeding\Cvterms\Straintypecomp;
//-------------------------------------------------------//

//livewire - Breeding/Colnoy management
use App\Livewire\Breeding\Colony\AddEntry;
use App\Livewire\Breeding\Colony\EditEntry;
use App\Livewire\Breeding\Colony\AddMating;
use App\Livewire\Breeding\Colony\EditMating;
use App\Livewire\Breeding\Colony\AddLitter;
use App\Livewire\Breeding\Colony\EditLitter;
//-------------------------------------------------------//

//Livewiere - Search Engines
use App\Livewire\Breeding\Searches\Searchmice;
use App\Livewire\Breeding\Searches\Searchmatings;
use App\Livewire\Breeding\Searches\Searchlitter;
use App\Livewire\Breeding\Searches\Searchcages;
use App\Livewire\Breeding\Searches\Searchbcages;
use App\Livewire\Breeding\Searches\Searchplugdates;
//-------------------------------------------------------//

//Livewiere - Common for PI and Manager
use App\Livewire\Common\Reagents\ManageReagents;
use App\Livewire\Common\Inventory\ManageInventory;
use App\Livewire\Common\Inventory\UpdateConsumption;
use App\Livewire\Common\Inventory\ConsumptionReplenishment;
use App\Livewire\Common\Inventory\ReviewInventory;
use App\Livewire\Common\LogBook;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/

require __DIR__.'/auth.php';

Route::get('/home/passwordReset', [
  'middleware'  => ['auth', 'verified'],
  'uses' => 'App\Http\Controllers\HomeController@passwordReset'
])->name('home/passwordReset');

Route::post('/home/pwupdate', [
  'middleware'  => ['auth', 'verified'],
  'uses' => 'App\Http\Controllers\HomeController@updatePassword'
])->name('home.pwupdate');
    
    
    
    
    
    
Route::middleware(['auth','verified'])->group(function() {    

    //------ home routes with checks ------//
    Route::get('/home', [
        //'middleware'  => ['auth', 'verified'],
        'uses' => 'App\Http\Controllers\HomeController@index'
    ])->name('home');
    // -------------- //    

    //Dashboard controller
    Route::resource('kanban', KanbanController::class);

		Route::resource('calendar', CalendarController::class);
		Route::post('calendar_mass_destroy', ['uses' => 'App\Http\Controllers\CalendarController@massDestroy', 'as' => 'calendar.mass_destroy']);

		//Kanban Boards routes
		Route::resource('kanban-boards', KanbanBoardsController::class);	
		Route::post('kanbanboards_mass_destroy', ['uses' => 'App\Http\Controllers\KanbanBoardsController@massDestroy', 'as' => 'kanban-boards.mass_destroy']);

		//Kanban Cards routes
		Route::resource('kanban-cards', KanbanCardsController::class);	
		Route::post('kanbancards_mass_destroy', ['uses' => 'App\Http\Controllers\KanbanCardsController@massDestroy', 'as' => 'kanban-cards.mass_destroy']);

		//events routes
		Route::resource('events', EventController::class);	
		Route::post('events_mass_destroy', ['uses' => 'App\Http\Controllers\EventController@massDestroy', 'as' => 'events.mass_destroy']);

    //Profile routes
    Route::resource('/profile', ProfileController::class);
    


    //-- PI specific : Projects routes
    Route::resource('/projects', ProjectsController::class);   
    
    //-- PI & Manager specific : IAEC Project submission route
    Route::post('/post-iaec-project', IaecProjectSubmissionController::class);
    Route::post('/edit-iaec-project', EditIAECProjectController::class);
    Route::resource('/reports', ReportsController::class);   


    // -- Livewire component -- //
    // -- PI group: Investigator, Researcher, Veternarian and Facility help -- //
    Route::get('iaec-projects', IaecProjects::class);
    Route::get('iaec-usage', IaecUsage::class);

    
    //-- Manager specific : Projects routes
    Route::get('/projectsmanager/{id}/submitted', [ProjectsManagerController::class, 'submitted'])->name('projectsmanager.submitted');
    //Route::post('projectsmanager/{id}',['as'=>'projectsmanager.update','uses'=>'ProjectsManagerController@update']);
    Route::resource('/projectsmanager', ProjectsManagerController::class);
    Route::resource('/usageapprovals', UsageApprovalController::class);    
    
    
    Route::resource('/bhome', BreedingHomeController::class);   

    //-- Manager: Routes for Facility
    Route::post('strains/updatestatus', [StrainManagementController::class, 'updatestatus'])->name('strains.updatestatus');
    Route::get('strains/changestatus', [StrainManagementController::class, 'changestatus'])->name('strains.changestatus');
    Route::resource('/strains', StrainManagementController::class);
    
    Route::resource('/facility', FacilityController::class);
    Route::resource('/building', BuildingController::class);
    Route::resource('/floor', FloorController::class);
    Route::resource('/room', RoomController::class);
    Route::resource('/rack', RackController::class);
    Route::resource('/roomsnracks', RoomsnRacksController::class);
    Route::resource('/assignslots', AssignSlotsController::class);

    Route::post('/reshuffle/cageUpdate', [ReshuffleController::class, 'cageUpdate']);
    Route::get('/reshuffle/fetchCages', [ReshuffleController::class, 'fetchCages']);
    Route::get('/reshuffle/fetchRacks', [ReshuffleController::class, 'fetchRacks']);
    Route::resource('/reshuffle', ReshuffleController::class);

    Route::resource('/infrastructure', InfrastructureController::class);
    Route::resource('/maintenance', MaintenanceController::class);
    
    //billing
    Route::post('billing/setperdiem', [BillingController::class, 'setperdiem'])->name('billing.setperdiem');
    Route::get('billing/perdiem', [BillingController::class, 'perdiem'])->name('billing.perdiem');
    Route::resource('/billing', BillingController::class);   

    // -- Livewire Manager -- //
    Route::get('reorganize', Reorganize::class);
    Route::get('occupancy', Occupancy::class);
    Route::get('comp-allot', CompleteAllottment::class);

    // -- CV Terms Manager -- //
    Route::get('cv-terms-home', CVHomeController::class);
    Route::get('colony-home', ColonyHomeController::class);



    // Breeding - Livewire CV Terms
    Route::get('/genecomp', Genecomp::class);
    Route::get('/gclass', Gclass::class);
    Route::get('/genotypespecimenlocation', GenotypeSpecimenLocationcomp::class);
    Route::get('/approvedmatingstrain', Approvedmatingstraincomp::class);
    Route::get('/causeofdeath', Causeofdeathcomp::class);
    Route::get('/coatcolor', Coatcolorcomp::class);
    Route::get('/diet', Dietcomp::class);
    Route::get('/generation', Generationcomp::class);
    Route::get('/lifestatus', Lifestatuscomp::class);
    Route::get('/mouseorigin', Mouseorigincomp::class);
    Route::get('/mouseuse', Mouseusecomp::class);
    Route::get('/phenotype', Phenotypecomp::class);
    Route::get('/strain', Straincomp::class);
    Route::get('/strainstatus', Strainstatuscomp::class);
    Route::get('/straintype', Straintypecomp::class);
    //Route::get('/useschedule', Useschedule::class);
    // -------------- //
        
    // Breeding - Livewire Colony Routes
    Route::get('/add-entry', AddEntry::class);
    Route::get('/edit-entry', EditEntry::class);
    Route::get('/add-mating', AddMating::class);
    Route::get('/edit-mating', EditMating::class);
    Route::get('/add-litter', AddLitter::class);
    Route::get('/edit-litter', EditLitter::class);
    // -------------- //
        
    // Breeding - Livewire Search engine
    Route::get('/searchmice', Searchmice::class);
    Route::get('/searchmatings', Searchmatings::class);
    Route::get('/searchlitter', Searchlitter::class);
    Route::get('/searchcages', Searchcages::class);
    Route::get('/searchbcages', Searchbcages::class);
    Route::get('/searchplugdates', Searchplugdates::class);
    // -------------- //



    // PI and Manager common - Livewire
    Route::get('/manage-reagents', ManageReagents::class);
    Route::get('/manage-inventory', ManageInventory::class);
    Route::get('/consumption-update', UpdateConsumption::class);
    Route::get('/consumption-replenishment', ConsumptionReplenishment::class);
    Route::get('/review-inventory', ReviewInventory::class);
    Route::get('/log-book', LogBook::class);

    // -- Download controller actions only -- //
    Route::get('/managerdownload/{id}', [DownloadController::class, 'getSubProjFile'])->name('managerSubProject.download');
    Route::get('/adminDownload/{id}', [DownloadController::class, 'getProjFile'])->name('adminProject.download');
    Route::get('/tpdownload/{id}', [DownloadController::class, 'getPiTempProjFile'])->name('pitempproject.download');
    Route::get('/download/{id}', [DownloadController::class, 'getPiProjFile'])->name('piproject.download');
    Route::get('/report/{id}', [DownloadController::class, 'getMaintainReportFile'])->name('maintenance.report');
    // -------------- //

    //-- Super admin and Manager specific routes    
		//Users routes
		Route::resource('users', UsersController::class);	
		Route::post('users_mass_destroy', ['uses' => 'App\Http\Controllers\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

		//roles routes
		Route::resource('roles', RolesController::class);	
		Route::post('roles_mass_destroy', ['uses' => 'App\Http\Controllers\RoleController@massDestroy', 'as' => 'roles.mass_destroy']);

		//permissions routes
		Route::resource('permissions', PermissionsController::class);	
		Route::post('permissions_mass_destroy', ['uses' => 'App\Http\Controllers\PermissionController@massDestroy', 'as' => 'permissions.mass_destroy']);
    
    







        
}); // end of auth and verified middle check for all routes