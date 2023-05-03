# Welcome to Inventory System
Hi fellow developers. This project used for skill improvement.

### To get started 
Clone the repository

    https://github.com/Miyunecadz/qr-attendance.git
Copy the `.env.example` file and name it `.env`
Change the value of `DB_USERNAME` and `DB_PASSWORD` it should not be null or the `DB_USERNAME` not be root

In the terminal make sure you are in the `inventory-system` directory.
Run this command

    docker-compose up -d --build
This will build the container and start the container
If you already build the container, you can just

    docker-compose up -d
Once the container is running, to access the `app` container run this command

    docker-compose exec app bash
 
This will attached the container to the terminal. Then install the dependencies

    composer install
Once installed you can now used the `php artisan` command.

### Stopping the container
To stop the container, simple run this command

    docker-compose down
Make sure you are not in the container shell, to exit in the container shell

    exit
