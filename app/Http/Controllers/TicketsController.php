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

    public function __construct()
    {
        
    }

    function priority(Request $request) {
      $read =  json_decode($request->getContent(), true);
      $data = array();

      foreach ($read as $value) {
        $ticketID = $value['TicketID'];
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

      $date1 = new \DateTime( $dateCreate[0] );
      $date2 = new \DateTime( $dateUpdate[0] );

      $interval = $date1->diff( $date2 );
      $interval = ( $interval->m * 30 ) + ( $interval->d );
      return ( $interval > 45 ? 1 : 0 ) ;
    }

    function verifyWords( $message ) {
      $badWords = array('Mas', 'quanto');
      $countWords = 0;
      foreach ($badWords as $item) {
        $countWords = $countWords + substr_count($message, $item);
      }
      return $countWords;
    }

    function verifySubject( $subject ) {
      return $subject === 'Reclamação' ? 4 : 0;
    }

    function isPriorityHigh( $count ) {
      if ( $count >= 4 )
        return 'Prioridade Alta';
      return 'Prioridade Baixa';
    }
}


