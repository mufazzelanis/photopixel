<?php

namespace Database\Seeders;

use App\Models\LegalPage;
use Illuminate\Database\Seeder;

class LegalPageSeeder extends Seeder
{
    public function run(): void
    {
        LegalPage::updateOrCreate(['slug' => 'privacy-policy'], [
            'title' => 'Privacy Policy',
            'hero_heading' => 'Our Privacy Policy | Update 2022',
            'hero_sub' => "Let's take a look our privacy policy",
            'hero_btn_label' => 'Contact Us',
            'hero_btn_url' => '/contact',
            'seo_title' => 'Privacy Policy — Pixel Graphic Studio',
            'seo_description' => "Read Pixel Graphic Studio's privacy policy — what data we collect, how long we keep it, and the rights you have over it.",
            'body' => <<<'HTML'
<h2>Who we are</h2>
<p>We are a promising company that provides you with high-end photo editing services. Our website address is: <a href="https://www.pixelgraphicstudio.com">https://www.pixelgraphicstudio.com</a></p>

<h2>Comments</h2>
<p>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor's IP address and browser user agent string to help spam detection.</p>
<p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: <a href="https://automattic.com/privacy/">https://automattic.com/privacy/</a>. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p>

<h2>Media</h2>
<p>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p>

<h2>Cookies</h2>
<p>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p>
<p>If you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p>
<p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select "Remember Me", your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p>
<p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p>

<h2>Embedded content from other websites</h2>
<p>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p>
<p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p>

<h2>Whom we share your data with</h2>
<p>We do not share your data with any third party. Your data is safe and we respect your privacy. If you request a password reset, your IP address will be included in the reset email.</p>

<h2>How long we retain your data</h2>
<p>We don't store any personal information our client provide to us. They can select service, upload their photos, write their requirements with their email or phone number. Using our payment method they also can pay for the services.</p>

<h2>What rights you have over your data</h2>
<p>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p>

<h2>Where we send your data</h2>
<p>Visitor comments may be checked through an automated spam detection service.</p>

<h2>Contact Us</h2>
<p>If you have any questions about this Privacy Policy, you can contact us:</p>
<p>By email: <a href="mailto:office@pixelgraphicstudio.com">office@pixelgraphicstudio.com</a><br>By visiting this page on our website: <a href="https://www.pixelgraphicstudio.com/contact-us/">https://www.pixelgraphicstudio.com/contact-us/</a></p>
HTML,
        ]);

        LegalPage::updateOrCreate(['slug' => 'terms-of-service'], [
            'title' => 'Terms Of Service',
            'hero_heading' => 'Terms Of Service',
            'hero_sub' => null,
            'hero_btn_label' => null,
            'hero_btn_url' => null,
            'seo_title' => 'Terms of Service — Pixel Graphic Studio',
            'seo_description' => 'The terms and conditions that govern the use of Pixel Graphic Studio\'s website and photo editing services.',
            'body' => <<<'HTML'
<h2>Terms and Conditions</h2>
<p>Welcome to Pixel Graphic Studio, a professional photo editing service provider. Our goal is to deliver top-notch photo editing services to our clients. This page outlines the terms and conditions that govern the use of our website and services. By accessing or using our website, you agree to be bound by these terms and conditions. If you do not agree to these terms and conditions, please do not use our website or services.</p>

<h3>Service Offerings</h3>
<p>At Pixel Graphic Studio, we offer a comprehensive range of photo editing services, including, but not limited to, photo retouching, color correction, background removal, and image manipulation. Our team of highly skilled editors will work to ensure that your photos are edited to your precise specifications.</p>

<h3>Payment Terms</h3>
<p>Payment for our services must be made in advance through our secure online payment gateway. Upon receipt of payment, our team will commence work on your photo editing project. If you are not satisfied with the final result, we will revise the work until you are completely satisfied.</p>

<h3>Delivery Timeline</h3>
<p>We are committed to delivering your edited photos in a timely manner. The delivery timeline will vary depending on the complexity of the project and the number of photos being edited. We will provide you with an estimated delivery date when you place your order.</p>

<h3>Refund Policy</h3>
<p>If you are not satisfied with the final product, we will work with you to make revisions until you are completely satisfied. In the event that you are still not satisfied after revisions, you may request a refund within 7 days of receipt of the final product. Refunds will be processed within 14 business days.</p>

<h3>Intellectual Property Rights</h3>
<p>The photos you submit to us for editing remain your property. We do not claim any rights of ownership to your photos. By submitting your photos to us for editing, you grant us a limited license to use the photos solely for the purpose of providing photo editing services to you. This license will automatically terminate upon completion of the services.</p>

<h3>Confidentiality</h3>
<p>We respect the privacy of our clients and take confidentiality very seriously. We will not share your photos or personal information with any third party, unless required by law.</p>

<h3>Limitation of Liability</h3>
<p>Pixel Graphic Studio shall not be held liable for any damages, including, but not limited to, direct or indirect damages, arising from the use of our services or the inability to use our services.</p>

<h3>Changes to Terms and Conditions</h3>
<p>Pixel Graphic Studio reserves the right to modify these terms and conditions at any time. Your continued use of our website and services following any changes to these terms and conditions constitutes your acceptance of the changes.</p>

<p>By using our website and services, you agree to be bound by these terms and conditions. If you have any questions or concerns, please do not hesitate to contact us at <a href="mailto:office@pixelgraphicstudio.com">office@pixelgraphicstudio.com</a>.</p>
<p>We are grateful for your choice of Pixel Graphic Studio for your photo editing needs and look forward to serving you.</p>

<h2>Complete Terms &amp; Conditions</h2>
<p>Please take the time to thoroughly read this complete agreement since it contains important information about your legal rights, including our agreement to arbitrate disputes.</p>

<h3>1. Introduction</h3>
<p>We appreciate you choosing Pixel Graphic Studio ("we," "us," or "our"). You ("you," "client," "user," or "customer") are entering into a legally binding agreement with Pixel Graphic Studio when you register, visit, use, or otherwise interact with our website (pixelgraphicstudio.com) and services (collectively, the "Pixel Graphic Studio Website" or "Site"), or access any content or material made available by Pixel Graphic Studio through the Service. The Customer Portal, which is further discussed in the Customer Portal section, is also a part of the Pixel Graphic Studio Service.</p>
<p>These Terms and Conditions of Use ("Terms") and our Privacy Policy constitute an agreement between you and us. If you wish to review the terms of the Agreements, the current version is available on Pixel Graphic Studio's website at pixelgraphicstudio.com. The Terms, Privacy Policy, and any additional terms that you agree to are collectively referred to as the "Agreements" as discussed in the Entire Agreement section. You accept these Agreements and declare that you have read, comprehended, and agree to be bound by them. You shouldn't access or otherwise use the Site if you disagree with any part of these Terms. Any text, materials, documents, pictures, graphics, logos, designs, audio, video, and other information that is posted to, downloaded from, or uploaded to the Site is referred to as "Content."</p>
<p>Please take your time reading the Agreements. They include crucial details regarding the Pixel Graphic Studio Services we delivered to you as well as any costs, taxes, and fees we billed you.</p>
<p>You must meet the following requirements in order to use Pixel Graphic Studio's services and access the content: (1) be at least 18 years old; (2) be at least 13 years old and have your parent or legal guardian's permission to enter into the Agreements; (3) be a resident of a country where the Site is accessible. You also warrant to Pixel Graphic Studio that any registration information you provide is true, accurate, and complete, and you undertake to maintain the accuracy of such information at all times.</p>

<h3>2. Modifications to the Agreements</h3>
<p>We have the right to occasionally modify the Agreements. It is your duty to frequently review these Agreements for updates. You will be deemed to have accepted the changes if you continue to use the Site after they have been posted. You are granted a limited, personal, non-exclusive right to access and use the Site by Pixel Graphic Studio as long as you abide by these Agreements.</p>

<h3>3. Site Restrictions and Changes</h3>
<p>The Pixel Graphic Studio Site will remain operational with reasonable efforts from Pixel Graphic Studio. However, occasionally there can be brief disruptions due to maintenance or certain technical issues. To the extent permitted by applicable law, Pixel Graphic Studio reserves the right to periodically and at any time interrupt, modify, or discontinue the Service or any feature or function thereof, with or without notice, and without incurring any liability to you, unless such interruption, modification, or discontinuation is prohibited by applicable law. You acknowledge that Pixel Graphic Studio is under no duty to support, upgrade, or otherwise update the Site or to deliver any particular material through the Site. To the extent permitted by applicable law, Pixel Graphic Studio and/or the owners of such Content may occasionally remove any such Content without notice.</p>

<h3>4. Use of the Website</h3>
<p><strong>Services We Provide:</strong> Clipping path and other Photoshop services are offered by Pixel Graphic Studio. Unless both parties agree differently, Pixel Graphic Studio demands full payment when you place your request for Services. You can get a quote before making a purchase. Visit our website to find out more about our services.</p>
<p><strong>4.2 Account creation, the customer portal, and passwords.</strong> Users may be needed to register with Pixel Graphic Studio and choose a password in order to use specific products and services of the Service. User must give Pixel Graphic Studio current, accurate, and complete registration information. A violation of this Agreement will be considered failure to comply, and the account of the User may be immediately terminated as punishment. Your account information, including your password, must always be kept private. You are also fully responsible for any and all activity that takes place on your account. You promise to immediately alert Pixel Graphic Studio of any unauthorized use of your account or password, as well as any other security lapses. However, if someone else uses your username, password, or account, you could be held liable for any losses incurred by Pixel Graphic Studio or any other user or visitor to the Site.</p>

<h3>5. We Grant You Rights</h3>
<p>Pixel Graphic Studio, and its affiliated/associated businesses, own the Site and the Content. We therefore give you a limited, non-exclusive, revocable license to access and make personal, non-commercial, entertainment use of the Site and the Content (the "License"). This License is valid until it is canceled by you or Pixel Graphic Studio, whichever comes first. You affirm that you use the Content solely for non-commercial, personal enjoyment purposes and that you will not distribute or otherwise transfer the Site or the Content.</p>
<p>The entire Pixel Graphic Studio brand, including all trade names, trademarks, service marks, logos, domain names, and other elements, is the exclusive property of Pixel Graphic Studio or its licensors. You have no rights to use any Pixel Graphic Studio brands for either commercial or non-commercial purposes under the Agreements.</p>
<p>You hereby agree not to use the Site, the Content, or any portion thereof in any manner not expressly permitted by the Agreements and to comply with our User Standards. Pixel Graphic Studio does not grant you any rights, titles, or interests in the Site or Content other than those that are specifically provided to you in these Agreements.</p>

<h3>6. Outside Applications</h3>
<p>To make content, goods, and/or services available to you, Pixel Graphic Studio is integrated with third-party programs, websites, and services, including but not limited to Shopify, PayPal, BrickFTP, Heroku, HelpScout, Smile.io, and Stripe ("Third-Party Applications"). Your use of these Third-Party Applications will be regulated by and subject to such terms and conditions and privacy policies, which may have been established by the Third-Party Applications themselves. You acknowledge and accept that Pixel Graphic Studio does not support any Third-Party Applications and is not accountable or liable for their functionality, features, or content, or for any business dealings you may have with their creators.</p>

<h3>7. Content Created by Users</h3>
<p>Users of Pixel Graphic Studio may post, upload, and/or contribute ("post") content to the Site in order to get services. This content, known as "User Content," may include, but is not limited to, images, text, messages, information, and/or other types of content. For the avoidance of doubt, "User Content" refers to any such content posted to any other area of the Site as well as the Customer Service Portal (the "Portal").</p>
<p>You affirm that, with regard to any User Content you post on the Site, (1) you have the legal right to do so, and (2) neither the User Content, nor Pixel Graphic Studio's use of it in accordance with the Agreements, violates the Agreements, applicable law, or the rights of others to their intellectual property (including without limitation copyright), publicity, or privacy, nor does it suggest a relationship with or endorsement by Pixel Graphic Studio of any person, business, or other entity.</p>
<p>Pixel Graphic Studio may monitor, review, or modify User Content, but this is not a requirement. For any reason, including but not limited to User Content that Pixel Graphic Studio determines in its sole judgment violates the Agreements, Pixel Graphic Studio reserves the right to remove or disable access to any User Content or account, without first informing you or any other parties. We reserve the right to remove or disable access to any User Content at our sole discretion, but we do not provide any guarantees in this regard.</p>
<p>For all User Content you submit, you are totally accountable. Pixel Graphic Studio disclaims all liability for User Content and does not share any opinions expressed within. You agree that, to the extent permitted by local law, you will indemnify and hold Pixel Graphic Studio harmless from and against all damages, losses, and expenses of any kind (including reasonable attorney fees and costs) arising out of any claim brought against Pixel Graphic Studio relating to user content that you provide.</p>

<h3>8. You Grant Us These Rights</h3>
<p>You grant us the right (1) to permit the Service to use the processor, bandwidth, and storage hardware on your device in order to facilitate the operation of the Service, (2) to deliver advertising and other information to you, and (3) to permit our business partners to do the same in exchange for the rights granted to you under the Agreements. Commercial factors, including contracts with third parties, may have an impact on the Content you view in any area of the Service, including its selection and placement.</p>
<p>You agree that we may use your photographs on our website (including a link to the home page of your website) and in our marketing materials unless you have instructed Pixel Graphic Studio otherwise in writing.</p>
<p>You accept that any comments, ideas, or recommendations you give to Pixel Graphic Studio in connection with the Service or Content ("Feedback") are not confidential and give Pixel Graphic Studio permission to use them without restriction or compensation to you. A form of User Content is regarded to be Feedback.</p>

<h3>9. User Instructions</h3>
<p>Pixel Graphic Studio upholds intellectual property rights, and we anticipate that you will as well. To ensure that Pixel Graphic Studio can keep offering services through the site, we've developed some ground rules for you to abide by when using it. The following is prohibited for any and all reasons:</p>
<p>any use of the Service or the Content that is not expressly permitted by the Agreements or applicable law, or that otherwise violates the intellectual property rights (such as copyright) in the Service or the Content or any part of it; copying, redistributing, reproducing, "ripping", recording, transferring, performing or displaying to the public, or making any part of the Site or the Content available to the public; copying cached Content using any method from an approved device to any other device; unless allowed by relevant law, reverse engineering, decompiling, disassembling, altering, or producing derivative works based on the Service, Content, or any component thereof; evading any security measures put in place by Pixel Graphic Studio, its licensors, or any other party to guard the Service or the Content; any type of sale, rental, sublicense, or lease of the Service or the Content; evading any geographic limitations imposed by Pixel Graphic Studio or its licensors, or otherwise tampering with the Services through the use of a script or other automated mechanism; deleting or changing any copyright, trademark, or other intellectual property notices present on or made available through the Service; using another person's username and password or disclosing your password to a third party; utilizing any automated means (such as bots, scrapers, and spiders) to gather data from Pixel Graphic Studio, such as "crawling" the Service; or selling a user account or accepting any kind of payment, whether monetary or not.</p>
<p>You understand and agree that publishing any such User Content may result in the immediate suspension or cancellation of your account. You also acknowledge that Pixel Graphic Studio may, at any time, reclaim your username.</p>
<p>Your user account is secured by your password, which you are completely responsible for keeping private and safe. Please notify us right away and reset your password as soon as you can if your username or password is lost, stolen, or if you think someone else may have accessed your account without your permission.</p>

<h3>10. Informational Property</h3>
<p>Owners of intellectual property are respected by Pixel Graphic Studio. Please email us at office@pixelgraphicstudio.com if you think any Content violates your legal rights, including intellectual property rights.</p>
<p>The Site's text, graphics, logos, button icons, pictures, audio clips, digital downloads, data compilations, and software all belong to Pixel Graphic Studio or its content suppliers and are covered by applicable copyright laws. With the exception of the following, it is forbidden to redistribute or reproduce all or part of the contents: extracts may only be printed or downloaded to a local hard drive for personal, non-commercial use; only if you credit the website as the original source will you be permitted to reproduce the content to specific third parties for their private use. You may not disseminate or otherwise commercially exploit the content without first obtaining our express written consent, or send it or keep it on any other website or electronic retrieval system.</p>

<h3>11. Customer Service</h3>
<p>Contact our customer service department at office@pixelgraphicstudio.com with any issues you may have regarding your account or payments ("Customer Support Queries"). We will make a fair effort to respond to any customer support requests in a timely manner, but we make no guarantees or warranties of any kind that we will be able to adequately address any such requests or that we will be able to do so within any certain time period.</p>

<h3>12. Paid, Refunded, and Cancelled Transactions</h3>
<p><strong>12.1 Credit Extension and Payment.</strong> Pixel Graphic Studio demands all individual clients to pay for services in full upfront before work begins. Payment choices are PayPal, credit cards, or Pixel Graphic Studio credits. Corporate clients may be offered credit, subject to satisfactory reference checks and at our discretion. Any customers with extended credit will have to sign a contract that will be delivered to them by a team member. The work must be paid in full no later than four (4) days after delivery. We might also offer choices for recurring monthly payments — the client is responsible for paying each month for all Services received during that time. We maintain the right to revoke any credit given to a client in the event of late payment at any time. There will be prior agreement on all costs.</p>
<p><strong>12.2 Refunds &amp; Quality Guarantee.</strong> Pixel Graphic Studio aims to offer the best possible services. If, on the odd occasion, you are unhappy with the outcome of your project, we will make reasonable repairs and amendments as required. All requests for revisions and refunds must be made within 14 days after delivery. If the client modifies the requirements from what was originally asked, we reserve the right to cancel any amendment request. We are unable to issue a refund for an order if the modified photographs meet the same quality standards as the accepted sample image. We can modify the photos to match your demands at a lower cost because we are aware that occasionally circumstances are beyond our control. No refund will be given if the client has downloaded their photographs and is unable to give a good explanation for their dissatisfaction. Please get in touch with customer service if you think you are eligible for a refund of any money you have already paid.</p>
<p><strong>12.3 Costs.</strong> Prices for the services offered may differ. Before finalizing a new order, we will notify you of any price changes for pre-paid work or credit (for work products not yet paid for). By continuing to use our Service after a price change goes into effect, you agree to the new price, to the extent permitted by local law. We retain the right to occasionally change our prices, and any changes will be immediately reflected in the relevant services. Unless there is a separate arrangement with each client, we may not alert clients about these changes, but they will notice the pricing before finalizing any new order.</p>
<p><strong>12.4 Special Discounts and Promotional Offers.</strong> We may run promotions through discount codes or other channels, and we retain the right to revoke any discounts or promotional offers at any time and for any reason.</p>
<p><strong>12.5 Loyalty and Referral Program.</strong> Our referral and customer loyalty program lets clients recommend us to friends, family members, and coworkers. Customers cannot earn points using more than one email account, and referrals cannot earn awards using more than one email address. Any prize that has been granted will be withheld or canceled if these terms are violated and considered program abuse. We retain the right to cancel or remove any awards, including loyalty points or credits, for any reason.</p>
<p><strong>12.6 Pixel Graphic Studio Credits.</strong> You can buy credits to use for services. Credits cannot be refunded and must be used to pay for our Services. When applying a refund to an order that was paid for using credits, we will only return the value in credits, not in cash. You are not guaranteed a specific price for the Services or a price freeze by purchasing credits — prices apply when you seek a price and place an order, not when you buy credits.</p>

<h3>13. Orders and Quotes</h3>
<p>Orders may be canceled if the client's order images do not match the sample that was included with the first quote. We might offer a fresh quote that the client can use to submit a different order. If a client places an order based on a different type or category of photos than the original quotation, we have the right to reject the order and offer the client a new quote.</p>

<h3>14. Reaction Time</h3>
<p>When a client places an order, the turnaround time they choose starts once they have finished submitting all of the photographs to be edited. The clock doesn't start ticking when the order is placed.</p>

<h3>15. Termination and Term</h3>
<p>Until you or Pixel Graphic Studio decide to terminate them, the Agreements will still be in effect for you. You understand and agree that the perpetual license you have granted in relation to User Content, including Feedback, is irrevocable and will continue even after any Agreements are terminated. In the event of your real or suspected unauthorized use of the Service and/or Content, or non-compliance with the Agreements, Pixel Graphic Studio may at any time cancel your access to the Site or Customer Portal, or suspend your access to the Service. To the fullest extent permissible by applicable law, Pixel Graphic Studio shall have no liability or duty to you in the event of termination, and we also do not reimburse any sums you have already paid. Please get in touch with us at office@pixelgraphicstudio.com to find out how to close your account. The Agreements are always subject to termination by you.</p>
<p>The following parts of the Agreements — Sections 3, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, and 22 — as well as any others that, either explicitly or by their nature, must remain in force even after the Agreements are terminated, shall survive termination.</p>

<h3>16. A Promise and a Disclaimer</h3>
<p>We try to give you the best service we can, but you acknowledge and agree that the Site is provided "as is" and "as available," without any express or implied warranty or condition of any kind. You use the Service at your own risk. To the fullest extent permitted by applicable law, Pixel Graphic Studio and all owners of the content make no representations and disclaim any warranties or conditions of satisfaction. This does not affect your consumer rights under the law.</p>

<h3>17. Limitations</h3>
<p>While Pixel Graphic Studio accepts no liability for third-party applications or their content, your sole and exclusive remedy, as applicable, for any problems or dissatisfaction with the service is to stop using the site. To the fullest extent permitted by law, in no event will Pixel Graphic Studio, its officers, shareholders, employees, agents, directors, subsidiaries, affiliates, successors, assigns, suppliers, or licensors be liable for any indirect, special, incidental, or punitive damages.</p>

<h3>18. Right of Third Parties</h3>
<p>You agree and accept that the distributors and the owners of the Content are the intended beneficiaries of the Agreements and have the authority to enforce them directly against you. The Agreements are not intended to transfer rights to anyone other than you and Pixel Graphic Studio, save as specified in this section, and in no event shall the Agreements create any third-party beneficiary rights. Furthermore, the approval of any third party is not required in order to terminate, rescind, or agree to any amendment, waiver, or settlement of the Agreements.</p>

<h3>19. Complete the Agreement</h3>
<p>The Agreements represent the entire understanding between you and Pixel Graphic Studio with regard to their subject matter and supersede any prior agreements, whether written or oral, regarding such subject matter, aside from what is expressly stated in this section or as explicitly agreed upon in writing between you and Pixel Graphic Studio.</p>

<h3>20. Discontinuity and Waiver</h3>
<p>If, for any reason or to any extent, any provision of the Agreements is found to be invalid or unenforceable, such invalidity shall not affect or render invalid or unenforceable the remaining provisions of the Agreements, and the application of such provision shall be enforced to the fullest extent permitted by law. Failure to enforce the Agreements or any of its provisions does not constitute a waiver of the right to do so in the future.</p>

<h3>21. Assignment</h3>
<p>The Agreements may be assigned in whole or in part, and Pixel Graphic Studio may delegate any of its responsibilities thereunder. You are not permitted to transfer or sublicense your rights under the Agreements to any third party or assign the Agreements or any portion of them.</p>

<h3>22. Relevant Law</h3>
<p>The interpretation of these terms and conditions shall be governed by applicable local law, and the courts of the relevant jurisdiction will have sole authority over any dispute.</p>

<h3>23. Indemnification</h3>
<p>To the fullest extent allowed by law, you agree to defend, indemnify, and hold harmless Pixel Graphic Studio from and against any claims for harm, loss, or expense of any kind (including reasonable legal fees and costs) resulting from: (1) your violation of this Agreement; (2) any User Content; (3) any activity you undertake on or through the Site; and (4) your violation of any law or the rights of a third party.</p>

<h3>24. Privacy</h3>
<p>The most recent version of our privacy statement, known as the <a href="/privacy-policy">Privacy Policy</a>, is accessible on the Site and is incorporated here. We highly advise that you carefully read it.</p>

<h3>25. Cookies</h3>
<p>A cookie is a little file that requests permission to be stored on the hard disk of your computer. Once you consent, the file is added, and the cookie assists in online traffic analysis or notifies you when you visit a specific website. Web apps can respond to you specifically thanks to cookies. By obtaining and retaining information about your preferences, the web application can adjust its operations to meet your needs, likes, and dislikes.</p>
<p>In order to determine which pages are being used, we use traffic log cookies. This enables us to analyze web page traffic statistics, enhance our website, and better cater it to the needs of users. This data is solely used by us for statistical analysis, after which it is deleted from the system. Cookies that are already on your computer can be deleted; for instructions specific to your browser, please check online. Nevertheless, many websites' usability will suffer if cookies are deleted.</p>

<h3>26. Message Us</h3>
<p>Please email our Customer Service at <a href="mailto:office@pixelgraphicstudio.com">office@pixelgraphicstudio.com</a> if you have any issues about the Service or the Agreements.</p>
HTML,
        ]);
    }
}
