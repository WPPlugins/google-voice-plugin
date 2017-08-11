<?php
/**
 * FooWidget Class
 */
class GVWidget extends WP_Widget {
    /** constructor */
    function GVWidget() {
        parent::WP_Widget(false, $name = 'Google Voice CallMe');  
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {     
        extract( $args );
        ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title;
                        if ($instance['title'])
                             echo $instance['title'];
                        echo $after_title; 
                   ?>
                 <?php echo $this->display($instance); ?>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {             
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {              
        $title = esc_attr($instance['title']);
        $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <hr width="90%"/>
            <p><strong><u>Do Not Disturb</u></strong></p>
            <p><strong>Current Time:</strong>&nbsp;<?php echo date('h:i a T');?></p> 
            <p><strong>Days of the Week:</strong></p>
            <?php
            foreach($days as $day)
            {
            ?>
            <div>
                <label for="<?php echo $this->get_field_id($day); ?>"><input id="<?php echo $this->get_field_id($day); ?>" name="<?php echo $this->get_field_name($day); ?>" type="checkbox" value="1" <?php echo $instance[$day] ? 'checked' : ''; ?>/><?php _e(ucwords($day)); ?></label><br/>
                <div align="right">Start: <?php $this->time_select($instance, $day.'-Start'); ?><br/></div>
                <div align="right">End: <?php $this->time_select($instance, $day.'-End'); ?><br/></div>
            </div>
            <?php
            }
    }

    function time_select($instance, $name, $class='')
    {
      ?> 
      <select name="<?php echo $this->get_field_name($name.'-Hour'); ?>" id="<?php echo $this->get_field_id($name.'-Hour'); ?>" class="<?php echo $class; ?>">
      <?php
      for ($i=1; $i <= 12; $i++)
      {
          echo "<option value='$i' ";
          echo $instance[$name.'-Hour'] == $i ? 'selected' : '';
          echo ">$i</option>";
      }
      ?>
      </select>
      <select name="<?php echo $this->get_field_name($name.'-Min'); ?>" id="<?php echo $this->get_field_id($name.'-Min'); ?>" class="<?php echo $class; ?>">
      <?php
      for ($i=0; $i <= 59; $i++)
      {
          if ($i < 10)
              $min = '0'.$i;
          else
              $min = $i;

          echo "<option value='$i' ";
          echo $instance[$name.'-Min'] == $i ? 'selected' : '';
          echo ">$i</option>";
      }
      ?>
      </select>
      <select name="<?php echo $this->get_field_name($name.'-Meridiem'); ?>" id="<?php echo $this->get_field_id($name.'-Meridiem'); ?>" class="<?php echo $class; ?>">
          <?php
          $cycle = array('am','pm');
          foreach ($cycle as $meridiem)
          {
              echo "<option value='$meridiem' ";
              echo $instance[$name.'-Meridiem'] == $meridiem ? 'selected' : '';
              echo ">$meridiem</option>";
          }
          ?> 
      </select>
      <?php 
    }

    function display($instance)
    {
        $day = date('l');
        // Is DND enabled for today?
        if ($instance[$day])
        {    
            // Get the current time
            $now = time();
    		// Build a string representation of the time
            $dnd_start = $instance[$day.'-Start-Hour'].':';
            $dnd_start .= $instance[$day.'-Start-Min'].' ';
            $dnd_start .= $instance[$day.'-Start-Meridiem'];		
            $dnd_end = $instance[$day.'-End-Hour'].':';
            $dnd_end .= $instance[$day.'-End-Min'].' ';
            $dnd_end .= $instance[$day.'-End-Meridiem'];        
            // Convert the time string to a timestamp
            $dnd_start = strtotime($dnd_start);
            $dnd_end = strtotime($dnd_end);
    
            // Does the current time fall between the DND start and end times?
            if ($dnd_start < $now && $now < $dnd_end)
                return get_option('google_voice_callme_dnd_html');
    		else
                return get_option('google_voice_callme_html');
        }
        // Show the CallMe widget if DND is not enabled for today
        else
            return get_option('google_voice_callme_html');
	}
} // class GVWidget

// register GVWidget widget
add_action('widgets_init', create_function('', 'return register_widget("GVWidget");'));

?>
