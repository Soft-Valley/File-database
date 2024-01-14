<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

final class DataTypes
{

    const STRING       = 'string';

    const CHAR         = 'char';

    const VARCHAR      = 'varchar';

    const TEXT         = 'text';

    const INT          = 'int';

    const TINYINT      = 'tinyint';

    const SMALLINT     = 'smallint';

    const MEDIUMINT    = 'mediumint';

    const BIGINT       = 'bigint';

    const BINARY       = 'binary';

    const BOOLEAN      = 'boolean';

    const FLOAT        = 'float';

    const DOUBLE       = 'double';

    const ARRAY        = 'array';

    const NULL         = 'null';

    const UNKNOWN_TYPE = 'unknown type';

    const DATE         = 'date';

    const DATETIME     = 'datetime';

    const TIMESTAMP    = 'timestamp';

    const TIME         = 'time';

    const ENUM         = 'enum';

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isString($value)
    {
        return ( is_string($value) && strlen($value) <= 225 ) ? self::STRING : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isTinyInt($value)
    {
        return (is_int($value) && strlen((string)$value) <= 3) ? self::TINYINT : false;
    }

    /**
     * @param $value
     * @return bool
     */
    public static function isInt($value)
    {
        return is_int($value) ? self::INT : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isSmallInt($value)
    {
        return (is_int($value) && strlen((string)$value) <= 5) ? self::SMALLINT : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isMediumInt($value)
    {
        return (is_int($value) && strlen((string)$value) <= 8) ? self::MEDIUMINT : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isBigInt($value)
    {
        return (is_int($value) && strlen((string)$value) <= 20) ? self::BIGINT : false;
    }


    /**
     * @param mixed $value
     * @return bool
     */
    public static function isBoolean($value)
    {
        return is_bool($value) ? self::BOOLEAN : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isFloat($value)
    {
        return is_float($value) ? self::FLOAT : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isDouble($value)
    {
        return is_double($value) ? self::DOUBLE : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isArray($value)
    {
        return is_array($value) ? self::ARRAY : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isNull($value)
    {
        return is_null($value) ? self::NULL : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isChar($value)
    {
        return is_string($value) && strlen($value) === 1 ? self::CHAR : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isVarchar($value)
    {
        return is_string($value) && strlen($value) <= 255 ? self::VARCHAR : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isText($value)
    {
        return is_string($value) ? self::TEXT : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isBinary(mixed $value)
    {
        return isBinary($value) ? self::BINARY : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isDate($value)
    {
        return isDate($value) ? self::DATE : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isDateTime($value)
    {
        return isDate($value) ? self::DATETIME : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isTimestamp($value)
    {
        return isDate($value) ? self::TIMESTAMP : false;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function isTime($value)
    {
        return isDate($value) ? self::TIME : false;
    }
}