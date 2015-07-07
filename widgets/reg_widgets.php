<?php
require_once (_BASEPATH_ . '/widgets/talentlms_login_widget.php');

function register_widgets()
{
    register_widget('TalentLMS_login');
}
    
add_action( 'widgets_init', 'register_widgets' );
?>