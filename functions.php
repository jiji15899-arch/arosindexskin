<?php
/**
 * 홈페이지형 목차 스킨 - Functions
 * Theme Name: Aros Index Skin
 * Version: 1.1
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
        'name' => '버튼 관리',
        'singular_name' => '버튼',
        'add_new' => '새 버튼 만들기',
        'add_new_item' => '새 버튼 추가',
        'edit_item' => '버튼 수정',
        'new_item' => '새 버튼',
        'view_item' => '버튼 보기',
        'search_items' => '버튼 검색',
        'not_found' => '생성된 버튼이 없습니다',
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
        'menu_icon' => 'dashicons-grid-view',
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
        '버튼 상세 설정',
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
    
    // 현재 설정된 섹션 ID 가져오기 (참고용)
    $s1_id = get_theme_mod('section1_id', 'aros1');
    $s2_id = get_theme_mod('section2_id', 'aros2');
    $s3_id = get_theme_mod('section3_id', 'aros3');
    $s4_id = get_theme_mod('section4_id', 'aros4');
    ?>
    <style>
        .aros-meta-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
        .aros-meta-table th { width: 120px; text-align: left; vertical-align: middle; font-weight: 600; }
        .aros-meta-table input[type="text"],
        .aros-meta-table input[type="url"],
        .aros-meta-table input[type="number"],
        .aros-meta-table select { width: 100%; max-width: 400px; padding: 6px; }
        .description { font-size: 12px; color: #666; margin-top: 4px; display: block; }
    </style>
    <table class="aros-meta-table">
        <tr>
            <th>배치할 위치</th>
            <td>
                <select id="button_section" name="button_section">
                    <option value="section1" <?php selected($section, 'section1'); ?>>섹션 1 (ID: <?php echo esc_html($s1_id); ?>)</option>
                    <option value="section2" <?php selected($section, 'section2'); ?>>섹션 2 (ID: <?php echo esc_html($s2_id); ?>)</option>
                    <option value="section3" <?php selected($section, 'section3'); ?>>섹션 3 (ID: <?php echo esc_html($s3_id); ?>)</option>
                    <option value="section4" <?php selected($section, 'section4'); ?>>섹션 4 (ID: <?php echo esc_html($s4_id); ?>)</option>
                </select>
                <span class="description">이 버튼이 나타날 섹션을 선택하세요. ID는 '사용자 정의하기'에서 변경 가능합니다.</span>
            </td>
        </tr>
        <tr>
            <th>부제목</th>
            <td><input type="text" id="button_subtitle" name="button_subtitle" value="<?php echo esc_attr($subtitle); ?>" placeholder="예: 신청바로가기"></td>
        </tr>
        <tr>
            <th>링크 URL</th>
            <td><input type="url" id="button_url" name="button_url" value="<?php echo esc_attr($url); ?>" placeholder="https://..."></td>
        </tr>
        <tr>
            <th>아이콘</th>
            <td><input type="text" id="button_icon" name="button_icon" value="<?php echo esc_attr($icon); ?>" placeholder="🔥"></td>
        </tr>
        <tr>
            <th>배경 색상</th>
            <td>
                <select id="button_color" name="button_color">
                    <option value="card-blue" <?php selected($color, 'card-blue'); ?>>기본 파랑</option>
                    <option value="card-blue2" <?php selected($color, 'card-blue2'); ?>>진한 파랑</option>
                    <option value="card-teal" <?php selected($color, 'card-teal'); ?>>청록색</option>
                    <option value="card-purple" <?php selected($color, 'card-purple'); ?>>보라색</option>
                    <option value="card-green" <?php selected($color, 'card-green'); ?>>초록색</option>
                    <option value="card-orange" <?php selected($color, 'card-orange'); ?>>주황색</option>
                    <option value="card-mustard" <?php selected($color, 'card-mustard'); ?>>겨자색</option>
                    <option value="card-deeppurple" <?php selected($color, 'card-deeppurple'); ?>>진보라</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>정렬 순서</th>
            <td><input type="number" id="button_order" name="button_order" value="<?php echo esc_attr($order); ?>" min="0"></td>
        </tr>
    </table>
    <?php
}

// 버튼 메타 저장
function aros_save_button_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['aros_button_meta_nonce']) || !wp_verify_nonce($_POST['aros_button_meta_nonce'], 'aros_button_save_meta')) return;
    if (!current_user_can('edit_post', $post_id)) return;

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
            update_post_meta($post_id, '_' . $field, call_user_func($sanitize_function, $_POST[$field]));
        }
    }
}
add_action('save_post_aros_button', 'aros_save_button_meta');

// 테마 커스터마이저
function aros_index_customize_register($wp_customize) {
    // 로고 설정
    $wp_customize->add_section('aros_header', array('title' => '헤더 설정', 'priority' => 30));
    $wp_customize->add_setting('header_logo', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo', array('label' => '로고 이미지', 'section' => 'aros_header')));
    $wp_customize->add_setting('site_title', array('default' => '오늘의 아파트', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('site_title', array('label' => '사이트 제목', 'section' => 'aros_header', 'type' => 'text'));
    
    // 탭 메뉴 설정 (활성화 여부 추가)
    $wp_customize->add_section('aros_tabs', array('title' => '탭 메뉴 설정', 'priority' => 31));
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("tab{$i}_text", array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("tab{$i}_text", array('label' => "탭 {$i} 텍스트", 'section' => 'aros_tabs', 'type' => 'text'));
        
        $wp_customize->add_setting("tab{$i}_url", array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("tab{$i}_url", array('label' => "탭 {$i} URL", 'section' => 'aros_tabs', 'type' => 'url'));
        
        $wp_customize->add_setting("tab{$i}_hash", array('default' => "aros{$i}", 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("tab{$i}_hash", array('label' => "탭 {$i} Hash (ID 연결)", 'description' => '예: aros1', 'section' => 'aros_tabs', 'type' => 'text'));

        // 탭 활성화 옵션 추가
        $wp_customize->add_setting("tab{$i}_active", array('default' => ($i === 1), 'sanitize_callback' => 'wp_validate_boolean'));
        $wp_customize->add_control("tab{$i}_active", array('label' => "탭 {$i} 기본 활성화", 'section' => 'aros_tabs', 'type' => 'checkbox'));
    }
    
    // 메인 카드 설정
    $wp_customize->add_section('aros_main_card', array('title' => '메인 카드 설정', 'priority' => 32));
    $wp_customize->add_setting('main_card_title', array('default' => '근로장려금 신청', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('main_card_title', array('label' => '메인 카드 제목', 'section' => 'aros_main_card', 'type' => 'text'));
    $wp_customize->add_setting('main_card_text', array('default' => '내용을 입력하세요.', 'sanitize_callback' => 'wp_kses_post'));
    $wp_customize->add_control('main_card_text', array('label' => '메인 카드 내용', 'section' => 'aros_main_card', 'type' => 'textarea'));
    $wp_customize->add_setting('main_card_icon', array('default' => '🎁', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('main_card_icon', array('label' => '메인 카드 아이콘', 'section' => 'aros_main_card', 'type' => 'text'));
    
    // 섹션 제목 설정
    $wp_customize->add_section('aros_sections', array('title' => '섹션 ID 및 제목 설정', 'priority' => 33));
    $default_sections = array(
        1 => array('title' => '섹션 1 제목', 'id' => 'aros1'),
        2 => array('title' => '섹션 2 제목', 'id' => 'aros2'),
        3 => array('title' => '섹션 3 제목', 'id' => 'aros3'),
        4 => array('title' => '섹션 4 제목', 'id' => 'aros4'),
    );
    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("section{$i}_title", array('default' => $default_sections[$i]['title'], 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("section{$i}_title", array('label' => "섹션 {$i} 제목", 'section' => 'aros_sections', 'type' => 'text'));
        
        $wp_customize->add_setting("section{$i}_id", array('default' => $default_sections[$i]['id'], 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("section{$i}_id", array('label' => "섹션 {$i} ID (URL 연결용)", 'description' => '예: aros1', 'section' => 'aros_sections', 'type' => 'text'));
    }

    // 푸터 등 기타 설정은 기존 유지...
    $wp_customize->add_section('aros_adsense', array('title' => '애드센스 설정', 'priority' => 34));
    $wp_customize->add_setting('adsense_client', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('adsense_client', array('label' => '애드센스 클라이언트 ID', 'section' => 'aros_adsense', 'type' => 'text'));
    $wp_customize->add_setting('adsense_slot', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('adsense_slot', array('label' => '애드센스 슬롯 ID', 'section' => 'aros_adsense', 'type' => 'text'));
    
    $wp_customize->add_section('aros_footer', array('title' => '푸터 설정', 'priority' => 35));
    $wp_customize->add_setting('footer_brand', array('default' => '굿인포', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_brand', array('label' => '브랜드명', 'section' => 'aros_footer', 'type' => 'text'));
    // (푸터 나머지 설정은 생략 없이 기존 코드 사용 권장, 여기서는 핵심만 수정)
}
add_action('customize_register', 'aros_index_customize_register');

// 버튼 가져오기 헬퍼 함수 (핵심 수정: post_status 추가)
function get_section_buttons($section) {
    $args = array(
        'post_type' => 'aros_button',
        'posts_per_page' => -1,
        'post_status' => 'publish', // 발행된 글만 가져오기 (중요)
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
