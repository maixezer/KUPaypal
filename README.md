<h1>KUPaypal</h1>

<h3>Description</h3>
Service for payment from one user to other user. There are two perspective of user, customer and merchant. 
Customer want to pay money to merchant by kupaypal. After check out payment from merchant, website will redirect to kupaypal sign in page. 
Customer require to have kupaypal account to sign in after that kupaypal will show the order id merchant name total amount and time that payment has created, customer choose accepte or decline a payment. 
After customer accept a payment, service will redirect to callback path provide by merchant with order_id e.g. http://sabaii.com/order/+1 => http://sabaii.com/order/1<br>
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
<b><i>[Use case at github's wiki](https://github.com/maixezer/KUPaypal/wiki/Use-Case) </i></b><br>

<h3>API Specification</h3>
<b><i>[API Specification at github's wiki](https://github.com/maixezer/KUPaypal/wiki/API-Specification) </i></b> <br>

<h3>How this service work</h3>
Situation: Customer come to a web store, buy something and want to pay via this service. <br><br>
1. Customer choose to pay with KUPaypal service, web store will use HTTP Post method to create a payment and redirect  customer to an accept page as refer in image below.
<h3>Customer pay a payment</h3>
![Alt text](https://github.com/maixezer/KUPaypal/blob/master/pic/sequenceUser.png "Optional title")

2. After customer accept a payment, money doesn't transfer to merchant account immediately. Merchant need to validate a payment to retrieve his/her money.
<h3>Merchant validaet a payment</h3>
![Alt text](https://github.com/maixezer/KUPaypal/blob/master/pic/sequenceMerchant.png "Optional title")

2. Alternative: If merchant found out that something wrong with payment, merchant can decline it. Payment marked as cancelled.

<h3>State of System</h3>
![Alt text](https://github.com/maixezer/KUPaypal/blob/master/pic/state.png "Optional title")

<h3>Reference</h3>
This part is reference of my research through paypal system.
I found this [link](https://www.paypal.com/cy/webapps/mpp/ua/servicedescription-full) is really helpful.

<h2>Developer</h2>
* Atit Lelasuksan 5510546201
* Parinthorn Panya 5510546085
* Wat Wattanagaroon 5510546140
