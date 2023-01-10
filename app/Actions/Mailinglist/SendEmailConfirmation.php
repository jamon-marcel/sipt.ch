<?php
namespace App\Actions\Mailinglist;
use App\Mail\MailinglistConfirm;
use Illuminate\Support\Facades\Mail;

class SendEmailConfirmation
{
  public function execute($data)
  {
    return Mail::to($data->email)->send(
      new MailinglistConfirm([
        'subscriber'  => $data,
      ])
    );
  }
}