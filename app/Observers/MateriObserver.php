<?php

namespace App\Observers;

use App\Models\Materi;

class MateriObserver
{
    /**
     * Handle the Materi "created" event.
     */
    public function created(Materi $materi): void
    {

        $container_name = env("CHATBOT_CONTAINER_NAME");

        // Jalankan perintah restart docker
        $output = shell_exec("docker restart $container_name 2>&1");
    }

    /**
     * Handle the Materi "updated" event.
     */
    public function updated(Materi $materi): void
    {
        //
    }

    /**
     * Handle the Materi "deleted" event.
     */
    public function deleted(Materi $materi): void
    {
        //
    }

    /**
     * Handle the Materi "restored" event.
     */
    public function restored(Materi $materi): void
    {
        //
    }

    /**
     * Handle the Materi "force deleted" event.
     */
    public function forceDeleted(Materi $materi): void
    {
        //
    }
}
