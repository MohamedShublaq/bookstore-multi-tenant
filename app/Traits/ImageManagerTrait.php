<?php

namespace App\Traits;

trait ImageManagerTrait
{
    public function storeImage($request, $model, $column)
    {
        $filename = time() . '_' . $request->file($column)->getClientOriginalName();
        $request->file($column)->move(public_path('images'), $filename);
        $model->update([
            $column => 'images/' . $filename
        ]);
    }

    public function deleteImage($model, $column)
    {
        if ($model->$column && file_exists(public_path($model->$column))) {
            unlink(public_path($model->$column));
        }
    }
}
