//プロフィール欄でHTMLコードを使えるようにする
remove_filter('pre_user_description', 'wp_filter_kses');

//YSE・NOチャート
if ( !function_exists( 'p_yesno_chart' ) ):
function p_yesno_chart() {
echo <<< EOM
<script>
jQuery('.yn-chart a').click(function() {
jQuery(this).closest('div').css('display', 'none');
id = jQuery(this).attr('href');
jQuery(id).fadeIn('fast');
return false;
})
</script>
EOM;
}
add_action( 'wp_print_footer_scripts', 'p_yesno_chart' );
endif;