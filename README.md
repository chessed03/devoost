# Para iniciar el proyecto
    1.- Ejecutar:
        - composer install

    2.- Ejecutar:
        - npm install
        - npm run build

    3.- Hacer lo siguiente:
        - Crear una base de datos en mysql con el nombre que más prefiera.
        - Confurar el archivo .env con el nombre de la BD recien creada.
        - Ejecutar el comando:
            - php artisan migrate

    4.- Ejecutar el server con:
        - php artisan serve

    5.- Crear un usuario:
        - Con el link "Registrarse" crea su usuario con los datos solicitados.
        - Una vez echo el registro, lo envia al login.
        - Ingresa con su email y password previamente creados.

    6.- Una vez en el sistema de órdenes veremos lo siguiente:
        - Paágina de bienvenida.
        - Mené con la siguientes opciones:
            - Inicio.
            - Clientes.
            - Productos.
            - Precios.
            - Ordenes.
            - Salir (Cierre de sesión.)
        
        - Nota: no se puede acceder por url sino se ha inicado sesion, una vez la sesion termina ya no tenemos acceso al sistema.

    7.- Uso del sistema
        - Creamos clientes
            - Ingresamos los datos solicitados.
            - Podemos: editar y elimiar.
        - Creamos productos
            - Ingresamos los datos solicitados.
            - El codigo del producto es la referencia principal deber de 8 digitos y no se debe repetir.
            - Podemos: editar y elimiar
        - Creamos precios para productos
            - Ingresamos los datos solicitados.
            - Cuando el precio se actualiza el anterio no se borra se genera un nuevo item en la BD y el precion anterior queda para el historico.
            - Podemos: editar y elimiar
        - Creamos Ordenes
            - Cuando creamos una orden nueva, de debe capturar el codigo del producto, cuando este completa las 8 posicines hace la busqueda automaticamente.
            - Por cada busqueda se agregará un nuevo item a la lista.
            - Si es un producto diferente se crea otra fila.
            - La sumatorio cambiará automaticamente.
            - Podemos: editar y elimiar
            - Para la edicion se pueden agregar mas elementos a lista o eliminarlo segun convengan.

    Saludos.
        

