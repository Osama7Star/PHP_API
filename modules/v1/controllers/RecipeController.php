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

        //get the step with instructions and it's ingridents and image of ingrident
        public function actionRecipe()
        {

          if (!empty($_GET)) {
              $model = new $this->modelClass;            
              try {
                 
                  $request = Yii::$app->request;
                  $lang = $request->get('lang', null);
                  
                  $recipe_id   = $request->get('recipeID', null);
                  $lang = $request->get('lang', null);
  
                  $name = "e_name as recipe_name";
                  $ingredient_name = "e_name as ingredient_name";
                  $small_desc = "e_small_desc as small_desc";
                  $desc = "e_desc as desc";
                  if($lang == 'ar'){
                      $name = "a_name as recipe_name";
                      $small_desc = "a_small_desc as small_desc";
                      $desc = "a_desc as desc";
                      $ingredient_name = "a_name as ingredient_name";
                  }              
            
            $recipe = "SELECT distinct recipe.e_name ,recipe.e_desc,recipe.e_small_desc,recipe.image,recipe.period,recipe.person_count               
            FROM recipe                     
            where recipe.recipe_id = $recipe_id";
            
            $recipe =Yii::$app->db->createCommand($recipe)->queryAll();

            $data = $o = (object) [];

            if(count($recipe)>0){
              $data->name = $recipe[0]['e_name'];
              $data->desc = $recipe[0]['e_desc'];
              $data->image = $recipe[0]['image'];
              $data->period = $recipe[0]['period'];
              $data->person_count = $recipe[0]['person_count'];
              
          }

            $steps_id = "SELECT distinct recipe_step.recipe_step_id
            FROM recipe
            inner join recipe_step on recipe_step.recipe_id = recipe.recipe_id              
            where recipe.recipe_id = $recipe_id";
         
            $steps_id_list =Yii::$app->db->createCommand($steps_id)->queryAll();
            $data->steps_number = count($steps_id_list);
            // $data->steps = [];
            //$data->ingridents = [];
            //$data->nutrution = [];
            if(count($steps_id_list)>0){
              $result = array();
              foreach($steps_id_list as $key=>$value){
                  // echo $k;
                  $recipe_step_id   = $value['recipe_step_id']; 
                  // echo         $recipe_step_id.' ';      
                  $recipes = "SELECT distinct recipe_step.instruction ,recipe_step_ingredient.amount,
                  recipe_step_ingredient.measure_unit,ingredient.e_name ,ingredient.image
                  FROM recipe_step        
                  inner join recipe_step_ingredient on recipe_step.recipe_step_id = recipe_step_ingredient.recipe_step_id
                  inner join ingredient on recipe_step_ingredient.ingredient_id = ingredient.ingredient_id        
                  where recipe_step.recipe_step_id = $recipe_step_id";
                  
                  $recipes =Yii::$app->db->createCommand($recipes)->queryAll();                                  
                  
                  if(count($recipes)>0){
                      foreach($recipes as $k=>$v){
                          $data->ingredients[] = array('amount' => $v['amount'],'measure_unit' => $v['measure_unit'],'e_name' => $v['e_name'],'image' => $v['image']);
                          //array_push($result,$v['e_name']);                        
                      }
                  }
              }
              //$data->ingridents= $result;
            }

            //nurition
            $nurition = "SELECT distinct nutrition.*
            FROM recipe
            inner join nutrition on recipe.recipe_id = nutrition.recipe_id              
            where recipe.recipe_id = $recipe_id";
         
            $nurition_list =Yii::$app->db->createCommand($nurition)->queryAll();
            $result_nurition = array();
            foreach($nurition_list as $k=>$v){
                $data->nutrution[] = array('calories' => $v['calories'],'energy' => $v['energy'],'fat' => $v['fat'],'carp' => $v['carp'],'proten' => $v['proten']);                
            }
 
        //   $data->nutrution = $result_nurition;  
          return $data;            
              }
               catch (Exception $ex) {
                  throw new \yii\web\HttpException(500, 'Internal server error');
              }
          } else {
              throw new \yii\web\HttpException(400, 'There are no query string Plese Enter Recipe ID ');
          }
      }

// 

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
           $request = Yii::$app->request;
           $PageSize = $request->get('PageSize', 40); 
           $PageIndex = $request->get('PageIndex', 0);               
           $text =  $request->get('Text', null);
            
            $lang = $request->get('lang', null);

            $query  = new \yii\db\Query();
            $query = $query->select(['*'])->from('category');

                

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



}


