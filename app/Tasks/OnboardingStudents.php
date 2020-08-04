<?php
namespace App\Tasks;

class OnboardingStudents
{
  public function __invoke()
  {
    $onboarding = \App\Models\Onboarding::where('role', '=', 'student')->where('has_invitation', '=', '0')->get();
    $onboarding = collect($onboarding)->splice(0, \Config::get('sipt.cron_chunk_size'));

    foreach($onboarding->all() as $o)
    {
      $user = \App\Models\User::with('student')->where('email', '=', $o->email)->get()->first();

      if ($user)
      {
        $pw = \Str::random(16);
        $user->password = \Hash::make($pw);
        $user->markEmailAsVerified();
        $user->save();
  
        \Mail::to($o->email)
              ->bcc(\Config::get('sipt.email_copy'))
              ->send(
                new \App\Mail\OnboardingStudentNotification(
                  [
                    'student'     => $user,
                    'email'       => $user->email,
                    'password'    => $pw,
                    'attachments' => [
                      public_path() . '/storage/downloads/' . 'sipt-tagungsprogramm.pdf',
                    ]
                  ]
            )
        );
      }

      // Mark onboarding as invited
      $o->has_invitation = 1;
      $o->save();
    }
  }
}