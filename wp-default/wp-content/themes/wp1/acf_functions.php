<?php
function modify_acf_relationship_display($title, $post, $field, $post_id) {
    return $title . ' (' . $post->ID . ')';
}
add_filter('acf/fields/relationship/result', 'modify_acf_relationship_display', 10, 4);