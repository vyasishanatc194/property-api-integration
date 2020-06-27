<?php

return [

    'DEFAULT_LANG' => env('DEFAULT_LANG', 'en'),
    'date_format_on_app' => 'jS M Y g:i A',
	'API_MAX_CALL'=>env('API_MAX_CALL',5),
	'API_PER_PAGE'=>env('API_PER_PAGE',100),
	'DATA_LISTING_PER_PAGE'=>env('DATA_LISTING_PER_PAGE',10),
	'API_KEY'=>env('API_KEY','3NLTTNlXsi6rBWl7nYGluOdkl2htFHug'),
	'API_BASE_URL'=>env('API_BASE_URL','http://trialapi.craig.mtcdevserver.com/api'),
];
