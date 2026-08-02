

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réponse à votre avis</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 0 15px rgba(0,0,0,.08);">

                    <!-- Header -->

                    <tr>
                        <td align="center"
                            style="background:#0d6efd;color:white;padding:30px;">
                            <h1 style="margin:0;">
                                🚗 Car Rental
                            </h1>

                            <p style="margin-top:10px;">
                                Merci pour votre confiance
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->

                    <tr>
                        <td style="padding:35px;">

                            <h2 style="color:#333;">
                                Bonjour {{ $avis->user->name }},
                            </h2>

                            <p style="font-size:16px;color:#555;line-height:28px;">

                                Nous vous remercions d'avoir partagé votre expérience
                                avec notre agence.

                            </p>

                            <hr>

                            <h3 style="color:#0d6efd;">
                                ⭐ Votre avis
                            </h3>

                            <p>

                                <strong>Note :</strong>

                                {{ $avis->note }}/5 ⭐

                            </p>

                            <p>

                                <strong>Commentaire :</strong>

                            </p>

                            <div style="
                                background:#f8f9fa;
                                border-left:5px solid #0d6efd;
                                padding:15px;
                                border-radius:8px;
                                color:#555;
                            ">

                                {{ $avis->commentaire }}

                            </div>

                            <br>

                            <h3 style="color:#198754;">
                                💬 Réponse de notre agence
                            </h3>

                            <div style="
                                background:#eafaf1;
                                border-left:5px solid #198754;
                                padding:15px;
                                border-radius:8px;
                                color:#333;
                            ">

                                {{ $avis->reponse_admin }}

                            </div>

                            <br><br>

                            <div style="text-align:center;">

                                <a href="http://127.0.0.1:8000"
                                    style="
                                        background:#0d6efd;
                                        color:white;
                                        text-decoration:none;
                                        padding:15px 35px;
                                        border-radius:8px;
                                        font-size:17px;
                                        display:inline-block;
                                    ">

                                    🚗 Voir mes réservations

                                </a>

                            </div>

                            <br>

                            <p style="color:#666;line-height:26px;">

                                Toute l'équipe <strong>Car Rental</strong>
                                vous remercie pour votre confiance.

                                Nous espérons vous accueillir très prochainement.

                            </p>

                            <br>

                            <p style="color:#888;">

                                Cordialement,<br>

                                <strong>L'équipe Car Rental</strong>

                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->

                    <tr>
                        <td align="center"
                            style="background:#f8f9fa;padding:20px;color:#777;font-size:13px;">

                            © {{ date('Y') }} Car Rental

                            <br>

                            Casablanca • Maroc

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>