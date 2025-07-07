<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommonService
{
    public function uploadImage($image, string $folder = 'uploads'): string
    {
        $extension = $image->getClientOriginalExtension();
        $imagename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $imagename = str_replace(' ', '_', $imagename);
        $imagename = substr($imagename, 0, 20);
        $uniqueName = uniqid($imagename . '_') . '.' . $extension;

        $path = $image->storeAs("backend/{$folder}", $uniqueName, 'public');
        return Storage::url($path);
    }

    public function toggleStatus(Request $request, $modelClass)
    {
        try {
            $model = $modelClass::findOrFail($request->id);
            $model->status = $request->status;
            $model->save();

            return response()->json([
                'type' => 'success',
                'message' => class_basename($modelClass) . ' ' . ($request->status == 1
                    ? trans('admin_fields.active_status')
                    : trans('admin_fields.inactive_status')),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function jsonResponse($data = null, string $message = '', int $code = 200)
    {
        return response()->json([
            'type' => $code >= 400 ? 'error' : 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
