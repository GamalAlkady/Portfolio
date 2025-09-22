<style>
    /* Styles for the language selector container */
    .language-selector-container {
        /* position: fixed;
        top: .8rem;
        right: 2rem; */
        z-index: 1000;
        font-family: 'Poppins', 'Tajawal', sans-serif;
    }

    /* The main button to toggle the dropdown */
    .language-toggle-button {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background-color: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 9999px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .language-toggle-button:hover {
        background-color: #f9fafb;
        border-color: #9ca3af;
    }

    .language-toggle-button img {
        width: 24px;
        height: 24px;
        margin-right: 0.5rem;
        border-radius: 50%;
    }

    .language-toggle-button span {
        font-weight: 600;
        color: #374151;
        margin-right: 0.5rem;
    }

    .language-toggle-button i {
        color: #9ca3af;
        transition: transform 0.3s ease;
    }

    .language-toggle-button.open i {
        transform: rotate(180deg);
    }

    /* The dropdown menu */
    .language-dropdown {
        position: absolute;
        top: 100%;
        /* right: 0; */
        margin-top: 0.5rem;
        background-color: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        /* padding: 0.5rem 0; */
        list-style: none;
        min-width: 130px;
        opacity: 0;
        display: none;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }

    .language-dropdown.show {
        opacity: 1;
        display: block;
        transform: translateY(0);
    }

    .language-dropdown li a {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .language-dropdown li a:hover {
        background-color: #f3f4f6;
    }

    .language-dropdown li a.active {
        background-color: #e5e7eb;
        font-weight: 600;
    }

    .language-dropdown li a img {
        width: 20px;
        height: 20px;
        margin-inline-end: 0.75rem;
        border-radius: 50%;
    }

    /* RTL adjustments for Arabic */
    [lang="ar"] {
        font-family: 'Tajawal', sans-serif;
        direction: rtl;
    }

    [lang="ar"] .language-selector-container {
        right: auto;
        left: 2rem;
    }

    [lang="ar"] .language-toggle-button {
        flex-direction: row-reverse;
    }

    [lang="ar"] .language-toggle-button img {
        margin-left: 0.5rem;
        margin-right: 0;
    }

    [lang="ar"] .language-toggle-button span {
        margin-left: 0.5rem;
        margin-right: 0;
    }




    .content-container {
        max-width: 600px;
        margin: 2rem;
        padding: 2.5rem;
        background-color: #ffffff;
        border-radius: 1.5rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.5s ease-in-out;
    }

    .user-name {
        display: inline-block;
    }

    @media (max-width: 768px) {
        .user-name {
            display: none;
        }

        .language-selector-container {
            top: 0.75rem;
            right: 0.75rem;
        }

        .language-dropdown {
            position: relative;
            min-width: auto;
            background: transparent;
        }

        .language-dropdown li a {
            padding: 0;
        }

        [lang="ar"] .language-selector-container {
            right: auto;
            left: 0.75rem;
        }

        .language-toggle-button {
            display: flex;
            justify-content: space-between;
            padding: 0;
            border-radius: 0;
            background: transparent;
        }

        .language-toggle-button img,
        .language-dropdown li a img {
            width: 15px;
            height: 15px;
        }

        .language-toggle-button span {
            font-size: 0.875rem;
        }

        .content-container {
            padding: 1.5rem;
            margin: 1rem;
        }
    }

    .language-switcher .flag-icon {
        width: 25px;
        height: 25px;
        background-size: cover;
        display: inline-block;
        border-radius: 50%;

    }

    .flag-icon-gb {
        background-image: url('https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg');
    }

    .flag-icon-sa {
        background-image: url('https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/sa.svg');
    }
</style>
<header class=" navbar-light">

    <div id="menu" class="fas fa-bars"></div>
    <a href="<?= isset($routeName) ? route($routeName) : '' ?>#" class="logo">
        <img src="<?= assets(setting('logo_' . theme()), 'images/logo.svg') ?>" alt="V2 Logo" style="height: auto; width: 45px; margin-inline-end: 8px; vertical-align: middle;">
        <span class="user-name"><?= setting('name_' . locale()) ?></span>
    </a>
    <nav class="navbar navbar-light">
        <ul>
            <li><a class="active" href="#home"><?= __('home') ?></a></li>
            <li><a href="#about"><?= __('about_me') ?></a></li>
            <?php if (!empty(setting('education_' . locale()))): ?><li><a href="#education"><?= __('education') ?></a></li><?php endif; ?>
            <?php if (!empty(setting('experience_' . locale()))): ?><li><a href="#experience"><?= __('experience') ?></a></li><?php endif; ?>
            <?php if (!empty($featuredCertificates)): ?><li><a href="#certificate"><?= __('certificates') ?></a></li><?php endif; ?>
            <?php if (count($skills) > 0): ?> <li><a href="#skill"><?= __('skills') ?></a></li><?php endif; ?>
            <li><a href="#contact"><?= __('contact') ?></a></li>
            <li>
                <?php
                if (locale() === 'ar') {
                    $currentLang = 'ar';
                    $currentFlag = 'sa';
                    $switchToLang = 'en';
                    $switchToFlag = 'us';
                    $switchToLangName = __('english');
                } else {
                    $currentLang = 'en';
                    $currentFlag = 'us';
                    $switchToLang = 'ar';
                    $switchToFlag = 'sa';
                    $switchToLangName = __('arabic');
                }
                ?>

                <div class="language-selector-container">
                    <div class="language-toggle-button">
                        <!-- Default language display here. Updated by JS -->
                        <img id="selected-flag" src="https://flagcdn.com/w20/<?= $currentFlag ?>.png" alt="<?= __($currentLang) ?> flag">
                        <span id="selected-lang-code"><?= strtoupper($currentLang) ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <ul class="language-dropdown">
                        <li>
                            <a href="<?= route('language.switch', ['locale' => $switchToLang, 'type' => 'user']) ?>"
                                title="<?= $switchToLangName ?>" data-lang="<?= $switchToLang ?>" data-flag="<?= $switchToFlag ?>">
                                <img src="https://flagcdn.com/w20/<?= $switchToFlag ?>.png" alt="<?= $switchToLangName ?> flag"> <?= $switchToLangName ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </nav>


</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const html = document.documentElement;
        const langSelector = document.querySelector('.language-selector-container');
        const toggleButton = langSelector.querySelector('.language-toggle-button');
        const dropdown = langSelector.querySelector('.language-dropdown');
        const langLinks = dropdown.querySelectorAll('a');
        const selectedLangCode = document.getElementById('selected-lang-code');
        const selectedFlag = document.getElementById('selected-flag');


        // Function to update the language and content
        function updateLanguage(lang, flag) {
            html.setAttribute('lang', lang);
            selectedLangCode.textContent = lang.toUpperCase();
            selectedFlag.src = `https://flagcdn.com/w20/${flag}.png`;
            selectedFlag.alt = `${lang} flag`;

            langLinks.forEach(link => {
                link.classList.remove('active');
                if (link.dataset.lang === lang) {
                    link.classList.add('active');
                }
            });
        }

        // Toggle dropdown visibility
        toggleButton.addEventListener('click', () => {
            dropdown.classList.toggle('show');
            toggleButton.classList.toggle('open');
        });

        // Handle language link clicks
        // langLinks.forEach(link => {
        //     link.addEventListener('click', (e) => {
        //         e.preventDefault();
        //         const lang = link.dataset.lang;
        //         const flag = link.dataset.flag;
        //         updateLanguage(lang, flag);
        //         dropdown.classList.remove('show');
        //         toggleButton.classList.remove('open');
        //     });
        // });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!langSelector.contains(e.target)) {
                dropdown.classList.remove('show');
                toggleButton.classList.remove('open');
            }
        });

        // Set initial language and display based on the HTML lang attribute
        // const initialLang = html.getAttribute('lang');
        // const initialFlag = document.querySelector(`a[data-lang="${initialLang}"]`).dataset.flag;
        // updateLanguage(initialLang, initialFlag);
    });
</script>