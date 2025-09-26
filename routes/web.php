<?php
use Illuminate\Support\Facades\Route;   
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\EmailnotificationController;
use App\Http\Controllers\StateController; 
use App\Http\Controllers\DistrictController;

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
use App\Http\Controllers\GoalTaskController;
use App\Http\Controllers\GoalSheetCategoryController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\TasktimesheetController;
use App\Http\Controllers\SubDomainDetailController;
use App\Http\Controllers\TaskTimeController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SupportCallCenterController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\CorporateVideoController;
use App\Http\Controllers\TrainingVideoController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\ChatAppController;
use App\Http\Controllers\AiChatMessageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\JiraTaskController;


Route::get('/test-mail', function () {
    Mail::raw('Test email from Laravel SMTP config', function ($message) {
        $message->to('yourtestemail@gmail.com')->subject('SMTP Test');
    });

    return 'Mail sent!';
});
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () { 
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
        Route::post('/edit/user','UserUpdate')->name('update.user');
        Route::get('/get/user/{id}','UserEdit')->name('edit.user');
        Route::post('/user/destroy/{id}','destroys')->name('destroy.userlist'); 
        Route::post('/user/status','status')->name('status.userlist');
        Route::get('/add/user','adduser')->name('add.user');
        Route::post('/store/userlist','Storeuserlist')->name('store.userlist');
        Route::get('/dashboard','Dashboard')->middleware(['auth'])->name('dashboard');
        Route::get('/dashboard-data', 'Dashboard')->name('dashboard.data');

    });

    Route::controller(EmployeeController::class)->group(function(){
        Route::get('/list/employee','userlist')->name('list.employee');
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

    Route::controller(TimesheetController::class)->group(function(){      
        Route::get('/timecat/list','index')->name('list.timecat');
        Route::get('/timecat/create','create')->name('add.timecat');  
        Route::post('/timecat/store','store')->name('store.timecat');    
        Route::post('/timecat/update','update')->name('update.timecat');     
        Route::get('/timecat/edit/{id}','edit')->name('edit.timecat');
        Route::get('/timecat/view/{id}','show')->name('view.timecat'); 
        Route::post('/timecat/destroy/{id}','destroy')->name('destroy.timecat'); 
        Route::post('/timecat/status','status')->name('status.timecat');
    });

    Route::controller(TasktimesheetController::class)->group(function(){      
        Route::get('/ttimecat/list','index')->name('list.ttimecat');
        Route::get('/ttimecat/create','create')->name('add.ttimecat');  
        Route::post('/ttimecat/store','store')->name('store.ttimecat');    
        Route::post('/ttimecat/update','update')->name('update.ttimecat');     
        Route::get('/ttimecat/edit/{id}','edit')->name('edit.ttimecat');
        Route::get('/ttimecat/view/{id}','show')->name('view.ttimecat'); 
        Route::post('/ttimecat/destroy/{id}','destroy')->name('destroy.ttimecat'); 
        Route::post('/ttimecat/status','status')->name('status.ttimecat');
    }); 
    Route::controller(GoalTaskController::class)->group(function(){      
        Route::get('/goal/task/list','index')->name('list.gtask');
        Route::get('/goal/task/create','create')->name('add.gtask');  
        Route::post('/goal/task/store','store')->name('store.gtask');    
        Route::post('/goal/task/update','update')->name('update.gtask');     
        Route::get('/goal/task/edit/{id}','edit')->name('edit.gtask');
        Route::get('/goal/task/view/{id}','show')->name('view.gtask'); 
        Route::post('/goal/start','start');
        Route::post('/goal/pause/{id}', 'pause');
        Route::post('/goal/stop/{id}','stop'); 
        Route::post('/goal/task/destroy/{id}','destroy')->name('destroy.gtask'); 
        Route::post('/goal/task/status','status')->name('status.gtask');
        // Route::post('/goalsheet/filtertasks', 'filterTasks')->name('goalsheet.filterTasks');
    }); 

    Route::controller(GoalSheetCategoryController::class)->group(function(){      
        Route::get('/goalsheet/category/list','index')->name('list.gscategory');
        Route::get('/goalsheet/category/create','create')->name('add.gscategory');  
        Route::post('/goalsheet/category/store','store')->name('store.gscategory');    
        Route::post('/goalsheet/category/update','update')->name('update.gscategory');     
        Route::get('/goalsheet/category/edit/{id}','edit')->name('edit.gscategory');
        Route::get('/goalsheet/category/view/{id}','show')->name('view.gscategory'); 
        Route::post('/goalsheet/category/destroy/{id}','destroy')->name('destroy.gscategory'); 
        Route::post('/goalsheet/category/status','status')->name('status.gscategory');
    });
 
    Route::controller(TaskTimeController::class)->group(function(){      
        Route::get('/tasktime/list','index')->name('list.time');
        Route::get('/tasktime/create','create')->name('add.time');  
        Route::post('/tasktime/store','store')->name('store.time');    
        Route::post('/tasktime/update','update')->name('update.time');     
        Route::get('/tasktime/edit/{id}','edit')->name('edit.time');
        Route::get('/tasktime/view/{id}','show')->name('view.time'); 
        Route::post('/tasktime/destroy/{id}','destroy')->name('destroy.time'); 
        Route::post('/tasktime/status','status')->name('status.time');
    });

    Route::controller(SubDomainDetailController::class)->group(function(){      
        Route::get('/project/subdomain/list','index')->name('list.sddetail');
        Route::get('/project/subdomain/create','create')->name('add.sddetail');  
        Route::post('/project/subdomain/store','store')->name('store.sddetail');    
        Route::post('/project/subdomain/update','update')->name('update.sddetail');     
        Route::get('/project/subdomain/edit/{id}','edit')->name('edit.sddetail');
        Route::get('/project/subdomain/view/{id}','show')->name('view.sddetail'); 
        Route::post('/project/subdomain/destroy/{id}','destroy')->name('destroy.sddetail'); 
        Route::post('/project/subdomain/status','status')->name('status.sddetail');
    });

    Route::controller(SocialMediaController::class)->group(function(){      
        Route::get('/social/media/list','index')->name('list.smedia');
        Route::get('/social/media/create','create')->name('add.smedia');  
        Route::post('/social/media/store','store')->name('store.smedia');    
        Route::post('/social/media/update','update')->name('update.smedia');     
        Route::get('/social/media/edit/{id}','edit')->name('edit.smedia');
        Route::get('/social/media/view/{id}','show')->name('view.smedia'); 
        Route::post('/social/media/destroy/{id}','destroy')->name('destroy.smedia'); 
        Route::post('/social/media/status','status')->name('status.smedia');
    });
    Route::controller(CorporateVideoController::class)->group(function(){      
        Route::get('/corporate/video/list','index')->name('list.cvideo');
        Route::get('/corporate/video/create','create')->name('add.cvideo');    
        Route::post('/corporate/video/store','store')->name('store.cvideo');    
        Route::post('/corporate/video/update','update')->name('update.cvideo');     
        Route::get('/corporate/video/edit/{id}','edit')->name('edit.cvideo');
        Route::get('/corporate/video/view/{id}','show')->name('view.cvideo'); 
        Route::post('/corporate/video/destroy/{id}','destroy')->name('destroy.cvideo'); 
        Route::post('/corporate/video/status','status')->name('status.cvideo');
        Route::get('/download-document/{id}','downloadDocument')->name('download.document'); 
        Route::get('/view-document/{id}','viewDocument')->name('view.document'); 
    });

    Route::controller(TrainingVideoController::class)->group(function(){      
        Route::get('/training/video/list','index')->name('list.tvideos');
        Route::get('/training/video/create','create')->name('add.tvideos');  
        Route::post('/training/video/store','store')->name('store.tvideos');    
        Route::post('/training/video/update','update')->name('update.tvideos');     
        Route::get('/training/video/edit/{id}','edit')->name('edit.tvideos');
        Route::get('/training/video/view/{id}','show')->name('view.tvideos'); 
        Route::post('/training/video/destroy/{id}','destroy')->name('destroy.tvideos'); 
        Route::post('/training/video/status','status')->name('status.tvideos');
        Route::get('/download/{filename}','download')->name('download.file'); 
        Route::get('/view-pdf/{filename}','viewPDF')->name('view.pdf'); 

    });
Route::controller(LeaveController::class)->group(function(){      
        Route::get('/leave/list','index')->name('list.leave');
        Route::get('/leave/create','create')->name('add.leave');  
        Route::post('/leave/store','store')->name('store.leave');    
        Route::post('/leave/update','update')->name('update.leave');     
        Route::get('/leave/edit/{id}','edit')->name('edit.leave');
        Route::get('/leave/view/{id}','show')->name('view.leave'); 
        Route::post('/leave/destroy/{id}','destroy')->name('destroy.leave'); 
        Route::post('/leave/status','status')->name('status.leave');
        Route::post('/send-response-email', 'sendResponseEmail')->name('send.leave');
        Route::post('/update-leave-status', 'updateLeaveStatus')->name('upt.leave');
        Route::post('/leave/approve','approveLeave')->name('approve.leave');
        Route::post('/leaves/reject','reject')->name('leaves.reject');
        Route::get('/leave/balance','showLeaveBalance')->name('leave.balance');
        Route::get('/fetch-leave-balance','fetchLeaveBalance')->name('leave.fetchBalance');
        Route::get('/leave/management/create','lmcreate')->name('add.leaveManagement');  
        Route::post('/leave/management/store','lmstore')->name('store.leaveManagement');    
        });
    Route::controller(SupportCallCenterController::class)->group(function(){      
        Route::get('/support/list','index')->name('list.support');
        Route::get('/support/create','create')->name('add.support');  
        Route::post('/support/store','store')->name('store.support');    
        Route::post('/support/update','update')->name('update.support');     
        Route::get('/support/edit/{id}','edit')->name('edit.support');
        Route::get('/support/view/{id}','show')->name('view.support'); 
        Route::post('/support/destroy/{id}','destroy')->name('destroy.support'); 
        Route::post('/support/status','status')->name('status.support');
    });
    Route::controller(FollowupController::class)->group(function(){      
        Route::get('/followup/list','index')->name('list.followup');
        Route::get('/followup/create','create')->name('add.followup');  
        Route::post('/followup/store','store')->name('store.followup');    
        Route::post('/followup/update','update')->name('update.followup');     
        Route::get('/followup/edit/{id}','edit')->name('edit.followup');
        Route::get('/followup/view/{id}','show')->name('view.followup'); 
        Route::post('/followup/destroy/{id}','destroy')->name('destroy.followup'); 
        Route::post('/followup/status','status')->name('status.followup');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/chat/{id}', [RoomController::class, 'show'])->name('chat.show');
        Route::post('/chat/{id}/send', [RoomController::class, 'sendMessage'])->name('chat.sends');
        Route::post('/rooms/{id}/add-users', [RoomController::class, 'addUsers'])->name('rooms.addUsers');
        Route::post('/rooms/{id}/remove-user', [RoomController::class, 'removeUser'])->name('rooms.removeUser');
        Route::post('/rooms/destroy/{id}', [RoomController::class,'destroy'])->name('rooms.destroy'); 
        Route::post('/message/destroy/{id}', [MessageController::class,'destroy'])->name('message.destroy');
    });
    
    Route::controller(SalesOrderController::class)->group(function(){
        Route::get('/salesorder','index')->name('list.salesorder');
        Route::get('/salesorder/add','create')->name('add.salesorder');
        Route::post('/salesorder/store','store')->name('store.salesorder');
        Route::get('/salesorder/view/{id}','show')->name('view.salesorder'); 
        Route::get('/salesorder/preview/{id}','preview')->name('preview.salesorder');
        Route::post('/salesorder/update/{id}','update')->name('update.salesorder');
        Route::delete('/salesorder/destroy/{id}','destroy')->name('destroy.salesorder');
        Route::post('/salesorder/status','status')->name('status.salesorder');
    });
    
    Route::controller(ChatAppController::class)->group(function(){
        Route::get('/chatapp','index')->name('list.chatapp');
        Route::post('/chat/send', 'sendMessage')->name('chat.send');
        Route::post('/chat/fetch', 'fetchMessages')->name('chat.fetch');
        Route::post('/chat/delete','deleteMessage')->name('chat.delete');
        Route::post('/chat/typing','typing')->name('chat.typing');
        Route::post('/chat/stopped_typing','stoppedTyping')->name('chat.stopped_typing');
    });
    Route::controller(AiChatMessageController::class)->group(function(){ 
        Route::get('/ai/chat',  'index')->name('aichat.index');
        Route::post('/ai/chat',  'send')->name('aichat.send');
    });
   Route::controller(InternController::class)->group(function(){
        Route::get('/intern/list','index')->name('list.intern');
        Route::post('/intern/store','store')->name('store.intern');    
        Route::post('/intern/update','update')->name('update.intern');     
        Route::get('/intern/edit/{id}','edit')->name('edit.intern');
        Route::get('/intern/view/{id}','show')->name('view.intern'); 
        Route::post('/intern/destroy/{id}','destroy')->name('destroy.intern'); 
        Route::post('/intern/status','status')->name('status.intern');
    });

   Route::get('/revenue-expense',[RevenueController::class, 'index'])->name('revenue-expense.index'); 
   Route::get('/add-entry',      [RevenueController::class, 'create'])->name('revenue.create');       
   Route::post('/store-entry',   [RevenueController::class, 'store'])->name('revenue.store');         


    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index'); 
    Route::get('/bookings', [BookingController::class, 'fetch'])->name('booking.fetch'); 
    Route::post('/bookings', [BookingController::class, 'store'])->name('booking.store'); 
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('booking.destroy'); 
     
     // Availability Routes
     Route::controller(AvailabilityController::class)->group(function(){
         Route::get('/availability', 'index')->name('availability.index');
         Route::get('/availability/create', 'create')->name('availability.create');
         Route::post('/availability', 'store')->name('availability.store');
         Route::get('/availability/calendar', 'calendar')->name('availability.calendar');
         Route::get('/availability/bulk-create', 'bulkCreateForm')->name('availability.bulk-create');
         Route::post('/availability/bulk', 'bulkCreate')->name('availability.bulk-store');
         Route::get('/availability/check-form', 'checkForm')->name('availability.check-form');
         Route::get('/availability/user/{userId}', 'getUserAvailability')->name('availability.user');
         Route::post('/availability/date-range', 'getAvailabilityForDateRange')->name('availability.date-range');
         Route::post('/availability/check', 'checkAvailability')->name('availability.check');
         Route::post('/availability/slots', 'getAvailableSlots')->name('availability.slots');
         Route::post('/availability/test', 'testAvailability')->name('availability.test');
         Route::get('/availability/debug', 'debugAvailability')->name('availability.debug');
         Route::get('/availability/{id}', 'show')->name('availability.show');
         Route::get('/availability/{id}/edit', 'edit')->name('availability.edit');
         Route::put('/availability/{id}', 'update')->name('availability.update');
         Route::delete('/availability/{id}', 'destroy')->name('availability.destroy');
         Route::post('/availability/{id}/toggle', 'toggleStatus')->name('availability.toggle');
     }); 
 
     Route::controller(InternController::class)->group(function(){
      
        Route::get('/karthik','create')->name('add.intern');  
        Route::post('/intern/store','store')->name('store.intern');    
        Route::post('/intern/update','update')->name('update.intern');     
        Route::get('/intern/edit/{id}','edit')->name('edit.intern');
        Route::get('/intern/view/{id}','show')->name('view.intern'); 
        Route::post('/intern/destroy/{id}','destroy')->name('destroy.intern'); 
        Route::post('/intern/status','status')->name('status.intern');
    });

    // Jira Tasks Routes
    Route::controller(JiraTaskController::class)->group(function(){
        Route::get('/jira-tasks/board', 'index')->name('jira-tasks.board');
        Route::get('/jira-tasks/create', 'create')->name('jira-tasks.create');
        Route::post('/jira-tasks/store', 'store')->name('jira-tasks.store');
        Route::get('/jira-tasks/show/{id}', 'show')->name('jira-tasks.show');
        Route::get('/jira-tasks/details/{id}', 'getTaskDetails')->name('jira-tasks.details');
        Route::get('/jira-tasks/edit/{id}', 'edit')->name('jira-tasks.edit');
        Route::put('/jira-tasks/update/{id}', 'update')->name('jira-tasks.update');
        Route::delete('/jira-tasks/destroy/{id}', 'destroy')->name('jira-tasks.destroy');
        Route::post('/jira-tasks/update-status', 'updateStatus')->name('jira-tasks.updateStatus');
        Route::post('/jira-tasks/assign', 'assignTask')->name('jira-tasks.assign');
        Route::get('/jira-tasks/backlog', 'backlog')->name('jira-tasks.backlog');
        Route::post('/jira-tasks/{id}/add-comment', 'addComment')->name('jira-tasks.add-comment');
        Route::delete('/jira-tasks/{id}/delete-comment', 'deleteComment')->name('jira-tasks.delete-comment');
    });
 
});
require __DIR__.'/auth.php';
