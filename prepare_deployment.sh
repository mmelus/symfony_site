### $1 parameter is the mailer DNS

rm -rf deployment-old.zip
### Check if a directory exists, THEN rename ###
[ -f "deployment.zip" ] && mv deployment.zip deployment-old.zip

### Replace APP_ENV line in .env
sed -i 's/APP_ENV=dev/APP_ENV=prod/' .env

### Install everything necessary
composer install --no-dev --optimize-autoloader
composer dump-autoload --optimize --no-dev --classmap-authoritative
composer require symfony/apache-pack
npm run build

### Create deployment folder
mkdir deployment
mkdir deployment/symfony
mkdir deployment/symfony/var
cp -R var/my_personal_site_data.db deployment/symfony/var
cp -R bin deployment/symfony/
cp -R config deployment/symfony/
cp -R public deployment/
cp -R src deployment/symfony/
cp -R templates deployment/symfony/
cp -R translations deployment/symfony/
cp -R vendor deployment/symfony/
cp -R .env deployment/symfony/
cp -R composer.json deployment/symfony/
cp -R composer.lock deployment/symfony/
cp -R package.json deployment/symfony/
cp -R package-lock.json deployment/symfony/
cp -R symfony.lock deployment/symfony/

### Add public_dir node to composer.json
sed -i 's/"extra": {/"extra": {"public_dir":"public_html",/' deployment/symfony/composer.json
### Replace link to sources from index.php
sed -i 's/\/vendor\/autoload_runtime.php/\/symfony\/vendor\/autoload_runtime.php/' deployment/public/index.php
### Replace links to assets from sources
sed -i 's/public\//..\/public_html\//' deployment/symfony/config/packages/webpack_encore.yaml
### Add mailer configuration if not NULL
[[ ! -z "$1" ]] && echo "$1" >> deployment/symfony/.env

### create Zip and delete Deployment folder
zip deployment.zip -r deployment
rm -rf deployment

### Replace APP_ENV line in .env - Reset to DEV
sed -i 's/APP_ENV=prod/APP_ENV=dev/' .env
composer install

#git add .
#git commit -m "Deployment commit"
#git push

