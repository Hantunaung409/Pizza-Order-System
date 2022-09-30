<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\MessageStatus;

class ContactController extends Controller
{
    //direct message list page
    public function messageListPage(){
        $messages = Contact::select('contacts.*','message_statuses.message_code as code')
                            ->leftJoin('message_statuses','message_statuses.message_code','contacts.message_code')
                            ->paginate('10');
        $newMessage = MessageStatus::get();

        return view('admin.message.messageList',compact('messages','newMessage'));
    }

    //ajax message
    public function ajaxMessage(Request $request){
        MessageStatus::where('message_code',$request->messageCode)->delete();
    }

    //direct message detail page
    public function messageDetail($messageCode){
        $mDetail = Contact::select('contacts.*','users.image as user_image','users.phone as user_phone','users.gender as user_gender')
                                  ->leftJoin('users','users.name','contacts.name')
                                  ->where('contacts.message_code',$messageCode)
                                  ->orderBy('contacts.id','desc')
                                  ->first();
                                //   dd($mDetail);
        return view('admin.message.messageDetail',compact('mDetail'));
    }

    //delete message
    public function messageDelete($id){
        Contact::where('id',$id)->delete();
        return redirect()->route('admin@messageListPage')->with(['deleted' => 'A Message Was Deleted!']);
    }
}
