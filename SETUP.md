# Local setup
Install [Docker](https://www.docker.com) and then run the Docker application.

Copy the file `.env.php` to `landtalk-custom-theme/inc`.
Copy the file `.env.js` to `static-src`.

Run:
```
npm install
npm run build
```

Run (keep this running in a separate terminal while doing things):
```
docker-compose up
```

Download dump.sql from someone on the Landtalk team.

Copy `dump.sql` and `mysql-test-user-setup.sql` to `/dev-env/dumps`.

Copy `setup-wordpress.sh` to `/dev-env/wordpress`.

Then run:
```
docker-compose exec mysql bash
chmod +x ./dumps/setup-mysql.sh
./dumps/setup-mysql.sh
exit
```

Then run:
```
docker-compose exec wordpress bash
chmod +x setup-wordpress.sh
./setup-wordpress.sh
```

Go to http://localhost and you should see this:

![image](https://user-images.githubusercontent.com/1689183/55282261-16009180-5317-11e9-9aa5-8b0ddda1c612.png)

Go to http://localhost/wp-admin/
