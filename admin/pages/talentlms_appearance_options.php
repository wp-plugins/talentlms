<div class="wrap">
    <div id="icon-edit-pages" class="icon32">
    </div>
    <?php if($_POST['action'] == "post") : ?>
        <?php if($_POST['courses-per-page'] < 0):?>
            <div id='talentlms-edit-css-message' class='error fade'>
                <p><?php _e('Courses per page must be positive number'); ?></p>
            </div>
        <?php elseif($_POST['show-course-list-description-limit'] < 0) : ?>
            <div id='talentlms-edit-css-message' class='error fade'>
                <p><?php _e('Description limit must be positive number'); ?></p>
            </div>
        <?php elseif($_POST['show-user-list-bio-limit'] < 0) : ?>
            <div id='talentlms-edit-css-message' class='error fade'>
                <p><?php _e('Bio limit must be positive number'); ?></p>
            </div>                                       
        <?php else: ?>
            <div id='talentlms-edit-css-message' class='updated fade'>
                <p><?php _e('Details edited successfully.'); ?></p>
            </div>
        <?php endif; ?> 
    <?php endif; ?>    
    <h2><?php echo __('TalentLMS Choose Templates'); ?></h2>
    
    <form name="talentlms-courses-template-form" method="post" action="<?php echo admin_url('admin.php?page=talentlms-appearance-options'); ?>">
        <input type="hidden" name="action" value="post">
        <h3><?php _e('Courses Page: '); ?></h3>
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field">
                    <label for="courses-per-page"><?php _e('Courses per page: '); ?></label>
                </th>
                <td class="form-field">
                    <input id="courses-per-page" name="courses-per-page" value="<?php echo get_option('talentlms-courses-per-page'); ?>" style="width: 2.5em;" />
                    <span class="description"><?php _e("Using this will enable pagination"); ?> </span>
                </td>                
            </tr>
            <tr>
                <th scope="row" class="form-field">
                </th>
                <td class="form-field">
                    <?php _e("Top pagination"); ?>
                    <?php if (get_option('talentlms-courses-top-pagination')): ?>
                        <input id="top-pagination" name="top-pagination" value="1" type="checkbox" style="width: 1.5em;" checked="checked"/>
                    <?php else : ?>
                        <input id="top-pagination" name="top-pagination" value="1" type="checkbox" style="width: 1.5em;" />
                    <?php endif; ?>
                    <?php _e("Bottom pagination"); ?>
                    <?php if (get_option('talentlms-courses-bottom-pagination')): ?>
                        <input id="bottom-pagination" name="bottom-pagination" value="1" type="checkbox" style="width: 1.5em;" checked="checked"/>
                    <?php else : ?>
                        <input id="bottom-pagination" name="bottom-pagination" value="1" type="checkbox" style="width: 1.5em;" />
                    <?php endif; ?>                    
                </td>                
            </tr>            
            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('Choose courses list template: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('talentlms-courses-template') == 'categories-right-courses-left'): ?>
                    <input type="radio" name="courses-template" value="categories-right-courses-left" style="width: 2.5em;" checked="checked"><?php _e("Courses on the left - Categories on the right"); ?><br />
                    <?php else: ?>
                    <input type="radio" name="courses-template" value="categories-right-courses-left" style="width: 2.5em;"><?php _e("Courses on the left - Categories on the right"); ?><br />    
                    <?php endif; ?>

                    <?php if(get_option('talentlms-courses-template') == 'categories-left-courses-right'): ?>                    
                    <input type="radio" name="courses-template" value="categories-left-courses-right" style="width: 2.5em;" checked="checked"><?php _e("Courses on the right - Categories on the left"); ?><br />
                    <?php else: ?>
                    <input type="radio" name="courses-template" value="categories-left-courses-right" style="width: 2.5em;"><?php _e("Courses on the right - Categories on the left"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('talentlms-courses-template') == 'categories-top-courses-bottom'): ?>
                    <input type="radio" name="courses-template" value="categories-top-courses-bottom" style="width: 2.5em;" checked="checked"><?php _e("Courses on the bottom - Categories on top"); ?><br />
                    <?php else: ?>
                    <input type="radio" name="courses-template" value="categories-top-courses-bottom" style="width: 2.5em;"><?php _e("Courses on the bottom - Categories on top"); ?><br />                        
                    <?php endif; ?>

					<br />

                    <?php if(get_option('talentlms-show-course-list-thumb')): ?>
                    <input type="checkbox" name="show-course-list-thumb" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show courses thumbnails"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-course-list-thumb" value="1" style="width: 2.5em;"><?php _e("Show courses thumbnails"); ?><br />    
                    <?php endif; ?>
                                        
                    <?php if(get_option('talentlms-show-course-list-description')): ?>
                    <input type="checkbox" name="show-course-list-description" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show courses description"); ?> 
                    <?php else: ?>
                    <input type="checkbox" name="show-course-list-description" value="1" style="width: 2.5em;"><?php _e("Show courses description"); ?>    
                    <?php endif; ?>
					
					<br />
					<?php _e('Limit description by number of words'); ?>
                    <input type="text" name="show-course-list-description-limit" value="<?php echo get_option('talentlms-show-course-list-description-limit'); ?>" style="width: 2.5em;" />
                    <span class="description"><?php _e("Leave empty for full description"); ?> </span>
                    
                    <br />
                    <?php if(get_option('talentlms-show-course-list-price')): ?>
                    <input type="checkbox" name="show-course-list-price" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show courses price"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-course-list-price" value="1" style="width: 2.5em;"><?php _e("Show courses price"); ?><br />    
                    <?php endif; ?>                    
                </td>                
            </tr>

            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('Single course template: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('talentlms-show-course-description')): ?>
                    <input type="checkbox" name="show-course-description" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course description"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-course-description" value="1" style="width: 2.5em;"><?php _e("Show course description"); ?><br />    
                    <?php endif; ?>

                    <?php if(get_option('talentlms-show-course-price')): ?>
                    <input type="checkbox" name="show-course-price" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course price"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-course-price" value="1" style="width: 2.5em;"><?php _e("Show course price"); ?><br />    
                    <?php endif; ?>

                    <?php if(get_option('talentlms-show-course-instructor')): ?>
                    <input type="checkbox" name="show-course-instructor" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course instructors"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-course-instructor" value="1" style="width: 2.5em;"><?php _e("Show course instructors"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('talentlms-show-course-units')): ?>
                    <input type="checkbox" name="show-course-units" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course content"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-course-units" value="1" style="width: 2.5em;"><?php _e("Show course content"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('talentlms-show-course-rules')): ?>
                    <input type="checkbox" name="show-course-rules" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course rules"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-course-rules" value="1" style="width: 2.5em;"><?php _e("Show course rules"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('talentlms-show-course-prerequisites')): ?>
                    <input type="checkbox" name="show-course-prerequisites" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show course prerequisites"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-course-prerequisites" value="1" style="width: 2.5em;"><?php _e("Show course prerequisites"); ?><br />    
                    <?php endif; ?>
                </td>                
            </tr>
            
            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('Users template: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('talentlms-show-user-list-avatar')): ?>
                    <input type="checkbox" name="show-user-list-avatar" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show users avatar"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-user-list-avatar" value="1" style="width: 2.5em;"><?php _e("Show users avatar"); ?><br />    
                    <?php endif; ?>

                    <?php if(get_option('talentlms-show-user-list-bio')): ?>
                    <input type="checkbox" name="show-user-list-bio" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show users bio"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-user-list-bio" value="1" style="width: 2.5em;"><?php _e("Show users bio"); ?><br />    
                    <?php endif; ?>
                    
					<?php _e('Limit bio by number of words'); ?>
                    <input type="text" name="show-user-list-bio-limit" value="<?php echo get_option('talentlms-show-user-list-bio-limit'); ?>" style="width: 2.5em;" />
                    <span class="description"><?php _e("Leave empty for full bio"); ?> </span>
                </td>                
            </tr>

            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('Single user template: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('talentlms-show-user-bio')): ?>
                    <input type="checkbox" name="show-user-bio" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show user bio"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-user-bio" value="1" style="width: 2.5em;"><?php _e("Show users bio"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('talentlms-show-user-email')): ?>
                    <input type="checkbox" name="show-user-email" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show user email"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-user-email" value="1" style="width: 2.5em;"><?php _e("Show users bio"); ?><br />    
                    <?php endif; ?>
                    
                    <?php if(get_option('talentlms-show-user-courses')): ?>
                    <input type="checkbox" name="show-user-courses" value="1" style="width: 2.5em;" checked="checked"><?php _e("Show user courses"); ?><br />
                    <?php else: ?>
                    <input type="checkbox" name="show-user-courses" value="1" style="width: 2.5em;"><?php _e("Show users bio"); ?><br />    
                    <?php endif; ?>                                                           
                </td>                
            </tr>                         
        </table>

        <h3><?php _e('Signup Page: '); ?></h3>
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field">
                    <label><?php _e('After a user signs up: '); ?></label>
                </th>
                <td class="form-field">
                    <?php if(get_option('talentlms-after-signup') == 'redirect'): ?>
                        <input type="radio" name="after-signup" value="redirect" style="width: 2.5em;" checked="checked"><?php _e("Redirect user to TalentLMS"); ?><br />
                    <?php else: ?>
                        <input type="radio" name="after-signup" value="redirect" style="width: 2.5em;"><?php _e("Redirect user to TalentLMS"); ?><br />
                    <?php endif; ?>
                    <?php if(get_option('talentlms-after-signup') == 'stay'): ?>
                        <input type="radio" name="after-signup" value="stay" style="width: 2.5em;" checked="checked"><?php _e("Stay in Wordpress"); ?><br />
                    <?php else: ?>
                        <input type="radio" name="after-signup" value="stay" style="width: 2.5em;"><?php _e("Stay in Wordpress"); ?><br />
                    <?php endif; ?>     
                         
                </td>                
            </tr>
        </table>

        <p class="submit">
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Submit' ) ?>" />
        </p>         
    </form>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#courses-per-page").blur(function() {
			if (jQuery(this).val()) {
				jQuery('#bottom-pagination').prop('checked', true);
			} else {
				jQuery('#top-pagination').prop('checked', false);
				jQuery('#bottom-pagination').prop('checked', false);
			}
		});
	});
</script>