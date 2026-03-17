<?php
/**
 * 404-Seite – xphysio.ch
 * Neve Child Theme
 */
get_header();
?>
<main id="main" class="xp-404-main" role="main" aria-label="Seite nicht gefunden">
    <div class="xp-404-container">
        <div class="xp-404-content">
            <p class="xp-404-code" aria-hidden="true">404</p>
            <h1 class="xp-404-title">Diese Seite existiert nicht</h1>
            <p class="xp-404-text">
                Die gesuchte Seite wurde möglicherweise verschoben, umbenannt oder gelöscht.
                Kein Problem – von hier aus finden Sie schnell wieder den richtigen Weg.
            </p>

            <div class="xp-404-search">
                <?php get_search_form(); ?>
            </div>

            <nav class="xp-404-links" aria-label="Weiterführende Seiten">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="xp-btn xp-btn--primary">
                    Zur Startseite
                </a>
                <a href="<?php echo esc_url( home_url( '/angebot/' ) ); ?>" class="xp-btn xp-btn--secondary">
                    Angebot &amp; Preise
                </a>
                <a href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>" class="xp-btn xp-btn--secondary">
                    Kontakt &amp; Termin
                </a>
            </nav>
        </div>
    </div>
</main>

<style>
.xp-404-main {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 60vh;
    padding: 3rem 1.5rem;
}
.xp-404-container {
    max-width: 600px;
    width: 100%;
    text-align: center;
}
.xp-404-code {
    font-size: clamp(5rem, 20vw, 8rem);
    font-weight: 700;
    color: #dff2ff;
    line-height: 1;
    margin: 0 0 0.25rem;
    font-family: 'Lora', serif;
}
.xp-404-title {
    font-size: clamp(1.5rem, 4vw, 2rem);
    color: #1e2761;
    margin: 0 0 1rem;
}
.xp-404-text {
    color: #555;
    font-size: 1rem;
    line-height: 1.7;
    margin: 0 0 2rem;
}
.xp-404-search {
    margin: 0 0 2rem;
}
.xp-404-search .search-form {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}
.xp-404-search .search-field {
    flex: 1;
    max-width: 320px;
    padding: 0.6rem 1rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
}
.xp-404-search .search-submit {
    padding: 0.6rem 1.25rem;
    background: #1e2761;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s ease;
}
.xp-404-search .search-submit:hover {
    background: #7a2048;
}
.xp-404-links {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    justify-content: center;
}
.xp-btn {
    display: inline-block;
    padding: 0.65rem 1.5rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease;
    min-height: 44px;
    line-height: 1.4;
}
.xp-btn--primary {
    background: #1e2761;
    color: #fff;
}
.xp-btn--primary:hover {
    background: #7a2048;
    color: #fff;
}
.xp-btn--secondary {
    background: transparent;
    color: #1e2761;
    border: 2px solid #1e2761;
}
.xp-btn--secondary:hover {
    background: #1e2761;
    color: #fff;
}
</style>

<?php get_footer(); ?>
