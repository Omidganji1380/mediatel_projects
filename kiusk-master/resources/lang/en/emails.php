<?php

return [
    'admin' => [
        'purchased_title_text' => 'A user has been purchased a :type with the following details:',
        'created_ad' => 'A new ad has been created with the following details:',
        'approved_ad' => 'Ad with the ID :id has been approved by admin with ID :adminId and email :adminEmail and published in the site.',
        'rejected_ad' => 'Ad with the ID :id has been rejected by admin with ID :adminId and email :adminEmail for :reason',
        'upgrade_level' => 'The user has upgraded her/his role.',
    ],
    'title' => 'Welcome To Kiusk!',
    'contact' => 'Contact with us',
    'greeting' => 'Hello dear :name,',
    'regards' => 'Sincerely, The Kiusk Team',

    'messages' => [
        'welcome' => '
        <h1 class="text-primary" style="text-align: center !important;">Thank you for choosing Kiusk.</h1>
        <p style="text-align: center !important;">At Kiusk, we are committed to providing our users with the best possible experience.</p>
        <p style="text-align: center !important;">To better use the Kiusk services, please take a moment to review the site rules. Also, if you have any questions or doubts, please contact us, our support team is ready to answer users 24 hours a day.</p>
        <p style="text-align: center !important;">Thank you again for choosing the Kiusk. We look forward to working with you!</p>',
        'created_ad' => '
        <h1 class="text-primary" style="text-align: center !important;">Your ad has been created successfully.</h1>
        <p style="text-align: center !important;">Our administrators will review it and confirm it as soon as possible. Once your ad is confirmed, it will be visible to other users. Thank you for using our service!</p>
        ',
        'confirm-code' => '<h1 class="text-primary" style="text-align: center !important;">Enter the code below to verify your email address</h1>',
        'rejected_ad' => '<h1 class="text-primary" style="text-align: center !important;">Unfortunately, your ad has not been approved for publication.</h1>',
        'rejected_ad_edit' => '<h1 class="text-primary" style="text-align: center !important;">By clicking the "Edit Ad" button, you can easily edit your ad and resubmit it for review.</h1>',
        'published_ad' => '
        <h1 class="text-primary" style="text-align: center !important;">Your ad has been successfully published on the Kiusk platform.</h1>
        <p style="text-align: center !important;">You can easily view your ad by clicking the "View Ad" button.</p>
        ',
        'upgrade_level' => '',
        'upgrade_level_success' => '
        <h1 style="text-align: center !important;">Congratulations, you have successfully upgraded your user level.</h1>
        <p style="text-align: center !important;">We hope that using the Kiusk platform will bring you a good experience.</p>',
        'promote_ad' => '
        <h1 style="text-align: center !important;">Congratulations, your ad has been upgraded successfully.</h1>
        <p style="text-align: center !important;">You can see the status of your ads through the following button: </p>
        ',
        'advertisement_published' => '
        <h1 style="text-align: center !important;">Your ad order has been successfully published on the Kiusk platform.</h1>
        <p style="text-align: center !important;">You can easily view your ads by clicking the "My Ads" button. </p>
        ',
        'payment_error' => '
        <h1 style="text-align: center !important;">Unfortunately, there was a problem with your payment process.</h1>
        <p style="text-align: center !important;">Please try again and contact the support team if you encounter any problems.</p>
        ',
        'payment_success' => '
        <h1 style="text-align: center !important;">Your payment has been successfully completed.</h1>
        <p style="text-align: center !important;">Your payment ID is :id.</p>
        ',
        'ticket_submitted' => '
        <h1 class="text-primary" style="text-align: center !important;">Your ticket has been registered successfully.</h1>
        <p style="text-align: center !important;">After checking, the ticket answer will be sent by the Kiusk experts. </p>
        ',
        'ticket_replied' => '<h1 style="text-align: center !important; direction:ltr;">A new ticket has been sent to you.</h1>',
        'unread_messages' => '<h1 style="text-align: center !important;">You have :count unread messages.</h1>',
        'new_ad_review' => '
        <h2  style="text-align: center !important;">Congratulations!</h2>
        <p  style="text-align: center !important;">A new comment has been registered for your ad.</p>
        ',
        'report_title' => '<h1 style="text-align: center !important;"></h1>',
        'promote_message' => '<h1 style="text-align: center !important;"></h1>',
        'report_service_usage' => '<h1 style="text-align: center !important;"></h1>',
        'score' => '<h1 style="text-align: center !important; direction:ltr;">Congratulations on Your Score! You have earned :score points for :type in the Kiusk.</h1>',
        'created_discount' => '
        <h2>Congratulations!</h2>
        <p style="text-align: center !important;">:scoreCategory with a :score scores has been activated for you.</p>
        <p style="text-align: center !important;">In the next 24 hours, the Kiusk experts will contact you to coordinate the use of the prize selection.</p>
        ',
        'forgot_password' => '<h3 style="text-align: center !important;">If you have forgotten your password, enter the following password to recover your password.</h3>',
        'daily_content' => '
            <h3 style="text-align: left !important;">- Total views of your ads: :adViews</h3>
            <h3 style="text-align: left !important;">- Total comments on your ads: :adComments</h3>
            <h3 style="text-align: left !important;">- Total Scores (Claimed): :claimedScoresSum</h3>
            <h3 style="text-align: left !important;">- Total Scores (Unclaimed): :unclaimedScoresSum</h3>
            <h3 style="text-align: left !important;">- Total Scores (Spend): :spentScoresSum</h3>

            <p style="text-align: left !important;">Thank you for using our service!</p>
        ',
        'intro' => ' <h1 style="text-align: left !important;">Here\'s a summary of the weekly and monthly reports:</h1>',
        'report_body' => '
            <h3 style="text-align: left !important;">1. Website and Social Media Clicks</h3>
                <p style="text-align: left !important;">- Weekly count: :linkClicksWeeklyCount</p>
                <p style="text-align: left !important;">- Monthly count: :linkClicksMonthlyCount</p>
            <h3 style="text-align: left !important;">2. Ads Review</h3>
                <p style="text-align: left !important;">- Weekly count: :reviewsVisibleWeeklyCount</p>
                <p style="text-align: left !important;">- Monthly count: :reviewsVisibleMonthlyCount</p>
            <h3 style="text-align: left !important;">3. Ads Service Usage</h3>
                <p style="text-align: left !important;">- Weekly count: :serviceUsagesConfirmedWeeklyCount</p>
                <p style="text-align: left !important;">- Monthly count: :serviceUsagesConfirmedMonthlyCount</p>
            <h3 style="text-align: left !important;">4. Messages</h3>
                <p style="text-align: left !important;">- Weekly count: :messagesWeeklyCount</p>
                <p style="text-align: left !important;">- Monthly count: :messagesMonthlyCount</p>
            <h3 style="text-align: left !important;">5. Scores (Claimed)</h3>
                <p style="text-align: left !important;">- Weekly: :claimedScoresWeeklySum</p>
                <p style="text-align: left !important;">- Monthly: :claimedScoresMonthlySum</p>
            <h3 style="text-align: left !important;">6. Scores (Unclaimed)</h3>
                <p style="text-align: left !important;">- Weekly: :unclaimedScoresWeeklySum</p>
                <p style="text-align: left !important;">- Monthly: :unclaimedScoresMonthlySum</p>
            <h3 style="text-align: left !important;">7. Scores (Spend)</h3>
                <p style="text-align: left !important;">- Weekly: :spentScoresWeeklySum</p>
                <p style="text-align: left !important;">- Monthly: :spentScoresMonthlySum</p>
        ',
        'subscription_warnings' => '
            <h2 style="text-align: center !important;">Your subscription will expire on :expirationDate. You have :daysUntilExpiration days left.</h2>
            <p style="text-align: center !important;">Please renew your subscription to continue using our service.</p>
        ',
        'new_property_applicant' => '
        <h1 style="text-align: center !important;">A new property applicant has been published.</h1>
        ',
    ],
];
