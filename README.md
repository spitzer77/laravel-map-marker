## Install on Ubuntu:

1) Clone the repository: <b>git clone https://github.com/spitzer77/laravel-map-marker.git </b>
2) Install Composer dependencies: <b>composer install</b>
3) Install npm dependencies: <b>npm install</b>
4) Set appropriate permissions: <b>chmod 777 -R ./storage/</b>
5) Create a new SQLite database:
- <b>touch database/database.sqlite</b>
- <b>chmod 777 -R ./database/</b>
- <b>chmod 777 -R ./database/database.sqlite</b>
6) Run database migrations: <b>php artisan migrate</b>
7) Build the project: <b>npm run build</b>

## How to use:

1) Go to http://your_server/markers
2) Open the same link in another browser or in another tab of the current browser to observe both windows concurrently.
3) Set dummy marker coordinates with a longitude of 31.20 and a latitude of 50.80 to display it on the current map under the form.
4) After 1 minute, the marker will disappear from all open links.