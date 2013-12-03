var addToHomeConfig = {
	message: wptouchFdnAddToHome.bubbleMessage,			// The message shown (configured in admin)
	expire: wptouchFdnAddToHome.bubbleExpiryInDays,		// Days to wait before showing the popup again (0 = always displayed)
	autostart: true,																				// Automatically open the balloon
	returningVisitor: false,																	// Show the balloon to returning visitors only (setting this to true is HIGHLY RECCOMENDED)
	startDelay: 1000,																			// Milliseconds
	lifespan: 1000*60,																		// 60 seconds before it is automatically destroyed
	animationIn: 'bubble',																	// drop || bubble || fade
	animationOut: 'fade',																	// drop || bubble || fade
	touchIcon: true																				// Display the homescreen icon
};