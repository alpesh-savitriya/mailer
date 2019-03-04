<?php
/**
 * Created by PhpStorm.
 * User: roshani
 * Date: 4/3/19
 * Time: 12:06 PM
 */

namespace PseudoMailer\Mailer;


use Illuminate\Support\Facades\Facade;


class MailerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mailer';
    }
}