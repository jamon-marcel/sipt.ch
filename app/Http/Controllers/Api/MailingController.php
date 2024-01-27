<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Mailing;
use App\Models\MailingQueue;
use App\Models\MailingAttachment;
use App\Http\Requests\MailingStoreRequest;
use Illuminate\Http\Request;

class MailingController extends Controller
{

  public function __construct(Mailing $mailing)
  {
    $this->mailing = $mailing;
  }

  /**
   * Get a list of mailings
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->mailing->with('mailinglists')->orderBy('created_at', 'DESC')->get());
  }

  /**
   * Get a single mailing for a given mailing
   * 
   * @param Mailing $mailing
   * @return \Illuminate\Http\Response
   */
  public function find(Mailing $mailing)
  {
    return response()->json($this->mailing->with('attachments')->findOrFail($mailing->id));
  }

  /**
   * Store a newly created mailing
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(MailingStoreRequest $request)
  {
    $mailing = Mailing::create($request->except('attachments'));
    $mailing->save();

    // add attachments
    if ($request->input('attachments') && !empty($request->input('attachments')))
    {
      foreach ($request->input('attachments') as $attachement)
      {
        $MailingAttachment = MailingAttachment::create([
          'mailing_id' => $mailing->id,
          'name' => $attachement['name']
        ]);
      }
    }
    return response()->json(['mailingId' => $mailing->id]);
  }

  /**
   * Update the current mailing
   *
   * @param Mailing $mailing
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Mailing $mailing, MailingStoreRequest $request)
  {
    $mailing->update($request->except('attachments'));

    // delete attachments first
    $mailing->attachments()->delete();
    
    // add new attachments
    if ($request->input('attachments') && !empty($request->input('attachments')))
    {
      foreach ($request->input('attachments') as $attachement)
      {
        $MailingAttachment = MailingAttachment::create([
          'mailing_id' => $mailing->id,
          'name' => $attachement['name']
        ]);
      }
    }

    $mailing->save();
    return response()->json('successfully updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Mailing $mailing
   * @return \Illuminate\Http\Response
   */
  public function destroy(Mailing $mailing)
  {
    $mailing->mailinglists()->detach();
    $mailing->queue()->delete();
    $mailing->attachments()->delete();
    $mailing->delete();
    return response()->json('successfully deleted');
  }
}