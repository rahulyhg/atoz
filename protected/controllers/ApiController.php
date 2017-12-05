<?php

header("Access-Control-Allow-Origin: *");

class ApiController extends Controller {

    //teste
    public function actionTest() {
        $returnOutputArr = array("isError" => false);
        try {
            $formdata = Yii::app()->request->getParam("id");
            $returnOutputArr['givenid'] = $formdata;
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }
        echo json_encode($returnOutputArr);
    }
    //delete later
    
    public function actionLogin($user, $pass) {
        //echo "infunction";exit;
        //Yii::log('', CLogger::LEVEL_ERROR, " Function:- $user $pass");
        $returnOutputArr = array("isError" => false);
        try {
            $purifiedObj = Yii::app()->purifier;
            //$mobile = Yii::app()->request->getParam('mobile');
            //$password = Yii::app()->request->getParam('pass');
            if (empty($user) || empty($pass))
                throw new Exception("Invalid Username or Password  ");
            $userArr = Yii::app()->db->createCommand()
                    ->select('user_id,role_id,patient_type,profile_image,first_name,last_name,is_active,password,mobile,email_1,address')
                    ->from('az_user_details')
                    ->where('mobile = :mobile', array(':mobile' => $user))
                    ->queryRow();
            if (!empty($userArr)) {

                if ($userArr['password'] !== md5($pass)) {
                    throw new Exception("Invalid Password");
                }

                if ($userArr['is_active'] == 0) {
                    throw new Exception("Your account is not active. Please contact administrator");
                }
                // $commonobj->sendSms($mobile,"$otp is your OTP verification code for A2zhelthplus");
                $returnOutputArr['isError'] = false;
                $returnOutputArr['user'] = $userArr;
            } else {
                throw new Exception("Username Not Existed");
            }
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

    public function actionConfirmOtpReg() {
        $returnOutputArr = array("isError" => false);
        try {
            $formdata = Yii::app()->request->getParam("formdata");
            $postArr = json_decode($formdata);
            $commonobj = new CommonFunction;
            //print_r($postArr);exit;
            $model = new UserDetails('Register');
            $model->first_name = $postArr->firstname;
            $model->last_name = $postArr->lastname;
            $model->mobile = $postArr->mobile;
            $model->password = md5($postArr->password);
            $model->vip_role = NULL;
            $model->company_name = NULL;
            $model->patient_type = $postArr->patienttype;
            $model->created_date = date('Y-m-d H:i:s');
            $model->is_active = 1;
            $model->role_id = 4;
            if ($model->save()) {
                $returnOutputArr['errorMsg'] = "dne";
            }
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionConForgotOtp() {

        $returnOutputArr = array("isError" => false);
        try {
            $formdata = Yii::app()->request->getParam("formdata");
            $postArr = json_decode($formdata);
            $commonobj = new CommonFunction;
            //  print_r($postArr);
            $newpss = md5($postArr->password);
            // echo $newpss;
            $mobile = $postArr->mobile;
            if (isset($newpss)) {
                Yii::app()->db->createCommand()->update('az_user_details', array('password' => $newpss), 'mobile=:mobile', array(':mobile' => $mobile));
                $returnOutputArr = array("isverified" => "yes");
            } else {
                $returnOutputArr = array("isverified" => "no");
            }
            echo json_encode(array('data' => $returnOutputArr));
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionSendOtp() {
        $returnOutputArr = array("isError" => false);
        try {
            $formdata = Yii::app()->request->getParam("formdata");
            $postArr = json_decode($formdata);
            $commonobj = new CommonFunction;
            $otpType = $postArr->otpType;
            if ($otpType == "registration") {
                $mobile = $postArr->mobile;
                $mobilenoArr = Yii::app()->db->createCommand()
                        ->select('mobile')
                        ->from('az_user_details')
                        ->where('mobile= :mobile', array(':mobile' => $mobile))
                        ->queryRow();
                if (!empty($mobilenoArr)) {
                    throw new Exception("You Are Already Member");
                } else {
                    $otp = rand(111111, 999999);
                    $commonobj->sendSms($mobile,"$otp is your OTP verification code for A2zhelthplus");
                    $returnOutputArr['userotp'] = $otp;
                }
            } else if ($otpType == "forgotpass") {
                $mobile = $postArr->mobile;
                $mobilenoArr = Yii::app()->db->createCommand()
                        ->select('mobile')
                        ->from('az_user_details')
                        ->where('mobile= :mobile', array(':mobile' => $mobile))
                        ->queryRow();
                if (!empty($mobilenoArr)) {

                    $otp = rand(111111, 999999);
                    $commonobj->sendSms($mobile,"$otp is your OTP verification code for A2zhelthplus");
                    $returnOutputArr['userotp'] = $otp;
                } else {
                    throw new Exception("You Are Not Member");
                }
            }

            /////////////////////////////////////////////////////// 
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionGetSearchLocation() {
        $purifiedObj = Yii::app()->purifier;
        $location = Yii::app()->request->getParam('location1');
        $locationResult = array();
        $returnOutputArr = array("isError" => false);
        try {
            $resultArr = array();
            if (isset($location) && !empty($location)) {
                $locationResult = Yii::app()->db->createCommand()->select("DISTINCT(area_name) as distarea")
                        ->from("az_user_details ")
                        ->where("area_name LIKE '%$location%' AND role_id IN(3,5,6,7,8,9) ")
                        ->queryColumn();
                if (!empty($locationResult)) {
                    foreach ($locationResult as $location) {
                        $resultArr[] = array("value" => $location, "label" => $location, "category" => "area_name");
                    }
                }
                //$locationResult[] = array("city_name" => 'city_name', "area_name" => 'area_name');
            } else {
                $defaultCity = Constants::DEFAULT_CITY;
                $resultArr[] = array("value" => $defaultCity, "label" => "All of " . $defaultCity, "category" => "main_city_name");
                $locationResult = Yii::app()->db->createCommand()->select("DISTINCT(area_name) as distarea")
                        ->from("az_user_details ")
                        ->where("city_name LIKE '%$location%' AND role_id IN(3,5,6,7,8,9)")
                        ->queryColumn();
                if (!empty($locationResult)) {
                    foreach ($locationResult as $location) {
                        $resultArr[] = array("value" => $location, "label" => $location, "category" => "area_name");
                    }
                }
            }
            $returnOutputArr["locationsdata"] = $resultArr;
        } catch (Exception $ex) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $ex->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionSearchResult() { // serching the result based on area and speciality
        $purifiedObj = Yii::app()->purifier;
        $requestObj = Yii::app()->request;
        $locationResult = array();
        $returnOutputArr = array("isError" => false);
        try {
            $location = $requestObj->getParam("location");
            $iscity = $requestObj->getParam("iscity");
            $speciality = $requestObj->getParam("speciality");
            $session = new CHttpSession;
            $session->open();
            $model = new UserDetails;
            $defaultsort = "Rating";
            $action = $param = $source = $dayofweek = "";
            if ($location == "null") {
                $location = "";
            }
            if (empty($sortoption)) {
                $sortoption = $defaultsort;
            }
            if (isset($_GET['sortby'])) {
                $sortoption = $requestObj->getParam("sortby");
                //echo $sortoption;exit;
            }
            if (isset($_GET['source'])) {
                $source = $requestObj->getParam("source");
            }
            if (isset($_GET['dayofweek'])) {
                $dayofweek = $requestObj->getParam("dayofweek");
            }
            if (isset($_GET['action'])) {
                $action = $requestObj->getParam("action");
                $param = $requestObj->getParam("param");
            }
            $defaultCity = Constants::DEFAULT_CITY;

            if (empty($location)) {     //if only speciality is selected
                $location = $defaultCity;
            }

            $whereClause = " WHERE t.role_id=3 AND spm.speciality_name = '$speciality' AND is_active = 1";
            $join = "LEFT JOIN az_speciality_user_mapping spm ON spm.user_id = t.user_id LEFT JOIN az_clinic_details cd ON cd.doctor_id = t.user_id";
            $order = "t.user_id";
            $paramArr = array();
            $paramArr[":specname"] = $speciality;
            if ($iscity == "Y") {
                $whereClause .= " AND  ( t.city_name='$location' OR cd.city_name = '$location' ) ";
                $paramArr[":city_name"] = $location;
            } elseif ($iscity == "N" && !empty($location)) {
                $whereClause .= " AND (t.area_name='$location'  OR cd.area_name = '$location') ";
                $paramArr[":area_name"] = $location;
            }
            if ($source == "freeoffer") {
                $whereClause .= " AND ( (cd.free_opd_perday IS NOT NULL and cd.free_opd_perday <> 0) OR (t.free_opd_perday IS NOT NULL and t.free_opd_perday <>0 )) and ( t.free_opd_preferdays LIKE '%$dayofweek%' OR cd.free_opd_preferdays LIKE '%$dayofweek%') ";
            }

            if ($sortoption == "Rating") {
                //$join .=" LEFT JOIN az_rating ar ON ar.user_id = t.user_id";
                $order = "ratecount DESC";
            }
            if ($sortoption == "feehighlow") {
                $order = "fees DESC";
            }
            if ($sortoption == "feelowhigh") {
                $order = "fees ASC";
            }
            if ($sortoption == "Experience") {
                $order = "t.experience DESC";
            }
            if ($sortoption == "Savings") {
                $order = "saving DESC";
            }
            $alldata = Yii::app()->db->createCommand("SELECT cd.clinic_id,IF( cd.opd_consultation_fee IS NULL, t.doctor_fees,cd.opd_consultation_fee) AS fees,cd.clinic_name,cd.address as clinic_address,cd.area_name as area_id,cd.state_name as state_id,cd.city_name as city_id, cd.country_name as country_id ,profile_image,t.user_id,role_id,first_name,last_name,t.area_name,t.city_name,t.state_name,t.country_name,t.description,hospital_name,t.experience,t.doctor_fees,parent_hosp_id,mobile,t.is_active,apt_contact_no_1,(select GROUP_CONCAT(degree_name) FROM az_doctor_degree_mapping dmp WHERE dmp.doctor_id = t.user_id ) as doctordegree,(SELECT dr.hospital_name FROM az_user_details dr WHERE dr.user_id = t.parent_hosp_id) as drhospital,(select COUNT(ar.id) FROM az_rating ar WHERE ar.user_id = t.user_id ) as ratecount,IF(cd.clinic_id is not null, (SELECT MAX(service_discount) FROM az_service_user_mapping sm WHERE sm.user_id = t.user_id AND sm.clinic_id = cd.clinic_id), '') as saving FROM az_user_details t $join $whereClause ORDER BY $order")->queryAll();
            //echo $alldata;exit;
            $returnOutputArr['resultdata'] = $alldata;
        } catch (Exception $ex) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $ex->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionGetUserDetails() {
        $returnOutputArr = array("isError" => false);
        $id = Yii::app()->request->getParam("userid");
        $clinicid = Yii::app()->request->getParam("clinicid");
        $roleid = Yii::app()->request->getParam("roleid");
        try {
            $resultArr = array();
            $action = $param = $select = "";
            if ($roleid == 3) {
                $select = "user_id ,role_id ,patient_type ,profile_image ,first_name ,last_name ,gender ,birth_date ,age ,blood_group ,mobile , apt_contact_no_1 ,apt_contact_no_2 ,email_1 ,email_2 ,country_id ,state_id ,city_id ,area_id ,landmark ,address ,pincode ,country_name ,state_name ,city_name ,area_name ,doctor_registration_no ,experience ,doctor_fees ,sub_speciality ,registration_Fees ,parent_hosp_id ,free_opd_perday ,free_opd_preferdays ,hospital_name ,type_of_hospital ,opd_no ,hospital_registration_no ,hos_establishment ,hos_validity ,type_of_establishment ,other_est_type , total_no_of_bed ,longitude ,latitude ,is_open_allday ,hospital_open_time ,hospital_close_time ,description,(select GROUP_CONCAT(degree_name) FROM az_doctor_degree_mapping dmp WHERE dmp.doctor_id = t.user_id ) as doctordegree,take_home";
            } elseif ($roleid == 5) {
                $select = "user_id ,role_id ,patient_type ,profile_image ,first_name ,last_name ,gender ,birth_date ,age ,blood_group ,mobile , apt_contact_no_1 ,apt_contact_no_2 ,email_1 ,email_2 ,country_id ,state_id ,city_id ,area_id ,landmark ,address ,pincode ,country_name ,state_name ,city_name ,area_name ,doctor_registration_no ,experience ,doctor_fees ,sub_speciality ,registration_Fees ,parent_hosp_id ,free_opd_perday ,free_opd_preferdays ,hospital_name ,type_of_hospital ,opd_no ,hospital_registration_no ,hos_establishment ,hos_validity ,type_of_establishment ,other_est_type , total_no_of_bed ,longitude ,latitude ,is_open_allday ,hospital_open_time ,hospital_close_time ,description,(SELECT count(u.user_id) FROM az_user_details u WHERE u.parent_hosp_id= t.user_id and u.is_active = 1) as doctorcnt,(select COUNT(ar.id) FROM az_rating ar WHERE ar.user_id = t.user_id ) as ratecount,take_home";
            }
            
            $user = Yii::app()->db->createCommand()
                    ->select($select)
                    ->from('az_user_details t')
                    ->where('user_id=:id', array(':id' => $id))
                    ->queryRow();
            if ($roleid == 3) {
                $user['clinic_id'] = $clinicid;
                $serMapStr = "";
                $serMapArr = array();
                if (!empty($clinicid)) {
                    $clinic = Yii::app()->db->createCommand()->select('clinic_name,payment_type,opd_consultation_fee,landmark,address,area_name,city_name,state_name,country_name,longitude,latitude,alldayopen')->from('az_clinic_details')->where('clinic_id=:id', array(':id' => $clinicid))->queryRow();
                    $user['payment_type'] = $clinic['payment_type'];
                    $user['landmark'] = $clinic['landmark'];
                    $user['address'] = $clinic['address'];
                    $user['area_name'] = $clinic['area_name'];
                    $user['city_name'] = $clinic['city_name'];
                    $user['state_name'] = $clinic['state_name'];
                    $user['country_name'] = $clinic['country_name'];
                    $user['latitude'] = $clinic['latitude'];
                    $user['longitude'] = $clinic['longitude'];
                    $user['country_name'] = $clinic['country_name'];
                    $user['clinic_name'] = $clinic['clinic_name'];
                    $user['doctor_fees'] = $clinic['opd_consultation_fee'];
                    $user['is_open_allday'] = $clinic['alldayopen'];
                    if ($clinic['alldayopen'] == "N") {
                        $clinicvisitArr = Yii::app()->db->createCommand()->select('*')->from('az_clinic_visiting_details')->where('doctor_id=:id and clinic_id = :clinic_id AND role_type = "clinic"', array(':id' => $id, ":clinic_id" => $clinicid))->queryAll();
                        $user['visit_details'] = $clinicvisitArr;
                    }
                    $serMapStr = "sum.user_id=:did AND sum.clinic_id = :clinic AND sum.is_clinic = 1";
                    $serMapArr = array(':did' => $id, ":clinic" => $clinicid);
                } elseif ($user['role_id'] == 3 && !empty($user['parent_hosp_id'])) {
                    $hospital = Yii::app()->db->createCommand()->select('hospital_name,hos_establishment,is_open_allday,hospital_open_time,hospital_close_time')->from('az_user_details')->where('user_id=:id', array(':id' => $user['parent_hosp_id']))->queryRow();
                    if (!empty($hospital)) {
                        $user['clinic_name'] = $hospital['hospital_name'];
                        $user['hos_establishment'] = $hospital['hos_establishment'];
                        $user['is_open_allday'] = $hospital['is_open_allday'];
                        $user['hospital_open_time'] = $hospital['hospital_open_time'];
                        $user['hospital_close_time'] = $hospital['hospital_close_time'];
                    }
                    $serMapStr = "sum.user_id=:did AND sum.is_clinic = 0";
                    $serMapArr = array(':did' => $user['parent_hosp_id']);
                }
                $serviceArr = Yii::app()->db->createCommand()->select('service_name,service_discount')->from('az_service_master sm')->join('az_service_user_mapping sum', 'sm.service_id = sum.service_id')->where($serMapStr, $serMapArr)->queryAll();
                $user['user_service'] = $serviceArr;
                
                
            } elseif ($roleid == 5 || $roleid == 6) {
                $speDoctCount = Yii::app()->db->createCommand()->select('spm.user_id,spm.speciality_name,COUNT(spm.speciality_id) as no')->from('az_user_details ud')->join('az_speciality_user_mapping spm', 'ud.user_id = spm.user_id')->where("ud.parent_hosp_id =:userid", array('userid' => $id))->group('spm.speciality_id')->queryAll();
                $user['speDoctCount'] = $speDoctCount;
                $docArr = Yii::app()->db->createCommand()->select('first_name,last_name,user_id,role_id,profile_image,parent_hosp_id,address,experience,doctor_fees,landmark,city_name,state_name,country_name,payment_type,description,(SELECT GROUP_CONCAT(speciality_name) FROM az_speciality_user_mapping spm WHERE spm.user_id = t.user_id) as userspeciality,(select GROUP_CONCAT(degree_name) FROM az_doctor_degree_mapping dmp WHERE dmp.doctor_id = t.user_id ) as doctordegree,(select COUNT(ar.id) FROM az_rating ar WHERE ar.user_id = t.user_id ) as ratecount,apt_contact_no_1')->from('az_user_details t')->where('parent_hosp_id=:id and is_active = 1  and role_id=3', array(':id' => $id))->group("t.user_id")->queryAll();
                $user['speDoctList'] = $docArr;
                $serviceArr = Yii::app()->db->createCommand()->select('service_name,service_discount')->from('az_service_master sm')->join('az_service_user_mapping sum', 'sm.service_id = sum.service_id')->where('sum.user_id=:did', array(':did' => $id))->queryAll();
                $user['user_service'] = $serviceArr;
                
            }
            
            $documentArr = Yii::app()->db->createCommand()->select('document')->from('az_document_details')->where("user_id=:did AND doc_type = 'other_photos'", array(':did' => $id))->queryAll();
                $user['user_photos'] = $documentArr;
            $returnOutputArr["userdata"] = $user;
        } catch (Exception $ex) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $ex->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionListType() {
        $returnOutputArr = array("isError" => false);
        $type = Yii::app()->request->getParam("type");
        $sortoption = Yii::app()->request->getParam("sortby");
        try {
            $purifiedObj = Yii::app()->purifier;
            $resultArr = array();
            switch ($type) {
                case "spcType":
                    $resultArr = Yii::app()->db->createCommand()->select('speciality_name,img_name')->from('az_speciality_master')->where('is_active= 1')->queryAll();
                    break;
                case "hospital":
                    $order = "saving desc";
                    if ($sortoption == "Rating") {
                        $order = "ratecount DESC";
                    }elseif ($sortoption == "Experience") {
                        $order = "hos_establishment ASC";
                    }elseif ($sortoption == "beds-strength") {
                        $order = "total_no_of_bed DESC";
                    }elseif ($sortoption == "saving") {
                        $order = "saving DESC";
                    }

//                     $speDoctCount = Yii::app()->db->createCommand()->select('spm.user_id,spm.speciality_name,COUNT(spm.speciality_id) as no')->from('az_user_details ud')->join('az_speciality_user_mapping spm', 'ud.user_id = spm.user_id')->where("ud.parent_hosp_id =:userid", array('userid' => $id))->group('spm.speciality_id')->queryAll();


                    $resultArr = Yii::app()->db->createCommand()->select('user_id,role_id,profile_image,payment_type,hospital_name,type_of_hospital,hos_establishment,total_no_of_bed,description,state_name,city_name,area_name,pincode,address,landmark,(SELECT count(t.user_id) FROM az_user_details t WHERE t.parent_hosp_id= u.user_id and t.is_active = 1) as doctorcnt,(select COUNT(ar.id) FROM az_rating ar WHERE ar.user_id = u.user_id ) as ratecount,(SELECT MAX(service_discount) FROM az_service_user_mapping sm WHERE sm.user_id = u.user_id) as saving,take_home')->from('az_user_details u')->where('role_id=5 AND is_active= 1')->order($order)->queryAll();
                    break;
                case "ambulance":
                    $resultArr = Yii::app()->db->createCommand()->select('t.user_id,t.role_id,t.first_name,hospital_name,mobile,type_of_hospital,address,landmark,company_name,longitude,latitude,take_home')->from('az_user_details t')->where('role_id = 10 AND is_active= 1')->queryAll();
                    break;
                case "diagnostic":
                    $order = "saving desc";
                    if ($sortoption == "Rating") {
                        $order = "ratecount DESC";
                    }elseif ($sortoption == "Experience") {
                        $order = "hos_establishment ASC";
                    }
                    $resultArr = Yii::app()->db->createCommand()->select('user_id,role_id,profile_image,payment_type,hospital_name,type_of_hospital,hos_establishment,total_no_of_bed,description,state_name,city_name,area_name,pincode,address,landmark,(SELECT count(t.user_id) FROM az_user_details t WHERE t.parent_hosp_id= u.user_id and t.is_active = 1) as doctorcnt,(select COUNT(ar.id) FROM az_rating ar WHERE ar.user_id = u.user_id ) as ratecount,(SELECT MAX(service_discount) FROM az_service_user_mapping sm WHERE sm.user_id = u.user_id) as saving,take_home')->from('az_user_details u')->where('role_id=7 AND is_active= 1')->order($order)->queryAll();
                    break;

                case "pathology":
                    $order = "saving desc";
                    if ($sortoption == "Rating") {
                        $order = "ratecount DESC";
                    }elseif ($sortoption == "Experience") {
                        $order = "hos_establishment ASC";
                    }


                    $resultArr = Yii::app()->db->createCommand()->select('user_id,role_id,profile_image,payment_type,hospital_name,type_of_hospital,hos_establishment,total_no_of_bed,description,state_name,city_name,area_name,pincode,address,landmark,(SELECT count(t.user_id) FROM az_user_details t WHERE t.parent_hosp_id= u.user_id and t.is_active = 1) as doctorcnt,(select COUNT(ar.id) FROM az_rating ar WHERE ar.user_id = u.user_id ) as ratecount,(SELECT MAX(service_discount) FROM az_service_user_mapping sm WHERE sm.user_id = u.user_id) as saving,take_home')->from('az_user_details u')->where('role_id=6 AND is_active= 1')->order($order)->queryAll();
                    break;

                case "bloodbanks":
                    $order = "saving desc";
                    if ($sortoption == "Rating") {
                        $order = "ratecount DESC";
                    }elseif ($sortoption == "Experience") {
                        $order = "hos_establishment ASC";
                    }
                    $resultArr = Yii::app()->db->createCommand()->select('user_id,role_id,profile_image,payment_type,hospital_name,type_of_hospital,hos_establishment,total_no_of_bed,description,state_name,city_name,area_name,pincode,address,landmark,(SELECT count(t.user_id) FROM az_user_details t WHERE t.parent_hosp_id= u.user_id and t.is_active = 1) as doctorcnt,(select COUNT(ar.id) FROM az_rating ar WHERE ar.user_id = u.user_id ) as ratecount,(SELECT MAX(service_discount) FROM az_service_user_mapping sm WHERE sm.user_id = u.user_id) as saving,take_home')->from('az_user_details u')->where('role_id=8 AND is_active= 1')->order($order)->queryAll();
                    break;

                case "medicalstores":
                    $order = "saving desc";
                    if ($sortoption == "Rating") {
                        $order = "ratecount DESC";
                    }elseif ($sortoption == "Experience") {
                        $order = "hos_establishment ASC";
                    }

                    $resultArr = Yii::app()->db->createCommand()->select('user_id,role_id,profile_image,payment_type,hospital_name,type_of_hospital,hos_establishment,total_no_of_bed,description,state_name,city_name,area_name,pincode,address,landmark,(SELECT count(t.user_id) FROM az_user_details t WHERE t.parent_hosp_id= u.user_id and t.is_active = 1) as doctorcnt,(select COUNT(ar.id) FROM az_rating ar WHERE ar.user_id = u.user_id ) as ratecount,(SELECT MAX(service_discount) FROM az_service_user_mapping sm WHERE sm.user_id = u.user_id) as saving,take_home')->from('az_user_details u')->where('role_id=9 AND is_active= 1')->order($order)->queryAll();
                    break;

                default:
                    break;
            }
            $returnOutputArr['list'] = $resultArr;
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

    public function actionConfirmAppointment() {
        $returnOutputArr = array("isError" => false);
        try {
            $purifiedObj = Yii::app()->purifier;
            $formdata = Yii::app()->request->getParam("formdata");
            $postArr = json_decode($formdata);
            $date = date('Y-m-d');
            //print_r($postArr);exit;
            $model = new AptmtQuery();
            $is_patient = 1;
            if (!$postArr->is_patient)
                $is_patient = 0;
            $model->is_patient = $is_patient;
            $model->patient_name = $postArr->patient_name;
            $model->patient_mobile = $postArr->patient_mobile;
            $model->creator_number = $postArr->creator_number;
            $model->type_of_visit = $postArr->type_of_visit;
            $model->relationship = $postArr->relationship;
            $model->doctor_id = $postArr->docid;
            if (isset($postArr->docfee) && $postArr->docfee != "NA") {
                $model->apt_fees = $postArr->docfee;
            }
            
            $model->clinic_id = $postArr->clinicid;
            if (!empty($postArr->promo_id)) {
                $model->promo_id = $postArr->promo_id;
            } else {
                $model->promo_id = NULL;
            }
            $model->apt_confirm = "No";
            $model->created_date = date("Y-m-d H:i:s");
            $model->created_by = $postArr->created_by;
            if (!empty($postArr->appdate))
                $model->preferred_day = date("Y-m-d", strtotime($postArr->appdate));
            $model->mode_of_pay = "counter";

            if ($model->save()) {
                if (!empty($model->promo_id)) {
                    Yii::app()->db->createCommand()->update("az_promo_code", array("promo_status" => "Used", "used_date" => date("Y-m-d H:i:s")), "promo_id = :promo_id", array(":promo_id" => $model->promo_id));
                }
            } else {
                throw new Exception("error in appointment");
            }
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

    public function actionGetHosServices() {
        $returnOutputArr = array("isError" => false);
        try {


            $roleid = Yii::app()->request->getParam("roleid");
            $userid = Yii::app()->request->getParam("userid");
            $hospitalservices = Yii::app()->db->createCommand()
                    ->select('t.role_id,r.role_name,apt_contact_no_1')
                    ->from('az_user_details t')
                    ->join('az_role_master r', 't.role_id=r.role_id')
                    ->andWhere('parent_hosp_id=:id ', array(':id' => $userid))
                    ->andWhere('t.role_id >:start AND t.role_id <= :end', array(':start' => 5, ':end' => 9))
                    ->queryAll();
            $returnOutputArr['listofservices'] = $hospitalservices;

            $servicename = Yii::app()->db->createCommand()
                    ->select('t.service_id,sm.service_name')
                    ->from('az_service_user_mapping t')
                    ->join('az_service_master sm', 't.service_id = sm.service_id')
                    ->where('t.user_id=:id', array(':id' => $userid))
                    ->queryAll();

            $returnOutputArr['servicename'] = $servicename;
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

    public function actionSetCurrentLocation() {
        $returnOutputArr = array("isError" => false);
        try {
            $currentLat = Yii::app()->request->getParam("currentLat");
            $currentLog = Yii::app()->request->getParam("currentLog");
            $userid = Yii::app()->request->getParam("uid");
            if (!empty($currentLat) && !empty($currentLog) && !empty($userid)) {
                Yii::app()->db->createCommand()->update("az_user_details", array("current_lat" => $currentLat, "current_log" => $currentLog, "last_update_date" => date("Y-m-d H:i:s")), "user_id = :uid", array(":uid" => $userid));
            }

            //  print_r($hospitalservices);
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

    public function actionGetUserById() {
        $returnOutputArr = array("isError" => false);
        try {
            $userid = Yii::app()->request->getParam("uid");
            if (!empty($userid)) {
                $details = Yii::app()->db->createCommand()
                        ->select('t.current_lat,current_log,latitude,longitude,user_id,role_id,patient_type,profile_image,first_name,last_name,mobile,email_1,address')
                        ->from('az_user_details t')
                        ->andWhere('user_id=:id ', array(':id' => $userid))
                        ->queryRow();
                $returnOutputArr['details'] = $details;
            }

            //  print_r($hospitalservices);
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

    public function actionGetAllAddress() {
        $returnOutputArr = array("isError" => false);
        try {


            $pincode = Yii::app()->request->getParam("pincode");

            $qryAddress = Yii::app()->db->createCommand()
                    ->select('am.area_name,am.area_id,cm.city_name,cm.city_id,sm.state_name,sm.state_id,am.pincode')
                    ->from('az_area_master am')
                    ->join('az_city_master cm', 'cm.city_id = am.city_id')
                    ->join('az_state_master sm', 'sm.state_id = cm.state_id')
                    ->where('am.pincode =:pincode', array(':pincode' => $pincode))
                    ->queryRow();

            $returnOutputArr['address'] = $qryAddress;
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

    public function actionConfirmLabAppointment() {
        $returnOutputArr = array("isError" => false);
        try {
            $purifiedObj = Yii::app()->purifier;
            $formdata = Yii::app()->request->getParam("formdata");
            $postArr = json_decode($formdata);
            $date = date('Y-m-d');
            $model = new LabBookDetails;
//           if (!empty($postArr->promo_id)) {
//                $model->promo_id = $postArr->promo_id;
//            } else {
//                $model->promo_id = NULL;
//            }
            //echo "<pre>";echo json_encode($_REQUEST);exit;
            //$model->role_id = $postArr->role_id;
            if($postArr->role_id == 5) { //for hospital services booking
                $model->role_id = $postArr->hospservice;
                $model->parent_hosp_id = $postArr->user_id;
                $model->center_id = Yii::app()->db->createCommand()->select('user_id')->from('az_user_details')->where('role_id =:role_id AND parent_hosp_id = :parent_hosp_id', array(':role_id' => $model->role_id, ":parent_hosp_id" =>$postArr->user_id ))->queryScalar();
            }else{
                $model->role_id = $postArr->role_id;
                $model->center_id = $postArr->user_id;
            }
            $model->patient_id = $postArr->login_id;
            if(!empty($postArr->appdate)) {
                $model->appointment_date = date("Y-m-d",  strtotime($postArr->appdate));
            }
            $totalbookcnt = Yii::app()->db->createCommand()->select('count(book_id)')->from('az_lab_book_details')->where('role_id =:role_id AND appointment_date = :appointment_date AND center_id = :center_id AND patient_id = :patient_id', array(':role_id' => $model->role_id, ":appointment_date" =>$model->appointment_date,":center_id" => $model->center_id, ":patient_id" => $model->patient_id))->queryScalar();
            if($totalbookcnt > 0){
                throw new Exception("We have already recieved request for appointment");
            }
            $model->full_name = $postArr->patient_name;
            if (!empty($postArr->relation))
                $model->relation = $postArr->relation;
            
            
            if (!empty($postArr->other_relation)) {
                if ($postArr->relation == 'OTHER')
                    $model->other_relation_dis = $postArr->other_relation;
            }

            $model->mobile_no = $postArr->patient_mobile;
            if (!empty($postArr->patient_age))
                $model->patient_age = $postArr->patient_age;
            else
                $model->patient_age = 0;
            $model->created_date = date("Y-m-d H:i:s");
            $model->status = "Pending";
            if (!empty($postArr->servicename)) {
                $model->service_name = $postArr->servicename;
            }

            if (!empty($postArr->blood_group)) {
                $model->blood_group = $postArr->blood_group;
            }
            if (!empty($postArr->no_of_unit)) {
                $model->no_of_unit = $postArr->no_of_unit;
            }

            if ($postArr->showcollect == 1) {
                $model->collect_home = "YES";
                $model->pincode = $postArr->pincode;
                $model->country_id = 1;
                $model->country_name = "India";
                $model->state_id = $postArr->state_id;
                $model->state_name = $postArr->state_name;
                $model->city_id = $postArr->city_id;
                $model->city_name = $postArr->city_name;
                $model->area_id = $postArr->area_id;
                $model->area_name = $postArr->area_name;
                $model->landmark = $postArr->landmark;
                $model->address = $postArr->address;
            } else {
                $model->collect_home = "NO";
            }
            
            if(isset($_FILES['file']) && !empty($_FILES['file'])) {
                $baseDir = Yii::app()->basePath . "/../uploads/";
                if (!is_dir($baseDir)) {
                    mkdir($baseDir);
                }
                $profileDir = 'doctordis/';                                    //profilepic
                if (!is_dir($baseDir . $profileDir)) {
                    mkdir($baseDir . $profileDir);
                }
                $profileDir = $profileDir . date("Y") . "/";                    //year
                if (!is_dir($baseDir . $profileDir)) {
                    mkdir($baseDir . $profileDir);
                }
                $profileDir = $profileDir . date("M") . "/";                    //month
                if (!is_dir($baseDir . $profileDir)) {
                    mkdir($baseDir . $profileDir);
                }
                $path_part = pathinfo($_FILES['file']['name']);
                $fname = $profileDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                if(move_uploaded_file($_FILES['file']['tmp_name'], $baseDir.$fname)) {
                    $model->discription_doc = $fname;
                } else{
                    throw new Exception("There was an error uploading the file, please try again!");
                }
            }
            if ($model->save()) {
                
            } else {
                throw new Exception("error in appointment");
            }
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionGetUserAppointments() {
        $returnOutputArr = array("isError" => false);
        try {
            $userid = Yii::app()->request->getParam("userid");
            $roleid = Yii::app()->request->getParam("roleid");

            if ($roleid == 4) {
                
                $drappresult = Yii::app()->db->createCommand()
                        ->select('u.first_name,last_name,doctor_fees,DATE_FORMAT(appointment_date, "%d %b %Y, %W") as aptdate,time,mobile,is_clinic,hospital_id,appointment_date,appointment_id,(SELECT group_concat(speciality_name) FROM az_speciality_user_mapping where user_id=u.user_id) AS speciality,IF( is_clinic = "Y", (SELECT CONCAT(c.clinic_name,";",CONCAT(c.address,",",c.area_name,",",c.city_name,",",c.state_name)) FROM az_clinic_details c WHERE c.clinic_id = t.hospital_id),(SELECT CONCAT(h.hospital_name,";",CONCAT(h.address,",",h.area_name,",",h.city_name,",",h.state_name)) FROM az_user_details h WHERE h.user_id = t.hospital_id)) as provider_name')
                        ->from('az_patient_appointment_details t')
                        ->leftJoin('az_user_details  u', 'u.user_id=t.doctor_id')
                        ->where('t.patient_id=:id', array(':id' => $userid))->order("appointment_date DESC")->limit(30)->getText();
                       // ->queryAll();
                $resultArr = Yii::app()->db->createCommand()
                        ->select('u.first_name,last_name,NULL as doctor_fees,DATE_FORMAT(t.created_date, "%d %b %Y, %W") as aptdate,NULL as time,mobile,NULL as is_clinic, NULL as hospital_id ,t.created_date as appointment_date,book_id as appointment_id, NULL as speciality,CONCAT(u.hospital_name,";",CONCAT(u.address,",",u.area_name,",",u.city_name,",",u.state_name)) as provider_name')
                        ->from('az_lab_book_details t')
                        ->leftJoin('az_user_details  u', 'u.user_id=t.center_id')
                        ->where('t.patient_id=:id', array(':id' => $userid))->order("appointment_date DESC")->limit(30)
                        ->union($drappresult)
                        ->queryAll();//print_r($appresultArr);exit;
                //usort($appresultArr, 'date_compare');
                //print_r($resultArr);exit;
            } elseif ($roleid == 3) {
                $resultArr = Yii::app()->db->createCommand()
                        ->select("u.first_name, u.last_name,u.mobile,t.hospital_id,DATE_FORMAT(t.appointment_date, '%d %b %Y, %W') as aptdate,t.time,t.day, t.type_of_visit,t.doc_fees,t.patient_id,t.doctor_id,t.appointment_id,(SELECT sum(ap.payment_amt) FROM az_appointment_payment_table ap WHERE ap.appointment_id = t.appointment_id) as payamtpay,(SELECT clinic_name from az_clinic_details where clinic_id= t.hospital_id and is_clinic = 'Y') as clinic_name,u.mobile as patient_mobile")
                        ->from('az_patient_appointment_details t')
                        ->leftJoin('az_user_details  u', 'u.user_id=t.patient_id')
                        ->where('t.doctor_id=:id', array(':id' => $userid))->order("appointment_date Asc")
                        ->queryAll();
            } elseif (in_array($roleid, array(6,7,8,9))) {
                $resultArr = Yii::app()->db->createCommand()
                        ->select('t.full_name,DATE_FORMAT(t.created_date, "%d %b %Y, %W") as aptdate,relation,mobile_no,t.created_date as appointment_date,book_id, CONCAT(t.address,",",t.area_name,",",t.city_name,",",t.state_name) as patient_address,collect_home,s.service_name')
                        ->from('az_lab_book_details t')->leftJoin("az_service_master s", "t.service_name = s.service_id")
                        ->where('t.center_id=:id', array(':id' => $userid))->order("appointment_date DESC")->limit(30)
                        ->queryAll();
            }

            $returnOutputArr['resultarr'] = $resultArr;
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

    public function actionGetAppRequest() {
        $returnOutputArr = array("isError" => false);
        try {
            $userid = Yii::app()->request->getParam("userid");
            $roleid = Yii::app()->request->getParam("roleid");

            if ($roleid == 3) {
                $resultArr = Yii::app()->db->createCommand()
                        ->select(" t.id,t.patient_name as first_name,t.patient_mobile as mobile,t.type_of_visit as address,t.doctor_id,t.preferred_day,preferred_day as aptdate,apt_confirm,(SELECT clinic_name FROM az_clinic_details cd WHERE cd.clinic_id = t.clinic_id) as clinic_name")
                        ->from('az_aptmt_query t')
                        ->where("apt_confirm ='NO' and doctor_id = " . $userid)
                        ->queryAll();
            } else if ($roleid == 4) {
                $resultArr = Yii::app()->db->createCommand()
                        ->select(" t.id,CONCAT('Patient Name','-',t.patient_name) as first_name,t.patient_mobile as mobile,t.type_of_visit as address,t.doctor_id,t.preferred_day,preferred_day as aptdate,apt_confirm,(SELECT clinic_name FROM az_clinic_details cd WHERE cd.clinic_id = t.clinic_id) as clinic_name,(SELECT CONCAT(apt_contact_no_1,';',CONCAT('Dr.',first_name,' ',last_name)) from az_user_details ud WHERE ud.user_id = t.doctor_id) as doctor_name,(SELECT group_concat(speciality_name) FROM az_speciality_user_mapping where user_id=t.doctor_id) AS speciality")
                        ->from('az_aptmt_query t')
                        ->where("apt_confirm ='NO' and created_by = " . $userid)
                        ->queryAll();
            }

            $returnOutputArr['resultarr'] = $resultArr;
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

    public function actionUpdateProfile() {
        $returnOutputArr = array("isError" => false);
        $user_id = Yii::app()->request->getParam("userid");
        try {
            $purifiedObj = Yii::app()->purifier;
            $formdata = Yii::app()->request->getParam("formdata");
            $postArr = json_decode($formdata);

            $model = UserDetails::model()->findByPk(array('user_id' => $user_id));
            //print_r($model);
            if (!empty($postArr)) {
                $model->user_id = $user_id;
                $model->role_id = 4;
                $model->first_name = $postArr->first_name;
                $model->last_name = $postArr->last_name;
                $model->address = $postArr->address;
                $model->email_1 = $postArr->email_1;
                $model->updated_date = date("Y-m-d H:i:s");
                
                if(isset($_FILES['file']) && !empty($_FILES['file'])) {
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $profileDir = 'profilepic/';                                    //profilepic
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("Y") . "/";                    //year
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("M") . "/";                    //month
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $path_part = pathinfo($_FILES['file']['name']);
                    //$fname = $profileDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                    $fname = $profileDir . $_FILES['file']['name'];
                    if(move_uploaded_file($_FILES['file']['tmp_name'], $baseDir.$fname)) {
                        $model->profile_image = $fname;
                    } else{
                        throw new Exception("There was an error uploading the file, please try again!");
                    }
                }
                
                if ($model->save()) {

                    $userArr = Yii::app()->db->createCommand()
                            ->select('user_id,role_id,patient_type,profile_image,first_name,last_name,is_active,password,mobile,email_1,address')
                            ->from('az_user_details')
                            ->where('user_id = :userid', array(':userid' => $user_id))
                            ->queryRow();
                    //print_r($userArr);
                    if (!empty($userArr)) {
                        $returnOutputArr['user'] = $userArr;
                    }
                } else {
                    //  print_r($model->getErrors());
                    throw new Exception("Error In Update Form");
                }
            }
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }
    
     public function actionGetDailyOffer(){
         //echo 'hiii';
        $returnOutputArr = array("isError" => false);
        try{
            $request = Yii::app()->request;
            $purifiedObj = Yii::app()->purifier;
            $htmlstr = "No Record Found";
            $location = Yii::app()->request->getParam("location");
            $resultArr = array();
            if (!empty($location)) {
                $category = $request->getParam("category");
                $iscity = "N";
                if($category == "main_city_name"){
                    $iscity = "Y";
                }
                $promo_date = $request->getParam("promo_date");
                $dayofweek = date("l", strtotime($promo_date));
                //echo $dayofweek;//exit;
                
                $paramArr = array();
                $whereClause = "u.role_id =3 AND ( (cd.free_opd_perday IS NOT NULL and cd.free_opd_perday <> 0) OR (u.free_opd_perday IS NOT NULL and u.free_opd_perday <>0 )) and ( u.free_opd_preferdays LIKE '%$dayofweek%' OR cd.free_opd_preferdays LIKE '%$dayofweek%') ";
                $otherServiceStr = "u.role_id not in(1,4,5,3) AND u.free_opd_perday IS NOT NULL and u.free_opd_perday <>0  and u.free_opd_preferdays LIKE '%$dayofweek%' ";
                if ($iscity == "Y") {
                    $whereClause .= " AND  ( u.city_name=:city_name OR cd.city_name = :city_name ) ";
                    $otherServiceStr .= " AND  u.city_name=:city_name ";
                    $paramArr[":city_name"] = $location;
                } elseif ($iscity == "N" && !empty($location)) {
                    $whereClause .= " AND (u.area_name=:area_name  OR cd.area_name = :area_name) ";
                    $otherServiceStr .= " AND  u.area_name=:area_name ";
                    $paramArr[":area_name"] = $location;
                }
                $specWiseCnt = Yii::app()->db->createCommand()
                        ->select('u.role_id,sum(IF( u.free_opd_perday IS NULL, cd.free_opd_perday,u.free_opd_perday)) AS ufreeopd,spm.speciality_id,spm.speciality_name')
                        ->from('az_user_details u')->leftJoin("az_clinic_details cd", "cd.doctor_id = u.user_id")->leftJoin("az_speciality_user_mapping spm", "spm.user_id = u.user_id")
                        ->where($whereClause, $paramArr)->group("spm.speciality_name")
                        ->queryAll();

                $serviceWiseCnt = Yii::app()->db->createCommand()
                        ->select('u.role_id,sum(u.free_opd_perday) AS ufreeopd,r.icon_name,r.role_name')
                        ->from('az_user_details u')->leftJoin("az_role_master r", "r.role_id = u.role_id")
                        ->where($otherServiceStr, $paramArr)->group("u.role_id")
                        ->queryAll();

                $cnt = 0;
                $index = 0;
                if (count($specWiseCnt) > 0) {
                    $resultArr[$index] = array( "catType" => "Doctors/Hospital","img" => '/images/icons/doctors_hospital.png') ;
                    $totalCnt = 0;
                    foreach ($specWiseCnt as $row) {
                        $spcnt = $row['ufreeopd'];
                        $usedOpdCnt = Yii::app()->db->createCommand()->select("count(`appointment_id`) totalapp")->from("az_patient_appointment_details")->where("`promo_id` is not null and doctor_id IN(SELECT u.user_id FROM az_user_details u LEFT JOIN `az_clinic_details` cd ON cd.doctor_id = u.user_id LEFT JOIN az_speciality_user_mapping spm ON spm.user_id = u.user_id WHERE spm.speciality_id = :spid and u.is_active = 1) AND appointment_date = :appdate ", array(":spid" => $row['speciality_id'], ":appdate" => date("Y-m-d", strtotime($promo_date))))->queryScalar();
                        $spcnt = $spcnt - $usedOpdCnt;
                        $redLink = "no";
                        $countText = "Closed";
                        if ($spcnt != 0 && !empty($row['speciality_name'])) {
                            $redLink = "yes";
                            $resultArr[$index]['subspec'][] = array("link" => $redLink, "cnt" => $spcnt, "spename" => $row['speciality_name'],'speciality' => $row['speciality_name'], 'location' => $location, 'iscity' => $iscity, "source" => "freeoffer", "dayofweek" => $dayofweek);
                            $totalCnt += $spcnt;
                        }else{
                            $resultArr[$index]['subspec'][] = array("link" => $redLink, "cnt" => $countText, "spename" => $row['speciality_name']);
                        }
                        
                    }
                    $resultArr[$index]['cnt'] = $totalCnt;
                    $index++;
                }
                if (count($serviceWiseCnt)) {
                    foreach ($serviceWiseCnt as $serrow) {
                        $spcnt = $serrow['ufreeopd'];
                        $resultArr[$index] = array("cnt" => $spcnt, "catType" => $serrow['role_name'],"img" =>"/images/icons/" . $serrow['icon_name']) ;
                        $index++;
                    }
                }
            }
            $returnOutputArr['result'] =  $resultArr;
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }
        echo json_encode($returnOutputArr);
     }
    public function actionPromocode() {
        $returnOutputArr = array("isError" => false);
        try {
            $purifiedObj = Yii::app()->purifier;
            $promo = Yii::app()->request->getParam("promo");
            $userid = Yii::app()->request->getParam("userid");
            $actiontype = Yii::app()->request->getParam("actiontype");
            if (!empty($actiontype)) {
                switch ($actiontype)
                {
                    case "apply" :
                        $promoInfoArr = Yii::app()->db->createCommand()->select("*")->from("az_promo_code ")->where("created_by=:id AND promo_code =:code ", array(':id' => $userid, ':code' => $promo))->queryRow();
                    $status = "Invalid Promo Code";

                    if (!empty($promoInfoArr) && count($promoInfoArr) > 0) {
                        if ($promoInfoArr['promo_status'] == "Used") {
                            $status = "Promo Code has Already Used";
                        } elseif (strtotime($promoInfoArr['expired_date']) < strtotime(date("Y-m-d"))) {
                            $status = "Promo Code has Expired";
                        } else {
                            $status = "";
                            $returnOutputArr['promoid'] = $promoInfoArr['promo_id'];
                        }
                    }
                    if(!empty($status)) {
                        throw new Exception($status);
                    }
                    break;
                    case "generate" :
                        $todayDate = date("Y-m-d");
                        $promo_code = Yii::app()->db->createCommand()->select('promo_code')->from('az_promo_code')->where("created_by = :uid AND promo_status = 'Unused' AND expired_date >= :today", array(":uid" => $userid, ":today" => $todayDate))->order("promo_id desc")->limit(1)->queryScalar();

                        if (empty($promo_code)) {
                            $promo_code = rand(11111, 99999) . $userid;
                            $model = new PromoCode;
                            $model->promo_code = $promo_code;
                            $model->generate_date = $todayDate;
                            $expired_date = date('Y-m-d', strtotime($todayDate . ' + 15 days')); //strtotime('+15 days',$promo_date);
                            $model->expired_date = $expired_date;
                            $model->created_by = $userid;
                            $model->promo_status = "Unused";
                            $model->save(); 
                        }
                        $returnOutputArr['promocode'] = $promo_code;
                        break;
                }
            }
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    } 
     public function actionSaveFeeback() {
        $returnOutputArr = array("isError" => false);
        try {
            $purifiedObj = Yii::app()->purifier;
            $formdata = Yii::app()->request->getParam("formdata");
            $postArr = json_decode($formdata);

            if (!empty($postArr)) {
                $result = Yii::app()->db->createCommand()->insert("az_feedback_details", array("name" => $postArr->name, "mobile_no" => $postArr->mobile, "email" => $postArr->email, "message" => $postArr->message, "created_date" => date("Y-m-d H:i:s")));
                if ($result) {
                    
                } else {
                    //  print_r($model->getErrors());
                    throw new Exception("Error In Update Form");
                }
            }
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode($returnOutputArr);
    }

}
