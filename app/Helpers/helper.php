<?php
/**
 * Created by PhpStorm.
 * User: Victor Souto
 * Date: 04/07/2016
 * Time: 15:10
 */



function getColumn( $column )
{

    switch ($column) {
        case 'gss':
            return (new \Nayjest\Grids\FieldConfig())
                ->setName('gss')
                ->setLabel('GSS')
                ->setSortable(true)
                ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {
                    if (!$val)
                        return '';

                    return '<span class="edit-gss" data-call-id="' . $row->getSrc()->id . '">' . $val . '</span>';
                });
            break;
        default:
            break;
    }
}


/**
 * Get Filter with LIKE
 *
 * @param $name
 * @return FilterConfig
 */
function getFilterILike($name, $initial = false) {

    $filter = new \Nayjest\Grids\FilterConfig();
    $filter->setName($name);
    $filter->setFilteringFunc(function($value, $dataProvider) use ($name, $initial) {
        if(!is_null($value) && !empty($value)) {
            $value = addcslashes($value, '_%\\');

            // Requested for initial letter only?
            $value = $initial? "$value%" : "%$value%";

            $dataProvider->filter($name, "like", $value);
        }
    });
    return $filter;
}