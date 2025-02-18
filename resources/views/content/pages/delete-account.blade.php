<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Suppression du compte</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('logo.png') }}" rel="icon">
    <link href="{{ asset('logo.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('pages/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('pages/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('pages/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('pages/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('pages/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('pages/assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">
    <main class="main">
        <section id="features" class="features" lang="fr">
            <div class="container">

                <div class="section-title">
                    <h2>Supprimer votre compte Agropole</h2>
                </div>

                <div class="row">
                    <p>
                        Agropole s'engage à protéger vos données personnelles conformément à notre politique de
                        confidentialité. Voici la procédure pour supprimer définitivement votre compte de notre base de
                        données via l'application.
                        <br><br>
                        <strong>Important :</strong>
                    </p>
                    <ul>
                        <li>
                            <p>La suppression de votre compte entraînera l'annulation immédiate de toutes les commandes
                                en cours, sans possibilité de restauration.</p>
                        </li>
                        <li>
                            <p>Vos informations seront complètement supprimées après 90 jours.</p>
                        </li>
                        <li>
                            <p>Si vous vous connectez avant la fin des 90 jours, seule la suppression sera annulée, mais
                                pas l'annulation des commandes.</p>
                        </li>
                        <li>
                            <p>Après 90 jours, toute nouvelle connexion créera un nouveau compte.</p>
                        </li>
                    </ul>
                    <br>
                    <p>
                        Pour supprimer votre compte, suivez ces étapes :
                    </p>
                </div>

                <div class="row justify-content-center">
                    <div class="image col-xl-5 d-flex align-items-center justify-content-center order-1 order-lg-2"
                        data-aos-delay="100">
                        <img src="{{ asset('pages/assets/img/1.jpg') }}" class="img-fluid" alt="Page d'accueil">
                    </div>
                </div>
                <div style="margin-top: 30px;"></div>

                <div class="row justify-content-center">
                    <div class="image col-xl-5 d-flex align-items-center justify-content-center order-1 order-lg-2"
                        data-aos-delay="100">
                        <img src="{{ asset('pages/assets/img/2.jpg') }}" class="img-fluid" alt="Page de profil">
                    </div>
                </div>
                <div style="margin-top: 30px;"></div>

                <div class="row justify-content-center">
                    <div class="image col-xl-5 d-flex align-items-center justify-content-center order-1 order-lg-2"
                        data-aos-delay="100">
                        <img src="{{ asset('pages/assets/img/3.jpg') }}" class="img-fluid"
                            alt="Confirmation de suppression">
                    </div>
                </div>
                <div style="margin-top: 30px;"></div>

                <div class="row">
                    <p>
                        Une fois que vous aurez cliqué sur "Supprimer", le processus de suppression commencera
                        immédiatement.
                        <br><br>
                        <strong>Rappel :</strong> Toutes vos commandes en cours seront annulées immédiatement. Cette
                        action est irréversible.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer dark-background">
        <div class="container">
            <img src="{{ asset('agropole-no-bg.png') }}" alt="logo" class="footerLogo">

            <div class="social-links d-flex justify-content-center">
                <a href=""><i class="bi bi-twitter-x"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
            <div class="container">
                <div class="copyright">
                    <span>Copyright</span> <strong>Agropole</strong> <span>Tous droits réservés</span>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
