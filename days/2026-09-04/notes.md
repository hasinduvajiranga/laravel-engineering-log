# Eloquent Spatial Queries

Eloquent spatial queries allow you to query your database using spatial data types, such as points, lines, and polygons.

## Defining the Spatial Column

To use Eloquent spatial queries, you need to define a spatial column in your model. This column should be of type `geometry` or `point`.

```php
protected $spatialColumn = 'geometry';
```

## Creating a Spatial Query Method

You can create a method in your model that performs an Eloquent spatial query. For example, let's say we want to find all users within a certain distance of a given point:

```php
public function byLocation($lat, $lng)
{
    return self::whereRaw("ST_DWithin(geometry, ST_GeomFromText('POINT({$lng} {$lat})'), 1000)") ->get();
}
```

In this example, we're using the `ST_DWithin` function to check if the user's geometry is within a distance of 1000 meters from the given point. The result will be an array of users that meet this condition.

## Spatial Functionality

Eloquent spatial queries provide several functions for working with spatial data:

*   `ST_DWithin`: Checks if two geometries are within a certain distance.
*   `ST_Intersects`: Checks if two geometries intersect.
*   `ST_Contains`: Checks if one geometry contains another.
*   `ST_ContainsPoint`: Checks if one geometry contains a point.

Note: The exact syntax for these functions may vary depending on the specific spatial database you're using.