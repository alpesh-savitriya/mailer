<?php
/**
 * Created by PhpStorm.
 * User: alpesh
 * Date: 4/3/19
 * Time: 12:23 PM
 */

namespace PseudoMailer\Mailer;
use Illuminate\Http\Request;
use Validator;
use Laravel\Lumen\Routing\Controller;

class MailerController extends Controller {

    public function insertMails($mailToArray, $mailFrom, $subject, $template, $attachements) {

        $uuid = uniqid();
        $createdDate = date("Y-m-d h:i:s");

        foreach ($mailToArray as $mailTo) {

            // insert into db
            $createMail = new Mailer();
            $createMail->mail_from = $mailFrom;
            $createMail->mail_to = $mailTo;
            $createMail->subject = $subject;
            $createMail->template = $template;
            $createMail->attachements = json_encode($attachements);
            $createMail->created_date = $createdDate;
            $createMail->uuid = $uuid;
            $createMail->save();
        }
        // return nothing
    }

    public static function listMail() {

        $result = array();
        $response = array();

        $result = Mailer::listMail();

        if (isset($result)) {

            $response['code'] = 200;
            $response['message'] = 'success';
            $response['content'] = $result;

        } else {

            $response['code'] = 400;
            $response['message'] = 'error';
            $response['content'] = '';
        }
        
        return response($response, $response['code'])
            ->header('content_type', 'application/json');
    }

    public static function showMailDetail(Request $request) {

        $response = array();
        $result = array();

        $uuid = $request->has('uuid') ? $request->input('uuid') : '';

        if ($uuid != '') {

            $listUUID = Mailer::select('*')->where('mails.uuid', '=', $uuid)->get();

            $uuidArray = array();
            $uuidArray['mail_from'] = $listUUID[0]->mail_from;
            $uuidArray['subject'] = $listUUID[0]->subject;
            $uuidArray['uuid'] = $listUUID[0]->uuid;
            $uuidArray['status'] = $listUUID[0]->status;
            $uuidArray['created_date'] = $listUUID[0]->created_date;
            $uuidArray['sent_at'] = $listUUID[0]->sent_at;
            $uuidArray['opened_at'] = $listUUID[0]->opened_at;
            $uuidArray['template'] = $listUUID[0]->template;

            $uuidArray['id'] = array();
            $uuidArray['mail_to'] = array();
            $uuidArray['attachements'] = array();

            foreach ($listUUID as $id) {
                $idArr = array();
                $idArr['id'] = $id->id;
                array_push($uuidArray['id'], $idArr['id']);
            }

            foreach ($listUUID as $mailTo) {
                $mailToArr = array();
                $mailToArr['mail_to'] = $mailTo->mail_to;
                array_push($uuidArray['mail_to'], $mailToArr['mail_to']);
            }

            foreach ($listUUID as $attechement) {
                $attechementArr = array();
                $attechementArr['attachements'] = $attechement->attachements;
                array_push($uuidArray['attachements'], $attechementArr['attachements']);
            }
            array_push($result, $uuidArray);
        }

        if (isset($result)) {

            $response['code'] = 200;
            $response['message'] = 'success';
            $response['content'] = $result;

        } else {

            $response['code'] = 400;
            $response['message'] = 'error';
            $response['content'] = '';
        }

        return response($response, $response['code'])
            ->header('content_type', 'application/json');
    }
}