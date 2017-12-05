<?php

header("Access-Control-Allow-Origin: *");

class SiteController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('contact', 'login', 'logout', 'appointmentDetails', 'details', 'getAllName', 'getInfoDoctor', 'getInfoSpeciality', 'patientDetail', 'getPatientDetails', 'confirm', 'verifyOtp', 'getSearchData', 'getSearchLocation', 'setSessionCity', 'docHosLogin', 'doctorDetails', 'getLocationName', 'searchResult', 'getHospitalId', 'getLogin', 'docViewAppointment', 'index', 'error', 'hosViewAppointment', 'hospitalDoctorList', 'addNotification', 'check_Mobile', 'hospitalList', 'serchPatient', 'getSpecialityData', 'pathologyList', 'detailsOther', 'shareProfile', 'addRating', 'specialityList', 'labTestBook', 'getHospitalPatientDetails', 'bookappoint', 'confirmappointment', 'forgotPassword', 'verifyOtpPanel', 'confirmPassword', 'getHospitalAppointment', 'ambulanceList', 'getappointpayment', 'getSelectedAptTime', 'labViewAppointment', 'checkpromocode', 'listDocAppointment', 'dailyFreeOffer', 'dataFromLocation', 'savePromoCode', 'treatmentDetails', 'listLabAppointment', 'confirmLabTest', 'shareProfileLogin', 'getDeliveryCharges', 'medicalPayment', 'listOfServices','chklabTestBook'),
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

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
// captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
// They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
// renders the view file 'protected/views/site/index.php'
// using the default layout 'protected/views/layouts/main.php'


        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {

        $model = new LoginForm;


// if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array("index"));
        }
// collect user input data
        if (isset($_POST['username']) && isset($_POST['password'])) {

            $returnOutputArr = array();
            $username = Yii::app()->request->getParam('username');
            $password = Yii::app()->request->getParam('password');
            $purifiedObj = Yii::app()->purifier;
            $model->username = $purifiedObj->getPurifyText($username);
            $model->password = $purifiedObj->getPurifyText($password);
            if (isset($_POST['rememberMe']) && $_POST['rememberMe'] != 0) {
                $model->rememberMe = 1;
            }
            try {
// validate user input and redirect to the previous page if valid
                if ($model->validate() && $model->login()) {
                    $session = new CHttpSession;
                    $session->open();
                    $returnOutputArr['isError'] = false;
                    $returnOutputArr['var1'] = $session["user_role_id"];

//$roleId = $session['user_role_id'];
                } else {
                    throw new Exception("Invalid User Name and Password");
                }
            } catch (Exception $e) {
                $returnOutputArr['isError'] = true;
                $returnOutputArr['errorMsg'] = $e->getMessage();
            }

            echo json_encode(array('data' => $returnOutputArr));
            Yii::app()->end();
        }
// display the login form
        $this->renderPartial('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionAppointmentDetails() {

        $model = new LoginForm();
        $reqObj = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;
        $model->username = $purifiedObj->getPurifyText($reqObj->getParam("name"));

        echo json_encode($model->username);
        $this->render('appointmentDetails', array('model' => $model));
    }

    public function actionDetails($param1, $param2) {
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($param1, $enc_key);
        $clinicid = Yii::app()->getSecurityManager()->decrypt($param2, $enc_key);
        $action = $param = "";
        if (isset($_GET['action'])) {
            $action = Yii::app()->request->getParam("action");
            $param = Yii::app()->request->getParam("param");
        }
        $user = Yii::app()->db->createCommand()
                ->select('*')
                ->from('az_user_details')
                ->where('user_id=:id', array(':id' => $id))
                ->queryRow();
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
        } elseif ($user['role_id'] == 3 && !empty($user['parent_hosp_id'])) {
            $hospital = Yii::app()->db->createCommand()->select('hospital_name,hos_establishment,is_open_allday,hospital_open_time,hospital_close_time')->from('az_user_details')->where('user_id=:id', array(':id' => $user['parent_hosp_id']))->queryRow();
            if (!empty($hospital)) {
                $user['clinic_name'] = $hospital['hospital_name'];
                $user['hos_establishment'] = $hospital['hos_establishment'];
                $user['is_open_allday'] = $hospital['is_open_allday'];
                $user['hospital_open_time'] = $hospital['hospital_open_time'];
                $user['hospital_close_time'] = $hospital['hospital_close_time'];
            }
        }
        $this->render('details', array('user_details' => $user, 'id' => $id, 'clinicid' => $clinicid, "action" => $action, "param" => $param));
    }

    public function actionGetAllName() {               //To find specific doctor name from search panel
        $request = Yii::app()->request;
        $hname = $request->getParam('hname');
        $doctorarr = Yii::app()->db->createCommand()
                ->select('first_name,user_id')
                ->from('az_user_details')
                ->where("role_id=3 AND first_name LIKE '%$hname%'")
                ->queryAll();
        echo json_encode(array('data' => $doctorarr));
    }

    public function actionGetInfoDoctor() {              //To Find specific doctor information
        $request = Yii::app()->request;
        $userid = $request->getParam('userid');
        $clinic = $request->getParam('clinic');
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->encrypt($userid, $enc_key);
        $clinicid = Yii::app()->getSecurityManager()->encrypt($clinic, $enc_key);
        echo json_encode(array("id" => urlencode($id), "clinicid" => urlencode($clinicid)));
    }

    public function actionGetInfoSpeciality() {    //To find secific speciality
        $request = Yii::app()->request;
        $speciality = $request->getParam('speciality');


        $specialityarr = Yii::app()->db->createCommand()
                ->select('ud.user_id')
                ->from('az_user_details ud')
                ->join('az_hospital_speciality hs', 'hs.user_id=ud.user_id')
                ->where('ud.role_id=5 and hs.speciality_name=:speciality', array(':speciality' => $speciality))
                ->queryAll();

        echo json_encode(array('data' => $specialityarr));
    }

    public function actionPatientDetail() {
        $session = new CHttpSession;
        $session->open();
        $role_id = $session["user_role_id"];


        $model = new PatientAppointmentDetails;
        $commonobj = new CommonFunction;
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->user->id;
        $doctorModel = Yii::app()->db->createCommand()->select("parent_hosp_id,hospital_name")->from("az_user_details")->where("user_id = :id", array(":id" => $id))->queryRow();
        //$id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $request = Yii::app()->request;
        $patientid = "";
        $patientinfo = array();
        if (isset($_GET['id'])) {
            $patientid = Yii::app()->request->getParam('id');

            $date = date('Y-m-d');
            $patientinfo = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('az_aptmt_query')
                    ->Where('apt_confirm =:confirm AND id=:userid', array(':userid' => $patientid, ':confirm' => 'No'))
                    ->andwhere('preferred_day >=:date', array(':date' => $date))
                    ->queryRow();
            $patientid = $patientinfo['created_by'];
            $model->patient_id = $patientid;
            $model->patient_name = $patientinfo['patient_name'];
            $model->patient_mobile = $patientinfo['patient_mobile'];
            $model->doc_fees = $patientinfo['apt_fees'];
            $model->type_of_visit = $patientinfo['type_of_visit'];
            //$model->patient_mobile = $patientinfo['creator_number'];
            $model->appointment_date = date("d-m-Y", strtotime($patientinfo['preferred_day']));
            $model->promo_id = $patientinfo['promo_id'];
            if (!empty($patientinfo['clinic_id'])) {
                $model->hospital_id = $patientinfo['clinic_id'];
                $model->is_clinic = 'Y';
            }
        }


        if (isset($_POST['PatientAppointmentDetails'])) {

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;


                $model->attributes = $_POST['PatientAppointmentDetails'];
                $postArr = $request->getPost("PatientAppointmentDetails");
                $pmobile = $postArr['patient_mobile'];

                $model->patient_name = $_POST['PatientAppointmentDetails']['patient_name'];
                $model->patient_mobile = $_POST['PatientAppointmentDetails']['patient_mobile'];
                $model->day = $postArr['day'];
                $model->created_date = date('Y-m-d H:i:s');
                $model->updated_date = date('Y-m-d H:i:s');
                $model->doctor_id = $id;
                $model->hospital_id = $postArr['hospital_id'];
                $model->is_clinic = $postArr['is_clinic'];
                $model->enquiry_id = $postArr['pid'];
                $model->doc_fees = $postArr['doc_fees'];

                if (!empty($patientinfo['clinic_id'])) {
                    $model->hospital_id = $patientinfo['clinic_id'];
                    $model->is_clinic = 'Y';
                }

                $patientidArr = Yii::app()->db->createCommand()
                        ->select('user_id')
                        ->from('az_user_details')
                        ->where('mobile=:mobile', array(':mobile' => $pmobile))
                        ->queryRow();

                $model->patient_id = $patientid;

                if (!empty($postArr['time'])) {

                    $to = $_POST['from'];
                    $from = $postArr['time'];
                    $time = $from . ' To ' . $to;
                    $model->time = $time;
                }
                if (!empty($postArr['appointment_date'])) {

                    $appointmentdate = date("Y-m-d", strtotime($postArr['appointment_date']));
                    $model->appointment_date = $appointmentdate;
                }
                if (!empty($postArr['type_of_visit'])) {
                    $model->type_of_visit = $postArr['type_of_visit'];
                }
                if ($model->save()) {

                    $eid = $model->enquiry_id;
                    $time = $postArr['time'];
                    if (!empty($eid)) {
                        Yii::app()->db->createCommand()->update('az_aptmt_query', array(
                            'apt_confirm' => 'Yes',
                                ), 'id=:id', array(':id' => $eid));
                    }

//                    $DrName = Yii::app()->db->createCommand()
//                        ->select('first_name,last_name')
//                        ->from('az_user_details')
//                        ->where('user_id=:user_id', array(':user_id' => $id))
//                        ->queryRow();
//                    print_r($DrName);
//                    echo $DrName['first_name'].$DrName['last_name'];exit;

                    $transaction->commit();
                    $commonobj->sendSms($pmobile, "Reminder: Your appointment time $time.  Pl ensure to be on time for best services.
");
//                    Your doctor appointment is on $time dt. $DrName['first_name'].$DrName['last_name']. Pl ensure to be on time, else communicate any change well before. Thank you.

                    Yii::app()->user->setFlash('Success', 'Appointment successfully Scheduled');
                    $this->redirect(array("docViewAppointment"));
                } else {
                    //print_r($model->getErrors());
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());

                $transaction->rollback();
            }
        }

        $this->render('patientdetail', array('model' => $model, 'id' => $id, 'doctorModel' => $doctorModel, 'patientid' => $patientid, 'role_id' => $role_id));
    }

    public function actionGetPatientDetails() {

        $session = new CHttpSession;
        $session->open();
        $role_id = $session["user_role_id"];
        // $parent_hos_id=$session[""];
        $request = Yii::app()->request;
        $mobilenumber = $request->getParam('mobile');
        $userid = $request->getParam('userid');
		$is_clinic = $request->getParam('is_clinic');
		$hospitalid = $request->getParam('hospitalid');
        $date = date('Y-m-d');
		$cmd = array();
        if ($role_id == 3 || $role_id == 5) {
            $result = Yii::app()->db->createCommand()
                    ->select('`id`, `is_patient`, `patient_name`, `patient_mobile`, `creator_number`, `relationship`, `type_of_visit`, `apt_fees`, `mode_of_pay`, `created_by`, `created_date`, `doctor_id`, `clinic_id`, `apt_confirm`, `promo_id`,DATE_FORMAT(preferred_day, "%d-%c-%Y") as preferred_day')
                    ->from('az_aptmt_query')
                    ->Where('patient_mobile=:mobile AND doctor_id=:userid ', array(':mobile' => $mobilenumber, ':userid' => $userid))
                    ->andWhere('apt_confirm = :confirm ', array(':confirm' => 'No'))
                    ->queryAll();
            //  print_r($cmd);
            if (empty($result)) {
				$queryresult = "";
                if ($is_clinic == "Y") {
					$queryresult = Yii::app()->db->createCommand()->select('user_id,CONCAT( first_name," ",last_name) AS patient_name,mobile as patient_mobile,(select opd_consultation_fee from az_clinic_details where doctor_id='.$userid.' AND clinic_id = '.$hospitalid.') as apt_fees')
					->from('az_user_details')->where('role_id= 4 and mobile=:mobile',array(':mobile' => $mobilenumber))
					->queryAll();
                } else {
					$queryresult = Yii::app()->db->createCommand()->select('user_id,CONCAT( first_name," ",last_name) AS patient_name,mobile as patient_mobile,(select doctor_fees from az_user_details where user_id='.$userid.' ) as apt_fees')
					->from('az_user_details')->where('role_id= 4 and mobile=:mobile',array(':mobile' => $mobilenumber))
					->queryAll();
                }
				$cmd['source'] = "exist";
				$cmd['resultset'] = $queryresult;
            }else{
				$cmd['source'] = "query";
				$cmd['resultset'] = $result;
			}

        }
        if ($role_id == 6 || $role_id == 7) {
            $cmd = Yii::app()->db->createCommand()
                    ->select('first_name,last_name,mobile,age')
                    ->from('az_user_details')
                    ->Where('mobile=:mobile ', array(':mobile' => $mobilenumber))
                    // ->andWhere('apt_confirm = :confirm && created_date >= :date ', array(':confirm' => 'No', ':date' => $date))
                    ->queryAll();
        }

        echo json_encode(array('data' => $cmd));
    }

    public function actionGetHospitalPatientDetails() {

        $request = Yii::app()->request;
        $mobilenumber = $request->getParam('mobile');
        $userid = $request->getParam('userid');

        $cmd = Yii::app()->db->createCommand()
                ->select('*')
                ->from('az_aptmt_query')
                ->Where('patient_mobile=:mobile', array(':mobile' => $mobilenumber))
                ->queryAll();

        echo json_encode(array('data' => $cmd));
    }

    public function actionConfirm() {
        $model = new UserDetails('Register');
        $model->scenario = 'formSubmit';
        $returnOutputArr = array();
        try {
            if (isset($_POST['password']) && isset($_POST['mobile'])) {

                $purifiedObj = Yii::app()->purifier;
                $commonobj = new CommonFunction;
                $firstname = Yii::app()->request->getParam('firstname');

                $lastname = Yii::app()->request->getParam('lastname');
                $mobile = Yii::app()->request->getParam('mobile');
                $password = Yii::app()->request->getParam('password');
                $patienttype = Yii::app()->request->getParam('patient');
                $role = Yii::app()->request->getParam('role');
                $company_name = Yii::app()->request->getParam('company_name');

                $mobilenoArr = Yii::app()->db->createCommand()
                        ->select('mobile')
                        ->from('az_user_details')
                        ->where('mobile=:mobile', array(':mobile' => $mobile))
                        ->queryRow();

                if (empty($mobilenoArr['mobile'])) {

                    $model->first_name = $purifiedObj->getPurifyText($firstname);
                    $model->last_name = $purifiedObj->getPurifyText($lastname);
                    $model->mobile = $purifiedObj->getPurifyText($mobile);
                    $model->patient_type = $purifiedObj->getPurifyText($patienttype);
                    $model->password = $purifiedObj->getPurifyText($password);
                    $model->vip_role = $purifiedObj->getPurifyText($role);
                    $model->company_name = $purifiedObj->getPurifyText($company_name);

                    if (!empty($model->password)) {
                        $model->password = md5($model->password);
                    }

                    $session = new CHttpSession;
                    $session->open();

                    $session['rFirName'] = $model->first_name;
                    $session['rLastName'] = $model->last_name;
                    $session['rMobile'] = $model->mobile;
                    $session['rPassword'] = $model->password;
                    $session['rpatienttype'] = $model->patient_type;
                    $session['rrole'] = $model->vip_role;

                    $session['rcompany'] = $model->company_name;
                    $otp = rand(111111, 999999);


                    $session['rOtp'] = $otp;
                    $commonobj->sendSms($mobile, "$otp is your OTP verification code for A2zhelthplus");
                    $returnOutputArr['isError'] = false;
                    $returnOutputArr['otp'] = $otp;
                } else {
                    throw new Exception("You Are Already Member");
                }
            }
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;

            $returnOutputArr['errorMsg'] = $e->getMessage();
        }

        echo json_encode(array('result' => $returnOutputArr));
    }

    public function actionVerifyOtp() {
        $model = new UserDetails('Register');
        $model->scenario = 'formSubmit';
        $purifiedObj = Yii::app()->purifier;
        $returnOutputArr = array();
        try {
            $transaction = Yii::app()->db->beginTransaction();
            if (isset($_POST['otpval'])) {

                $session = new CHttpSession;
                $session->open();

                $sendotp = $_POST['otpval'];
                if ($sendotp !== NULL) {

                    if ($sendotp == $session['rOtp']) {
                        // if ($sendotp == $sendotp) {

                        $model->first_name = $purifiedObj->getPurifyText($session['rFirName']);
                        $model->last_name = $purifiedObj->getPurifyText($session['rLastName']);
                        $model->mobile = $purifiedObj->getPurifyText($session['rMobile']);
                        $model->password = $purifiedObj->getPurifyText($session['rPassword']);
                        $model->vip_role = $purifiedObj->getPurifyText($session['rrole']);
                        $model->company_name = $purifiedObj->getPurifyText($session['rcompany']);
                        $model->patient_type = $purifiedObj->getPurifyText($session['rpatienttype']);
                        $model->created_date = date('Y-m-d H:i:s');
                        $model->is_active = 1;
                        if ($session['rpatienttype'] == 'Corporate') {
                            $model->role_id = 11;
                        } else {
                            $model->role_id = 4;
                        }
                        if ($model->save()) {
                            $transaction->commit();
                            unset($session['rFirName']);
                            unset($session['rLastName']);
                            unset($session['rMobile']);
                            unset($session['rPassword']);
                            unset($session['rrole']);
                            unset($session['rcompany']);
                            unset($session['rpatienttype']);
                            unset($session['rOtp']);
                        }
                    } else {

                        $returnOutputArr['isError'] = false;
                        throw new Exception("Invalid OTP.");
                    }
                } else {

                    throw new Exception("Mobile Number not registered.");
                }
            }
        } catch (Exception $ex) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $ex->getMessage();
            $transaction->rollback();
        }
        echo json_encode(array('data' => $returnOutputArr));
    }

    /*
     * param : @term : term to be search, @location
     * return json with matched records
     * author: suchit dalvi
     */

    public function actionGetSearchData() {
        $purifiedObj = Yii::app()->purifier;
        $Speciality = SpecialityMaster::model()->findAll();
        $SpecialityArr = CHtml::listData($Speciality, "speciality_id", "speciality_name");
        $returnOutputArr = array();
        try {
            if (isset($_GET['term']) && !empty($_GET['term'])) {
                $serviceArr = array("6" => "Pathology","7" => "Diagnostic","8" => "Blood Bank","9" => "Medical Store");
                $term = Yii::app()->request->getParam('term');
                $location = Yii::app()->request->getParam('location');
                $is_city = Yii::app()->request->getParam('is_city');

                $term = $purifiedObj->getPurifyText($term);
                $location = $purifiedObj->getPurifyText($location);
                $is_city = $purifiedObj->getPurifyText($is_city);
                $addCondition = "";
                if (!empty($location)) {
                    if ($is_city == "Y") {
                        $addCondition = " AND (t.city_name ='$location' OR cd.city_name ='$location') ";
                    } else {
                        $addCondition = " AND (t.area_name ='$location' OR cd.area_name='$location')";
                    }
                }
                foreach ($SpecialityArr as $spe) {
                    if (stripos($spe, $term) !== false) {
                        $returnOutputArr[] = array("value" => $spe, "label" => $spe, "category" => "speciality");
                    }
                }
                if (stripos("Hospital", $term) !== false) { //all hospital
                    $returnOutputArr[] = array("value" => "Hospital", "label" => "Hospital", "category" => "type");
                }
                foreach ($serviceArr as $key => $ser) {
                    if (stripos($ser, $term) !== false) {
                        $returnOutputArr[] = array("value" => $key, "label" => $ser, "category" => "service");
                    }
                }
//                $hospitalResult = Yii::app()->db->createCommand()->select("t.user_id,hospital_name,profile_image,city_name,first_name, last_name,t.role_id,GROUP_CONCAT(sm.speciality_name) as doctspecial")
//                        ->from("az_user_details t")
//                        ->leftJoin('az_speciality_user_mapping p', 'p.user_id=t.user_id ')
//                        ->leftJoin('az_speciality_master sm', 'sm.speciality_id=p.speciality_id ')
//                        ->where("(hospital_name LIKE '%$term%' AND role_id = 5) OR ( (first_name LIKE '%$term%' OR last_name LIKE '%$term%')  AND role_id = 3) $addCondition")
//                        ->group("t.user_id")->order("FIELD(t.role_id,5,3)")
//                        ->queryAll();

                $hospitalResult = Yii::app()->db->createCommand()->select("t.user_id,hospital_name,profile_image,t.city_name,first_name, last_name,t.role_id,cd.clinic_id,cd.clinic_name,is_active")
                        ->from("az_user_details t")
                        ->leftJoin('az_clinic_details cd', 'cd.doctor_id=t.user_id ')
                        ->where(" (hospital_name LIKE '%$term%' AND role_id IN(5,6,7,8,9) ) OR ( (first_name LIKE '%$term%' OR last_name LIKE '%$term%')  AND role_id = 3 ) AND is_active = 1 $addCondition")
                        ->order("FIELD(t.role_id,5,3,6,7,8,9)")
                        ->queryAll();
                if (!empty($hospitalResult)) {
                    foreach ($hospitalResult as $row) {
                        $type = "doctor";
                        $label = $row['first_name'] . " " . $row['last_name'];
                        //$doctSepcial = $row['doctspecial'];
                        $doctSepcial = Yii::app()->db->createCommand()->select("GROUP_CONCAT(sm.speciality_name)")->from("az_speciality_user_mapping sm")->where("user_id = :user", array(":user" => $row['user_id']))->queryScalar();
                        $clinic_name = "";
                        $clinic_id = 0;
                        if (!empty($row['clinic_name'])) {
                            $clinic_name = $row['clinic_name'];
                            $role = $row['role_id'];
                        }
                        if (!empty($row['clinic_id'])) {
                            $clinic_id = $row['clinic_id'];
                            $role = $row['role_id'];
                        }
                        if ($row['role_id'] == 5) {
                            $type = "hospital";
                            $label = $row['hospital_name'];
                            $role = $row['role_id'];
                        }
                        if ($row['role_id'] == 6) {
                            $type = "pathology";
                            $label = $row['hospital_name'];
                            $role = $row['role_id'];
                        }
                        if ($row['role_id'] == 7) {
                            $type = "diagnostic";
                            $label = $row['hospital_name'];
                            $role = $row['role_id'];
                        }
                        if ($row['role_id'] == 8) {
                            $type = "Blood Bank";
                            $label = $row['hospital_name'];
                            $role = $row['role_id'];
                        }
                        if ($row['role_id'] == 9) {
                            $type = "Medical Store";
                            $label = $row['hospital_name'];
                            $role = $row['role_id'];
                        }
                        $returnOutputArr[] = array("user" => $row['user_id'], "value" => $label, "label" => $label, "category" => $type, "img" => $row['profile_image'], "cityname" => $row['city_name'], "docspecial" => $doctSepcial, "clinic_name" => $clinic_name, "clinic_id" => $clinic_id, "role_id" => $row['role_id'], "role" => $row['role_id']);
                    }
                }
            } else {
                foreach ($SpecialityArr as $spe) {
                    $returnOutputArr[] = array("value" => $spe, "label" => $spe, "category" => "speciality");
                }
            }
            
            
        } catch (Exception $ex) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $ex->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionGetSearchLocation() {
        $purifiedObj = Yii::app()->purifier;
        $location = Yii::app()->request->getParam('location1');
        $locationResult = array();
        $returnOutputArr = array();
        try {
            if (isset($location) && !empty($location)) {
                $locationResult = Yii::app()->db->createCommand()->select("DISTINCT(area_name) as distarea")
                        ->from("az_user_details ")
                        ->where("area_name LIKE '%$location%' AND role_id IN( 3,5,6,7,8,9) ")
                        ->queryColumn();
                if (!empty($locationResult)) {
                    foreach ($locationResult as $location) {
                        $returnOutputArr[] = array("value" => $location, "label" => $location, "category" => "area_name");
                    }
                }
                //$locationResult[] = array("city_name" => 'city_name', "area_name" => 'area_name');
            } else {
                $session = new CHttpSession;
                $session->open();
                $defaultCity = Constants::DEFAULT_CITY;
                if (isset($session['usercity'])) {
                    $defaultCity = $session['usercity'];
                }
                $returnOutputArr[] = array("value" => $defaultCity, "label" => "All of " . $defaultCity, "category" => "main_city_name");
                $locationResult = Yii::app()->db->createCommand()->select("DISTINCT(area_name) as distarea")
                        ->from("az_user_details ")
                        ->where("city_name LIKE '%$defaultCity%'  AND role_id IN( 3,5,6,7,8,9) ")
                        ->queryColumn();
                if (!empty($locationResult)) {
                    foreach ($locationResult as $location) {
                        $returnOutputArr[] = array("value" => $location, "label" => $location, "category" => "area_name");
                    }
                }
            }
        } catch (Exception $ex) {
            $returnOutputArr['isError'] = true;
            $returnOutputArr['errorMsg'] = $ex->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionSetSessionCity() {
        $session = new CHttpSession;
        $session->open();
        $session['usercity'] = Yii::app()->request->getPost("city");
    }

    public function actionDocHosLogin() {

        $model = new UserDetails();
        $this->render('dochoslogin');
    }

    public function actionDoctorDetails() {
        $speciality = SpecialityMaster::model()->findAll();
        $specialityArr = CHtml::listData($speciality, 'speciality_name', 'img_name');
        $this->render('doctordetails', array('specialityArr' => $specialityArr));
    }

    public function actionGetLocationName() {
        $request = Yii::app()->request;
        $cityname = $request->getParam('city');

        $cmd = Yii::app()->db->createCommand()
                ->select('location_id,location_name')
                ->from('az_location_master')
                ->where('city_id=:id', array(':id' => $cityname))
                ->queryAll();

        $returnArr['location_name'] = $cmd;
        echo json_encode(array('data' => $cmd));
    }

    public function actionSearchResult() { // serching the result based on area and speciality
        $session = new CHttpSession;
        $session->open();
        $model = new UserDetails;
        $defaultsort = "Rating";
        $action = $param = $source = $dayofweek = "";
        if (empty($sortoption)) {
            $sortoption = $defaultsort;
        }
        $purifiedObj = Yii::app()->purifier;
        $requestObj = Yii::app()->request;
        $enc_key = Yii::app()->params->enc_key;
        $location = $requestObj->getParam("location");
        $iscity = $requestObj->getParam("iscity");
        $speciality = $requestObj->getParam("speciality");
        if (isset($_GET['sortby'])) {
            $sortoption = $requestObj->getParam("sortby");
            
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


        if (isset($session['usercity'])) {
            $defaultCity = $session['usercity'];
        }
        if (empty($location)) {     //if only speciality is selected
            $location = $defaultCity;
        }

        $whereClause = " t.role_id=3 AND spm.speciality_name = :specname AND is_active = 1";
        $join = "LEFT JOIN az_speciality_user_mapping spm ON spm.user_id = t.user_id LEFT JOIN az_clinic_details cd ON cd.doctor_id = t.user_id";
        $order = "t.user_id";
        $paramArr = array();
        $paramArr[":specname"] = $speciality;
        if ($iscity == "Y") {
            $whereClause .= " AND  ( t.city_name=:city_name OR cd.city_name = :city_name ) ";
            $paramArr[":city_name"] = $location;
        } elseif ($iscity == "N" && !empty($location)) {
            $whereClause .= " AND (t.area_name=:area_name  OR cd.area_name = :area_name) ";
            $paramArr[":area_name"] = $location;
        }
        if ($source == "freeoffer") {
            $whereClause .= " AND ( (cd.free_opd_perday IS NOT NULL and cd.free_opd_perday <> 0) OR (t.free_opd_perday IS NOT NULL and t.free_opd_perday <>0 )) and ( t.free_opd_preferdays LIKE '%$dayofweek%' OR cd.free_opd_preferdays LIKE '%$dayofweek%') ";
        }

        if ($sortoption == "Rating") {
            $join .= " LEFT JOIN az_rating ar ON ar.user_id = t.user_id";
            $order = "ar.rating DESC";
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

        $criteriaArr = array(
            'select' => "cd.clinic_id,IF( cd.opd_consultation_fee IS NULL, t.doctor_fees,cd.opd_consultation_fee) AS fees,cd.clinic_name,cd.address as clinic_address,cd.area_name as area_id,cd.state_name as state_id,cd.city_name as city_id, cd.country_name as country_id ,profile_image,t.user_id,role_id,first_name,last_name,t.area_name,t.city_name,t.state_name,t.country_name,t.description,hospital_name,t.experience,t.doctor_fees,parent_hosp_id,mobile,t.is_active,apt_contact_no_1,(select GROUP_CONCAT(degree_name) FROM az_doctor_degree_mapping dmp WHERE dmp.doctor_id = t.user_id ) as doctordegree,(select GROUP_CONCAT(speciality_name) FROM az_speciality_user_mapping dmp WHERE dmp.user_id = t.user_id ) as doctorspeciality,sub_speciality",
            'join' => $join,
            'condition' => $whereClause,
            'params' => $paramArr,
            'order' => $order,
        );
        $dataProvider = new CActiveDataProvider('UserDetails', array('criteria' => $criteriaArr,
            'pagination' => array('pageSize' => 20),)
        );


        $this->render('doctorlist', array('model' => $model, 'dataProvider' => $dataProvider, 'speciality' => $speciality, "action" => $action, "param" => $param, 'sortoption' => $sortoption, "source" => $source, "dayofweek" => $dayofweek));
    }

    public function actionGetHospitalId() { //get clinic_id from clinic_name
        $request = Yii::app()->request;
        $hosname = $request->getParam('hosname');

        $cmd = Yii::app()->db->createCommand()
                ->select('clinic_name,clinic_id')
                ->from('az_clinic_details')
                ->where('clinic_name=:name', array(':name' => $hosname))
                ->queryAll();

        $returnArr['clinic_id'] = $cmd;
        echo json_encode(array('data' => $cmd));
    }

    public function actionGetLogin($param1) {
        $model = new LoginForm;
        $purifiedObj = Yii::app()->purifier;
        $request = Yii::app()->request;
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($param1, $enc_key);

        $this->render('appointmentlogin', array('model' => $model, 'id' => $id));
    }

    public function actionDocViewAppointment() {
        $appointmentModel = new PatientAppointmentDetails();
        $appointmentpayment = new AppointmentPaymentTable();
        $session = new CHttpSession;
        $session->open();
        $id = $session["user_id"];

        $DocInfoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_user_details ")
                ->where(" role_id=3 And user_id=$id ")
                ->queryRow();
        $appointmentModel->unsetAttributes();  // clear any default values
        if (isset($_GET['PatientAppointmentDetails'])) {
            $appointmentModel->attributes = $_GET['PatientAppointmentDetails'];
            $appointmentModel->first_name = $_GET['PatientAppointmentDetails']['first_name'];
        }
        $this->render('docviewappointment', array('DocInfoArr' => $DocInfoArr, 'id' => $id, 'appointmentModel' => $appointmentModel, 'appointmentpayment' => $appointmentpayment));
    }

    public function actionAppointmentLogin() {
        $model = new LoginForm;

        $purifiedObj = Yii::app()->purifier;
        $request = Yii::app()->request;
        $mobile = $request->getParam('mobile');


        $uname = $purifiedObj->getPurifyText($request->getParam("mobile"));


//         if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $session = new CHttpSession;
                $session->open();
                $roleId = $session['user_role_id'];
                if ($roleId == 1) { //if its superadmin
                    $this->redirect(array("userDetails/admin"));
                } else { //redirect to user dashboard
                    $this->redirect(array("userDetails/userDashboard"));
                }
            }
        }
        // display the login form
        $this->render('appointmentLogin', array('model' => $model));
    }

    public function actionGetVisitingDetails() {
        $request = Yii::app()->request;
        $id = $request->getParam('hosname');
    }

    public function actionHosViewAppointment() {
        $this->layout = 'adminLayout';
        $appointmentModel = new PatientAppointmentDetails;
        $userdetailModel = new UserDetails;
        $apmtQuerymodel = new AptmtQuery;
        $session = new CHttpSession;
        $session->open();
        $id = $session->open();
        $id = $session['user_id'];

        $HospitalinfoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_user_details")
                ->where("role_id=5 And user_id =$id")
                ->queryRow();
        $appointmentModel->unsetAttributes();  // clear any default values
        $userdetailModel->unsetAttributes();
        if (isset($_GET['PatientAppointmentDetails'])) {
            $appointmentModel->attributes = $_GET['PatientAppointmentDetails'];
            if (isset($_GET['PatientAppointmentDetails']['first_name'])) {
                $appointmentModel->first_name = $_GET['PatientAppointmentDetails']['first_name'];
            }
            if (isset($_GET['PatientAppointmentDetails']['doctorname'])) {
                $appointmentModel->doctorname = $_GET['PatientAppointmentDetails']['doctorname'];
            }
            if (isset($_GET['PatientAppointmentDetails']['mobile'])) {
                $appointmentModel->mobile = $_GET['PatientAppointmentDetails']['mobile'];
            }
            if (isset($_GET['PatientAppointmentDetails']['appointment_date'])) {
                $appointmentModel->appointment_date = $_GET['PatientAppointmentDetails']['appointment_date'];
            }
        }

        if (isset($_GET['UserDetails'])) {
            $userdetailModel->attributes = $_GET['UserDetails'];
            if (isset($_GET['UserDetails']['doctorname'])) {
                $userdetailModel->doctorname = $_GET['UserDetails']['doctorname'];
            }
            if (isset($_GET['UserDetails']['apt_contact_no_1'])) {
                $userdetailModel->apt_contact_no_1 = $_GET['UserDetails']['apt_contact_no_1'];
            }
            if (isset($_GET['UserDetails']['speciality'])) {
                $userdetailModel->speciality = $_GET['UserDetails']['speciality'];
            }
        }
        $this->render('hosViewAppointment', array('HospitalinfoArr' => $HospitalinfoArr, 'id' => $id,
            'appointmentModel' => $appointmentModel, 'userdetailModel' => $userdetailModel, 'apmtQuerymodel' => $apmtQuerymodel));
    }

    public function actionHospitalDoctorList($id) {
        $model = new UserDetails;
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);

        $this->render('hospitalDoctorList', array('id' => $id));
    }

    public function actionAddNotification() {
        $session = new CHttpSession;
        $session->open();
        $purifiedObj = Yii::app()->purifier;
        $userid = Yii::app()->request->getParam('userid');
        $module = Yii::app()->request->getParam('module');
        $action = Yii::app()->request->getParam('action');
        $opertion = Yii::app()->request->getParam('opertion');
        $notification = Yii::app()->request->getParam('notification');
        $recordid = $session['user_id'];

        CommonFunction::Notification($userid, $recordid, $module, $action, $opertion, $notification);
    }

    public function actionCheck_Mobile() {               //To find unique mobile no
        $request = Yii::app()->request;
        $param = $request->getParam('mobile');
        $mobile = Yii::app()->db->createCommand()
                ->select('count(mobile)')
                ->from('az_user_details')
                ->where("mobile LIKE '%$param%'")
                ->queryScalar();

        echo json_encode(array('data' => $mobile));
    }

    public function actionHospitalList() {
        $sortoption = "";

        if (isset($_GET['sortby'])) {
            $sortoption = Yii::app()->request->getParam("sortby");
        }
        $model = new UserDetails;
        $whereClause = "t.role_id=5 AND t.is_active = 1";
        $order = "discount DESC";
        if ($sortoption == "Rating") {
            $criteriaArr['join'] = " LEFT JOIN az_rating ar ON ar.user_id = t.user_id";
            $criteriaArr['order'] = "ar.rating DESC";
        }
        if ($sortoption == "Establishment") {
            $order = "hos_establishment_for_order ASC";
        }
        if ($sortoption == "beds-strength") {

            $order = "t.total_no_of_bed DESC";
        }
        $criteriaArr = array(
            'select' => "t.user_id,t.role_id,profile_image,payment_type,hospital_name,type_of_hospital,IF(t.hos_establishment IS NULL,'2050-01-01',hos_establishment) as hos_establishment_for_order ,total_no_of_bed,description,state_name,city_name,area_name,pincode,address,landmark,t.hos_establishment ,(select MAX(service_discount) from az_service_user_mapping um where um.user_id = t.user_id)as discount",
            'condition' => $whereClause,
            'order' => $order,
        );

        $dataProvider = new CActiveDataProvider('UserDetails', array('criteria' => $criteriaArr,
            'pagination' => array('pageSize' => 20),)
        );
        $this->render('HospitalList', array('model' => $model, 'dataProvider' => $dataProvider, 'sortoption' => $sortoption));
    }

    public function actionAddRating() {
        $model = new Rating;
        $createdBy = Yii::app()->user->id;
        $createdDate = date('Y-m-d H:i:s');
        $userid = Yii::app()->request->getParam('userid');
        $rating = Yii::app()->request->getParam('rate');
        $model->user_id = $userid;
        $model->rating = $rating;
        $model->created_by = $createdBy;
        $model->created_date = $createdDate;
        $model->save();
    }

    public function actionPathologyList($role) {
        $sortoption = "";
        $order = "discount DESC";
//        $savings = Yii::app()->db->createCommand()->select("MAX(service_discount)")->from("az_service_user_mapping")->where("user_id = :id AND clinic_id = :cid", array(":id" => $data->user_id, ":cid" => 0 ))->queryScalar();

        if (isset($_GET['sortby'])) {
            $sortoption = Yii::app()->request->getParam("sortby");
        }
        if ($sortoption == "Experience") {

            $order = "t.hos_establishment DESC";
        }
        if ($sortoption == "Rating") {
            $criteriaArr['join'] = " LEFT JOIN az_rating ar ON ar.user_id = t.user_id";
            $criteriaArr['order'] = "ar.rating DESC";
        }
        $model = new UserDetails;
        $whereClause = "t.role_id=$role AND is_active = 1";
        $criteriaArr = array(
            'select' => "t.user_id,t.role_id,profile_image,hospital_name,type_of_hospital,hos_establishment,description,state_name,city_name,area_name,pincode,address,landmark,(select MAX(service_discount) from az_service_user_mapping um where um.user_id = t.user_id)as discount",
            'condition' => $whereClause,
            'order' => $order,
        );

        //

        $dataProvider = new CActiveDataProvider('UserDetails', array('criteria' => $criteriaArr,
            'pagination' => array('pageSize' => 20),)
        );
        $this->render('PathologyList', array('model' => $model, 'dataProvider' => $dataProvider, 'role' => $role, 'sortoption' => $sortoption));
    }

    public function actionDetailsOther($param1, $param2) {
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($param1, $enc_key);
        $role = $param2;
        // $id = $param1;



        $user = Yii::app()->db->createCommand()
                ->select('*')
                ->from('az_user_details')
                ->where('user_id=:id', array(':id' => $id))
                ->queryRow();

        if ($user['role_id'] == $role) {
            $hospital = Yii::app()->db->createCommand()->select('hospital_name,hos_establishment')->from('az_user_details')->where('user_id=:id', array(':id' => $user['user_id']))->queryRow();
            if (!empty($hospital)) {
                $user['hospital_name'] = $hospital['hospital_name'];
                $user['hos_establishment'] = $hospital['hos_establishment'];
            }
        }

        $this->render('details_other', array('user_details' => $user, 'id' => $id, 'role' => $role)); //    , "action" => $action, "param" => $param));
    }

    public function actionShareProfileLogin() {
        $session = new CHttpSession;
        $session->open();
        $request = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;
        $redirectUrl = $request->getPost("redirectUrl");
        $userid = $request->getPost("userid");
        if (isset($session['user_id']) && !empty($session['user_id'])) {
            if (isset($session['shareprofileshow'])) {
                unset($session['shareprofileshow']);
            }
            $infoArr = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('az_user_details')
                    ->where("user_id=:id", array(':id' => $userid))
                    ->queryRow();
            // print_r($infoArr);
            $this->renderPartial('shareProfile', array('userdetails' => $infoArr));
        } else {
            $session['shareprofileshow'] = "yes";
            $this->renderPartial('login', array('model' => new LoginForm, "redirectUrl" => $redirectUrl));
        }
    }

    public function actionShareProfile() {

        $userid = Yii::app()->request->getParam('userid');
        $email = Yii::app()->request->getParam('email');
        $degree = Yii::app()->request->getParam('degree');
        $clinicname = Yii::app()->request->getParam('clinicname');
        $clinicaddress = Yii::app()->request->getParam('clinicaddress');
        $returnOutputArr = array("isError" => false);
        try {
            if (isset($email)) {
                $subject = "Demo Mail";
                $emailArr = explode(",", $email);
                $emailfinalArr = array();

                foreach ($emailArr as $key => $value) {
                    $emailfinalArr[$value] = "";
                }

                $profile = Yii::app()->db->createCommand()
                        ->select('role_id,user_id,profile_image,first_name,last_name,apt_contact_no_1,email_1,city_name,state_name,country_name,hospital_name,type_of_hospital,total_no_of_bed,description')
                        ->from('az_user_details')
                        ->where("user_id=:id", array(':id' => $userid))
                        ->queryRow();
                $profilepath = Yii::app()->baseUrl;
                $profilepath .= "/uploads/" . $profile['profile_image'];
                $name = $profile['first_name'] . " " . $profile['last_name'];
                $hospitalname = $profile['hospital_name'];
                $hospitaltype = $profile['type_of_hospital'];
                $Total_Bed = $profile['total_no_of_bed'];
                $description = $profile['description'];
                $appointmentno = $profile['apt_contact_no_1'];
                $address = $profile['city_name'] . ", " . $profile['state_name'] . " " . $profile['country_name'];
                if ($profile['role_id'] == 3) {
                    $msg = "<table style='width:80%;padding-bottm:15px; border:1px solid black;margin-left:10%;margin-right:10%;'>";
                    $msg .= "<tr><td style='width:25%'><div style='text-align:center;'><img src=.$profilepath class='img-circle img-responsive' height=150px width=150px style='border-radius: 50%;'></div></td><td><div class=style='border:1px solid;width:65%;'><h4 style='margin-bottom: 0px;'>Dr $name</h4><br><span class='col-view' style='margin-top: 8px;'>$degree</span><br><span class='col-view' style='margin-top: 8px;'>Address.$clinicaddress </span><br><span class='col-view' style='margin-top: 8px;'>Appointment Contact No.$appointmentno </span><br><p>$description</p></div></td></tr>";
                    $msg .= "</table>";
                } else if ($profile['role_id'] == 5) {
                    $msg = "<table style='width:80%;padding-bottm:15px; border:1px solid black;margin-left:10%;margin-right:10%;'>";
                    $msg .= "<tr><td style='width:25%;'><div style='text-align:center;'><img src=.$profilepath class='img-circle img-responsive' height=150px width=150px style='border-radius: 50%;'></div></td><td><div><h4 style='margin-bottom: 0px;'>$hospitalname</h4><br><span class='col-view' style='margin-top: 8px;'> Hospital type.$hospitaltype</span><br><span class='col-view' style='margin-top: 8px;'>Address $address </span><br><h5 class='title-details' style='padding-left:0px;'> NO.Of Beds-.$Total_Bed </h5><br><p>$description</p></div></td></tr>";
                    $msg .= "</table>";
                    $msg .= "</div>";
                    $msg .= "</table>";
                } else if ($profile['role_id'] == 6 || $profile['role_id'] == 7 || $profile['role_id'] == 8 || $profile['role_id'] == 9) {
                    $msg = "<table style='width:80%;padding-bottm:15px; border:1px solid black;margin-left:10%;margin-right:10%;'>";
                    $msg .= "<tr><td style='width:25%;'><div style='text-align:center;'><img src=.$profilepath class='img-circle img-responsive' height=150px width=150px style='border-radius: 50%;'></div></td><td><div><h4 style='margin-bottom: 0px;'>$hospitalname</h4><br><span class='col-view' style='margin-top: 8px;'> Hospital type.$hospitaltype</span><br><span class='col-view' style='margin-top: 8px;'>Address $address </span><br><p>$description</p></div></td></tr>";
                    $msg .= "</table>";
                    $msg .= "</div>";
                    $msg .= "</table>";
                }


                $response = CommonFunction::sendMail($subject, $emailfinalArr, $msg);

                if ($response == 1) {
                    $returnOutputArr['isError'] = false;
                    $createdDate = date('Y-m-d H:i:s');
                    $createdBy = Yii::app()->user->id;
                    $model = new EmailHistory;
                    $model->user_id = $userid;
                    $model->email_address = $email;
                    $model->created_by = $createdBy;
                    $model->created_date = $createdDate;
                    $model->save();
                } else {
                    throw new Exception("Error in mail send. Please contact administrator");
                }
            }
        } catch (Exception $e) {
            $returnOutputArr['isError'] = true;

            $returnOutputArr['errorMsg'] = $e->getMessage();
        }
        echo json_encode(array('result' => $returnOutputArr));
    }

    public function actionSpecialityList() {
        $model = new UserDetails;
        $specialityid = Yii::app()->request->getParam('specialityid');
        $whereClause = "spm.speciality_id = :specialityid AND t.role_id=3  ";
        $paramArr = array();
        $paramArr[":specialityid"] = $specialityid;
        $criteriaArr = array(
            'select' => "spm.`speciality_id`,spm.`speciality_name`,cd.address as clinic_address,cd.area_name as area_id,cd.state_name as state_id,
cd.city_name as city_id, cd.country_name as country_id ,profile_image,t.user_id,role_id,first_name,last_name,t.area_name,t.city_name,
t.state_name,t.country_name,t.description,hospital_name,experience,doctor_fees,parent_hosp_id,mobile,apt_contact_no_1,(select GROUP_CONCAT(degree_name) FROM az_doctor_degree_mapping dmp WHERE dmp.doctor_id = t.user_id ) as doctordegree",
            'join' => 'LEFT JOIN az_speciality_user_mapping spm ON spm.user_id = t.user_id LEFT JOIN az_clinic_details cd ON cd.doctor_id = t.user_id',
            'condition' => $whereClause,
            'params' => $paramArr,
            'order' => 't.user_id'
        );

        $dataProvider = new CActiveDataProvider('UserDetails', array('criteria' => $criteriaArr,
            'pagination' => array('pageSize' => 20),)
        );
        $this->render('specialityList', array('model' => $model, 'dataProvider' => $dataProvider));
    }

    public function actionAddHospitalAppointment() {
        $this->layout = 'adminLayout';
        $commonobj = new CommonFunction;
        $enc_key = Yii::app()->params->enc_key;
        $enquiryId = Yii::app()->request->getParam('id');

        $request = Yii::app()->request;
        //   $patientid = "";
        $patientinfo = array();
//        if(isset($_GET['id'])){
//             $patientid = Yii::app()->request->getParam('id');
//             
//            $date = date('Y-m-d');
//            $patientinfo = Yii::app()->db->createCommand()
//                ->select('*')
//                ->from('az_aptmt_query')
//                ->Where(' apt_confirm =:confirm AND id=:userid', array(':userid' => $patientid,':confirm'=>'No'))
//                ->andwhere('preferred_day >=:date',array(':date'=>$date))
//                ->queryRow();
//          
//          
//            $model->patient_id = $patientinfo['patient_name'];
//            $model->doc_fees = $patientinfo['apt_fees'];
//            $model->type_of_visit = $patientinfo['type_of_visit'];
//            $model->patient_mobile = $patientinfo['creator_number'];
//            $model->appointment_date = date("d-m-Y", strtotime($patientinfo['preferred_day']));
//        }
        $model = new PatientAppointmentDetails;
        try {
            if (isset($_POST['PatientAppointmentDetails'])) {
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                //$model->attributes = $_POST['PatientAppointmentDetails'];
                $postArr = $request->getPost("PatientAppointmentDetails");
                //print_r($postArr);exit;
                $model->patient_name = $postArr['patient_name'];
                $model->patient_mobile = $postArr['patient_mobile'];
                $model->doctor_id = $postArr['doctor_id'];
                $model->hospital_id = Yii::app()->user->id;
                $model->enquiry_id = $enquiryId;
                if (!empty($postArr['appointment_date'])) {
                    $appointmentdate = $postArr['appointment_date'];
                    $model->appointment_date = $appointmentdate;
                }
                if (!empty($postArr['time'])) {
                    $model->time = $purifiedObj->getPurifyText($postArr['time']);
                }
                $model->day = $postArr['day'];
                if (!empty($postArr['type_of_visit'])) {
                    $model->type_of_visit = $postArr['type_of_visit'];
                }

                $model->created_date = date('Y-m-d H:i:s');
                //$model->updated_date = date('Y-m-d H:i:s');


                $model->is_clinic = "N";
                $model->doc_fees = $postArr['doc_fees'];






                if ($model->save()) {
                    $pmobile = $postArr['patient_mobile'];
                    $time = $model->time;
                    $commonobj->sendSms($pmobile, "Reminder: Your appointment time $time.  Pl ensure to be on time for best services.
");
                    //exit;
                    Yii::app()->user->setFlash('Success', 'Appointment successfully Scheduled');
                }
            }
        } catch (Exception $ex) {
            $transaction->rollback();
            $model->addError(NULL, $ex->getMessage());
        }
        $this->render('addHospitalAppointment', array('model' => $model));
    }

    public function actionlabTestBook($param1, $param2, $param3) {
    $session = new CHttpSession;
        $session->open();
        $enc_key = Yii::app()->params->enc_key;
//        $role = Yii::app()->getSecurityManager()->decrypt($param2, $enc_key);
//        $centerid = Yii::app()->getSecurityManager()->decrypt($param3, $enc_key);
//        $link = Yii::app()->getSecurityManager()->decrypt($param1, $enc_key);
        //$user_id = Yii::app()->getSecurityManager()->decrypt($param4, $enc_key);
        $patient_id = $session['user_id'];
            //  $model = LabBookDetails ::model()->findByAttributes(array('patient_id' => $patient_id)); 
$link = $param1;
$centerid = $param3;
$role = $param2;
            $model = new LabBookDetails;
            $model->relation = 'SELF';
            
            if (isset($_POST['LabBookDetails'])) {
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                try {

                    $postArr = Yii::app()->request->getParam('LabBookDetails');
                    
                    $model->role_id = $role;
                    $model->full_name = $purifiedObj->getPurifyText($postArr['full_name']);
                    if (!empty($postArr['relation'])) {
                        $model->relation = $purifiedObj->getPurifyText($postArr['relation']);
                    }
                    $model->patient_id = $patient_id;   //Yii::app()->user->id;
                    $model->center_id = $centerid;
                    if (!empty($postArr['other_relation_dis'])) {
                        $model->other_relation_dis = $purifiedObj->getPurifyText($postArr['other_relation_dis']);
                    }
                    $model->mobile_no = $purifiedObj->getPurifyText($postArr['mobile_no']);
                    $model->patient_age = $purifiedObj->getPurifyText($postArr['patient_age']);
                    if (!empty($postArr['blood_group']))
                        $model->blood_group = $purifiedObj->getPurifyText($postArr['blood_group']);
                    if (!empty($postArr['no_of_unit']))
                        $model->no_of_unit = $purifiedObj->getPurifyText($postArr['no_of_unit']);

                    if ($role != 8) {
                        if (!empty($postArr['service_name'])) {
                            $model->service_name = $purifiedObj->getPurifyText($postArr['service_name']);
                        }
                    }
                    if (!empty($postArr['pincode'])) {
                        $model->collect_home = "YES";
                        $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
                        $model->country_id = 1;
                        $model->country_name = "India";
                        $model->state_id = $purifiedObj->getPurifyText($postArr['state_id']);
                        $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
                        $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
                        $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                        $model->area_id = $purifiedObj->getPurifyText($postArr['area_id']);
                        $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                        $model->landmark = $purifiedObj->getPurifyText($postArr['landmark']);
                        $model->address = $purifiedObj->getPurifyText($postArr['address']);
                    } else {
                        $model->collect_home = "NO";
                    }
                    $model->status = 'Pending';
                    $model->created_date = date("Y-m-d H:i:s");
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


                    $doctordisImageObj = CUploadedFile::getInstance($model, "discription_doc");
                   
                    if (!empty($doctordisImageObj)) {
                        $path_part = pathinfo($doctordisImageObj->name);
                        $fname = $profileDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model->discription_doc = $fname;

                        $doctordisImageObj->saveAs($baseDir . $model->discription_doc);
                    }

                    if ($model->save()) {
                        Yii::app()->user->setFlash('Success', 'Appointment successfully Booked');
                        //$this->redirect(array('site/labViewAppointment','roleid'=>$role));
                    }
                } catch (Exception $e) {
                    $model->addError(NULL, $e->getMessage());
                }
            }
            
            $login_role_id = $session["user_role_id"];
        if ($login_role_id == 6 || $login_role_id == 7) {
                    $this->render('_labTestBook', array('model' => $model, 'centerid' => $centerid, 'role' => $role, 'link' => $link, 'patient_id' => $patient_id));
              
            } else {   // 8,9 is perfect
      
               
             $this->render('labTestBook', array('model' => $model, 'centerid' => $centerid, 'role' => $role, 'link' => $link, 'patient_id' => $patient_id));
          
        
            }
       
    }

    public function actionChklabTestBook(){
        $session = new CHttpSession;
        $session->open();
        $enc_key = Yii::app()->params->enc_key;
        $request = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;
        $centerid = $request->getPost("hospid");
        $role = $request->getPost("role");
        $link = $request->getPost("detaillink");
        $patient_id = $session['user_id'];
        $model = new LabBookDetails;
        $dataArr = array();
         if (isset($session['user_id']) && !empty($session['user_id'])) {
            if (isset($session['isshowappoint'])) {
                unset($session['centerid']);
                unset($session['bookroleid']);
                unset($session['isshowappoint']);
            }
        
        $dataArr['data'] =     Yii::app()->createUrl('site/labTestBook', array( 'param3' => $centerid, 'param2' => $role, 'param1' => $link));
        $dataArr['is_link'] = 'Y';
        
         } else {
             $session['isshowappoint'] = true;
             $session['centerid'] = $centerid;
             $session['bookroleid'] = $role;
            $dataArr['is_link'] = 'N';
            $dataArr['data'] = $this->renderPartial('login', array('model' => new LoginForm, "redirectUrl" => $link . "&action=appoint&param=$centerid"),true);
        }
        echo json_encode($dataArr);
        
    }
    
    public function actionBookappoint() {
        
        $session = new CHttpSession;
        $session->open();
        $request = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;
        $docid = $request->getPost("docid");
        $clinic_id = $request->getPost("clinicid");
       
        $redirectUrl = $request->getPost("redirectUrl");
        $docfee = $request->getPost("docfee");
        $source = $request->getPost("source");
        if (isset($session['user_id']) && !empty($session['user_id'])) {
            if (isset($session['isshowappoint'])) {
                unset($session['isshowappoint']);
            }
            $model = new AptmtQuery();
            $model->is_patient = 1;
            $model->patient_name = $session["user_fullname"];
            $model->patient_mobile = $session["mobile"];
            $model->creator_number = $session["mobile"];
            $model->type_of_visit = "firstvisit";
            $model->doctor_id = $docid;
            $model->apt_fees = $docfee;
            // $model->save();
            $doctorprofile = Yii::app()->db->createCommand()->select('first_name,last_name,apt_contact_no_1,city_name,state_name,country_name,address,area_name,doctor_fees')->from('az_user_details')->where("user_id=:id", array(':id' => $docid))->queryRow();
            $this->renderPartial('bookappointment', array('model' => $model, "doctorprofile" => $doctorprofile, "docfee" => $docfee, "source" => $source, "clinic_id" => $clinic_id));
        } else {
            $session['isshowappoint'] = true;
            $session['bkaptclinicid'] = $clinic_id;
            $session['bkaptdocfee'] = $docfee;
            $this->renderPartial('login', array('model' => new LoginForm, "redirectUrl" => $redirectUrl . "&action=appoint&param=$docid"));
        }
    }

    public function actionConfirmappointment() {

        if (isset($_POST['AptmtQuery']) && !empty($_POST['AptmtQuery'])) {
            $session = new CHttpSession;
            $session->open();

            $request = Yii::app()->request;
            $purifiedObj = Yii::app()->purifier;
            $postArr = $request->getPost("AptmtQuery");
            $date = date('Y-m-d');
            $id = $session['user_id'];

            $model = new AptmtQuery();
            $model->is_patient = $postArr['is_patient'];
            $model->patient_name = $postArr['patient_name'];
            $model->patient_mobile = $postArr['patient_mobile'];
            $model->creator_number = $postArr['creator_number'];
            $model->type_of_visit = $postArr['type_of_visit'];
            $model->relationship = $postArr['relationship'];
            $model->doctor_id = $postArr['doctor_id'];
            $model->apt_fees = $postArr['doctorfees'];
            $model->clinic_id = $postArr['clinic_id'];
            if (!empty($postArr['promo_id'])) {
                $model->promo_id = $postArr['promo_id'];
            } else {
                $model->promo_id = NULL;
            }
            $model->apt_confirm = "No";
            $model->created_date = date("Y-m-d H:i:s");
            $model->created_by = $session['user_id'];
            $model->preferred_day = date("Y-m-d", strtotime($postArr['preferred_day']));
            $model->mode_of_pay = "counter";

            if ($model->save()) {
                if (!empty($model->promo_id)) {
                    Yii::app()->db->createCommand()->update("az_promo_code", array("promo_status" => "Used", "used_date" => date("Y-m-d H:i:s")), "promo_id = :promo_id", array(":promo_id" => $model->promo_id));
                }
                echo $model->id;
            }
//            else {
//                // print_r($model->getErrors());
//            }
        }
    }

    public function actionForgotPassword() {

        $request = Yii::app()->request;
        $commonobj = new CommonFunction;
        $param = $request->getParam('mobile');
        $returnOutputArr = array("iserror" => false);
        try {
            $userid = Yii::app()->db->createCommand()->select('user_id')->from('az_user_details')->where("mobile = :mobile", array(":mobile" => $param))->queryScalar();
            if (!empty($userid) && $userid > 0) {
                $otp = rand(111111, 999999);
                Yii::app()->db->createCommand()->update('az_user_details', array('user_otp' => $otp), 'user_id=:user_id', array(':user_id' => $userid));
                $commonobj->sendSms($param, "$otp is your OTP verification code for A2zhelthplus");
            } else {
                throw new Exception("You are not registered Member");
            }
        } catch (Exception $ex) {
            $returnOutputArr['iserror'] = true;
            $returnOutputArr['errormsg'] = $ex->getMessage();
        }
        echo json_encode($returnOutputArr);
    }

    public function actionVerifyOtpPanel() {

        $request = Yii::app()->request;
        $otpval = $request->getParam('otpval');
        $mobile = $request->getParam('mobile');

        $result = Yii::app()->db->createCommand()
                ->select('user_otp')
                ->from('az_user_details')
                ->where("mobile = :mobile", array(":mobile" => $mobile))
                ->queryRow();

        if ($result['user_otp'] == $otpval) {
            $returnOutputArr = array("isverified" => "yes");
        } else {
            $returnOutputArr = array("isverified" => "no");
        }
        echo json_encode(array('data' => $returnOutputArr));
    }

    public function actionConfirmPassword() {

        $request = Yii::app()->request;
        $pwd = $request->getParam('pwd');
        $cpwd = $request->getParam('cpwd');
        $mobile = $request->getParam('mobile');
        $newpss = md5($pwd);
        if (isset($newpss)) {
            Yii::app()->db->createCommand()->update('az_user_details', array('password' => $newpss), 'mobile=:mobile', array(':mobile' => $mobile));
            $returnOutputArr = array("isverified" => "yes");
        } else {
            $returnOutputArr = array("isverified" => "no");
        }
        echo json_encode(array('data' => $returnOutputArr));
    }

    public function actionGetHospitalAppointment() {

        $session = new CHttpSession;
        $session->open();
        $request = Yii::app()->request;
        $redirectUrl = $request->getPost("detaillink");
  
        $hospid = Yii::app()->request->getParam('hospid');
        if (isset($session['user_id']) && !empty($session['user_id'])) {
            if (isset($session['isshowappoint'])) {
                unset($session['isshowappoint']);
                unset($session['temp_hospid']);
            }
            $hospitalservices = Yii::app()->db->createCommand()->select('t.role_id,r.role_name,apt_contact_no_1')->from('az_user_details t')->join('az_role_master r', 't.role_id=r.role_id')->where('parent_hosp_id=:id ', array(':id' => $hospid))->andWhere('t.role_id >:start AND t.role_id <= :end', array(':start' => 5, ':end' => 9))->queryAll();
            $hospstr = "<div class='appointcontent1' style='background-color:rgba(83,116,115,0.8);color:#fff;box-shadow: none;border: 0;'>";
            //$hospstr .= "<div class='text-right'><button type='button' class='close' data-dismiss='modal'>&times;</button></div>";
            foreach ($hospitalservices as $key => $value) {
                //   $hospstr .='<label>'.$value["service_name"].'</label></br>';
                $hospstr .= "<div class='col-sm-4' style='margin-top:15px;'> <h4 class='modal-title'>" . $value['role_name'] . "</h4><p>+91" . $value['apt_contact_no_1'] . "</p></div>";
            }
            $hospstr .= "<div class='clearfix'>&nbsp;</div>";
            $hospstr .= "</div>";
            echo $hospstr;
        } else {
            $session['isshowappoint'] = true;
            $session['temp_hospid'] = $hospid;
            $this->renderPartial('login', array('model' => new LoginForm,"redirectUrl" => $redirectUrl));
        }
    }

    public function actionAmbulanceList() {


        Yii::import('application.extensions.yiinfinite-scroll.YiinfiniteScroller');
        $model = new UserDetails;
        $name = "";
        $category = "";
        $paramArr = array();
        $whereClause = "t.role_id=10";
        $requestObj = Yii::app()->request;

        if (isset($_GET['address'])) {
            $name = $requestObj->getParam("address");
        }
        if (isset($_GET['category'])) {
            $category = $requestObj->getParam("category");
        }


        if (!empty($category)) {
            $whereClause .= " AND t.type_of_hospital=:category";
            $paramArr[':category'] = $category;
        }
        $criteria = new CDbCriteria;
        $total = Yii::app()->db->createCommand()->select('COUNT(t.user_id)')->from('az_user_details t')->where('t.role_id = 10')->queryScalar();
        $pages = new CPagination($total);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $criteria->select = 't.user_id,t.role_id,t.first_name,hospital_name,mobile,type_of_hospital,address,landmark,company_name,longitude,latitude';
        if (!empty($name)) {
            //$whereClause .= " AND t.address Like  :name ";
            //$paramArr[':name'] = "%".$name."%";
            $criteria->compare('address', $name, true);
        }
        $criteria->condition = $whereClause;
        $criteria->params = $paramArr;

        $posts = UserDetails::model()->findAll($criteria);

        $this->render('ambulanceList', array(
            'posts' => $posts,
            'pages' => $pages,
            'category' => $category,
            'name' => $name
        ));
    }

    public function actionGetappointpayment() {
        $model = new AppointmentPaymentTable;
        $bookid = $payedamt = "";
        $request = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;
        $userid = $request->getParam('userid');
        $patientid = $request->getParam('patientid');
        $doctorfee = $request->getParam('doctorfee');
        $patientamt = $request->getParam('patientamt');
        $doctorid = $request->getParam('doctorid');
        $payedamt = $request->getParam('payedamt');
        $bookid = $request->getParam('bookid');

        $role = $request->getParam('role');
        $aptid = $request->getParam('aptid');

        $result = Yii::app()->db->createCommand()
                ->select('role_id')
                ->from('az_user_details')
                ->where("user_id = :userid", array(":userid" => $doctorid))
                ->queryScalar();

        $model->payment_amt = $purifiedObj->getPurifyText($patientamt);
        if (!empty($payedamt)) {
            $model->payment_amt = $purifiedObj->getPurifyText($payedamt);
        }
        $model->patient_id = $purifiedObj->getPurifyText($patientid);
        $model->user_id = $purifiedObj->getPurifyText($doctorid);
        $model->appointment_id = $purifiedObj->getPurifyText($aptid);
        if (!empty($bookid)) {
            $model->appointment_id = $purifiedObj->getPurifyText($bookid);
        }
        if (!empty($role)) {
            $model->user_type = $role;
        }
        $model->user_type = $result;

        $model->created_date = date('Y-m-d H:i:s');

        $model1 = LabBookDetails::model()->findByAttributes(array('book_id' => $bookid));
        if ($model1['total_charges'] < $doctorfee) {
            $update = Yii::app()->db->createCommand()->update('az_lab_book_details', array('total_charges' => $doctorfee), 'book_id = :bookid', array(":bookid" => $bookid));
        }

        if ($model->save()) {
            echo true;
        }
    }

    public function actionGetSelectedAptTime() {
        $request = Yii::app()->request;
        $selecteddate = $request->getParam('aptdate');
        $doctorid = Yii::app()->user->id;
        $result = Yii::app()->db->createCommand()
                ->select('appointment_date,time')
                ->from('az_patient_appointment_details')
                ->where("doctor_id = :doctorid AND appointment_date =:pdate", array(":doctorid" => $doctorid, ":pdate" => $selecteddate))
                ->queryAll();
        echo json_encode($result);
    }

    public function actionLabViewAppointment() {
        $request = Yii::app()->request;
        $roleid = $request->getParam('roleid');

        $labbookModel = new LabBookDetails();

        $session = new CHttpSession;
        $session->open();
        $id = $session["user_id"];

        $labInfoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_user_details ")
                ->where(" role_id=:role And user_id=:id", array(':role' => $roleid, ':id' => $id))
                ->queryRow();
        $labbookModel->unsetAttributes();  // clear any default values
        if (isset($_GET['LabBookDetails'])) {
            $labbookModel->attributes = $_GET['LabBookDetails'];
            if (isset($_GET['LabBookDetails']['full_name'])) {
                $labbookModel->full_name = $_GET['LabBookDetails']['full_name'];
            }
        }
        $this->render('labViewAppointment', array('labInfoArr' => $labInfoArr, 'labbookModel' => $labbookModel, 'id' => $id, 'roleid' => $roleid));
    }

    public function actionCheckpromocode() {
        $returnOutputArr = array();
        $request = Yii::app()->request;
        $promocode = $request->getPost('promo');
        $userid = $request->getPost('userid');
        $promoInfoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_promo_code ")
                ->where("created_by=:id AND promo_code =:code ", array(':id' => $userid, ':code' => $promocode))
                ->queryRow();
        $status = "Invalid Promo Code";

        if (!empty($promoInfoArr) && count($promoInfoArr) > 0) {
            if ($promoInfoArr['promo_status'] == "Used") {
                $status = "Promo Code has Already Used";
            } elseif (strtotime($promoInfoArr['expired_date']) < strtotime(date("Y-m-d"))) {
                $status = "Promo Code has Expired";
            } else {
                $status = "available";
                $returnOutputArr['promoid'] = $promoInfoArr['promo_id'];
            }
        }

        $returnOutputArr['promo_status'] = $status;
        echo json_encode(array('result' => $returnOutputArr));
    }

    public function actionlistDocAppointment($doctorid, $type) {
        $enc_key = Yii::app()->params->enc_key;
        $appointmentmodel = new AptmtQuery;
        $id = Yii::app()->getSecurityManager()->decrypt($doctorid, $enc_key);
        $serviceArr = '';
        $paymentArr = '';
        if ($type == 'Appointment') {
            $type = 'Appointment';
        } else if ($type == 'Services' || $type == 'Discount') {
            $serviceArr = Yii::app()->db->createCommand()
                    ->select('service_name,service_discount,corporate_discount')
                    ->from(' az_service_master sm')
                    ->join('az_service_user_mapping sum', 'sm.service_id = sum.service_id')
                    ->where(' sum.user_id=:did', array(':did' => $id))
                    ->queryAll();
        } else if ($type == 'Payment') {
            $paymentArr = Yii::app()->db->createCommand()
                    ->select('payment_type')
                    ->from(' az_clinic_details')
                    ->where(' doctor_id=:did', array(':did' => $id))
                    ->queryScalar();
        }
        $this->render('listDocAppointment', array('appointmentmodel' => $appointmentmodel, 'serviceArr' => $serviceArr, 'id' => $id, 'type' => $type, 'paymentArr' => $paymentArr));
    }

    public function actionDailyFreeOffer() {
        $session = new CHttpSession;
        $session->open();
        $request = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;
        //$session['opendailyfreeoffer'] = "yes";
        $redirectUrl = $request->getPost("redirectUrl");
        if (isset($session['user_id']) && !empty($session['user_id'])) {
            unset($session['opendailyfreeoffer']);
            $this->renderPartial('dailyoffer_login_select', array());
        } else {
            $session['opendailyfreeoffer'] = "yes";
            $this->renderPartial('login', array('model' => new LoginForm, "redirectUrl" => $redirectUrl));
        }
    }

    public function actionDataFromLocation() {
        $returnArr[] = array();
        $request = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;
        $htmlstr = "No Record Found";
        if (isset($_POST['location']) && !empty($_POST['location'])) {
            $location = $request->getPost("location");
            $iscity = $request->getPost("is_city");
            $promo_date = $request->getPost("promo_date");
            $dayofweek = date("l", strtotime($promo_date));
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
            //print_r($specWiseCnt);
            $serviceWiseCnt = Yii::app()->db->createCommand()
                    ->select('u.role_id,sum(u.free_opd_perday) AS ufreeopd,r.icon_name,r.role_name')
                    ->from('az_user_details u')->leftJoin("az_role_master r", "r.role_id = u.role_id")
                    ->where($otherServiceStr, $paramArr)->group("u.role_id")
                    ->queryAll();
            //print_r($serviceWiseCnt);exit;
            $cnt = 0;
            $htmlstr = "<div class='col-sm-12'>";
            $htmlstr .= "<ul id='accordion' class='accordion'>";
            $htmlstr .= "<li>";
            $htmlstr .= "<span class='col-sm-3 text-center' style='display:block;margin: 5px 0;'>";
            $htmlstr .= "<img src='" . Yii::app()->baseUrl . "/images/icons/doctors_hospital.png' width='50'>";
            $htmlstr .= "</span>";

            if (count($specWiseCnt) > 0) {
                $htmlstr .= "<div class='link' onclick='toggleSubmenu();'> Doctors/Hospital <i class='fa fa-chevron-down'></i>";
                $htmlstr .= "<span class='pull-right' style='padding-right:15px'>Free Coupon </span></div>";
                $htmlstr .= "<ul class='submenu col-md-9 pull-right'>";
                foreach ($specWiseCnt as $row) {
                    $spcnt = $row['ufreeopd'];
                    $usedOpdCnt = Yii::app()->db->createCommand()->select("count(`appointment_id`) totalapp")->from("az_patient_appointment_details")->where("`promo_id` is not null and doctor_id IN(SELECT u.user_id FROM az_user_details u LEFT JOIN `az_clinic_details` cd ON cd.doctor_id = u.user_id LEFT JOIN az_speciality_user_mapping spm ON spm.user_id = u.user_id WHERE spm.speciality_id = :spid and u.is_active = 1) AND appointment_date = :appdate ", array(":spid" => $row['speciality_id'], ":appdate" => date("Y-m-d", strtotime($promo_date))))->queryScalar();
                    $spcnt = $spcnt - $usedOpdCnt;
                    $redLink = "#";
                    $countText = "Closed";
                    if ($spcnt != 0) {
                        $redLink = Yii::app()->createUrl("site/searchResult", array('speciality' => $row['speciality_name'], 'location' => $location, 'iscity' => $iscity, "source" => "freeoffer", "dayofweek" => $dayofweek));
                        $countText = "Free Nos - <span id='doc_cnt'> $spcnt</span>  </span>";
                    }
                    $htmlstr .= "<li> <a href='" . $redLink . "'> " . $row['speciality_name'] . " <span class='pull-right' style='padding-right:10px'>$countText</a>";
                    $htmlstr .= "</li>";
                }
                $htmlstr .= "</ul><div class='clearfix'></div>";
            }
            $htmlstr .= "</li>";
            if (count($serviceWiseCnt)) {
                foreach ($serviceWiseCnt as $serrow) {
                    $spcnt = $serrow['ufreeopd'];
                    $htmlstr .= "<li class=''>";
                    $htmlstr .= "<a href='#'><span class='col-sm-3 text-center' style='display:block;margin: 5px 0;'>";
                    $htmlstr .= "<img src='" . Yii::app()->baseUrl . "/images/icons/" . $serrow['icon_name'] . "' width='50'>";
                    $htmlstr .= "</span>";
                    $htmlstr .= "<div class='link'> " . $serrow['role_name'] . "<i class='fa fa-chevron-down'></i>";
                    $htmlstr .= "<span class='pull-right' style='padding-right:15px'>$spcnt Free Coupon </span></div></a>";
                    $htmlstr .= "<div class='clearfix'></div></li>";
                }
            }
            $htmlstr .= "</ul>";
            $htmlstr .= "</div>";
        }
        echo ($htmlstr);
    }

    public function actionSavePromoCode() {
        $session = new CHttpSession;
        $session->open();
        $user_id = $session['user_id'];
        $request = Yii::app()->request;
        $purifiedObj = Yii::app()->purifier;
        $todayDate = date("Y-m-d");
        $promo_code = Yii::app()->db->createCommand()
                ->select('promo_code')
                ->from('az_promo_code')
                ->where("created_by = :uid AND promo_status = 'Unused' AND expired_date >= :today", array(":uid" => $user_id, ":today" => $todayDate))
                ->order("promo_id desc")->limit(1)
                ->queryScalar();

        //  print_r($is_generate);
        if (empty($promo_code)) {
            $promo_code = rand(11111, 99999) . $user_id;

            $model = new PromoCode;
            $model->promo_code = $promo_code;
            $model->generate_date = $todayDate;
            $expired_date = date('Y-m-d', strtotime($todayDate . ' + 15 days')); //strtotime('+15 days',$promo_date);
            $model->expired_date = $expired_date;
            $model->created_by = $user_id;
            $model->promo_status = "Unused";
            $model->save();
        }

        echo $promo_code;
    }

    public function actionTreatmentDetails($id) {
        $session = new CHttpSession;
        $session->open();
        $userid = $session['user_id'];
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);

        $appointmentpayment = PatientAppointmentDetails::model()->findByAttributes(array('appointment_id' => $id));

        $model = new TreatmentDetails;
        $model3 = new DocumentDetails;
        if (isset($_POST['TreatmentDetails'])) {
            $purifiedObj = Yii::app()->purifier;
            $request = Yii::app()->request;
            $postArr = $request->getPost("TreatmentDetails");
            $model->appointment_id = $id;
            $model->patient_id = $appointmentpayment['patient_id'];
            $model->symptoms = $purifiedObj->getPurifyText($postArr['symptoms']);
            $model->treatment = $purifiedObj->getPurifyText($postArr['treatment']);
            $model->created_by = $userid;
            $model->created_date = date('Y-m-d H:i:s');



            if ($model->save()) {
                $user_id = $model->patient_id;
                $apt_id = $model->appointment_id;
                $docname = CUploadedFile::getInstance($model3, 'document');
                if (!empty($docname)) {
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
                    $path_part = pathinfo($docname->name);
                    $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                    $model3->document = $dname;
                    $docname->saveAs($baseDir . $model3->document);
                    $model3->doc_type = 'Patient_document';
                    $model3->user_id = $user_id;
                    $model3->appointment_id = $apt_id;
                    if ($model3->save()) {
                        Yii::app()->user->setFlash('Success', 'Success');
                    }
                }
                $this->redirect(array('site/docViewAppointment'));
            }
        } //  $model->unsetAttributes();   
        $this->render('treatmentDetails', array('model' => $model, 'model3' => $model3, 'appointmentpayment' => $appointmentpayment));
    }

    public function actionListLabAppointment($centerid) {
        $enc_key = Yii::app()->params->enc_key;
        $appointmentmodel = new AptmtQuery;
        $id = Yii::app()->getSecurityManager()->decrypt($centerid, $enc_key);

        $this->render('listLabAppointment', array('appointmentmodel' => $appointmentmodel, 'id' => $id));
    }

    public function actionConfirmLabTest($id) {
        $model = LabBookDetails ::model()->findByattributes(array('book_id' => $id));
        $session = new CHttpSession;
        $session->open();
        $roleId = $session['user_role_id'];
        $center_id = $model->center_id;
        if (isset($_POST['LabBookDetails'])) {

            $purifiedObj = Yii::app()->purifier;
            $request = Yii::app()->request;
            $postArr = $request->getPost("LabBookDetails");
            if (!empty($postArr['relation'])) {
                $model->relation = $purifiedObj->getPurifyText($postArr['relation']);
            }

            $model->full_name = $purifiedObj->getPurifyText($postArr['full_name']);
            $model->mobile_no = $purifiedObj->getPurifyText($postArr['mobile_no']);
            $model->patient_age = $purifiedObj->getPurifyText($postArr['patient_age']);
            if (!empty($postArr['service_name'])) {
                $model->service_name = $purifiedObj->getPurifyText($postArr['service_name']);
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
            $model->status = $purifiedObj->getPurifyText($postArr['status']);
            if ($model->save()) {
                Yii::app()->user->setFlash('Success', 'You have successfully Confirm Appointment.');
                $this->redirect(array('site/labViewAppointment', 'roleid' => $roleId));
            }
        }


        $this->render('updateLabPatient', array('model' => $model, 'id' => $id, 'role' => $roleId, 'center_id' => $center_id));
    }

    public function actionGetDeliveryCharges() {
        $request = Yii::app()->request;

        $userid = $request->getPost('userid');
        $deliveryCharge = Yii::app()->db->createCommand()
                ->select("doctor_fees")
                ->from("az_user_details ")
                ->where("user_id=:id ", array(':id' => $userid))
                ->queryScalar();

        echo json_encode($deliveryCharge);
    }

    public function actionMedicalPayment() {

        $request = Yii::app()->request;

        $totalamount = $request->getPost('totalamount');
        $extracharge = $request->getPost('extracharge');
        $role = $request->getPost('role');
        $patientid = $request->getPost('patientid');
        $bookid = $request->getPost('bookid');
        $doctorid = $request->getPost('doctorid');
        $flag = 0;
        try {
            $model = new AppointmentPaymentTable;

            // if($totalamount !=0 && $role !=0 && $patientid !=0 ){
            $model->payment_amt = $totalamount;
            if (!empty($extracharge)) {
                $model->extra_charge = $extracharge;
            }
            $model->user_type = $role;
            $model->patient_id = $patientid;
            $model->appointment_id = $bookid;
            $model->user_id = $doctorid;
            $model->created_date = date('Y-m-d H:i:s');
            if ($model->save()) {
                $flag = 1;
                Yii::app()->user->setFlash('Success', 'Medical Payment On Way ');
            } else {
                throw new Exception("Problem in Add Payment");
            }
        } catch (Exception $ex) {
            
        }
        echo json_encode($flag);
    }

    public function actionListOfServices($centerid, $role, $type) {
        $enc_key = Yii::app()->params->enc_key;
        $centerid = Yii::app()->getSecurityManager()->decrypt($centerid, $enc_key);


        $labInfoArr = Yii::app()->db->createCommand()
                ->select("*")
                ->from("az_user_details ")
                ->where(" role_id=:role And user_id=:id", array(':role' => $role, ':id' => $centerid))
                ->queryRow();
        $serviceArr = '';
        $paymentArr = '';
        if ($type == 'Services' || $type == 'Discount') {
            $serviceArr = Yii::app()->db->createCommand()
                    ->select('service_name,service_discount,corporate_discount')
                    ->from(' az_service_master sm')
                    ->join('az_service_user_mapping sum', 'sm.service_id = sum.service_id')
                    ->where(' sum.user_id=:did', array(':did' => $centerid))
                    ->queryAll();
        }
        if ($type == 'Amenities') {
            
        }

        if ($type == 'Payment') {
            $paymentArr = Yii::app()->db->createCommand()
                    ->select('payment_type')
                    ->from(' az_user_details')
                    ->where(' user_id=:did', array(':did' => $centerid))
                    ->queryScalar();
        }


        $this->render('listofServices', array('labInfoArr' => $labInfoArr, 'role' => $role, 'type' => $type, 'serviceArr' => $serviceArr, 'paymentArr' => $paymentArr));
    }

}
