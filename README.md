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
```
// Role.php

use Cklmercer\ModelStash\CacheForever;
use Illuminate\Database\Eloquent\Model;

class Role extends Models 
{
    use CacheForever;
     
    // truncated for brevity..
}
```

Now, whenever you create/update/delete/restore an instance of your model your cache will automatically be updated.

##### 2.) Get an index of your cached models.

*Note: The default cache name will be the plural form of your model's class name.*

```
$roles = \Cache::get('roles')
```

You can change your model's cache name by defining a `$cacheName` property on your model.

```
// Role.php

use Cklmercer\ModelStash\CacheForever;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use CacheForever;

    /**
     * The model's cache name.
     *
     * @var string
     */
    protected $cacheName = 'cachedRoles';

    // truncated for brevity..
}
```
```
$roles = \Cache::get('cachedRoles');
```

##### 3.) Get a specific instance of a cached model.
*Note: The convention used to get a specific instance is "cache-name:cache-key", with cache-key defaulting to your model's route key.*
```
$role = \Cache::get('roles:1')
```

You can change your model's cache key by defining a `$cacheKey` property on your model.

```
// Role.php

use Cklmercer\LaravelModelStash\CacheForever;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use CacheForever;

    /**
     * The model's cache key.
     *
     * @var string
     */
     protected $cacheKey = 'slug';

     // truncated for brevity..
}
```
```
$role = \Cache::get('roles:create-user')
```

## License
[MIT](http://opensource.org/licenses/MIT)
