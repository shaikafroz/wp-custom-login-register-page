<?php
/*
Plugin Name: wp custom-login
Plugin URI: http://niaj.me
Description: This is the plugin will help you to customize your login & register page.
Author: Niaj Morshed
Author URI: http://niaj.me
Version: 1.0.1
licence: GNU General Public License (GPL) version 2.
*/

function ncustom_login_option_page()
{
	?>

	<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Custom Login Option Page</h2>
	<p>Welcome to the custom login plugin. Here you can edit the background &amp; your Logo for your custom login page.</p>
	<form action="options.php" method="post" id="ncustom-login-options-form">
	<?php settings_fields('ncustom_login_options'); ?>
		<p>
			<b>Link of admin login logo image</b><br />
			<input type="text" id="n_logo_link" name="n_logo_link" value="<?php echo esc_attr( get_option('n_logo_link') ); ?>" size="80" />
		</p>
		<p>
			<b>Link of admin login background image</b><br />
			<input type="text" id="n_background_link" name="n_background_link" value="<?php echo esc_attr( get_option('n_background_link') ); ?>" size="80" />
		</p>
		<p>
			<input type="submit" value="Save images Link">
		</p>
	</form>
	</div>
	<?php
}

function ncustom_login_init(){
	register_setting('ncustom_login_options','n_logo_link');
	register_setting('ncustom_login_options','n_background_link');
}

add_action('admin_init','ncustom_login_init');

function ncustom_login_menu()
{
	add_options_page('Custom Login Settings','Custom Login','manage_options','custom-login','ncustom_login_option_page');
}
add_action('admin_menu','ncustom_login_menu');

/*---------------------------*/

function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return '';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function my_login_stylesheet() { ?>
    <link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo get_bloginfo('url') . '/wp-content/plugins/wp-custom-login-register-page/style-login.css'; ?>" type="text/css" media="all" />
<?php }
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );



/*------------ Get custom Images ----------------*/
function n_login_css() {
	$n_logo_link = esc_attr( get_option('n_logo_link') );
	$n_background_link = esc_attr( get_option('n_background_link') );
	if($n_logo_link != '')
	{
		echo '<style type="text/css">
		#login h1 a { background: url('.$n_logo_link.')  no-repeat scroll 50% 50% transparent;}
		</style>';
	}else{
		echo '<style type="text/css">
		#login h1 a { background: url('.get_bloginfo("url").'/wp-content/plugins/wp-custom-login-register-page/images/logo.png)  no-repeat scroll 50% 50% transparent; }
		</style>';
	}

	if($n_background_link != '')
	{
		echo '<style type="text/css">
		html { background: url('.$n_background_link.') no-repeat 50% 50% fixed;
		background-size: 100% auto;
		}
		</style>';
	}else{
		echo '<style type="text/css">
		html { background: url('.get_bloginfo("url").'/wp-content/plugins/wp-custom-login-register-page/images/bg1.jpg) no-repeat 50% 50% fixed;
		background-size: 100% auto;
		}
		</style>';
	}
}

add_action('login_enqueue_scripts', 'n_login_css');