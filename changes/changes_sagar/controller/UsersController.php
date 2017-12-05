<?php

class UsersController extends Controller {

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('diagnostic', 'updateDiagnostic', 'manageDiagnostic', 'viewDiagnostic', 'bloodBank', 'getSubSpeciality', 'updateAdminBloodBank', 'updateBloodBank', 'manageBloodBank', 'createAdminBloodBank', 'viewBloodBank', 'updateHospitalServices', 'viewServices', 'ambulanceDetails', 'manageAmbulanceServices', 'addAdminEmergencyServices', 'updateAdminEmergencyServices', 'viewEmergencyServices', 'getOpdtrnsferDoctor', 'transferOpd', 'manageInactiveDiagnostic', 'manageInactiveBloodBank', 'manageInactiveAmbulanceServices', 'editReport', 'manageHospitalServices', 'addHospitalServices', 'deleteRec', 'getDocument', 'manageAppointmentServices'),
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

    public function loadModel($id) {
        $model = UserDetails::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionDiagnostic() {
        $roleid = Yii::app()->request->getParam('roleid');

        $roleid = base64_decode($roleid);


        $model = new UserDetails;
        $model3 = new DocumentDetails;
        $model4 = new ServiceUserMapping;
        $model6 = new ClinicVisitingDetails;
        $model7 = new BankDetails;
        $commonobj = new CommonFunction;
        $session = new CHttpSession;
        $data = "";
        $commonobj = new CommonFunction;


        if (isset($_POST['UserDetails']) && count($_POST['UserDetails']) > 0) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = 7;
                //$model->is_active = 0;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password'])) {
                    $model->password = md5($postArr['password']);
                }
                $model->other_est_type = $purifiedObj->getPurifyText($postArr['other_est_type']);
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
                $model->free_opd_perday = $postArr['free_opd_perday'];

                $Daystr = NULL;
                if (isset($postArr['free_opd_preferdays']) && count($postArr['free_opd_preferdays']) > 0) {
                    foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                        $Daystr.=$value . ",";
                    }
                }

                if (isset($postArr['payment_type'])) {
                    $model->payment_type = implode(",", $postArr['payment_type']);
                }

                $model->free_opd_preferdays = $Daystr;

                $model->created_date = date("Y-m-d H:i:s");
                $model->created_by = Yii::app()->user->id;

                if ($model->save()) {

                    $user_id = $model->user_id;
                    $mobile = $model->mobile;


                    if (isset($_POST['UserDetails']['is_open_allday']) && $_POST['UserDetails']['is_open_allday'] == 'Y') {
                        $model->is_open_allday = 'Y';
                        $model->save();
                    } else {
                        if (isset($_POST['ClinicVisitingDetails']['clinic_open_time'][0])) {
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
                                    $ClinicVisitingDetails->role_type = 'diagnostic';
                                    if (!$ClinicVisitingDetails->save()) {
                                        throw new Exception("Error in saving days");
                                    }
                                }
                            }
                        }
                    }


                    if (isset($_POST['ServiceUserMapping']['service_id'][0]) && !empty($_POST['ServiceUserMapping']['service_id'][0])) {
                        $serivceIdArr = array();
                        $serivceIdArr = $_POST['ServiceUserMapping'];
                        foreach ($serivceIdArr['service_id'] as $key => $value) {
                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $purifiedObj->getPurifyText($value);
                            $serviceUserMappingobj->user_id = $user_id;
                            $serviceUserMappingobj->service_discount = $serivceIdArr['service_discount'][$key];
                            $serviceUserMappingobj->corporate_discount = $serivceIdArr['corporate_discount'][$key];
                            $serviceUserMappingobj->is_available_allday = $serivceIdArr['twentyfour'][$key];
                            $serviceUserMappingobj->is_clinic = 0;

                            if (!$serviceUserMappingobj->save()) {

                                throw new Exception("Error in saving service user data");
                            }
                        }
                    }
                    
                    if (!empty($_POST['BankDetails']['acc_holder_name'])) {
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
                                //  print_r($bank->getErrors()); //exit;
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
                            $docdetails->doc_type = 'other_photos';
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
                        $model3->doc_type = 'Diagnostic_Registration';
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
                        $otherdoc->doc_type = 'Diagnostic_Oth_Registration';
                        $otherdoc->user_id = $user_id;
                        if ($otherdoc->save()) {
                            
                        }
                    }


                    $transaction->commit();
                    $commonobj->sendSms($mobile, "Thanks for your registration. Your profile will shortly be activated after a small verification process.");
                    Yii::app()->user->setFlash('Success', 'You have successfully registered. Your account will be activated after verification.');
                    $this->redirect(array('users/diagnostic'));
                }
            } catch (Exception $ex) {
                $model->addError(NULL, $ex->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('diagnostic', array(
            'model' => $model, 'model3' => $model3, 'model4' => $model4, 'model6' => $model6, 'model7' => $model7, 'session' => $session
        ));
    }

    public function actionUpdateDiagnostic() {
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
        $data = "";
        if (isset($_POST['UserDetails'])) {
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }
        }


        //print_r($_POST);exit;
        if (isset($_POST['UserDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;

                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = 7;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                // $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password']))
                    $model->password = md5($postArr['password']);
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);

//                if (!empty($postArr['hos_establishment']))
//                    $model->hos_establishment = $purifiedObj->getPurifyText($postArr['hos_establishment']);
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

                $model->free_opd_perday = $postArr['free_opd_perday'];
                $Daystr = NULL;
                if ((!empty($postArr['free_opd_preferdays']))) {
                    foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                        $Daystr.=$value . ",";
                    }

                    $model->free_opd_preferdays = $Daystr;
                }


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
                                $ClinicVisitingDetails->role_type = 'diagnostic';
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
                        //  print_r($serivceIdArr);//exit;
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
                            $docdetails->doc_type = 'other_photos';
                            $docdetails->user_id = $user_id;
                            if ($docdetails->save()) {
                                
                            }
                        }
                    }

                    $docname = CUploadedFile::getInstance($model3, 'document');
                    if (!empty($docname)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Diagnostic_Registration'));
                        $model3 = new DocumentDetails;
                        if (!empty($docname)) {
                            $path_part = pathinfo($docname->name);
                            $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $model3->document = $dname;
                            $docname->saveAs($baseDir . $model3->document);
                            $model3->doc_type = 'Diagnostic_Registration';
                            $model3->user_id = $user_id;
                            if ($model3->save()) {
                                
                            }
                        }
                    }
                    $otherdoc = new DocumentDetails;
                    $otherdocname = CUploadedFile::getInstance($model3, 'otherdoc');
                    if (!empty($otherdocname)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Diagnostic_Oth_Registration'));

                        if (!empty($otherdocname)) {
                            $path_part = pathinfo($otherdocname->name);
                            $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $otherdoc->document = $dname;
                            $otherdocname->saveAs($baseDir . $otherdoc->document);
                            $otherdoc->doc_type = 'Diagnostic_Oth_Registration';
                            $otherdoc->user_id = $user_id;
                            if ($otherdoc->save()) {
                                
                            }
                        }
                    }
                    $transaction->commit();

                    Yii::app()->user->setFlash('Success', 'You have successfully Updated Your Profile');
                    $this->redirect(array('site/labViewAppointment', 'roleid' => 7));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('updateDiagnostic', array('id' => $id, 'model' => $model, 'serviceUserMapping' => $serviceUserMapping, 'model3' => $model3, 'model7' => $model7));
    }

    public function actionManageDiagnostic() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('searchPathology');
        $model->unsetAttributes();  // clear any default values
        //    $model->hospital_name='ABC';
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageDiagnostic', array(
            'model' => $model,
        ));
    }

    public function actionViewDiagnostic($id) {
        $this->layout = 'adminLayout';

        try {
            $enc_key = Yii::app()->params->enc_key;
            $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        } catch (Exception $ex) {
            $model->addError(NULL, $ex->getMessage());
        }

        $this->render('viewDiagnostic', array(
            'model' => $this->loadModel($id)
        ));
    }

    public function actionGetSubSpeciality() {
        $request = Yii::app()->request;
        $Specialityname = $request->getParam('speciality');

        $spArr = explode(",", $Specialityname);
        // SELECT speciality_id,sub_speciality_name from az_sub_speciality WHERE speciality_id IN (1, 4)

        $cmd = Yii::app()->db->createCommand()
                ->select('speciality_id,sub_speciality_name,sub_speciality_id')
                ->from('az_sub_speciality')
                ->where(array('in', 'speciality_id', $spArr))
                ->queryAll();


        $returnArr['sub_speciality_name'] = $cmd;
        echo json_encode(array('data' => $cmd));
    }

    public function actionCreateAdminBloodBank($role) {
        $enc_key = Yii::app()->params->enc_key;
         $session = new CHttpSession;
        $session->open();
        $login_role_id = $session["user_role_id"];
        $this->layout = 'adminLayout';
        $model = new UserDetails;
        $model1 = new ServiceUserMapping;
        $model3 = new DocumentDetails;
        $model7 = new BankDetails;
        $model6 = new ClinicVisitingDetails;
        $data = "";
        if (isset($_POST['UserDetails'])) {

            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }

            $request = Yii::app()->request;
            $purifiedObj = Yii::app()->purifier;
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $postArr = Yii::app()->request->getParam('UserDetails');
                $model->role_id = $role;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->type_of_establishment = $purifiedObj->getPurifyText($postArr['type_of_establishment']);
                if (!empty($postArr['other_est_type']))
                    $model->other_est_type = $postArr['other_est_type'];
                $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
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
                if($login_role_id == 5){
                $model->parent_hosp_id = Yii::app()->user->id;
                }
                
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
                $model->created_date = date("Y-m-d H:i:s");
               // $model->updated_by = Yii::app()->user->id;
                $model->is_active = 1;
                $model->created_by = Yii::app()->user->id;
                // $model->registration_Fees = $purifiedObj->getPurifyText($postArr['registration_Fees']);
                // if(isset($postArr['discount']))
                //$model->discount = $purifiedObj->getPurifyText($postArr['discount']);
                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']);
                if (!empty($postArr['doctor_fees'])) {       //used as delivery charges for medical
                    $model->doctor_fees = $purifiedObj->getPurifyText($postArr['doctor_fees']);
                }

                if (!empty($postArr['payment_type'])) {
                    $model->payment_type = implode(",", $postArr['payment_type']);
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


                 $profileImageObj = CUploadedFile::getInstance($model, "profile_image");
                    if (!empty($profileImageObj)) {
                        $path_part = pathinfo($profileImageObj->name);
                        $fname = $profileDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model->profile_image = $fname;
                        if ($profileImageObj->saveAs($baseDir . $model->profile_image)) {
                            $model->save();
                        }
                    }
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
                                $ClinicVisitingDetails->clinic_open_time = $selecteddays['clinic_open_time'][$key];
                                $ClinicVisitingDetails->clinic_close_time = $selecteddays['clinic_close_time'][$key];
                                $ClinicVisitingDetails->clinic_eve_open_time = $selecteddays['clinic_eve_open_time'][$key];
                                $ClinicVisitingDetails->clinic_eve_close_time = $selecteddays['clinic_eve_close_time'][$key];
                                if ($role == 8) {
                                    $ClinicVisitingDetails->role_type = 'Blood-Bank';
                                }
                                if ($role == 9) {
                                    $ClinicVisitingDetails->role_type = 'Medical';
                                }
                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving days");
                                }
                            }
                        }
                    }

                    if (isset($_POST['service']) && count($_POST['service']) > 1) {
                        

                        foreach ($_POST['service'] as $key => $value) {
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
                            throw new Exception("Error in saving BankDetails");
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
                    $docname = CUploadedFile::getInstance($model3, 'document');
                    if (!empty($docname)) {
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model3->document = $dname;
                        $docname->saveAs($baseDir . $model3->document);
                        $model3->doc_type = 'Blood-Bank_Registration';
                        $model3->user_id = $user_id;
                        if ($model3->save()) {
                            
                        }
                    }
                    $transaction->commit();
                    $this->redirect(array('users/viewServices', 'id' => Yii::app()->getSecurityManager()->encrypt($user_id, $enc_key),'role'=>$role));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('createAdminBloodBank', array('model' => $model, 'model1' => $model1, 'model3' => $model3, 'model6' => $model6, 'model7' => $model7, 'role' => $role,'login_role_id'=>$login_role_id));
    }

    public function actionUpdateAdminBloodBank($id, $role) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $session = new CHttpSession;
        $session->open();
        $login_role_id = $session["user_role_id"];
        
        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));             //Userdetails
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        if (empty($serviceUserMapping)) {
            $serviceUserMapping[] = new ServiceUserMapping;
        }
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model3)) {
            $model3 = new DocumentDetails;
        }
        $model7 = BankDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model7)) {
            $model7 = new BankDetails;
        }
        $ClinicVisitingDetails = ClinicVisitingDetails::model()->findByAttributes(array('doctor_id' => $id));
        if (empty($ClinicVisitingDetails)) {
            $ClinicVisitingDetails[] = new ClinicVisitingDetails;
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
                $model->type_of_establishment = $purifiedObj->getPurifyText($postArr['type_of_establishment']);
                if (!empty($postArr['other_est_type']))
                    $model->other_est_type = $postArr['other_est_type'];
                $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                if (!empty($postArr['hos_establishment']) && $role == 8) {
                    $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
                }
//                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
//                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
                $model->apt_contact_no_1 = $purifiedObj->getPurifyText($postArr['apt_contact_no_1']);
                $model->apt_contact_no_2 = $purifiedObj->getPurifyText($postArr['apt_contact_no_2']);
                $model->email_1 = $purifiedObj->getPurifyText($postArr['email_1']);
                $model->email_2 = $purifiedObj->getPurifyText($postArr['email_2']);
                $model->coordinator_name_1 = $purifiedObj->getPurifyText($postArr['coordinator_name_1']);
                $model->coordinator_mobile_1 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_1']);
                if (isset($postArr['coordinator_email_1'])) {
                    $model->coordinator_email_1 = $purifiedObj->getPurifyText($postArr['coordinator_email_1']);
                }
                $model->coordinator_name_2 = $purifiedObj->getPurifyText($postArr['coordinator_name_2']);
                $model->coordinator_mobile_2 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_2']);
                if (isset($postArr['coordinator_email_2'])) {
                    $model->coordinator_email_2 = $purifiedObj->getPurifyText($postArr['coordinator_email_2']);
                }
                $model->description = $purifiedObj->getPurifyText($postArr['description']);
                if($login_role_id == 5){
                $model->parent_hosp_id = Yii::app()->user->id;
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
                $model->updated_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;
                // $model->registration_Fees = $purifiedObj->getPurifyText($postArr['registration_Fees']);
                // if(isset($postArr['discount']))
                //$model->discount = $postArr['discount'];
                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                $model->extra_charges = $postArr['extra_charges'];
                if ($model->save()) {

                    $user_id = $model->user_id;

                    Yii::app()->db->createCommand()->delete('az_clinic_visiting_details', 'doctor_id=:id', array(':id' => $user_id));


                    if (isset($_POST['UserDetails']['is_open_allday']) && $_POST['UserDetails']['is_open_allday'] == 'Y') {
                        $model->is_open_allday = 'Y';
                        $model->save();
                    } else {
                        $clinicvisit = Yii::app()->request->getParam('ClinicVisitingDetails');

                        if (isset($clinicvisit['day']) && count($clinicvisit['day']) > 0) {

                            foreach ($clinicvisit['day'] as $key => $value) {

                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = 0;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;
                                 $ClinicVisitingDetails->clinic_open_time = (!empty($clinicvisit['clinic_open_time'][$key])) ? date('H:i:s', strtotime($clinicvisit['clinic_open_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_close_time = (!empty($clinicvisit['clinic_close_time'][$key])) ? date('H:i:s', strtotime($clinicvisit['clinic_close_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_eve_open_time =(!empty($clinicvisit['clinic_eve_open_time'][$key])) ?  date('H:i:s', strtotime($clinicvisit['clinic_eve_open_time'][$key])) : NULL;
                                $ClinicVisitingDetails->clinic_eve_close_time = (!empty($clinicvisit['clinic_eve_close_time'][$key])) ?  date('H:i:s', strtotime($clinicvisit['clinic_eve_close_time'][$key])) : NULL;
                                if ($role == 8) {
                                    $ClinicVisitingDetails->role_type = 'Blood-Bank';
                                }
                                if ($role == 9) {
                                    $ClinicVisitingDetails->role_type = 'Medical';
                                }
                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving Timigs");
                                }
                            }
                            $model->is_open_allday = 'N';
                            $model->save();
                        }
                    }

                    Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'user_id=:id AND is_clinic=:isclinic', array(':id' => $user_id, ':isclinic' => '0'));
                   
                    if (isset($_POST['service']) && count($_POST['service']) > 0) {

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

                    Yii::app()->db->createCommand()->delete('az_bank_details', 'user_id=:id', array(':id' => $user_id));

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
                            throw new Exception("Error in saving BankDetails");
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

                    $docname = CUploadedFile::getInstance($model, 'document');
                    
                    if (!empty($docname)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Diagnostic_Registration'));

                        $model3 = new DocumentDetails;
                        if (!empty($docname)) {
                            $path_part = pathinfo($docname->name);
                            $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $model3->document = $dname;
                            $docname->saveAs($baseDir . $model3->document);
                            $model3->doc_type = 'Blood-Bank_Registration';
                            $model3->user_id = $user_id;
                            if ($model3->save()) {
                                
                            }
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
            } catch (Exception $ex) {
                $model->addError(NULL, $ex->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('updateAdminBloodBank', array('model' => $model, 'id' => $id, 'model7' => $model7, 'model3' => $model3, 'serviceUserMapping' => $serviceUserMapping, 'ClinicVisitingDetails' => $ClinicVisitingDetails, 'role' => $role,'login_role_id'=>$login_role_id));
    }

    public function actionManageBloodBank($roleid) {
        $this->layout = 'adminLayout';
        $model = new UserDetails('searchbloodbank');
        $model->unsetAttributes();  // clear any default values
        //    $model->hospital_name='ABC';
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageBloodBank', array(
            'model' => $model, 'roleid' => $roleid
        ));
    }

    public function actionUpdateBloodBank($roleid) {

        $enc_key = Yii::app()->params->enc_key;
        $roleid = Yii::app()->getSecurityManager()->decrypt($roleid, $enc_key);
        $id = Yii::app()->user->id;
        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));          //Userdetails
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model3)) {
            $model3 = new DocumentDetails;
        }
        $model7 = BankDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model7)) {
            $model7 = new BankDetails;
        }
        if (empty($serviceUserMapping)) {
            $serviceUserMapping[] = new ServiceUserMapping;
        }

        $ClinicVisitingDetails = ClinicVisitingDetails::model()->findByAttributes(array('doctor_id' => $id));
        if (empty($ClinicVisitingDetails)) {
            $ClinicVisitingDetails = new ClinicVisitingDetails();
        }

        if (isset($_POST['UserDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = $roleid;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->type_of_establishment = $purifiedObj->getPurifyText($postArr['type_of_establishment']);
                if (!empty($postArr['other_est_type']))
                    $model->other_est_type = $postArr['other_est_type'];
                $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                if (!empty($postArr['hos_establishment']))
                    $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
//                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
//                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password']))
                    $model->password = md5($postArr['password']);
                $model->apt_contact_no_1 = $purifiedObj->getPurifyText($postArr['apt_contact_no_1']);
                $model->apt_contact_no_2 = $purifiedObj->getPurifyText($postArr['apt_contact_no_2']);
                $model->email_1 = $purifiedObj->getPurifyText($postArr['email_1']);
                $model->email_2 = $purifiedObj->getPurifyText($postArr['email_2']);
                $model->coordinator_name_1 = $purifiedObj->getPurifyText($postArr['coordinator_name_1']);
                $model->coordinator_mobile_1 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_1']);
                if (isset($postArr['coordinator_email_1'])) {
                    $model->coordinator_email_1 = $purifiedObj->getPurifyText($postArr['coordinator_email_1']);
                }
                $model->coordinator_name_2 = $purifiedObj->getPurifyText($postArr['coordinator_name_2']);
                $model->coordinator_mobile_2 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_2']);
                if (isset($postArr['coordinator_email_2'])) {
                    $model->coordinator_email_2 = $purifiedObj->getPurifyText($postArr['coordinator_email_2']);
                }
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
                $model->updated_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;
                // $model->registration_Fees = $purifiedObj->getPurifyText($postArr['registration_Fees']);
//                if(isset($postArr['discount']))
//                $model->discount = $purifiedObj->getPurifyText($postArr['discount']);
                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']);

                $paymentstr = NULL;
                if ((!empty($postArr['payment_type']))) {

                    foreach ($postArr['payment_type'] as $key => $value) {
                        $paymentstr .= $value . ",";
                    }

                    $model->payment_type = $paymentstr;
                }
                if ($model->save()) {

                    $user_id = $model->user_id;

                    Yii::app()->db->createCommand()->delete('az_clinic_visiting_details', 'doctor_id=:id', array(':id' => $user_id));


                    if (isset($_POST['UserDetails']['is_open_allday']) && $_POST['UserDetails']['is_open_allday'] == 'Y') {
                        $model->is_open_allday = 'Y';
                        $model->save();
                    } else {
                        $clinicvisit = Yii::app()->request->getParam('ClinicVisitingDetails');

                        if (isset($clinicvisit['day']) && count($clinicvisit['day']) > 0) {

                            foreach ($clinicvisit['day'] as $key => $value) {

                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = 0;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;
                                $ClinicVisitingDetails->clinic_open_time = $clinicvisit['clinic_open_time'][$key];
                                $ClinicVisitingDetails->clinic_close_time = $clinicvisit['clinic_close_time'][$key];
                                $ClinicVisitingDetails->clinic_eve_open_time = $clinicvisit['clinic_eve_open_time'][$key];
                                $ClinicVisitingDetails->clinic_eve_close_time = $clinicvisit['clinic_eve_close_time'][$key];
                                if ($roleid == 8) {
                                    $ClinicVisitingDetails->role_type = "Blood-Bank";
                                }
                                if ($roleid == 9) {
                                    $ClinicVisitingDetails->role_type = "Medical";
                                }
                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving Timigs");
                                }
                            }
                            $model->is_open_allday = 'N';
                            $model->save();
                        }
                    }

                    Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'user_id=:id AND is_clinic=:isclinic', array(':id' => $user_id, ':isclinic' => '0'));

                    if (isset($_POST['service']) && count($_POST['service']) > 0) {

                        foreach ($_POST['service'] as $key => $value) {
                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $value;
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

                    Yii::app()->db->createCommand()->delete('az_bank_details', 'user_id=:id', array(':id' => $user_id));

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
                            throw new Exception("Error in saving BankDetails");
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

                    $docname = CUploadedFile::getInstance($model, 'document');

                    if (!empty($docname)) {
                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Diagnostic_Registration'));

                        $model3 = new DocumentDetails;
                        if (!empty($docname)) {
                            $path_part = pathinfo($docname->name);
                            $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                            $model3->document = $dname;
                            $docname->saveAs($baseDir . $model3->document);
                            $model3->doc_type = 'Blood-Bank_Registration';
                            $model3->user_id = $user_id;
                            if ($model3->save()) {
                                
                            }
                        }
                    }

                    $transaction->commit();
                    Yii::app()->user->setFlash('Success', 'You have successfully Updated Your Profile');
                    $this->redirect(array('site/labViewAppointment', 'roleid' => $roleid));
                }
            } catch (Exception $ex) {
                $model->addError(NULL, $ex->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('updateBloodBank', array('id' => $id, 'model' => $model, 'serviceUserMapping' => $serviceUserMapping, 'model3' => $model3, 'model7' => $model7, 'ClinicVisitingDetails' => $ClinicVisitingDetails, 'roleid' => $roleid));
    }

    public function actionViewBloodBank($id) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $roleid = Yii::app()->request->getParam('role');
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = $this->loadModel($id);
        $this->render('viewBloodbank', array('model' => $model, 'roleid' => $roleid, 'id' => $id));
    }

    public function actionManageHospitalServices() {
        $this->layout = 'adminLayout';
        $model = new UserDetails();
        $model->unsetAttributes();  // 
        $this->render('manageHospitalServices', array(
            'model' => $model
        ));
    }

    public function actionAddHospitalServices() {
        $this->layout = 'adminLayout';
        $model = new UserDetails;
        $model1 = new ServiceUserMapping;
        $model3 = new DocumentDetails;
        $model7 = new BankDetails;
        $model6 = new ClinicVisitingDetails;
        $role = $_GET['role_id'];
        if (isset($_POST['UserDetails'])) {
            $request = Yii::app()->request;
            $purifiedObj = Yii::app()->purifier;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                
                $postArr = Yii::app()->request->getParam('UserDetails');
                
                $model->role_id = $role;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                if ($role == 8 || $role == 9) {
                    $model->type_of_establishment = $purifiedObj->getPurifyText($postArr['type_of_establishment']);
                }
                if (!empty($postArr['other_est_type']))
                    $model->other_est_type = $postArr['other_est_type'];
                $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password']))
                    $model->password = md5($postArr['password']);
                if ($role == 6 || $role == 7) {
                    $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                }
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                if ($role == 6 || $role == 7 || $role == 8) {
                    if (!empty($postArr['hos_establishment'])) {
                        $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
                    }
                }
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
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
                $model->country_id = 1;
                $model->country_name = "India";
                $model->parent_hosp_id = Yii::app()->user->id;
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
                $model->created_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;
                if ($role == 8 || $role == 9) {
                    $model->registration_Fees = $purifiedObj->getPurifyText($postArr['registration_Fees']);
                }
                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']);
                $model->is_active = 1;
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


                $profileImageObj = CUploadedFile::getInstance($model, "profile_image");

                if (!empty($profileImageObj)) {
                    $path_part = pathinfo($profileImageObj->name);
                    $fname = $profileDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                    $model->profile_image = $fname;

                    $profileImageObj->saveAs($baseDir . $model->profile_image);
                }
                
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
                                $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key]));
                                if ($role == 6)
                                    $ClinicVisitingDetails->role_type = 'pathology';
                                if ($role == 7)
                                    $ClinicVisitingDetails->role_type = 'diagnostic';
                                if ($role == 8)
                                    $ClinicVisitingDetails->role_type = 'Blood-bank';
                                if ($role == 9)
                                    $ClinicVisitingDetails->role_type = 'Medical-Store';
                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving days");
                                }
                            }
                        }
                    }

                    if (isset($_POST['service']) && count($_POST['service']) > 1) {
                        foreach ($_POST['service'] as $key => $value) {
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
                            throw new Exception("Error in saving BankDetails");
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
                    $docname = CUploadedFile::getInstance($model3, 'document');
                    if (!empty($docname)) {
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model3->document = $dname;
                        $docname->saveAs($baseDir . $model3->document);
                        if ($role == 8) {
                            $model3->doc_type = 'Blood-Bank_Registration';
                        }
                        if ($role == 9) {
                            $model3->doc_type = 'Medical_Registration';
                        }
                        $model3->user_id = $user_id;
                        if ($model3->save()) {
                            
                        }
                    }
                    if ($role == 6 || $role == 7) {
                        $photos = CUploadedFile::getInstancesByName('DocumentDetails[doc_photo]');
                        // proceed if the images have been set
                        if (isset($photos) && count($photos) > 0) {
                            foreach ($photos as $image => $pic) {
                                $docdetails = new DocumentDetails;
                                $path_part = pathinfo($pic->name);
                                $pic_name = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                                $docdetails->document = $pic_name;
                                $pic->saveAs($baseDir . $docdetails->document);
                                $docdetails->doc_type = 'other_photos';
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
                    }
                    $transaction->commit();
                }


                // $this->redirect(array('userDetails/viewhospital', 'id' => Yii::app()->getSecurityManager()->encrypt($model->user_id, $enc_key)));
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('addHospitalServices', array(
            'model' => $model, 'model1' => $model1, 'model3' => $model3, 'model6' => $model6, 'model7' => $model7, 'role' => $role
        ));
    }

    public function actionUpdateHospitalServices($id, $role) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));             //Userdetails
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        if (empty($serviceUserMapping)) {
            $serviceUserMapping = new ServiceUserMapping;
        }
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model3)) {
            $model3 = new DocumentDetails;
        }
        $model7 = BankDetails::model()->findByAttributes(array('user_id' => $id));
        $model6 = ClinicVisitingDetails::model()->findByAttributes(array('doctor_id' => $id));
        if (empty($model6)) {
            $model6 = new ClinicVisitingDetails;
        }
        $oldprofile = $model->profile_image;

        if (isset($_POST['UserDetails'])) {
            $request = Yii::app()->request;
            $purifiedObj = Yii::app()->purifier;
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = $role;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                if ($role == 8 || $role == 9) {
                    $model->type_of_establishment = $purifiedObj->getPurifyText($postArr['type_of_establishment']);
                }
                if (!empty($postArr['other_est_type']))
                    $model->other_est_type = $postArr['other_est_type'];
                $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                if ($role == 6 || $role == 7) {
                    $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                }
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                if ($role == 6 || $role == 7 || $role == 8) {
                    if (!empty($postArr['hos_establishment'])) {
                        $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
                    }
                }
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->last_name = $purifiedObj->getPurifyText($postArr['last_name']);
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
                $model->country_id = 1;
                $model->country_name = "India";
                $model->parent_hosp_id = Yii::app()->user->id;
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
                $model->created_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;
                if ($role == 8 || $role == 9) {
                    $model->registration_Fees = $purifiedObj->getPurifyText($postArr['registration_Fees']);
                    $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                    $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']);
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


                                if ($role == 6)
                                    $ClinicVisitingDetails->role_type = 'pathology';
                                if ($role == 7)
                                    $ClinicVisitingDetails->role_type = 'diagnostic';
                                if ($role == 8)
                                    $ClinicVisitingDetails->role_type = 'Blood-bank';
                                if ($role == 9)
                                    $ClinicVisitingDetails->role_type = 'Medical-Store';

                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving days");
                                }
                            }
                        }
                    }

                    Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'user_id=:id AND clinic_id=:isclinic', array(':id' => $user_id, ':isclinic' => '0'));
                    if (isset($postArr['userservice']) && count($postArr['userservice']) > 0) {

                        foreach ($postArr['userservice'] as $key => $value) {
                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $value;
                            $serviceUserMappingobj->user_id = $user_id;
                            $serviceUserMappingobj->service_discount = $postArr['discount'][$key];
                            $serviceUserMappingobj->corporate_discount = $postArr['corporate_discount'][$key];
                            $serviceUserMappingobj->is_available_allday = $postArr['twentyfour'][$key];
                            $serviceUserMappingobj->is_clinic = 0;
                            if (!$serviceUserMappingobj->save()) {

                                throw new Exception("Error in saving service data");
                            }
                        }
                    }
                    Yii::app()->db->createCommand()->delete('az_bank_details', 'user_id=:id', array(':id' => $user_id));
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
                            throw new Exception("Error in saving BankDetails");
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
                    $docname = CUploadedFile::getInstance($model3, 'document');
                    if (!empty($docname)) {
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model3->document = $dname;
                        $docname->saveAs($baseDir . $model3->document);
                        if ($role == 8) {
                            $model3->doc_type = 'Blood-Bank_Registration';
                        }
                        if ($role == 9) {
                            $model3->doc_type = 'Medical_Registration';
                        }
                        $model3->user_id = $user_id;
                        if ($model3->save()) {
                            
                        }
                    }

                    if ($role == 6 || $role == 7) {

                        $photos = CUploadedFile::getInstancesByName('DocumentDetails[doc_photo]');
                        // proceed if the images have been set
                        if (isset($photos) && count($photos) > 0) {
                            foreach ($photos as $image => $pic) {
                                $docdetails = new DocumentDetails;
                                $path_part = pathinfo($pic->name);
                                $pic_name = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                                $docdetails->document = $pic_name;
                                $pic->saveAs($baseDir . $docdetails->document);
                                $docdetails->doc_type = 'other_photos';
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
                    }
                    $transaction->commit();
                    Yii::app()->user->setFlash('Success', 'You have successfully Updated Your Profile');
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('updateHospitalServices', array(
            'model' => $model, 'model3' => $model3, 'model6' => $model6, 'model7' => $model7, 'serviceUserMapping' => $serviceUserMapping, 'role' => $role, 'id' => $id
        ));
    }

    public function actionViewServices($id, $role) {
        $session = new CHttpSession;
        $session->open();
        $login_role_id = $session["user_role_id"];
        $this->layout = 'adminLayout';
        try {
            $enc_key = Yii::app()->params->enc_key;
            $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
            $model = UserDetails::model()->findByAttributes(array('user_id' => $id));
            $model = UserDetails::model()->findByAttributes(array('user_id' => $id));             //Userdetails
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        if (empty($serviceUserMapping)) {
            $serviceUserMapping[] = new ServiceUserMapping;
        }
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model3)) {
            $model3 = new DocumentDetails;
        }
        $model7 = BankDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model7)) {
            $model7 = new BankDetails;
        }
        $ClinicVisitingDetails = ClinicVisitingDetails::model()->findByAttributes(array('doctor_id' => $id));
        if (empty($ClinicVisitingDetails)) {
            $ClinicVisitingDetails[] = new ClinicVisitingDetails;
        }
            
            
        } catch (Exception $ex) {
            $model->addError(NULL, $ex->getMessage());
        }

        $this->render('viewServices', 
              //  array(
//            'model' => $model, 'role' => $role,'login_role_id'=>$login_role_id,'id'=>$id
//        ));
        
        array('model' => $model, 'id' => $id, 'model7' => $model7, 'model3' => $model3, 'serviceUserMapping' => $serviceUserMapping, 'ClinicVisitingDetails' => $ClinicVisitingDetails, 'role' => $role,'login_role_id'=>$login_role_id));
        
    }

    public function actionManageAmbulanceServices($roleid) {

        $this->layout = 'adminLayout';
        $model = new UserDetails('searchambulance');
        $model->unsetAttributes();  // clear any default values
        //    $model->hospital_name='ABC';
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageAmbulanceServices', array(
            'model' => $model, 'roleid' => $roleid
        ));
    }

    public function actionAddAdminEmergencyServices($roleid) {
         $this->layout = 'adminLayout';
        $model = new UserDetails;
        $model2 = new DocumentDetails;
        $model3 = new BankDetails;
        $model5 = new AmbulanceDetails;
        $request = Yii::app()->request;

        if (isset($_POST['UserDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();

                $purifiedObj = Yii::app()->purifier;
                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = $roleid;
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password']))
                    $model->password = md5($postArr['password']);
                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']);
                $model->emergency = $purifiedObj->getPurifyText($postArr['extra_charges']);

                $model->coordinator_name_1 = $purifiedObj->getPurifyText($postArr['coordinator_name_1']);
                $model->coordinator_mobile_1 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_1']);
                if (isset($postArr['coordinator_email_1'])) {
                    $model->coordinator_email_1 = $purifiedObj->getPurifyText($postArr['coordinator_email_1']);
                }
                if (isset($postArr['coordinator_mobile_2'])) {
                    $model->coordinator_mobile_2 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_2']);
                }

                $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
                $model->country_id = 1;
                $model->country_name = "india";
                $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->latitude = $postArr['latitude'];
                $model->longitude = $postArr['longitude'];
                $model->address = $purifiedObj->getPurifyText($postArr['address']);
                $model->created_date = date("Y-m-d H:i:s");
                $model->created_by = Yii::app()->user->id;

                if ($model->save()) {

                    $user_id = $model->user_id;

                    if (isset($_POST['AmbulanceDetails'])) {
                        $AmbulancedetailsArr = $_POST['AmbulanceDetails'];
                        $bank = new AmbulanceDetails;
                        $model5->ambulance_id = $user_id;
                        $model5->working_day = $AmbulancedetailsArr['working_day'];
//                        $model5->ex_name = Null;    //$AmbulancedetailsArr['ex_name'];
//                       $model5->ex_contact_no = Null;       //$AmbulancedetailsArr['ex_contact_no'];
                        $model5->vehical_no = $AmbulancedetailsArr['vehical_no'];
                        $model5->vehical_type = $AmbulancedetailsArr['vehical_type'];

                        if (!$model5->save()) {

                            throw new Exception("Error in saving AmbulanceDetails");
                        }
                    }


                    $docname = CUploadedFile::getInstance($model2, 'document');

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
                        $model2->document = $dname;
                        $docname->saveAs($baseDir . $model2->document);
                        $model2->doc_type = 'Ambulance_Registration';
                        $model2->user_id = $user_id;
                        if ($model2->save()) {
                            
                        }
                    }

                    $transaction->commit();
                    Yii::app()->user->setFlash('Success', 'You have successfully registered. Your account will be activated after verification.');
                    // $this->redirect(array('users/addEmergencyServices', 'roleid' => $roleid));
                }
            } catch (Exception $ex) {
                $model->addError(NULL, $ex->getMessage());
                $transaction->rollback();
            }
        }
        $this->render('addAdminEmergencyServices', array(
            'model' => $model, 'model2' => $model2, 'model5' => $model5, 'roleid' => $roleid
        ));
    }

    public function actionUpdateAdminEmergencyServices($id, $roleid) {

        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);

        $model = UserDetails::model()->findByAttributes(array('user_id' => $id));
        $model2 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model2)) {
            $model2 = new DocumentDetails;
        }

        $model5 = AmbulanceDetails::model()->findByAttributes(array('ambulance_id' => $id));
        if (empty($model5)) {
            $model5 = new AmbulanceDetails;
        }
        $request = Yii::app()->request;
//        echo '<pre>';
//        print_r($_POST);exit;
        if (isset($_POST['UserDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();

                $purifiedObj = Yii::app()->purifier;
                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = $roleid;
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);

                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']);
                $model->emergency = $purifiedObj->getPurifyText($postArr['extra_charges']);

                $model->coordinator_name_1 = $purifiedObj->getPurifyText($postArr['coordinator_name_1']);
                $model->coordinator_mobile_1 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_1']);
                if (isset($postArr['coordinator_email_1'])) {
                    $model->coordinator_email_1 = $purifiedObj->getPurifyText($postArr['coordinator_email_1']);
                }
                if (isset($postArr['coordinator_mobile_2'])) {
                    $model->coordinator_mobile_2 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_2']);
                }

                $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
                $model->country_id = 1;
                $model->country_name = "india";
                $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->latitude = $postArr['latitude'];
                $model->longitude = $postArr['longitude'];
                $model->address = $purifiedObj->getPurifyText($postArr['address']);
                $model->created_date = date("Y-m-d H:i:s");
                $model->created_by = Yii::app()->user->id;

                if ($model->save()) {

                    $user_id = $model->user_id;
                    Yii::app()->db->createCommand()->delete('az_ambulance_details', 'ambulance_id=:id', array(':id' => $user_id));

                    if (isset($_POST['AmbulanceDetails'])) {
                        $AmbulancedetailsArr = $_POST['AmbulanceDetails'];
                        $bank = new AmbulanceDetails;
                        $model5->ambulance_id = $user_id;
                        $model5->working_day = $AmbulancedetailsArr['working_day'];
                       // $model5->ex_name = $AmbulancedetailsArr['ex_name'];
                        $model5->ex_contact_no = $AmbulancedetailsArr['ex_contact_no'];
                        $model5->vehical_no = $AmbulancedetailsArr['vehical_no'];
                        $model5->vehical_type = $AmbulancedetailsArr['vehical_type'];
                        if (!$model5->save()) {
                            throw new Exception("Error in saving AmbulanceDetails");
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

                    $docname = CUploadedFile::getInstance($model2, 'document');

                    if (!empty($docname)) {

                        Yii::app()->db->createCommand()->delete('az_document_details', 'user_id=:id AND doc_type=:doc_type', array(':id' => $id, 'doc_type' => 'Ambulance_Registration'));
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model2->document = $dname;
                        $docname->saveAs($baseDir . $model2->document);
                        $model2->doc_type = 'Ambulance_Registration';
                        $model2->user_id = $user_id;
                        if ($model2->save()) {
                            
                        }
                    }

                    $transaction->commit();
               //     echo $id.$roleid;exit;
                    $this->redirect(array('users/viewEmergencyServices', 'id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key),'roleid'=>$roleid));
                }
            } catch (Exception $ex) {
                $model->addError(NULL, $ex->getMessage());
                $transaction->rollback();
            }
        }
        
        $this->render('updateAdminEmergencyServices', array(
            'model' => $model, 'model2' => $model2, 'model5' => $model5, 'roleid' => $roleid
        ));
    }

    public function actionViewEmergencyServices($id, $roleid) {
        $this->layout = 'adminLayout';
        //echo $id.$roleid;exit;
            $enc_key = Yii::app()->params->enc_key;
            $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
            $model = UserDetails::model()->findByAttributes(array('user_id' => $id));
            $model2 = AmbulanceDetails::model()->findByAttributes(array('ambulance_id' => $id));
            if(empty($model2)){
                $model2 = new AmbulanceDetails;
            }


        $this->render('viewEmergencyServices', array('model' => $model, 'model2' => $model2, 'roleid' => $roleid));
    }

    public function actionManageInactiveDiagnostic() {
        $this->layout = 'adminLayout';
        $model = new UserDetails('searchInactivePathology');
        $model->unsetAttributes();  // clear any default values
        //    $model->hospital_name='ABC';
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageInactiveDiagnostic', array(
            'model' => $model,
        ));
    }

    public function actionManageInactiveBloodBank($roleid) {
        $this->layout = 'adminLayout';
        $model = new UserDetails('searchbloodbank');
        $model->unsetAttributes();  // clear any default values
        //    $model->hospital_name='ABC';
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageInactiveBloodBank', array(
            'model' => $model, 'roleid' => $roleid
        ));
    }

    public function actionBloodBank($roleid) {

        $enc_key = Yii::app()->params->enc_key;
        $roleid = base64_decode($roleid);
        $data = "";
        $model = new UserDetails;
        $model3 = new DocumentDetails;
        $model1 = new ServiceUserMapping;
        $model6 = new ClinicVisitingDetails;
        $model7 = new BankDetails;
        $commonobj = new CommonFunction;

        if (isset($_POST['UserDetails'])) {
            $request = Yii::app()->request;
            $purifiedObj = Yii::app()->purifier;
            if (!empty($_POST['profile'])) {
                list($type, $data) = explode(';', $_POST['profile']);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
            }

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $postArr = Yii::app()->request->getParam('UserDetails');
                $model->role_id = $roleid;
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->type_of_establishment = $purifiedObj->getPurifyText($postArr['type_of_establishment']);
                if (!empty($postArr['other_est_type']))
                    $model->other_est_type = $postArr['other_est_type'];

                if (!empty($postArr['type_of_hospital']))
                    $model->type_of_hospital = $postArr['type_of_hospital'];

                $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password']))
                    $model->password = md5($postArr['password']);
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);

                if (!empty($postArr['hos_establishment']) && $roleid == 8) {

                    $model->hos_establishment = date("Y-m-d", strtotime("01-" . $postArr['hos_establishment']));
                }

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
                $model->created_date = date("Y-m-d H:i:s");
                $model->updated_by = Yii::app()->user->id;
                // $model->registration_Fees = $purifiedObj->getPurifyText($postArr['registration_Fees']);
                //if(isset($postArr['discount']))
                //$model->discount = $purifiedObj->getPurifyText($postArr['discount']);
                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']);
                if (!empty($postArr['doctor_fees'])) {       //used as delivery charges for medical
                    $model->doctor_fees = $purifiedObj->getPurifyText($postArr['doctor_fees']);
                }

                if (!empty($postArr['payment_type'])) {
                    $model->payment_type = implode(",", $postArr['payment_type']);
                }


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

                    $user_id = $model->user_id;
                    $mobile = $model->mobile;
                    if (isset($_POST['UserDetails']['is_open_allday']) && $_POST['UserDetails']['is_open_allday'] == 'Y') {
                        $model->is_open_allday = 'Y';
                        $model->save();
                    } else {

                        $clinicvisit = Yii::app()->request->getParam('ClinicVisitingDetails');

                        if (isset($clinicvisit['day']) && count($clinicvisit['day']) > 0) {

                            foreach ($clinicvisit['day'] as $key => $value) {

                                $ClinicVisitingDetails = new ClinicVisitingDetails;
                                $ClinicVisitingDetails->clinic_id = 0;
                                $ClinicVisitingDetails->doctor_id = $user_id;
                                $ClinicVisitingDetails->day = $value;
                                $ClinicVisitingDetails->clinic_open_time = date('H:i:s', strtotime($clinicvisit['clinic_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_close_time = date('H:i:s', strtotime($clinicvisit['clinic_close_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_open_time = date('H:i:s', strtotime($clinicvisit['clinic_eve_open_time'][$key]));
                                $ClinicVisitingDetails->clinic_eve_close_time = date('H:i:s', strtotime($clinicvisit['clinic_eve_close_time'][$key]));
                                if ($roleid == 8) {
                                    $ClinicVisitingDetails->role_type = "Blood-Bank";
                                }
                                if ($roleid == 9) {
                                    $ClinicVisitingDetails->role_type = "Medical";
                                }
                                if (!$ClinicVisitingDetails->save()) {
                                    throw new Exception("Error in saving service user data");
                                }
                            }
                        }
                    }
         
                    if (!empty($_POST['service'])) {
                        if (isset($_POST['service']) && count($_POST['service']) > 0) {

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
                    }

                    if (!empty($_POST['BankDetails']['acc_holder_name'])) {
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
                                throw new Exception("Error in saving BankDetails");
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
                    $docname = CUploadedFile::getInstance($model3, 'document');

                    if (!empty($docname)) {
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model3->document = $dname;
                        $docname->saveAs($baseDir . $model3->document);
                        if ($roleid == 8) {
                            $model3->doc_type = 'Blood-Bank_Registration';
                        }
                        if ($roleid == 9) {
                            $model3->doc_type = 'Medical_Registration';
                        }
                        $model3->user_id = $user_id;
                        if ($model3->save()) {
                            
                        }
                    }
                    $transaction->commit();
                    Yii::app()->user->setFlash('Success', 'You have successfully registered. Your account will be activated after verification.');
                    $commonobj->sendSms($mobile, "Thanks for your registration. Your profile will shortly be activated after a small verification process.");
                    $this->redirect(array('users/bloodBank', 'roleid' => $roleid));
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('bloodBank', array('model' => $model, 'model3' => $model3, 'model1' => $model1, 'model6' => $model6, 'model7' => $model7, 'roleid' => $roleid));
    }

    public function actionManageInactiveAmbulanceServices($roleid) {

        $this->layout = 'adminLayout';
        $model = new UserDetails('searchambulance');
        $model->unsetAttributes();  // clear any default values
        //    $model->hospital_name='ABC';
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];
        $this->render('manageInactiveAmbulanceServices', array(
            'model' => $model, 'roleid' => $roleid
        ));
    }

    public function actionTransferOpd() {
        $returnoutputArr = array();
        $request = Yii::app()->request;
        $olddoctorid = $request->getParam('olddoctorid');
        $selecteddocid = $request->getParam('selecteddocid');
        $update = Yii::app()->db->createCommand()->update('az_patient_appointment_details', array('doctor_id' => $selecteddocid), 'doctor_id = :olddoctorid', array(":olddoctorid" => $olddoctorid));
        if ($update) {
            $returnOutputArr['isError'] = false;
        } else {
            $returnOutputArr['isError'] = true;
        }
        echo json_encode(array('result' => $returnOutputArr));
    }

    public function actionGetOpdtrnsferDoctor() {
        $request = Yii::app()->request;
        $userid = $request->getParam('userid');
        $hospitalid = $request->getParam('phospitalid');
        $opdno = $request->getParam('opdno');
        $isactive = "1";
        $doctorinfoArr = Yii::app()->db->createCommand()
                ->select('first_name,last_name,user_id,opd_no,parent_hosp_id,is_active')
                ->from(' az_user_details t')
                ->where('opd_no = :opdno AND parent_hosp_id =:phosid', array(':opdno' => $opdno, ':phosid' => $hospitalid))
                ->andwhere('is_active =:isacive', array(':isacive' => $isactive))
                ->queryAll();
        echo json_encode(array('data' => $doctorinfoArr));
    }

    public function actionAmbulanceDetails($param1) {
        $enc_key = Yii::app()->params->enc_key;
        $roleid = base64_decode($param1);
        $model = new UserDetails;
        $model2 = new DocumentDetails;
        $model3 = new BankDetails;
        $model5 = new AmbulanceDetails;
        $commonobj = new CommonFunction;
        if (isset($_POST['UserDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $request = Yii::app()->request;
                $purifiedObj = Yii::app()->purifier;
                $postArr = Yii::app()->request->getParam('UserDetails');

                $model->role_id = $roleid;
                $model->first_name = $purifiedObj->getPurifyText($postArr['first_name']);
                $model->company_name = $purifiedObj->getPurifyText($postArr['company_name']);
                $model->type_of_hospital = $purifiedObj->getPurifyText($postArr['type_of_hospital']);
                $model->hospital_registration_no = $purifiedObj->getPurifyText($postArr['hospital_registration_no']);
                $model->hospital_name = $purifiedObj->getPurifyText($postArr['hospital_name']);
                $model->mobile = $purifiedObj->getPurifyText($postArr['mobile']);
                if (!empty($postArr['password']))
                    $model->password = md5($postArr['password']);
                $model->take_home = $purifiedObj->getPurifyText($postArr['take_home']);
                $model->extra_charges = $purifiedObj->getPurifyText($postArr['extra_charges']);
                $model->emergency = $purifiedObj->getPurifyText($postArr['extra_charges']);

                $model->coordinator_name_1 = $purifiedObj->getPurifyText($postArr['coordinator_name_1']);
                $model->coordinator_mobile_1 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_1']);
                if (isset($postArr['coordinator_email_1'])) {
                    $model->coordinator_email_1 = $purifiedObj->getPurifyText($postArr['coordinator_email_1']);
                }
                if (isset($postArr['coordinator_mobile_2'])) {
                    $model->coordinator_mobile_2 = $purifiedObj->getPurifyText($postArr['coordinator_mobile_2']);
                }

                $model->pincode = $purifiedObj->getPurifyText($postArr['pincode']);
                $model->country_id = 1;
                $model->country_name = "india";
                $model->city_id = $purifiedObj->getPurifyText($postArr['city_id']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->latitude = $postArr['latitude'];
                $model->longitude = $postArr['longitude'];
                $model->address = $purifiedObj->getPurifyText($postArr['address']);
                $model->created_date = date("Y-m-d H:i:s");
                $model->created_by = Yii::app()->user->id;

                if ($model->save()) {

                    $user_id = $model->user_id;
                    $mobile = $model->mobile;
                    if (isset($_POST['AmbulanceDetails'])) {
                        $AmbulancedetailsArr = $_POST['AmbulanceDetails'];
                        $bank = new AmbulanceDetails;
                        $model5->ambulance_id = $user_id;
                        $model5->working_day = $AmbulancedetailsArr['working_day'];
                        $model5->ex_name = $AmbulancedetailsArr['ex_name'];
                        $model5->ex_contact_no = $AmbulancedetailsArr['ex_contact_no'];
                        $model5->vehical_no = $AmbulancedetailsArr['vehical_no'];
                        $model5->vehical_type = $AmbulancedetailsArr['vehical_type'];
                        if (!$model5->save()) {
                            throw new Exception("Error in saving AmbulanceDetails");
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
                    $docname = CUploadedFile::getInstance($model2, 'document');

                    if (!empty($docname)) {
                        $path_part = pathinfo($docname->name);
                        $dname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model2->document = $dname;
                        $docname->saveAs($baseDir . $model2->document);
                        $model2->doc_type = 'Ambulance_Registration';
                        $model2->user_id = $user_id;
                        if ($model2->save()) {
                            
                        }
                    }

                    $transaction->commit();
                    $commonobj->sendSms($mobile, "Thanks for your registration. Your profile will shortly be activated after a small verification process.");
                    Yii::app()->user->setFlash('Success', 'You have successfully registered. Your account will be activated after verification.');
                    $this->redirect(array('users/ambulanceDetails', 'param1' => $param1));
                }
            } catch (Exception $ex) {
                $model->addError(NULL, $ex->getMessage());
                $transaction->rollback();
            }
        }

        $this->render('ambulanceDetails', array(
            'model' => $model, 'model2' => $model2, 'model3' => $model3, 'model5' => $model5, 'roleid' => $roleid
        ));
    }

    public function actionEditReport() {
        $request = Yii::app()->request;
        $appintid = $request->getParam('appintid');
        $patient_id = $request->getParam('user_id');
        $document = $request->getParam('doc');

        // print_r($_FILES);

        $model = DocumentDetails::model()->findByAttributes(array('appointment_id' => $appintid));
        if (empty($model)) {
            $model = new DocumentDetails;
        }

        // print_r($model);exit;
        $baseDir = Yii::app()->basePath . "/../uploads/";
        if (!is_dir($baseDir)) {
            mkdir($baseDir);
        }

        $profilepicDir = 'document/';               //profilepic
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


        if (!empty($document)) {
            $imageFileType = pathinfo($document, PATHINFO_EXTENSION);
            $allowedExtArr = array('gif', 'png', 'jpg', 'jpeg', 'pdf', 'docs', 'docx', 'txt');

            if (!in_array($imageFileType, $allowedExtArr)) {

                throw new Exception("Please Select png,gif,jpg,jpef,pdf,docs,docx,txt Files Only");
            }
            if (!empty($document)) {


                $dname = $profilepicDir . time() . "_" . rand(111, 9999) . "." . 'jpg';

                $model->document = $dname;
                $target = $baseDir . $dname;
                $model->doc_type = 'Patient_document';
                $model->user_id = $patient_id;
                $model->appointment_id = $appintid;
//                        echo $dname.'==========';
//                         echo $target;exit;
                //if( move_uploaded_file($document, $target)){


                if ($model->save()) {
                    
                }
            } else {
                throw new Exception("Problem in saving");
            }
            //  }
        }




        //echo json_encode(array('result' => ));
    }

    public function actionDeleteRec() {
        $request = Yii::app()->request;
        $patient_id = $request->getParam('patient_id');

        Yii::app()->db->createCommand()->delete('az_patient_appointment_details', 'appointment_id=:id', array(':id' => $patient_id));
        echo json_encode(true);
    }

    public function actionGetDocument() {
        $request = Yii::app()->request;
        $appintid = $request->getParam('appintid');
        $patient_id = $request->getParam('user_id');


        $PatientDoc = Yii::app()->db->createCommand()
                ->select("document")
                ->from("az_document_details ")
                ->where(" appointment_id = $appintid And user_id=$patient_id ")
                ->queryScalar();
        echo json_encode(array('result' => $PatientDoc));
    }

    public function actionManageAppointmentServices() {
        $this->layout = 'adminLayout';
        $model = new UserDetails();
        $model->unsetAttributes();
        $this->render('manageAppointmentServices', array(
            'model' => $model
        ));
    }
    
    public function actionViewAllLab($id,$role){
        $this->layout = 'adminLayout';

       
            $enc_key = Yii::app()->params->enc_key;
            $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
              $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('user_id' => $id));
        if (empty($serviceUserMapping)) {
            $serviceUserMapping[] = new ServiceUserMapping;
        }
        $model3 = DocumentDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model3)) {
            $model3 = new DocumentDetails;
        }
        $model7 = BankDetails::model()->findByAttributes(array('user_id' => $id));
        if (empty($model7)) {
            $model7 = new BankDetails;
        }
        $ClinicVisitingDetails = ClinicVisitingDetails::model()->findByAttributes(array('doctor_id' => $id));
        if (empty($ClinicVisitingDetails)) {
            $ClinicVisitingDetails[] = new ClinicVisitingDetails;
        }
       

        $this->render('viewAllLab', array(
            'model' => $this->loadModel($id),'role'=>$role,'id'=>$id,'serviceUserMapping'=>$serviceUserMapping,'model7'=>$model7
        ));
    }

}
