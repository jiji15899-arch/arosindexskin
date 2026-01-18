<?php
/**
 * 홈페이지형 목차 스킨 - Functions
 * Theme Name: Aros Index Skin
 * Version: 1.0
 */

// 테마 기본 설정
function aros_index_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    
    // 메뉴 등록
    register_nav_menus(array(
        'tab-menu' => '탭 메뉴'
    ));
}
add_action('after_setup_theme', 'aros_index_setup');

// 스타일 및 스크립트 등록
function aros_index_scripts() {
    wp_enqueue_style('noto-sans-kr', 'https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700&display=swap');
    wp_enqueue_style('aros-index-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_script('aros-index-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'aros_index_scripts');

// 커스텀 포스트 타입: 버튼
function aros_register_button_post_type() {
    $labels = array(
        'name' => '버튼',
        'singular_name' => '버튼',
        'add_new' => '버튼 추가',
        'add_new_item' => '새 버튼 추가',
        'edit_item' => '버튼 수정',
        'new_item' => '새 버튼',
        'view_item' => '버튼 보기',
        'search_items' => '버튼 검색',
        'not_found' => '버튼이 없습니다',
        'not_found_in_trash' => '휴지통에 버튼이 없습니다'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'aros-button'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-links',
        'supports' => array('title'),
        'show_in_rest' => true,
    );

    register_post_type('aros_button', $args);
}
add_action('init', 'aros_register_button_post_type');

// 버튼 메타박스
function aros_button_meta_boxes() {
    add_meta_box(
        'aros_button_details',
        '버튼 설정',
        'aros_button_meta_callback',
        'aros_button',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'aros_button_meta_boxes');

// 버튼 메타박스 콜백
function aros_button_meta_callback($post) {
    wp_nonce_field('aros_button_save_meta', 'aros_button_meta_nonce');
    
    $subtitle = get_post_meta($post->ID, '_button_subtitle', true);
    $url = get_post_meta($post->ID, '_button_url', true);
    $icon = get_post_meta($post->ID, '_button_icon', true);
    $color = get_post_meta($post->ID, '_button_color', true);
    $section = get_post_meta($post->ID, '_button_section', true);
    $order = get_post_meta($post->ID, '_button_order', true);
    
    if (empty($color)) $color = 'card-blue';
    if (empty($section)) $section = 'section1';
    if (empty($order)) $order = 0;
    ?>
    <style>
        .aros-meta-table { width: 100%; border-collapse: collapse; }
        .aros-meta-table th { width: 150px; padding: 15px 10px; text-align: left; vertical-align: top; }
        .aros-meta-table td { padding: 15px 10px; }
        .aros-meta-table input[type="text"],
        .aros-meta-table input[type="url"],
        .aros-meta-table input[type="number"],
        .aros-meta-table select { width: 100%; max-width: 500px; }
    </style>
    <table class="aros-meta-table">
        <tr>
            <th><label for="button_subtitle">부제목</label></th>
            <td><input type="text" id="button_subtitle" name="button_subtitle" value="<?php echo esc_attr($subtitle); ?>" placeholder="예: 신청gogo"></td>
        </tr>
        <tr>
            <th><label for="button_url">링크 URL</label></th>
            <td><input type="url" id="button_url" name="button_url" value="<?php echo esc_attr($url); ?>" placeholder="https://example.com"></td>
        </tr>
        <tr>
            <th><label for="button_icon">아이콘 (이모지)</label></th>
            <td><input type="text" id="button_icon" name="button_icon" value="<?php echo esc_attr($icon); ?>" placeholder="🔥"></td>
        </tr>
        <tr>
            <th><label for="button_color">색상 클래스</label></th>
            <td>
                <select id="button_color" name="button_color">
                    <option value="card-blue" <?php selected($color, 'card-blue'); ?>>파란색</option>
                    <option value="card-blue2" <?php selected($color, 'card-blue2'); ?>>파란색2</option>
                    <option value="card-blue3" <?php selected($color, 'card-blue3'); ?>>파란색3</option>
                    <option value="card-blue4" <?php selected($color, 'card-blue4'); ?>>파란색4</option>
                    <option value="card-teal" <?php selected($color, 'card-teal'); ?>>청록색</option>
                    <option value="card-purple" <?php selected($color, 'card-purple'); ?>>보라색</option>
                    <option value="card-lightpurple" <?php selected($color, 'card-lightpurple'); ?>>연보라</option>
                    <option value="card-deeppurple" <?php selected($color, 'card-deeppurple'); ?>>진보라</option>
                    <option value="card-violet" <?php selected($color, 'card-violet'); ?>>바이올렛</option>
                    <option value="card-green" <?php selected($color, 'card-green'); ?>>초록색</option>
                    <option value="card-forestgreen" <?php selected($color, 'card-forestgreen'); ?>>숲초록</option>
                    <option value="card-seagreen" <?php selected($color, 'card-seagreen'); ?>>바다초록</option>
                    <option value="card-orange" <?php selected($color, 'card-orange'); ?>>주황색</option>
                    <option value="card-darkgold" <?php selected($color, 'card-darkgold'); ?>>진금색</option>
                    <option value="card-amber" <?php selected($color, 'card-amber'); ?>>호박색</option>
                    <option value="card-mustard" <?php selected($color, 'card-mustard'); ?>>겨자색</option>
                    <option value="card-bronze" <?php selected($color, 'card-bronze'); ?>>청동색</option>
                    <option value="card-royalblue" <?php selected($color, 'card-royalblue'); ?>>로열블루</option>
                    <option value="card-deepskyblue" <?php selected($color, 'card-deepskyblue'); ?>>딥스카이블루</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="button_section">섹션</label></th>
            <td>
                <select id="button_section" name="button_section">
                    <option value="section1" <?php selected($section, 'section1'); ?>>섹션 1</option>
                    <option value="section2" <?php selected($section, 'section2'); ?>>섹션 2</option>
                    <option value="section3" <?php selected($section, 'section3'); ?>>섹션 3</option>
                    <option value="section4" <?php selected($section, 'section4'); ?>>섹션 4</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="button_order">정렬 순서</label></th>
            <td><input type="number" id="button_order" name="button_order" value="<?php echo esc_attr($order); ?>" min="0" placeholder="0"></td>
        </tr>
    </table>
    <?php
}

// 버튼 메타 저장
function aros_save_button_meta($post_id) {
    // 자동 저장 체크
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Nonce 확인
    if (!isset($_POST['aros_button_meta_nonce']) || 
        !wp_verify_nonce($_POST['aros_button_meta_nonce'], 'aros_button_save_meta')) {
        return;
    }

    // 권한 확인
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // 필드 저장
    $fields = array(
        'button_subtitle' => 'sanitize_text_field',
        'button_url' => 'esc_url_raw',
        'button_icon' => 'sanitize_text_field',
        'button_color' => 'sanitize_text_field',
        'button_section' => 'sanitize_text_field',
        'button_order' => 'absint'
    );

    foreach ($fields as $field => $sanitize_function) {
        if (isset($_POST[$field])) {
            $value = call_user_func($sanitize_function, $_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
}
add_action('save_post_aros_button', 'aros_save_button_meta');

// 버튼 목록에 컬럼 추가
function aros_button_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['subtitle'] = '부제목';
    $new_columns['section'] = '섹션';
    $new_columns['color'] = '색상';
    $new_columns['order'] = '순서';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_aros_button_posts_columns', 'aros_button_columns');

// 버튼 목록 컬럼 내용
function aros_button_column_content($column, $post_id) {
    switch ($column) {
        case 'subtitle':
            echo esc_html(get_post_meta($post_id, '_button_subtitle', true));
            break;
        case 'section':
            echo esc_html(get_post_meta($post_id, '_button_section', true));
            break;
        case 'color':
            $color = get_post_meta($post_id, '_button_color', true);
            echo '<span class="' . esc_attr($color) . '" style="padding: 3px 8px; border-radius: 3px; background: #2196F3; color: white;">' . esc_html($color) . '</span>';
            break;
        case 'order':
            echo esc_html(get_post_meta($post_id, '_button_order', true));
            break;
    }
}
add_action('manage_aros_button_posts_custom_column', 'aros_button_column_content', 10, 2);

// 테마 커스터마이저
function aros_index_customize_register($wp_customize) {
    // 로고 설정
    $wp_customize->add_section('aros_header', array(
        'title' => '헤더 설정',
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('header_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo', array(
        'label' => '로고 이미지',
        'section' => 'aros_header',
        'settings' => 'header_logo',
    )));
    
    $wp_customize->add_setting('site_title', array(
        'default' => '오늘의 아파트',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('site_title', array(
        'label' => '사이트 제목',
        'section' => 'aros_header',
        'type' => 'text',
    ));
    
    // 탭 메뉴 설정
    $wp_customize->add_section('aros_tabs', array(
        'title' => '탭 메뉴 설정',
        'priority' => 31,
    ));
    
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("tab{$i}_text", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("tab{$i}_text", array(
            'label' => "탭 {$i} 텍스트",
            'section' => 'aros_tabs',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting("tab{$i}_url", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control("tab{$i}_url", array(
            'label' => "탭 {$i} URL",
            'section' => 'aros_tabs',
            'type' => 'url',
        ));
        
        $wp_customize->add_setting("tab{$i}_hash", array(
            'default' => "aros{$i}",
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("tab{$i}_hash", array(
            'label' => "탭 {$i} Hash",
            'description' => '예: aros1',
            'section' => 'aros_tabs',
            'type' => 'text',
        ));
    }
    
    // 메인 카드 설정
    $wp_customize->add_section('aros_main_card', array(
        'title' => '메인 카드 설정',
        'priority' => 32,
    ));
    
    $wp_customize->add_setting('main_card_title', array(
        'default' => '근로장려금 신청',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('main_card_title', array(
        'label' => '메인 카드 제목',
        'section' => 'aros_main_card',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('main_card_text', array(
        'default' => '대한민국 92%가 놓치고 있던 사실!<br/>근로장려금, 자금 받을 수 있습니다!<br/>바로 확인하고 혜택 놓치지 마세요!',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('main_card_text', array(
        'label' => '메인 카드 내용',
        'section' => 'aros_main_card',
        'type' => 'textarea',
    ));
    
    $wp_customize->add_setting('main_card_icon', array(
        'default' => '🎁',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('main_card_icon', array(
        'label' => '메인 카드 아이콘',
        'section' => 'aros_main_card',
        'type' => 'text',
    ));
    
    // 섹션 제목 설정
    $wp_customize->add_section('aros_sections', array(
        'title' => '섹션 제목 설정',
        'priority' => 33,
    ));
    
    $default_sections = array(
        1 => array('title' => '최대 460만원, 지금 바로 신청!', 'id' => 'aros1'),
        2 => array('title' => '근로장려금, 당신도 받을 수 있다!', 'id' => 'aros2'),
        3 => array('title' => '1인당 330만원, 지금 확인!', 'id' => 'aros3'),
        4 => array('title' => '정부 지원금, 놓치지 마세요!', 'id' => 'aros4'),
    );
    
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("section{$i}_title", array(
            'default' => $default_sections[$i]['title'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("section{$i}_title", array(
            'label' => "섹션 {$i} 제목",
            'section' => 'aros_sections',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting("section{$i}_id", array(
            'default' => $default_sections[$i]['id'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("section{$i}_id", array(
            'label' => "섹션 {$i} ID",
            'section' => 'aros_sections',
            'type' => 'text',
        ));
    }
    
    // 애드센스 설정
    $wp_customize->add_section('aros_adsense', array(
        'title' => '애드센스 설정',
        'priority' => 34,
    ));
    
    $wp_customize->add_setting('adsense_client', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('adsense_client', array(
        'label' => '애드센스 클라이언트 ID',
        'description' => 'ca-pub-xxxxx 형식',
        'section' => 'aros_adsense',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('adsense_slot', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('adsense_slot', array(
        'label' => '애드센스 슬롯 ID',
        'section' => 'aros_adsense',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('adsense_blocker_url', array(
        'default' => 'https://aros100.com',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('adsense_blocker_url', array(
        'label' => '무효 트래픽 방지 리다이렉트 URL',
        'section' => 'aros_adsense',
        'type' => 'url',
    ));
    
    // 푸터 설정
    $wp_customize->add_section('aros_footer', array(
        'title' => '푸터 설정',
        'priority' => 35,
    ));
    
    $wp_customize->add_setting('footer_brand', array(
        'default' => '굿인포',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_brand', array(
        'label' => '브랜드명',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('footer_address', array(
        'default' => '대전광역시동구동부로10번길55',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_address', array(
        'label' => '사업자 주소',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('footer_business_number', array(
        'default' => '784-15-02513',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_business_number', array(
        'label' => '사업자 번호',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('footer_creator', array(
        'default' => '아로스',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_creator', array(
        'label' => '제작자',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('footer_website', array(
        'default' => 'https://aros100.com',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('footer_website', array(
        'label' => '홈페이지 URL',
        'section' => 'aros_footer',
        'type' => 'url',
    ));
    
    $wp_customize->add_setting('footer_copyright', array(
        'default' => 'Copyrights © 2020 All Rights Reserved by (주)아백',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_copyright', array(
        'label' => '저작권 문구',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
}
add_action('customize_register', 'aros_index_customize_register');

// 버튼 가져오기 헬퍼 함수
function get_section_buttons($section) {
    $args = array(
        'post_type' => 'aros_button',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_button_section',
                'value' => $section,
                'compare' => '='
            ),
        ),
        'meta_key' => '_button_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
    );
    
    return new WP_Query($args);
}
