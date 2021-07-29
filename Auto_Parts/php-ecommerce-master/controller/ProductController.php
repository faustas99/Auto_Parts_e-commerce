<?php
/*
 * Copyright 2018 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once('AbstractController.php');
require_once('model/ProductTypeModel.php');
require_once('model/ProductModel.php');
require_once('view/View.php');

class ProductController extends AbstractController {

  private $logger;
  private $config;
  private $producModel;
  private $productTypeModel;
  
  public function __construct($config) {
    $this->config = $config;
    $this->logger = new Logger($config, 'ProductController');
    $this->producModel = new ProductModel($config);
    $this->productTypeModel = new ProductTypeModel($config);
  }

  public function getProduct($id) {
    $productTypes = $this->productTypeModel->getProductTypes();
    $product = $this->producModel->getProduct($id)[0];
    $selectedProductType = $product['type'];

    $user = null;
    if (isset($_SESSION['user'])){
      $user = $_SESSION['user'];
    }

    $view = new View("Product");
    $view->render(
      array('product' => $product, 
            'productTypes' => $productTypes, 
            'selectedProductType' => $selectedProductType,
            'user' => $user
      ), TRUE
    );
  }
}