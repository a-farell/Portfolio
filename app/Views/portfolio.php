<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#090909">
    <title><?= esc($profile['Farel Anwar'] ?? 'Portofolio') ?> — Farel Anwar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/portfolio-reference.css') ?>">
</head>
<body>
<?php if ($profile === null): ?>
    <main class="setup-notice">
        <p class="eyebrow">PORTOFOLIO FAREL ANWAR</p>
        <h1>Data profil belum tersedia.</h1>
        <p>Atur koneksi database, lalu jalankan migrasi dan seeder sesuai petunjuk di README.</p>
    </main>
<?php else: ?>
    <?php
        $emailUrl = 'https://mail.google.com/mail/u/0/?view=cm&fs=1&to=' . rawurlencode($profile['email']);
        $skillGroups = [];
        foreach ($skills as $skill) {
            $skillGroups[$skill['category']][] = $skill;
        }
        $approachItems = [];
        foreach ($experiences as $item) {
            $approachItems[] = ['title' => $item['role'], 'label' => $item['organization']];
        }
        foreach ($education as $item) {
            $approachItems[] = ['title' => $item['degree'], 'label' => $item['institution']];
        }
        foreach ($achievements as $item) {
            $approachItems[] = ['title' => $item['title'], 'label' => $item['organization']];
        }
        $approachItems = array_slice($approachItems, 0, 3);
    ?>
    <header class="site-header" id="home">
        <a class="brand-mark" href="#home" aria-label="<?= esc($profile['full_name']) ?> — Beranda">
            <?= esc(strtoupper(substr($profile['full_name'], 0, 1))) ?>
        </a>
        <nav class="main-nav" aria-label="Navigasi utama">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#skills">Skills</a>
            <a href="#projects">Projects</a>
        </nav>
        <a class="header-cta" href="<?= esc($emailUrl, 'attr') ?>" target="_blank" rel="noopener noreferrer">Let's Talk <span aria-hidden="true">↗</span></a>
    </header>

    <main>
        <section class="hero page-width">
            <div class="hero-copy">
                <p class="hero-greeting">Halo, saya <?= esc($profile['full_name']) ?></p>
                <h1><?= esc($profile['role']) ?></h1>
                <p class="hero-intro"><?= esc($profile['tagline']) ?></p>
                <div class="hero-socials" aria-label="Tautan sosial">
                    <?php foreach ($socialLinks as $link): ?>
                        <a href="<?= esc($link['url'], 'attr') ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= esc($link['label'], 'attr') ?>">
                            <?php $socialLabel = strtolower($link['label']); ?>
                            <?php if (str_contains($socialLabel, 'github')): ?>
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill="currentColor" d="M12 .5a12 12 0 0 0-3.79 23.39c.6.11.82-.26.82-.58v-2.23c-3.34.73-4.04-1.42-4.04-1.42-.55-1.39-1.33-1.76-1.33-1.76-1.09-.75.08-.74.08-.74 1.2.08 1.83 1.23 1.83 1.23 1.07 1.83 2.8 1.3 3.49.99.11-.78.42-1.3.76-1.6-2.67-.3-5.47-1.34-5.47-5.95 0-1.32.47-2.39 1.24-3.23-.13-.3-.54-1.53.12-3.18 0 0 1.01-.32 3.3 1.23a11.5 11.5 0 0 1 6 0c2.29-1.55 3.3-1.23 3.3-1.23.66 1.65.25 2.88.12 3.18.77.84 1.24 1.91 1.24 3.23 0 4.62-2.8 5.64-5.48 5.94.43.37.81 1.1.81 2.22v3.32c0 .32.22.69.83.57A12 12 0 0 0 12 .5Z"/>
                                </svg>
                            <?php elseif (str_contains($socialLabel, 'linkedin')): ?>
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill="currentColor" d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.13 1.44-2.13 2.94v5.67H9.35V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.26 2.37 4.26 5.46v6.28ZM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12Zm1.78 13.02H3.56V9h3.56v11.45ZM22.22 0H1.77C.79 0 0 .77 0 1.72v20.56C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.72V1.72C24 .77 23.2 0 22.22 0Z"/>
                                </svg>
                            <?php else: ?>
                                <?= esc(strtolower(substr($link['label'], 0, 2))) ?>
                            <?php endif ?>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="portrait-frame">
                <?php if (! empty($profile['avatar_url'])): ?>
                    <img class="portrait-image" src="<?= esc($profile['avatar_url'], 'attr') ?>" alt="Foto <?= esc($profile['full_name'], 'attr') ?>">
                <?php else: ?>
                    <div class="portrait-placeholder" role="img" aria-label="Ilustrasi foto profil">
                        <svg viewBox="0 0 360 420" aria-hidden="true">
                            <defs>
                                <linearGradient id="portrait-background" x1="0" x2="1" y1="0" y2="1">
                                    <stop offset="0" stop-color="#424242"/>
                                    <stop offset="1" stop-color="#111"/>
                                </linearGradient>
                                <linearGradient id="portrait-light" x1="0" x2="1">
                                    <stop offset="0" stop-color="#b6b6b6"/>
                                    <stop offset="1" stop-color="#656565"/>
                                </linearGradient>
                            </defs>
                            <rect width="360" height="420" fill="url(#portrait-background)"/>
                            <circle cx="180" cy="142" r="69" fill="url(#portrait-light)"/>
                            <path d="M75 420c7-100 45-151 105-151s98 51 105 151" fill="#262626"/>
                            <path d="M126 184c19 25 38 37 54 37s35-12 54-37" fill="none" stroke="#484848" stroke-width="8" stroke-linecap="round"/>
                        </svg>
                        <span><?= esc($profile['full_name']) ?></span>
                    </div>
                <?php endif ?>
                <span class="portrait-caption"><?= esc($profile['location']) ?> · <?= esc($profile['availability']) ?></span>
            </div>
        </section>

        <section class="section-block page-width about-section" id="about">
            <div class="center-heading">
                <p class="eyebrow">SENANG BERTEMU DENGANMU</p>
                <h2>About Me</h2>
                <p class="about-copy"><?= esc($profile['bio']) ?></p>
            </div>
            <?php if ($approachItems !== []): ?>
                <h3 class="approach-heading">My Journey</h3>
                <div class="approach-grid">
                    <?php foreach ($approachItems as $index => $item): ?>
                        <article class="approach-card">
                            <span class="approach-number">0<?= $index + 1 ?></span>
                            <div>
                                <h3><?= esc($item['title']) ?></h3>
                                <p><?= esc($item['label']) ?></p>
                            </div>
                        </article>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            <div class="stats-row">
                <div><strong><?= str_pad((string) count($experiences), 2, '0', STR_PAD_LEFT) ?>+</strong><span>Pengalaman</span></div>
                <div><strong><?= str_pad((string) count($projects), 2, '0', STR_PAD_LEFT) ?>+</strong><span>Proyek</span></div>
                <div><strong><?= str_pad((string) count($skills), 2, '0', STR_PAD_LEFT) ?>+</strong><span>Keahlian</span></div>
            </div>
        </section>

        <section class="section-block page-width" id="skills">
            <div class="center-heading">
                <p class="eyebrow">HAL YANG SAYA KUASAI</p>
                <h2>Skills</h2>
                <p>Teknologi dan tools yang saya gunakan untuk mengubah ide menjadi kenyataan.</p>
            </div>
            <div class="skills-grid">
                <?php foreach ($skillGroups as $category => $items): ?>
                    <article class="dark-card skill-card">
                        <h3><?= esc($category) ?></h3>
                        <div class="skill-tags">
                            <?php foreach ($items as $skill): ?>
                                <span><?= esc($skill['name']) ?></span>
                            <?php endforeach ?>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        </section>

        <section class="section-block page-width" id="projects">
            <div class="center-heading">
                <p class="eyebrow">KARYA PILIHAN</p>
                <h2>Projects</h2>
                <p>Beberapa hal yang pernah saya rancang dan bangun.</p>
            </div>
            <div class="project-grid">
                <?php foreach ($projects as $index => $project): ?>
                    <article class="dark-card project-card">
                        <div class="project-visual project-visual-<?= ($index % 3) + 1 ?><?= ! empty($project['image_url']) ? ' project-visual-has-image' : '' ?>">
                            <span>0<?= $index + 1 ?></span>
                            <?php if (! empty($project['image_url'])): ?>
                                <img class="project-image" src="<?= esc($project['image_url'], 'attr') ?>" alt="Gambar proyek <?= esc($project['title'], 'attr') ?>">
                            <?php else: ?>
                                <strong><?= esc(strtoupper(substr($project['title'], 0, 1))) ?></strong>
                            <?php endif ?>
                            <?php if (! empty($project['project_url'])): ?>
                                <a href="<?= esc($project['project_url'], 'attr') ?>" target="_blank" rel="noopener noreferrer" aria-label="Lihat <?= esc($project['title'], 'attr') ?>">↗</a>
                            <?php endif ?>
                        </div>
                        <div class="project-info">
                            <h3><?= esc($project['title']) ?></h3>
                            <p><?= esc($project['description']) ?></p>
                            <span class="project-stack"><?= esc($project['stack']) ?></span>
                            <?php if (! empty($project['repository_url'])): ?>
                                <a class="repository-link" href="<?= esc($project['repository_url'], 'attr') ?>" target="_blank" rel="noopener noreferrer">Lihat repositori ↗</a>
                            <?php endif ?>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        </section>

        <section class="section-block page-width" id="experience">
            <div class="center-heading">
                <p class="eyebrow">BELAJAR DAN BERTUMBUH</p>
                <h2>Experience & Education</h2>
            </div>
            <div class="timeline-grid">
                <?php foreach ($experiences as $item): ?>
                    <article class="dark-card timeline-card">
                        <span class="timeline-period"><?= esc($item['period']) ?></span>
                        <h3><?= esc($item['role']) ?></h3>
                        <p class="timeline-meta"><?= esc($item['organization']) ?></p>
                        <p><?= esc($item['description']) ?></p>
                    </article>
                <?php endforeach ?>
                <?php foreach ($education as $item): ?>
                    <article class="dark-card timeline-card">
                        <span class="timeline-period"><?= esc($item['study_period']) ?></span>
                        <h3><?= esc($item['degree']) ?></h3>
                        <p class="timeline-meta"><?= esc($item['institution']) ?></p>
                        <?php if (! empty($item['description'])): ?><p><?= esc($item['description']) ?></p><?php endif ?>
                    </article>
                <?php endforeach ?>
            </div>
        </section>

        <?php if ($achievements !== []): ?>
            <section class="section-block page-width" id="achievements">
                <div class="center-heading">
                    <p class="eyebrow">PENCAPAIAN</p>
                    <h2>Milestones</h2>
                </div>
                <div class="achievement-grid">
                    <?php foreach ($achievements as $item): ?>
                        <article class="dark-card achievement-card">
                            <span><?= esc($item['awarded_at']) ?></span>
                            <h3><?= esc($item['title']) ?></h3>
                            <p><?= esc($item['organization']) ?></p>
                            <?php if (! empty($item['description'])): ?><p><?= esc($item['description']) ?></p><?php endif ?>
                            <?php if (! empty($item['certificate_url'])): ?>
                                <a class="certificate-link" href="<?= esc($item['certificate_url'], 'attr') ?>" target="_blank" rel="noopener noreferrer">Lihat sertifikat ↗</a>
                            <?php endif ?>
                        </article>
                    <?php endforeach ?>
                </div>
            </section>
        <?php endif ?>

        <section class="contact-section" id="contact">
            <div class="page-width contact-inner">
                <p class="eyebrow">ADA IDE MENARIK?</p>
                <h2>Let's Talk<span>.</span></h2>
                <a class="contact-email" href="<?= esc($emailUrl, 'attr') ?>" target="_blank" rel="noopener noreferrer"><?= esc($profile['email']) ?> ↗</a>
                <?php if (! empty($profile['phone'])): ?>
                    <a class="contact-phone" href="tel:<?= esc(preg_replace('/[^0-9+]/', '', $profile['phone']), 'attr') ?>"><?= esc($profile['phone']) ?></a>
                <?php endif ?>
                <div class="contact-bottom">
                    <span><?= esc($profile['location']) ?></span>
                    <div class="social-links">
                        <?php foreach ($socialLinks as $link): ?>
                            <a href="<?= esc($link['url'], 'attr') ?>" target="_blank" rel="noopener noreferrer"><?= esc($link['label']) ?> ↗</a>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer page-width">
        <a href="#home"><?= esc($profile['full_name']) ?></a>
        <span>&copy; <?= date('Y') ?></span>
    </footer>
<?php endif ?>
</body>
</html>
