# README

## Project Overview
At the root of this project, you'll see two main folders for the two primary coding environments. The `/api` folder contains a Laravel project which runs on a server, while the `/client` folder contains a React project which runs in one of many potential browsers. Each environment requires its own domain expertise and tooling, which should be well isolated with this setup. Neither side currently creates its own server, but instead relies on a separate web server to forward requests to the appropriate files.

### API (Laravel)
[Laravel](https://laravel.com/) is used here to support development of a data API. This app was originally generated from the `composer create-project --prefer-dist laravel/laravel` generator.

### Client (React)
The client's code, build process, and server logic has been entirely decoupled from our PHP/Laravel code. Aside from making sure build files (HTML, CSS, and JS) are up-to-date, the deployment process shouldn't be much different than simply deploying Laravel by itself.

Specifically, the client is built around the [React](https://reactjs.org/) library, which was generated from the [Create React App](https://www.npmjs.com/package/create-react-app) tool. It may be helpful to read the documentation for both, since the generator adds additional libraries to support React.

### Server-side support for Client
If server-side logic is later needed to better support the client, like with SEO or the concepts found in the [PRPL pattern](https://web.dev/apply-instant-loading-with-prpl/), we may want to add a separate server/service specific to the client app. Thanks to the existing separation, this should be easy enough to add without requiring any type of major rewrite. To support these features we would likely add Node server-side (since the React ecosystem is built on that technology), and the existing web server config would forward client requests to the new Node server, instead of serving up the static files from the `build` folder.

## Setup
PHP, Composer, a web server (Typically Nginx or Apache), and MySQL need installed to support the API. Most can be installed together as a single package. Node also needs installed to support the client (dev only)

The `apache.tpl.conf` and `ports.tpl.conf` are the files I used to get Apache working locally. By setting environment variables SERVER_NAME, PORT, PROJECT_DIR, and APACHE_LOG_DIR, the following Linux-based commands can be used to deploy and update the Apache configuration using our repo code (should be useful for continuous deployment):
- `envsubst < ${PROJECT_DIR}/apache.tpl.conf > /etc/apache2/sites-available/000-default.conf` \*
- `envsubst < ${PROJECT_DIR}/ports.tpl.conf > /etc/apache2/ports.conf` \*
- `apachectl restart`, if running

\* Note that you may need to install the `gettext-base` package (or similar package depending on your Linux flavor) for `envsubst` to work. Also, you can just as easily do the process manually - the files aren't much to go through.

In addition to those two configuration files, Apache needs the rewrite module enabled (`a2enmod rewrite`) and the `opcache` extension should be enabled, at very least in production (otherwise, Laravel's performance suffers terribly - rerunning the same exact logic during every request to build the app)

We also need to ensure our PHP and JS packages are all installed before anything will work:
- `composer install -d=${PROJECT_DIR}/api` (add `--no-dev` for production)
- `npm install --prefix=${PROJECT_DIR}/client` (add `--production` for production)

Laravel has a couple more requirements to set up a new environment. By default, Laravel uses either actual environment variables or those found in an `env` file to gather its configuration settings. These values are primarily used by the files under `config`. If you are fine with the env file approach (easier for development), copy the `.env.example` file to a new `env` file. Update all values as needed except APP_KEY, then run `php artisan key:generate` to generate and inject the APP_KEY environment variable into `env`. (If you don't want to use an `env` file - maybe, in production - you can alternatively use `php artisan key:generate --show` to get the APP_KEY value)

Finally, note that you have some choices when running the application. Apache will likely be running as a service in the background but when it comes to developing the client, Apache only knows about what is in the `build` folder. So, you can either run `npm run build` from the `${PROJECT_DIR}/client` folder or you can use `npm start` and visit `localhost:3000` in the browser. The latter option is better for speedy development (has HMR), so you can mostly just save files and immediately see the changes in the browser (you don't need to run the build command for every change and/or hit the reload button in the browser all the time). HMR isn't perfect, but it can definitely save some time there.
