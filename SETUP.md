# Local setup
## Prerequisites
- Install [Docker](https://www.docker.com) and then 
- Make sure you have three files (get it from whoever worked on Landtalk previously): `.env.php`, `.env.js`, and `dump.sql`.

## Setup instructions

Run the Docker application.

Copy the file `.env.php` to `landtalk-custom-theme/inc`.
Copy the file `.env.js` to `static-src`.

Run (keep this running in a separate terminal while doing future commands):
```
npm install
npm run watch
```

Run (keep this running in a separate terminal while doing future commands):
```
docker-compose up
```

Copy `dump.sql` to the `/dumps` file.

Then run:
```
docker-compose exec mysql bash
chmod +x ./dumps/setup-mysql.sh
./dumps/setup-mysql.sh
exit
```

Go to http://localhost and you should see this:



Go to http://localhost/wp-admin/ and sign in with username `root` and password `root`.

## Regular running instructions
To run the app in the future, run:
```
docker-compose up
```
And in another terminal, run:
```
npm run watch
```
And open http://localhost in your browser.

## Deployment
Run:
```
npm run build
```

And then connect to the server via FTP / SSH, then replace the remote `wp-content/themes/landtalk-custom-theme` directory with the local `./landtalk-custom-theme` directory.