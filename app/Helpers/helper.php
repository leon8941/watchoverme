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

function getCategoryColor($category) {

    switch ($category->slug) {
        case 'humor':
            return 'label-danger';
            break;
        case 'noticias':
            return 'label-inverse';
            break;
        case 'blue-post':
            return 'label-primary';
            break;
        case 'cenario-nacional':
            return 'label-warning';
            break;
        case 'campeonatos':
        case 'eventos':
            return 'label-default';
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

function isActive($page) {

    if (\Illuminate\Support\Facades\Route::getCurrentRoute() !== null )
        if (\Illuminate\Support\Facades\Route::getCurrentRoute()->getPath() == $page )
            return 'active';
}

function getUserImage($avatar = false)
{
    $random_images = [
        'assets/img/user-1.jpg',
        'assets/img/user-2.jpg',
        'assets/img/user-3.jpg',
        'assets/img/user-4.jpg',
        'assets/img/user-5.jpg',
        'assets/img/user-6.jpg',
        'assets/img/user-7.jpg',
        'assets/img/user-8.jpg',
    ];

    if (!$avatar)
        return $random_images[rand(0,7)];

    $full_dir = \App\User::$avatar_dir . $avatar;

    if (\Illuminate\Support\Facades\File::exists($full_dir))
        return $full_dir;
}

function getRegion($from) {

    return isset(\App\Event::$regions[$from])? \App\Event::$regions[$from] : '';
}

function getUserAvatar($avatar) {

    if (!$avatar)
        return asset('assets/img/profile-cover.jpg');

    $full_dir = \App\User::$avatar_dir . $avatar;

    if (\Illuminate\Support\Facades\File::exists($full_dir))
        return asset($full_dir);
}

function getTeamAvatar($avatar = false) {

    if (!$avatar)
        return asset('img/team.jpg');

    $full_dir = \App\Team::$avatar_dir . $avatar;

    if (\Illuminate\Support\Facades\File::exists($full_dir))
        return asset($full_dir);
}

function getPostImage($image = false, $thumb = false) {

    if (!$image)
        return asset('img/team.jpg');

    if ($thumb)
        $full_dir = \App\Posts::$image_dir . '/thumb/' . $image;
    else
        $full_dir = \App\Posts::$image_dir . $image;

    if (\Illuminate\Support\Facades\File::exists($full_dir))
        return asset($full_dir);

}