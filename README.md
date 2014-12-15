<h1>KUPaypal</h1>

<h3>Description</h3>
Service for payment from one user to other user. There are two perspective of user, customer and merchant. User want to pay money to merchant by kupaypal. After check out payment from merchant, website will redirect to kupaypal login. User have to have kupaypal account before login then kupaypal will show the order id merchant name total amount and time of purchased, user will choose accepted or decline for confirm that payment. Then kupaypal will redirect user to merchant website. <br>
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

<h3>Use Cases</h3>
<h2>1. Send a payment (Create a payment)</h2>
After customer decide to check out via ku paypal, client/merchant's website create a json data which contain order id, merchant email and total price to POST in our service.
  * Primary Actor: Merchant
  * Scope: Payment System
  * Level: Very High
  * Story: Merchant create a payment in service's system.

<h3>Scenario Create payment</h3>
<h4>Main Success Scenario and steps</h4>
1. Customer choose product from Merchant's website.
2. Customer place order and check out.
3. Merchant's website will send order id, merchant email, total amount to create payment in our service.

<h4>Precondition</h4>
  Merchant email is exist in kupaypal system.(merchant have an account to validate a payment and get his/her money.)

<h4>Extensions</h4>
2a. Total amount has negative value
    .1 Merchant have to resend his/her data to our service.

<h4>Trigger</h4>
  Customer selects to checkout via "Ku paypal"  

<h4>Guarantee</h4>
  Merchant create a payment so customer can accept it.


<h2>2. Accept a payment (funds held wait for merchant validation)</h2>
After merchant's website create a payment. Customer want to pay that payment, customer just GET a acception path to accept a payment.
  * Primary Actor: Customer
  * Scope: Payment System
  * Level: Very High
  * Story: Customer accept a payment, service system hold his/her balance to wait merchant come and validate a payment.

<h3>Scenario Accept a payment</h3>
<h4>Main Success Scenario and steps</h4>
1. Customer retrieve a payment information from merchant's website e.g. list of item, total price.
2. Merchant's website redirect to payment acception page.
3. Customer accept a payment.

<h4>Precondition</h4>
  Customer have an account in kupaypal system.

<h4>Guarantee</h4>
  Customer accept a payment.

<h2>3. Validate a payment (funds tranferred)</h2>
After customer accept a payment, merchant come to kupaypal system and validate a payment to retrieve money.
  * Primary Actor: Merchant
  * Scope: Payment System
  * Level: Very High
  * Story: Merchant validate a payment and retrieve money to account.

<h3>Scenario Accept a payment</h3>
<h4>Main Success Scenario and steps</h4>
1. Merchant go to validate path (/payment/{id}/validate) to get validation page.
2. Merchant validate a payment.

<h4>Precondition</h4>
  Customer already accept a payment.

<h4>Guarantee</h4>
  Merchant validate a payment.


<h2>4. Reverse/chargeback a payment</h2>
If customer or merchant found that payment information is not correct or have a problem, they want to cancel/reverse this payment.
  * Primary Actor: Customer or Merchant
  * Scope: Payment System
  * Level: Low
  * Story: Some problem occured in a payment. Customer/merchant want to reverse/cancel a payment. They go and try to reverse/rollback a payment.

<h3>Scenario Charge back</h3>
<h4>Main Success Scenario and steps</h4>
1. Customer fullfill a cancel/reverse form in merchant's website.
2. Merchant GET cancel path to cancel/reverse a payment.
3. Customer and Merchant get chargeback amount.

<h4>Extensions</h4>
Admin of website do not permit to charge back

<h4>Trigger</h4>
  Customer selects to cancel/reverse a payment. (depend on what merchant's website provided.)

<h4>Precondition</h4>
  Payment already created.

<h4>Guarantee</h4>
  Customer can get his/her money back.
  
<h2>5. User registration</h2>
 User want to pay via this service, they need to register.
  * Primary Actor: Customer
  * Scope: Account Management
  * Level: High
  * Story: User want to become a member of the system.

<h3>Scenario Register</h3>
<h4>Main Success Scenario and steps</h4>
1. User provide email, password, first name, last name and address in registration form.
2. User selects "register".

<h4>Extensions</h4>
1a. E-mail is already in use
    .1 User need to change his/her email.
3a. The two passwords are different(use for password validation)
    .1 User retype his/her password

<h4>Trigger</h4>
  User selects the "Sign Up". 

<h4>Precondition</h4>
  User is not logged in.

<h4>Guarantee</h4>
  User becomes a registered user.

<h2>6. User Log In</h2>
 Customer want to access the system. Customer can retrieve his/her profile and balance.
  * Primary Actor: Customer
  * Scope: Account management
  * Level: High
  * Story: Customer want to login to the system.

<h2>Scenario Login User</h2>
<h4>Main Sucess scenario</h4>
1. User provide his/her email and password.
2. User select "Sign In".

<h4>Extensions</h4>
2a. User provides invalid login parameter
(see Login Failed)

<h4>Trigger</h4>
User selects the "Sign In".
User access resource that need authentication.

<h4>Precondition</h4>
User does not login yet.

<h4>Guarantee</h4>
User can see his/her own information in paypal.

<h2>6. User Log In Failed</h2>
 When customer want to accessto the system.
  * Primary Actor: Customer
  * Scope: Account management
  * Level: High
  * Story: Customer want to login to the system.

<h2> Scenario Login failed</h2>
<h3>Login Failed</h3>
<h4>Precondition</h4>
- The user provides invalid login parameters
Precondition should be identical with the condition of the extension point
<h4>Main success scenario</h4>
1.System redirects the User to the Login page
2.System informs the User that he/she typed a non-registered user name
<h3>Login without Registration</h3>
<h4>Precondition</h4>
- The User typed a non-registered user name
- 
Precondition should refine the precondition of Login Failed
<h4>Main success scenario</h4>
1. System redirects the User to the Login page
2. System informs the User that he/she typed a non-registered user name

<h3>Functional Requirement</h3>
1. Transaction history
2. Current balance for each user.
3. (Extra) Support multiple currency and multiple language

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
