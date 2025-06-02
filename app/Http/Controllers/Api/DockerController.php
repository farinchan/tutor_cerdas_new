<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DockerController extends Controller
{
    public function restart(Request $request)
    {
        $container_name = env("CHATBOT_CONTAINER_NAME");

        // Jalankan perintah restart docker
        $output = shell_exec("docker restart $container_name 2>&1");

        return response()->json([
            'status' => 'success',
            'message' => "Container $container_name has been restarted successfully.",
            'output' => $output
        ]);
    }

}
