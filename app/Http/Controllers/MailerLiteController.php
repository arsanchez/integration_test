<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\MailerLiteConnector;

class MailerLiteController extends Controller
{
    protected $connector;

    public function __construct(MailerLiteConnector $connector)
    {
        $this->connector = $connector;
    }

    public function search(Request $request) 
    {
        // Getting the search and paging info
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];

        // Getting and parsing the data 
        $data = [];
        $subscribers = $this->connector->getSubscribers($start, $length, $search);
        foreach ($subscribers as $s) {
            $subscribe_date = '';
            $subscribe_time = '';
            if ($s->date_subscribe) {
                list($subscribe_date, $subscribe_time) = explode(' ', $$s->date_subscribe);
            }
            $data[] = ['email' => $s->email, 'name' => $s->name, 'country' => $s->country_id,'subscribe_date' => $subscribe_date, 'subscribe_time' => $subscribe_time];
        }
        dd($data);
    }

    // Custom implementation of the 'data_output' function from 'ssp.class.php'
    // https://github.com/DataTables/DataTables/blob/master/examples/server_side/scripts/ssp.class.php
    private function dtOutput($columns, $data)
    {
        $out = array();
		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();
			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];
				// Is there a formatter?
				if ( isset( $column['formatter'] ) ) {
                    if(empty($column['db'])){
                        $row[ $column['dt'] ] = $column['formatter']( $data[$i] );
                    }
                    else{
                        $row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
                    }
				}
				else {
                    if(!empty($column['db'])){
                        $row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
                    }
                    else{
                        $row[ $column['dt'] ] = "";
                    }
				}
			}

			$out[] = $row;
		}

		return $out;
    }
}
