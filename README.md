#Avangate with Nexmo SMS

<img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image1.PNG" width=200>

##Introduction

Avangate with Nexmo SMS app provides extended notification feature in Avangate. Avangate store owners and customers can receive notification on their mobile via SMS. This app allows to send order create, order fulfilment and order refund notifications via SMS to shop owner and customers. Avangate admin can configure web hooks, which require SMS notification and also set threshold amount so notification will only send if order amount satisfies threshold value.

##Use Case

**SMS to Store owner and customer when any new order is placed or order status is changed on Avangate store** 

Whenever any new order is placed by customer, app will immediately send the SMS to owner and customer with order id and the total order amount. The SMS will be send by app only when order amount is more than the specified amount threshold. Store owner can define the order total threshold in app settings. 

Avangate with Nexmo SMS will send the SMS on following events: 

1.  **Order Place / Order Fulfillment**:  

    1.  **For Store Owner: ** 

		\#&lt;&lt;order no&gt;&gt;
		Avngt Ref.: &lt;&lt;order id&gt;&gt;
		Order Total: &lt;&lt;amount&gt;&gt;
		Status: PAYMENT\_AUTHORIZED

	2.  **For Customer:** Your order id &lt;&lt;order id&gt;&gt; payment of &lt;&lt;amount&gt;&gt; is done.


2.  **Payment Refunded**.

    1.  **For Store Owner:** 

		\#&lt;&lt;order no&gt;&gt;
		Avngt Ref.: &lt;&lt;order id&gt;&gt;
		Order Total: &lt;&lt;amount&gt;&gt;
		Status: REVERSED

	2.  **For Customer:** Your order id &lt;&lt;order id&gt;&gt; payment of &lt;&lt;amount&gt;&gt; is refunded.

##Prerequisites 

-   Avangate Store account.

-   Hosting platform with LAMP stack to host and run Avangate with Nexmo SMS app code.

-   Nexmo subscription and corresponding Nexmo API keys (Keys and Secret). To access the API keys, see appendix section.

##Features

-   Enable and disable SMS functionality.

-   Send real time SMS notifications on order status change to both customers and store owner.

-   Set the Threshold Value in number. The app sends an SMS when an order is placed with an amount greater than or equal to the threshold value.

##Steps to deploy Avangate with Nexmo SMS 

1.  Visit the target Git repository using the [URL.](https://github.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS.git)

2.  Click on **Download Zip.** The app's zip file will get downloaded.

3.  Extract the app code.

4.  Host the downloaded app code using ftp or any other medium to your hosting platform. The hosted code must be accessible publically as the internal and localhost will not work for this app.

###Create Webhook URL using Avangate with Nexmo SMS 

1.  Access the Avangate with Nexmo SMS app using public URL as explained above.
	<img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image3.png" width=400>

2.  Type the correct Nexmo API credentials and click on **Validate**.

3.  On valid API, you will see the configuration page as below:
    <img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image4.png" width=400>

    -   Select the **From Number** from the dropdown list.

    -   Set the **Threshold Value** in number. The app sends an SMS when an order is placed with an amount greater than or equal to the threshold value.

    -   Set the **Store Name** of the online store.

    -   Set **Store Owner Mobile Number** where you want to receive the message when the threshold condition is satisfied.

    -   Click on **Get Webhooks.**

4.  Copy the Webhook for further use.

	<img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image5.png" width=400>

##Steps to use webhook URL

1.  Login to the Avangate cpanel with your credentials**.**

2.  On the Avangate dashboard, under the section **Step 1,** click on IPN link.
    <img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image6.png" width=400>

3.  Set the copied URL under **IPN URL** label which is under the **URL** section as shown below:
    <img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image7.png" width=400>

4.  Click on **Save**.

5.  Stay on the IPN settings page and select **Notification settings** as shown below**:
    **<img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image8.png" width=400>

6.  Click **Save.**

7.  Select all the notification statuses, which are listed under the **Notification Details** and click **Save.**

8.  Click on **System settings** tab, select **Email Text & IPN** option to receive notifications. <img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image9.png" width=400>

9.  Click on **Update Settings** at the end of the page.
    <img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image10.png" width=400>

##Steps to use Avangate with Nexmo SMS 

1.  To test webhook working correctly, click on **Generate links** from Menu.
    <img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image11.png" width=400>

2.  Select the product from the Link section under the **Sales Link** tab. 
	<img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image12.png" width=400>

3.  Go to the end of the page and click **Place a test order**.
    <img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image13.png" width=400>

4.  You may be redirected to the checkout page. Follow the instruction as given there to checkout and place a test order.

5.  If you receive an SMS, the app is successfully configured, otherwise check the reconfiguration of **Avangate with Nexmo SMS** app, and follow steps under the **Create webhook URL using Nexmo SMS** section given above.

##Appendix

Nexmo API Keys
--------------

-   To access Nexmo keys, go to <https://www.nexmo.com/> and Sign-in

-   On the top right corner, click on the “**Api Settings**”

-   Key and Secret will display in the top bar as shown in the below image:

	<img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image14.jpeg" width=400>

Avangate Secret Keys
--------------------

1.  Login to Avangate.

2.  Go to <https://secure.avangate.com/cpanel/account_settings.php>

3.  In **System Settings** tab, scroll to **Instant Payment Notification** section and copy the secret key.

	<img src= "https://raw.githubusercontent.com/AdvaiyaLabs/Avangate-with-Nexmo-SMS/master/Docs/image15.png" width=400>
