test:
	php artisan test
test-coverage:
	php artisan test --coverage-clover build/logs/clover.xml
install:
	composer install
lint:
	composer run-script phpcs
lint-fix:
	composer run-script phpcbf
stylelint:
	npx stylelint resources/sass resources/css
stylelint-fix:
	npx stylelint resources/sass resources/css --fix
html-lint:
	npx htmlhint resources/views
setup: install
	cp -n .env.example .env || true
	php artisan key:generate
	touch database/database.sqlite
	php artisan migrate
npm:
	npm install && npm run dev
seed:
	php artisan db:seed
clear:
	php artisan route:clear
	php artisan view:clear
	php artisan cache:clear
	php artisan config:clear
start:
	heroku local -f Procfile.dev
