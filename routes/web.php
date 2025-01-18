<?php

use Illuminate\Support\Facades\Route;   
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\EmailnotificationController;
use App\Http\Controllers\StateController; 
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\CallCenterController;
use App\Http\Controllers\MasterController; 
use App\Http\Controllers\InventoryController;  
use App\Http\Controllers\StorageController;  
use App\Http\Controllers\EmployeeController;    
use App\Http\Controllers\WebsitecredentialController;
use App\Http\Controllers\ProjectServiceController;
use App\Http\Controllers\ProjectDetailController;
use App\Http\Controllers\TimeDetailController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ToolsTypeController;
use App\Http\Controllers\HostDetailsController;
use App\Http\Controllers\DomainDetailController;
use App\Http\Controllers\ToolsCredentialsController;


Route::get('/', function () {
    return view('auth.login');
    //return view('welcome');
});

Route::controller(AdminController::class)->group(function(){
    Route::get('/admin/logout','destroy')->name('admin.logout');
    Route::get('/admin/profile','Profile')->name('admin.profile');
    Route::get('/edit/profile','EditProfile')->name('edit.profile');
    Route::post('/update/email','UpdateEmail')->name('update.email');
    Route::post('/update/password','UpdatePassword')->name('update.password');
    Route::post('/store/profile','StoreProfile')->name('store.profile');
    Route::post('/store/rolelist','Storerolelist')->name('store.rolelist');
    Route::post('/update/rolelist','Updaterolelist')->name('update.rolelist');
    Route::post('/delete/rolelist','Deleterolelist')->name('delete.rolelist');
    Route::post('/edit/role','Editrolelist')->name('edit.rolelist');
    Route::get('/list/role','rolelist')->name('list.role');
    Route::get('/view/role','roleview')->name('view.role');
    Route::get('/list/user','userlist')->name('list.user');
    Route::post('/delete/userlist','Deleteuserlist')->name('delete.userlist');
    Route::get('/add/user','adduser')->name('add.user');
    Route::post('/store/userlist','Storeuserlist')->name('store.userlist');
    Route::get('/dashboard','Dashboard')->middleware(['auth'])->name('dashboard');
});

Route::controller(EmployeeController::class)->group(function(){
    Route::get('/list/employee','userlist')->name('list.employee');
    // Route::post('/delete/userlist','Deleteuserlist')->name('delete.userlist');
    // Route::post('/store/userlist','Storeuserlist')->name('store.userlist');
});

Route::controller(CallCenterController::class)->group(function(){
    Route::get('/callcenter','index')->name('callcenter.callcenter');
    Route::get('/callcenter/add','add')->name('callcenter.add');
    Route::post('/callcenter/store','store')->name('callcenter.store');
    Route::put('/callcenter/update','update')->name('callcenter.update');
    Route::get('/callcenter/edit/{id}','edit')->name('callcenter.edit');
    Route::get('/callcenter/view/{id}','show')->name('callcenter.view'); 
    Route::post('/callcenter/destroy/{id}','destroy')->name('callcenter.delete'); 
});

Route::controller(WebsitecredentialController::class)->group(function(){
    Route::get('/websitecredentials','index')->name('website.main');
    Route::get('/websitecredentials/add','add')->name('website.add');
    Route::post('/websitecredentials/store','store')->name('website.store');
    Route::get('/websitecredentials/{d}/edit','edit')->name('website.edit');
    Route::put('/websitecredentials/{d}/update','update')->name('website.update');
    Route::get('/websitecredentials/{d}/view','view')->name('website.view');
});

Route::controller(ProjectServiceController::class)->group(function(){      
    Route::get('/project/service/list','index')->name('list.pservice');
    Route::get('/project/service/create','create')->name('add.pservice');  
    Route::post('/project/service/store','store')->name('store.pservice');    
    Route::post('/project/service/update','update')->name('update.pservice');     
    Route::get('/project/service/edit/{id}','edit')->name('edit.pservice');
    Route::get('/project/service/view/{id}','show')->name('view.pservice'); 
    Route::post('/project/service/destroy/{id}','destroy')->name('destroy.pservice'); 
    Route::post('/project/service/status','status')->name('status.pservice');
});

Route::controller(ProjectDetailController::class)->group(function(){      
    Route::get('/project/detail/list','index')->name('list.pdetail');
    Route::get('/project/detail/create','create')->name('add.pdetail');  
    Route::post('/project/detail/store','store')->name('store.pdetail');    
    Route::post('/project/detail/update','update')->name('update.pdetail');     
    Route::get('/project/detail/edit/{id}','edit')->name('edit.pdetail');
    Route::get('/project/detail/view/{id}','show')->name('view.pdetail'); 
    Route::post('/project/detail/destroy/{id}','destroy')->name('destroy.pdetail'); 
    Route::post('/project/detail/status','status')->name('status.pdetail');
});

Route::controller(TimeDetailController::class)->group(function(){      
    Route::get('/project/timeline/list','index')->name('list.ptime');
    Route::get('/project/timeline/create','create')->name('add.ptime');  
    Route::post('/project/timeline/store','store')->name('store.ptime');    
    Route::post('/project/timeline/update','update')->name('update.ptime');     
    Route::get('/project/timeline/edit/{id}','edit')->name('edit.ptime');
    Route::get('/project/timeline/view/{id}','show')->name('view.ptime'); 
    Route::post('/project/timeline/destroy/{id}','destroy')->name('destroy.ptime'); 
    Route::post('/project/timeline/status','status')->name('status.ptime');
});

Route::controller(TypeController::class)->group(function(){      
    Route::get('/project/types/list','index')->name('list.ttime');
    Route::get('/project/types/create','create')->name('add.ttime');  
    Route::post('/project/types/store','store')->name('store.ttime');    
    Route::post('/project/types/update','update')->name('update.ttime');     
    Route::get('/project/types/edit/{id}','edit')->name('edit.ttime');
    Route::get('/project/types/view/{id}','show')->name('view.ttime'); 
    Route::post('/project/types/destroy/{id}','destroy')->name('destroy.ttime'); 
    Route::post('/project/types/status','status')->name('status.ttime');
});

Route::controller(ToolsTypeController::class)->group(function(){      
    Route::get('/project/toolstype/list','index')->name('list.tooltime');
    Route::get('/project/toolstype/create','create')->name('add.tooltime');  
    Route::post('/project/toolstype/store','store')->name('store.tooltime');    
    Route::post('/project/toolstype/update','update')->name('update.tooltime');     
    Route::get('/project/toolstype/edit/{id}','edit')->name('edit.tooltime');
    Route::get('/project/toolstype/view/{id}','show')->name('view.tooltime'); 
    Route::post('/project/toolstype/destroy/{id}','destroy')->name('destroy.tooltime'); 
    Route::post('/project/toolstype/status','status')->name('status.tooltime');
});

Route::controller(HostDetailsController::class)->group(function(){      
    Route::get('/project/host/list','index')->name('list.hdetail');
    Route::get('/project/host/create','create')->name('add.hdetail');   
    Route::post('/project/host/store','store')->name('store.hdetail');    
    Route::post('/project/host/update','update')->name('update.hdetail');     
    Route::get('/project/host/edit/{id}','edit')->name('edit.hdetail');
    Route::get('/project/host/view/{id}','show')->name('view.hdetail'); 
    Route::post('/project/host/destroy/{id}','destroy')->name('destroy.hdetail'); 
    Route::post('/project/host/status','status')->name('status.hdetail');
});

Route::controller(DomainDetailController::class)->group(function(){      
    Route::get('/project/domain/list','index')->name('list.ddetail');
    Route::get('/project/domain/create','create')->name('add.ddetail');  
    Route::post('/project/domain/store','store')->name('store.ddetail');    
    Route::post('/project/domain/update','update')->name('update.ddetail');     
    Route::get('/project/domain/edit/{id}','edit')->name('edit.ddetail');
    Route::get('/project/domain/view/{id}','show')->name('view.ddetail'); 
    Route::post('/project/domain/destroy/{id}','destroy')->name('destroy.ddetail'); 
    Route::post('/project/domain/status','status')->name('status.ddetail');
});

Route::controller(ToolsCredentialsController::class)->group(function(){      
    Route::get('/project/toolcred/list','index')->name('list.toolcred');
    Route::get('/project/toolcred/create','create')->name('add.toolcred');  
    Route::post('/project/toolcred/store','store')->name('store.toolcred');    
    Route::post('/project/toolcred/update','update')->name('update.toolcred');     
    Route::get('/project/toolcred/edit/{id}','edit')->name('edit.toolcred');
    Route::get('/project/toolcred/view/{id}','show')->name('view.toolcred'); 
    Route::post('/project/toolcred/destroy/{id}','destroy')->name('destroy.toolcred'); 
    Route::post('/project/toolcred/status','status')->name('status.toolcred');
});

require __DIR__.'/auth.php';
