<?php
/**
 * Created by PhpStorm.
 * User: alpesh
 * Date: 4/3/19
 * Time: 12:06 PM
 */

namespace PseudoMailer\Mailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Mailer extends Model {

    use SoftDeletes;
    protected $table = 'mails';

    protected $fillable = ['mail_from', 'mail_to', 'subject', 'uuid', 'status', 'created_date', 'sent_at', 'opened_at', 'template', 'created_at', 'updated_at'];

    public static function listMail() {

        $uuid = Mailer::groupBy('uuid')->select(DB::raw('mail_from as mail_from, mail_to as mail_to, subject as subject,
                            attachements as attachements, uuid as uuid, status as status, created_date as created_date,
                            sent_at as sent_at, opened_at as opened_at, template as template'))
                            ->get();
        
        $listMail = array();
        foreach ($uuid as $uuidData) {

            $uuidArray = array();
            // $uuidArray['id'] = $uuidData->id;
            $uuidArray['mail_form'] = $uuidData->mail_from;
            // $uuidArray['mail_to'] = $uuidData->mail_to;
            $uuidArray['subject'] = $uuidData->subject;
            // $uuidArray['attachements'] = $uuidData->attachements;
            $uuidArray['uuid'] = $uuidData->uuid;
            $uuidArray['status'] = $uuidData->status;
            $uuidArray['created_date'] = $uuidData->created_date;
            $uuidArray['sent_at'] = $uuidData->sent_at;
            $uuidArray['opened_at'] = $uuidData->opened_at;
            $uuidArray['template'] = $uuidData->template;

            $uuidArray['id'] = array();
            $uuidArray['mail_to'] = array();
            $uuidArray['attachements'] = array();

            $listMailTo = Mailer::select('id', 'mail_to', 'attachements')->where('uuid', '=', $uuidData->uuid)->get();
            foreach ($listMailTo as $id) {
                $idArr = array();
                $idArr['id'] = $id->id;
                array_push($uuidArray['id'], $idArr['id']);
            }

            foreach ($listMailTo as $mailTo) {
                $mailToArr = array();
                $mailToArr['mail_to'] = $mailTo->mail_to;
                array_push($uuidArray['mail_to'], $mailToArr['mail_to']);
            }

            foreach ($listMailTo as $attechement) {
                $attechementArr = array();
                $attechementArr['attachements'] = $attechement->attachements;
                array_push($uuidArray['attachements'], $attechementArr['attachements']);
            }

            array_push($listMail, $uuidArray);
        }

        if (isset($listMail)) {
            
            return $listMail;
        }
    }
}