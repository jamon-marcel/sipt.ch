<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Mailing extends Model
{
  protected $fillable = [
    'salutation',
    'subject',
    'body',
    'greetings',
  ];

  protected $appends = [
    'queued',
    'processed',
    'attachment_array'
  ];

  public function attachments()
  {
    return $this->hasMany(MailingAttachment::class);
  }

  public function queue()
  {
    return $this->hasMany(MailingQueue::class);
  }

  public function getQueuedAttribute()
  {
    return MailingQueue::with('items')->where('mailing_id', $this->id)->count();
  }

  public function getProcessedAttribute()
  {
    return MailingQueue::with('items')->where('mailing_id', $this->id)->where('processed', 1)->count();
  }

  public function getAttachmentArrayAttribute()
  {
    $data = $this->attachments()->get();
    $attachments = [];
    if ($data->count() > 0)
    {
      foreach($data->all() as $a)
      {
        $attachments[] = public_path() . '/storage/uploads/' . $a->name;
      }
    }
    return $attachments;
  }
 
}
