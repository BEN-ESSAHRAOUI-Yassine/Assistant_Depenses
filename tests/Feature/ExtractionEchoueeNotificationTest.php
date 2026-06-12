<?php

use App\Models\Recu;
use App\Models\User;
use App\Notifications\ExtractionEchouee;
use Illuminate\Support\Facades\Notification;

it('sends notification with correct subject and content', function () {
    $user = User::factory()->create();
    $recu = Recu::factory()->create([
        'user_id' => $user->id,
        'title' => 'Facture 123',
        'error_message' => 'API indisponible',
    ]);

    $notification = new ExtractionEchouee($recu, 'API indisponible');

    $mail = $notification->toMail($user);

    expect($mail->subject)->toBe('Échec de l\'extraction : Facture 123');
    expect($mail->introLines)->toContain('L\'extraction des dépenses a échoué pour le reçu suivant :');
    expect($mail->greeting)->toBe('Bonjour,');
});

it('sends notification via mail channel', function () {
    $notification = new ExtractionEchouee(new Recu, 'error');

    expect($notification->via(new User))->toBe(['mail']);
});

it('sends notification on job failure via Queue::failing', function () {
    Notification::fake();

    $user = User::factory()->create();
    $recu = Recu::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test receipt',
        'error_message' => 'Something went wrong',
    ]);

    $recu->user->notify(new ExtractionEchouee($recu, 'Something went wrong'));

    Notification::assertSentTo(
        $user,
        ExtractionEchouee::class,
        function ($notification) use ($recu) {
            return $notification->recu->id === $recu->id
                && $notification->errorMessage === 'Something went wrong';
        }
    );
});
