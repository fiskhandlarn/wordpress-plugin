<?php

/*
 * mailgun-wordpress-plugin - Sending mail from Wordpress using Mailgun
 * Copyright (C) 2016 Mailgun, et al.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

class list_widget extends \WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            // Base ID of your widget
            'list_widget',
            // Widget name will appear in UI
            __('Mailgun List Widget', 'wpb_widget_domain'),
            // Widget description
            array('description' => __('Mailgun list widget', 'wpb_widget_domain'))
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {
        global $mailgun;

        if (!isset($instance['list_address']) || !$instance['list_address']) {
            return;
        }
        // vars
        $list_address = apply_filters('list_address', $instance['list_address']);

        if (isset($instance['collect_name'])) {
            $args['collect_name'] = true;
        }

        if (isset($instance['list_title'])) {
            $args['list_title'] = $instance['list_title'];
        }

        if (isset($instance['list_description'])) {
            $args['list_description'] = $instance['list_description'];
        }

        $mailgun->list_form($list_address, $args, $instance);
    }

    // Widget Backend
    public function form($instance)
    {
        global $mailgun;

        if (isset($instance['list_address'])) {
            $list_address = $instance['list_address'];
        } else {
            $list_address = __('New list_address', 'wpb_widget_domain');
        }

        if (isset($instance['collect_name']) && $instance['collect_name'] === 'on') {
            $collect_name = 'checked';
        } else {
            $collect_name = '';
        }

        $list_title = isset($instance['list_title']) ? $instance['list_title'] : null;
        $list_description = isset($instance['list_description']) ? $instance['list_description'] : null;

        // Widget admin form
        ?>
        <div class="mailgun-list-widget-back">
            <p>
                <label for="<?php echo $this->get_field_id('list_title'); ?>"><?php _e('Title (optional):'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('list_title'); ?>" name="<?php echo $this->get_field_name('list_title'); ?>" type="text" value="<?php echo esc_attr($list_title); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('list_description'); ?>"><?php _e('Description (optional):'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('list_description'); ?>" name="<?php echo $this->get_field_name('list_description'); ?>" type="text" value="<?php echo esc_attr($list_description); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('list_address'); ?>"><?php _e('List addresses (required):'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('list_address'); ?>" name="<?php echo $this->get_field_name('list_address'); ?>" type="text" value="<?php echo esc_attr($list_address); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('collect_name'); ?>"><?php _e('Collect name:'); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id('collect_name'); ?>" name="<?php echo $this->get_field_name('collect_name'); ?>" type="checkbox" <?php echo esc_attr($collect_name); ?> />
            </p>
        </div>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance = $new_instance;

        return $instance;
    }
}
