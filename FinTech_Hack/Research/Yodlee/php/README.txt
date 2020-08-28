----------------------------------
Yodlee PFM/Aggregation Sample Apps
----------------------------------

 - Yodlee Sample Apps/Libraries can be used :
 
	i)  To Consume Yodlee PFM/Aggregation API's 
 
	ii) Provides seamless interaction to Yodlee API's

Note : 

	i)  Yodlee Apps/Apis are categorized into three different categories i.e. :  Authentication/PFM/Aggregation

	ii) Response From all APIs is JSON and utilities parses and provides key/value pair arrays for the same.
 
 - Yodlee Sample Apps/Libraries is structured as follows:

	|yodlee|
	|      | 		
	|      |--- api - provides client libraries for Authentication/PFM/Aggregation
	|      |	
	|      |--- apps - Command Line Apps - (Authentication/PFM/Aggregation) to Test Drive Authentication/PFM/Aggregation APIs
	|      |
	|      |--- conf - configuration details in file named myapp.ini
	|      |
	|      |--- include - contains include.php file which holds all common packages/files to be included by Authentication/PFM/Aggregation Apps
	|      |	
	|      |--- util - utility scripts
	|      |
	|      |--- web - provides web version of Apps (Provides an idea , how to use Sample Apps in Web Based Application)

	For MFA and Non MFA Add Account , two samples have been provided for providers 16441 and 16442. There can be multiple providers and the MFA and NonMFA
	calls will vary based on the nature of providers. Please follow the API documentation for more details on the same.


- System Requirements

	- PHP 5.5
	- Make sure curl is enabled in php.ini
	- Apache 2.4/WAMP (For Web Samples)


----------------------------------------------------------------------------------------------------------------------------
Steps To Execute (Command Line Apps)
----------------------------------------------------------------------------------------------------------------------------
	Assuming <YODLEE_APPS_DIR>, is where YODLEE_APPS Archieve has been extracted

	1) Authenticate		: This step will execute cobrandLogin and userLogin using the following command.

				<YODLEE_APPS_DIR>: php yodlee/apps/authentication/login/loginApp.php

	2) PFM

		a) Accounts     : 
				<YODLEE_APPS_DIR>: php yodlee/apps/pfm/accounts/accountsApp.php
		b) Transactions : 
				<YODLEE_APPS_DIR>: php yodlee/apps/pfm/transactions/transactionsApp.php
		c) Holdings     : 
				<YODLEE_APPS_DIR>: php yodlee/apps/pfm/holdings/holdingsApp.php
		d) Bills     : 
				<YODLEE_APPS_DIR>: php yodlee/apps/pfm/bills/billsApp.php
	3) Aggregation

		a) Provider     : 
				<YODLEE_APPS_DIR>: php yodlee/apps/aggregation/providerApp.php
		b) Add Account : 
				<YODLEE_APPS_DIR>: php yodlee/apps/aggregation/addAccount.php

		For MFA and Non MFA Add Account , two samples have been provided for providers 16441 and 16442. 
		There can be multiple providers and the MFA and NonMFA
		calls will vary based on the nature of providers. 
		Please follow the API documentation for more details on the same.

		For Non MFA , after Account Addition, getRefresh API should be called till the time we get refresh status as REFRESH_COMPLETE/LOGIN_FAILURE
		For MFA, refresh API should be called till we get REFRESH_COMPLETE/LOGIN_FAILURE, if we get MFA/LoginForm in intermediate steps, we should
		be posting MFA Challenge. For more details please refer API Documentation.

		Refresh call can be a polling call which can be made by end user after a delay of every 10-20 ms, till the time refresh is complete or login failure.
		
----------------------------------------------------------------------------------------------------------------------------
Steps To Execute (Web Based Apps)
----------------------------------------------------------------------------------------------------------------------------

i)  Deploy YODLEE_APPS archieve in Apache Standalone/WAMP/LAMP
ii) Home page can be accessed via the following url
	http://[host]:[port]/[appname]/yodlee/web/home.php
