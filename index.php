<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php if (get_theme_mod('adsense_blocker_url')): ?>
    <script>
        window.redirectTarget = "<?php echo esc_js(get_theme_mod('adsense_blocker_url', 'https://aros100.com')); ?>";
    </script>
    <script src='https://cdn.jsdelivr.net/gh/abaeksite/aros_adsense_blocker@main/aros_adsense_blocker_v7-1.js'></script>
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class='main-wrapper'>
    <!-- 헤더 섹션 -->
    <div class='section' id='header'>
        <div class='widget Header'>
            <div class='container'>
                <header class='header'>
                    <div class='container'>
                        <div class='logo'>
                            <?php if (get_theme_mod('header_logo')): ?>
                                <img alt='로고 이미지' src='<?php echo esc_url(get_theme_mod('header_logo')); ?>'/>
                            <?php endif; ?>
                        </div>
                        <h1 class='logo-text'><?php echo esc_html(get_theme_mod('site_title', get_bloginfo('name'))); ?></h1>
                    </div>
                </header>
            </div>
        </div>
    </div>

    <!-- 메인 섹션 -->
    <div class='main section' id='main'>
        <div class='widget Blog'>
            <div class='blog-posts hfeed container'>
                <div class='container'>
                    <!-- 탭 메뉴 -->
                    <div class='tab-wrapper'>
                        <div class='container'>
                            <nav class='tab-container'>
                                <ul class='tabs'>
                                    <?php for ($i = 1; $i <= 3; $i++): 
                                        $tab_text = get_theme_mod("tab{$i}_text");
                                        $tab_url = get_theme_mod("tab{$i}_url");
                                        $tab_hash = get_theme_mod("tab{$i}_hash");
                                        if ($tab_text && $tab_url):
                                    ?>
                                    <li class='tab-item'>
                                        <a class='tab-link <?php echo $i === 1 ? 'active' : ''; ?>' 
                                           data-tab='<?php echo esc_attr($tab_hash); ?>' 
                                           href='<?php echo esc_url($tab_url . '#' . $tab_hash); ?>'>
                                            <?php echo esc_html($tab_text); ?>
                                        </a>
                                    </li>
                                    <?php endif; endfor; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- 메인 카드 -->
                    <?php if (get_theme_mod('main_card_title')): ?>
                    <div class='content-card'>
                        <h2 class='card-title'><?php echo esc_html(get_theme_mod('main_card_title')); ?></h2>
                        <p class='card-text'><?php echo nl2br(esc_html(get_theme_mod('main_card_text'))); ?></p>
                        <span class='card-icon'><?php echo esc_html(get_theme_mod('main_card_icon', '🎁')); ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- 섹션 1 -->
                    <?php 
                    $section1_buttons = get_section_buttons('section1');
                    if ($section1_buttons->have_posts() && get_theme_mod('section1_title')):
                    ?>
                    <h2 class='section-title' id='<?php echo esc_attr(get_theme_mod('section1_id', 'aros1')); ?>'>
                        <?php echo esc_html(get_theme_mod('section1_title')); ?>
                    </h2>
                    <div class='support-grid'>
                        <?php while ($section1_buttons->have_posts()): $section1_buttons->the_post(); ?>
                        <a class='support-card <?php echo esc_attr(get_post_meta(get_the_ID(), '_button_color', true)); ?>' 
                           href='<?php echo esc_url(get_post_meta(get_the_ID(), '_button_url', true)); ?>'>
                            <div class='support-title'><?php the_title(); ?></div>
                            <div class='support-subtitle'><?php echo esc_html(get_post_meta(get_the_ID(), '_button_subtitle', true)); ?></div>
                            <div class='support-icon'><?php echo esc_html(get_post_meta(get_the_ID(), '_button_icon', true)); ?></div>
                        </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                    <?php endif; ?>

                    <!-- 애드센스 광고 -->
                    <?php if (get_theme_mod('adsense_client') && get_theme_mod('adsense_slot')): ?>
                    <div>
                        <script async crossorigin="anonymous" 
                                src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo esc_attr(get_theme_mod('adsense_client')); ?>"></script>
                        <ins class="adsbygoogle" 
                             data-ad-client="<?php echo esc_attr(get_theme_mod('adsense_client')); ?>" 
                             data-ad-format="auto" 
                             data-ad-slot="<?php echo esc_attr(get_theme_mod('adsense_slot')); ?>" 
                             data-full-width-responsive="true" 
                             style="display: block;"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                    <?php endif; ?>

                    <!-- 섹션 2 -->
                    <?php 
                    $section2_buttons = get_section_buttons('section2');
                    if ($section2_buttons->have_posts() && get_theme_mod('section2_title')):
                    ?>
                    <h2 class='section-title' id='<?php echo esc_attr(get_theme_mod('section2_id', 'aros2')); ?>'>
                        <?php echo esc_html(get_theme_mod('section2_title')); ?>
                    </h2>
                    <div class='support-grid'>
                        <?php while ($section2_buttons->have_posts()): $section2_buttons->the_post(); ?>
                        <a class='support-card <?php echo esc_attr(get_post_meta(get_the_ID(), '_button_color', true)); ?>' 
                           href='<?php echo esc_url(get_post_meta(get_the_ID(), '_button_url', true)); ?>'>
                            <div class='support-title'><?php the_title(); ?></div>
                            <div class='support-subtitle'><?php echo esc_html(get_post_meta(get_the_ID(), '_button_subtitle', true)); ?></div>
                            <div class='support-icon'><?php echo esc_html(get_post_meta(get_the_ID(), '_button_icon', true)); ?></div>
                        </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                    <?php endif; ?>

                    <!-- 섹션 3 -->
                    <?php 
                    $section3_buttons = get_section_buttons('section3');
                    if ($section3_buttons->have_posts() && get_theme_mod('section3_title')):
                    ?>
                    <h2 class='section-title' id='<?php echo esc_attr(get_theme_mod('section3_id', 'aros3')); ?>'>
                        <?php echo esc_html(get_theme_mod('section3_title')); ?>
                    </h2>
                    <div class='support-grid'>
                        <?php while ($section3_buttons->have_posts()): $section3_buttons->the_post(); ?>
                        <a class='support-card <?php echo esc_attr(get_post_meta(get_the_ID(), '_button_color', true)); ?>' 
                           href='<?php echo esc_url(get_post_meta(get_the_ID(), '_button_url', true)); ?>'>
                            <div class='support-title'><?php the_title(); ?></div>
                            <div class='support-subtitle'><?php echo esc_html(get_post_meta(get_the_ID(), '_button_subtitle', true)); ?></div>
                            <div class='support-icon'><?php echo esc_html(get_post_meta(get_the_ID(), '_button_icon', true)); ?></div>
                        </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                    <?php endif; ?>

                    <!-- 섹션 4 -->
                    <?php 
                    $section4_buttons = get_section_buttons('section4');
                    if ($section4_buttons->have_posts() && get_theme_mod('section4_title')):
                    ?>
                    <h2 class='section-title' id='<?php echo esc_attr(get_theme_mod('section4_id', 'aros4')); ?>'>
                        <?php echo esc_html(get_theme_mod('section4_title')); ?>
                    </h2>
                    <div class='support-grid'>
                        <?php while ($section4_buttons->have_posts()): $section4_buttons->the_post(); ?>
                        <a class='support-card <?php echo esc_attr(get_post_meta(get_the_ID(), '_button_color', true)); ?>' 
                           href='<?php echo esc_url(get_post_meta(get_the_ID(), '_button_url', true)); ?>'>
                            <div class='support-title'><?php the_title(); ?></div>
                            <div class='support-subtitle'><?php echo esc_html(get_post_meta(get_the_ID(), '_button_subtitle', true)); ?></div>
                            <div class='support-icon'><?php echo esc_html(get_post_meta(get_the_ID(), '_button_icon', true)); ?></div>
                        </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 푸터 -->
<footer class='footer'>
    <div class='footer-content'>
        <div class='footer-left'>
            <div class='footer-brand'><?php echo esc_html(get_theme_mod('footer_brand', '굿인포')); ?></div>
            <ul class='footer-info'>
                <li>
                    <i>📍</i>
                    사업자 주소: <?php echo esc_html(get_theme_mod('footer_address', '대전광역시동구동부로10번길55')); ?>
                </li>
                <li>
                    <i>🏢</i>
                    사업자 번호: <?php echo esc_html(get_theme_mod('footer_business_number', '784-15-02513')); ?>
                </li>
            </ul>
        </div>
        <div class='footer-right'>
            <p>제작자: <?php echo esc_html(get_theme_mod('footer_creator', '아로스')); ?></p>
            <p>홈페이지: <a href='<?php echo esc_url(get_theme_mod('footer_website', 'https://aros100.com')); ?>' target='_blank'>바로가기</a></p>
            <p class='footer-copyright'><?php echo esc_html(get_theme_mod('footer_copyright', 'Copyrights © 2020 All Rights Reserved by (주)아백')); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
