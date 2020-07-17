<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Registration deadline in days
  |--------------------------------------------------------------------------
  |
  */

  // Registration
  'registration_deadline' => '+1 day',

  // Bank/ESR details
  'esr_codeline_prefix' => '01',
  'esr_customer_id'     => '96 34990',
  'esr_account_str'     => '01-200027-2',
  'esr_account_int'     => '012000272',

  // Minimum Invoice Number
  'min_invoice_number' => 605278,

  // Minimum Booking Number
  'min_booking_number' => 406400,

  // E-Mail Carbon Copy
  'email_cc' => [
    'm@marceli.to',
    //'marcel@jamon.digital',
  ],

  // Notice types
  'notice_types' => [
    0 => 'Zahlungserinnerung',
    1 => '1. Mahnung',
    2 => '2. Mahnung',
    3 => '3. Mahnung'
  ],

];