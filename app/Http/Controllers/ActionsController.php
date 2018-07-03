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
    function orderbyDate( Request $request, $type = null ) {
      $read =  json_decode($request->getContent(), true);
      foreach ($read as $item) {
        $date = explode(" ", $item[$type]);
        $dates[] = $date[0];
      }
      array_multisort( $dates, $read );
      return $read;
    }

    function orderbyPriority( Request $request ) {
      $read =  json_decode( $request->getContent(), true );
      foreach ( $read as $item ) {
        $priorities[] = $item['Priority'];
      }
      array_multisort( $priorities, $read );
      return $read;
    }

    //filter 
    function filterbyPriority( Request $request, $type = null ) {
      $read =  json_decode( $request->getContent(), true );
      $priority = $type === 'pa' ? 'Prioridade Alta' : 'Prioridade Baixa';

      if( $priority === 'Prioridade Alta' ) {
        $filter = array_filter( $read, function( $item ){
          return $item['Priority'] === 'Prioridade Alta';
        });
      } else {
        $filter = array_filter( $read, function( $item ){
          return $item['Priority'] === 'Prioridade Baixa';
        });
      }
      return $filter;
    }


    function filterbyDate( Request $request, $initial = null, $final = null ) {
      $read =  json_decode( $request->getContent(), true );

      $filter = array_filter( $read, function( $item ) use ($initial, $final) {
        $dateInital = date('Y-m-d', strtotime($initial));
        $dateFinal = date('Y-m-d', strtotime($final));
        return ((explode(" ", $item['DateCreate'])[0]) > $dateInital) && ((explode(" ", $item['DateCreate'])[0]) < $dateFinal);
      });

      return $filter;
    }

    // pagination

    function pagination( Request $request, $items = null, $number = null) {
      $read =  json_decode( $request->getContent(), true );

      $page = $number;
      $total = count( $read ); //total items in array    
      $limit = $items; //per page    
      $totalPages = ceil( $total/ $limit ); //calculate total pages
      $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
      $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
      $offset = ($page - 1) * $limit;
      if( $offset < 0 ) $offset = 0;

      $read = array_slice( $read, $offset, $limit );
      return $read;
    }






   
}


