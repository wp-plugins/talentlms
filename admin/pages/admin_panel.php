<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<div class="wrap">
	<div class="tl-admin-content">
	
		<div class="tl-admin-header">
			<!-- <img alt="Talentlms" src="<?php echo plugins_url( 'img/talentlms-header.png', dirname(dirname(__FILE__)) ); ?>">
			 -->
		</div><!-- .tl-admin-header -->
	
		<div class="tl-admin-options">
	
			<h2>Welcome! Let's integrate TalentLMS with WordPress</h2>
	
			<br />
			<br />
		
			<div class="tl-admin-options-grid">
				<a href="<?php echo admin_url('admin.php?page=talentlms-setup'); ?>">
					<div class="tl-admin-option">
						<i class="fa fa-cog fa-3x"></i>
						<h3>Setup</h3>
						<p>Connect TalentLMS with your WordPress site</p>
					</div>
				</a>
				<a href="<?php echo admin_url('admin.php?page=talentlms-options'); ?>">
					<div class="tl-admin-option">
						<i class="fa fa-check-square-o fa-3x"></i>
						<h3>Options</h3>
						<p>Customize the plugin behavior</p>
					</div>
				</a>
				<a href="<?php echo admin_url('admin.php?page=talentlms-sync'); ?>">
					<div class="tl-admin-option">
						<i class="fa fa-link fa-3x"></i>
						<h3>Sync</h3>
						<p>Synchronize users and content</p>			
					</div>
				</a>
				<a href="<?php echo admin_url('admin.php?page=talentlms-css'); ?>">
				<div class="tl-admin-option">
					<i class="fa fa-check-square-o fa-3x"></i>
					<h3>CSS</h3>
					<p>Customize the plugin appearance</p>			
				</div>
				</a>
				<a href="javascript:void(0);">
				<div class="tl-admin-option" data-toggle="modal" data-target="#shortcodesModal">
					<i class="fa fa-code fa-3x"></i>
					<h3>Shortcodes</h3>
					<p>Widgets to use with your WordPress site.</p>			
				</div>
				</a>
				<a href="javascript:void(0);">
				<div class="tl-admin-option" data-toggle="modal" data-target="#helpModal">
					<i class="fa fa-question-circle fa-3x"></i>
					<h3>Help</h3>
					<p>Instructions and best practices</p>	
				</div>
				</a>
			</div>
		</div><!-- tl-admin-options -->
		
		
		<div class="tl-admin-footer">
		</div><!-- .tl-admin-footer -->	
	
		<div class="modal" id ="shortcodesModal" aria-labelledby="modal-label" tabindex="0">
			<span id="modal-label" class="screen-reader-text"><?php _e('Press Esc to close.'); ?></span>
			<a href="#" class="close" data-dismiss="modal">&times; <span class="screen-reader-text"><?php _e('Close modal window'); ?></span></a>
			<div class="content-container ">
				<div class="content">
					<h2>ShortCodes</h2>
					<p><?php _e('Here is a list of all available shortcodes with the TalentLMS WordPress plugin. Use these shortcodes in any WordPress posts or pages'); ?></p>
					<ul>
						<li>
							<p><strong>[talentlms-courses]</strong>&nbsp;<?php _e('Shortcode for listing your TalentLMS courses.'); ?></p>
						</li>
    					<li>
    						<p><strong>[talentlms-signup]</strong>&nbsp;<?php _e('Shortcode for outputing a signup to TalentLMS form.'); ?></p>
    					</li>
    					<li>
    						<p><strong>[talentlms-forgot-credentials]</strong>&nbsp;<?php _e('Shortcode for a forgot your TalentLMS username/password form'); ?></p>
    					</li>
    					<li>
    						<p><strong>[talentlms-login]</strong>&nbsp;<?php _e('Shortcode for a login to TalentLMS form'); ?></p>
    					</li>
					</ul>
					
				</div>
			</div>
			<footer>
				<ul>
					<li>
						<span class="activate">
						<a class="button-primary" href="#" data-dismiss="modal">Close</a>
						</span>
					</li>
				</ul>
			</footer>		
		</div>
		
		<div class="modal" id ="helpModal" aria-labelledby="modal-label" tabindex="0">
			<span id="modal-label" class="screen-reader-text"><?php _e('Press Esc to close.'); ?></span>
			<a href="#" class="close" data-dismiss="modal">&times; <span class="screen-reader-text"><?php _e('Close modal window'); ?></span></a>
			<div class="content-container ">
				<div class="content">
					<h2><?php _e('Help');?></h2>
					<p><strong>TalentLMS</strong><?php _e(' is a super-easy, cloud-based learning platform to train your people and customers. This WordPress plugin is a tool you can use to diplay your TalentLMS content in WordPress.')?></p>
					<p><?php _e('For more information');?>:</p>
					<ul>
						<li>
							<p><strong>TalentLMS:</strong>&nbsp;<a href="http://www.talentlms.com/" target="_blank">www.talentlms.com</a></p>
						</li>
						<li>
							<p><strong>TalentLMS blog:</strong>&nbsp;<a href="http://blog.talentlms.com/" target="_blank">blog.talentlms.com</a></p>
						</li>						
						<li>
							<p><strong>Support:</strong>&nbsp;<a href="http://support.talentlms.com/" target="_blank">support.talentlms.com</a></p>
						</li>
						<li>
							<p><strong>Contact:</strong>&nbsp;<a href="mailto: support@talentlms.com" target="_blank">support@talentlms.com</a> or use our <a href="http://www.talentlms.com/contact" target="_blank"> contact form</a></p>
						</li>
					</ul>
				</div>
			</div>
			<footer>
				<ul>
					<li>
						<span class="activate">
						<a class="button-primary" href="#" data-dismiss="modal">Close</a>
						</span>
					</li>
				</ul>
			</footer>		
		</div>		
		
<!--     
    <h3><?php //_e('Cache control'); ?></h3>
    <form name="tl-cache-form" method="post" action="<?php //echo admin_url('admin.php?page=talentlms'); ?>">
        <input type="hidden" name="action" value="tl-cache">
        <table class="form-table">
            <tr>
                <th scope="row" class="form-field" style="width: 30em;">
                    <?php _e('Clearing the cache will force contacting your Talentlms domain'); ?>
                </th>
                <td class="form-field">
                    <input class="button-secondary" type="submit" name="Clear cache" value="<?php _e('Clear cache' ) ?>" style="width: 8.5em;" />
                </td>
            </tr>
        </table>
    </form>
-->
 
 
	</div><!-- .tl-admin-content -->
		
</div><!-- .wrap -->