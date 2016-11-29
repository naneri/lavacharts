<?php

namespace Khill\Lavacharts\DataTables\Cells;

use Carbon\Carbon;

/**
 * DateCell Class
 *
 * Wrapper object to implement JsonSerializable on the Carbon object.
 *
 * @package   Khill\Lavacharts\DataTables\Cells
 * @since     3.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2016, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT      MIT
 */
class DateCell extends Cell
{
    /**
     * Creates a new DateCell object from a Carbon object.
     *
     * @param  \Carbon\Carbon $carbon
     * @param  string         $format
     * @param  array          $options
     */
    public function __construct(Carbon $carbon = null, $format = '', array $options = [])
    {
        parent::__construct($carbon, $format, $options);
    }

    /**
     * Parses a datetime string with or without a datetime format.
     *
     * Uses Carbon to create the values for the DateCell.
     *
     *
     * @param  string $dateTimeString
     * @param  string $dateTimeFormat
     * @return \Khill\Lavacharts\DataTables\Cells\Cell
     */
    public static function parseString($dateTimeString, $dateTimeFormat = '')
    {
        if ($dateTimeString === null) {
            return new DateCell();
        }

        if (empty($dateTimeFormat) === true) {
            $carbon = Carbon::parse($dateTimeString);
        } else {
            $carbon = Carbon::createFromFormat($dateTimeFormat, $dateTimeString);
        }

        return new DateCell($carbon);
    }

    /**
     * Custom string output of the Carbon date.
     *
     * @return string
     */
    public function __toString()
    {
        if ($this->v === null) {
            return 'null';
        }

        return sprintf(
            'Date(%d,%d,%d,%d,%d,%d)',
            isset($this->v->year)   ? $this->v->year      : 'null',
            isset($this->v->month)  ? $this->v->month - 1 : 'null', //silly javascript
            isset($this->v->day)    ? $this->v->day       : 'null',
            isset($this->v->hour)   ? $this->v->hour      : 'null',
            isset($this->v->minute) ? $this->v->minute    : 'null',
            isset($this->v->second) ? $this->v->second    : 'null'
        );
    }

    /**
     * Custom serialization of the Carbon date.
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return ['v' => (string) $this];
    }
}
