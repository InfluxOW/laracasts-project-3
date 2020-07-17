![PHP CI](https://github.com/InfluxOW/laracasts-project-3/workflows/PHP%20CI/badge.svg)
[![Maintainability](https://api.codeclimate.com/v1/badges/a9017db863a4cdeec91f/maintainability)](https://codeclimate.com/github/InfluxOW/laracasts-project-3/maintainability)
[![codecov](https://codecov.io/gh/InfluxOW/laracasts-project-3/branch/master/graph/badge.svg)](https://codecov.io/gh/InfluxOW/laracasts-project-3)


# Forum
https://influx-forum.herokuapp.com/

# Development Setup
1. Run `make setup` to install dependencies, generate .env file, create SQLite database, apply migrations and etc.
2. Run `make npm` to install npm and compile JS/CSS files.
3. Run `make start` to launch a local server using Heroku.
# Heroku Setup
1. Add `php` and `nodejs` buildpacks.
2. Add Heroku Postgres and Heroku Redis addons.
3. Set all `.env` keys. Set `NPM_CONFIG_PRODUCTION` as `false`.
# Additional Information
If you want users to confirm their emails then in `RegisterController's` `create` method remove `email_verified_at` string. 
