[Events](https://book.cakephp.org/4/en/core-libraries/events.html) work the same as in standard CakePHP applications. An Event Listener Loader is provided to automatically
register events in your `App\Event` namespace.

### Event Listener Loader

The Event Listener Loader will automatically load all listeners which implement `Cake\Event\EventListenerInterface`
within a given namespace. Example:

```php
# src/Application.php
use Cake\Http\BaseApplication;
use MixerApi\Core\Event\EventListenerLoader;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        // ...other code
        (new EventListenerLoader())->load(); # defaults to `App\Event`
        // other code...
    }
}
```

The default behavior loads all listeners in `App\Event`. You can pass a different namespace argument
such as `load('App\Event\Listeners')` if your listeners are located elsewhere.
