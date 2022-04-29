<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = [];
        // $uid = 1;
        // for($i=1;$i<=167;$i++){
        //     $uid++;
        //     $data[] = [

        //             "uid"=> $uid,
        //             "id"=> $i,
        //             "state"=> 1,
        //             "timestamp"=> "2022-04-20 08:00:00",
        //             "type"=> 0
        //     ];
        //     $uid++;
        //     $data[] = [

        //         "uid"=> $uid,
        //         "id"=> $i,
        //         "state"=> 1,
        //         "timestamp"=> "2022-04-20 17:00:00",
        //         "type"=> 1
        // ];
        // }
        // $return['attendances'] = $data;
        // $return['branch'] = env('BRANCH_ID');
        // return $return;


        $zk = new ZKTeco(config('zkteco.ip'));
        $zk->connect();
        $data = $zk->getAttendance();
        $zk->disconnect();

        

        $return['attendances'] = $data;
        $return['branch'] = env('BRANCH_ID');
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => env('API_URL').'attendance',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode($return),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.env('AUTH_TOKEN'),
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        
        echo 'นำเข้ารายชื่อ '.$response.' รายการ';
        curl_close($curl);
        

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => env('API_URL').'TransferDataTimeWork',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "branch": "'.env('BRANCH_ID').'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.env('AUTH_TOKEN'),
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        echo '<br>';
        echo 'ประมวลผลสำเร็จ '.$response.' รายการ';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
