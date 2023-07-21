<?php

namespace app\components\validators;

use Yii;
use yii\validators\Validator;

class DocumentValidator extends Validator
{
    const MIN = 14;
    const MAX = 18;

    public function validateAttribute( $model, $attribute )
    {
        $document = preg_replace( '/\D/', '', $model->$attribute );

        $length = Yii::t( 'app', '{attribute} must contain between {min} and {max} characters.' );
        $invalid = Yii::t( 'app', '{attribute} is not a valid document.' );

        if ( strlen( $document ) !== 11 && 14 !== strlen( $document ) ) {
            $this->addError( $model, $attribute, $length, [ 'min' => self::MIN, 'max' => self::MAX ] );
        }
        else if ( ! self::validateDocument( $document ) ) {
            $this->addError( $model, $attribute, $invalid );
        }
    }

    public function validateDocument( $document )
    {
        // Remove special characters
        $document = preg_replace( '/[^0-9]/', '', $document );

        // Check CPF
        if ( strlen( $document ) === 11 ) {
            if ( preg_match( '/(\d)\1{10}/', $document ) ) {
                return false; // CPF with all digits the same is invalid
            }

            for ( $i = 9; $i < 11; $i++ ) {
                $sum = 0;
                for ( $j = 0; $j < $i; $j++ ) {
                    $sum += $document[ $j ] * ( ( $i + 1 ) - $j );
                }
                $rest = $sum % 11;
                if ( $rest < 2 ) {
                    $digit = 0;
                }
                else {
                    $digit = 11 - $rest;
                }
                if ( $document[ $i ] != $digit ) {
                    return false; // Invalid CPF
                }
            }

            return true; // Valid CPF
        }

        // Check CNPJ
        elseif ( strlen( $document ) === 14 ) {
            if ( preg_match( '/(\d)\1{13}/', $document ) ) {
                return false; // CNPJ with all digits the same is invalid
            }

            for ( $i = 0, $j = 5, $sum = 0; $i < 12; $i++ ) {
                $sum += $document[ $i ] * $j;
                $j   = ( $j === 2 ) ? 9 : $j - 1;
            }

            $rest = $sum % 11;
            if ( $document[ 12 ] != ( $rest < 2 ? 0 : 11 - $rest ) ) {
                return false; // Invalid CNPJ
            }

            for ( $i = 0, $j = 6, $sum = 0; $i < 13; $i++ ) {
                $sum += $document[ $i ] * $j;
                $j   = ( $j === 2 ) ? 9 : $j - 1;
            }

            $rest = $sum % 11;
            return $document[ 13 ] == ( $rest < 2 ? 0 : 11 - $rest ); // Valid CNPJ
        }

        return false; // Invalid size for CPF or CNPJ
    }
}