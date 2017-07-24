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

    public static function getLatLong($the_geom)
    {
        $geom = json_decode($the_geom);
        $coordinates = !empty($geom->coordinates) ? $geom->coordinates : null;
        $points = new \stdClass();
        $points->lon = $coordinates != null ? $coordinates[0] : '';
        $points->lat = $coordinates != null ? $coordinates[1] : '';
        return $points;
    }

    public static function formatPolygon($the_geom)
    {
        if ($the_geom == null)
            return false;

        $crs = array(
            "type" => "name",
            "properties" => array("name" => "EPSG:4326")
        );
        $geom = json_decode($the_geom);
        $geom->crs = $crs;
        return json_encode($geom);
    }
}