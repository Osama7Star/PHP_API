<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jfsbkjsbfdskjgfdskjbgfsdhjgfajds',
        ],
        
        
//        'urlManager'   => [
//        'enablePrettyUrl'     => true,
//        'enableStrictParsing' => true,
//        'showScriptName'      => false,
//        'rules'               => [
//            [
//                'class'         => 'yii\rest\UrlRule',
//                'controller'    => [ 'v1/recipe' ],
//                'extraPatterns' => [ 'POST' => 'create' ],
//                'pluralize'     => false
//            ],
//            [
//                'class'         => 'yii\rest\UrlRule',
//                'controller'    => [ 'v1/country' ],
//                'extraPatterns' => [ 'GET' => 'index', 'DELETE' => 'delete' ],
//                'pluralize'     => false
//            ],
////            [
////                'class'         => 'yii\rest\UrlRule',
////                'controller'    => [ 'v1/notifications' ],
////                'extraPatterns' => [ 'POST' => 'create' ]
////            ]
//        ]   
//        ]
        
//-------------------------------------------        
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['v1/recipe','v1/country'],
//                    'controller' => ['v1/recipe'],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET login' => 'login',                        
                        'GET recipe' => 'recipe',
                        'GET recipes' => 'recipes',
                        'GET steps' => 'steps',
                        'GET recipesteps' => 'recipesteps',
                        'GET step' => 'step',
                        'GET search' => 'search',
                        'GET newrecipes' => 'newrecipes',                        
                        'GET kitchens' => 'kitchens',
                        'GET stepdetails' => 'stepdetails',
                        'GET recipetest' => 'recipetest',
                        'GET recipedetail' => 'recipedetail',

                        //
                        'GET products'  => 'products',
                        'GET product'   => 'product',
                        'GET category'  => 'category', 
                        'GET slider'    => 'slider',
                        'GET newproducts' => 'newproducts',
                        'GET getbooks'    => 'getbooks',
                        'GET getbooksinformation' => 'getbooksinformation',
                        'GET getauthors'    => 'getauthors',
                        'GET getauthor'    => 'getauthor',
                        'GET getauthorbooks'        => 'getauthorbooks',
                        'GET getbookinformation'    => 'getbookinformation',


                        'GET getcategories' => 'getcategories',
                        'GET getcategoryname' => 'getcategoryname',
                        'GET getbookreview' => 'getbookreview',
                        'GET getcategorybook' => 'getcategorybook',
                        'GET getuserinformation' => 'getuserinformation',
                        'GET getbookreview1' => 'getbookreview1',
                        'GET getsearchbook' => 'getsearchbook',

                        'GET getsuggestedbook' => 'getsuggestedbook',
                        'GET getconditions' => 'getconditions',
                        'GET checkusername' => 'checkusername',
                        'GET signup' => 'signup',
                        'GET getcategory1books' => 'getcategory1books',
                        'GET getcategory2books' => 'getcategory2books',
                        'GET getcategory3books' => 'getcategory3books',
                        'GET getendedbook' => 'getendedbook',
                        'GET getmostratedbooks' => 'getmostratedbooks',
                        'GET getlastbooks' => 'getlastbooks',
                        'GET addquote' => 'addquote',
                        'GET getquotes' => 'getquotes',
                        'GET getbookbyid' => 'getbookbyid',
                        'GET getauthorbooks1' => 'getauthorbooks1',
                        'GET searchauthors' => 'searchauthors',
                        'GET updatequotelikes' => 'updatequotelikes',
                        'GET updatebookstatus' => 'updatebookstatus',

                        'GET addbookborrowing' => 'addbookborrowing',
                        'GET getborrowedinfo' => 'getborrowedinfo',
                        'GET getauthorname' => 'getauthorname',
                        'GET addreview' => 'addreview',
                        'GET searchbytag' => 'searchbytag',
                        'GET getuserrebooks' => 'getuserrebooks',
                        'GET getuserreviews' => 'getuserreviews',
                        'GET getuserquotes' => 'getuserquotes',
                        'GET getbooksborrowingrecords' => 'getbooksborrowingrecords',
                          
                        'GET getbookbyisbn' => 'getbookbyisbn',
                        'GET getauthorinfo' => 'getauthorinfo',




                        

                        

                    ],
                    
                ]
            ],        
        ]
        
//-------------------------------------------        
        
//        'urlManager' => [
//                'class' => 'yii\web\UrlManager',
//                // Disable index.php
//                'showScriptName' => false,
//                // Disable r= routes
//                'enablePrettyUrl' => true,
//                'rules' => array(                    
////                    'POST apis/add/recipe' => 'api/add-recipe',
////                    'GET apis/recipe/list' => 'api/recipe-list',
////                    'GET recipes/recipe' => 'recipe/recipe',
////                    'GET apis/recipe/steps' => 'api/recipe-steps',
////                    'GET apis/step' => 'api/step',
////                    'POST apis/filter' => 'api/filter',                    
////                    'POST apis/create' => 'api/create',
////                    'POST apis/login' => 'api/login',                    
//                ),
//        ],  
        
    ],
    'params' => $params,
];