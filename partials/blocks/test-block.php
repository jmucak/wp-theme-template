<?php
/**
 *
 * Here add all variables you passed from acf
 * @var string $test_block
 * @var int $image
 *
 */

?>

<div style="background-color: red;">
	<?php
	echo $test_block; ?>

	<?php
    if(!empty($image)) { ?>
        <img src="<?php echo wp_get_attachment_url($image) ?>" style="width: 500px" alt="">
    <?php }
    
//	echo get_responsive_image( array(
//		'image' => $image,
//		'sizes' => array(
//			'desktop'        => 'image_1000',
//			'desktop_retina' => 'image_1000',
//			'mobile'         => 'image_200',
//			'mobile_retina'  => 'image_200',
//		),
//		'urls'  => array(
//			'desktop'        => 'https://picsum.photos/id/236/1440/1440',
//			'desktop_retina' => 'https://picsum.photos/id/236/1920/1920',
//			'mobile'         => 'https://picsum.photos/id/234/600/600',
//			'mobile_retina'  => 'https://picsum.photos/id/234/900/900',
//		)
//	) );
	?>
</div>
