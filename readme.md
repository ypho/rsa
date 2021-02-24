# RSA Demo
**Disclaimer**: This project simulates the algorithm for generating an RSA public/private keypair and uses that for
encryption/decription of messages. This code is built for demonstration purposes only! It should **NEVER** be used in 
any kind of production environment, or anywhere else, except in the context of demonstration.

### Prerequisites
To run this project, you need one of the following:
- Docker
- Local PHP (7.4 or higher) installation + composer

### Installing
To run this project, do one of the following:

#### Docker
```
bin/rsa up [--build] [-d] -- This builds the Docker containers
bin/rsa setup -- This installs all the required packages from within the container
bin/rsa test -- This runs the tests in the Docker container
```
To bring down the Docker containers, use
```
bin/rsa down
```

When the containers are running, direct your browser to ```localhost:8085``` 

#### Local PHP installation
This only works if you have PHP 7.4 or higher running locally, and have access to the composer library.
```
composer install
vendor/bin/phpunit
bin/rsa local-php
```

When the application is running, you should be able to open it on ```localhost:8000```

## Author
**Ivo Geersen** - [Ypho.NL](https://ypho.nl)

## License
This project is licensed under the GNU GPL v3 License - see the [LICENSE](LICENSE) file for details
