<?php

defined( 'ABSPATH' ) || exit();

/**
 * Shortcode to display price plan table with ACF
 */
add_shortcode ('price_table_acf', 'price_table_function' );
function price_table_function() {
	ob_start();
	$FirstCurrency = get_field('main_currency', 'option');
	$SecondCurrency = get_field('second_currency', 'option');
	$ExchangeRate = get_field('exchange-rate', 'option');
	$otherCurrency = get_field('other_currency', 'option');
	$PeriodMultiplier = get_field('period_multiplier', 'option');
	$MainFrequency = get_field('main_frequency', 'option');
	$SecondFrequency = get_field('second_frequency', 'option');
	// Check rows exists.
	if( have_rows('plan', 'option') ): ?>
	<style>
	:root {
	--bg-color:<?php the_field('background_color','option');?>;
	--bg-color-feat:<?php the_field('background_color_feat','option');?>;
	--title:<?php the_field('title_color','option');?>;
	--title-feat:<?php the_field('title_color_feat','option');?>;
	--description:<?php the_field('description_color','option');?>;
	--description-feat:<?php the_field('description_color_feat','option');?>;
	--price:<?php the_field('price_color','option');?>;
	--price-feat:<?php the_field('price_color_feat','option');?>;
	--color:<?php the_field('font_color','option');?>;
	--color-feat:<?php the_field('font_color_feat','option');?>;
	--bar-color:<?php the_field('separate_bar_color','option');?>;
	--bar-color-feat:<?php the_field('separate_bar_color_feat','option');?>;
	--bg-button:<?php the_field('background_button','option');?>;
	--color-button:<?php the_field('font_color_button','option');?>;
	--bg-button-hover:<?php the_field('background_button_hover','option');?>;
	--color-button-hover:<?php the_field('font_color_button_hover','option');?>;
	
	--title-size:<?php the_field('title_font_size','option');?>px;
	--description-size:<?php the_field('description_font_size','option');?>px;
	--price-size:<?php the_field('price_font_size','option');?>px;
	--body-size:<?php the_field('body_font_size','option');?>px;
	--border-size:<?php the_field('border_width','option');?>px;
	}
	</style>
	<div id="table-price-acf" class="section_table">
		<div class="toggles_opt">
			<?php if( get_field('subtitle_plan', 'option') ): ?>
			<p class="subtitle_plan"><?= get_field('subtitle_plan', 'option') ?></p>
			<?php endif; ?>
			<?php if( $PeriodMultiplier ): ?>
			<div class="toggle_options">
				<label><?= $MainFrequency["label"] ?></label>
				<div class="toggle-btn">
					<input type="hidden" id="PeriodMultiplier" name="PeriodMultiplier" value="<?= $PeriodMultiplier ?>">
					<input type="checkbox" class="checkbox_price" id="checkboxPeriod" onclick="planPeriod()" />
					<label class="sub" id="sub" for="checkboxPeriod">
					<div class="circle"></div>
					</label>
				</div>
				<label><?= $SecondFrequency["label"] ?></label>
			</div>
			<?php endif; ?>
			<?php if( $otherCurrency ): ?>
			<div class="toggle_options cur_opt">
				<span><?php _e('Show prices in','table-price-acf') ?></span>
				<label><?= $FirstCurrency['iso_code'] ?> </label>
				<div class="toggle-btn">
					<input type="checkbox" class="checkbox_price" id="checkboxCurrency" />
					<label class="sub" id="subCurrency" for="checkboxCurrency">
					<div class="circle"></div>
					</label>
				</div>
				<label> <?= $SecondCurrency['code_iso'] ?></label>
			</div>
			<?php endif; ?>
		</div>
		<div class="pricing_table cards">
		<?php
			// Loop through rows.
			while( have_rows('plan', 'option') ) : the_row();
				// Load sub field value.
				$title = get_sub_field('title_plan', 'option');
				$description = get_sub_field('description_plan', 'option');
				$price = get_sub_field('price', 'option');
				$featured  = get_sub_field('featured', 'option');
				$linkUrl = get_sub_field('link_to_buy', 'option');
				$linkLabel = get_sub_field('label_link', 'option');
				// Content ?>
				<div class="card shadow <?php echo ($featured == true) ? 'active' : ''; ?>">
					<h3 class="pack"><?= $title ?></h3>
					<p class="desc_plan"><?= $description ?></p>
					<ul class="list_pricing_table">
						<li id="formule" class="price-eur price bottom-bar"><span class="priceNb"><?= $price ?></span> <?= $FirstCurrency['symbol_cur'] ?>/<span class="period"><?= $MainFrequency["label"] ?></span></li>
						<li id="formuleCur" class="price-currency price bottom-bar"><span class="priceNb"><?= round($price*$ExchangeRate) ?></span> <?= $SecondCurrency['symbol_cur'] ?>/<span class="period"><?= $MainFrequency["label"] ?></span></li>
						<?php // Loop over sub repeater rows.
						if( have_rows('options_plan') ):
							while( have_rows('options_plan') ) : the_row();
								// Get sub value.
								$avalaible = get_sub_field('available', 'option');
								$label = get_sub_field('label_option', 'option'); ?>
								<li class="bottom-bar <?php echo ($avalaible == false) ? 'not_available' : ''; ?>"><?= $label ?></li>
							<?php endwhile;
						endif; ?>
					</ul>
					<?php if ($linkUrl) : ?>
					<a class="plan_button" href="$linkUrl" target="self"><?= $linkLabel ?></a>
					<?php endif; ?>
				</div>
			<?php // End loop.
			endwhile; ?>
		</div>
	</div>
	<?php else : ?>
		<p><?php _e('Don\'t forget to build your pricing table','table-price-acf') ?></p>
	<?php endif; 
	return ob_get_clean();    
}