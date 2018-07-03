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
    function orderbyDate(Request $request, $type = null) {
      $read =  json_decode($request->getContent(), true);
      foreach ($read as $item) {
        $date = explode(" ", $item[$type]);
        $dates[] = $date[0];
      }
      array_multisort($dates, $read);
      return $read;
    }

    function orderbyPriority(Request $request) {
      $read =  json_decode($request->getContent(), true);
      foreach ($read as $item) {
        $priorities[] = $item['Priority'];
      }
      array_multisort($priorities, $read);
      return $read;
    }

    //filter 
    function filterbyPriority(Request $request, $type = null) {
      $read =  json_decode($request->getContent(), true);
      $priority = $type === 'pa' ? 'Prioridade Alta' : 'Prioridade Baixa';

      if( $priority === 'Prioridade Alta') {
        $filter = array_filter($read, function($item){
          return $item['Priority'] === 'Prioridade Alta';
        });
      } else {
        $filter = array_filter($read, function($item){
          return $item['Priority'] === 'Prioridade Baixa';
        });
      }


      return $filter;
    }

   
}


