# Your App

# Development Setup
1. Run `make setup` to install dependencies, generate .env file, create SQLite database, apply migrations and etc.
2. Run `make npm` to install npm and compile JS/CSS files.
3. Run `make run` to launch web server (http://localhost:8000).
# Heroku Setup
1. Add `php` and `nodejs` builpacks.
2. Add Heroku Postgres addon.
3. Set all necessary `.env` keys. Set `NPM_CONFIG_PRODUCTION` as `false`.

## If you want users to confirm their emails then in `RegisterController's` `create` method remove `email_verified_at` string. 
