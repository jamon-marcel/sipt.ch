<?php
namespace App\Services;
use App\Models\NewsletterSubscriber;
use App\Models\User;

class NewsletterPreferences
{
  public function __construct(NewsletterSubscriber $newsletterSubscriber, User $user)
  {
    $this->newsletterSubscriber = $newsletterSubscriber;
    $this->user = $user;
  }

  public function update(User $user, $isSubscriber = FALSE)
  {
    $user->is_newsletter_subscriber = $isSubscriber;
    $user->save();

    // Update "newsletter_subscriber" table
    $subscriber = $this->newsletterSubscriber->withTrashed()->where('email', '=', $user->email)->get()->first();
    
    // Restore if already subscribed but deleted
    if ($subscriber)
    {
      if ($user->is_newsletter_subscriber == 1)
      {
        $subscriber->deleted_at = NULL;
        $subscriber->is_confirmed = 1;
        $subscriber->save();
      }
      else
      {
        $subscriber->delete();
      }
    }
    else
    {
      // otherwise create new subscriber
      $data = [
        'email' => $user->email,
        'is_done' => 1,
        'is_confirmed' => 1
      ];
      $subscriber = NewsletterSubscriber::create($data);
      $subscriber->save();

      // delete if action is unsubscribe
      if ($user->is_newsletter_subscriber == 0)
      {
        $subscriber->delete();
      }
    }
  }

}