<?php

namespace Tests\Feature;

use App\Mail\ReponseAvisMail;
use App\Models\Avis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReponseAvisMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_reponse_avis_mail_contains_correct_information(): void
    {
        $avis = new Avis([
            'note' => 5,
            'commentaire' => 'Très bonne voiture',
        ]);

        $mail = new ReponseAvisMail($avis);

        $this->assertSame($avis, $mail->avis);

        $this->assertSame(
            'Reponse  a votre Avis ',
            $mail->envelope()->subject
        );

        $this->assertSame(
            'emails.reponse_avis',
            $mail->content()->view
        );
    }
}