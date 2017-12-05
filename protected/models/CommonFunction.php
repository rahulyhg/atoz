<?php

class CommonFunction {
    /*
     * Author :- Sagar
     * Description :- Return Date in user format 
     */

    public function getDateInUserFormat($date) {
        if ($date != NULL) {
            return date("d-m-Y h:i:s a", strtotime($date));
        }
    }

    public function getCountryNameById($id) {
        if ($id != NULL) {
            $custName = Yii::app()->db->createCommand()
                    ->select('country_name ')
                    ->from('az_country_master')
                    ->where('country_id = :id', array(':id' => $id))
                    ->queryRow();
            $name = $custName['country_name'];
            return $name;
        }
    }

    public function getStateNameById($id) {
        if ($id != NULL) {
            $stateName = Yii::app()->db->createCommand()
                    ->select('state_name')
                    ->from('az_state_master')
                    ->where('state_id = :id', array(':id' => $id))
                    ->queryRow();

            $name = $stateName['state_name'];
            return $name;
        }
    }

    public function getCityNameById($id) {
        if ($id != NULL) {
            $custName = Yii::app()->db->createCommand()
                    ->select('city_name,city_id ')
                    ->from('az_city_master,az_state_master')
                    ->where('city_id = :id', array(':id' => $id))
                    ->queryRow();
            $name = $custName['city_name'];

            return $name;
        }
    }

    public function getLocationNameById($id) {
        if ($id != NULL) {
            $cityName = Yii::app()->db->createCommand()
                    ->select('city_name')
                    ->from('az_city_master')
                    ->where('city_id = :id', array(':id' => $id))
                    ->queryRow();
            $name = $cityName['city_name'];

            return $name;
        }
    }

    public static function refresh_cache() {
        $specialitynameArr = Yii::app()->db->createCommand()
                ->select('speciality_name')
                ->from('az_speciality_master')
                ->queryAll();
        $rows = Yii::app()->cache->set('specialitycache', $specialitynameArr);
    }

    public static function CalculateAge($no) {

        // $no=15;
        $year = floor($no / 12);
        $month = $no % 12;

        $age = $year . " year, $month month ";
        return $age;
    }

    public static function Notification($id, $module, $action, $operation, $notification) {
        $createdBy = Yii::app()->user->id;
        $createdDate = date('Y-m-d H:i:s');

        $model = new Notification;

        $model->user_id = $id;
        $model->module = $module;
        $model->action = $action;
        $model->operation = $operation;
        $model->notification = $notification;
        $model->created_by = $createdBy;
        $model->created_date = $createdDate;
        $model->record_id = $id;
        $model->viewed = 0;
      // print_r(error_get_last());
        if($model->save())
        {
            
        }
    }
    public static function sendMail($subject,$toMailIdArr,$mailbody)
    {
      
          Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer(true);
        $mail->IsSMTP();
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465; 
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->CharSet = 'UTF-8';
        $mail->Username = '';      //snehit121@gmail.com
        $mail->Password = '';       //9011967707
        $mail->SetFrom('', ''); //snehit121@gmail.com   snehitzanwar
        $mail->Subject = $subject;
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $mail->MsgHTML($mailbody);
        foreach($toMailIdArr as $key => $value)
        {
        $mail->AddAddress($key,$value);
        }
        if(!$mail->send()){
            echo "Mailer Error: " . $mail->ErrorInfo; exit;
            return false;
           // Yii::log('', CLogger::LEVEL_ERROR, "Subject :".$subject." -> ".$mail->ErrorInfo);  
        }else{
           return 1;
            //echo "E-Mail has been sent";
        }
      //  return 1;
    }
    public function sendSms($mobile,$text, $sender_id = "AtoZHP", $created_by = 0, $historyId = 0 ){
     
        $returnText  = "";
        $encodedtext = urlencode($text);
//       $requestUrl = "http://sms.3dsms.co.in/vendorsms/pushsms.aspx?user=shubh123&password=shubh@1234$&msisdn=$mobile&sid=$sender_id&msg=$encodedtext&fl=0&gwid=2 ";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_URL, $requestUrl);
//        $resultStr = curl_exec($ch);
//        $resultStr = trim($resultStr);
//        curl_close($ch);
//        $sent_status = "fail";
//        $sms_status = 0;
//        $return_message_id = NULL;
//        if(is_numeric($resultStr)){ //if message sent successfully
//            $sent_status = "sent";
//            $sms_status = "success";
//            $return_message_id = $resultStr;
//            //Yii::log('', CLogger::LEVEL_ERROR, " To=>sent $mobile");
//        }else{ //else message fail
//            $sms_status = $resultStr;
//            Yii::log('', CLogger::LEVEL_ERROR, "not sent to $mobile ".$resultStr);
//        }
       
    }
    
    
    public function excelSheetReader($file) {
        $presentFieldArr = array();
        $resultArr = array();
        Yii::import('application.vendor.PHPExcel', true); //exit;

        $inputFileType = PHPExcel_IOFactory::identify($file);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file); //$file --> your filepath and filename

        $objWorksheet = $objPHPExcel->getActiveSheet(); //exit;
        //$objWorksheet = $objPHPExcel->getSheet(0); //exit;
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $index = 0;
        for ($row = 1; $row <= $highestRow; ++$row) {      //start of data reading
            for ($col = 0; $col < $highestColumnIndex; ++$col) {

                if ($row == 1) {           //check whether all fields are present
                    $header_name = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                    $presentFieldArr[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();

                    if ($col == $highestColumnIndex) {
                        $result = array_diff($fieldArr, $presentFieldArr);
                        if (count($result) > 0) {
                            $model->addError("", implode(",", $result) . " fields are missing.");
                            throw new CException(CHtml::errorSummary($model));
                        }
                    }
                } else {
                    $field = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
                    $resultArr[$index][$field] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
            }
            $index++;
        }
        return $resultArr;
    }


}

?>