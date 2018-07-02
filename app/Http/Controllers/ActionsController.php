<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Response;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ActionsController extends Controller
{

    public function __construct()
    {
        
    }

    // order by
    function date(Request $request, $type = null) {
      $read =  json_decode($request->getContent(), true);
      foreach ($read as $item) {
        $date = explode(" ", $item[$type]);
        $dates[] = $date[0];
      }
      array_multisort($dates, $read);
      return $read;
    }

    function priority(Request $request) {
      $read =  json_decode($request->getContent(), true);
      foreach ($read as $item) {
        $priorities[] = $item['Priority'];
      }
      array_multisort($priorities, $read);
      return var_dump($read);
    }

   
}


