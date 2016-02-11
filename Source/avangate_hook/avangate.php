<?php
/*
The status of the order:
AUTHRECEIVED – Avangate blocks the amount corresponding to the transaction, but the process of collecting funds is incomplete.
PENDING - Avangate has yet to block the amount corresponding to the transaction or shoppers used an offline payment method like wire transfer.
COMPLETE – The shopper completed the transaction for the purchase and Avangate or you fulfilled the order (when required).
CANCELED – Avangate cancels orders for which shoppers fail to transfer funds in due time.
REVERSED – Avangate reverses order transactions that never reach the Complete/Finished stage. Shoppers never complete transactions for such purchases.
REFUND – Avangate refunds orders only after they reach the Complete/Finished stage and returns the funds collected to shoppers.
*/


class Avangate 
{
	
	public function __construct($api='',$secret=''){
		$this->_api = $api;
		$this->_secret = $secret;
		$this->_default_txt = "Your order id %s payment of %s %s is %s.";
		
    }
	public function Handler($raw_data,$encrypted_data=''){
		$this->logs('\n\nLOGS START =======================================\n\n');	
		$decript_data =  explode("$#$",base64_decode ($encrypted_data));;

		$this->order_status = strtoupper($raw_data['ORDERSTATUS']);
		$this->order_no = $raw_data['ORDERNO'];
		$this->product_name = implode(",",$raw_data['IPN_PNAME']); //PRODUCT NAME
		$this->phone = preg_replace("/[^0-9]/", "", $raw_data['PHONE']);; //PHONE NUMBER
		$this->order_totl = $raw_data['IPN_TOTALGENERAL'];
		$this->ref = $raw_data['REFNO'];
		$date = $raw_data['IPN_DATE'];
		$this->curr = $raw_data['CURRENCY'];
		
		$this->_api = $decript_data[1];
		$this->_secret = $decript_data[2];
		$this->from = $decript_data[3]; 
		$this->threshold = floor($decript_data[4]);
		$this->logs('THRESHOLD' . $this->threshold);
		$this->strore_owner = preg_replace("/[^0-9]/", "", $decript_data[6]);
		$this->logs('STORE OWNER' . $this->strore_owner);
		$secret = file_get_contents(getcwd()."/avangate.conf");
        $this->logs('SECRET' . $secret);
		$array  = array('AUTHRECEIVED'=>'In progress','PENDING'=>'Pending','COMPLETE'=>'fulfilled','CANCELED'=>'canceled payment.','REVERSED'=>'shopper cannot fullfill.','REFUND'=> 'refunded','PAYMENT_AUTHORIZED'=>'done','INVALID'=>'Billing/Delivery information is not valid','PAYMENT_RECEIVED'=>'received','PENDING_APPROVAL'=>'waiting for approval');
		foreach($array as $key=>$value){
			$txtmsg = sprintf($this->_default_txt,
						$this->ref,
						$this->order_totl,
						$this->curr,
						$value
					);
			$this->logs($key. ' :  '.$txtmsg);
			
		}
		$this->logs('STATUS' . $array[$this->order_status]);
		$this->logs('STATUS 2' . $this->order_status);
		$txtmsg = sprintf($this->_default_txt,
						$this->ref,
						$this->order_totl,
						$this->curr,
						$array[$this->order_status]
					);
					
		$this->logs('MESSAGE_NIRAV '.$txtmsg);
		
		/* check threshold value before sending sms to customer */
		if($this->order_totl >= $this->threshold){
			$this->send_sms($this->phone, $txtmsg);
		}
		
		$this->threashold();
		if(in_array(strtoupper($this->order_status),array('REVERSED','REFUND')))
		{
			$this->send_sms($this->phone, $txtmsg);
			$this->threashold();
		}
		
		/*switch($this->order_status){
			case 'CANCELED':
				$txtmsg = sprintf($this->_default_txt,
								$this->product_name,
								strtolower($this->order_status),
								$this->order_no);
								$this->send_sms($this->strore_owner, $txtmsg);
				
				break;;
			case 'REVERSED':
				$txtmsg = sprintf($this->_default_txt,
								$this->product_name,
								$this->order_status,
								$this->order_no);
							$this->send_sms($this->strore_owner, $txtmsg);
				break;;
			case 'REFUND':
				$txtmsg = sprintf($this->_default_txt,
								$this->product_name,
								$this->order_status,
								$this->order_no);
				$this->threashold();
				break;;
			default:
				echo "";
					
		}*/
		
		
		$chck = strlen($raw_data['IPN_PID'][0]).$raw_data['IPN_PID'][0].strlen($raw_data['IPN_PNAME'][0]).$raw_data['IPN_PNAME'][0].strlen($raw_data['IPN_DATE']).$date.strlen($date).$date;
        $this->logs( 'KEY DATA'. $chck);

        $this->logs( 'KEY HASH '. '<EPAYMENT>'.$date.'|'.hash_hmac('md5',$chck,trim($secret)).'</EPAYMENT>');
		return '<EPAYMENT>'.$date.'|'.hash_hmac('md5',$chck,trim($secret)).'</EPAYMENT>';
	}
	
	function threashold(){
		if($this->order_totl>=$this->threshold){
			$owner = "#: ".$this->order_no;
			$owner .= "\nAvngt Ref.: ".$this->ref;
			$owner .= "\nOrder Total: ". $this->order_totl. ' '. $this->curr;
			$owner .= "\nStatus: ". $this->order_status;
			$this->send_sms($this->strore_owner,$owner);
		}
		if(in_array(strtoupper($this->order_status),array('REVERSED','REFUND')))		
		{
			$this->send_sms($this->strore_owner,$owner);
		}
		return;
	}
	
	public function send_sms($to, $msg){
		if(!empty($to) && is_numeric($to)){
			$url =  "https://rest.nexmo.com/sms/json";
			$data = array('api_key'=>$this->_api,
				'api_secret'=>$this->_secret,
				'from'=>$this->from,
				'to'=>$to,
				'text'=>$msg);
			$url = $url . '?' .http_build_query($data);
			$data = file_get_contents($url);
            $this->logs("Request URLl:". $url);
            $this->logs("JSON:". $data);

            fclose($f);
		}
		return true;
	}

   public function logs($str){
	  $f = fopen("/var/www/html/sunil_home/avangate_hook/logs.txt","a+");
      fwrite($f,$str."\n");
      fclose($f);
      return ;

   }
	
}
?>
