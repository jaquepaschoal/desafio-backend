<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Response;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TicketsController extends Controller
{


  // # Priorities
    function priority( $number = null ) {
      $read = json_decode(Storage::get('tickets.json'), true);
      $data = $this->definePriorities( $read );
      $data = $this->pagination( $data, $number);
      if($data)
        return $data;
      return new Response( ['fail' => 'Não foi possivel setar as prioridades.'] , 401);
    }

    function definePriorities( $read ) {
      $data = array();
      foreach ($read as $value) {
        $punctuation = $this->verifyTimeResolution( $value['DateCreate'], $value['DateUpdate'] );
        foreach ($value['Interactions'] as $msg) {
          $punctuation = $punctuation + $this->verifyWords( $msg['Message'] ) + $this->verifySubject( $msg['Subject'] );
        }
        $value = array( 'Priority' => $this->isPriorityHigh( $punctuation ), 'Punctuation' => $punctuation ) + $value;
        array_push($data,$value);
      }
      return $data;
    }

    function verifyTimeResolution( $create, $update ){
      $dateCreate = explode(" ", $create);
      $dateUpdate = explode(" ", $update);

      $create = new \DateTime( $dateCreate[0] );
      $update = new \DateTime( $dateUpdate[0] );

      $interval = $create->diff( $update );
      $interval = ( $interval->m * 30 ) + ( $interval->d );
      return ( $interval > 45 ? 1 : 0 ) ;
    }

    function verifyWords( $message ) {
      $badWords = array( 'Não',
                         'não', 
                         'nao foi entregue', 
                         'não foi entregue', 
                         'providências', 
                         'providencias', 
                         'não consigo',
                         'nao consigo',
                         'cancelamento',
                         'não chegou',
                         'nao chegou',
                         'não funciona',
                         'nao funciona',
                         'prazo de entrega',
                         'troco',
                         'produto',
                         'troca',
                         'errado',
                         'problema');
      $countWords = 0;
      foreach ($badWords as $words) {
        $countWords = $countWords + substr_count($message, $words);
      }
      return $countWords;
    }

    function verifySubject( $subject ) {
      return $subject === 'Reclamação' ? 4 : 0;
    }

    function isPriorityHigh( $count ) {
      if ( $count >= 3 )
        return 'Prioridade Alta';
      return 'Prioridade Baixa';
    }

    // # Order By

    function orderbyPriority( $number = null ) {
      $read = json_decode(Storage::get('tickets.json'), true);
      $data = $this->definePriorities( $read );

      foreach ( $data as $item ) {
        $priorities[] = $item['Priority'];
      }

      array_multisort( $priorities, $data );
      $data = $this->pagination( $data, $number);
      return $data;
    }

    function orderbyDate( $type = null, $number = null ) {
      $read = json_decode(Storage::get('tickets.json'), true);
      $data = $this->definePriorities( $read );

      foreach ($data as $item) {
        $date = explode(" ", $item[$type]);
        $dates[] = $date[0];
      }
      array_multisort( $dates, $data );
      $data = $this->pagination( $data, $number);
      return $data;
    }

    // # Filter

    function filterbyPriority( $type = null, $number ) {
      $read = json_decode(Storage::get('tickets.json'), true);
      $data = $this->definePriorities( $read );
      
      if( $type == 'pa' ) {
        $filter = array_filter( $data, function( $item ) {
          return $item['Priority'] === 'Prioridade Alta';
        });
      } else {
        $filter = array_filter( $data, function( $item ) {
          return $item['Priority'] === 'Prioridade Baixa';
        });
      }
      $filter = $this->pagination( $filter, $number);
      return $filter;
    }

    function filterbyDate( $initial = null, $final = null, $number = null ) {

      if(!$this->isValidDate($initial) || !$this->isValidDate($final))
        return new Response( ['fail' => 'Data não está no formato correto! (ANO-MES-DIA).'] , 401);
      
      if( strtotime($final) < strtotime($initial) )
        return new Response( ['fail' => 'Data final não pode ser maior que a inicial. '] , 401);

      $read = json_decode(Storage::get('tickets.json'), true);
      $data = $this->definePriorities( $read );

      $filter = array_filter( $data, function( $item ) use ($initial, $final) {
        $dateInital = date('Y-m-d', strtotime($initial));
        $dateFinal  = date('Y-m-d', strtotime($final));
        return ((explode(" ", $item['DateCreate'])[0]) > $dateInital) && 
               ((explode(" ", $item['DateCreate'])[0]) < $dateFinal);
      });

      $filter = $this->pagination( $filter, $number);
      return $filter;
    }

    function isValidDate($date) {
      $date = explode("-",$date);
      if( count($date) == 3) {
        $d = $date[2]; $m = $date[1]; $y = $date[0];
        $res = checkdate($m,$d,$y);
        return ($res == 1 ? true : false); 
      }
      return false;
    }

    // # Pagination
    function pagination( $read, $number ) {
      $page       = $number;
      $total      = count( $read ); // # Total items in array    
      $limit      = 3; // # Per page    
      $totalPages = ceil( $total/ $limit ); // # Calculate total pages
      $page       = max($page, 1); // # Get 1 page when page <= 0
      $page       = min($page, $totalPages); // # Get last page when page > $totalPages
      $offset     = ($page - 1) * $limit;
      if( $offset < 0 ) $offset = 0;
      $read       = array_slice( $read, $offset, $limit );
      $read       = array('Number' => $page, 'Pages' => $totalPages, 'Items' => $total) + $read;
      return $read;
    }
}


