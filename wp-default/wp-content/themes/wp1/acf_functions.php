<?php

class ACF_Custom_Fields
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'my_acf_init_public']);
        add_action('acf/init', [$this, 'my_acf_init_private']);
        add_action('acf/init', [$this, 'my_acf_init_taxonomy']);
        add_filter('acf/validate_value/name=custom_image_field', [$this, 'validate_image'], 10, 4);
        add_filter('acf/fields/relationship/result', [$this,'modify_acf_relationship_display'], 10, 4);
        add_filter('acf/fields/relationship/query/name=custom_relationship_field', [$this, 'my_acf_defined_relationship'], 10, 3);
    }


    public function my_acf_init_public(): void
    {
        // Register a custom field group
        acf_add_local_field_group([
            'key' => 'group_1',
            'title' => 'Custom Fields',
            'fields' => [
                [
                    'key' => 'field_1_public',
                    'label' => 'Custom Text Field',
                    'name' => 'custom_text_field',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_2_public',
                    'label' => 'Custom image Field',
                    'name' => 'custom_image_field',
                    'type' => 'image',
                    'instructions' => 'width = 48px, max height = 100px',
                    'return_format' => [],
                ],
                [
                    'key' => 'field_3_public',
                    'label' => 'Custom Relationship Field',
                    'name' => 'custom_relationship_field',
                    'type' => 'relationship',
                    'post_type' => ['my-custom-type-2',/*'post', 'page'*/],
                    'filters' => ['search', /*'post_type'*/],
                    'return_format' => 'object'/*'id'*/,
                ],

            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'my-custom-type-1',
                    ],
                ],
            ],
        ]);
    }

    public function my_acf_init_private(): void
    {
        // Register a custom field group
        acf_add_local_field_group([
            'key' => 'group_2',
            'title' => 'Custom Fields Private',
            'fields' => [
                [
                    'key' => 'field_1_private',
                    'label' => 'Custom Select Field',
                    'name' => 'custom_select_field',
                    'type' => 'select',
                    'choices' => [
                        'option1' => 'Option 1',
                        'option2' => 'Option 2',
                        'option3' => 'Option 3',
                    ],
                    'default_value' => 'option1',
                    'allow_null' => true,
                ],
                [
                    'key' => 'field_2_private',
                    'label' => 'Taxonomy Select Field',
                    'name' => 'taxonomy_select_field',
                    'type' => 'taxonomy',
                    'taxonomy' => 'category_taxonomy',
                    'field_type' => 'multi_select',
                    'allow_null' => true,
                    'add_term' => true,
                    'save_terms' => true,
                    'load_terms' => true,
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'my-custom-type-2',
                    ],
                ],
            ],
        ]);
    }

    public function my_acf_init_taxonomy(): void
    {
        // Register a custom field group
        acf_add_local_field_group([
            'key' => 'group_3',
            'title' => 'Custom Fields Taxonomy',
            'fields' => [
                [
                    'key' => 'field_1_taxonomy',
                    'label' => 'Toggle option',
                    'name' => 'toggle_option',
                    'type' => 'true_false',
                    'ui' => 1,
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => 'category_taxonomy',
                    ],
                ],
            ],
        ]);
    }

    public function validate_image($valid, $value, $field, $input)
    {
        if (!$valid) {
            return $valid;
        }

        if (empty($value)) {
            return 'Пожалуйста, загрузите изображение.';
        }

        // Get the image dimensions
        $image = wp_get_attachment_image_src($value, 'full');
        if ($image) {
            $width = $image[1];
            $height = $image[2];

            if ($width != 48 || $height > 100) {
                return 'Изображение должно быть 48px в ширину и не выше 100px.';
            }
        }

        return $valid;
    }

    public function modify_acf_relationship_display($title, $post, /*$field, $post_id*/): string
    {
        return $title . ' (' . $post->ID . ')';
    }

    public function my_acf_defined_relationship($args, $field, $post_id)
    {
        $args['meta_query'] = [
            [
                'key' => 'custom_select_field', // Поле выбора
                'value' => 'option2', // Только записи с Option 2
                'compare' => '=', // Сравнение с LIKE
            ]
        ];

        return $args;
    }
}











