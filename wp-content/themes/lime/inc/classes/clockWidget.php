<?php
/**
 * Clock Widget
 * 
 * @package YOYO-Tube
 */

namespace Inc\classes;

use Inc\Traits\Singleton;

class ClockWidget extends \WP_Widget
{
          use Singleton;

          public function __construct()
          {
                    parent::__construct(
                              'Clock_widget',  // Base ID
                              'Clock',         // Name
                              ["description" => __("Clock widget", "yoyo-tube")]
                    );
          }

          public $args = array(
                    'before_title' => '<h4 class="widgettitle">',
                    'after_title' => '</h4>',
                    'before_widget' => '<div class="widget-wrap">',
                    'after_widget' => '</div>',
          );

          public function widget($args, $instance)
          {
                    echo $args['before_widget'];
                    if (!empty($instance['title'])) {
                              echo $args['before_title'] .
                                        apply_filters('widget_title', $instance['title']) .
                                        $args['after_title'];
                    }
                    ?>
                    <section class="card">
                              <div class="clock card-body">
                                        <span id="time"></span>
                                        <span id="ampm"></span>
                                        <span id="time-emoji"></span>
                              </div>
                    </section>
                    <?php
                    echo '<div class="textwidget">';
                    echo esc_html(__($instance['text'], 'YOYO-Tube'));
                    echo '</div>';
                    echo $args['after_widget'];
          }

          public function form($instance)
          {
                    $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Clock', 'yoyo-tube');
                    //  default value          
                    $text = !empty($instance['text']) ? $instance['text'] : esc_html__('Clock text here...', 'yoyo-tube');
                    ?>
                    <p>
                              <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                                        <?php echo esc_html__('Title:', 'yoyo-tube'); ?>
                              </label>
                              <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                                        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                                        value="<?php echo esc_attr($title); ?>">
                    </p>
                    <p>
                              <label for="<?php echo esc_attr($this->get_field_id('text')); ?>">
                                        <?php echo esc_html__('Text:', 'yoyo-tube'); ?>
                              </label>
                              <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                                        name="<?php echo esc_attr($this->get_field_name('text')); ?>" cols="30"
                                        rows="10"><?php echo esc_attr($text); ?></textarea>
                    </p>
                    <?php
          }

          public function update($new_instance, $old_instance)
          {
                    $instance = array();
                    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
                    $instance['text'] = (!empty($new_instance['text'])) ? $new_instance['text'] : '';
                    return $instance;
          }
}
