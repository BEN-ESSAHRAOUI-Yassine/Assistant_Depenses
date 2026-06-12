<?php

namespace App\Providers;

use App\Jobs\ExtraireDepensesDuRecu;
use App\Notifications\ExtractionEchouee;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Queue::failing(function (JobFailed $event) {
            if ($event->job->resolveName() !== ExtraireDepensesDuRecu::class) {
                return;
            }

            $command = unserialize($event->job->payload()['data']['command']);

            if (! isset($command->recu)) {
                return;
            }

            $recu = $command->recu->fresh();

            if ($recu && $recu->user) {
                try {
                    Notification::send(
                        $recu->user,
                        new ExtractionEchouee($recu, $recu->error_message ?? 'Erreur inconnue')
                    );
                } catch (\Throwable) {
                    // Silently fail if notification can't be sent
                }
            }
        });
    }
}
