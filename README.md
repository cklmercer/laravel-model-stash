# laravel-model-stash
Easily maintain a "forever" cache of your models.

*Disclaimer: This trait is best used on models which you query often but rarely create, update or delete.*

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

Now, whenever you create/update/delete/restore an instance of your model your cache will automatically be updated.

##### 2.) Access you cached models

Get an index of your cached models use the plural form of the model's class name.
```
$permissions = cache('permissions')
```

Get a specific instance using the instance's route key. _(Defaults to the model's id)_
```
$permission = cache('permissions:1')
```

If you use a slug for your route key then your cache keys become significantly more readable.
```
$permission = cache('permissions:create-user')
```

## License
[MIT](http://opensource.org/licenses/MIT)
