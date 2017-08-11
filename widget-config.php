<?php
/**
 * This file could be used to catch submitted form data. When using a non-configuration
 * view to save form data, remember to use some kind of identifying field in your form.
 */
    $number = ( isset( $_POST['number'] ) ) ? stripslashes( $_POST['number'] ) : '';
    self::update_dashboard_widget_options(
            self::wid,                                  //The  widget id
            array(                                      //Associative array of options & default values
                'category_number' => $number,
            )
    );

?>

<p>This is the configuration part of the widget. Create category for administration guide purpose posts. Use those category for posting info. Get category id of administrator category and set it through this input filed. <tt style="display: none;"><?php echo __FILE__ ?></tt></p>
<p><input type="text" name="number" />
</p>