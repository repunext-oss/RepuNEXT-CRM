<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\GoalSheetCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{

    public function index()
    {   
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }
        $user = User::all();
        $gc = GoalSheetCategory::all();
        $repn   =   Ticket::where('isdeleted', 0)->orderBy('id','DESC')->get();
        return view('ticket.list',compact('repn','user','gc'));              
    }
    public function create()
    {
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }
        $user = User::all();
        $gc = GoalSheetCategory::all();
        return view('ticket.add',compact('user','gc'));   
    }
   
    public function store(Request $request)
    {
        // dd($request->all());
        // exit();
        // Validate the request
        if (Auth::check()) {
            session(['name' => Auth::user()->id, 'username' => Auth::user()->username]);
        }
   

        $exists = Ticket::where('ticket_subject', $request->ticket_subject)->first();
        if ($exists) {
            return redirect()->route('list.ticket')->with([
                'message' => 'Ticket with this subject already exists.',
                'alert-type' => 'warning'
            ]);
        }
    
        // Initialize the model
        $ticket = new Ticket;
        $ticket->client_user_id = session('name');;
        $ticket->ticket_subject = $request->ticket_subject;
        $ticket->product =$request->product;
        $ticket->ticket_prority = $request->ticket_prority;
        $ticket->ticket_description = $request->ticket_description;
        $ticket->ticket_status = $request->ticket_status;
    
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $filename = 'ticket_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/tickets'), $filename);
            $ticket->attachments = $filename;
        }
    
        // Save ticket
        $ticket->save();
    
        // Redirect with success message
        return redirect()->route('list.ticket')->with([
            'message' => 'Ticket created successfully!',
            'alert-type' => 'success'
        ]);
    }
    
    
    public function show($id)
    {
        $ticket   = Ticket::find($id);
        $gc = GoalSheetCategory::all();
        return view('ticket.show',compact('ticket','gc'));   
    }
    public function edit($id)
    {
        $ticket   = Ticket::find($id);
        $gc = GoalSheetCategory::all();
        return view('ticket.edit',compact('ticket','gc'));   
    }
    
    public function update(Request $request)
    {
        $ticket    =   Ticket::find($request->id); 
        $ticket->ticket_subject  =   $request['ticket_subject']; 
        $ticket->product  =   $request['product']; 
        $ticket->ticket_prority  =   $request['ticket_prority']; 
        $ticket->ticket_description  =   $request['ticket_description']; 
        $ticket->ticket_status  =   $request['ticket_status']; 
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $filename = 'ticket_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/tickets'), $filename);
            $ticket->attachments = $filename;
        }
    
        $ticket->save();     
        if($ticket){
            $notification = array(  'message' => 'Ticket edited successfully!',
                                    'alert-type' => 'success'  );
            return redirect()->route('list.ticket')->with($notification);
        }else{
            $notification = array(  'message' => 'Something went wrong, Please try again!!',
                                    'alert-type' => 'warning' );
            return redirect()->route('list.ticket')->with($notification);
        }
    }
 
    public function destroy($id)
    {
        $repn                   =   Ticket::find($id);
        $repn->isdeleted     =   "1";
        $repn->save();     
        return redirect()->route('list.ticket')->with('success','state has been deleted successfully');
    }
    public function status(Request $request)
    { 
        $repn               =   Ticket::find($request->id);  
        $repn->ticket_status    =   $request->statusval;
        $repn->save();     
        return redirect()->route('list.ticket')->with('success','state has been status successfully');
    }
}
