<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait ControllerTrait
{
    /**
     * Apply search functionality to a query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $fields
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applySearch($query, Request $request, array $fields)
    {
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $conditions = [];
            foreach ($fields as $field) {
                $conditions[] = [$field, 'like', '%' . $search . '%'];
            }
            return $query->where(function ($q) use ($conditions) {
                foreach ($conditions as [$column, $operator, $value]) {
                    $q->orWhere($column, $operator, $value);
                }
            });
        }
        return $query;
    }

    /**
     * Paginate results with query string preservation
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginateResults($query, $perPage = 10)
    {
        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Check if current user is admin
     *
     * @return bool
     */
    protected function isAdmin()
    {
        return Auth::user()->isAdmin();
    }
}