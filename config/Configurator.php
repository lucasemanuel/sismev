<?php

namespace app\config;

use Yii;
use yii\base\UserException;

class Configurator
{
    /**
     * Initiate environment
     */
    public static function init( bool $console = false )
    {
        require_once( __DIR__ . '/../vendor/autoload.php' );

        $dotenv = \Dotenv\Dotenv::createImmutable( dirname( __DIR__ ) );
        $dotenv->safeLoad();

        self::setEnvironment( $console );

        require_once( __DIR__ . '/../vendor/yiisoft/yii2/Yii.php' );
    }

    /**
     * Load environment type from dot env file, if exists
     * If not found default framework settings will apply (ENV=prod, DEBUG=false)
     */
    protected static function setEnvironment( $console )
    {
        $env            = (object) [];
        $is_not_defined = array();
        $env_required   = array(
            'ENVIRONMENT',
            'DB_HOST',
            'DB_NAME',
            'DB_PORT',
            'DB_USER',
            'DB_PASS',
            'DEBUG',
        );

        foreach ( $env_required as $key ) {
            if ( isset( $_ENV[ $key ] ) )
                $env->{$key} = $_ENV[ $key ];
            else
                $is_not_defined[] = $key;
        }

        if ( ! empty( $is_not_defined ) ) {
            require_once( __DIR__ . '/../vendor/yiisoft/yii2/Yii.php' );

            $config = require_once __DIR__ . '/web.php';

            new \yii\web\Application( $config );

            $message = Yii::t( 'app', 'The .env file is not configured correctly, {count, plural, one{key is} other{keys are}} missing: {keys}', [
                'count' => count( $is_not_defined ),
                'keys'  => join( ', ', $is_not_defined )
            ], Yii::$app->language );

            if ( $console ) exit( $message );

            throw new UserException( $message );
        }

        switch (strtolower( $env->ENVIRONMENT )) {
            case 'prod':
            case 'production':
                defined( 'YII_ENV' ) || define( 'YII_ENV', 'prod' );
                defined( 'YII_DEBUG' ) || define( 'YII_DEBUG', false );
                break;
            case 'test':
            case 'testing':
            case 'staging':
                defined( 'YII_ENV' ) || define( 'YII_ENV', 'test' );
                break;
            case 'dev':
            case 'devel':
            case 'development':
                defined( 'YII_ENV' ) || define( 'YII_ENV', 'dev' );
                break;
        }

        defined( 'YII_DEBUG' ) || define( 'YII_DEBUG', filter_var( $env->DEBUG, FILTER_VALIDATE_BOOL ) );
    }
}