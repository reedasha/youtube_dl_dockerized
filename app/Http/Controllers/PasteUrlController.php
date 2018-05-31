<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

class PasteUrlController extends Controller
{
    
    public function store(Request $request)
    {
        $file = $request->input('link');
        $file_headers = @get_headers($file);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
           return view('welcome');
        }
        else {
          //  return redirect()->away('https://google.com');
        Log::info('Your link is ' .$file);  
        $result = exec('python /var/www/script.py ' .$file);
        Log::info('Your link is ' .$result);
        date_default_timezone_set('Asia/Bishkek');
        $date = date('Y/m/d H:i:s');
        file_put_contents('/var/www/requests.txt', "\r\n" .$file ." " .$date, FILE_APPEND);
        
        return redirect()->away($result);
        }
        
      
    }

   
}
