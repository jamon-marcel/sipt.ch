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
  'billable_deadline'     => '+30 days',
  'callable_deadline'     => '+10 days',
  'reminder_deadline'     => '+20 days',

  // Bank/ESR details
  'esr_codeline_prefix' => '01',
  'esr_customer_id'     => '96 34990',
  'esr_account_str'     => '01-200027-2',
  'esr_account_int'     => '012000272',

  // Minimum Invoice Number
  'min_invoice_number' => 650000,

  // Minimum Booking Number
  'min_booking_number' => 450000,

  // Chunk size for cron jobs
  'cron_chunk_size' => 1,

  // E-Mail 
  'email_admin' => [
    'admin@sipt.ch',
  ],

  // E-Mail carbon copy
  'email_copy' => [
    // 'support@sipt.ch',
    // 'r.barwinski@swissonline.ch',
    // 'sekretariat@sipt.ch'
  ],

  // Notice types
  'notice_types' => [
    0 => 'Zahlungserinnerung',
    1 => '1. Mahnung',
    2 => '2. Mahnung',
    3 => '3. Mahnung'
  ],

  // ID for current symposium
  'symposium_id' => '644b0723-5c3a-45d3-800a-592876d90257',

  // ID for 'CAS Zertifikatslehrgang FachberaterIn Psychotraumatologie'
  'cas_consultant_psychotraumatology_id' => '44e470df-40ae-4eef-9aed-2788f563c626',

  // Quotes for training pages
  'quotes' => [
    'a7cfb68c-a8fe-4460-a804-e6b7b3489dd9' => [
      'author' => 'Marianne Herzog, Fachberaterin / Fachpädagogin Psychotraumatologie',
      'quote' => 'Die Weiterbildung zur Fachberaterin und Fachpädagogin Psychotraumatologie am SIPT war für mich zentral. Die Theorien der Übertragungsphänomene, das Wissen um die Bedeutung der frühkindlichen Bindung, das Verstehen von hirnorganischer Abläufe gerade auch unter Stress sind wichtige Inhalte in meinen Weiterbildungen.',
    ],

    '1803a571-02bb-495e-98ce-40b2a5cdbac5' => [
      'author' => 'Chistina Haeny, Psychologin',
      'quote' => 'Die Fortbildung am SIPT ermöglichte mir ein tiefgreifendes, psychodynamisches Verständnis für die Diagnostik und Therapie bei Traumafolgestörungen.',
    ],

    '9bc842b3-001b-4bfb-92ce-c0f72010d7c4' => [
      'author' => 'Ruth Monstein, Coach, Fachberaterin Psychotraumatologie, Achtsamkeitstrainerin',
      'quote' => 'Mit dem am SIPT vermittelten Wissen kann ich nun viele Situationen, die ich mit traumatisierten Kindern im Schulbereich erlebt habe, einordnen, und die dahinterliegende Traumadynamik verstehen. Zudem habe ich
      Methoden erworben, mit denen ich in herausfordernden Situationen handeln kann.',
    ],

    'f8397281-acc4-47a4-985e-b6515b433419' => [
      'author' => 'Marianne Herzog, Fachberaterin / Fachpädagogin Psychotraumatologie',
      'quote' => 'Die Weiterbildung zur Fachberaterin und Fachpädagogin Psychotraumatologie am SIPT war für mich zentral. Die Theorien der Übertragungsphänomene, das Wissen um die Bedeutung der frühkindlichen Bindung, das Verstehen von hirnorganischer Abläufe gerade auch unter Stress sind wichtige Inhalte in meinen Weiterbildungen.',
    ]
  ]

];