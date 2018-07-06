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
  // # Order by date
  function orderbyDate( Request $request, $type = null ) {
    $read =  json_decode($request->getContent(), true);
    foreach ($read as $item) {
      $date = explode(" ", $item[$type]);
      $dates[] = $date[0];
    }
    array_multisort( $dates, $read );
    return $read;
  }

  // # Order by priority
  function orderbyPriority( Request $request ) {
    $read =  json_decode( $request->getContent(), true );
    foreach ( $read as $item ) {
      $priorities[] = $item['Priority'];
    }
    array_multisort( $priorities, $read );
    return $read;
  }

  // # Filter by priority 



  function filterbyDate( Request $request, $initial = null, $final = null ) {
    $read =  json_decode( $request->getContent(), true );
    $filter = array_filter( $read, function( $item ) use ($initial, $final) {
      $dateInital = date('Y-m-d', strtotime($initial));
      $dateFinal = date('Y-m-d', strtotime($final));
      return ((explode(" ", $item['DateCreate'])[0]) > $dateInital) && 
             ((explode(" ", $item['DateCreate'])[0]) < $dateFinal);
    });
    return $filter;
  }

  // # Pagination
  function pagination( $read = null, $items = null, $number = null) {
    $page = $number;
    $total = count( $read ); // # Total items in array    
    $limit = $items; // # Per page    
    $totalPages = ceil( $total/ $limit ); // # Calculate total pages
    $page = max($page, 1); // # Get 1 page when page <= 0
    $page = min($page, $totalPages); // # Get last page when page > $totalPages
    $offset = ($page - 1) * $limit;
    if( $offset < 0 ) $offset = 0;
    $read = array_slice( $read, $offset, $limit );
    $read = array('Number' => $page, 'Pages' => $totalPages, 'Items' => $total) + $read;
    return $read;
  }
}


