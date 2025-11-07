<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait DataTableTrait
{
    public function applyDataTable(Request $request, $query, array $searchable = [], array $relationSearchable = [])
    {
        $model = $query->getModel();
        $table = $model->getTable();

        $recordsTotal = $query->count();

        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search, $searchable, $relationSearchable, $table) {
                foreach ($searchable as $column) {
                    $q->orWhere("{$table}.{$column}", 'LIKE', "%{$search}%");
                }

                foreach ($relationSearchable as $relation => $columns) {
                    $q->orWhereHas($relation, function ($relQ) use ($columns, $search) {
                        foreach ($columns as $column) {
                            $relQ->where($column, 'LIKE', "%{$search}%");
                        }
                    });
                }
            });
        }

        $recordsFiltered = $query->count();

        if ($request->has('order')) {
            $order = $request->input('order')[0];
            $columnIndex = $order['column'];
            $dir = $order['dir'];
            $columnName = $request->input("columns.{$columnIndex}.data");

            if (strpos($columnName, '.') !== false) {
                [$relation, $relationColumn] = explode('.', $columnName);

                $relatedModel = $model->{$relation}()->getRelated();
                $relatedTable = $relatedModel->getTable();
                $foreignKey = $model->{$relation}()->getForeignKeyName();
                $ownerKey = $model->{$relation}()->getOwnerKeyName();

                $query->leftJoin($relatedTable, "{$table}.{$foreignKey}", '=', "{$relatedTable}.{$ownerKey}")
                    ->orderBy("{$relatedTable}.{$relationColumn}", $dir)
                    ->select("{$table}.*");
            } else {
                $query->orderBy("{$table}.{$columnName}", $dir);
            }
        }

        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $data = $query->skip($start)->take($length)->get();

        return [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ];
    }
}
