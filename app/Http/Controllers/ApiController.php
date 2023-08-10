<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected $searchColumns = [];

    public function indexResponse(Request $request, $query)
    {
        $page = $request->get('page', 1);
        $itemsPerPage = $request->get('pageSize', 30);
        $search = $request->get('search');
        $order = $request->get('order', []);
        $filter = $request->get('filter', []);

        // Apply search
        if ($search && count($this->searchColumns) > 0) {
            foreach ($this->searchColumns as $column) {
                $query->orWhere($column, 'like', '%' . $search . '%');
            }
        }

        // Apply filters
        foreach ($filter as $field => $value) {
            $query->where($field, $value);
        }

        // Apply ordering
        foreach ($order as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        // Apply pagination
        $items = $query->paginate($itemsPerPage, ['*'], 'page', $page);

        return response()->json([
            'member' => $items->items(),
            'totalItems' => $items->total(),
        ]);
    }
}

