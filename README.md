# Segundo Workshop Proyecto Juniors

## Temas Tratados
* Introducción a Laravel
* Uso de pruebas unitarias
* Uso de TDD

## Tips
* El archivo ***.env*** es único para cada ambiente y contiene información sensible, por lo tanto no se debe agregar al repositorio (Agregarlo a .gitignore).
* Usar la función ```env()```solo en los archivos de configuración. Esto es, porque al almacenar la caché de la configuración, Laravel no obtendrá valores del ***.env*** sino de la configuración, asi que cualquier cambio realizado en el ***.env** no se verá reflejado sino hasta que borremos la caché.
* Las contraseñas jamás se deben almacenar en texto plano, es decir, si mi contraseña es ***admin***, en la base de datos no puede mostrarse como ***admin*** sino con un hash. Para esto podemos hacer uso de la función ```bcrypt()```.
* Hacer uso de ```route()```para acceder a la url de la ruta a través de su nombre y no directamente de la url. Por ejemplo:
```php
Route::get('users', 'TestController@index')->name('users.index');

route('users.index');
```
* Si ya tenemos nuestra aplicación corriendo en producción, no podemos hacer modificaciones de las migraciones que ya fueron migradas. Por lo tanto, si por ejemplo queremos agregar un nuevo campo a una tabla que ya esta en producción, debemos crear otra migración para esto y correr luego el comando ``` php artisan migrate ```.
* Usar TDD, implica que ya conocemos muy bien los requerimientos, sabemos las entradas y las salidas, sabemos como se debe comportar el sistema o el módulo que estamos construyendo.
* TDD hace que nuestro flujo de desarrollo cambie, es decir, primero escribimos las pruebas de como se debe comportar el sistema y luego escribimos el código que hará que funcione.
* Realizar buenas pruebas implica dividir responsabilidades, es decir, si queremos probar que un método está almacenando datos en la base de datos, la prueba debe probar eso exactamente, no hay que probar si la vista del formulario se ve bien.
* Es una buena práctica implementar el patrón AAA en las pruebas. Esto nos ayuda a tener un código más legible y bien estructurado.