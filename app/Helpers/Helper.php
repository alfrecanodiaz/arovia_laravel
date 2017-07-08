<?php
namespace App\Helpers;


class Helper
{
    public static function getTableButtons($edit, $delete)
    {
        return "<div class='btn-group'>
        <a href='". $edit." ' class='btn btn-default btn-flat'>
            <i class='glyphicon glyphicon-pencil'></i>
        </a>
        <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='". $delete ."'>
            <i class='glyphicon glyphicon-trash'></i>
        </button>
        </div>";
    }

    public static function withHref($route, $id, $attribute)
    {
        $edit = $route;
        $editRoute = route( $edit, [$id]);
        $td = "<a href='".$editRoute." '>".$attribute."</a>";
        return $td;
    }
}