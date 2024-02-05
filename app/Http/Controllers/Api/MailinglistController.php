<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use App\Actions\Mailinglist\GetSubscriptions;
use App\Actions\Mailinglist\DeleteSubscription;
use App\Actions\Mailinglist\CreateOrUpdateSubscriber;
use Illuminate\Http\Request;

class MailinglistController extends Controller
{
  public function get($subscriberCount = FALSE)
  {
    if ($subscriberCount)
    {
      return new DataCollection(
        Mailinglist::withCount('activeSubscribers')->orderBy('order')->get()
      );
    }
    return new DataCollection(
      Mailinglist::orderBy('order')->get()
    );
  }

  public function getSubscriptions($email = NULL, GetSubscriptions $getSubscriptions)
  {
    return response()->json($getSubscriptions->execute($email));
  }

  public function addSubscription(Request $request, CreateOrUpdateSubscriber $createOrUpdateSubscriber)
  { 
    $subscriber = $createOrUpdateSubscriber->execute([
      'mailinglist' => Mailinglist::find($request->input('mailinglist')),
      'email' => $request->input('email')
    ]);
    return response()->json($subscriber);
  }

  public function deleteSubscription(MailinglistSubscriber $mailinglistSubscriber, DeleteSubscription $deleteSubscription)
  {
    return $deleteSubscription->execute($mailinglistSubscriber);
  }

}
