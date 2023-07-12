# CS:GO Server API - Laravel package
Laravel package to interface [CS:GO Server API](https://github.com/laspi94/csgo-server-api).

## Cómo funciona
This package interfaces [my CS:GO API](https://github.com/laspi94/csgo-server-api) main endpoints:

`/send` que puede enviar un comando, con un retraso a un solo servidor;

`/sendAll` que puede enviar un comando, con un retraso a todos los servidores controlados por la API;

## Requisitos
* PHP 8.*
    
* [CS:GO Server API](https://github.com/laspi94/csgo-server-api) instalación
  
## Instalación

Usando el Composer, run (Laravel/Framework ^10.0):

`composer require laspi94/csgo-server-api-laravel:3.0.0`
  
Publish config:

`php artisan vendor:publish --provider="laspi94\CsgoServerApi\Providers\PackageServiceProvider"`

## Configuración
Cualquier configuración puede ser modificada en `configs/csgo-api.php`

#### `CSGO_API_URL=http://my-csgo-server-api.com/`

URL del punto final del servidor API.

#### `CSGO_API_KEY=abcdef123456`

Clave de autenticación del servidor API.

## Usage

#### Creating a command
```php
$myCommand = new Command($command, $delay = 0, $wait = false);
```

###### Parameters
* `$command` es el comando a ejecutar;
* `$delay` dice cuánto tiempo debe esperar la API antes de enviar el comando;
* `$wait` le dice a la API que espere la respuesta del servidor antes de responder la solicitud.

###### Examples
```php
// Get server stats
$statsCommand = new Command('stats', 0,  true);

// Kick bots
$botsCommand = new Command('bot_kick');

// Schedule say message
$sayCommand = new Command('say Hi!', 30000)
```

#### Creating a server
```php
$myServer = new Server($address, $port);
```

###### Parameters
* `$address` es la direccion completa o solo ip;
* `$port` es el puerto del servidor.

###### Examples
```php
/** 
 * Uso de IP y puerto
 */
$server1 = new Server('177.54.150.15', 27001);

/** 
 * Usando la dirección completa
 */  
$server2 = new Server('177.54.150.15:27002');
```


#### Envío de una lista de comandos a una lista de servidores

```php
/** 
 * Puede reemplazar `direct` con` to ', son los mismos  
 */ 
CsgoApi::direct(ByCommandSummary::class)->addCommand([
    new Command('stats', 1500, true),
    new Command('status', 1500, true),
])->addServer(
    new Server('177.54.150.15:27001'),
    new Server('177.54.150.15:27002'),
)->send();

/** 
 * Respuesta esperada:
 * [
 *     "stats"  => [
 *       "177.54.150.15:27001" => "response-1",
 *       "177.54.150.15:27001" => "response-2",
 *     ],
 *     "status" => [
 *       "177.54.150.15:27001" => "response-3",
 *       "177.54.150.15:27001" => "response-4",
 *      ],
 * ]
 */ 
```

#### Broadcasting a list of commands to all servers controlled by the API
```php
/** 
 * Envía `say` y `quit` a todos los servidores
 * 
 * Puedes reemplazar `broadcast` con ``, son lo mismo
 */ 
CsgoApi::broadcast(ByCommandSummary::class)->addCommand([
    new Command('say "Closing server for maintenance in 30 seconds', 0),
    new Command('say "Closing server for maintenance in 15 seconds', 15000),
    new Command('say "Closing server for maintenance in 5 seconds', 25000),
    new Command('quit', 30000),
])->send();
```

#### Diferentes formas de agregar comandos o servidores
En un intento por evitar instanciar cada servidor o comando, puede usar los siguientes formatos:

###### Servers
```php
/**
 * Creación de un remitente directo
 */ 
$sender = CsgoApi::direct();

/**
 * Usando el objeto de servidor completo
 * 
 * Los 4 métodos son idénticos, use lo que se sienta bien
 * 
 */
$sender->addServer(new Server('177.54.150.15:27001'));
$sender->addServers(new Server('177.54.150.15:27001'));
$sender->server(new Server('177.54.150.15:27001'));
$sender->servers(new Server('177.54.150.15:27001'));

/**
 * Uso de la lista de objetos del servidor 
 */
$sender->addServer([
    new Server('177.54.150.15:27001'),
    new Server('177.54.150.15:27002'),
]);

/**
 * Usando dirección de cadena
 */
$sender->addServer('177.54.150.15:27002');

/**
 * Uso de la lista de direcciones de cadena
 */
$sender->addServer([
    '177.54.150.15:27001',
    '177.54.150.15:27002',
]);

/**
 * Uso de IP y puerto por separado
 */ 
$sender->addServer('177.54.150.15', 27002);

/**
 * Usando la lista de IP y puertos
 */
$sender->addServer([
    ['177.54.150.15', 27001],
    ['177.54.150.15', 27002],
]);
```

###### Commandos
```php
/**
 * Creación de un remitente directo
 */ 
$sender = CsgoApi::direct();

/**
 * Usando el objeto de comando completo
 *  
 * Los 4 métodos son idénticos, use lo que se sienta bien
 * 
 */
$sender->addCommand(new Command('stats', 1000, false));
$sender->addCommands(new Command('stats', 1000, false));
$sender->command(new Command('stats', 1000, false));
$sender->commands(new Command('stats', 1000, false));

/**
 * Uso de la lista de objetos de comando
 */ 
$sender->addCommandItem([
    new Command('stats', 1500, false),
    new Command('status', 1500, false),
]);

/**
 * Uso de parámetros de comando directamente
 */
$sender->addCommand('stats', 1500, false);

/**
 * Uso de la lista de parámetros de comando
 */ 
$sender->addCommand([
    ['stats', '1500', false],
    ['status', '1500', false],
]);
```

#### Changing summary class
Puede cambiar la forma en que se agrupan las respuestas pasando una nueva clase de Resumen

###### `ByCommandSummary::class`
Agrupa las respuestas primero por comando y luego por servidor.
```php
/** 
 * Ejemplo de respuesta:
 * [
 *    "stats"  => [
 *        "177.54.150.15:27001" => "response-1",
 *        "177.54.150.15:27002" => "response-2",
 *    ],
 *    "status" => [
 *        "177.54.150.15:27001" => "response-3",
 *        "177.54.150.15:27002" => "response-4",
 *    ],
 * ]
 */ 
```

###### `ByServerSummary::class`
Agrupa las respuestas primero por servidor y después por comando.
```php
/** 
 * Ejemplo de respuesta:
 *  [
 *      "177.54.150.15:27001"  => [
 *          "stats" => "response-1",
 *          "status" => "response-3",
 *      ],
 *      "177.54.150.15:27002" => [
 *          "stats" => "response-2",
 *          "status" => "response-4",
 *      ],
 *   ]
 */ 
```

###### Ejemplo
```php
$directByCommandSender = CsGoApi::direct(ByCommandSummary::class);
$directByServerSender = CsGoApi::direct(ByServerCummary::class);

$broadcastByCommandSender = CsGoApi::broadcast(ByCommandSummary::class);
$broadcastByServerSender = CsGoApi::broadcast(ByServerCummary::class);
```

###### 
```php
$directByCommandSender = CsGoApi::direct(ByCommandSummary::class);
$directByServerSender = CsGoApi::direct(ByServerCummary::class);

$broadcastByCommandSender = CsGoApi::broadcast(ByCommandSummary::class);
$broadcastByServerSender = CsGoApi::broadcast(ByServerCummary::class);
```

## Author Original

- [@HugoJF](https://www.github.com/HugoJF)