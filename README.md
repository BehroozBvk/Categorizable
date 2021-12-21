

Categorizable Package
============

This Package enables you to Categorize your Eloquent Models. just use the trait in the model and you're good to go.


### Requirements
- PHP 7.2+
- Laravel 7+

## Installation

	composer require bvkdev/categorizable

#### Publish and Run the migrations


```bash
php artisan vendor:publish --provider="BvkDev\Categorizable\CategorizableServiceProvider"

php artisan migrate
```


Laravel Categorizable package will be auto-discovered by Laravel. and if not: register the package in config/app.php providers array manually.
```php
'providers' => [
	...
	BvkDev\Categorizable\CategorizableServiceProvider::class,
],
```


#### Setup models - just use the Trait in the Model.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use BvkDev\Categorizable\Categorizable;

class Product extends Model
{
	use Categorizable;
}

```

## Usage
first of all we need to create some Category to work with. Laravel Categorizable package relies on another package called [laravel-nestedset](https://github.com/lazychaser/laravel-nestedset) that is responsible for creating, updating, removing and retrieving single or nested categories.
Here i demonstrate how to create categories and assign one as the other's child.. but you can always refer to package's repository for full documentation.
https://github.com/lazychaser/laravel-nestedset


```php
use App\Product;
use BvkDev\Categorizable\Category;

// first we create a bunch of categories

// create "BackEnd" category
Category::create([
	'name' => 'BackEnd'
]);

// create "PHP" category
Category::create([
	'name' => 'PHP'
]);

// create "FrontEnd" category
Category::create([
	'name' => 'FrontEnd'
]);

// create "Test" Category (alternative way)
$test = new Category();
$test->name = 'Test';
$test->save();


// assign "PHP" as a child of "BackEnd" category
$parent = Category::findByName('BackEnd');
$child = Category::findByName('PHP');
$parent->appendNode($child);

// delete "Test" Category
$testObj = Category::findByName('Test');
$testObj->delete();



//  assuming that we have these variables
$product = Product::first();

// 3 different ways of getting a category's instance
$backendCategory = Category::findById(1);	// 'BackEnd'
$phpCategory = Category::findByName('PHP');	// 'PHP'
$frontendCategory = Category::find(3);		// 'FrontEnd'


```

### Attach the Product to category

```php
    $product->attachCategory($phpCategory);
```

### Detach the Product from a category

```php
    $product->detachCategory($phpCategory); 
```

### Attach the Product to list of categories

```php
    $product->syncCategories([
	    $phpCategory,
	    $backendCategory
	    ]); 
```

### Detach the Product from all categories

```php
    $product->syncCategories([]); 
```

### Sync the categories attached to a Product

```php
    $product->syncCategories([
	    $frontendCategory
	    ]); 


    // removes attached categories & adds the given categories
```


### Check if Product is attached to categories (boolean)
```php
    // single use case
    $product->hasCategory($phpCategory);

    // multiple use case
    $product->hasCategory([
	    $phpCategory,
	    $backendCategory
	    ]);


    // return boolean
```

### List of categories attached to the Product (array)
```php
    $product->categoriesList();


    // return array [id => name]
```

### List of categories IDs attached to the Product (array)
```php
    $product->categoriesId();


    // return array
```

### Get all Products attached to given category (collection)
```php
    $categoryProducts = Category::find(1)
	    ->entries(Product::class)
	    ->get();


    // return collection
```

---

## Relationships

### categories() Relationship
```php
    $productWithCategories = Product::with('categories')
	    ->get();


     // you have access to categories() relationship in case you need eager loading
    
```

### parent Relationship
```php
    $category = Product::first()->categories()->first();
    
    $category->parent;
    // return the category's parent if available

```

### children Relationship
```php
    $category = Product::first()->categories()->first();
    
    $category->children;
    // return the category's children if any

```

### ancestors Relationship
```php
    $category = Product::first()->categories()->first();
    
    $category->ancestors;
    // return the category's ancestors if any

```

### descendants Relationship
```php
    $category = Product::first()->categories()->first();
    
    $category->descendants;
    // return the category's descendants if any

```

#### Credits

- Behrooz Valikhani - <behrooz.valikhani@gmail.com>
