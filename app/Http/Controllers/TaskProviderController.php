<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class TaskProviderController extends Controller
{
    /**
     * Task Provider
     * @param int|null $id
     * @return Response
     */
    public function run(int $id = null) : Response
    {
        $path = base_path("storage/json/mock/mock{$id}.json");
        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            //json hatalıysa
            if (json_last_error() !== JSON_ERROR_NONE) {
                return new Response([
                    'success' => false,
                    'message' => 'Json dosyası içeriği hatalı'
                ], 204);
            } else {
                return new Response([
                    'success' => true,
                    'name' => "Task {$id}",
                    'data' => $data
                ]);
            }
        } else {
            return new Response([
                'success' => false
            ], 404);
        }
    }
}
