<?php

namespace Inc\Helpers;

use Inc\Traits\Singleton;
class template_tags
{
          use Singleton;
          public function yoyo_the_excert($custom_excert_length = 20)
          {
                    if (!has_excerpt() || $custom_excert_length === 0) {
                              return get_the_excerpt();
                    }
                    // Remove all HTML tags e.g. `strip_tags( '<script>something</script>' )` will return 'something'.
                    $get_excert = wp_strip_all_tags(get_the_excerpt());

                    $trimed_excert = substr($get_excert, 0, $custom_excert_length);

                    $excerpt = rtrim($trimed_excert, ' .');
                    return $excerpt . "...";
          }
}