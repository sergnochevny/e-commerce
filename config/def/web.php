<?php
return [
  'define' => [
    'ENABLE_SEF' => true,
    'DS' => '/',

    'FILTER_LIMIT' => 50,
    'DEFAULT_SHIPPING' => 3,
    'TITLE_MAX_CHARS' => 50,
    'TITLE_MIN_CHARS' => 5,
    'DATA_MAX_CHARS' => 1000,
    'DATA_MIN_CHARS' => 15,
    'DEMO' => 1,
    'DISCOUNT_STRING_JOINER' => '<br />',
    'DISCOUNT_TYPE_NONE' => 0,
    'DISCOUNT_TYPE_SUBTOTAL' => 1,
    'DISCOUNT_TYPE_SHIPPING' => 2,
    'DISCOUNT_TYPE_TOTAL' => 3,
    'DISCOUNT_CATEGORY_ALL' => 1,
    'DISCOUNT_CATEGORY_COUPON' => 2,
    'DISCOUNT_CATEGORY_SHIPPING' => 3,
    'DISCOUNT_CATEGORY_PRODUCT' => 4, #define the variables needed for the defaults for the samples
    'SAMPLES_PRICE_EXPRESS_SHIPPING' => 39.95, #define the variables needed for the defaults for the samples
    'SAMPLES_QTY_MULTIPLE_MIN' => 2,          #the minimum number of samples to qualify for the multiple price
    'SAMPLES_QTY_MULTIPLE_MAX' => 5,
    #the maximum number of samples to qualify for the multiple price, after this number they are charged the additional price
    'SAMPLES_PRICE_SINGLE' => 14.00,          #the price if only one sample is purchased
    'SAMPLES_PRICE_MULTIPLE' => 28.00,        #the price if multiple min qty is met
    'SAMPLES_PRICE_ADDITIONAL' => 4.00,        #the price for each additional sample after the multiple max quantity
    'SAMPLES_PRICE_WITH_PRODUCTS' => 4.00,
    #the price charge for samples if they are purchased with any other products
    'SAMPLES_DESCRIPTION_PREFIX' => 'SAMPLE - ',
    'SAMPLES_PURCHASE_BEFORE_TIME_HOUR' => 3,
    'SAMPLES_PURCHASE_BEFORE_TIME_MINUTE' => 00,
    'SAMPLES_PURCHASE_AFTER_DAY' => 1,
    'SAMPLES_PURCHASE_BEFORE_DAY' => 4,
    'SAMPLES_SHIPPING_DISCLAIMER' => 'I acknowledge that in rare cases samples may not arrive overnight due to circumstances beyond the control of iLuvFabrix.com. There are no guarantees or refunds given for this service.',

    'RATE_HANDLING' => 12.50,                #handling rate
    'RATE_ROLL' => 30.00,                    #if a customer chooses to have in shipped on the roll
    #define the shipping rates
    #base rate is the price for that shipping
    #multiplier is for order x to y yards they are charged the base plus the multiplier times the yardage
    'RATE_EXPRESS_LIGHT' => 22.85,            #rate to ship light products via express
    'RATE_EXPRESS_LIGHT_MULTIPLIER' => 3.25,
    'RATE_EXPRESS_MEDIUM' => 27.85,
    #rate to ship medium products via express
    'RATE_EXPRESS_MEDIUM_MULTIPLIER' => 3.75,
    'RATE_EXPRESS_HEAVY' => 27.85,
    #rate to ship heavy products via express
    'RATE_EXPRESS_HEAVY_MULTIPLIER' => 4.75,
    'RATE_GROUND_LIGHT' => 20.95,
    #rate to ship light products via ground
    'RATE_GROUND_LIGHT_MULTIPLIER' => 3.00,
    'RATE_GROUND_MEDIUM' => 20.95,
    #rate to ship medium products via ground
    'RATE_GROUND_MEDIUM_MULTIPLIER' => 3.35,
    'RATE_GROUND_HEAVY' => 22.85,
    #rate to ship heavy products via ground
    'RATE_GROUND_HEAVY_MULTIPLIER' => 4.00,

    'HIDE_REGULAR_PRICE' => 0,
    'SAMPLE_EXPRESS_SHIPPING' => 1,
    'CSV_USE_GZ' => 0,
    'CSV_FIELDS' => 'email,bill_firstname,bill_lastname',
    'CAPTCHA_RELEVANT' => 300,

    'SHOP_SPECIALS_AMOUNT' => 30,
    'SHOP_BSELLS_AMOUNT' => 60,

    'PRICE_GROUPS_COUNT' => 24,

    'LIGHT_FABRIC' => 1,
    'MEDIUM_FABRIC' => 2,
    'HEAVY_FABRIC' => 3,
    'YRDS_FOR_MULTIPLIER' => 2.0,
    #total yardage allowed before a mulitplier is added
  ],
  'ini_set' => [
    'display_errors' => 'On',
    'mysql.connect_timeout' => 60,
    'error_reporting' => (E_ALL & (~E_DEPRECATED)),
    'always_populate_raw_post_data' => -1,
  ],
  'date_default_timezone_set' => [['UTC']],
  'setlocale' => [
    [LC_ALL, 'en_US'],
    [LC_TIME, 'UTC']
  ],
  'DBS' => [
    'connections' => [
      'default' => [
        'host' => "localhost",
        'user' => "root",
        'password' => "",
        'db' => [
          'default' => 'iluvfabrix'
        ]
      ]
    ]
  ],
  'layouts' => "main_layout",
  'per_page_items' => ['6', '12', '24'],
  'errorHandler' => 'classes\ErrorHandler'
];
