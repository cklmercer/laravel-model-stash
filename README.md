# laravel-model-stash
Easily maintain a "forever" cache of your models.

## Installation
##### 1.) Install via composer
```
composer require cklmercer/laravel-model-stash
```
## Usage
##### 1.) Use the trait `Cklmercer\ModelStash\CacheForever` within your model.
_Permission.php_
```
use Cklmercer\ModelStash\CacheForever;

class Permission extends Models 
{
    use CacheForever;
     
    // truncated for brevity..
}
```

*Disclaimer: This trait is best used on models which you query often but rarely create, update or delete.*

## License
[MIT](http://opensource.org/licenses/MIT)