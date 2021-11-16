<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\web\Response;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use frontend\models\User;
use yii\data\ActiveDataProvider;

/**
 * Recipe Controller API
 *
 *
 */
class RecipeController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Recipe';    

    public function beforeAction($action)
    {error_log("beforeAction");
        $request = Yii::$app->request;
        // error_log(print_r(Yii::$app->request->get(),true));
        // error_log("######");
        // error_log(print_r(Yii::$app->request->post(),true));
        // error_log("######");
        Yii::$app->request->enableCsrfValidation = false;
        $limit = $request->get('limit', 25);
        $limit = $limit > 25 ? 25 : $limit;

     //        $this->lang = Yii::$app->request->headers->get('Accept-Language');//$request->get('lang','en');

      //        Yii::$app->language = $this->lang;
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }
    
    public function behaviors()
    {
        $beh = [
            'authenticator' => [
                'class' => QueryParamAuth::className(),
                'only' =>['recipe','recipesteps','step']
            ],        
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update-settings', 'logout','view','categories','get-settings','update','change-password','refresh'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update-settings','logout','view','categories','get-settings','update','change-password','refresh'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow'=>true,
                        'actions' =>['verify','reset-password'],
                        'roles'=>['?']
                    ]    
                ],
            ],
        ];
        return $beh;
    } 
                       
    

    //Search 
    public function actionSearch()
    {
        if (!empty($_GET)) {
            $model = new $this->modelClass;            
            try {
           $request = Yii::$app->request;
           $PageSize = $request->get('PageSize', 40); 
           $PageIndex = $request->get('PageIndex', 0);
           
           $text =  $request->get('text', null);
            
            $lang = $request->get('lang', null);                

            $query  = new \yii\db\Query();
            $query = $query->select(['*'])->from('product');                             

              if(!empty($text)){                         
                $query->Where(['like', 'product.name', $text]);
              }
                                       

                $provider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            // 'recipe_id'=> SORT_DESC
                        ]
                    ],
                      'pagination' => [
                    'defaultPageSize' => $PageSize,
                    'page' => $PageIndex 
                ],
                ]);
            }
             catch (Exception $ex) {
                throw new \yii\web\HttpException(500, 'Internal server error');
            }

            if ($provider->getCount() <= 0) {
                throw new \yii\web\HttpException(404, 'No entries found with this query string');
            } else {
                return $provider;
            }
        } else {
            throw new \yii\web\HttpException(400, 'There are no query string');
        }
    }

       
//--Get recipe with Page index and PageIndex size and filter 
public function actionProducts()
{
    if (!empty($_GET)) {        
        try {
           $request = Yii::$app->request;
           $PageSize = $request->get('PageSize', 40); 
           $PageIndex = $request->get('PageIndex', 0);
           $category_id =  $request->get('categoryId', null);       
           $text =  $request->get('Text', null);
            
            $lang = $request->get('lang', null);                

            $query  = new \yii\db\Query();
            $query = $query->select(['*'])->from('product');                         
        
             if(!empty($category_id)){                         
                $query->where("product.category_id = $category_id");    
              }

            
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
//                            'recipe_id'=> SORT_DESC
                    ]
                ],
                  'pagination' => [
                'defaultPageSize' => $PageSize,
                'page' => $PageIndex 
            ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}


public function actionNewproducts()
{
    if (!empty($_GET)) {        
        try {
           $request = Yii::$app->request;        
           $category_id =  $request->get('categoryId', null);
           $text =  $request->get('Text', null);
           $limit = $request->get('limit', 2);
           $lang = $request->get('lang', null);                

            $query  = new \yii\db\Query();
            $query = $query->select(['*'])->from('product');
        
            if(!empty($category_id)){                         
                $query->where("product.category_id = $category_id");    
            }

            if(!empty($limit)){
                $query = $query->limit($limit);
            }
                        
            
            $query = $query->orderBy(['date' => SORT_DESC]);            

            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        //    'date'=> SORT_DESC
                    ]
                ],
                'pagination' => false,
            //       'pagination' => [
            //     'defaultPageSize' => $PageSize,
            //     'page' => $PageIndex 
            // ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}


//--Get recipe with Page index and PageIndex size and filter 
public function actionProduct()
{
    if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
           $request = Yii::$app->request;           
           $productId =  $request->get('productId', null);     
           $text =  $request->get('Text', null);
           $lang = $request->get('lang', null);        

            $query  = new \yii\db\Query();
            $query = $query->select(['*'])->from('product');                                 
    
            if(!empty($productId)){                         
                $query->where("product.id = $productId");    
            }

            
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
//                            'recipe_id'=> SORT_DESC
                    ]
                ],
                  'pagination' => [
                // 'defaultPageSize' => $PageSize,
                // 'page' => $PageIndex 
            ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}


public function actionCategory()
{
    if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
           $request   = Yii::$app->request;
           $PageSize  = $request->get('PageSize', 40); 
           $PageIndex = $request->get('PageIndex', 0);               
           $text      =  $request->get('Text', null);
           $lang      = $request->get('lang', null);

            $query  = new \yii\db\Query();
            $query  = $query->select(['*'])->from('category');

                

            if (!empty($text)) {                         
                $query->Where(['like', 'category.name', $text]);
            }
        
            
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        //    'category.id'=> SORT_DESC
                    ]
                ],
                  'pagination' => [
                'defaultPageSize' => $PageSize,
                'page' => $PageIndex 
            ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}


public function actionSlider()
{
    if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
           $request = Yii::$app->request;
           $PageSize = $request->get('PageSize', 40); 
           $PageIndex = $request->get('PageIndex', 0);                      
            
            $lang = $request->get('lang', null);

            $query  = new \yii\db\Query();
            $query = $query->select(['*'])->from('slider');
            
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                    ]
                ],
                  'pagination' => [
                'defaultPageSize' => $PageSize,
                'page' => $PageIndex 
            ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}



public function actionGetbooks()
{
    
      
         $query  = new \yii\db\Query();
            $query = $query->select(['bookId','ISBN','bookName','rate','imageUrl'])->from('books') ;
             // $query->Where(['equal', 'id', 16]);
            
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                    ]
                ],
                  'pagination' => [
            ],
            ]);

            return $provider ;
}
// public function actionGetbooksb()
// {
    
//       $query  = new \yii\db\Query();
//                   $bookid =  $request->get('bookid', 1);     

//               $query = $query->select(['*'])->from('books') ;

//               $query->Where(['equal', 'bookId', $bookid]);

//             $provider = new ActiveDataProvider([
//                 'query' => $query,
//                 'sort' => [
//                     'defaultOrder' => [
//                     ]
//                 ],
//                   'pagination' => [
//             ],
//             ]);

//             return $provider ;
// }
public function actionGetauthors()
{
    
    
      $query  = new \yii\db\Query();
      
           $request   = Yii::$app->request;
           $pageSize  = $request->get('numberOfAuthors', 9); 
           
          
              $query = $query->select(['*'])->from('author') ;

            
              $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                    ]
                ],
                   'pagination' => 
                  [
                  'defaultPageSize' => $pageSize ,
                   ],
            ]);

            return $provider ;
}


public function actionGetauthorinfo()
{
    
    
     if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;


             $authorId =  $request->get('authorId', 80);
                
                            $reviews = "SELECT * FROM author where authorId=$authorId";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}


public function actionGetcategories()
{
    
     



            if (!empty($_GET)) {
        $model = new $this->modelClass;   
        
        try {
              $query  = new \yii\db\Query();
                  $request   = Yii::$app->request;
           $pageSize  = $request->get('numbercategories', 6); 
              $query = $query->select(['*'])->from('category') ;

           
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                    ]
                ],
                   'pagination' => 
                  [
                  'defaultPageSize' =>$pageSize,
                   ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}

public function actionGetcategorie()
{
    
     



            if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
           $query  = new \yii\db\Query();
              $query = $query->select(['*'])->from('category') ;


            if(!empty($category_id)){                         
                $query->where("product.category_id = $category_id");    
            }
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                    ]
                ],
                  'pagination' => [
              ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}

public function actionGetauthor()
{
    
      if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
           $query  = new \yii\db\Query();
              $query = $query->select(['*'])->from('author') ;


            if(!empty($category_id)){                         
                $query->where("product.category_id = $category_id");    
            }
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => 
                [
                    'defaultOrder' => []
                ],
                  'pagination' => 
                  [
                  'defaultPageSize' =>3,
                   ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}


public function actionGetauthorbooks1()
{
    
      if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
            $query  = new \yii\db\Query();
                        $request = Yii::$app->request;

            $authorId =  $request->get('authorid', 10);

              $query = $query->select(['*'])->from('books') ;
                $query->where("books.authorId = $authorId");    


            if(!empty($authorid)){                         
            }
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => 
                [
                    'defaultOrder' => []
                ],
                  'pagination' => 
                  [
                  
                   ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}

////// GET ALL BOOKS'S INFORMATION BY BOOK ID
public function actionGetbookbyid()
{
      if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $bookId =  $request->get('bookId', 26);


            $reviews = "select * from books
            inner join author on books.authorId=author.authorId  
            inner join category on books.categoryId=category.categoryId 
            where books.bookId='$bookId'
            ";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}

//// GET BOOK BY ISBN
public function actionGetbookbyisbn()
{
      if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $ISBN =  $request->get('ISBN', 'a1');


            $reviews = "select * from books where books.ISBN='$ISBN' ";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
           return $result; 
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}


// GET CATEGORY INFO BY ID


public  function  actionGetcategoryname(){
 if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
            $query  = new \yii\db\Query();
                        $request = Yii::$app->request;

            $categoryId =  $request->get('categoryId', 1);

              $query = $query->select(['*'])->from('category') ;
                $query->where("category.categoryId = $categoryId");    


            if(!empty($categoryId)){                         
            }
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => 
                [
                    'defaultOrder' => []
                ],
                  'pagination' => 
                  [
                   ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}

// GET BOOK REVIEW


public  function  actionGetbookreview(){
 if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $bookId =  $request->get('bookId', '1');


            $reviews = "select * from reviews where reviews.bookId='$bookId' ORDER BY rate DESC ";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    }
}


//////// GET BOOKS BY CATEGORY IS 
public function actionGetcategorybook()
{
  if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
            $query  = new \yii\db\Query();
                        $request = Yii::$app->request;

            $categoryId =  $request->get('categoryid', 30);

              $query = $query->select(['*'])->from('books') ;
                $query->where("books.categoryId = $categoryId");    


            if(!empty($categoryId)){                         
            }
            $provider = new ActiveDataProvider([
                'query' => $query,
                 'pagination' => 
                  [
                  'defaultPageSize' =>70,
                   ],
                 
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}


  
  public  function  actionGetbookreview1(){
    if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $bookId =  $request->get('bookid', 1);

            $reviews = "SELECT distinct userName,fullName, review, rate,imageUrl,reviewId ,date,reviews.userId
                  FROM reviews        
                  inner join users on reviews.userId = users.userId
                  where reviews.bookId = $bookId order by reviewId desc";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}


public function actionGetsearchbook()
{
  if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
            $query  = new \yii\db\Query();
                        $request = Yii::$app->request;

              $text =  $request->get('text', "هكذا");
            
         ltrim($text); 
              $query = $query->select(['*'])->from('books') ;
                 $query->Where(['like', 'books.bookName', $text]);
                 $query->orWhere(['like', 'books.tag1', $text]); 
                 $query->orWhere(['like', 'books.tag2', $text]); 
                 $query->orWhere(['like', 'books.tag3', $text]); 
                 $query->orWhere(['like', 'books.ISBN', $text]);
       
            if(!empty($text)){                         
            }
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => 
                [
                    'defaultOrder' => []
                ],
                  'pagination' => 
                  [
                   ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
  
}

// public function actionGetsuggestedbook()
// {
//     if (!empty($_GET)) 
//     {
//         $model = new $this->modelClass;            
//         try
//          {
//             $query  = new \yii\db\Query();
//                         $request = Yii::$app->request;

        



//             $result  =Yii::$app->db->createCommand()->insert('reviews', 
//             [
//                 'review' => 'test',
//                 'rate'   => '3',
//                 'bookId' => '3',
//                 'userId' => '1',
//                 'date'   => '22',

//             ])->execute();


       
          
//             $provider = new ActiveDataProvider([
//                 'query' => $query,
//                 'sort' => 
//                 [
//                     'defaultOrder' => []
//                 ],
//                   'pagination' => 
//                   [
//                    ],
//             ]);
//         }
//          catch (Exception $ex) {
//             throw new \yii\web\HttpException(500, 'Internal server error');
//         }

//         if ($provider->getCount() <= 0) {
//             throw new \yii\web\HttpException(404, 'No entries found with this query string');
//         } else {
//             return $provider;
//         }
//     } else {
//         throw new \yii\web\HttpException(400, 'There are no query string');
//     }
// }
public  function  actionGetsuggestedbook(){
    if (!empty($_GET)) {
        try {
            $request = Yii::$app->request;
            $bookName =  $request->get('bookName', 546);
            $authorName =  $request->get('authorName', 564);
            $note =  $request->get('note', 644645);
            $userId =  $request->get('userId', 1);

            // $reviews = "SELECT distinct userName, review, rate
            //       FROM reviews
            //       inner join users on reviews.userId = users.userId
            //       where reviews.bookId = $bookId";
                  
            // $result =Yii::$app->db->createCommand($reviews)->queryAll();
            
            $result =Yii::$app->db->createCommand()->insert('suggestedbooks', [
                'bookName' =>  $bookName,
                'bookAuthor' =>$authorName,
                'userId' =>$userId,
                'note'   => $note,
                'date'   =>'1-2-2'
            ])->execute();
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($result <= 0) {
            throw new \yii\web\HttpException(404, 'Error with adding the new record');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}


///// MOST RATED BOOKS 
public function actionGetmostratedbooks()
{
    
         $query  = new \yii\db\Query();
            $query = $query->select(['bookId','bookName','rate','imageUrl','ISBN'])->from('books') ;
             // $query->Where(['equal', 'id', 16]);
            
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                    ]
                ],
                  'pagination' => [
            ],
            ]);

   $provider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            // 'recipe_id'=> SORT_DESC
                        ]
                    ],
                      'pagination' => [
                    'defaultPageSize' => 4,
                    'page' => $PageIndex 
                ],
                ]);
            return $provider ;
} 

//// GET THE BOOKS FROM FIRST CATEGORY 
public function actionGetcategory1books()
    {
          if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;

           $reviews = "select * from books inner join category on books.categoryId=category.categoryId 
               where books.categoryId = 19" ;
                      
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            }
    }

    //// GET THE BOOKS FROM SECOND CATEGORY 
public function actionGetcategory2books()
    {
        
          if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;

           $reviews = "select * from books inner join category on books.categoryId=category.categoryId 
               where books.categoryId = 20" ;
                      
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            }
    }
    
    //// GET THE BOOKS FROM THIRD CATEGORY 
public function actionGetcategory3books()
    {
        
          if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;

           $reviews = "select * from books inner join category on books.categoryId=category.categoryId 
               where books.categoryId = 21" ;
                      
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            }
    }
    
    public function actionGetuserinformation()
        {
            
            $query  = new \yii\db\Query();
             $request = Yii::$app->request;
             $userid = $request->get('userid', 2);
            $query = $query->select(['*'])->from('users') ;
             $query->where("userId = $userid"); 
             
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                    ]
                ],
                  'pagination' => [
            ],
            ]);

   $provider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            // 'recipe_id'=> SORT_DESC
                        ]
                    ],
                      'pagination' => [
                    'defaultPageSize' => 4,
                    'page' => $PageIndex 
                ],
                ]);
            return $provider ;
        }
        
        
        public function actionGetquotes()
            {
                if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $bookId =  $request->get('bookid', 1);

           $reviews = "SELECT quoteId, quote, likeNumbers,date,quotes.userId,userName,fullName,imageUrl
                  FROM quotes        
                  inner join users on quotes.userId = users.userId
                  order by quoteId DESC" ;
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            }}
            
            /////
            
            public function actionGetbooksborrowingrecords()
            {
                
                 if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $bookId =  $request->get('bookid', 1);

           $reviews = "SELECT DISTINCT  borrowingRecordId, borrowing_record.bookId,borrowing_record.userId,bookName,userName,fullName,startDate,users.imageUrl
                  FROM borrowing_record        
                  inner join users on borrowing_record.userId = users.userId
                  inner join books on borrowing_record.bookId = books.bookId
                  where share=1
                  order by borrowingRecordId DESC" ;
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            }
            }
            
            
            //// get the users' quotes 
            
            public function actionGetuserquotes()
            {
                
                     
                 if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $userId =  $request->get('userId', 2);

           $reviews = "SELECT quoteId, quote, quotes.userId, likeNumbers, date,imageUrl,userName,fullName from quotes     
                  inner join users on quotes.userId = users.userId
                  
                  where quotes.userId=$userId
                   order by quoteId DESC" ;
           
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            
                        throw new \yii\web\HttpException(404, 'No entries found with this query string');

        } else {
                        
                        return $result;

        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            }
            }
              
              
              //////// GET USERS' REVIEWS
              
              public function actionGetuserreviews()
              {
                     if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $userId =  $request->get('userId', 1);

           $reviews = "SELECT reviewId,review,rate,date,userName,fullName,imageUrl,reviews.userId,reviews.bookId
                  FROM reviews        
                  inner join users on reviews.userId = users.userId
                  
                  where reviews.userId=$userId order by reviewId desc" ;
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            }
              }
              
              
              //// GET USERS' BOOKS
              
              public function actionGetuserrebooks()
              {
                      if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $userId =  $request->get('userId', 1);

           $reviews = "SELECT borrowingRecordId,fullName, borrowing_record.bookId,borrowing_record.userId,books.bookName,books.imageUrl,borrowing_record.startDate
                  FROM borrowing_record        
                  inner join users on borrowing_record.userId = users.userId
                  inner join books on borrowing_record.bookId = books.bookId
                  where borrowing_record.userId='$userId' and borrowing_record.share=!0  order by startDate DESC" ;
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            }
              
              }
              
              
              ///// SEARCH BOOKS BY TAGS
              
              public function actionSearchbytag()
              {
                   if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
            $query  = new \yii\db\Query();
                        $request = Yii::$app->request;

              $text =  $request->get('tag', "العلمانية");

              $query = $query->select(['*'])->from('books') ;
                 $query->Where(['like', 'books.tag1', $text]);
                 $query->orWhere(['like', 'books.tag2', $text]); 
                 $query->orWhere(['like', 'books.tag3', $text]); 




            

       
            if(!empty($text)){                         
            }
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => 
                [
                    'defaultOrder' => []
                ],
                  'pagination' => 
                  [
                   ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
              }
              
              
              
             ////////////////INSERT USER REVIEW
              public function actionAddreview()
              {
                  if (!empty($_GET)) {
        try {
            $request = Yii::$app->request;
            $review =  $request->get('review', 10);
            $rate   =  $request->get('rate', 10);
            $bookId =  $request->get('bookId', 10);
            $userId =  $request->get('userId', 10);
            
    date_default_timezone_set('Europe/Istanbul');

            $date = date("Y/m/d");
            
            $result =Yii::$app->db->createCommand()->insert('reviews', [
                'review' => $review,
                'userId' =>$userId,
                'bookId' =>$bookId,
                'rate'   =>$rate,
                'date'   =>$date
            ])->execute();
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($result <= 0) {
            throw new \yii\web\HttpException(404, 'Error with adding the new record');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
              }
              
              
              
              //// ADD QUOTE 
              
              public function actionAddquote()
              {
  if (!empty($_GET)) {
        try {
            $request = Yii::$app->request;
            $quote =  $request->get('quote', 10);
            $likeNumbers   =  $request->get('likeNumbers', 10);
            $userId =  $request->get('userId', 10);
            

          date_default_timezone_set('Europe/Istanbul');

            $date = date("Y/m/d");
            
            $result =Yii::$app->db->createCommand()->insert('quotes', [
                'quote' =>  $quote,
                'userId' =>$userId,
                'likeNumbers'  =>$likeNumbers,
                'date'   =>$date
            ])->execute();
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($result <= 0) {
            throw new \yii\web\HttpException(404, 'Error with adding the new record');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
           
              }
              
              
              
              ///// get author names for the books
              
              public function actionGetauthorname()
              {
                 if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
           $bookId =  $request->get('bookId', 26);

            $reviews = "SELECT book_author.authorId,authrorName,imageUrl,authorBio
                  FROM book_author        
                  inner join author on author.authorId = book_author.authorId
                  where book_author.bookId = $bookId";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            }  
              }
              
              /////////// GET AUTHOR INFORMATION LIKE(NAME, BIO ,IMAGE)
                    
              
              
              
              ////////////
              
              
              /// get the informations of user who borrowed the book 
              
              public function actionGetborrowedinfo()
              {
                  
                  if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
           $bookId =  $request->get('bookId', 'a1');

            $reviews = "SELECT distinct fullName,users.userId,	endDate
                  FROM borrowing_record        
                  inner join users on users.userId = borrowing_record.userId
                  where borrowing_record.bookId = '$bookId' order by borrowingRecordId desc";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            } 
              }
              
              
              ///// ADD THE INFORMATION OF BORROWING BOOK 
              public function actionAddbookborrowing()
              {
                  if (!empty($_GET)) {
        try {
            
            $request = Yii::$app->request;
                        date_default_timezone_set('Europe/Istanbul');

            $startDate = date("Y/m/d");
            $userId    =  $request->get('userId', 10);
            $bookId    =  $request->get('bookId', 10);
            $endDate   =  $request->get('endDate', 1);
            $share     =  $request->get('share', 1);
            
          //  $endDate = "2012/12/13";
            
            $endDate = strtotime($endDate);
        
             $endDate =  date("Y/m/d", $endDate);
             
            $result =Yii::$app->db->createCommand()->insert('borrowing_record', [
               
                'userId' =>$userId,
                'bookId'  =>$bookId,
                'startDate'   =>$startDate,
                'endDate'   =>$endDate,
                'share' =>$share,
                
            ])->execute();
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($result <= 0) {
            throw new \yii\web\HttpException(404, 'Error with adding the new record');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
              }
              
              
              // UPDATE BOOK'S STATUS 
              
     public function actionUpdatebookstatus()
     {
        if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $bookId =  $request->get('bookId', 4);
            $booStatus =  $request->get('bookStatus', 0);
            $userId =  $request->get('userId', 0);
            $borrowingCount = $request->get('borrowingCount', 0);


            $reviews = "UPDATE books SET bookstatus = '$booStatus',userId = '$userId', borrowingsCounts = '$borrowingCount'  WHERE bookId = $bookId";
                  
            $result =Yii::$app->db->createCommand($reviews)->execute();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server erbror');
        }

        if ($result < 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            } 
              }
              
                public function actionUpdatequotelikes()
     {
        if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $like =  $request->get('like', 4);
            $quoteId =  $request->get('quoteId', 70);


            $reviews = "UPDATE quotes SET likeNumbers = $like  WHERE quoteId = $quoteId";
                  
            $result =Yii::$app->db->createCommand($reviews)->execute();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server erbror');
        }

        if ($result < 1) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');

       
       
            } 
              }
              
              
                public  function  actionLogin(){
    if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $username =  $request->get('username', 'osama7star');
            $password =  $request->get('password', 'xx');

            $password = sha1($password);
            $reviews = "SELECT * from users where username='$username' and password='$password'";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            return  $result ;
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}


         
         
public  function  actionSignup(){
    if (!empty($_GET)) {
        try {
            $request = Yii::$app->request;
            $fullName =  $request->get('fullName', 12345);
            $userName =  $request->get('userName', 56488);
            $password =  $request->get('password', 123456);
            $imageUrl =  $request->get('imageUrl', 123456);

            $universityName =  $request->get('universityName', 644645);
            $collageName =  $request->get('collageName', 644645);
            $bio  = $request->get('bio', 644645);

            date_default_timezone_set('Europe/Istanbul');

            $startDate = date("Y/m/d");            
          
            
            $result =Yii::$app->db->createCommand()->insert('users', [
                'userName' =>  $userName,
                'fullName' =>$fullName,
                'password' =>sha1($password),
                'universityName'   => $universityName,
                'collageName'   =>$collageName ,
                'bio' => $bio ,
                'createdDate'=> $startDate,
                'imageUrl'=>$imageUrl
            ])->execute();
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($result <= 0) {
            throw new \yii\web\HttpException(404, 'Error with adding the new record');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}

public  function  actionCheckusername(){
    if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $username =  $request->get('userName', 'osama7star');


            $reviews = "SELECT * from users where username='$username' ";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            return 0 ;
        } else {
            return 1;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}


public  function  actionGetendedbook(){
    if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $userId =  $request->get('userId', 1);
            $nowdate = date("Y/m/d");

           

            $reviews = "SELECT * from  borrowing_record inner join books on   borrowing_record.bookId=books.bookId
            where  borrowing_record.userId='$userId'   and books.bookStatus=1 and books.userId='$userId'";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            return 0 ;
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}


public function actionSearchauthors()
{
  if (!empty($_GET)) {
        $model = new $this->modelClass;            
        try {
            $query  = new \yii\db\Query();
                        $request = Yii::$app->request;

              $text =  $request->get('name', "طارق");
            
         ltrim($text); 
              $query = $query->select(['*'])->from('author') ;
                 $query->Where(['like', 'author.authrorName', $text]);
                
                
                  
       
            if(!empty($text)){                         
            }
            $provider = new ActiveDataProvider([
                'query' => $query,
                'sort' => 
                [
                    'defaultOrder' => []
                ],
                  'pagination' => 
                  [
                   ],
            ]);
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if ($provider->getCount() <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $provider;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
  
}

   
   
public  function  actionGetconditions(){
    if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $userId =  $request->get('userId', 1);
            $nowdate = date("Y/m/d");

           

            $reviews = "SELECT * from configration";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            return 0 ;
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}


public function actionGetlastbooks()
{
   if (!empty($_GET)) {               
        try {            
            $request = Yii::$app->request;
            $bookId =  $request->get('bookid', 1);

            $reviews = "select * from books order by bookId desc";
                  
            $result =Yii::$app->db->createCommand($reviews)->queryAll();                                  
        }
         catch (Exception $ex) {
            throw new \yii\web\HttpException(500, 'Internal server error');
        }

        if (count($result) <= 0) {
            throw new \yii\web\HttpException(404, 'No entries found with this query string');
        } else {
            return $result;
        }
    } else {
        throw new \yii\web\HttpException(400, 'There are no query string');
    } 
}
   
}
