<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use App\Mail;
use Illuminate\Support\Facades\Log;

class MailController extends Controller
{

	const DETECT = [
		"momo" => [
			"money" => [
				'prefix'=>"Số tiền",
				'suffixes'=>'Người gửi'
			],
			"name" => [
				'prefix'=>"Người gửi",
				'suffixes'=>'Số điện thoại người gửi'
			],
			"phone" => [
				'prefix'=>"Số điện thoại người gửi",
				'suffixes'=>'Thời gian'
			],
			"content" => [
				'prefix'=>"Lời chúc",
				'suffixes'=>'Mã giao dịch'
			],
			"time" => [
				'prefix'=>"Thời gian",
				'suffixes'=>'Lời chúc'
			],
			"deal_id" => [
				'prefix'=>"Mã giao dịch",
				'suffixes'=>'Công ty Cổ phần dịch vụ Di Động'
			],
		],
		"Zalo" => [
			"money" => ['prefix'=>"tiền",'suffixes'=>'Người'],
			"name" => ['prefix'=>"gửi",'suffixes'=>'Số'],
			"phone" => ['prefix'=>"gửi",'suffixes'=>'Thời'],
			"content" => ['prefix'=>"chúc",'suffixes'=>'Mã'],
		],	
	];

    public function index(){
    	$data = [];
    	$messages = LaravelGmail::message()->from('no-reply@momo.vn')->after('2020/7/12')->preload()->all();
		if(!empty($messages)){
			foreach ( $messages as $message ) {
				if( !Mail::where('email_id', $message->getId())->first())
				{
					$dataMail=$this->getDataAfter($message->getHtmlBody());
					if(!empty($dataMail['name']) && !empty($dataMail['money']) && $dataMail['name']!=$dataMail['money']){
						$dataMail['email_id']=$message->getId();
						$dataMail['money'] =(int) preg_replace('/\D/', '', $dataMail['money']);
						$mail = Mail::create($dataMail);
						$data[]=$dataMail;
					}
				}
			}
		}
		 return view('mail',compact('data'));
    }
    public function htmlToPlainText($str){
    	$str=strip_tags($str);
		$str = str_ireplace(array("\r","\n","\t",'\t','\r','\n'),'', $str);
	    return $str;
	}
    public function getDataDetect($array,$text){
    	$data=[];
    	foreach ($array as $key => $value) {
    		$data[$key]=trim(preg_replace('/.+'.$value['prefix'].'(.+)'.$value['suffixes'].'.+/','$1', $text));
    		$data[$key]=!empty($data[$key])?$data[$key]:'';
    	}
	    return $data;
	}

    public function getDataAfter($text){
    	$text= $this->htmlToPlainText($text);
		$data=$this->getDataDetect(self::DETECT['momo'],$text);
   		Log::info(json_encode($data));
	    return $data;
	}
}
