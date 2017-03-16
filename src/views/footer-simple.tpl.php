        </div><!-- .content-small -->
        
        <footer class="footer">
			
			<div class="wrap">
				
				<div class="footer-logo">
					<img src="/assets/img/elements/logo_white.png" alt="Hive Charitable Foundation" />
				</div>
				
				<div class="footer-legal">
                    
                    <p>Golf for Good is a Hive Charitable Foundation fundraising event. All donations are received by the Hive Charitable Foundation and redistributed to the participating charities.</p>

                    <p>The Hive Charitable Foundation is a registered Canadian Foundation that grants funds to qualified registered charities.</p>
                    
				</div>
				
		
				<div class="contentinfo">
					<p class="footer-charity-number">Canadian Charity Number: <?php echo $config->get('charity_number'); ?></p>
					<p class="copyright">&copy; <?php echo date('Y'); ?> <a href="/">golf4good.golf</a></p>
				</div>
			
			</div><!-- .wrap -->
	
		</footer>

	</div> <!-- .container -->
<?php
	
//Include analytics.
if ( isset( $analytics ) ) {
    echo $analytics;
}

?>
</body>
</html>