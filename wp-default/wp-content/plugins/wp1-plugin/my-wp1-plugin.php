<?php
/**
 * Plugin name: My1-custom-plugin
 * Description: Plugin  adds to system two custom post types "my-custom-type-1" public  and "my custom-type-2" private
 */

defined('ABSPATH') or die('You wrong way!');
function my1_custom_plugin(): void
{
    register_post_type('my-custom-type-1', [
        'label' => null,
        'labels' => [
            'name' => __('Custom Type 1', 'wp1'),
            'singular_name' => __('Custom Type 1', 'wp1'),
            'add_new' => __('Добавить', 'wp1'),
            'add_new_item' => __('Добавление', 'wp1'),
            'edit_item' => __('Редактирование', 'wp1'),
            'new_item' => __('Новое', 'wp1'),
            'view_item' => __('Смотреть', 'wp1'),
            'search_items' => __('Искать', 'wp1'),
            'not_found' => __('Не найдено', 'wp1'),
            'not_found_in_trash' => __('Не найдено в корзине', 'wp1'),
            'menu_name' => __('Custom Type 1', 'wp1'),
        ],
        'public' => true,
        'has_archive' => true,
        'show_in_menu' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => true,
    ]);

    register_post_type('my-custom-type-2', [
        'label' => null,
        'labels' => [
            'name' => __('Custom Type 2', 'wp1'),
            'singular_name' => __('Custom Type 2', 'wp1'),
            'add_new' => __('Добавить', 'wp1'),
            'add_new_item' => __('Добавление', 'wp1'),
            'edit_item' => __('Редактирование', 'wp1'),
            'new_item' => __('Новое', 'wp1'),
            'view_item' => __('Смотреть', 'wp1'),
            'search_items' => __('Искать', 'wp1'),
            'not_found' => __('Не найдено', 'wp1'),
            'not_found_in_trash' => __('Не найдено в корзине', 'wp1'),
            'menu_name' => __('Custom Type 2', 'wp1'),
        ],
        'public' => false,
        'show_ui' => true,
        'supports' => ['title', 'editor'],
        'rewrite' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
    ]);
}

add_action('init', 'my1_custom_plugin');
function my1_wp1_plugin_meta_boxes(): void
{
    add_meta_box(
        'my1_wp1_public_text_field',
        'Add data',
        'my1_wp1_public_text_field_callback',
        'my-custom-type-1',
    );

    add_meta_box(
        'my1_wp1_public_select_field',
        'Add selected data',
        'my1_wp1_public_select_field_callback',
        'my-custom-type-2',
    );
}

add_action('add_meta_boxes', 'my1_wp1_plugin_meta_boxes');

function my1_wp1_public_text_field_callback($post): void
{
    $value = get_post_meta($post->ID, 'my1_wp1_public_text', true);
    echo '<input type="text" name="my1_wp1_public_text" value="' . esc_attr($value) . '" />';
}

function my1_wp1_public_select_field_callback($post): void
{
    $value = get_post_meta($post->ID, 'my1_wp1_public_select', true);
    $options = ["type 1", "type 2", "type 3",];
    echo '<select name="my1_wp1_public_select">';
    foreach ($options as $option) {
        echo '<option value="' . esc_attr($option) . '"' . selected($value, $option, false) . '>' . esc_html($option) . '</option>';
    }
    echo '</select>';
}


function create_custom_taxonomy_in_my_custom_type_1(): void
{
    register_taxonomy('category_taxonomy', ['my-custom-type-1'], [
        'labels' => [
            'name' => __('Category taxonomy', 'wp1'),
            'singular_name' => __('Category taxonomy', 'wp1'),
        ],
        'public' => true,
        'hierarchical' => true,
        'show_admin_column' => true,
//        'rewrite' => ['slug' => 'category-custom-type-1'],
    ],
    );
}

add_action('init', 'create_custom_taxonomy_in_my_custom_type_1');

function add_boole_taxonomy_in_my_custom_type_1($term): void
{
    $value = (isset($term->term_id)) ? get_term_meta($term->term_id, 'custom_true_false_field', true) : 0;
    ?>
    <tr class="form-field">
        <th scope="row"><label for="custom_true_false_field">Включить поле?</label></th>
        <td>
            <input type="checkbox" name="custom_true_false_field" id="custom_true_false_field" value="1" <?php checked($value, 1); ?> />
        </td>
    </tr>
<?php
}

add_action("category_taxonomy_edit_form_fields", 'add_boole_taxonomy_in_my_custom_type_1');
add_action('category_taxonomy_add_form_fields', 'add_boole_taxonomy_in_my_custom_type_1');

