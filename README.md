# Psicotest

- Aplicación para examen técnico 

# Requerimientos

- Git `~> 2.17.1`
- Docker `~> 19.03.12`
- Docker Compose `~> 1.26.0`

## Uso de docker

Comandos básicos:

- `docker-compose up -d`: Crear y enciende los contenedores de los servicios y los mantiene corriendo en segundo plano.
- `docker-compose down`: Elimina los contenedores de los servicios, si se agrega la bandera `-v`, va a eliminar los volúmenes. Los volúmenes es donde se almacena la información de la base de datos y el cache de los servicios.
- `docker-compose start`: Enciende los contenedores de los servicios.
- `docker-compose stop`: Apaga los contenedores de los servicios.
- `docker-compose restart`: Reinicia los contenedores de los servicios.
- `docker-compose logs -f`: Muestra los logs de los servicios, se puede visualizar los logs de un servicio en individual si agrego el nombre del servicio después de la bandera `-f`.
- `docker-compose exec [NOMBRE DEL SERVICIO] [COMANDO]`: Ejecuta un comando dentro de los contenedores de un servicio.

## Comandos útiles

- `docker-compose exec laravel composer run-script reset-db`: Esto volverá a ejecutar todas la migraciones y las semillas
- `for d in $(ls -d ./tests/Feature/*/); do php artisan test --without-tty --stop-on-failure $d; if (( $? != 0 )); then break; fi; done`: Ejecuta las pruebas
