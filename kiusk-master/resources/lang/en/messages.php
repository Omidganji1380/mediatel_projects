<?php

return [
    'unknown_error_message' => 'unfortunately there has been a problem. ' . PHP_EOL .' Please contact the support.',
    'cart_description' => 'You can create :limit Ads and :featured_limit special Ads in :days days',
    'login_message' => 'Creating ads is only possible for site members. <br> If you are already a member of the site, log in and otherwise register on the site',
    'login_success' => 'You have successfully logged in',
    'login_error' => 'There is no user with this specification.',
    'register_message' => 'Your personal information will be used in your order process and your support experience in this website, and for other perpuses that explained in the privacy policy page.',
    'comment_title' => 'Be the first to write a review for “:title”',
    'comment_username' => 'Logged in as :username',
    'comment_login_message' => '<b><a href=":url">Login</a></b> first to submit a comment.',
    'rate_login_message' => '<b><a href=":url">Login</a></b> first to rate.',
    'comment_limit_error' => 'You have already commented today. Please try again tomorrow.',
    'commet_complete_profile_error' => 'Please complete your profile before proceeding.',
    'register_success' => 'Registerd successfully.',
    'register_success_with_referral' => 'Registerd successfully. You have won :point points with ":code" code.',
    'service_usage_success' => 'Your request has been submitted. Our admins will check it and send you the result as soon as possible.',
    'google_review_success' => 'Your review has been submitted. Our admins will check it and send you the result as soon as possible.',
    'upload_video_success' => 'Your video has been submitted. Our admins will check it and send you the result as soon as possible.',
    'self_chat_restriction' => 'You can\'t send message to your own Ad',
    'forgot_password_text' => 'If you have forgotten your password, enter the following password to recover your password.',
    'forgot_password_sms' => '
    To change the password of the Kiusk account, enter the following code:
        :token
    ',
    'forgot_password_error' => 'The phone number or email entered was not found.',
    'logout' => 'You have logged out successfully.',
    'something_went_wrong' => 'Something wen wrong. Please try again.',
    'confirmed' => 'Confirmed',
    'not_confirmed' => 'Not Confirmed',
    'accept_rules' => 'I have carefully read the <a href="/site-rules">terms and conditions</a> of the Kiusk platform and accept the rules.',
    'weeks' => '{1} :weeks week|[2, *] :weeks weeks',

    'errors' => [
        500 => 'We\'re sorry, but something went wrong on our end and we\'re unable to process your request at this time. Please try again later or contact us if the problem persists.'
    ],

    'report' => [
        // 'intro' => 'We hope this email finds you well. We wanted to provide you with an update on the performance of your ads, social links, and scores, as well as any unread messages you may have. Here\'s a summary of the weekly and monthly reports:'
        'daily_intro' => 'Here\'s your daily report:',
        'daily_content' => '
            - Total views of your ads: :adViews
            - Total comments on your ads: :adComments

            Thank you for using our service!
        ',
        'visit' => 'Visit our website',
        'read_message' => 'Read message',
        'intro' => 'Here\'s a summary of the weekly and monthly reports:',
        'report_body' => '
            1. Website and Social Media Clicks
                - Weekly count: :linkClicksWeeklyCount
                - Monthly count: :linkClicksMonthlyCount
            2. Ads Review
                - Weekly count: :reviewsVisibleWeeklyCount
                - Monthly count: :reviewsVisibleMonthlyCount
            3. Ads Service Usage
                - Weekly count: :serviceUsagesConfirmedWeeklyCount
                - Monthly count: :serviceUsagesConfirmedMonthlyCount
            4. Messages
                - Weekly count: :messagesWeeklyCount
                - Monthly count: :messagesMonthlyCount
            5. Scores (Claimed)
                - Weekly: :claimedScoresWeeklySum
                - Monthly: :claimedScoresMonthlySum
            6. Scores (Unclaimed)
                - Weekly: :unclaimedScoresWeeklySum
                - Monthly: :unclaimedScoresMonthlySum
            7. Scores (Spend)
                - Weekly: :spentScoresWeeklySum
                - Monthly: :spentScoresMonthlySum
        ',
    ],

    'ads' => [
        'delete' => 'Would you like to remove your ad?',
        'created_ad_notification' => 'Your ad has been created successfully. Our administrators will review it and confirm it as soon as possible. Once your ad is confirmed, it will be visible to other users. Thank you for using our service!',
        'approved' => 'Your ad has been approved and will be visible to users. For better visibility, consider upgrading your ad.',
        'title' => 'By upgrading to the <a href="/my-account/upgrade">VIP</a> user level, in addition to registering ads in all branches, you can publish up to three ads in a special way.',
        // 'title' => 'By upgrading to <a href="/my-account/upgrade">VIP</a> or <a href="/my-account/upgrade">VIP Business</a> user level, you will be able to upgrade three or more ads with special conditions.',
        'promote_confirm_title' => 'Are you sure you want to promote this ad?',
        'promote_confirm_text' => 'After confirmation you will not be able to change it.',
        'promote_success' => 'Ad promoted successfully.',
        'promote_limit_error' => 'You have reached your plan\'s featured limit. If you want to promote your ad purchase or upgrade your plan.',
    ],

    'categories' => [
        'types' => [
            'all' => 'All',
            'customer' => 'Regular Customer',
            'business_owner' => 'Business',
            'real_estate' => 'Property',
            'seller' => 'Used',
            'property_applicant' => 'Property Applicant',
            'vip' => 'VIP',
        ],
    ],

    'scores' => [
        'description' => 'As a Kiusk user, you can earn points through activities such as completing the user profile, commenting on advertisements or blogs, registering with referral codes, sending Google comments, sending videos, and entering feedback. These points not only represent your active interaction with the Kiusk platform, but also enable you to enjoy valuable discounts and rewards by using the points.',
        'usage_description' => 'When a user’s scores reach a specific amount, they can use the scores to get coupons. To get the coupons, they have to select a discount plan that matches their scores. The discount plan will determine how many coupons they can get and how much discount they can receive. This system is designed to reward users for their loyalty and encourage them to continue using the service.',
        'types' => [
            'comment' => 'Blog comments',
            'review' => 'Ad reviews',
            'rate' => 'Ad ratings',
            'referral' => 'Register with referral',
            'complete_registration' => 'Complete profile',
            'google_review' => 'Google review',
            'send_video' => 'Upload video',
            'service_usage' => 'Service usage',
        ],
        'emails' => [
            'title' => 'Congratulations on Your Score!',
            'subtitle' => 'Dear :name,',
            'body' => 'Congratulations on Your Score! You have earned :score points for :type in the Kiusk.',
            'regards' => 'Best regards,',
            'kiusk_team' => 'Kiusk Team',
        ],
        'limit_error' => 'The plan you choose requires more than your earned scores.',
        'unclaimed_scores_description' => 'Pending points are points that are required to be approved by site administrators. These points will be added to the related points section after being approved by site administrators.'

    ],

    // Flash messages
    'destroy' => ':name deleted successfully.',
    'create' => ':name created successfully.',
    'edit' => ':name updated successfully.',

    'profile' => [
        'edit' => 'Your profile has been edited successfully.',
        'upgraded_role' => 'Role has been upgraded successfully.',
        'upgrade_role_description' => 'By upgrading your level of access to VIP, you will be able to create ads in a variety of ad categories. In addition, you can also advertise in your specific field. Please note that upgrading your access level may incur additional charges. If you have any questions or concerns, please contact us.',
        'avatar_message' => 'Profile picture edited.',
        'avatar_delete_message' => 'The profile picture has been deleted.',
        'upgrade_error' => 'You can only change to the "vip" role if you are a real estate, business owner, or seller.',
    ],

    'video' => 'Video file saved successfully',

    'referral' => [
        'description' => 'Your referral code is a unique code that you can share with your friends and family. When someone uses your referral code to sign up for our service, you earn points that you can use for discounts.',
    ],

    'publish_ad_message' => 'Your ad has been successfully registered and will be published on the site after review and approval by the management.',
    'create_ad_pending' => "The ad has been created successfully. It will be published after approval.",
    'create_ad_pending_payment' => 'Ad successfully created. The ad will be approved and published after purchasing or upgrading the plan.',
    'payment_email' => 'Thanks for your purchase. A :duration days subscription has been created for you for $:price with reference number :reference_number',

    "verify_code_sms" => "Your verification code is :code",
    "mobile_verification_error" => "Your phone number is not verified",
    'email_verification_notification' => 'To verify your email enter the code below : :code',
    'email_notification_introduction' => 'Hi dear :name',
    'email_verified' => 'You have successfully verified your email',
    'phone_verified' => 'You have successfully verified your phone',
    'phone_verification_message' => 'Hello! Thank you for signing up for our service. Your verification code is :code. Please enter this code on our website to verify your phone number. If you did not sign up for our service, please ignore this message. https://kiusk.ca',
    'email_not_verified' => 'Sorry, your email could not be verified. The entered code does not match.',
    'phone_not_verified' => 'Sorry, your phone number could not be verified. The entered code does not match',
    'cart_description' => 'Display your ad in :show_in_main_page :show_in_suggestion :show_in_sidebar .',
    'cart_description_pin' => 'Will be Pin your ad in Telegram Channel, Instagram page and display in instagram highlight.',
    'ad_page_title' => 'Dear user, in order to register an advertisement on the Kiusk website, choose one of the following options.',
    'signup-phone' => 'Enter your mobile phone number to enter the advertisement registration process and click on the continue button. A verification code will be sent to you.',
    'sent_code' => 'We sent you a SMS to verify your phone number, please enter the code below.',
    'verify_phone_subheading' => 'Enter the verification code that we sent to your phone number.',
    'verify_email_error' => 'Sorry, you should verify your email before creating any ad.',
    'messages' => 'Messages',
    'unread_messages_count' => 'You have :count unread messages.',

    'plans' => [
        'show_in_sidebar' => 'Show ads in the ads sidebar',
        'show_in_suggestion' => 'Display ads in suggested ads',
        'show_in_main_page' => 'Display the ad as a special feature on the main page',
        'vip_show_in_main_page' => 'Display :count ads as a special feature on the main page',
        'pin_ad' => 'Display and pin your ad in Kiusk telegram channel.',
        'pin_ad_instagram' => 'Pin your ad in Kiusk instagram page.',
        'pin_ad_instagram_highlight' => 'Display your ad in Kiusk instagram highlights.',
        'motion_story' => 'Create story motion for this ad.',
        'story' => 'Display ads in Instagram stories, daily.',
        'free_blog_ad' => 'Free advertisement on the site counter',
        'telegram_group_ad' => 'Advertising in Telegram groups',
        'telegram_channel' => 'Display in Kiusk Telegram Channel, daily',
        'telegram_bot' => 'Display in Kiusk Telegram Bot, in every start request',
        'narration' => 'Making a motion graphic story with <span class="badge bg-danger">narration</span> for this ad',

        'intervals' => [
            'day' => '{1} Daily|[2,*] :count Days',
            'month' => '{1} Monthly |[2,*] :count Months',
            'year' => '{1} Yearly |[2,*] :count Years',
        ]
    ],

    'permissions' => [
        'create_ad_denied' => 'Sorry, it looks like you don’t have access to create an ad. Please upgrade your access level or contact the administrator for more information.',
    ],
    'area_unit' => [
        'square_meter' => 'Square Meter',
        'square_feet' => 'Square Feet'
    ],
    'area_unit_short' => [
        'square_meter' => 'Sq m',
        'square_feet' => 'Sq ft'
    ],
    'facilities' => [
        'facility' => 'Facility',
        'nearby_facility' => 'Nearby Facility',
        'building_facility' => 'Building Facility',
        'unit_facility' => 'Unit Facility',
        'parking' => 'Parking',
    ],
    'roles' => [
        'admin' => 'Admin',
        'super_admin' => 'Super Admin',
        'customer' => 'Customer',
        'subscriber' => 'Subscriber',
        'seo' => 'Seo Manager',
        'author' => 'Author',
        'business_owner' => 'Business Owner',
        'seller' => 'Goods Seller',
        'real_estate' => 'Real Estate',
        'vip' => 'VIP',
        'property_applicant' => 'Property Applicant',
    ],

    'statuses' => [
        'pending' => 'Pending',
        'replied' => 'Replied',
        'draft' => 'Draft',
        'published' => 'Published',
        'pending_payment' => 'Pending Payment',
        'payment_completed' => 'Payment Completed',
        'canceled' => 'Canceled',
        'expired' => 'Expired',
        'reported' => 'Reported',
    ],

    'payments' => [
        'statuses' => [
            'COMPLETED' => 'Completed',
            'CREATED' => 'Created',
            'CANCELED' => 'Canceled'
        ],
    ],

    'warnings' => [
        'edit_profile_title' => 'Dear user, fill in the following fields so that you can benefit from points-earning activities:',
        'first_name' => 'First Name is empty',
        'last_name' => 'Last Name is empty',
        'name' => 'Display Name is empty',
        'phone' => 'Phone Number is empty',
        'email' => 'Email Address is empty',
        'password' => 'Password is empty',
        'email_verified_at' => 'Email Address is not verified',
        'phone_verified_at' => 'Phone Number is not verified',
        'address' => 'Address is empty',
        'avatar' => 'Avatar is not set',
    ],

    //Telegram
    'telegram_bot_description' => 'After registering in the Telegram bot, it is possible to log in with the mobile number registered on the kiusk website.',
    'telegram' =>[
        'success' => [
            'normal_user' => 'Congratulations! You have successfully accessed the User role. You can now review the ads available on our platform. We hope you find the perfect offerings that meet your needs. Enjoy your browsing experience!',
            'real_estate' => 'Congratulations! You have been granted the Real Estate role. You can now create ads in the real estate category. Showcase your properties and rental listings to potential buyers and tenants. Start attracting interested individuals today!',
            'property_applicant' => 'Congratulations! You have been granted the property applicant role. You can now create a demand ad in the real estate category. If you are looking for a property with your desired personal characteristics, you can find your desired property in this way.!',
            'seller' => 'Congratulations! You have been granted the Seller role. You can now create ads in the selling goods category. Promote and sell your products to our platform\'s users. We wish you great success in your selling endeavors!',
            'business_owner' => 'Congratulations! You have successfully obtained the Business Owner role. You can now create ads in the business category to showcase your services, promotions, and events. Reach a wider audience and boost your business with our platform!',
            'vip' => 'Congratulations! You have achieved VIP status. As a VIP member, you have the ability to create ads in any category, gaining maximum exposure. Additionally, you can pin your ads on our Telegram channel and Instagram page, as well as highlight your ads. Leverage these exclusive features to enhance your advertising reach and impact.',
        ],
        'vip_plan_purchase' => 'For VIP membership subscription, it is required to purchase a VIP plan. Thank you.',
        'adsCreatePreview' => '
<b>Ad details:</b>

<b>Category</b>: <i>:category</i>
<b>Persian title</b>: <i>:title</i>
<b>English title</b>: <i>:title_en</i>
<b>Persian content</b>: <i>:content</i>
<b>English content</b>: <i>:content_en</i>
<b>Province</b>: <i>:state</i>
<b>City</b>: <i>:city</i>
<b>Photo</b>: <i>:image</i>
        ',
        'adsRealEstateSaleCreatePreview' => '
<b>Ad details:</b>

<b>Category</b>: <i>:category</i>
<b>Persian title</b>: <i>:title</i>
<b>English title</b>: <i>:title_en</i>
<b>Persian content</b>: <i>:content</i>
<b>English content</b>: <i>:content_en</i>
<b>Province</b>: <i>:state</i>
<b>City</b>: <i>:city</i>
<b>Photo</b>: <i>:image</i>
<b>Sale price</b>: <i>:sale_price</i>
<b>Yearly tax</b>: <i>:yearly_tax</i>
<b>Keeping Price</b>: <i>:price_keep</i>
<b>Area</b>: <i>:area :areaUnit</i>
<b>Floor</b>: <i>:floor</i>
<b>Rooms</b>: <i>:rooms</i>
<b>Bathrooms</b>: <i>:bathrooms</i>
<b>Construction year</b>: <i>:construction_year</i>
<b>Availability Date</b>: <i>:availability_date</i>
<b>Parking</b>: <i>:parking</i>
<b>General facilities</b>: <i>:facilities</i>
<b>Nearby facilities</b>: <i>:nearby_facilities</i>
<b>Building facilities</b>: <i>:building_facilities</i>
<b>Unit facilities</b>: <i>:unit_facilities</i>
        ',
        'adsRealEstateRentCreatePreview' => '
<b>Ad details:</b>

<b>Category</b>: <i>:category</i>
<b>Persian title</b>: <i>:title</i>
<b>English title</b>: <i>:title_en</i>
<b>Persian content</b>: <i>:content</i>
<b>English content</b>: <i>:content_en</i>
<b>Province</b>: <i>:state</i>
<b>City</b>: <i>:city</i>
<b>Photo</b>: <i>:image</i>
<b>Mortgage Price</b>: <i>:mortgage_price</i>
<b>Rent price</b>: <i>:rent_price</i>
<b>Area</b>: <i>:area :areaUnit</i>
<b>Floor</b>: <i>:floor</i>
<b>Rooms</b>: <i>:rooms</i>
<b>Bathrooms</b>: <i>:bathrooms</i>
<b>Construction year</b>: <i>:construction_year</i>
<b>Availability Date</b>: <i>:availability_date</i>
<b>Parking</b>: <i>:parking</i>
<b>General facilities</b>: <i>:facilities</i>
<b>Nearby facilities</b>: <i>:nearby_facilities</i>
<b>Building facilities</b>: <i>:building_facilities</i>
<b>Unit facilities</b>: <i>:unit_facilities</i>
        ',
        'createAdSmsText' => 'Thank you for submitting your ad titled “:title”. Our team will review your ad and approve it shortly. Once approved, your ad will be displayed on our site. You can upgrade your ad for better visibility and reach more potential customers.
            :link
        ',
        'editAdSmsText' => 'Your ad with the title “:title” has been successfully edited.. Our team will review your ad and approve it shortly. Once approved, your ad will be displayed on our site. You can upgrade your ad for better visibility and reach more potential customers.
            :link
        ',

        'user_score_text' => '
<b>Your Scores:</b>

<b>Total Scores</b>: <i>:total_score</i>
<b>Total Used Scores</b>: <i>:total_used_score</i>
<b>Total Pending Scores</b>: <i>:total_pending_score</i>

<b>Complete Profile</b>: <i>:complete_profile %</i>
<b>Blog/Ad Review</b>: <i>:blog_ad_review</i>
<b>Ad Rating</b>: <i>:ad_rating</i>
<b>Google Review</b>: <i>:google_review</i>
<b>Upload Video</b>: <i>:upload_video</i>
<b>Use Services</b>: <i>:use_services</i>
<b>Referral User</b>: <i>:referral_user</i>
        ',
        'generated_code_title' => "<b>Genereated Codes</b>",
    ],

    'upgrade_level_text' => '
<b>Welcome! Please choose the user role that best suits your needs:</b>

<b>Normal User:</b> As a User, you can review ads but do not have the ability to create ads. You can explore the various advertisements available on our platform and provide valuable feedback.

<b>Real Estate: </b>If you are a Real Estate professional, this role allows you to create ads specifically in the real estate category. You can showcase properties, rental listings, and other real estate-related offerings.

<b>Seller:</b> As a Seller, you have the privilege to create ads exclusively in the selling goods category. This role enables you to promote and sell various products to our platform\'s users.

<b>Business Owner:</b> If you own a business and want to advertise your services, this role is ideal for you. You can create ads specifically in the business category, showcasing your company\'s offerings, promotions, and events.

<b>VIP:</b> The VIP role provides you with extensive privileges. You have the ability to create ads in any category. Additionally, as a VIP member, you can pin your ads on our Telegram channel and Instagram page, gaining increased visibility and reach.
    ',

    'welcome' => '
<p>Hello,</p>
<p>Thank you for choosing our website.</p>
<p>At Kiusk, we are committed to providing our users with the best possible experience.</p>
<p>To better use the Kiusk services, please take a moment to <a href="https://kiusk.ca/site-rules">review the site rules</a>. Also, if you have any questions or doubts, please contact us. Our support team is ready to answer users 24 hours a day.</p>
<p>Thank you again for choosing Kiusk. We look forward to working with you!</p>

Best regards, Kiusk Team<br>',

    'order_transaction_success' => '
    Your ad has been successfully paid

Order ID: :orderId

Transaction ID: :transactionId

Payment Amount: $:price
    ',
    'order_transaction_failed' => '
    Your payment has been faild.

Order ID: :orderId

Transaction ID: :transactionId

Payment Amount: $:price
    ',

    'advertisements' => [
        'select_category' => 'In which category do you want your ad to be displayed?',
        'send_image' => 'Please send the image of your advertisement.',
        'send_image_en' => 'Please send the English image of your advertisement.',
        'create_content' => 'Please send the description of your advertisement.',
        'create_content_en' => 'Please send the description of your advertisement in English.',
        'create_link' => 'Please send the link of your advertisement.',
        'create_success' => 'Your ad was created successfully. It will be published after payment and confirmation.',
        'edit_description' => 'Please send the description of your advertisement.',
        'edit_description_en' => 'Please send the description of your advertisement in English.',
        'edit_gallery_text' => 'Please send the Perisan image of your advertisement.',
        'edit_gallery_en_text' => 'Please send the English image of your advertisement.',
        'edit_link' => 'Please send the link of your advertisement.',
        'payment' => "Pay through the link below to confirm and display the ad",
        'not_found' => 'Advertisement not found.',
        'confirm_edit' => 'Send for approval and display',
        'delete' => 'Delete(permanently)',
        'delete_message' => 'Are you sure you want to delete the information?(There is no return option)',
        'help' => 'Hello
        To create an ad, click on the option to create an ad
        Then, after entering your information, you can use extensive advertising services in Canada😍',
    ],
];
