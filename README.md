<h1>KUPaypal</h1>

<h3>Description</h3>
Service for payment from one user to other user. There are two perspective of user, customer and merchant. 
Customer want to pay money to merchant by kupaypal. After check out payment from merchant, website will redirect to kupaypal sign in page. 
Customer require to have kupaypal account to sign in after that kupaypal will show the order id merchant name total amount and time that payment has created, customer choose accepte or decline a payment. 
Then kupaypal will redirect customer to merchant website. <br>
There is not include parts that use bank api to withdraw or deposit money with this service.

<h3>Stakeholder</h3>
* Merchant
* Customer
* Payment System Admin
* User, It refer to both Customer and Merchant.

<h3>Specific Term</h3>
* Payment - a payment for goods/services that merchant send to the recipient (customer).
* Problem - a problem that broke an agreement of two stakeholders which is merchant and customer.
<br><b><i>note:</i></b> we still doesn't have standard for problem.

<h3>Use Case</h3>
<b><i>[API Specification at github's wiki](https://github.com/maixezer/KUPaypal/wiki/Use-Case) </i></b><br>


<h3>API Specification</h3>
<b><i>[API Specification at github's wiki](https://github.com/maixezer/KUPaypal/wiki/API-Specification) </i></b> <br>

<h3>Reference</h3>
This part is reference of my research through paypal system.
I found this [link](https://www.paypal.com/cy/webapps/mpp/ua/servicedescription-full) is really helpful.

<h3>Picture</h3>
![Alt text](https://github.com/maixezer/KUPaypal/blob/master/pic/sequenceUser.png "Optional title")

<h3>Picture</h3>
![Alt text](https://github.com/maixezer/KUPaypal/blob/master/pic/sequenceMerchant.png "Optional title")

<h3>Picture</h3>
![Alt text](https://github.com/maixezer/KUPaypal/blob/master/pic/state.png "Optional title")

<h2>Developer</h2>
* Atit Lelasuksan 5510546201
* Parinthorn Panya 5510546085
* Wat Wattanagaroon 5510546140
