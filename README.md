# GAME KEY
## Software needed to run this project

1. [Docker Desktop](https://www.docker.com/products/docker-desktop/) (for Windows or Mac)
2. [Docker CE](https://docs.docker.com/engine/install/ubuntu/) (for Linux)

## Instructions on how to run this project

1. Copy the content .env.example and paste it into .env

2. Run docker compose command.

    ```
    docker compose up -d --build
    ```
3. To check if all containers ( 2 of them ) are up:

    ```
    docker ps
    ```
    
3. Once everything is okay, run this command below to install Laravel dependencies.

    ```
    docker exec game-key composer install
    docker exec game-key php artisan optimize
    docker exec game-key php artisan migrate --seed
    docker exec game-key php artisan l5-swagger:generate 

    ```
4. Access http://localhost/api/documentation for Swagger. Feel free to change the host, by editing your host file.

	```
	127.0.0.1       gamekey.dev
	```


5. To run test.

    ```
    docker exec game-key php artisan test

    ```

6. To close the docker compose, please run this.

    ```
    docker compose down
   ```
