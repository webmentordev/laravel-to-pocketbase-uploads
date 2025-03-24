<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class PocketbaseController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'file' => 'required|max:2024|image'
            ]);

            $url = config('app.pocketbase');
            $collection = 'posts';

            $file = $request->file('file');

            $response = Http::attach(
                'file',
                file_get_contents($file->getRealPath()),
                rand(9, 999) . '_' . $file->getClientOriginalName()
            )->post($url . '/api/collections/' . $collection . '/records', [
                'name' => $request->name
            ]);

            if ($response->successful()) {
                $record = $response->json();
                $fileURL = '/api/files/' . $record['collectionId'] . '/' . $record['id'] . '/' . $record['file'];
                return response()->json([
                    'file' => $url . $fileURL
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Failed to upload to PocketBase',
                    'details' => $response->json() ?: $response->body(),
                    'status' => $response->status()
                ], $response->status());
            }
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
