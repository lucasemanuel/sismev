<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">SISMEV</h1>
    <br>
</p>

CONFIGURATION
-------------

### Database

## Create the database 'sismec'

``` CREATE DATABASE sismec; ```

## Create the user 'dev'

``` CREATE USER 'sismec'@'localhost' IDENTIFIED BY 'sismec' ```

## Grant to dev user all permission to the dev database

``` GRANT ALL PRIVILEGES ON sismec.* TO 'sismec'@'localhost'; ```
