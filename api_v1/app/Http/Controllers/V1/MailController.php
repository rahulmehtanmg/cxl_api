<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
class MailController extends Controller
{
public function mailSend() {
    //echo 'sss';die;
$data = array('name'=>"arunkumar");
$value = Mail::send('mail', $data, function($message) {
$message->to('rahul.mehta@cxl.io', 'RahulMehta')->subject('Test Mail from Selva');
$message->from('rajiv.kumar@cxl.io','Contextlabs');
});
echo'Email Sent. Check your inbox';
}
}
