<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\MailerLiteConnector;
use App\Rules\UniqueEmail;

class MailerLiteController extends Controller
{
    protected $connector;
    private $api_stats;

    public function __construct(MailerLiteConnector $connector)
    {
        $this->connector = $connector;
        $this->api_stats  = $this->connector->getAPIStats();
    }

    public function search(Request $request)
    {
        // Getting the search and paging info
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];

        // Getting and parsing the data
        $subscribers = $this->connector->getSubscribers($length, $start, $search);

        // Serverside data table
        $columns = [
            ['db' => 'email', 'dt' => 0],
            ['db' => 'name', 'dt' => 1],
            ['db' => 'country', 'dt' => 2],
            ['db' => 'subscribe_date', 'dt' => 3],
            ['db' => 'subscribe_time', 'dt' => 4],
            ['db' => 'id', 'dt' => 5],
        ];

        $data = $this->dtOutput($columns, $subscribers, $request);
        return response()->json($data);
    }

    public function addEdit($id)
    {
        if ($id > 0) {
            $subscriber = $this->connector->findSubscriber($id);
            $subscriber->id = strval($subscriber->id);
        } else {
            $subscriber = [];
        }

        return view('addedit', ['subscriber' => $subscriber]);
    }

    public function save(Request $request)
    {
        // Validating the data
        $this->validate($request, [
            'email' => ['required', 'email', new UniqueEmail($request->id, $this->connector)],
            'name' => ['required'],
            'country' => ['required'],
        ]);

        $subscriber = ['email' => $request->email, 'name' => $request->name, 'fields' => ['country' => $request->country]];

        if ($request->id > 0) {
            return $this->connector->updateubscriber($request->id, $subscriber);
        } else {
            return $this->connector->addSubscriber($subscriber);
        }
    }

    public function delete($id, Request $request)
    {
        return $this->connector->deleteSubscriber($id);
    }

    // Custom implementation of the 'data_output' function from 'ssp.class.php'
    // https://github.com/DataTables/DataTables/blob/master/examples/server_side/scripts/ssp.class.php
    private function dtOutput($columns, $data, Request $request)
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

        $filtered = ($request->search['value']) ? count($data) : intval($this->api_stats->subscribed);

		return [
			"draw"            => isset ($request->draw) ? intval($request->draw) : 0,
			"recordsTotal"    => intval($this->api_stats->subscribed),
			"recordsFiltered" => $filtered,
			"data"            => $out
        ];
    }
}
