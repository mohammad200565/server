<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

trait HasRelationsShip
{
    public function loadRelations(Request $request, $modelOrQuery, array $allowedRelations = [])
    {
        $relations = $request->query('with', []);
        if (is_string($relations)) {
            $relations = explode(',', $relations);
        }
        $relations = array_intersect($relations, $allowedRelations);
        if (!empty($relations)) {
            if ($modelOrQuery instanceof Builder) {
                $modelOrQuery->with($relations);
            } else {
                $modelOrQuery->load($relations);
            }
        }
        return $modelOrQuery;
    }
}
