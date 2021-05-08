# LARAVEL IPFS FILESYSTEM

IPFS is A peer-to-peer hypermedia protocol
designed to make the web faster, safer, and more open.

read more: [ipfs](https://ipfs.io/)

## System Requirements

```bash
Node: v14.15.5 or above

PHP: 7.3v or Above

Composer: 2.0.4v or Above

Laravel: 8.0v or Above

```

## Requeriments

To use and configure u need to have some ipfs url and port available, for example you can download and install form here: 
[ipfs-desktop](https://github.com/ipfs/ipfs-desktop)

Select ur operating system, download and install it.

By default, you only need to add this on .env:

```bash

IPFS_BASE_URL=127.0.0.1
IPFS_PORT=5001

```

Change if u have another ipfs provider.

## Installation

Step 1: Open the terminal in your root directory(ipfs-filesystem) & to install the composer packages run the following command:

```bash
composer install
```

Step 2: In the root directory, you will find a file named .env.example, rename the given file name to .env and run the following command to generate the key (and you can also edit your database credentials here).

```bash
php artisan key:generate
```

Step 2: In the root directory, you will find a file named .env.example, rename the given file name to .env and run the following command to generate the key (and you can also edit your database credentials here).

```bash
php artisan key:generate
```

Step 3: By running the following command, you will be able to get all the dependencies in your node_modules folder:

```bash
npm install
```

Step 4: To run the project, you need to run following command in the project directory. It will compile the php files & all the other project files. If you are making any changes in any of the php file then you need to run the given command again.

```bash
npm run dev
```

Step 5: For migrate and seed run:

```bash
php artisan resetdb
```

Type yes 2 times to run seeders.

Required Permissions
If you are facing any issues regarding the permissions, then you need to run the following command in your project directory:

```bash
sudo chmod -R o+rw bootstrap/cache
sudo chmod -R o+rw storage
```


##LOGIN

With the seeders by default u can access with:

User: admin@test.com

Password: password



## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
