# RSA Demo
**Disclaimer**: This project simulates the algorithm for generating an RSA public/private keypair and uses that for
encryption/decription of messages. This code is built for demonstration purposes only! It should **NEVER** be used in 
any kind of production environment, or anywhere else, except in the context of demonstration.

## Prerequisites
To run this project, you need one of the following:
- PHP (7.4+) and Composer
- Docker

## Installing
When the code is checked out, you have everything you need. Depending on your preferred method of installation, use
one of the following options:

### Local PHP Installation
If you wish to use your local PHP installation, you can run the following command:
```
./bin/rsa/local-php
```
With that command, a local server will be started, and can be visited through: http://localhost:8085

### Docker Containers
If you have no PHP/Composer available on your local system, you can also use Docker containers. You'll need to 
execute the following commands in order to make everything work:
```
bin/rsa up [--build] [-d] -- This builds the Docker containers
bin/rsa setup -- This installs all the required packages from within the container
bin/rsa test -- This runs the tests in the Docker container
```

When the containers are running, you can visit the app through: http://localhost:8085

To bring down the Docker containers, use
```
bin/rsa down
```

## Author
**Ivo Geersen** - [Ypho.NL](https://ypho.nl)

## License
This project is licensed under the GNU GPL v3 License - see the [LICENSE](LICENSE) file for details
