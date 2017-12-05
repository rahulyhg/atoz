<?php

//ini_set('memory_limit','32M');
//ini_set("post_max_size", "32M");
//ini_set("upload_max_filesize", "12M");

class UserDetailsController extends Controller {

    //public $layout = '//layouts/adminLayout';

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('adminDashboard', 'viewDoctor', 'viewPatient', 'hospital', 'getStateName', 'getCityName', 'getAreaName', 'getPincodeData', 'doctorDetails', 'sessionDoctorDetails', 'registration', 'updateDoctordetails', 'adminDoctor', 'adminPatient', 'updateAdminDoctor', 'setUserData', 'getSpecialityName', 'manageHospital', 'manageHospitalDoctor', 'createHospDoc', 'patientAppointments', 'clinicDetails', 'updateClinicDetails', 'patientDetails', 'updateHospitalDoctor', 'viewHospitalDoctor', 'viewHospital', 'updateHospitalProfile', 'updateAdminHospital', 'createAdminHospital', 'createAdminDoctor', 'createAdminpatient', 'pathology', 'pathologySetData', 'managePathology', 'viewPathology', 'createAdminPathology', 'updateAdminPathology', 'updatePathology', 'onSuccess', 'manageInactiveHospital', 'manageInactiveDoctor', 'manageInactiveHospitalDoctor', 'manageInactivePatien', 'GetPatientRequest', 'corporatePatient', 'updateAdminCorporate', 'corporateList','getPendingRequest'
                ),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionAdminDashboard() {
        $this->layout = 'adminLayout';
        $this->render('admindashboard');
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionViewDoctor($id) {
        $this->layout = 'adminLayout';
        try {
            $enc_key = Yii::app()->params->enc_key;
            $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        } catch (Exception $ex) {
            $model->addError(NULL, $ex->getMessage());
        }

        $this->render('viewDoctor', array(
            'model' => $this->loadModel($id)
        ));
    }

    public function actionViewPatient($id) {
        $this->layout = 'adminLayout';
        try {
            $enc_key = Yii::app()->params->enc_key;
            $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        } catch (Exception $ex) {
            $model->addError(NULL, $ex->getMessage());
        }

        $this->render('viewPatient', array(
            'model' => $this->loadModel($id)
        ));
    }

    public function actionHospital() {
        $enc_key = Yii::app()->params->enc_key;
        $roleid = Yii::app()->request->getParam('roleid');
        $data = "";
        $roleid = base64_decode($roleid);
        $model = new UserDetails;
        $commonobj = new CommonFunction;
        $session = new CHttpSession;
        $session->open();

        if (isset($_POST['UserDetails'])) {

            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                $postArr = $request->getPost("UserDetails");


                $model->hospital_name = $session['hospital_name'];
                $model->type_of_hospital = $session['type_of_hospital'] = $postArr['type_of_hospital'];
                $model->hospital_registration_no = $session['hospital_registration_no'] = $postArr['hospital_registration_no'];
                if (!empty($session['payment_type'])) {
                    $model->payment_type = implode(",", $session['payment_type']);
                }
                if (!empty($session['hos_establishment']))
                    $model->hos_establishment = date("Y-m-d", strtotime("01-" . $session['hos_establishment']));
                //$model->hos_validity = date("Y-m-d", strtotime("01-" . $session['hos_validity']));
                $model->type_of_establishment = $session['type_of_establishment'];
                if ($session['type_of_establishment'] == "others") {
                    $model->other_est_type = $session['other_est_type'];
                }
                //$model->speciality = $session['speciality'];
                $model->mobile = $session['mobile'];
                if (!empty($session['password'])) {
                    $model->password = md5($session['password']);
                }
                $model->landline_1 = $session['landline_1'];
                $model->email_1 = $session['email_1'];
                $model->emergency_no_1 = $session['emergency_no_1'];
                $model->ambulance_no_1 = $session['ambulance_no_1'];
                $model->tollfree_no_1 = $session['tollfree_no_1'];
                $model->coordinator_name_1 = $session['coordinator_name_1'];
                $model->coordinator_mobile_1 = $session['coordinator_mobile_1'];
                $model->coordinator_name_2 = $session['coordinator_name_2'];
                $model->coordinator_mobile_2 = $session['coordinator_mobile_2'];
                $model->coordinator_email_1 = $session['coordinator_email_1'];
                $model->coordinator_email_2 = $session['coordinator_email_2'];
                $model->is_open_allday = $session['is_open_allday'];
                if (!empty($session['hospital_open_time']))
                    $model->hospital_open_time = date("H:i:s", strtotime($session['hospital_open_time']));
                if (!empty($session['hospital_close_time']))
                    $model->hospital_close_time = date("H:i:s", strtotime($session['hospital_close_time']));

                $model->pincode = $session['pincode'];
                $model->state_id = $session['state_id'];
                $model->state_name = $session['state_name'];
                $model->city_id = $session['city_id'];
                $model->city_name = $session['city_name'];
                $model->area_id = $session['area_id'];
                $model->area_name = $session['area_name'];
                $model->landmark = $session['landmark'];
                $model->address = $session['address'];
                $model->latitude = $session['latitude'];
                $model->longitude = $session['longitude'];
                $model->description = $session['description'];
                $model->other_est_type = $session['other_est_type'];

                $model->is_active = 0;
                $model->created_date = date('Y-m-d H:i:s');
                $model->updated_date = date('Y-m-d H:i:s');
                $model->country_id = 1;
                $model->role_id = 5;
                if ($model->save()) {
                    $user_id = $model->user_id;
                    $mobile = $model->mobile;
                    if (!empty($session['speciality'])) {
                        foreach ($session['speciality'] as $speId) {
                            $userSpecModel = new SpecialityUserMapping();
                            $userSpecModel->user_id = $user_id;
                            $userSpecModel->speciality_id = $speId;
                            $specName = Yii::app()->db->createCommand()->select("speciality_name")->from("az_speciality_master")->where("speciality_id = :id", array(":id" => $speId))->queryScalar();
                            $userSpecModel->speciality_name = $specName;
                            $userSpecModel->save();
                        }
                    }
                    
                    if (!empty($session['speciality'])) {
                        foreach ($session['userservice'] as $key => $serviceId) {
                            $userServiceModel = new ServiceUserMapping();
                            $userServiceModel->user_id = $user_id;
                            $userServiceModel->service_id = $serviceId;
                            $userServiceModel->is_available_allday = $session['twentyfour'][$key];
                            $userServiceModel->service_discount = $session['discount'][$key];
                            $userServiceModel->corporate_discount = $session['corporate_discount'][$key];
                            $userServiceModel->is_clinic = 0;
                            $userServiceModel->save();
                        }
                    }

                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $profileDir = 'profilepic/';               //profilepic
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("M") . "/";
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    if (!empty($_POST['profile'])) {
                        $imageName = time() . "_" . rand(111, 9999) . '.png';
                        $model->profile_image = $profileDir . $imageName;

                        if (file_put_contents($baseDir . $profileDir . $imageName, $data)) {
                            
                        }
                    }
                    $model->save();


                    $documentDir = 'document/';               //profilepic
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("M") . "/";
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $registDocObj = CUploadedFile::getInstance($model, "registraiondoc");

                    if (!empty($registDocObj)) {
                        $path_part = pathinfo($registDocObj->name);
                        $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        if ($registDocObj->saveAs($baseDir . $fname)) {
                            $documentDetModel = new DocumentDetails();
                            $documentDetModel->user_id = $user_id;
                            $documentDetModel->doc_type = "Hospital Registration";
                            $documentDetModel->document = $fname;
                            $documentDetModel->save(false);
                        }
                    }

                    $otherDocObj = CUploadedFile::getInstance($model, "otherdoc");


                    if (!empty($otherDocObj)) {
                        $path_part = pathinfo($otherDocObj->name);
                        $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        if ($otherDocObj->saveAs($baseDir . $fname)) {
                            $documentDetModel = new DocumentDetails();
                            $documentDetModel->user_id = $user_id;
                            $documentDetModel->doc_type = "Other Registration";
                            $documentDetModel->document = $fname;
                            $documentDetModel->save(false);
                        }
                    }
                    $transaction->commit();
                    $session->destroy();
                    $model->unsetAttributes();
                    $commonobj->sendSms($mobile, "Thanks for your registration. Your profile will shortly be activated after a small verification process.");
                    Yii::app()->user->setFlash('Success', 'You have successfully registered. Your account will be activated after verification.');
                    $this->redirect(array('userDetails/hospital'));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('hospital', array(
            'model' => $model, 'session' => $session, 'roleid' => $roleid
        ));
    }

    public function actionGetStateName() {
        $request = Yii::app()->request;
        $countryname = $request->getParam('country');

        $cmd = Yii::app()->db->createCommand()
                ->select('state_name,state_id')
                ->from('az_state_master')
                ->where('country_id=:id', array(':id' => $countryname))
                ->queryAll();

        $returnArr['state_name'] = $cmd;
        echo json_encode(array('data' => $cmd));
    }

    public function actionGetCityName() {
        $request = Yii::app()->request;
        $statename = $request->getParam('state');
        $cmd = Yii::app()->db->createCommand()
                ->select('city_id,city_name')
                ->from('az_city_master')
                ->where('state_id=:id', array(':id' => $statename))
                ->queryAll();

        $returnArr['city_name'] = $cmd;
        echo json_encode(array('data' => $cmd));
    }

    public function actionGetAreaName() {
        $request = Yii::app()->request;
        $areaname = $request->getParam('area');

        $cmd = Yii::app()->db->createCommand()
                ->select('area_id,area_name,pincode')
                ->from('az_area_master')
                ->where('city_id=:id', array(':id' => $areaname))
                ->queryAll();

        $returnArr['area_name'] = $cmd;
        echo json_encode(array('data' => $cmd));
    }

    public function actionGetPincodeData() {
        $resultArr = array();
        if (isset($_POST['pincode'])) {
            $pincode = Yii::app()->request->getParam('pincode');
            $pincodecmd = Yii::app()->db->createCommand()->select('area_id,area_name,city_id, (SELECT state_id FROM az_city_master cm WHERE cm.city_id = t.city_id ) as stateid')->from('az_area_master t')->where('pincode=:pincode', array(':pincode' => $pincode))->queryRow();
            if (!empty($pincodecmd)) {
                //get all area under that city
                $areacmd = Yii::app()->db->createCommand()->select('area_id,area_name,pincode')->from('az_area_master')->where('city_id=:id', array(':id' => $pincodecmd['city_id']))->queryAll();
                $areaName = "";
                $areaHtml = "<option value=''>Select Area</option>";
                foreach ($areacmd as $row) {
                    $areaHtml .= "<option value='" . $row['area_id'] . "' ";
                    if ($row['area_id'] == $pincodecmd['area_id']) {
                        $areaHtml .= " selected ";
                        $areaName = $row['area_name'];
                    }
                    $areaHtml .= ">" . $row['area_name'] . "</option>";
                }
                $resultArr['areadata'] = $areaHtml;
                //now get all city
                $cityName = "";
                $citycmd = Yii::app()->db->createCommand()->select('city_id,city_name')->from('az_city_master')->where('state_id=:id', array(':id' => $pincodecmd['stateid']))->queryAll();
                $cityHtml = "<option value=''>Select City</option>";
                foreach ($citycmd as $row) {
                    $cityHtml .= "<option value='" . $row['city_id'] . "' ";
                    if ($row['city_id'] == $pincodecmd['city_id']) {
                        $cityHtml .= " selected ";
                        $cityName = $row['city_name'];
                    }
                    $cityHtml .= ">" . $row['city_name'] . "</option>";
                }
                $resultArr['citydata'] = $cityHtml;
                $resultArr['areaname'] = $areaName;
                $resultArr['cityname'] = $cityName;
                $resultArr['stateid'] = $pincodecmd['stateid'];
            }
        }
        echo json_encode($resultArr);
    }

    /*
     * DoctorDetails - Doctor Entered Data
     * @param => all doctor related info
     * @author => Sagar Badgujar
     */

    public function actionDoctorDetails() {
        $model = new UserDetails;
        $model1 = new DoctorExperience;
        $model2 = new ClinicDetails;
        $model3 = new DocumentDetails;
        $model4 = new ServiceUserMapping;
        $model5 = new SpecialityUserMapping;
        $model6 = new ClinicVisitingDetails;
        $model7 = new DegreeMaster;


        $roleid = Yii::app()->request->getParam('roleid');

        $roleid = base64_decode($roleid);
        $session = new CHttpSession;

        if (isset($_POST['UserDetails'])) {

            $session->open();
            $postArr = Yii::app()->request->getParam('UserDetails');

            $session['first_name'] = $postArr['first_name'];
            $session['last_name'] = $postArr['last_name'];
            $session['gender'] = $postArr['gender'];
            $session['birth_date'] = $postArr['birth_date'];
            $session['blood_group'] = $postArr['blood_group'];
            $session['age'] = $postArr['age'];
            $session['doctor_registration_no'] = $postArr['doctor_registration_no'];
            $session['mobile'] = $postArr['mobile'];
            $session['password'] = $postArr['password'];
            $session['apt_contact_no_1'] = $postArr['apt_contact_no_1'];
            $session['apt_contact_no_2'] = $postArr['apt_contact_no_2'];
            $session['email_1'] = $postArr['email_1'];
            $session['email_2'] = $postArr['email_2'];
            $session['description'] = $postArr['description'];
            if (isset($postArr['speciality'])) {
                $session['speciality'] = $postArr['speciality'];
            }
            if (isset($postArr['sub_speciality'])) {
                $session['sub_speciality'] = $postArr['sub_speciality'];
            }
            if (isset($postArr['degree'])) {
                $session['degree'] = $postArr['degree'];
            }

            $DoctExp = Yii::app()->request->getParam('DoctorExperience');

            $session['work_from'] = $DoctExp['work_from'];

            $session['work_to'] = $DoctExp['work_to'];
            //$session['doctor_role'] = $DoctExp['doctor_role'];
            // $session['doccity_name'] = $DoctExp['city_name'];
            //$session['clinic_name1'] = $DoctExp['ex_clinic_name'];

            $clinicDetail = Yii::app()->request->getParam('ClinicDetails');
            $session['clinic_name'] = $clinicDetail['clinic_name'];
            $session['opd_consultation_fee'] = $clinicDetail['opd_consultation_fee'];
            $session['opd_consultation_discount'] = $clinicDetail['opd_consultation_discount'];
            $session['free_opd_perday'] = $clinicDetail['free_opd_perday'];
            $session['clinic_reg_certificate'] = $clinicDetail['clinic_reg_certificate'];
            $session['state_id'] = $clinicDetail['state_id'];
            $session['city_id1'] = $clinicDetail['city_id'];
            $session['area_id'] = $clinicDetail['area_id'];
            $session['pincode'] = $clinicDetail['pincode'];
            $session['state_name'] = $clinicDetail['state_name'];
            $session['city_name'] = $clinicDetail['city_name'];
            $session['area_name'] = $clinicDetail['area_name'];
            $session['c_landmark'] = $clinicDetail['landmark'];
            $session['c_address'] = $clinicDetail['address'];
            if (isset($clinicDetail['free_opd_preferdays'])) {
                $session['free_opd_preferdays'] = $clinicDetail['free_opd_preferdays'];
            }
            if (isset($clinicDetail['payment_type'])) {
                $session['payment_type'] = $clinicDetail['payment_type'];
            }
            if (isset($clinicDetail['alldayopen'])) {
                $session['alldayopen'] = $clinicDetail['alldayopen'];
            }
            $clinicvisit = Yii::app()->request->getParam('ClinicVisitingDetails');


            if (isset($clinicvisit['day'])) {
                $session['day'] = $clinicvisit['day'];
                $session['clinic_open_time'] = $clinicvisit['clinic_open_time'];
                $session['clinic_close_time'] = $clinicvisit['clinic_close_time'];
                $session['clinic_eve_open_time'] = $clinicvisit['clinic_eve_open_time'];
                $session['clinic_eve_close_time'] = $clinicvisit['clinic_eve_close_time'];
            }

            $ServiceUserMapping = Yii::app()->request->getParam('ServiceUserMapping');
            $session['service_id'] = $ServiceUserMapping['service_id'];
            $session['service_discount'] = $ServiceUserMapping['service_discount'];
            $session['corporate_discount'] = $ServiceUserMapping['corporate_discount'];
            
            $session['twentyfour'] = $ServiceUserMapping['twentyfour'];

            Yii::app()->end();
        }//UserDetails


        $this->render('doctordetails', array(
            'model' => $model, 'model1' => $model1, 'model2' => $model2, 'model3' => $model3, 'model4' => $model4, 'model5' => $model5, 'model6' => $model6, 'model7' => $model7, 'session' => $session, 'roleid' => $roleid
        ));
    }

    /*
     * DoctorDetails - Doctor Entered Data is saving
     * @param => all doctor related info saving
     * @author => Sagar Badgujar
     */

    public function actionSessionDoctorDetails() {
        $roleid = Yii::app()->request->getParam('roleid');

        $roleid = base64_decode($roleid);
        $session = new CHttpSession;
        $model = new UserDetails;
        $model1 = new DoctorExperience;
        $model2 = new ClinicDetails;
        $model3 = new DocumentDetails;
        $model4 = new ServiceUserMapping;
        $model5 = new SpecialityUserMapping;

        $model6 = new ClinicVisitingDetails;
        $model7 = new DegreeMaster;
        $session->open();


        $commonobj = new CommonFunction;
        $data = "";

        if (isset($_POST['UserDetails']) && count($_POST['UserDetails']) > 0) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {

                $model->is_active = 0;
                $model->created_date = date('Y-m-d H:i:s');
                $model->role_id = 3;
                $model->first_name = $session['first_name'];
                $model->last_name = $session['last_name'];
                $model->gender = $session['gender'];
                $birthDate = date("Y-m-d", strtotime($session['birth_date']));
                $model->birth_date = $birthDate;
                $model->age = $session['age'];
                $model->blood_group = $session['blood_group'];
                $model->doctor_registration_no = $session['doctor_registration_no'];
                $model->mobile = $session['mobile'];
                $model->password = md5($session['password']);
                $model->apt_contact_no_1 = $session['apt_contact_no_1'];
                $model->apt_contact_no_2 = $session['apt_contact_no_2'];
                $model->email_1 = $session['email_1'];
                $model->email_2 = $session['email_2'];
                $model->description = $session['description'];
                $model->created_date = date('Y-m-d H:i:s');
               // $model->updated_date = date('Y-m-d H:i:s');

                if (isset($session['sub_speciality']) && count($session['sub_speciality']) > 0) {
                    $sub_spe = implode(',', $session['sub_speciality']);
                    $model->sub_speciality = $sub_spe;
                }

                if ($model->save()) {

                    $user_id = $model->user_id;
                    $mobile = $model->mobile;

                    if (isset($session['speciality']) && count($session['speciality']) > 0) {
                        foreach ($session['speciality'] as $key => $value) {
                            $specialityname = SpecialityMaster::model()->findByAttributes(array('speciality_id' => $value));
                            $specmap = new SpecialityUserMapping;
                            $specmap->speciality_id = $value;
                            $specmap->speciality_name = $specialityname['speciality_name'];
                            $specmap->user_id = $user_id;
                            if ($specmap->save()) {
                                
                            }
                        }
                    }


                    if (isset($session['degree']) && count($session['degree']) > 0) {
                        foreach ($session['degree'] as $key => $value) {
                            $degreename = DegreeMaster::model()->findByAttributes(array('degree_id' => $value));
                            $degreeMappingModel = new DoctorDegreeMapping;
                            $degreeMappingModel->degree_id = $value;
                            $degreeMappingModel->doctor_id = $user_id;
                            $degreeMappingModel->degree_name = $degreename['degree_name'];
                            if ($degreeMappingModel->save()) {
                                
                            }
                        }
                    }

                    //$exp = 0;
//                    if (isset($session['work_from']) && count($session['work_from']) > 0) {
//                        foreach ($session['work_from'] as $key => $value) {
//                            $docexp = new DoctorExperience;
//                            $docexp->doctor_id = $user_id;
//                            $docexp->work_from = $value;
//                            $docexp->work_to = $session['work_to'][$key];
//                            $docexp->doctor_role = $session['doctor_role'][$key];
//                            //  $docexp->city_name = $session['doccity_name'][$key];
//                            $docexp->ex_clinic_name = $session['clinic_name1'][$key];
//
//
//                            $formatdate1 = date('Y-m-d', strtotime("01-" . $value));
//                            $formatdate2 = date('Y-m-d', strtotime("01-" . $session['work_to'][$key]));
//
//                            $datetime1 = new DateTime($formatdate1);
//                            $datetime2 = new DateTime($formatdate2);
//                            $interval = $datetime2->diff($datetime1);
//                            $exp += ($interval->format('%y') * 12) + $interval->format('%m');
//
//                            if ($docexp->save()) {
//                                
//                            }
//                        }
//                    }
                  //  print_r($session['work_from']);exit;
                    if (isset($session['work_from'])) {
                        $docexp = new DoctorExperience;
                        $year = $session['work_from'];
                        $month = $session['work_to'];
                        $exp = 0;
                        if($year == 0){
                            $exp = $month;
                        }else{
                            $year = $year * 12;
                            $exp = $year + $month;
                        }
                        $docexp->doctor_id = $user_id;
                        $docexp->work_from = $session['work_from'];   //store year 
                        $docexp->work_to = $session['work_to'];    //store month
                        if ($docexp->save()) {
                            }else{
                               // print_r($docexp->getErrors());
                            }
                        
                    }
                   $model->experience = $exp;

                    $model2->doctor_id = $user_id;
                    $model2->clinic_name = $session['clinic_name'];
                    $model2->opd_consultation_fee = $session['opd_consultation_fee'];
                    $model2->opd_consultation_discount = $session['opd_consultation_discount'];
                    $model2->free_opd_perday = $session['free_opd_perday'];

                    $model2->clinic_reg_certificate = $session['clinic_reg_certificate'];
                    $model2->country_id = 1;
                    $model2->state_id = $session['state_id'];
                    $model2->city_id = $session['city_id1'];
                    $model2->area_id = $session['area_id'];
                    $model2->pincode = $session['pincode'];
                    $model2->country_name = 'India';
                    $model2->state_name = $session['state_name'];
                    $model2->city_name = $session['city_name'];
                    $model2->area_name = $session['area_name'];
                    $model2->landmark = $session['c_landmark'];
                    $model2->address = $session['c_address'];
                    $model2->alldayopen = $session['alldayopen'];

                    $Daystr = NULL;
                    if (isset($session['free_opd_preferdays']) && count($session['free_opd_preferdays']) > 0) {
                        foreach ($session['free_opd_preferdays'] as $key => $value) {
                            $Daystr .= $value . ",";
                        }
                    }
                    $model2->free_opd_preferdays = $Daystr;

                    $paymentstr = NULL;
                    if (isset($session['payment_type']) && count($session['payment_type']) > 0) {
                        foreach ($session['payment_type'] as $key => $value) {
                            $paymentstr .= $value . ",";
                        }
                    }
                    $model2->payment_type = $paymentstr;


                    $baseDir = Yii::app()->basePath . "/../uploads/";

                    if (!empty($_POST['profile'])) {


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


                        $imageName = time() . "_" . rand(111, 9999) . '.png';
                        $model->profile_image = $profileDir . $imageName;

                        if (file_put_contents($baseDir . $profileDir . $imageName, $data)) {
                            
                        }
                    }
                    if ($model->save()) {
                        
                    }

                    $clinicDir = 'certificates/';                               //certificates
                    if (!is_dir($baseDir . $clinicDir)) {
                        mkdir($baseDir . $clinicDir);
                    }
                    $clinicDir = $clinicDir . date("Y") . "/";                  //year
                    if (!is_dir($baseDir . $clinicDir)) {
                        mkdir($baseDir . $clinicDir);
                    }
                    $clinicDir = $clinicDir . date("M") . "/";                  //month
                    if (!is_dir($baseDir . $clinicDir)) {
                        mkdir($baseDir . $clinicDir);
                    }
                    $clinicdoc = CUploadedFile::getInstance($model2, 'clinic_reg_certificate');

                    if (!empty($clinicdoc)) {
                        $imageFileType = pathinfo($clinicdoc, PATHINFO_EXTENSION);
                        $allowedExtArr = array('gif', 'png', 'jpg', 'jpeg', 'pdf', 'docs', 'docx', 'txt');

                        if (!in_array($imageFileType, $allowedExtArr)) {

                            //  $errorMsg = "Please Select png,gif,jpg,jpef Files Only";
                            throw new Exception("Please Select png,gif,jpg,jpef,pdf,docs,docx,txt Files Only");
                        }

                        if (!empty($clinicdoc)) {
                            $path_part = pathinfo($clinicdoc->name);
                            $cname = $clinicDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $model2->clinic_reg_certificate = $cname;
                            $clinicdoc->saveAs($baseDir . $model2->clinic_reg_certificate);
                        }
                    }

                    if ($model2->save()) {

                        $clinic_id = $model2->clinic_id;
                    }

                    foreach ($session['service_id'] as $key => $value) {
                        $model4 = new ServiceUserMapping;
                        $model4->user_id = $user_id;
                        $model4->service_id = $value;
                        $model4->service_discount = $session['service_discount'][$key];
                        $model4->corporate_discount = $session['corporate_discount'][$key];
                        $model4->is_clinic = 1;
                        $model4->is_available_allday = $session['twentyfour'][$key];
                        $model4->clinic_id = $clinic_id;
                        if ($model4->save()) {
                            
                        }
                    }
                    if (isset($_POST['ClinicDetails']['alldayopen']) && $_POST['ClinicDetails']['alldayopen'] == 'Y') {

                        $model2->alldayopen = 'Y';

                        if ($model2->save()) {
                            
                        }
                    } else {
                        if (isset($session['day']) && count($session['day']) > 0) {
                            foreach ($session['day'] as $key => $value) {
                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = $clinic_id;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;
                                $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($session['clinic_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($session['clinic_close_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($session['clinic_eve_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($session['clinic_eve_close_time'][$key]));

                                if ($ClinicVisitingDetails->save()) {
                                    
                                }
                            }
                        }
                    }

                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    $docDir = 'document/';                                      //document
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("Y") . "/";                        //year
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("M") . "/";                        //month
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }


                    $photos = CUploadedFile::getInstancesByName('DocumentDetails[doc_photo]');
                    // proceed if the images have been set
                    if (isset($photos) && count($photos) > 0) {
                        foreach ($photos as $image => $pic) {
                            $docdetails = new DocumentDetails;
                            $path_part = pathinfo($pic->name);
                            $pic_name = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $docdetails->document = $pic_name;
                            $pic->saveAs($baseDir . $docdetails->document);
                            $docdetails->doc_type = 'Gallery_photos';
                            $docdetails->user_id = $user_id;
                            if ($docdetails->save()) {
                                
                            }
                        }
                    }

                    $docname = CUploadedFile::getInstance($model3, 'document');
                    if (!empty($docname)) {
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model3->document = $dname;
                        $docname->saveAs($baseDir . $model3->document);
                        $model3->doc_type = 'Doctor_Registration';
                        $model3->user_id = $user_id;
                        if ($model3->save()) {
                            
                        }
                    }
                    $otherdoc = new DocumentDetails;
                    $otherdocname = CUploadedFile::getInstance($model3, 'otherdoc');
                    if (!empty($otherdocname)) {
                        $path_part = pathinfo($otherdocname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $otherdoc->document = $dname;
                        $otherdocname->saveAs($baseDir . $otherdoc->document);
                        $otherdoc->doc_type = 'otherdoc';
                        $otherdoc->user_id = $user_id;
                        if ($otherdoc->save()) {
                            
                        }
                    }

                    if ($model->save()) {
                        
                    }

                    $transaction->commit();
                    $session->destroy();
                    $model->unsetAttributes();
                    $commonobj->sendSms($mobile, "Thanks for your registration. Your profile will shortly be activated after a small verification process.");
                    Yii::app()->user->setFlash('Success', 'You have successfully registered. Your account will be activated after verification.');
                    $this->redirect(array('userDetails/doctordetails'));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('doctordetails', array(
            'model' => $model, 'model1' => $model1, 'model2' => $model2, 'model3' => $model3, 'model4' => $model4, 'model5' => $model5, 'model6' => $model6, 'model7' => $model7, 'session' => $session, 'roleid' => $roleid
        ));
    }

    public function actionOnSuccess() {
        $model = new UserDetails;
        $this->render('onSuccess', array(
            'model' => $model
        ));
        ;
    }

    public function actionRegistration() {
        $this->render('registration');
    }

    /*
     * Update Doctor Data
     * @author => Sagar Badgujar
     */

    public function actionUpdateDoctorDetails($id, $tab = "tab_a") {


        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);

        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));             //Userdetails
        $model1 = DoctorExperience::model()->findByAttributes(array('doctor_id' => $id));    //DoctorExperience
        $model2 = ClinicDetails::model()->findByAttributes(array('doctor_id' => $id));        //ClinicDetails     
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        $roleid = $model->role_id;
        //  print_r($model2);
        if (empty($model2)) {
            $model2 = new ClinicDetails;
        }
        if (empty($model3)) {
            $model3 = new DocumentDetails;
        }
        $clinicNameArray = Yii::app()->db->createCommand()
                ->select('clinic_name,clinic_id')
                ->from(' az_clinic_details ')
                ->where('doctor_id=:id', array(':id' => $id))
                ->queryAll();

        $firstClinicid = 0;
        $clinicname = array();
        foreach ($clinicNameArray as $clinickey => $row) {
            if ($clinickey == 0) {
                $firstClinicid = $row['clinic_id'];
            }
            $clinicname[$row['clinic_id']] = array('clinic_name' => $row['clinic_name']);
        }
       
        if($firstClinicid != 0){
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('clinic_id' => $firstClinicid));}else{
            
            $serviceUserMapping = new ServiceUserMapping;
        }
        
//        $parenthosid=$model->parent_hosp_id;
//        if(empty($parenthosid))
//        {
//            $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('clinic_id' => $firstClinicid));  //ServiceMapping
//        }else{
//            $serviceUserMapping=new ServiceUserMapping;
//        }
        $model5 = SpecialityUserMapping::model()->findByAttributes(array('user_id' => $id));                        //SpecialityUserMapping
        $model6 = ClinicVisitingDetails::model()->findByAttributes(array('doctor_id' => $id));                        //ClinicVisitingDetails

        if (empty($model6)) {
            $model6 = new ClinicVisitingDetails;
        }

        $model7 = DoctorDegreeMapping::model()->findByAttributes(array('doctor_id' => $id));                         //DoctorDegreeMapping

        if (isset($_POST['UserDetails'])) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
        }
        if (isset($_POST['UserDetails']) && count($_POST['UserDetails']) > 0) {

            $transaction = Yii::app()->db->beginTransaction();
            try {

                $postArr = Yii::app()->request->getParam('UserDetails');

                $purifiedObj = Yii::app()->purifier;
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
                $model->gender = $purifiedObj->getPurifyText($postArr['gender']);
                $birthDate = date("Y-m-d", strtotime($postArr['birth_date']));
                $model->age = $postArr['age'];
                $model->birth_date = $birthDate;
                $model->blood_group = $postArr['blood_group'];
                $model->doctor_registration_no = $postArr['doctor_registration_no'];
                // $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password'])) {
                    $model->password = md5($postArr['password']);
                }
                $model->apt_contact_no_1 = $purifiedObj->getPurifyText($postArr['apt_contact_no_1']);
                $model->apt_contact_no_2 = $purifiedObj->getPurifyText($postArr['apt_contact_no_2']);
                $model->email_1 = $purifiedObj->getPurifyText($postArr['email_1']);
                $model->email_2 = $purifiedObj->getPurifyText($postArr['email_2']);
                if (!empty($postArr['description']))
                    $model->description = $purifiedObj->getPurifyText($postArr['description']);
                $model->updated_date = date('Y-m-d H:i:s');
                $model->updated_by = Yii::app()->user->id;


                if (isset($postArr['sub_speciality']) && count($postArr['sub_speciality']) > 0) {
                    $sub_spe = implode(',', $postArr['sub_speciality']);
                    $model->sub_speciality = $sub_spe;
                }

                $oldImgName = $model->profile_image;


                if ($model->save()) {

                    if (!empty($_POST['ClinicDetails'])) {
                        $clinicdetails = $_POST['ClinicDetails'];

                        $model2->doctor_id = $id;
                        $model2->clinic_name = $clinicdetails['clinic_name'];
                        if (!empty($clinicdetails['opd_consultation_fee']))
                            $model2->opd_consultation_fee = $clinicdetails['opd_consultation_fee'];
                        if (!empty($clinicdetails['opd_consultation_discount']))
                            $model2->opd_consultation_discount = $clinicdetails['opd_consultation_discount'];
                        if (!empty($clinicdetails['free_opd_perday']))
                            $model2->free_opd_perday = $clinicdetails['free_opd_perday'];


                        $model2->country_id = 1;
                        $model2->state_id = $clinicdetails['state_id'];
                        $model2->city_id = $clinicdetails['city_id'];
                        $model2->area_id = $clinicdetails['area_id'];
                        $model2->pincode = $clinicdetails['pincode'];
                        $model2->country_name = 'India';
                        $model2->state_name = $clinicdetails['state_name'];
                        $model2->city_name = $clinicdetails['city_name'];
                        $model2->area_name = $clinicdetails['area_name'];
                        $model2->landmark = $clinicdetails['landmark'];
                        $model2->address = $clinicdetails['address'];
                        $paymentstr = NULL;
                        if ((!empty($clinicdetails['payment_type']))) {

                            foreach ($clinicdetails['payment_type'] as $key => $value) {
                                $paymentstr .= $value . ",";
                            }

                            $model2->payment_type = $paymentstr;
                        }
                        $Daystr = NULL;
                        if ((!empty($clinicdetails['free_opd_preferdays']))) {
                            foreach ($clinicdetails['free_opd_preferdays'] as $key => $value) {
                                $Daystr .= $value . ",";
                            }

                            $model2->free_opd_preferdays = $Daystr;
                        }

                        if ($model2->save()) {
                            
                        }
                    }


                    Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'user_id=:id AND is_clinic=:isclinic', array(':id' => $id, ':isclinic' => '1'));

                    if (!empty($_POST['service'])) {

                        $serivceIdArr = $_POST['service'];


                        foreach ($serivceIdArr as $key => $value) {
                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $purifiedObj->getPurifyText($value);
                            $serviceUserMappingobj->user_id = $id;
                            $serviceUserMappingobj->service_discount = $_POST['service_discount'][$key];
                          $serviceUserMappingobj->corporate_discount = $_POST['corporate_discount'][$key];
                            $serviceUserMappingobj->is_clinic = 1;
                            $serviceUserMappingobj->is_available_allday = $_POST['twentyfour'][$key];
                            $serviceUserMappingobj->clinic_id = $firstClinicid;
                            if (!$serviceUserMappingobj->save()) {
                                throw new Exception("Error in saving data");
                            }
                        }
                    }

                    Yii::app()->db->createCommand()->delete('az_doctor_degree_mapping', 'doctor_id=:id', array(':id' => $id));

                    if (!empty($postArr['degree'])) {
                        $degreeArr = $postArr['degree'];

                        foreach ($degreeArr as $key => $value) {
                            $degreeidArr = Yii::app()->db->createCommand()
                                    ->select('degree_id')
                                    ->from(' az_degree_master')
                                    ->where('degree_name=:id', array(':id' => $value))
                                    ->queryScalar();

                            $degree = new DoctorDegreeMapping;
                            $degree->doctor_id = $id;
                            $degree->degree_id = $degreeidArr;
                            $degree->degree_name = $value;
                            if (!$degree->save()) {
                                throw new Exception("Error in saving data");
                            }
                        }
                    }

                    Yii::app()->db->createCommand()->delete('az_speciality_user_mapping', 'user_id=:id', array(':id' => $id));


                    if (!empty($postArr['speciality'])) {

                        $specialityIdArr = $postArr['speciality'];

                        foreach ($specialityIdArr as $key => $value) {

                            $specialityUserMapping = new SpecialityUserMapping();
                            $specialityid = Yii::app()->db->createCommand()
                                    ->select('speciality_name')
                                    ->from('az_speciality_master')
                                    ->where('speciality_id=:id', array(':id' => $value))
                                    ->queryRow();

                            $specialityUserMapping->speciality_id = $value;
                            $specialityUserMapping->user_id = $id;

                            $specialityUserMapping->speciality_name = $specialityid['speciality_name'];
                            if (!$specialityUserMapping->save()) {

                                throw new Exception("Error in saving data");
                            }
                        }
                    }

                    Yii::app()->db->createCommand()->delete('az_doctor_experience', 'doctor_id=:id', array(':id' => $id));
                    $exp = 0;

                  
                     if (!empty($_POST['DoctorExperience'])) {
                        
                         $docExp = $_POST['DoctorExperience'];
                      
                        $doctorexp = new DoctorExperience;
                        
                        $year = $docExp['work_from'];
                        $month = $docExp['work_to'];
                         
                        $doctorexp->doctor_id = $id;
                        $doctorexp->work_from = $year;
                        $doctorexp->work_to = $month;
                        
                        $exp = 0;
                        if($year == 0){
                            $exp = $month;
                        }else{
                            $year = $year * 12;
                            $exp = $year + $month;
                        }
                        

                        
                        if ($doctorexp->save()) {
                            $model->experience = $exp;
                            }else{
                               // print_r($docexp->getErrors());
                            }
                        
                    }
                    

                    Yii::app()->db->createCommand()->delete('az_clinic_visiting_details', 'clinic_id=:id', array(':id' => $firstClinicid));

                    if (isset($_POST['ClinicDetails']['alldayopen']) && $_POST['ClinicDetails']['alldayopen'] == 'Y') {
                        
                        $model2->alldayopen = 'Y';

                        if ($model2->save()) {
                            
                        }
                    } else {

                        $selecteddays = $_POST['ClinicVisitingDetails'];

                        foreach ($selecteddays['day'] as $key => $value) {
                            $ClinicVisitingDetails = new ClinicVisitingDetails;
                            $ClinicVisitingDetails->clinic_id = $firstClinicid;
                            $ClinicVisitingDetails->doctor_id = $id;
                            $ClinicVisitingDetails->day = $value;
                            $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key]));
                            $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key]));
                            $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key]));
                            $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key]));

                            if (!$ClinicVisitingDetails->save()) {
                                throw new Exception("Error in saving data");
                            }
                        }
                    }

                    //Update Profile_image 
                    $filename = CUploadedFile::getInstance($model, 'profile_image');


                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }

                    $profilepicDir = 'profilepic/';               //profilepic
                    if (!is_dir($baseDir . $profilepicDir)) {
                        mkdir($baseDir . $profilepicDir);
                    }

                    $profilepicDir = $profilepicDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $profilepicDir)) {
                        mkdir($baseDir . $profilepicDir);
                    }

                    $profilepicDir = $profilepicDir . date("M") . "/";
                    if (!is_dir($baseDir . $profilepicDir)) {
                        mkdir($baseDir . $profilepicDir);
                    }


                    if (!empty($_POST['profile'])) {
                        $imageName = time() . "_" . rand(111, 9999) . '.png';
                        $model->profile_image = $profilepicDir . $imageName;

                        if (file_put_contents($baseDir . $profilepicDir . $imageName, $data)) {
                            
                        }
                    }
                    if ($model->save()) {
                        
                    }

                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    $documentDir = 'document/';                                         //documents
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("M") . "/";
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $registDocObj = CUploadedFile::getInstance($model3, "document");


                    if (!empty($registDocObj)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Doctor_Registration'));

                        if (!empty($registDocObj)) {
                            $path_part = pathinfo($registDocObj->name);
                            $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            if ($registDocObj->saveAs($baseDir . $fname)) {
                                $documentDetModel = new DocumentDetails();
                                $documentDetModel->user_id = $id;
                                $documentDetModel->doc_type = "Doctor_Registration";
                                $documentDetModel->document = $fname;
                                $documentDetModel->save(false);
                            }
                        }
                    }


                    $photos = CUploadedFile::getInstancesByName('DocumentDetails[doc_photo]');
                    // proceed if the images have been set
                    if (isset($photos) && count($photos) > 0) {
                        foreach ($photos as $image => $pic) {
                            $docdetails = new DocumentDetails;
                            $path_part = pathinfo($pic->name);
                            $pic_name = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $docdetails->document = $pic_name;
                            $pic->saveAs($baseDir . $docdetails->document);
                            $docdetails->doc_type = 'Gallery_photos';
                            $docdetails->user_id = $id;
                            if ($docdetails->save()) {
                                
                            }
                        }
                    }


                    $otherDocObj = CUploadedFile::getInstance($model3, 'otherdoc');
                    if (!empty($otherDocObj)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Other_Document'));
                        if (!empty($otherDocObj)) {
                            $path_part = pathinfo($otherDocObj->name);
                            $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            if ($otherDocObj->saveAs($baseDir . $fname)) {
                                $documentDetModel = new DocumentDetails();
                                $documentDetModel->user_id = $id;
                                $documentDetModel->doc_type = "Other_Document";
                                $documentDetModel->document = $fname;
                                $documentDetModel->save(false);
                            }
                        }
                    }
                    $clinicDir = 'certificates/';                           //certificates
                    if (!is_dir($baseDir . $clinicDir)) {
                        mkdir($baseDir . $clinicDir);
                    }
                    $clinicDir = $clinicDir . date("Y") . "/";              //year
                    if (!is_dir($baseDir . $clinicDir)) {
                        mkdir($baseDir . $clinicDir);
                    }
                    $clinicDir = $clinicDir . date("M") . "/";                //month
                    if (!is_dir($baseDir . $clinicDir)) {
                        mkdir($baseDir . $clinicDir);
                    }
                    $certificateObj = CUploadedFile::getInstance($model2, 'clinic_reg_certificate');
                    if (!empty($certificateObj)) {
                        // Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Other_Document'));
                        if (!empty($certificateObj)) {
                            $path_part = pathinfo($certificateObj->name);
                            $cname = $clinicDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            if ($certificateObj->saveAs($baseDir . $cname)) {
                                $model2->clinic_reg_certificate = $cname;
                                $model2->save(false);
                            }
                        }
                    }

                    $transaction->commit();
                    Yii::app()->user->setFlash('Success', 'You have successfully Updated Your Profile');
                    $this->redirect(array('site/docViewAppointment'));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                $model->addError(NULL, $ex->getMessage());
            }
        }
        $this->render('UpdateDoctordetails', array(
            'model' => $model, 'model1' => $model1, 'model2' => $model2, 'model3' => $model3, 'serviceUserMapping' => $serviceUserMapping, 'model5' => $model5, 'model6' => $model6, 'model7' => $model7, 'id' => $id, 'tab' => $tab, 'firstClinicid' => $firstClinicid, 'roleid' => $roleid
        ));
    }

    public function actionAdminDoctor() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('search');
        $model->unsetAttributes();                                              // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('adminDoctor', array(
            'model' => $model,
        ));
    }

    public function actionAdminPatient() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('search');
        $model->unsetAttributes();                                              // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('adminPatient', array(
            'model' => $model,
        ));
    }

    public function actionUpdateAdminDoctor($id) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $userid = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = $this->loadModel($userid);       
        $doctorexp = DoctorExperience::model()->findByAttributes(array('doctor_id' => $userid));
        if (empty($doctorexp)) {
            $doctorexp = new DoctorExperience;
        }
        $data = "";
        $oldprofile = $model->profile_image;

        if (isset($_POST['UserDetails'])) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $postArr = Yii::app()->request->getParam('UserDetails');
                $purifiedObj = Yii::app()->purifier;
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);

                $model->blood_group = $purifiedObj->getPurifyText($postArr['blood_group']);
                $model->country_id = 1;
                $model->state_id = $postArr['state_id'];
                $model->city_id = $postArr['city_id'];
                $model->area_id = $postArr['area_id'];
                $model->pincode = $postArr['pincode'];
                $model->apt_contact_no_1 = $postArr['apt_contact_no_1'];
                if (!empty($postArr['apt_contact_no_2']))
                    $model->apt_contact_no_2 = $postArr['apt_contact_no_2'];
                $model->email_1 = $postArr['email_1'];
                if (!empty($postArr['email_2']))
                    $model->email_2 = $postArr['email_2'];
                $model->doctor_registration_no = $postArr['doctor_registration_no'];
                $model->description = $purifiedObj->getPurifyText($postArr['description']);
                $model->country_name = "india";
                $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
                $model->address = $purifiedObj->getPurifyText($postArr['address']);
                if (!empty($postArr['birth_date'])) {
                    $birthDate = $purifiedObj->getPurifyText($postArr['birth_date']);
                    $birthDate = date("Y-m-d", strtotime($birthDate));
                    $model->birth_date = $birthDate;
                    //calculate age in months
                    $date2 = date("Y-m-d");
                    $diff = abs(strtotime($date2) - strtotime($birthDate));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    $age = ($years * 12) + $months;
                    $model->age = $age;
                }
                if (!empty($postArr['gender'])) {
                    $model->gender = $purifiedObj->getPurifyText($postArr['gender']);
                }
                if (isset($postArr['sub_speciality']) && count($postArr['sub_speciality']) > 0) {
                    $sub_spe = implode(',', $postArr['sub_speciality']);
                    $model->sub_speciality = $sub_spe;
                }
                $model->role_id = 3;
                $model->updated_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;
                if (!empty($data)) {
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $profilepicDir = 'profilepic/';               //profilepic
                    if (!is_dir($baseDir . $profilepicDir)) {
                        mkdir($baseDir . $profilepicDir);
                    }

                    $profilepicDir = $profilepicDir . date("Y") . "/";         //year
                    if (!is_dir($baseDir . $profilepicDir)) {
                        mkdir($baseDir . $profilepicDir);
                    }

                    $profilepicDir = $profilepicDir . date("M") . "/";          //Month
                    if (!is_dir($baseDir . $profilepicDir)) {
                        mkdir($baseDir . $profilepicDir);
                    }
                    if (!empty($_POST['profile'])) {
                        $imageName = time() . "_" . rand(111, 9999) . '.png';
                        $model->profile_image = $profilepicDir . $imageName;
                        if (file_put_contents($baseDir . $profilepicDir . $imageName, $data)) {
                            
                        }
                    }
                }
                if ($model->save()) {

                    $user_id = $model->user_id;
                    Yii::app()->db->createCommand()->delete('az_speciality_user_mapping', 'user_id=:id', array(':id' => $user_id));

                    if (isset($postArr['speciality']) && count($postArr['speciality']) > 0) {
                        $serivceIdArr = array();


                        foreach ($postArr['speciality'] as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $specialityUserMapping = new SpecialityUserMapping();
                            $specialityid = Yii::app()->db->createCommand()
                                    ->select('speciality_name')
                                    ->from('az_speciality_master t')
                                    ->where('speciality_id=:id', array(':id' => $value))
                                    ->queryRow();

                            $specialityUserMapping->speciality_id = $value;
                            $specialityUserMapping->user_id = $user_id;

                            $specialityUserMapping->speciality_name = $purifiedObj->getPurifyText($specialityid['speciality_name']);
                            if (!$specialityUserMapping->save()) {
                                throw new Exception("Error in saving speciality");
                            }
                        }
                    }
                    Yii::app()->db->createCommand()->delete('az_doctor_degree_mapping', 'doctor_id=:id', array(':id' => $user_id));

                    if (isset($postArr['degree']) && count($postArr['degree']) > 0) {
                        $serivceIdArr = array();
                        foreach ($postArr['degree'] as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $DoctorDegreeMapping = new DoctorDegreeMapping();
                            $degreeid = Yii::app()->db->createCommand()
                                    ->select('degree_name')
                                    ->from('az_degree_master t')
                                    ->where('degree_id=:id', array(':id' => $value))
                                    ->queryRow();

                            $DoctorDegreeMapping->degree_id = $value;
                            $DoctorDegreeMapping->doctor_id = $userid;

                            $DoctorDegreeMapping->degree_name = $purifiedObj->getPurifyText($degreeid['degree_name']);
                            if (!$DoctorDegreeMapping->save()) {
                                throw new Exception("Error in saving  degree");
                            }
                        }
                    }
                    if (!empty($_POST['DoctorExperience'])) {
                        
                        $docExpPostArr = $_POST['DoctorExperience'];
                        
                        $year = $docExpPostArr['work_from'];
                        $month = $docExpPostArr['work_to'];
                        $doctorexp->doctor_id = $user_id;
                        $doctorexp->work_from = $year;
                        $doctorexp->work_to = $month;
                        $exp = 0;
                        if($year == 0){
                            $exp = $month;
                        }else{
                            $year = $year * 12;
                            $exp = $year + $month;
                        }
                        if ($doctorexp->save()) {
                            $model->experience = $exp;
                            $model->save();
                        }else{
                            print_r($docexp->getErrors());
                        }
                        
                    }
		
                    $transaction->commit();
                    $this->redirect(array('viewDoctor', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)));
                }

                
            } catch (Exception $ex) {
                $transaction->rollback();
                $model->addError(NULL, $ex->getMessage());
            }
        }
        $this->render('update_admin_doctor', array(
            'model' => $model,'userid' => $userid,'doctorexp' => $doctorexp
        ));
    }

    public function actionUpdateAdminPatient($id) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $userid = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = $this->loadModel($userid);

        if (isset($_POST['UserDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $postArr = Yii::app()->request->getParam('UserDetails');

                $purifiedObj = Yii::app()->purifier;
                $model->vip_role = '';
                $model->company_name = '';
                $model->patient_type = $purifiedObj->getPurifyText($postArr['patient_type']);
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
                $model->gender = $purifiedObj->getPurifyText($postArr['gender']);
                if ($model->patient_type == 'Premium member') {
                    $model->vip_role = $purifiedObj->getPurifyText($postArr['vip_role']);
                }
                if ($model->patient_type == 'Corporate') {
                    
                   // $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                }
                if (!empty($postArr['birth_date']))
                    $model->birth_date = date("Y-m-d", strtotime($postArr['birth_date']));
                $model->age = $postArr['age'];
                $model->blood_group = $postArr['blood_group'];

                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password']))
                    $model->password = md5($postArr['password']);
                $model->apt_contact_no_1 = $purifiedObj->getPurifyText($postArr['apt_contact_no_1']);
                $model->apt_contact_no_2 = $purifiedObj->getPurifyText($postArr['apt_contact_no_2']);
                $model->email_1 = $purifiedObj->getPurifyText($postArr['email_1']);
                $model->email_2 = $purifiedObj->getPurifyText($postArr['email_2']);
                $model->country_name = "India";
                $model->country_id = 1;
                $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
                $model->state_id = $purifiedObj->getPurifyText($postArr['state_id']);
                $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
                $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->area_id = $purifiedObj->getPurifyText($postArr['area_id']);
                $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
                $model->address = $purifiedObj->getPurifyText($postArr['address']);

                $model->updated_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;
                if ($model->save()) {
                    $transaction->commit();
                    if ($model->patient_type == 'Corporate') {
                        $this->redirect(array('userDetails/CorporateList'));
                    }
                    $this->redirect(array('userDetails/viewPatient','id'=>Yii::app()->getSecurityManager()->encrypt($userid, $enc_key)));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                $model->addError(NULL, $ex->getMessage());
            }
        }
        $this->render('update_admin_patient', array(
            'model' => $model
        ));
    }

    public function actionActiveStatus() {
        $update = Yii::app()->db->createCommand()->update('az_user_details', array('is_active' => $_POST['is_active']), 'user_id = :userid', array(":userid" => $_POST['user_id']));
        if ($update)
            echo 1;
    }

    public function loadModel($id) {
        $model = UserDetails::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /*
     * Set User - Hospital Entered Data
     * @param => all hospital related info
     * @author => Suchit Dalvi
     */

    public function actionSetUserData() {
        if (isset($_POST['UserDetails'])) {
            $session = new CHttpSession;
            $session->open();
            $postArr = Yii::app()->request->getParam('UserDetails');

            $session['hospital_name'] = $postArr['hospital_name'];
            $session['type_of_hospital'] = $postArr['type_of_hospital'];
            $session['hospital_registration_no'] = $postArr['hospital_registration_no'];
            if (isset($postArr['payment_type'])) {
                $session['payment_type'] = $postArr['payment_type'];
            }
            $session['hos_establishment'] = $postArr['hos_establishment'];
            //   $session['hos_validity'] = $postArr['hos_validity'];
            if (isset($postArr['type_of_establishment'])) {
                $session['type_of_establishment'] = $postArr['type_of_establishment'];
            }
            if (isset($postArr['speciality']))
                $session['speciality'] = $postArr['speciality'];
            //$session['services'] = $postArr['services'];
            if (isset($postArr['total_no_of_bed']))
                $session['total_no_of_bed'] = $postArr['total_no_of_bed'];
            if (isset($postArr['latitude']))
                $session['latitude'] = $postArr['latitude'];
            if (isset($postArr['longitude']))
                $session['longitude'] = $postArr['longitude'];
            $session['mobile'] = $postArr['mobile'];
            $session['password'] = $postArr['password'];
            $session['landline_1'] = $postArr['landline_1'];
            $session['email_1'] = $postArr['email_1'];
            $session['emergency_no_1'] = $postArr['emergency_no_1'];
            $session['ambulance_no_1'] = $postArr['ambulance_no_1'];
            $session['tollfree_no_1'] = $postArr['tollfree_no_1'];

            $session['coordinator_name_1'] = $postArr['coordinator_name_1'];
            $session['coordinator_mobile_1'] = $postArr['coordinator_mobile_1'];
            $session['coordinator_name_2'] = $postArr['coordinator_name_2'];
            $session['coordinator_mobile_2'] = $postArr['coordinator_mobile_2'];
            $session['coordinator_email_1'] = $postArr['coordinator_email_1'];
            $session['coordinator_email_2'] = $postArr['coordinator_email_2'];
            if (isset($postArr['is_open_allday']))
                $session['is_open_allday'] = $postArr['is_open_allday'];
            $session['hospital_open_time'] = $postArr['hospital_open_time'];
            $session['hospital_close_time'] = $postArr['hospital_close_time'];
            $session['other_est_type'] = $postArr['other_est_type'];
            $session['pincode'] = $postArr['pincode'];
            $session['state_id'] = $postArr['state_id'];
            $session['state_name'] = $postArr['state_name'];
            $session['city_id'] = $postArr['city_id'];
            $session['city_name'] = $postArr['city_name'];
            $session['area_id'] = $postArr['area_id'];
            $session['area_name'] = $postArr['area_name'];
            $session['landmark'] = $postArr['landmark'];
            $session['address'] = $postArr['address'];
            $session['description'] = $postArr['description'];
            if (isset($postArr['amenities']))
                $session['amenities'] = $postArr['amenities'];
            if (isset($postArr['userservice']))
                $session['userservice'] = $postArr['userservice'];
            if (isset($postArr['discount']))
                $session['discount'] = $postArr['discount'];
            if (isset($postArr['corporate_discount']))
                $session['corporate_discount'] = $postArr['corporate_discount'];
           
            $session['twentyfour'] = $postArr['twentyfour'];
            //$session['tempdata']['type_of_establishment'] = $postArr['type_of_establishment'];

            echo true;
        }
    }

    public function actionGetSpecialityName() {

        $request = Yii::app()->request;
        $speciality = $request->getParam('specialityid');

        $cmd = Yii::app()->db->createCommand()
                ->select('speciality_name,speciality_id,img_name')
                ->from('az_speciality_master')
                ->where('speciality_id=:id', array(':id' => $speciality))
                ->queryRow();

        $returnArr['speciality_name'] = $cmd;
        echo json_encode(array('data' => $cmd));
    }

    public function actionManageHospital() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('searchHospial');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageHospital', array(
            'model' => $model,
        ));
    }

    public function actionManageHospitalDoctor($param1) {
        $this->layout = 'adminLayout';
        $hospId = base64_decode($param1);
        $model = new UserDetails('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageHospitalDoctor', array(
            'model' => $model, 'hospId' => $hospId
        ));
    }

    public function actionCreateHospDoc($param1) {
        $this->layout = 'adminLayout';
        $param1 = base64_decode($param1);
        $model = new UserDetails;
        $model2 = new ClinicDetails;
        $model6 = new ClinicVisitingDetails;
        $data = "";
        if (isset($_POST['UserDetails'])) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                $model->attributes = $_POST['UserDetails'];
                $postArr = $request->getPost("UserDetails");

                $model->is_active = 1;
                $model->created_date = date('Y-m-d H:i:s');
                $model->updated_date = date('Y-m-d H:i:s');
                $model->country_id = 1;
                $model->role_id = 3;
                $model->parent_hosp_id = $param1;
                $model->doctor_registration_no = $purifiedObj->getPurifyText($postArr['doctor_registration_no']);
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                $model->password = $purifiedObj->getPurifyText($postArr['password']);
                $model->blood_group = $purifiedObj->getPurifyText($postArr['blood_group']);
                $model->apt_contact_no_1 = $postArr['apt_contact_no_1'];
               // $model->experience = $postArr['experience'];
                $model->email_1 = $postArr['email_1'];
                $model->doctor_fees = $postArr['doctor_fees'];
                $model->opd_no = $postArr['opd_no'];
                $model->free_opd_perday = $postArr['free_opd_perday'];

                $Daystr = NULL;
                if ((!empty($postArr['free_opd_preferdays']))) {
                    foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                        $Daystr .= $value . ",";
                    }

                    $model->free_opd_preferdays = $Daystr;
                }
//                else{
//                     $model->free_opd_preferdays = $Daystr;
//                }
                //locations
                $locResultArr = Yii::app()->db->createCommand()->select('country_id,state_id,city_id,area_id,country_name,state_name,city_name,area_name')->from('az_user_details')
                                ->where('user_id=:id', array(':id' => $param1))->queryRow();
                $model->country_id = $locResultArr['country_id'];
                $model->state_id = $locResultArr['state_id'];
                $model->city_id = $locResultArr['city_id'];
                $model->area_id = $locResultArr['area_id'];
                $model->country_name = $locResultArr['country_name'];
                $model->state_name = $locResultArr['state_name'];
                $model->city_name = $locResultArr['city_name'];
                $model->area_name = $locResultArr['area_name'];


                if (!empty($postArr['birth_date'])) {
                    $birthDate = $purifiedObj->getPurifyText($postArr['birth_date']);
                    $birthDate = date("Y-m-d", strtotime($birthDate));
                    $model->birth_date = $birthDate;
                    //calculate age in months
                    $date2 = date("Y-m-d");
                    $diff = abs(strtotime($date2) - strtotime($birthDate));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    $age = ($years * 12) + $months;
                    $model->age = $age;
                }
                if (!empty($postArr['gender'])) {
                    $model->gender = $purifiedObj->getPurifyText($postArr['gender']);
                }
                if (!empty($model->password)) {
                    $model->password = md5($model->password);
                }

                if (isset($postArr['sub_speciality']) && count($postArr['sub_speciality']) > 0) {
                    $sub_spe = implode(',', $postArr['sub_speciality']);
                    $model->sub_speciality = $sub_spe;
                }

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

                if (!empty($_POST['profile'])) {
                    $imageName = time() . "_" . rand(111, 9999) . '.png';
                    $model->profile_image = $profileDir . $imageName;

                    if (file_put_contents($baseDir . $profileDir . $imageName, $data)) {
                        
                    }
                }
                if ($model->save()) {
                    $user_id = $model->user_id;

                    if (isset($postArr['speciality']) && count($postArr['speciality']) > 0) {

                        foreach ($postArr['speciality'] as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $SpecialityUserMappingobj = new SpecialityUserMapping();
                            $specialityid = Yii::app()->db->createCommand()
                                    ->select('speciality_name')
                                    ->from('az_speciality_master t')
                                    ->where('speciality_id=:name', array(':name' => $value))
                                    ->queryRow();

                            $SpecialityUserMappingobj->speciality_id = $value;
                            $SpecialityUserMappingobj->user_id = $user_id;
                            $SpecialityUserMappingobj->speciality_name = $specialityid['speciality_name'];

                            if (!$SpecialityUserMappingobj->save()) {
                                throw new Exception("Error in saving speciality data");
                            }
                        }
                    }

                    if (isset($postArr['degree']) && !empty($postArr['degree'])) {


                        foreach ($postArr['degree'] as $key => $value) {
                            $DoctorDegreeMappingobj = new DoctorDegreeMapping();
                            $degreeid = Yii::app()->db->createCommand()
                                    ->select('degree_name')
                                    ->from('az_degree_master t')
                                    ->where('degree_id=:name', array(':name' => $value))
                                    ->queryRow();

                            $DoctorDegreeMappingobj->degree_id = $value;
                            $DoctorDegreeMappingobj->doctor_id = $user_id;

                            $DoctorDegreeMappingobj->degree_name = $degreeid['degree_name'];

                            if (!$DoctorDegreeMappingobj->save()) {
                                throw new Exception("Error in saving degree data");
                            }
                        }
                    }

                    if (isset($_POST['ClinicDetails']['alldayopen']) && $_POST['ClinicDetails']['alldayopen'] == 'Y') {

                        $model2->alldayopen = 'Y';

                        if ($model2->save()) {
                            
                        }
                    } else {


                        $selecteddays = $_POST['ClinicVisitingDetails'];
                        //  print_r($selecteddays);exit;
                        if (isset($selecteddays['day'])) {
                            foreach ($selecteddays['day'] as $key => $value) {
                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = 0;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;
                                $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key]));
                                $ClinicVisitingDetails->role_type = 'doctor';
                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving data");
                                }
                                $model2->alldayopen = 'N';
                                if ($model2->save()) {
                                    
                                }
                            }
                        }
                    }
                     Yii::app()->db->createCommand()->delete('az_doctor_experience', 'doctor_id=:id', array(':id' => $user_id));
                    $exp = 0;

                     if (!empty($_POST['DoctorExperience'])) {
                        
                         $docExp = $_POST['DoctorExperience'];
                      
                        $doctorexp = new DoctorExperience;
                        
                        $year = $docExp['work_from'];
                        $month = $docExp['work_to'];
                         
                        $doctorexp->doctor_id = $user_id;
                        $doctorexp->work_from = $year;
                        $doctorexp->work_to = $month;
                        
                        $exp = 0;
                        if($year == 0){
                            $exp = $month;
                        }else{
                            $year = $year * 12;
                            $exp = $year + $month;
                        }
                        

                        
                        if ($doctorexp->save()) {
                            $model->experience = $exp;
                            $model->save();
                            }else{
                                print_r($docexp->getErrors());
                            }
                        
                    }

                    $transaction->commit();
                    $this->redirect(array('userDetails/manageHospitalDoctor', 'param1' => base64_encode($param1)));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('createHospDoc', array(
            'model' => $model, 'param1' => $param1, 'model6' => $model6
        ));
    }

    public function actionPatientAppointments() {

        //$model = new PatientAppointmentDetails;
        $session = new CHttpSession;
        $session->open();
        $id = $session["user_id"];
        $roleid = $session["user_role_id"];
        $PatientInfoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_user_details ")
                ->where(" role_id = $roleid And user_id=$id ")
                ->queryRow();

        $patientAppoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_patient_appointment_details ")
                
                ->where("patient_id= " . $PatientInfoArr['user_id'])
                ->queryRow();



        $whereClause = "t.patient_id=:id";
        $paramArr = array(':id' => $id);
        $DocArrProvider = new CActiveDataProvider('PatientAppointmentDetails', array('criteria' => array(
                'select' => "u.first_name,last_name,doctor_fees,appointment_date,time,mobile,description,is_clinic,hospital_id,appointment_date,time,appointment_id,
            (SELECT group_concat(speciality_name) FROM az_speciality_user_mapping where user_id=u.user_id) AS speciality ",
                'condition' => $whereClause,
                'params' => $paramArr,
                'join' => 'LEFT JOIN az_user_details  u ON u.user_id=t.doctor_id'
            ),
            'pagination' => array('pageSize' => 5))
        );
        
       

        $bankDetails = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_bank_details ")
                ->where("user_id= " . $id)
                ->queryRow();


        $this->render('patientappointments', array(
            'id' => $id, 'PatientInfoArr' => $PatientInfoArr, 'patientAppoArr' => $patientAppoArr, 'DocArrProvider' => $DocArrProvider, 'bankDetails' => $bankDetails, 'roleid' => $roleid
        ));
    }

    public function actionClinicDetails($id) {
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);

        $model = new UserDetails;
        $model2 = new ClinicDetails;
        $model4 = new ServiceUserMapping;
        $model6 = new ClinicVisitingDetails;
        $request = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;


        if (isset($_POST['ClinicDetails'])) {
            $model2->attributes = $_POST['ClinicDetails'];
            $postArr = $request->getPost("ClinicDetails");
            $model2->doctor_id = $id;

            $model2->clinic_name = $purifiedObj->getPurifyText($postArr['clinic_name']);
            // $model2->register_no = $purifiedObj->getPurifyText($postArr['register_no']);
            $model2->opd_consultation_fee = $purifiedObj->getPurifyText($postArr['opd_consultation_fee']);
            $model2->opd_consultation_discount = $purifiedObj->getPurifyText($postArr['opd_consultation_discount']);
            $model2->free_opd_perday = $purifiedObj->getPurifyText($postArr['free_opd_perday']);
            $model2->country_id = 1;
            $model2->state_id = $purifiedObj->getPurifyText($postArr['state_id']);
            $model2->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
            $model2->area_id = $purifiedObj->getPurifyText($postArr['area_id']);
            $model2->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
            $model2->country_name = 'India';
            $model2->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
            $model2->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
            $model2->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
            $model2->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
            $model2->address = $purifiedObj->getPurifyText($postArr['address']);
            $model2->latitude = $purifiedObj->getPurifyText($postArr['latitude']);
            $model2->longitude = $purifiedObj->getPurifyText($postArr['longitude']);
            $paymentstr = NULL;
            if ((!empty($postArr['payment_type']))) {

                foreach ($postArr['payment_type'] as $key => $value) {
                    $paymentstr .= $value . ",";
                }

                $model2->payment_type = $paymentstr;
            }
            $Daystr = NULL;
            if ((!empty($postArr['free_opd_preferdays']))) {
                foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                    $Daystr .= $value . ",";
                }

                $model2->free_opd_preferdays = $Daystr;
            }
            if ($model2->save()) {
                $clinicid = $model2->clinic_id;
                $sermap = $_POST['ServiceUserMapping'];

                foreach ($sermap['service_id'] as $key => $value) {
                    $serviceUserMappingModel = new ServiceUserMapping();
                    $serviceUserMappingModel->user_id = $id;
                    $serviceUserMappingModel->service_id = $value;
                    $serviceUserMappingModel->service_discount = $sermap['service_discount'][$key];
                    $serviceUserMappingModel->corporate_discount = $sermap['corporate_discount'][$key];
                    $serviceUserMappingModel->is_clinic = 1;
                    $serviceUserMappingModel->is_available_allday = $sermap['twentyfour'][$key];
                    $serviceUserMappingModel->clinic_id = $clinicid;
                    if (!$serviceUserMappingModel->save()) {
                        throw new Exception("Error in saving data");
                    }
                }

                if (isset($_POST['ClinicDetails']['alldayopen']) && $_POST['ClinicDetails']['alldayopen'] == 'Y') {
                   
                    $model2->alldayopen = 'Y';

                    if ($model2->save()) {
                        
                    }
                } else {

                    $selecteddays = $_POST['ClinicVisitingDetails'];
                    foreach ($selecteddays['day'] as $key => $value) {
                        $ClinicVisitingDetails = new ClinicVisitingDetails;
                        $ClinicVisitingDetails->clinic_id = $clinicid;
                        $ClinicVisitingDetails->doctor_id = $id;
                        $ClinicVisitingDetails->day = $value;
                        $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key]));
                        $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key]));
                        $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key]));
                        $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key]));
                        if (!$ClinicVisitingDetails->save()) {
                            throw new Exception("Error in saving data");
                        }
                        $model2->alldayopen = 'N';
                        if ($model2->save()) {
                            
                        }
                    }
                }


                $this->redirect(array('UpdateDoctordetails', 'id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key), 'tab' => 'tab_b'));
            }
        }
        $this->render('clinicDetails', array(
            'model' => $model, 'model2' => $model2, 'model4' => $model4, 'model6' => $model6
        ));
    }

    public function actionUpdateClinicDetails($c_id, $u_id) {
        
        $enc_key = Yii::app()->params->enc_key;
        $u_id = Yii::app()->getSecurityManager()->decrypt($u_id, $enc_key);
        $c_id = Yii::app()->getSecurityManager()->decrypt($c_id, $enc_key);

        $model = UserDetails::model()->findByAttributes(array('user_id' => $u_id));  //Userdetails
        //$model1 =  DoctorExperience::model()->findByAttributes(array('doctor_id'=>$id));  //DoctorExperience
        $model2 = ClinicDetails::model()->findByAttributes(array('clinic_id' => $c_id)); //ClinicDetails
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('clinic_id' => $c_id));
        $model6 = ClinicVisitingDetails::model()->findByAttributes(array('clinic_id' => $c_id));
        if (empty($model6)) {
            $model6 = new ClinicVisitingDetails;
        }



        $request = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;


        if (isset($_POST['ClinicDetails'])) {
            $model2->attributes = $_POST['ClinicDetails'];
            $postArr = $request->getPost("ClinicDetails");
            $model2->doctor_id = $u_id;

            $model2->clinic_name = $purifiedObj->getPurifyText($postArr['clinic_name']);
            // $model2->register_no = $purifiedObj->getPurifyText($postArr['register_no']);
            $model2->opd_consultation_fee = $purifiedObj->getPurifyText($postArr['opd_consultation_fee']);
            $model2->opd_consultation_discount = $purifiedObj->getPurifyText($postArr['opd_consultation_discount']);
            $model2->free_opd_perday = $purifiedObj->getPurifyText($postArr['free_opd_perday']);
            // $model2->free_opd_preferdays = $purifiedObj->getPurifyText($postArr['free_opd_preferdays']);
            $paymentstr = NULL;
            if ((!empty($postArr['payment_type']))) {

                foreach ($postArr['payment_type'] as $key => $value) {
                    $paymentstr .= $value . ",";
                }

                $model2->payment_type = $paymentstr;
            }
            $Daystr = NULL;
            if ((!empty($postArr['free_opd_preferdays']))) {
                foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                    $Daystr .= $value . ",";
                }

                $model2->free_opd_preferdays = $Daystr;
            }
            if ($model2->save()) {
                $clinicid = $model2->clinic_id;
                Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'clinic_id=:id', array(':id' => $c_id));
                $sermap = $_POST['service'];

                foreach ($sermap as $key => $value) {
                    $serviceUserMappingModel = new ServiceUserMapping();
                    $serviceUserMappingModel->user_id = $u_id;
                    $serviceUserMappingModel->service_id = $value;
                    $serviceUserMappingModel->service_discount = $_POST['service_discount'][$key];
                    $serviceUserMappingModel->corporate_discount = $_POST['corporate_discount'][$key];
                    $serviceUserMappingModel->is_clinic = 1;
                    $serviceUserMappingModel->is_available_allday = $_POST['twentyfour'][$key];
                    $serviceUserMappingModel->clinic_id = $c_id;
                    if (!$serviceUserMappingModel->save()) {
                        throw new Exception("Error in saving data");
                    }
                }

                Yii::app()->db->createCommand()->delete('az_clinic_visiting_details', 'clinic_id=:id', array(':id' => $c_id));

                if (isset($postArr['alldayopen']) && $postArr['alldayopen'] == 'Y') {
                    $model2->alldayopen = 'Y';
                    if ($model2->save()) {
                        
                    }
                } else {
                    $selecteddays = $_POST['ClinicVisitingDetails'];

                    foreach ($selecteddays['day'] as $key => $value) {
                        $ClinicVisitingDetails = new ClinicVisitingDetails;
                        $ClinicVisitingDetails->clinic_id = $c_id;
                        $ClinicVisitingDetails->doctor_id = $u_id;
                        $ClinicVisitingDetails->day = $value;
                        $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key]));
                        $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key]));
                        $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key]));
                        $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key]));

                        if (!$ClinicVisitingDetails->save()) {
                            throw new Exception("Error in saving data");
                        }
                        $model2->alldayopen = 'N';
                        if ($model2->save()) {
                            
                        }
                    }
                }
                $baseDir = Yii::app()->basePath . "/../uploads/";
                $clinicDir = 'certificates/';                           //certificates
                if (!is_dir($baseDir . $clinicDir)) {
                    mkdir($baseDir . $clinicDir);
                }
                $clinicDir = $clinicDir . date("Y") . "/";              //year
                if (!is_dir($baseDir . $clinicDir)) {
                    mkdir($baseDir . $clinicDir);
                }
                $clinicDir = $clinicDir . date("M") . "/";                //month
                if (!is_dir($baseDir . $clinicDir)) {
                    mkdir($baseDir . $clinicDir);
                }
                $certificateObj = CUploadedFile::getInstance($model2, 'clinic_reg_certificate');
                if (!empty($certificateObj)) {

                    if (!empty($certificateObj)) {
                        $path_part = pathinfo($certificateObj->name);
                        $cname = $clinicDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        if ($certificateObj->saveAs($baseDir . $cname)) {
                            $model2->clinic_reg_certificate = $cname;
                            $model2->save(false);
                        }
                    }
                }



                $this->redirect(array('UpdateDoctordetails', 'id' => Yii::app()->getSecurityManager()->encrypt($u_id, $enc_key), 'tab' => 'tab_b'));
            }
        }



        $this->render('updateClinicDetails', array(
            'model' => $model, 'model2' => $model2, 'serviceUserMapping' => $serviceUserMapping, 'model6' => $model6, 'c_id' => $c_id, 'u_id' => $u_id
        ));
    }

    public function actionPatientDetails() {
        $id = Yii::app()->user->id;
        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));
        $model7 = BankDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model7)) {
            $model7 = new BankDetails();
        }

        if (isset($_POST['UserDetails']) && count($_POST['UserDetails']) > 0) {

            $data = "";
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }

            $postArr = Yii::app()->request->getParam('UserDetails');
            $purifiedObj = Yii::app()->purifier;
            $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
            $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
            $model->gender = $purifiedObj->getPurifyText($postArr['gender']);
            $birthDate = date("Y-m-d", strtotime($postArr['birth_date']));
            $model->age = $postArr['age'];
            $model->birth_date = $birthDate;
            $model->blood_group = $postArr['blood_group'];
            $model->bld_donor_consent = $postArr['bld_donor_consent'];
            $model->apt_contact_no_1 = $purifiedObj->getPurifyText($postArr['apt_contact_no_1']);
            $model->apt_contact_no_2 = $purifiedObj->getPurifyText($postArr['apt_contact_no_2']);
            $model->email_1 = $purifiedObj->getPurifyText($postArr['email_1']);
            $model->email_2 = $purifiedObj->getPurifyText($postArr['email_2']);
            $model->country_id = 1;
            $model->country_name = 'India';
            $model->state_id = $purifiedObj->getPurifyText($postArr['state_id']);
            $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
            $model->area_id = $purifiedObj->getPurifyText($postArr['area_id']);
            $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
            $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
            $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
            $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
            $model->address = $purifiedObj->getPurifyText($postArr['address']);
            $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);

            $model->updated_date = date("Y-m-d H:i:s");
            $model->updated_by = Yii::app()->user->id;

            if ($model->save()) {

                if (isset($_POST['BankDetails'])) {
                    $bankdetailsArr = $_POST['BankDetails'];

                    $model7->user_id = $id;
                    $model7->acc_holder_name = $bankdetailsArr['acc_holder_name'];
                    $model7->bank_name = $bankdetailsArr['bank_name'];
                    $model7->branch_name = $bankdetailsArr['branch_name'];
                    $model7->account_no = $bankdetailsArr['account_no'];
                    $model7->account_type = $bankdetailsArr['account_type'];
                    $model7->ifsc_code = $bankdetailsArr['ifsc_code'];

                    if ($model7->save()) {
                        
                    }
                }


                $baseDir = Yii::app()->basePath . "/../uploads/";
                if (!is_dir($baseDir)) {
                    mkdir($baseDir);
                }
                $profileDir = 'profilepic/';               //profilepic
                if (!is_dir($baseDir . $profileDir)) {
                    mkdir($baseDir . $profileDir);
                }
                $profileDir = $profileDir . date("Y") . "/";                      //year
                if (!is_dir($baseDir . $profileDir)) {
                    mkdir($baseDir . $profileDir);
                }
                $profileDir = $profileDir . date("M") . "/";                    //month
                if (!is_dir($baseDir . $profileDir)) {
                    mkdir($baseDir . $profileDir);
                }

                if (!empty($_POST['profile'])) {
                    $imageName = time() . "_" . rand(111, 9999) . '.png';
                    $model->profile_image = $profileDir . $imageName;

                    if (file_put_contents($baseDir . $profileDir . $imageName, $data)) {
                        
                    }
                }
                if ($model->save()) {
                    Yii::app()->user->setFlash('Success', 'You have successfully Edit Profile.');
                    $this->redirect(array("patientAppointments"));
                }
            }
        }
        $this->render('patientDetails', array(
            'model' => $model, 'model7' => $model7));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////



    public function actionUpdateHospitalDoctor($id) {
        $this->layout = 'adminLayout';

        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $param1 = $id;
        $data = "";
        $specialityUserMapping = SpecialityUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        if (empty($specialityUserMapping)) {
            $specialityUserMapping = new SpecialityUserMapping;
        }

        $doctorDegreeMapping = DoctorDegreeMapping::model()->findAllByAttributes(array('doctor_id' => $id));

        $model = $this->loadModel($id);
        $model2 = ClinicDetails::model()->findByAttributes(array('doctor_id' => $id)); //ClinicDetails
        if (empty($model2)) {
            $model2 = new ClinicDetails;
        }
        //  $model6 = ClinicVisitingDetails::model()->findAllByAttributes(array('doctor_id' => $id));                        //ClinicVisitingDetails

        if (empty($model6)) {
            $model6 = new ClinicVisitingDetails;
        }

        $oldprofile = $model->profile_image;
        if (isset($_POST['UserDetails'])) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                $postArr = Yii::app()->request->getParam('UserDetails');

                $profile = CUploadedFile::getInstance($model, 'profile_image');
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
                $model->blood_group = $purifiedObj->getPurifyText($postArr['blood_group']);
                $model->apt_contact_no_1 = $postArr['apt_contact_no_1'];
              //  $model->experience = $postArr['experience'];
                $model->email_1 = $postArr['email_1'];
                $model->doctor_fees = $postArr['doctor_fees'];
                $model->opd_no = $postArr['opd_no'];
                $model->doctor_registration_no = $postArr['doctor_registration_no'];
                $model->free_opd_perday = $postArr['free_opd_perday'];
                $model->apt_contact_no_1 = $postArr['apt_contact_no_1'];
              //  print_r($postArr['sub_speciality']);
                $sub_spe = '';
                 if (isset($postArr['sub_speciality']) && count($postArr['sub_speciality']) > 0) {
                     foreach($postArr['sub_speciality'] as $key => $val){
                    $sub_spe .=$val.',';
                    
                    }
                 $model->sub_speciality = $sub_spe;
                 }

                $Daystr = NULL;
                if ((!empty($postArr['free_opd_preferdays']))) {
                    foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                        $Daystr .= $value . ",";
                    }

                    $model->free_opd_preferdays = $Daystr;
                }

                if (!empty($postArr['birth_date'])) {
                    $birthDate = $purifiedObj->getPurifyText($postArr['birth_date']);
                    $birthDate = date("Y-m-d", strtotime($birthDate));
                    $model->birth_date = $birthDate;
                    //calculate age in months
                    $date2 = date("Y-m-d");
                    $diff = abs(strtotime($date2) - strtotime($birthDate));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    $age = ($years * 12) + $months;
                    $model->age = $age;
                }
                if (!empty($postArr['gender'])) {
                    $model->gender = $purifiedObj->getPurifyText($postArr['gender']);
                }


                 if (!empty($postArr['password'])) {
                    $model->password = md5($postArr['password']);
                }
                $baseDir = Yii::app()->basePath . "/../uploads/";
                if (!is_dir($baseDir)) {
                    mkdir($baseDir);
                }

                $profilepicDir = 'profilepic/';               //profilepic
                if (!is_dir($baseDir . $profilepicDir)) {
                    mkdir($baseDir . $profilepicDir);
                }

                $profilepicDir = $profilepicDir . date("Y") . "/";         //year
                if (!is_dir($baseDir . $profilepicDir)) {
                    mkdir($baseDir . $profilepicDir);
                }

                $profilepicDir = $profilepicDir . date("M") . "/";          //Month
                if (!is_dir($baseDir . $profilepicDir)) {
                    mkdir($baseDir . $profilepicDir);
                }


                if (!empty($_POST['profile'])) {
                    $imageName = time() . "_" . rand(111, 9999) . '.png';
                    $model->profile_image = $profilepicDir . $imageName;

                    if (file_put_contents($baseDir . $profilepicDir . $imageName, $data)) {
                        
                    }
                }
                if ($model->save()) {

                    $user_id = $model->user_id;
                    Yii::app()->db->createCommand()->delete('az_speciality_user_mapping', 'user_id=:id', array(':id' => $user_id));

                    if (isset($postArr['speciality']) && count($postArr['speciality']) > 0) {
                        $serivceIdArr = array();


                        foreach ($postArr['speciality'] as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $specialityUserMapping = new SpecialityUserMapping();
                            $specialityid = Yii::app()->db->createCommand()
                                    ->select('speciality_name')
                                    ->from('az_speciality_master t')
                                    ->where('speciality_id=:id', array(':id' => $value))
                                    ->queryRow();

                            $specialityUserMapping->speciality_id = $value;
                            $specialityUserMapping->user_id = $user_id;

                            $specialityUserMapping->speciality_name = $purifiedObj->getPurifyText($specialityid['speciality_name']);
                            if (!$specialityUserMapping->save()) {
                                throw new Exception("Error in saving speciality");
                            }
                        }
                    }
                    Yii::app()->db->createCommand()->delete('az_doctor_degree_mapping', 'doctor_id=:id', array(':id' => $user_id));

                    if (isset($postArr['degree']) && count($postArr['degree']) > 0) {
                        $serivceIdArr = array();


                        foreach ($postArr['degree'] as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $DoctorDegreeMapping = new DoctorDegreeMapping();
                            $degreeid = Yii::app()->db->createCommand()
                                    ->select('degree_name')
                                    ->from('az_degree_master t')
                                    ->where('degree_id=:id', array(':id' => $value))
                                    ->queryRow();

                            $DoctorDegreeMapping->degree_id = $value;
                            $DoctorDegreeMapping->doctor_id = $user_id;

                            $DoctorDegreeMapping->degree_name = $purifiedObj->getPurifyText($degreeid['degree_name']);
                            if (!$DoctorDegreeMapping->save()) {
                                throw new Exception("Error in saving  degree");
                            }
                        }
                    }

                    Yii::app()->db->createCommand()->delete('az_clinic_visiting_details', 'doctor_id=:id and clinic_id = 0', array(':id' => $user_id));

                    if (isset($_POST['UserDetails']['is_open_allday']) && $_POST['UserDetails']['is_open_allday'] == 'Y') {
                        $model->is_open_allday = 'Y';
                        $model->save();
                    } else {
                 
                        if (isset($_POST['ClinicVisitingDetails']) && count($_POST['ClinicVisitingDetails']) > 0) {
                            $selecteddays = $_POST['ClinicVisitingDetails'];
                            if (isset($selecteddays['day'])) {
                            foreach ($selecteddays['day'] as $key => $value) {
                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = 0;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;
                                $ClinicVisitingDetails->clinic_open_time = (!empty($selecteddays['clinic_open_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_close_time = (!empty($selecteddays['clinic_close_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_eve_open_time =(!empty($selecteddays['clinic_eve_open_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_eve_close_time = (!empty($selecteddays['clinic_eve_close_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key])) : NULL;
                                $ClinicVisitingDetails->role_type = "doctor";
                                if ($ClinicVisitingDetails->save()) {
                                   
                                }
                            }
                            }
                        }
                    }
                    
//                    if (isset($_POST['DoctorExperience']['work_from'])){
//                         $exp = new DoctorExperience;
//                                    $exp->doctor_id = $user_id;
//                                    $exp->work_from = $_POST['DoctorExperience']['work_from'];
//                                    $exp->work_to = $_POST['DoctorExperience']['work_to'];
//                                    
//                                    if($exp ->save()){}
//                    }
                    
                    Yii::app()->db->createCommand()->delete('az_doctor_experience', 'doctor_id=:id', array(':id' => $user_id));
                    $exp = 0;

                  
                     if (!empty($_POST['DoctorExperience'])) {
                        
                         $docExp = $_POST['DoctorExperience'];
                      
                        $doctorexp = new DoctorExperience;
                        
                        $year = $docExp['work_from'];
                        $month = $docExp['work_to'];
                         
                        $doctorexp->doctor_id = $user_id;
                        $doctorexp->work_from = $year;
                        $doctorexp->work_to = $month;
                        
                        $exp = 0;
                        if($year == 0){
                            $exp = $month;
                        }else{
                            $year = $year * 12;
                            $exp = $year + $month;
                        }
                        

                        
                        if ($doctorexp->save()) {
                            $model->experience = $exp;
                            $model->save();
                            }else{
                                print_r($docexp->getErrors());
                            }
                        
                    }
                    
                    
                    

                    $transaction->commit();
                    $this->redirect(array('userDetails/viewHospitalDoctor', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)));
                }
            } catch (Exception $e) {

                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('updateHospitalDoctor', array(
            'model' => $model, 'param1' => $param1, 'specialityUserMapping' => $specialityUserMapping, 'doctorDegreeMapping' => $doctorDegreeMapping, 'model2' => $model2, 'model6' => $model6, 'id' => $id));
    }

    public function actionViewHospitalDoctor($id) {
        $this->layout = 'adminLayout';
         $enc_key = Yii::app()->params->enc_key;
        $userid = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = $this->loadModel($userid);
        $model2 = ClinicDetails::model()->findByAttributes(array('doctor_id' => $userid)); //ClinicDetails
        if (empty($model2)) {
            $model2 = new ClinicDetails;
        }
        $model6 = ClinicVisitingDetails::model()->findByAttributes(array('doctor_id' => $userid));                        //ClinicVisitingDetails

        if (empty($model6)) {
            $model6 = new ClinicVisitingDetails;
        }


        $this->render('viewHospitalDoctor',  array(
            'model' => $model, 'model2' => $model2, 'model6' => $model6, 'userid' => $userid
        ));
    }

   public function actionViewHospital($id) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));
        $specialityUserMapping = SpecialityUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        $amenities = Amenities::model()->findAllByAttributes(array('hos_id' => $id));
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id, "is_clinic" => 0));
        $roleid = $model->role_id;
        if (empty($serviceUserMapping)) {
            $serviceUserMapping = new ServiceUserMapping();
        }
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model3)) {
            $model3 = new DocumentDetails();
        }

        $this->render('viewhospital', array('model' => $model, 'specialityUserMapping' => $specialityUserMapping, 'serviceUserMapping' => $serviceUserMapping, 'model3' => $model3, 'amenities' => $amenities, 'roleid' => $roleid));
    }

    public function actionUpdateAdminHospital($id) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));
        $specialityUserMapping = SpecialityUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        $amenities = Amenities::model()->findAllByAttributes(array('hos_id' => $id));
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id, "is_clinic" => 0));
        $roleid = $model->role_id;
        if (empty($serviceUserMapping)) {
            $serviceUserMapping = new ServiceUserMapping();
        }
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model3)) {
            $model3 = new DocumentDetails();
        }
        $oldprofile = $model->profile_image;

        $oldotherdoc = $model->otherdoc;
        if (isset($_POST['UserDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;


                $postArr = Yii::app()->request->getParam('UserDetails');

                $profile = CUploadedFile::getInstance($model, 'profile_image');
                $registraiondoc = CUploadedFile::getInstance($model, 'registraiondoc');
                $otherdoc = CUploadedFile::getInstance($model, 'otherdoc');

                $model->hospital_name = $postArr['hospital_name'];
                $model->type_of_hospital = $postArr['type_of_hospital'];
                $model->hospital_registration_no = $postArr['hospital_registration_no'];
                if (!empty($postArr['payment_type']))
                    $model->payment_type = implode(",", $postArr['payment_type']);
                if (!empty($postArr['hos_establishment']))
                   $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
                $model->type_of_establishment = $postArr['type_of_establishment'];
                if (!empty($postArr['other_est_type']))
                    $model->other_est_type = $postArr['other_est_type'];
                $model->landline_1 = $postArr['landline_1'];
                $model->landline_2 = $postArr['landline_2'];
                $model->email_1 = $postArr['email_1'];
                if (!empty($postArr['email_2']))
                    $model->email_2 = $postArr['email_2'];
                $model->emergency_no_1 = $postArr['emergency_no_1'];
                if (!empty($postArr['emergency_no_2']))
                    $model->emergency_no_2 = $postArr['emergency_no_2'];
                $model->ambulance_no_1 = $postArr['ambulance_no_1'];
                if (!empty($postArr['ambulance_no_2']))
                    $model->ambulance_no_2 = $postArr['ambulance_no_2'];
                $model->tollfree_no_1 = $postArr['tollfree_no_1'];
                if (!empty($postArr['tollfree_no_2']))
                    $model->tollfree_no_2 = $postArr['tollfree_no_2'];
                $model->coordinator_name_1 = $postArr['coordinator_name_1'];
                $model->coordinator_mobile_1 = $postArr['coordinator_mobile_1'];
                $model->coordinator_email_1 = $postArr['coordinator_email_1'];
                $model->coordinator_name_2 = $postArr['coordinator_name_2'];
                $model->coordinator_mobile_2 = $postArr['coordinator_mobile_2'];
                $model->coordinator_email_2 = $postArr['coordinator_email_2'];
                $model->total_no_of_bed = $postArr['total_no_of_bed'];
                $model->is_open_allday = $postArr['is_open_allday'];
                if (!empty($postArr['hospital_open_time']))
                    $model->hospital_open_time = date("H:i:s", strtotime($postArr['hospital_open_time']));
                if (!empty($postArr['hospital_close_time']))
                    $model->hospital_close_time = date("H:i:s", strtotime($postArr['hospital_close_time']));
                $model->pincode = $postArr['pincode'];
                $model->state_id = $postArr['state_id'];
                $model->state_name = $postArr['state_name'];
                $model->city_id = $postArr['city_id'];
                $model->city_name = $postArr['city_name'];
                $model->area_id = $postArr['area_id'];
                $model->area_name = $postArr['area_name'];
                $model->landmark = $postArr['landmark'];
                $model->address = $postArr['address'];
                $model->latitude = $postArr['latitude'];
                $model->longitude = $postArr['longitude'];
                $model->description = $postArr['description'];
                $model->created_date = date('Y-m-d H:i:s');
                $model->updated_date = date('Y-m-d H:i:s');
                $model->country_id = 1;
                $model->role_id = 5;
                if (!empty($profile)) {
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }

                    $profilepicDir = 'profilepic/';               //profilepic
                    if (!is_dir($baseDir . $profilepicDir)) {
                        mkdir($baseDir . $profilepicDir);
                    }

                    $profilepicDir = $profilepicDir . date("Y") . "/";         //year
                    if (!is_dir($baseDir . $profilepicDir)) {
                        mkdir($baseDir . $profilepicDir);
                    }

                    $profilepicDir = $profilepicDir . date("M") . "/";          //Month
                    if (!is_dir($baseDir . $profilepicDir)) {
                        mkdir($baseDir . $profilepicDir);
                    }

                    $path_part = pathinfo($profile->name);
                    $path_part['filename'];

                    $fname = $profilepicDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];

                    if ($profile->saveAs($baseDir . $fname)) {
                        $model->profile_image = $fname;

                        if (file_exists($baseDir . $oldprofile)) {
                            
                        }
                        // unlink($baseDir . $oldImgName);
                    } else {
                        $model->profile_image = $oldprofile;
                    }
                }
                if ($model->save()) {
                    $user_id = $model->user_id;

                    Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'user_id=:id AND is_clinic=:noDelete', array(':id' => $user_id, ':noDelete' => '0'));



                    if (!empty($_POST['service'])) {
                        $serivceIdArr = array();
                        $serivceIdArr = $_POST['service'];


                        foreach ($serivceIdArr as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);
                            if (!empty($value)) {
                                $serviceUserMappingobj = new ServiceUserMapping();
                                $serviceUserMappingobj->service_id = $purifiedObj->getPurifyText($value);
                                $serviceUserMappingobj->user_id = $user_id;
                                $serviceUserMappingobj->service_discount = $_POST['service_discount'][$key];
                                $serviceUserMappingobj->corporate_discount = $_POST['corporate_discount'][$key];
                                $serviceUserMappingobj->is_available_allday = $_POST['twentyfour'][$key];
                                $serviceUserMappingobj->is_clinic = 0;
                                if (!$serviceUserMappingobj->save()) {
                                    throw new Exception("Error in saving service data");
                                }
                            }
                        }
                    }

                    if (!empty($postArr['amenities']) && count($postArr['amenities']) > 0) {
                        Yii::app()->db->createCommand()->delete('az_amenities', 'hos_id=:id', array(':id' => $user_id));
                        foreach ($postArr['amenities'] as $key => $value) {
                            $amenitiesobj = new Amenities();
                            $amenitiesobj->amenities = $purifiedObj->getPurifyText($value);
                            $amenitiesobj->hos_id = $user_id;

                            if (!$amenitiesobj->save()) {

                                throw new Exception("Error in saving Amenities data");
                            }
                        }
                    }



                    if (!empty($postArr['speciality'])) {
                        Yii::app()->db->createCommand()->delete('az_speciality_user_mapping', 'user_id=:id', array(':id' => $user_id));
                        $serivceIdArr = array();
                        $specialityIdArr = $postArr['speciality'];

                        foreach ($specialityIdArr as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $specialityUserMapping = new SpecialityUserMapping();
                            $specialityid = Yii::app()->db->createCommand()
                                    ->select('speciality_id')
                                    ->from('az_speciality_master t')
                                    ->where('speciality_name=:name', array(':name' => $value))
                                    ->queryRow();

                            $specialityUserMapping->speciality_id = $specialityid['speciality_id'];
                            $specialityUserMapping->user_id = $user_id;

                            $specialityUserMapping->speciality_name = $purifiedObj->getPurifyText($value);
                            if (!$specialityUserMapping->save()) {
                                throw new Exception("Error in saving speciality data");
                            }
                        }
                    }
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    $documentDir = 'document/';                                         //documents
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("M") . "/";
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $registDocObj = CUploadedFile::getInstance($model3, "document");


                    if (!empty($registDocObj)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Hospital_Registration'));

                        if (!empty($registDocObj)) {
                            $path_part = pathinfo($registDocObj->name);
                            $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            if ($registDocObj->saveAs($baseDir . $fname)) {
                                $documentDetModel = new DocumentDetails();
                                $documentDetModel->user_id = $id;
                                $documentDetModel->doc_type = "Hospital_Registration";
                                $documentDetModel->document = $fname;
                                $documentDetModel->save(false);
                            }
                        }
                    }


                    $otherDocObj = CUploadedFile::getInstance($model3, 'otherdoc');
                    if (!empty($otherDocObj)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Other_Registration'));
                        if (!empty($otherDocObj)) {
                            $path_part = pathinfo($otherDocObj->name);
                            $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            if ($otherDocObj->saveAs($baseDir . $fname)) {
                                $documentDetModel = new DocumentDetails();
                                $documentDetModel->user_id = $id;
                                $documentDetModel->doc_type = "Other_Registration";
                                $documentDetModel->document = $fname;
                                $documentDetModel->save(false);
                            }
                        }
                    }
                    $transaction->commit();
                    $this->redirect(array('userDetails/viewhospital', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('updateAdminHospital', array('model' => $model, 'specialityUserMapping' => $specialityUserMapping, 'serviceUserMapping' => $serviceUserMapping, 'model3' => $model3, 'amenities' => $amenities, 'roleid' => $roleid));
    }

    public function actionCreateAdminHospital() {
        $this->layout = 'adminLayout';
        $model = new UserDetails;
        $model1 = new ServiceUserMapping;
        $model3 = new DocumentDetails;
        $roleid = 5;
        $enc_key = Yii::app()->params->enc_key;
        if (isset($_POST['UserDetails'])) {

            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }

            try {

                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->type_of_hospital = $postArr['type_of_hospital'];
                $model->mobile = $postArr['mobile'];
                if (!empty($postArr['password'])) {
                    $model->password = md5($postArr['password']);
                }
                $model->hospital_registration_no = $postArr['hospital_registration_no'];
                if (!empty($postArr['payment_type']))
                    $model->payment_type = implode(",", $postArr['payment_type']);
                if (!empty($postArr['hos_establishment']))
                 $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
                $model->type_of_establishment = $postArr['type_of_establishment'];
                if (!empty($postArr['other_est_type']))
                    $model->other_est_type = $postArr['other_est_type'];
                $model->landline_1 = $postArr['landline_1'];
                $model->landline_2 = $postArr['landline_2'];
                $model->email_1 = $postArr['email_1'];
                if (!empty($postArr['email_2']))
                    $model->email_2 = $postArr['email_2'];
                $model->emergency_no_1 = $postArr['emergency_no_1'];
                if (!empty($postArr['emergency_no_2']))
                    $model->emergency_no_2 = $postArr['emergency_no_2'];
                $model->ambulance_no_1 = $postArr['ambulance_no_1'];
                if (!empty($postArr['ambulance_no_2']))
                    $model->ambulance_no_2 = $postArr['ambulance_no_2'];
                $model->tollfree_no_1 = $postArr['tollfree_no_1'];
                if (!empty($postArr['tollfree_no_2']))
                    $model->tollfree_no_2 = $postArr['tollfree_no_2'];
                $model->coordinator_name_1 = $postArr['coordinator_name_1'];
                $model->coordinator_mobile_1 = $postArr['coordinator_mobile_1'];
                $model->coordinator_email_1 = $postArr['coordinator_email_1'];
                $model->coordinator_name_2 = $postArr['coordinator_name_2'];
                $model->coordinator_mobile_2 = $postArr['coordinator_mobile_2'];
                $model->coordinator_email_2 = $postArr['coordinator_email_2'];
                $model->total_no_of_bed = $postArr['total_no_of_bed'];
                $model->is_open_allday = $postArr['is_open_allday'];
                if (!empty($postArr['hospital_open_time']))
                    $model->hospital_open_time = date("H:i:s", strtotime($postArr['hospital_open_time']));
                if (!empty($postArr['hospital_close_time']))
                    $model->hospital_close_time = date("H:i:s", strtotime($postArr['hospital_close_time']));
                $model->country_name = "india";
                $model->pincode = $postArr['pincode'];
                $model->state_id = $postArr['state_id'];
                $model->state_name = $postArr['state_name'];
                $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->area_id = $purifiedObj->getPurifyText($postArr['area_id']);
                $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
                $model->address = $purifiedObj->getPurifyText($postArr['address']);
                $model->latitude = $postArr['latitude'];
                $model->longitude = $postArr['longitude'];
                $model->description = $purifiedObj->getPurifyText($postArr['description']);
                $model->is_active = 1;
                $model->created_date = date('Y-m-d H:i:s');
                $model->updated_date = date('Y-m-d H:i:s');
                $model->country_id = 1;
                $model->role_id = 5;
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


                if (!empty($_POST['profile'])) {
                    $imageName = time() . "_" . rand(111, 9999) . '.png';
                    $model->profile_image = $profileDir . $imageName;

                    if (file_put_contents($baseDir . $profileDir . $imageName, $data)) {
                        
                    }
                }

                if ($model->save()) {
                    $user_id = $model->user_id;

                    if (isset($postArr['userservice']) && count($postArr['speciality']) > 0) {

                        foreach ($postArr['userservice'] as $key => $value) {
                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $purifiedObj->getPurifyText($value);
                            $serviceUserMappingobj->user_id = $user_id;
                            $serviceUserMappingobj->service_discount = $postArr['discount'][$key];
                             $serviceUserMappingobj->corporate_discount = $postArr['corporate_discount'][$key];
                            $serviceUserMappingobj->is_available_allday = $postArr['twentyfour'][$key];
                            $serviceUserMappingobj->is_clinic = 0;
                            if (!$serviceUserMappingobj->save()) {

                                throw new Exception("Error in saving service user data");
                            }
                        }
                    }

                    if (!empty($postArr['amenities']) && count($postArr['amenities']) > 0) {

                        foreach ($postArr['amenities'] as $key => $value) {
                            $amenitiesobj = new Amenities();
                            $amenitiesobj->amenities = $purifiedObj->getPurifyText($value);
                            $amenitiesobj->hos_id = $user_id;

                            if (!$amenitiesobj->save()) {

                                throw new Exception("Error in saving Amenities data");
                            }
                        }
                    }
                    if (isset($postArr['speciality']) && count($postArr['speciality']) > 0) {

                        $specialityIdArr = $postArr['speciality'];

                        foreach ($specialityIdArr as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $specialityUserMapping = new SpecialityUserMapping();
                            $specialityid = Yii::app()->db->createCommand()
                                    ->select('speciality_name')
                                    ->from('az_speciality_master t')
                                    ->where('speciality_id=:name', array(':name' => $value))
                                    ->queryRow();

                            $specialityUserMapping->speciality_id = $value;
                            $specialityUserMapping->user_id = $user_id;

                            $specialityUserMapping->speciality_name = $purifiedObj->getPurifyText($specialityid['speciality_name']);
                            if (!$specialityUserMapping->save()) {
                                throw new Exception("Error in saving speciality data");
                            }
                        }
                    }

                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    $documentDir = 'document/';                                         //documents
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("M") . "/";
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $registDocObj = CUploadedFile::getInstance($model3, "document");

                    if (!empty($registDocObj)) {
                        $path_part = pathinfo($registDocObj->name);
                        $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        if ($registDocObj->saveAs($baseDir . $fname)) {
                            $documentDetModel = new DocumentDetails();
                            $documentDetModel->user_id = $user_id;
                            $documentDetModel->doc_type = "Hospital_Registration";
                            $documentDetModel->document = $fname;
                            $documentDetModel->save(false);
                        }
                    }


                    $otherDocObj = CUploadedFile::getInstance($model3, 'otherdoc');


                    if (!empty($otherDocObj)) {
                        $path_part = pathinfo($otherDocObj->name);
                        $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        if ($otherDocObj->saveAs($baseDir . $fname)) {
                            $documentDetModel = new DocumentDetails();
                            $documentDetModel->user_id = $user_id;
                            $documentDetModel->doc_type = "Other_Registration";
                            $documentDetModel->document = $fname;
                            $documentDetModel->save(false);
                        }
                    }

                    $transaction->commit();


                    $this->redirect(array('userDetails/viewhospital', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('createAdminHospital', array('model' => $model, 'model1' => $model1, 'model3' => $model3, 'roleid' => $roleid));
    }

    public function actionUpdateHospitalProfile() {
        //$enc_key = Yii::app()->params->enc_key;
        $this->layout = 'adminLayout';
        $id = Yii::app()->user->id;

        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));
        $roleid = $model->role_id;
        $specialityUserMapping = SpecialityUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        if (empty($specialityUserMapping)) {
            $specialityUserMapping[] = new SpecialityUserMapping;
        }
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id, "is_clinic" => 0));
        if (empty($serviceUserMapping)) {
            $serviceUserMapping[] = new ServiceUserMapping;
        }
        $amenities = Amenities::model()->findAllByAttributes(array('hos_id' => $id));

        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model3)) {
            $model3 = new DocumentDetails();
        }
        $oldprofile = $model->profile_image;

       
        if (isset($_POST['UserDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;


                $postArr = Yii::app()->request->getParam('UserDetails');
              
                $profile = CUploadedFile::getInstance($model, 'profile_image');
                $registraiondoc = CUploadedFile::getInstance($model, 'registraiondoc');
                $otherdoc = CUploadedFile::getInstance($model, 'otherdoc');

                $model->hospital_name = $postArr['hospital_name'];
                $model->type_of_hospital = $postArr['type_of_hospital'];
                $model->hospital_registration_no = $postArr['hospital_registration_no'];
                if (!empty($postArr['payment_type']))
                    $model->payment_type = implode(",", $postArr['payment_type']);
                if (!empty($postArr['hos_establishment']))
                    $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
                $model->type_of_establishment = $postArr['type_of_establishment'];
                if ($postArr['type_of_establishment'] == "others") {
                    $model->other_est_type = $postArr['other_est_type'];
                }
                $model->total_no_of_bed = $postArr['total_no_of_bed'];

                $model->landline_1 = $postArr['landline_1'];
                $model->landline_2 = $postArr['landline_2'];
                $model->email_1 = $postArr['email_1'];
                if (!empty($postArr['email_2']))
                    $model->email_2 = $postArr['email_2'];
                $model->emergency_no_1 = $postArr['emergency_no_1'];
                if (!empty($postArr['emergency_no_2']))
                    $model->emergency_no_2 = $postArr['emergency_no_2'];
                $model->ambulance_no_1 = $postArr['ambulance_no_1'];
                if (!empty($postArr['ambulance_no_2']))
                    $model->ambulance_no_2 = $postArr['ambulance_no_2'];
                $model->tollfree_no_1 = $postArr['tollfree_no_1'];
                if (!empty($postArr['tollfree_no_2']))
                    $model->tollfree_no_2 = $postArr['tollfree_no_2'];
                $model->coordinator_name_1 = $postArr['coordinator_name_1'];
                $model->coordinator_mobile_1 = $postArr['coordinator_mobile_1'];
                $model->coordinator_email_1 = $postArr['coordinator_email_1'];
                $model->coordinator_name_2 = $postArr['coordinator_name_2'];
                $model->coordinator_mobile_2 = $postArr['coordinator_mobile_2'];
                $model->coordinator_email_2 = $postArr['coordinator_email_2'];
                //$model->total_no_of_bed = $postArr['total_no_of_bed'];
                $model->is_open_allday = $postArr['is_open_allday'];
                if (!empty($postArr['hospital_open_time']))
                    $model->hospital_open_time = date("H:i:s", strtotime($postArr['hospital_open_time']));
                if (!empty($postArr['hospital_close_time']))
                    $model->hospital_close_time = date("H:i:s", strtotime($postArr['hospital_close_time']));

                $model->pincode = $postArr['pincode'];
                $model->state_id = $postArr['state_id'];
                $model->state_name = $postArr['state_name'];
                $model->city_id = $postArr['city_id'];
                $model->city_name = $postArr['city_name'];
                $model->area_id = $postArr['area_id'];
                $model->area_name = $postArr['area_name'];
                $model->landmark = $postArr['landmark'];
                $model->address = $postArr['address'];
                $model->latitude = $postArr['latitude'];
                $model->longitude = $postArr['longitude'];
                $model->description = $postArr['description'];
                $model->created_date = date('Y-m-d H:i:s');
                $model->updated_date = date('Y-m-d H:i:s');
                if ($model->save()) {
                    $user_id = $model->user_id;

                    Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'user_id=:id AND is_clinic=:isclinic', array(':id' => $user_id, ':isclinic' => '0'));

                    if (!empty($_POST['service']) && count($_POST['service']) > 0) {
                        $serivceIdArr = array();
                        $serivceIdArr = $_POST['service'];
                        foreach ($_POST['service'] as $key => $value) {
                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $purifiedObj->getPurifyText($value);
                            $serviceUserMappingobj->user_id = $user_id;
                            $serviceUserMappingobj->service_discount = $_POST['service_discount'][$key];
                             $serviceUserMappingobj->corporate_discount = $_POST['corporate_discount'][$key];
                            $serviceUserMappingobj->is_available_allday = $_POST['twentyfour'][$key];
                            $serviceUserMappingobj->is_clinic = 0;
                            if (!$serviceUserMappingobj->save()) {

                                throw new Exception("Error in saving service user data");
                            }
                        }
                    }
                    Yii::app()->db->createCommand()->delete('az_amenities', 'hos_id=:id', array(':id' => $user_id));
                    if (isset($postArr['amenities']) && count($postArr['amenities']) > 0) {

                        foreach ($postArr['amenities'] as $key => $value) {
                            $amenitiesobj = new Amenities();
                            $amenitiesobj->amenities = $purifiedObj->getPurifyText($value);
                            $amenitiesobj->hos_id = $user_id;

                            if (!$amenitiesobj->save()) {

                                throw new Exception("Error in saving Amenities data");
                            }
                        }
                    }
                    Yii::app()->db->createCommand()->delete('az_speciality_user_mapping', 'user_id=:id', array(':id' => $user_id));

                    if (!empty($postArr['speciality']) && count($postArr['speciality']) > 0) {
                        
                        $serivceIdArr = array();
                        $specialityIdArr = $postArr['speciality'];
                        foreach ($specialityIdArr as $key => $value) {
                           // print_r($value . $key);exit;
                            $specialityUserMapping = new SpecialityUserMapping();
                            $specMaster = Yii::app()->db->createCommand()
                                    ->select('speciality_name,speciality_id')
                                    ->from('az_speciality_master t')
                                    ->where('speciality_name=:id', array(':id' => $value))
                                    ->queryRow();

                            $specialityUserMapping->speciality_id = $specMaster['speciality_id'];
                            $specialityUserMapping->user_id = $user_id;

                            $specialityUserMapping->speciality_name = $specMaster['speciality_name'];
                            if (!$specialityUserMapping->save()) {

                                throw new Exception("Error in saving speciality data");
                            }
                        }
                    }
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $profileDir = 'profilepic/';               //profilepic
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("M") . "/";
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }


                    $profileImageObj = CUploadedFile::getInstance($model, "profile_image");
                    if (!empty($profileImageObj)) {
                        $path_part = pathinfo($profileImageObj->name);
                        $fname = $profileDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model->profile_image = $fname;
                        if ($profileImageObj->saveAs($baseDir . $model->profile_image)) {
                            $model->save();
                        }
                    }
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    $documentDir = 'document/';                                         //documents
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $documentDir = $documentDir . date("M") . "/";
                    if (!is_dir($baseDir . $documentDir)) {
                        mkdir($baseDir . $documentDir);
                    }
                    $registDocObj = CUploadedFile::getInstance($model3, "document");


                    if (!empty($registDocObj)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Hospital_Registration'));

                        if (!empty($registDocObj)) {
                            $path_part = pathinfo($registDocObj->name);
                            $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            if ($registDocObj->saveAs($baseDir . $fname)) {
                                $documentDetModel = new DocumentDetails();
                                $documentDetModel->user_id = $id;
                                $documentDetModel->doc_type = "Hospital_Registration";
                                $documentDetModel->document = $fname;
                                $documentDetModel->save(false);
                            }
                        }
                    }


                    $otherDocObj = CUploadedFile::getInstance($model3, 'otherdoc');
                    if (!empty($otherDocObj)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Other_Registration'));
                        if (!empty($otherDocObj)) {
                            $path_part = pathinfo($otherDocObj->name);
                            $fname = $documentDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            if ($otherDocObj->saveAs($baseDir . $fname)) {
                                $documentDetModel = new DocumentDetails();
                                $documentDetModel->user_id = $id;
                                $documentDetModel->doc_type = "Other_Registration";
                                $documentDetModel->document = $fname;
                                $documentDetModel->save(false);
                            }
                        }
                    }
                    $transaction->commit();
                    Yii::app()->user->setFlash('Success', 'You have successfully updated data.');
                    $this->redirect(array('userDetails/updateHospitalProfile'));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('updateHospitalProfile', array('model' => $model, 'specialityUserMapping' => $specialityUserMapping, 'serviceUserMapping' => $serviceUserMapping, 'model3' => $model3, 'amenities' => $amenities, 'roleid' => $roleid));
    }

    public function actionCreateAdminDoctor() {
        $enc_key = Yii::app()->params->enc_key;
        $this->layout = 'adminLayout';
        $model = new UserDetails;
        $model2 = new ClinicDetails;
        $model6 = new ClinicVisitingDetails;
        $data = "";

        

        if (isset($_POST['UserDetails'])) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $postArr = Yii::app()->request->getParam('UserDetails');
                $purifiedObj = Yii::app()->purifier;
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password']))
                    $model->password = md5($postArr['password']);
                $model->blood_group = $purifiedObj->getPurifyText($postArr['blood_group']);
                $model->country_id = 1;
                $model->state_id = $postArr['state_id'];
                $model->city_id = $postArr['city_id'];
                $model->area_id = $postArr['area_id'];
                $model->pincode = $postArr['pincode'];
                $model->apt_contact_no_1 = $postArr['apt_contact_no_1'];
                if (!empty($postArr['apt_contact_no_2']))
                    $model->apt_contact_no_2 = $postArr['apt_contact_no_2'];
                $model->email_1 = $postArr['email_1'];
                if (!empty($postArr['email_2']))
                    $model->email_2 = $postArr['email_2'];
                $model->doctor_registration_no = $postArr['doctor_registration_no'];
                $model->description = $purifiedObj->getPurifyText($postArr['description']);
                $model->country_name = "india";
                $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
                $model->address = $purifiedObj->getPurifyText($postArr['address']);

                if (!empty($postArr['birth_date'])) {
                    $birthDate = $purifiedObj->getPurifyText($postArr['birth_date']);
                    $birthDate = date("Y-m-d", strtotime($birthDate));
                    $model->birth_date = $birthDate;
                    //calculate age in months
                    $date2 = date("Y-m-d");
                    $diff = abs(strtotime($date2) - strtotime($birthDate));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    $age = ($years * 12) + $months;
                    $model->age = $age;
                }
                if (!empty($postArr['gender'])) {
                    $model->gender = $purifiedObj->getPurifyText($postArr['gender']);
                }
                if (isset($postArr['sub_speciality']) && count($postArr['sub_speciality']) > 0) {
                    $sub_spe = implode(',', $postArr['sub_speciality']);
                    $model->sub_speciality = $sub_spe;
                }
                $model->role_id = 3;
                $model->is_active = 1;
                $model->created_date = date("Y-m-d H:i:s");
                $model->created_by = Yii::app()->user->id;
                $model->updated_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;

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
                if (!empty($_POST['profile'])) {
                    $imageName = time() . "_" . rand(111, 9999) . '.png';
                    $model->profile_image = $profileDir . $imageName;

                    if (file_put_contents($baseDir . $profileDir . $imageName, $data)) {
                        
                    }
                }
                if ($model->save()) {
                    $user_id = $model->user_id;
                    if (isset($postArr['speciality']) && count($postArr['speciality']) > 0) {

                        foreach ($postArr['speciality'] as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $SpecialityUserMappingobj = new SpecialityUserMapping();
                            $specialityid = Yii::app()->db->createCommand()
                                    ->select('speciality_name')
                                    ->from('az_speciality_master t')
                                    ->where('speciality_id=:name', array(':name' => $value))
                                    ->queryRow();

                            $SpecialityUserMappingobj->speciality_id = $value;
                            $SpecialityUserMappingobj->user_id = $user_id;
                            $SpecialityUserMappingobj->speciality_name = $specialityid['speciality_name'];

                            if (!$SpecialityUserMappingobj->save()) {
                                throw new Exception("Error in saving speciality data");
                            }
                        }
                    }

                    if (isset($postArr['degree']) && !empty($postArr['degree'])) {

                        foreach ($postArr['degree'] as $key => $value) {
                            $DoctorDegreeMappingobj = new DoctorDegreeMapping();
                            $degreeid = Yii::app()->db->createCommand()
                                    ->select('degree_name')
                                    ->from('az_degree_master t')
                                    ->where('degree_id=:name', array(':name' => $value))
                                    ->queryRow();
                            $DoctorDegreeMappingobj->degree_id = $value;
                            $DoctorDegreeMappingobj->doctor_id = $user_id;
                            $DoctorDegreeMappingobj->degree_name = $degreeid['degree_name'];
                            if (!$DoctorDegreeMappingobj->save()) {
                                throw new Exception("Error in saving degree data");
                            }
                        }
                    }
                    /*if (isset($_POST['ClinicDetails']['alldayopen']) && $_POST['ClinicDetails']['alldayopen'] == 'Y') {
                        $model2->alldayopen = 'Y';
                        if ($model2->save()) {
                        }
                    } else {
                        $selecteddays = $_POST['ClinicVisitingDetails'];
                       
                        if (!empty($selecteddays['day'])) {
                            foreach ($selecteddays['day'] as $key => $value) {
                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = 0;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;
                                $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key]));
                                $ClinicVisitingDetails->role_type = "doctor";
                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving data");
                                }
                                $model2->alldayopen = 'N';
                                if ($model2->save()) {
                                    
                                }
                            }
                        }
                    }*/
                    
                    if (!empty($_POST['DoctorExperience'])) {
                        $docExp = $_POST['DoctorExperience'];
                        $doctorexp = new DoctorExperience;
                        $year = $docExp['work_from'];
                        $month = $docExp['work_to'];
                        $doctorexp->doctor_id = $user_id;
                        $doctorexp->work_from = $year;
                        $doctorexp->work_to = $month;
                        $exp = 0;
                        if($year == 0){
                            $exp = $month;
                        }else{
                            $year = $year * 12;
                            $exp = $year + $month;
                        }
                        if ($doctorexp->save()) {
                            $model->experience = $exp;
                            $model->save();
                        }else{
                            print_r($docexp->getErrors());
                        }
                    }

                    $transaction->commit();
                    $this->redirect(array('viewDoctor', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                $model->addError(NULL, $ex->getMessage());
            }
        }
        $this->render('CreateAdminDoctor', array('model' => $model, 'model6' => $model6));
    }

    public function actionCreateAdminPatient() {
        $this->layout = 'adminLayout';
        $model = new UserDetails;
        if (isset($_POST['UserDetails'])) {

            $postArr = Yii::app()->request->getParam('UserDetails');

            $purifiedObj = Yii::app()->purifier;
            $model->role_id = 4;
            $model->patient_type = $purifiedObj->getPurifyText($postArr['patient_type']);
            $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
            $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
            $model->gender = $purifiedObj->getPurifyText($postArr['gender']);
            $model->vip_role = $purifiedObj->getPurifyText($postArr['vip_role']);
            $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
            if (!empty($postArr['birth_date']))
                $model->birth_date = date("Y-m-d", strtotime($postArr['birth_date']));
            $model->age = $postArr['age'];
            $model->blood_group = $postArr['blood_group'];

            $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
            if (!empty($postArr['password']))
                $model->password = md5($postArr['password']);
            $model->apt_contact_no_1 = $purifiedObj->getPurifyText($postArr['apt_contact_no_1']);
            $model->apt_contact_no_2 = $purifiedObj->getPurifyText($postArr['apt_contact_no_2']);
            $model->email_1 = $purifiedObj->getPurifyText($postArr['email_1']);
            $model->email_2 = $purifiedObj->getPurifyText($postArr['email_2']);

            $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
            $model->state_id = $purifiedObj->getPurifyText($postArr['state_id']);
            $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
            $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
            $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
            $model->area_id = $purifiedObj->getPurifyText($postArr['area_id']);
            $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
            $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
            $model->address = $purifiedObj->getPurifyText($postArr['address']);
            $model->country_name = "India";
            $model->country_id = 1;
            $model->is_active = 1;

            if ($model->save()) {
                $this->redirect(array(('userDetails/adminpatient')));
            }
        }
        $this->render('createAdminPatient'
                , array(
            'model' => $model
        ));
    }

    /*
     * SessionArr created for Pathology Data
     * @author => Sagar Badgujar
     */

    public function actionPathology() {

        $model = new UserDetails;
        $model3 = new DocumentDetails;
        $model4 = new ServiceUserMapping;
        $model6 = new ClinicVisitingDetails;
        $model7 = new BankDetails;

        $session = new CHttpSession;

        if (isset($_POST['UserDetails'])) {

            $session->open();
            $postArr = Yii::app()->request->getParam('UserDetails');

            $session['hospital_name'] = $postArr['hospital_name'];
            $session['type_of_hospital'] = $postArr['type_of_hospital'];
            $session['hospital_registration_no'] = $postArr['hospital_registration_no'];
            $session['hos_establishment'] = $postArr['hos_establishment'];
//            $session['first_name'] = $postArr['first_name'];
//            $session['last_name'] = $postArr['last_name'];
            $session['mobile'] = $postArr['mobile'];
            $session['password'] = $postArr['password'];
            $session['other_est_type'] = $postArr['other_est_type'];
            $session['apt_contact_no_1'] = $postArr['apt_contact_no_1'];
            $session['apt_contact_no_2'] = $postArr['apt_contact_no_2'];
            $session['email_1'] = $postArr['email_1'];
            $session['email_2'] = $postArr['email_2'];
            $session['pincode'] = $postArr['pincode'];
            $session['state_id'] = $postArr['state_id'];
            $session['state_name'] = $postArr['state_name'];
            $session['city_name'] = $postArr['city_name'];
            $session['area_id'] = $postArr['area_id'];
            $session['area_name'] = $postArr['area_name'];
            $session['landmark'] = $postArr['landmark'];
            $session['address'] = $postArr['address'];
            $session['latitude']= $postArr['latitude'];
            $session['longitude'] = $postArr['longitude'];
            $session['coordinator_name_1'] = $postArr['coordinator_name_1'];
            $session['coordinator_mobile_1'] = $postArr['coordinator_mobile_1'];
            $session['coordinator_name_2'] = $postArr['coordinator_name_2'];
            $session['coordinator_mobile_2'] = $postArr['coordinator_mobile_2'];
            $session['coordinator_email_1'] = $postArr['coordinator_email_1'];
            $session['coordinator_email_2'] = $postArr['coordinator_email_2'];

            $session['free_opd_perday'] = $postArr['free_opd_perday'];
            if (isset($postArr['free_opd_preferdays'])) {
                $session['free_opd_preferdays'] = $postArr['free_opd_preferdays'];
            }

            if (isset($postArr['payment_type'])) {
                $session['payment_type'] = $postArr['payment_type'];
            }


//             $session['userservice'] = $postArr['userservice'];
//            $session['discount'] = $postArr['discount'];
//            $session['twentyfour'] = $postArr['twentyfour'];

            $session['take_home'] = $postArr['take_home'];
            $session['emergency'] = $postArr['emergency'];
            $session['opd_no'] = $postArr['opd_no'];      //used as corporate_discount
            $session['blood_bank_no'] = $postArr['blood_bank_no'];   //used as free or charge
            $session['extra_charges'] = $postArr['extra_charges'];   //used for charge

            if (isset($postArr['is_open_allday']))
                $session['is_open_allday'] = $postArr['is_open_allday'];

            $session['description'] = $postArr['description'];



            $service = Yii::app()->request->getParam('ServiceUserMapping');
            $session['userservice'] = $service['service_id'];
            $session['discount'] = $service['service_discount'];
            $session['twentyfour'] = $service['twentyfour'];
            $session['corporate_discount'] = $service['corporate_discount'];



            $bankDetail = Yii::app()->request->getParam('BankDetails');
            $session['acc_holder_name'] = $bankDetail['acc_holder_name'];
            $session['bank_name'] = $bankDetail['bank_name'];
            $session['branch_name'] = $bankDetail['branch_name'];
            $session['account_no'] = $bankDetail['account_no'];
            $session['account_type'] = $bankDetail['account_type'];
            $session['ifsc_code'] = $bankDetail['ifsc_code'];


            $ClinicVisitingDetails = Yii::app()->request->getParam('ClinicVisitingDetails');
            $session['clinic_open_time'] = $ClinicVisitingDetails['clinic_open_time'];
            $session['clinic_close_time'] = $ClinicVisitingDetails['clinic_close_time'];
            $session['clinic_eve_open_time'] = $ClinicVisitingDetails['clinic_eve_open_time'];
            $session['clinic_eve_close_time'] = $ClinicVisitingDetails['clinic_eve_close_time'];



            if (isset($ClinicVisitingDetails['day']) && count($ClinicVisitingDetails['day']) > 0) {
                $session['day'] = $ClinicVisitingDetails['day'];
            }

            Yii::app()->end();
        }


        $this->render('pathology'
                , array(
            'model' => $model, 'model3' => $model3, 'model4' => $model4, 'model6' => $model6, 'model7' => $model7, 'session' => $session
        ));
    }

    /*
     * PathologySetData - Pathology's Data is saving
     * @param => all pathology related info saving
     * @author => Sagar Badgujar
     */

    public function actionPathologySetData() {


        $enc_key = Yii::app()->params->enc_key;

        $model = new UserDetails;
        $model3 = new DocumentDetails;
        $model4 = new ServiceUserMapping;
        $model6 = new ClinicVisitingDetails;
        $model7 = new BankDetails;
        $commonobj = new CommonFunction;
        $session = new CHttpSession;
        $session->open();

        $data = "";
        if (isset($_POST['UserDetails'])) {

            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
        }
        if (isset($_POST['UserDetails']) && count($_POST['UserDetails']) > 0) {

            $transaction = Yii::app()->db->beginTransaction();
            try {

                $model->is_active = 0;
                $model->created_date = date('Y-m-d H:i:s');
                $model->role_id = 6;
                $model->hospital_name = $session['hospital_name'];
                $model->type_of_hospital = $session['type_of_hospital'];
                $model->hospital_registration_no = $session['hospital_registration_no'];
                if (!empty($postArr['hos_establishment']))
                    $model->hos_establishment = date("Y-m-d", strtotime("01-" . $session['hos_establishment']));


//                $model->first_name = $session['first_name'];
//                $model->last_name = $session['last_name'];
                $model->mobile = $session['mobile'];
                if (!empty($session['password']))
                    $model->password = md5($session['password']);
                $model->other_est_type = $session['other_est_type'];
                $model->apt_contact_no_1 = $session['apt_contact_no_1'];
                $model->apt_contact_no_2 = $session['apt_contact_no_2'];
                $model->email_1 = $session['email_1'];
                $model->email_2 = $session['email_2'];
                $model->country_id = 1;
                $model->country_name = "India";
                $model->pincode = $session['pincode'];
                $model->state_id = $session['state_id'];
                $model->state_name = $session['state_name'];
                $model->city_name = $session['city_name'];
                $model->area_id = $session['area_id'];
                $model->area_name = $session['area_name'];
                $model->landmark = $session['landmark'];
                $model->address = $session['address'];
                $model->latitude = $session['latitude'];
                $model->longitude = $session['longitude'];
                $model->coordinator_name_1 = $session['coordinator_name_1'];
                $model->coordinator_mobile_1 = $session['coordinator_mobile_1'];
                $model->coordinator_name_2 = $session['coordinator_name_2'];
                $model->coordinator_mobile_2 = $session['coordinator_mobile_2'];
                $model->coordinator_email_1 = $session['coordinator_email_1'];
                $model->coordinator_email_2 = $session['coordinator_email_2'];
                $model->description = $session['description'];
                $model->take_home = $session['take_home'];
                $model->emergency = $session['emergency'];
                if (!empty($session['opd_no']))
                    $model->opd_no = $session['opd_no'];

                if (!empty($session['blood_bank_no']))
                    $model->blood_bank_no = $session['blood_bank_no'];

                if (!empty($session['extra_charges']))
                    $model->extra_charges = $session['extra_charges'];

                $model->free_opd_perday = $session['free_opd_perday'];
                
                if (!empty($session['payment_type'])) {
                    $model->payment_type = implode(",", $session['payment_type']);
                }
                

                $Daystr = NULL;
                if (isset($session['free_opd_preferdays']) && count($session['free_opd_preferdays']) > 0) {
                    foreach ($session['free_opd_preferdays'] as $key => $value) {
                        $Daystr .= $value . ",";
                    }
                }
                $model->free_opd_preferdays = $Daystr;



                if ($model->save()) {
                    $user_id = $model->user_id;
                    $mobile = $model->mobile;
                    if (isset($_POST['UserDetails']['is_open_allday']) && $_POST['UserDetails']['is_open_allday'] == 'Y') {
                        $model->is_open_allday = 'Y';
                        $model->save();
                    } else {
                        if (isset($session['day']) && count($session['day']) > 0) {
                            foreach ($session['day'] as $key => $value) {
                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = 0;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;
                                $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($session['clinic_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($session['clinic_close_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($session['clinic_eve_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($session['clinic_eve_close_time'][$key]));
                                $ClinicVisitingDetails->role_type = "pathology";
                                if ($ClinicVisitingDetails->save()) {
                                    
                                }
                            }
                        }
                    }
                    if (!empty($session['userservice'])) {
                        foreach ($session['userservice'] as $key => $serviceId) {
                            $userServiceModel = new ServiceUserMapping();
                            $userServiceModel->user_id = $user_id;
                            $userServiceModel->service_id = $serviceId;
                            $userServiceModel->is_available_allday = $session['twentyfour'][$key];
                            $userServiceModel->service_discount = $session['discount'][$key];
                            $userServiceModel->corporate_discount = $session['corporate_discount'][$key];
                            $userServiceModel->is_clinic = 0;
                            $userServiceModel->save();
                        }
                    }
                    if (isset($_POST['BankDetails'])) {
                        $bankArr = $_POST['BankDetails'];

                        $bank = new BankDetails;
                        $bank->user_id = $user_id;
                        $bank->acc_holder_name = $bankArr['acc_holder_name'];
                        $bank->bank_name = $bankArr['bank_name'];
                        $bank->branch_name = $bankArr['branch_name'];
                        $bank->account_no = $bankArr['account_no'];
                        $bank->account_type = $bankArr['account_type'];
                        $bank->ifsc_code = $bankArr['ifsc_code'];

                        if ($bank->save()) {
                            
                        }
                    }
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $profileDir = 'profilepic/';               //profilepic
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("M") . "/";
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }


                    if (!empty($_POST['profile'])) {
                        $imageName = time() . "_" . rand(111, 9999) . '.png';
                        $model->profile_image = $profileDir . $imageName;

                        if (file_put_contents($baseDir . $profileDir . $imageName, $data)) {
                            
                        }
                    }
                    $model->save();

                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    $docDir = 'document/';                                      //document
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("Y") . "/";                        //year
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("M") . "/";                        //month
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }


                    $photos = CUploadedFile::getInstancesByName('DocumentDetails[doc_photo]');
                    // proceed if the images have been set
                    if (isset($photos) && count($photos) > 0) {
                        foreach ($photos as $image => $pic) {
                            $docdetails = new DocumentDetails;
                            $path_part = pathinfo($pic->name);
                            $pic_name = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $docdetails->document = $pic_name;
                            $pic->saveAs($baseDir . $docdetails->document);
                            $docdetails->doc_type = 'Gallery_photos';
                            $docdetails->user_id = $user_id;
                            if ($docdetails->save()) {
                                
                            }
                        }
                    }

                    $docname = CUploadedFile::getInstance($model3, 'document');
                    if (!empty($docname)) {
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model3->document = $dname;
                        $docname->saveAs($baseDir . $model3->document);
                        $model3->doc_type = 'Pathology_Registration';
                        $model3->user_id = $user_id;
                        if ($model3->save()) {
                            
                        }
                    }
                    $otherdoc = new DocumentDetails;
                    $otherdocname = CUploadedFile::getInstance($model3, 'otherdoc');
                    if (!empty($otherdocname)) {
                        $path_part = pathinfo($otherdocname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $otherdoc->document = $dname;
                        $otherdocname->saveAs($baseDir . $otherdoc->document);
                        $otherdoc->doc_type = 'Pathology_Oth_Registration';
                        $otherdoc->user_id = $user_id;
                        if ($otherdoc->save()) {
                            
                        }
                    }

                    $transaction->commit();
                    $session->destroy();

                    $model->unsetAttributes();
                    $commonobj->sendSms($mobile, "Thanks for your registration. Your profile will shortly be activated after a small verification process.");
                    Yii::app()->user->setFlash('Success', 'You have successfully registered. Your account will be activated after verification.');
                    $this->redirect(array('userDetails/pathology'));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('pathology'
                , array(
            'model' => $model, 'model3' => $model3, 'model4' => $model4, 'model6' => $model6, 'model7' => $model7, 'session' => $session
        ));
    }

    public function actionManagePathology() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('searchPathology');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('managePathology', array(
            'model' => $model,
        ));
    }

    public function actionViewPathology($id) {
        $this->layout = 'adminLayout';

        try {
            $enc_key = Yii::app()->params->enc_key;
            $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        } catch (Exception $ex) {
            $model->addError(NULL, $ex->getMessage());
        }

        $this->render('viewPathology', array(
            'model' => $this->loadModel($id)
        ));
    }

    /*
     * Create Admin_side Pathology Data
     * @author => Sagar Badgujar
     */

    public function actionCreateAdminPathology($role) {
        $this->layout = 'adminLayout';
        $session = new CHttpSession;
        $session->open();
        $login_role_id = $session["user_role_id"];
        
        $model = new UserDetails;
        $model1 = new ServiceUserMapping;
        $model3 = new DocumentDetails;
        $model6 = new ClinicVisitingDetails;
        $model7 = new BankDetails;
        $enc_key = Yii::app()->params->enc_key;
        $data = "";
        if (isset($_POST['UserDetails'])) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }

            try {

                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = $role;
                $model->is_active = 1;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password'])) {
                    $model->password = md5($postArr['password']);
                }
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                if (!empty($postArr['hos_establishment']))
                    $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
                $model->other_est_type = $purifiedObj->getPurifyText($postArr['other_est_type']);
//                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
//                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
                $model->apt_contact_no_1 = $purifiedObj->getPurifyText($postArr['apt_contact_no_1']);
                $model->apt_contact_no_2 = $purifiedObj->getPurifyText($postArr['apt_contact_no_2']);
                $model->email_1 = $purifiedObj->getPurifyText($postArr['email_1']);
                $model->email_2 = $purifiedObj->getPurifyText($postArr['email_2']);
                $model->coordinator_name_1 = $purifiedObj->getPurifyText($postArr['coordinator_name_1']);
                $model->coordinator_mobile_1 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_1']);
                $model->coordinator_email_1 = $purifiedObj->getPurifyText($postArr['coordinator_email_1']);
                $model->coordinator_name_2 = $purifiedObj->getPurifyText($postArr['coordinator_name_2']);
                $model->coordinator_mobile_2 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_2']);
                $model->coordinator_email_2 = $purifiedObj->getPurifyText($postArr['coordinator_email_2']);
                $model->description = $purifiedObj->getPurifyText($postArr['description']);
                if($login_role_id == 5){
                $model->parent_hosp_id = Yii::app()->user->id;
                }
                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                $model->emergency = $purifiedObj->getPurifyText($postArr['emergency']);


                if (!empty($postArr['opd_no']))
                    $model->opd_no = $purifiedObj->getPurifyText($postArr['opd_no']);

                if (!empty($postArr['blood_bank_no']))
                    $model->blood_bank_no = $purifiedObj->getPurifyText($postArr['blood_bank_no']);

                if (!empty($postArr['extra_charges']))
                    $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']);



                $model->free_opd_perday = $postArr['free_opd_perday'];

                $Daystr = NULL;
                if (isset($postArr['free_opd_preferdays']) && count($postArr['free_opd_preferdays']) > 0) {
                    foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                        $Daystr .= $value . ",";
                    }
                }
                $model->free_opd_preferdays = $Daystr;
                
                
                if (isset($postArr['payment_type'])) {
                    $model->payment_type = implode(",", $postArr['payment_type']);
                }


                $model->country_id = 1;
                $model->country_name = "India";
                $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
                $model->state_id = $purifiedObj->getPurifyText($postArr['state_id']);
                $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
                $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->area_id = $purifiedObj->getPurifyText($postArr['area_id']);
                $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
                $model->address = $purifiedObj->getPurifyText($postArr['address']);
                $model->latitude = $purifiedObj->getPurifyText($postArr['latitude']);
                $model->longitude = $purifiedObj->getPurifyText($postArr['longitude']);
                $model->created_date = date("Y-m-d H:i:s");
                $model->created_by = Yii::app()->user->id;

                if ($model->save()) {
                    $user_id = $model->user_id;



                    if (isset($_POST['UserDetails']['is_open_allday']) && $_POST['UserDetails']['is_open_allday'] == 'Y') {
                        $model->is_open_allday = 'Y';
                        $model->save();
                    } else {
                        if (isset($_POST['ClinicVisitingDetails'])) {
                            $selecteddays = $_POST['ClinicVisitingDetails'];

                            foreach ($selecteddays['day'] as $key => $value) {
                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = 0;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;
                                $ClinicVisitingDetails->clinic_open_time = (!empty($selecteddays['clinic_open_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_close_time = (!empty($selecteddays['clinic_close_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_eve_open_time =(!empty($selecteddays['clinic_eve_open_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_eve_close_time = (!empty($selecteddays['clinic_eve_close_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key])) : NULL;


                                if ($role == 6) {
                                    $ClinicVisitingDetails->role_type = 'pathology';
                                }
                                if ($role == 7) {
                                    $ClinicVisitingDetails->role_type = 'diagnostic';
                                }
                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving days");
                                }
                            }
                        }
                    }

                    if (isset($_POST['service'])) {
                        $serivceIdArr = array();
                        $serivceIdArr = $_POST['service'];

                        foreach ($serivceIdArr as $key => $value) {
                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $purifiedObj->getPurifyText($value);
                            $serviceUserMappingobj->user_id = $user_id;
                            $serviceUserMappingobj->service_discount = $_POST['service_discount'][$key];
                            $serviceUserMappingobj->corporate_discount = $_POST['corporate_discount'][$key];
                            $serviceUserMappingobj->is_available_allday = $_POST['twentyfour'][$key];
                            $serviceUserMappingobj->is_clinic = 0;

                            if (!$serviceUserMappingobj->save()) {

                                throw new Exception("Error in saving service user data");
                            }
                        }
                    }


                    if (isset($_POST['BankDetails'])) {
                        $bankdetailsArr = $_POST['BankDetails'];
                        $bank = new BankDetails;
                        $bank->user_id = $user_id;
                        $bank->acc_holder_name = $bankdetailsArr['acc_holder_name'];
                        $bank->bank_name = $bankdetailsArr['bank_name'];
                        $bank->branch_name = $bankdetailsArr['branch_name'];
                        $bank->account_no = $bankdetailsArr['account_no'];
                        $bank->account_type = $bankdetailsArr['account_type'];
                        $bank->ifsc_code = $bankdetailsArr['ifsc_code'];

                        if (!$bank->save()) {
                            
                        }
                    }


                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $profileDir = 'profilepic/';               //profilepic
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("M") . "/";
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }


                    $profileImageObj = CUploadedFile::getInstance($model, "profile_image");
                    if (!empty($_POST['profile'])) {
                        $imageName = time() . "_" . rand(111, 9999) . '.png';
                        $model->profile_image = $profileDir . $imageName;

                        if (file_put_contents($baseDir . $profileDir . $imageName, $data)) {
                            
                        }
                    }

                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    $docDir = 'document/';                                      //document
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("Y") . "/";                        //year
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("M") . "/";                        //month
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }


                    $photos = CUploadedFile::getInstancesByName('DocumentDetails[doc_photo]');
                    // proceed if the images have been set
                    if (isset($photos) && count($photos) > 0) {
                        foreach ($photos as $image => $pic) {
                            $docdetails = new DocumentDetails;
                            $path_part = pathinfo($pic->name);
                            $pic_name = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $docdetails->document = $pic_name;
                            $pic->saveAs($baseDir . $docdetails->document);
                            $docdetails->doc_type = 'Gallery_photos';
                            $docdetails->user_id = $user_id;
                            if ($docdetails->save()) {
                                
                            }
                        }
                    }

                    $docname = CUploadedFile::getInstance($model3, 'document');
                    if (!empty($docname)) {
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model3->document = $dname;
                        $docname->saveAs($baseDir . $model3->document);
                        if ($role == 6) {
                            $model3->doc_type = 'Pathology_Registration';
                        }
                        if ($role == 7) {
                            $model3->doc_type = 'Diagnostic_Registration';
                        }
                        $model3->user_id = $user_id;
                        if ($model3->save()) {
                            
                        }
                    }
                    $otherdoc = new DocumentDetails;
                    $otherdocname = CUploadedFile::getInstance($model3, 'otherdoc');
                    if (!empty($otherdocname)) {
                        $path_part = pathinfo($otherdocname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $otherdoc->document = $dname;
                        $otherdocname->saveAs($baseDir . $otherdoc->document);
                        if ($role == 6) {
                            $otherdoc->doc_type = 'Pathology_Oth_Registration';
                        }
                        if ($role == 7) {
                            $otherdoc->doc_type = 'Diagnostic_Oth_Registration';
                        }
                        $otherdoc->user_id = $user_id;
                        if ($otherdoc->save()) {
                            
                        }
                    }


                    $transaction->commit();
                    
                    if($login_role_id == 1){
                         $this->redirect(array('users/viewAllLab', 'id' => Yii::app()->getSecurityManager()->encrypt($user_id, $enc_key),'role'=>$role));
                    }else{
                    
                    $this->redirect(array('users/viewServices', 'id' => Yii::app()->getSecurityManager()->encrypt($user_id, $enc_key),'role'=>$role));
                    }
                }
//                if ($role == 6) {
//                    $this->redirect(array('users/viewpathology', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)));
//                }
//                if ($role == 7) {
//                    $this->redirect(array('users/viewDiagnostic', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)));
//                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('createAdminPathology', array('model' => $model, 'model1' => $model1, 'model3' => $model3, 'model7' => $model7, 'model6' => $model6, 'role' => $role,'login_role_id'=>$login_role_id));
    }

    /*
     * Update Admin_side Pathology Data
     * @author => Sagar Badgujar
     */

    public function actionUpdateAdminPathology($id, $role) {
        $this->layout = 'adminLayout';

        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));             //Userdetails
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        $model7 = BankDetails::model()->findByAttributes(array('user_id' => $id));
         $session = new CHttpSession;
        $session->open();
        $login_role_id = $session["user_role_id"];
        if (empty($model3)) {
            $model3 = new DocumentDetails;
        }
        if (empty($serviceUserMapping)) {
            $serviceUserMapping[] = new ServiceUserMapping;
        }
        if (empty($model7)) {
            $model7 = new BankDetails;
        }
          $data = "";
        if (isset($_POST['UserDetails'])) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;

                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = $role;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                //$model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password'])) {
                    $model->password = md5($postArr['password']);
                }
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                if (!empty($postArr['hos_establishment'])) {
                    $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
                 }


                $model->other_est_type = $postArr['other_est_type'];
                $model->apt_contact_no_1 = $purifiedObj->getPurifyText($postArr['apt_contact_no_1']);
                $model->apt_contact_no_2 = $purifiedObj->getPurifyText($postArr['apt_contact_no_2']);
                $model->email_1 = $purifiedObj->getPurifyText($postArr['email_1']);
                $model->email_2 = $purifiedObj->getPurifyText($postArr['email_2']);
                $model->coordinator_name_1 = $purifiedObj->getPurifyText($postArr['coordinator_name_1']);
                $model->coordinator_mobile_1 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_1']);
                $model->coordinator_email_1 = $purifiedObj->getPurifyText($postArr['coordinator_email_1']);
                $model->coordinator_name_2 = $purifiedObj->getPurifyText($postArr['coordinator_name_2']);
                $model->coordinator_mobile_2 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_2']);
                $model->coordinator_email_2 = $purifiedObj->getPurifyText($postArr['coordinator_email_2']);
                $model->description = $purifiedObj->getPurifyText($postArr['description']);

                $model->free_opd_perday = $postArr['free_opd_perday'];

                 if($login_role_id == 5){
                $model->parent_hosp_id = Yii::app()->user->id;
                }
                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                if (!empty($postArr['blood_bank_no']))
                    $model->blood_bank_no = $purifiedObj->getPurifyText($postArr['blood_bank_no']);  //Free/Charge
                if (!empty($postArr['extra_charges']))
                    $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']); //Exact charge

                $Daystr = NULL;
                if (isset($postArr['free_opd_preferdays']) && count($postArr['free_opd_preferdays']) > 0) {
                    foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                        $Daystr .= $value . ",";
                    }
                }
                $model->free_opd_preferdays = $Daystr;
                
                $paymentstr = NULL;
                        if ((!empty($postArr['payment_type']))) {

                            foreach ($postArr['payment_type'] as $key => $value) {
                                $paymentstr .= $value . ",";
                            }

                            $model->payment_type = $paymentstr;
                        }


                $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
                $model->state_id = $purifiedObj->getPurifyText($postArr['state_id']);
                $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
                $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->area_id = $purifiedObj->getPurifyText($postArr['area_id']);
                $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
                $model->address = $purifiedObj->getPurifyText($postArr['address']);
                $model->latitude = $purifiedObj->getPurifyText($postArr['latitude']);
                $model->longitude = $purifiedObj->getPurifyText($postArr['longitude']);
                $model->updated_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;

                if ($model->save()) {
                    $user_id = $model->user_id;


                    Yii::app()->db->createCommand()->delete('az_clinic_visiting_details', 'doctor_id=:id', array(':id' => $user_id));

                    if (isset($_POST['UserDetails']['is_open_allday']) && $_POST['UserDetails']['is_open_allday'] == 'Y') {
                        $model->is_open_allday = 'Y';
                        $model->save();
                    } else {
                        if (isset($_POST['ClinicVisitingDetails'])) {
                            $selecteddays = $_POST['ClinicVisitingDetails'];

                            if (!empty($selecteddays['day']) && count($selecteddays['day']) > 0) {
                                foreach ($selecteddays['day'] as $key => $value) {
                                    $ClinicVisitingDetails = new ClinicVisitingDetails;
                                    $ClinicVisitingDetails->clinic_id = 0;
                                    $ClinicVisitingDetails->doctor_id = $user_id;
                                    $ClinicVisitingDetails->day = $value;
                                     $ClinicVisitingDetails->clinic_open_time = (!empty($selecteddays['clinic_open_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_close_time = (!empty($selecteddays['clinic_close_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_eve_open_time =(!empty($selecteddays['clinic_eve_open_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_eve_close_time = (!empty($selecteddays['clinic_eve_close_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key])) : NULL;
                                    if ($role == 6) {
                                        $ClinicVisitingDetails->role_type = 'pathology';
                                    }
                                    if ($role == 7) {
                                        $ClinicVisitingDetails->role_type = 'diagnostic';
                                    }
                                    if (!$ClinicVisitingDetails->save()) {
                                        throw new Exception("Error in saving days");
                                    }
                                }
                                $model->is_open_allday = 'N';
                                $model->save();
                            }
                        }
                    }


                    Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'user_id=:id AND is_clinic=:isclinic', array(':id' => $user_id, ':isclinic' => '0'));

                    if (isset($_POST['service'])) {
                      //  $serivceIdArr = array();
                        $serivceIdArr = $_POST['service'];
                        //print_r($serivceIdArr);$_POST['service_discount'];
                        foreach ($serivceIdArr as $key => $value) {
                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $value;
                            $serviceUserMappingobj->user_id = $user_id;
                            $serviceUserMappingobj->service_discount = $_POST['service_discount'][$key];
                            $serviceUserMappingobj->corporate_discount = $_POST['corporate_discount'][$key];
                            $serviceUserMappingobj->is_available_allday = $_POST['twentyfour'][$key];
                            $serviceUserMappingobj->is_clinic = 0;
                           // print_r($_POST['service_discount'][$key]);exit;
                            if ($serviceUserMappingobj->save()) {}
                            else{
                                
                                throw new Exception("Error in saving service user data");
                            }
                        }
                    }

                    
                    if (isset($_POST['BankDetails'])) {
                        $bankdetailsArr = $_POST['BankDetails'];

                        $model7->user_id = $id;
                        $model7->acc_holder_name = $bankdetailsArr['acc_holder_name'];
                        $model7->bank_name = $bankdetailsArr['bank_name'];
                        $model7->branch_name = $bankdetailsArr['branch_name'];
                        $model7->account_no = $bankdetailsArr['account_no'];
                        $model7->account_type = $bankdetailsArr['account_type'];
                        $model7->ifsc_code = $bankdetailsArr['ifsc_code'];

                        if ($model7->save()) {
                            
                        }
                    }

                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $profileDir = 'profilepic/';               //profilepic
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }
                    $profileDir = $profileDir . date("M") . "/";
                    if (!is_dir($baseDir . $profileDir)) {
                        mkdir($baseDir . $profileDir);
                    }


                   if (!empty($_POST['profile'])) {
                        $imageName = time() . "_" . rand(111, 9999) . '.png';
                        
                        $model->profile_image = $profileDir . $imageName;
                       
                        if (file_put_contents($baseDir . $profileDir . $imageName, $data)) {
                           if ($model->save()) {
                               
                           }else{
                             //  print_r($model->getErrors());exit;
                           }
                            
                        }
                    } 


                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    $docDir = 'document/';                                      //document
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("Y") . "/";                        //year
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("M") . "/";                        //month
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }


                    $photos = CUploadedFile::getInstancesByName('DocumentDetails[doc_photo]');
                    // proceed if the images have been set
                    if (isset($photos) && count($photos) > 0) {
                        foreach ($photos as $image => $pic) {
                            $docdetails = new DocumentDetails;
                            $path_part = pathinfo($pic->name);
                            $pic_name = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $docdetails->document = $pic_name;
                            $pic->saveAs($baseDir . $docdetails->document);
                            $docdetails->doc_type = 'Gallery_photos';
                            $docdetails->user_id = $user_id;
                            if ($docdetails->save()) {
                                
                            }
                        }
                    }

                    $docname = CUploadedFile::getInstance($model3, 'document');
                    if (!empty($docname)) {
                        $model3 = new DocumentDetails;
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model3->document = $dname;
                        $docname->saveAs($baseDir . $model3->document);
                        if ($role == 6) {
                            $model3->doc_type = 'Pathology_Registration';
                        }
                        if ($role == 7) {
                            $model3->doc_type = 'Diagnostic_Registration';
                        }
                        $model3->user_id = $user_id;
                        if ($model3->save()) {
                            
                        }
                    }
                    $otherdoc = new DocumentDetails;
                    $otherdocname = CUploadedFile::getInstance($model3, 'otherdoc');
                    if (!empty($otherdocname)) {
                        $path_part = pathinfo($otherdocname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $otherdoc->document = $dname;
                        $otherdocname->saveAs($baseDir . $otherdoc->document);
                        if ($role == 6) {
                            $otherdoc->doc_type = 'Pathology_Oth_Registration';
                        }
                        if ($role == 7) {
                            $otherdoc->doc_type = 'Diagnostic_Oth_Registration';
                        }
                        $otherdoc->user_id = $user_id;
                        if ($otherdoc->save()) {
                            
                        }
                    }
                    $transaction->commit();
                    Yii::app()->user->setFlash('Success', 'You have successfully Updated Profile');
                    if($login_role_id == 1){
                        $this->redirect(array('users/viewAllLab', 'id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key),'role'=>$role));
                    }else{
                    $this->redirect(array('users/viewServices', 'id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key),'role'=>$role));
                    }
                }
                //}
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('updateAdminPathology', array('id' => $id, 'model' => $model, 'serviceUserMapping' => $serviceUserMapping, 'model3' => $model3, 'model7' => $model7, 'role' => $role,'login_role_id'=>$login_role_id));
    }

    /*
     * Update Pathology Data
     * @author => Sagar Badgujar
     */

    public function actionUpdatePathology() {
        $enc_key = Yii::app()->params->enc_key;
        // $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $id = Yii::app()->user->id;
        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));             //Userdetails
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        $model7 = BankDetails::model()->findByAttributes(array('user_id' => $id));

        if (empty($model3)) {
            $model3 = new DocumentDetails;
        }
        if (empty($serviceUserMapping)) {
            $serviceUserMapping[] = new ServiceUserMapping;
        }
        if (empty($model7)) {
            $model7 = new BankDetails;
        }
       
        if (isset($_POST['UserDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;



                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = 6;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                //  $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password']))
                    $model->password = md5($postArr['password']);
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                
                if (!empty($postArr['hos_establishment']))
                    $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
//                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
//                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
                $model->apt_contact_no_1 = $purifiedObj->getPurifyText($postArr['apt_contact_no_1']);
                $model->apt_contact_no_2 = $purifiedObj->getPurifyText($postArr['apt_contact_no_2']);
                $model->email_1 = $purifiedObj->getPurifyText($postArr['email_1']);
                $model->email_2 = $purifiedObj->getPurifyText($postArr['email_2']);
                $model->coordinator_name_1 = $purifiedObj->getPurifyText($postArr['coordinator_name_1']);
                $model->coordinator_mobile_1 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_1']);
                $model->coordinator_email_1 = $purifiedObj->getPurifyText($postArr['coordinator_email_1']);
                $model->coordinator_name_2 = $purifiedObj->getPurifyText($postArr['coordinator_name_2']);
                $model->coordinator_mobile_2 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_2']);
                $model->coordinator_email_2 = $purifiedObj->getPurifyText($postArr['coordinator_email_2']);
                $model->description = $purifiedObj->getPurifyText($postArr['description']);
                $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
                $model->state_id = $purifiedObj->getPurifyText($postArr['state_id']);
                $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
                $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->area_id = $purifiedObj->getPurifyText($postArr['area_id']);
                $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
                $model->address = $purifiedObj->getPurifyText($postArr['address']);
                $model->latitude = $postArr['latitude'];
                $model->longitude = $postArr['longitude'];
                $model->free_opd_perday = $purifiedObj->getPurifyText($postArr['free_opd_perday']);


                $Daystr = NULL;
                if (isset($postArr['free_opd_preferdays']) && count($postArr['free_opd_preferdays']) > 0) {
                    foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                        $Daystr .= $value . ",";
                    }
                }
                $model->free_opd_preferdays = $Daystr;

                  $paymentstr = NULL;
                        if ((!empty($postArr['payment_type']))) {

                            foreach ($postArr['payment_type'] as $key => $value) {
                                $paymentstr .= $value . ",";
                            }

                            $model->payment_type = $paymentstr;
                        }
                
                

                $model->updated_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;

                if ($model->save()) {
                    $user_id = $model->user_id;


                    Yii::app()->db->createCommand()->delete('az_clinic_visiting_details', 'doctor_id=:id', array(':id' => $user_id));

                    if (isset($_POST['UserDetails']['is_open_allday']) && $_POST['UserDetails']['is_open_allday'] == 'Y') {
                        $model->is_open_allday = 'Y';
                        $model->save();
                    } else {
                        if (isset($_POST['ClinicVisitingDetails'])) {
                            $selecteddays = $_POST['ClinicVisitingDetails'];

                            foreach ($selecteddays['day'] as $key => $value) {
                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = 0;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;

                                $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key]));
                                $ClinicVisitingDetails->role_type = 'pathology';
                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving days");
                                }
                            }
                            $model->is_open_allday = 'N';
                            $model->save();
                        }
                    }


                    Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'user_id=:id AND is_clinic=:isclinic', array(':id' => $user_id, ':isclinic' => '0'));

                    if (isset($_POST['service'])) {
                        $serivceIdArr = array();
                        $serivceIdArr = $_POST['service'];

                        foreach ($serivceIdArr as $key => $value) {
                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $purifiedObj->getPurifyText($value);
                            $serviceUserMappingobj->user_id = $user_id;
                            $serviceUserMappingobj->service_discount = $_POST['service_discount'][$key];
                            $serviceUserMappingobj->corporate_discount = $_POST['corporate_discount'][$key];
                            $serviceUserMappingobj->is_available_allday = $_POST['twentyfour'][$key];
                            $serviceUserMappingobj->is_clinic = 0;

                            if (!$serviceUserMappingobj->save()) {

                                throw new Exception("Error in saving service user data");
                            }
                        }
                    }


                    if (isset($_POST['BankDetails'])) {
                        $bankdetailsArr = $_POST['BankDetails'];

                        $model7->user_id = $id;
                        $model7->acc_holder_name = $bankdetailsArr['acc_holder_name'];
                        $model7->bank_name = $bankdetailsArr['bank_name'];
                        $model7->branch_name = $bankdetailsArr['branch_name'];
                        $model7->account_no = $bankdetailsArr['account_no'];
                        $model7->account_type = $bankdetailsArr['account_type'];
                        $model7->ifsc_code = $bankdetailsArr['ifsc_code'];

                        if ($model7->save()) {
                            
                        }
                    }

                    $baseDir = Yii::app()->basePath . "/../uploads/";


                    $profileImageObj = CUploadedFile::getInstance($model, "profile_image");

                    if (!empty($profileImageObj)) {
                        if (!is_dir($baseDir)) {
                            mkdir($baseDir);
                        }
                        $profileDir = 'profilepic/';               //profilepic
                        if (!is_dir($baseDir . $profileDir)) {
                            mkdir($baseDir . $profileDir);
                        }
                        $profileDir = $profileDir . date("Y") . "/";                      //year
                        if (!is_dir($baseDir . $profileDir)) {
                            mkdir($baseDir . $profileDir);
                        }
                        $profileDir = $profileDir . date("M") . "/";
                        if (!is_dir($baseDir . $profileDir)) {
                            mkdir($baseDir . $profileDir);
                        }



                        $path_part = pathinfo($profileImageObj->name);
                        $fname = $profileDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model->profile_image = $fname;
                        if ($profileImageObj->saveAs($baseDir . $model->profile_image)) {
                            $model->save();
                        }
                    }

                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    $docDir = 'document/';                                      //document
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("Y") . "/";                        //year
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("M") . "/";                        //month
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }


                    $photos = CUploadedFile::getInstancesByName('DocumentDetails[doc_photo]');
                    // proceed if the images have been set
                    if (isset($photos) && count($photos) > 0) {
                        foreach ($photos as $image => $pic) {
                            $docdetails = new DocumentDetails;
                            $path_part = pathinfo($pic->name);
                            $pic_name = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $docdetails->document = $pic_name;
                            $pic->saveAs($baseDir . $docdetails->document);
                            $docdetails->doc_type = 'Gallery_photos';
                            $docdetails->user_id = $user_id;
                            if ($docdetails->save()) {
                                
                            }
                        }
                    }
                    $model3 = new DocumentDetails;
                    $docname = CUploadedFile::getInstance($model3, 'document');
                    if (!empty($docname)) {
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model3->document = $dname;
                        $docname->saveAs($baseDir . $model3->document);
                        $model3->doc_type = 'Pathology_Registration';
                        $model3->user_id = $user_id;
                        if ($model3->save()) {
                            
                        }
                    }
                    $otherdoc = new DocumentDetails;
                    $otherdocname = CUploadedFile::getInstance($model3, 'otherdoc');
                    if (!empty($otherdocname)) {
                        $path_part = pathinfo($otherdocname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $otherdoc->document = $dname;
                        $otherdocname->saveAs($baseDir . $otherdoc->document);
                        $otherdoc->doc_type = 'Pathology_Oth_Registration';
                        $otherdoc->user_id = $user_id;
                        if ($otherdoc->save()) {
                            
                        }
                    }


                    $transaction->commit();

                    Yii::app()->user->setFlash('Success', 'You have successfully Updated Your Profile');
                    $this->redirect(array('site/labViewAppointment', 'roleid' => $model->role_id));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('UpdatePathology', array('id' => $id, 'model' => $model, 'serviceUserMapping' => $serviceUserMapping, 'model3' => $model3, 'model7' => $model7));
    }

    public function actionManageInactiveHospital() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('searchInactiveHospial');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageInactiveHospital', array(
            'model' => $model,
        ));
    }

    public function actionManageInactiveDoctor() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('search');
        $model->unsetAttributes();                                              // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageInactiveDoctor', array(
            'model' => $model,
        ));
    }

    public function actionManageInactiveHospitalDoctor($param1) {
        $this->layout = 'adminLayout';
        $hospId = base64_decode($param1);
        $model = new UserDetails('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageInactiveHospitalDoctor', array(
            'model' => $model, 'hospId' => $hospId
        ));
    }

    public function actionManageInactivePathology() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('searchInactivePathology');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageInactivePathology', array(
            'model' => $model,
        ));
    }

    public function actionManageInactivePatient() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('searchInactivePatient');
        $model->unsetAttributes();                                              // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageInactivePatient', array(
            'model' => $model,
        ));
    }

    public function actionGetPatientRequest() {
        $session = new CHttpSession;
        $session->open();
        $id = $session["user_id"];

        $PatientInfoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_user_details ")
                ->where(" role_id=4 And user_id=$id ")
                ->queryRow();

        $appArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_appointment_payment_table ")
                ->where(" patient_id=$id ")
                ->queryAll();

        //print_r($appArr);


        $this->render('patient_app_request', array('PatientInfoArr' => $PatientInfoArr));
    }

    public function actionCorporatePatient() {

        $this->layout = 'adminLayout';
        $model = new UserDetails('searchCororate');
        $model->unsetAttributes();                         // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('adminCorporatePatient', array(
            'model' => $model,
        ));
    }

    public function actionUpdateAdminCorporate($id) {

        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $userid = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        
        $commonObj = new CommonFunction();
        $model = new UserDetails;
        if (isset($_POST['UserDetails'])) {
            $xls_file = CUploadedFile::getInstance($model, 'tmp_file');
            $baseUrl = Yii::app()->request->baseUrl;

            $resultArr = $commonObj->excelSheetReader($xls_file->tempName);
            $cusCount = count($resultArr);
            $succesCount = 0;
            try {
                $transaction = Yii::app()->db->beginTransaction();
                foreach ($resultArr as $customer) {
                    $model = new UserDetails;
                    $model->role_id = 4;
                    $model->is_active = 1;
                    $model->patient_type = 'Corporate';
                    $model->first_name = $customer['Employee first Name'];
                    $model->last_name = $customer['Employee last Name'];

                    if (!empty($customer['Mobile No.']))
                        $model->mobile = $customer['Mobile No.'];
                    $model->password = md5('test');

                    if (!empty($customer['DOB/ Age']))
                        $model->age = $customer['DOB/ Age'];
                    if (!empty($customer['M/ F']))
                        $model->gender = $customer['M/ F'];
                    if (!empty($customer['Blood Group']))
                        $model->blood_group = $customer['Blood Group'];

                    if (!empty($customer['Emergency Contact No. ']))
                        $model->emergency_no_1 = $customer['Emergency Contact No. '];
                    if (!empty($customer['Emergency contact no. 2']))
                        $model->emergency_no_2 = $customer['Emergency contact no. 2'];
                    if (!empty($customer['Address']))
                        $model->address = $customer['Address'];
                    if (!empty($customer['City']))
                        $model->city_name = $customer['City'];

                    $model->parent_hosp_id = $userid;

                    $model->created_date = date("Y-m-d H:i:s");
                    $model->created_by = Yii::app()->user->id;


                    if ($model->save()) {
                        $user_id = $model->user_id;
                        $model1 = new BankDetails();
                        if (!empty($customer['Bank Account No. for Cash-back'])) {
                            $model1->user_id = $user_id;
                            $fullname =  $customer['Employee first Name'].' '.$customer['Employee last Name'];
                            $model1->acc_holder_name = $fullname;
                            // $model1->gender= $customer['Aadhar no.'];
//                                    $model1->gender= $customer['Pan No.'];
                            $model1->account_no = $customer['Bank Account No. for Cash-back'];
                            $model1->ifsc_code = $customer['Bank IFSC Code'];
                            $model1->bank_name = $customer['Bank Name'];
                            $model1->branch_name = $customer['Branch Name'];
                            $model1->account_type = $customer['Account Type'];
                            $model1->save();
                        }
                    } 
                }
                $transaction->commit();
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('update_admin_corporate', array(
            'model' => $model
        ));
    }

    public function actionCorporateList() {
        $this->layout = 'adminLayout';
        $session = new CHttpSession;
        $session->open();
        $id = $session["user_id"];
        $roleid = $session["user_role_id"];
        $model = new UserDetails;
        $PatientInfoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_user_details ")
                ->where(" parent_hosp_id=$id")
                ->queryAll();
        // print_r($PatientInfoArr);

        $this->render('corporateList', array(
            'id' => $id, 'PatientInfoArr' => $PatientInfoArr, 'roleid' => $roleid, 'model' => $model
        ));
    }
    
    
    public function actionGetPendingRequest(){
         $session = new CHttpSession;
        $session->open();
        $id = $session["user_id"];

        $PatientInfoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_user_details ")
                ->where(" role_id=4 And user_id= $id ")
                ->queryRow();

        $appArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_aptmt_query ")
                ->where(" created_by = ".$id." And apt_confirm = 'No' ")
                ->queryAll();

        


        $this->render('pending_request', array('PatientInfoArr' => $PatientInfoArr,'appArr'=>$appArr));
    }

}

//UPDATE az_clinic_visiting_details SET day = 'Monday' where day ='mon';
//UPDATE az_clinic_visiting_details SET day = 'Tuesday' where day ='tue';
//UPDATE az_clinic_visiting_details SET day = 'Wednesday' where day ='wed';
//UPDATE az_clinic_visiting_details SET day = 'Thursday' where day ='thur';
//UPDATE az_clinic_visiting_details SET day = 'Friday' where day ='fri';
//UPDATE az_clinic_visiting_details SET day = 'Saturday' where day ='sat';
//UPDATE az_clinic_visiting_details SET day = 'Sunday' where day ='sun';

//UPDATE az_clinic_visiting_details SET role_type = 'Medical' WHERE role_type = 'Blood-Bank';
//UPDATE az_clinic_visiting_details SET role_type = 'doctor' WHERE role_type = 'clinic' AND clinic_id = 0;