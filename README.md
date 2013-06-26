Brdige
======

An ownCloud application implemented to authenticate users in the phpBB forum

How to install it
------
Put the folder in the /ownCloud/apps/ <br />
Login in the ownCloud with an administrator account <br />
Find the application in the apps list <br />
Enable it <br />

How to use it
------
Choose Database Copy or Multiple Backends in the setting panel.
Multiple Backends is automatic
Database Copy can be automatic or manual
If manaual style is chosen, click the import button to active the function.

Configuration
------
To let this applications works properly, some configuration needs to be noticed.

### Email function.
    In /ownCloud/config/config.php, some mail parameters should be set.
    For example
      'mail_smtpdebug' => false,
      'mail_smtpmode' => 'smtp',
      'mail_smtphost' => 'smtp.gmail.com',
      'mail_smtpport' => 465,
      'mail_smtptimeout' => 10,
      'mail_smtpsecure' => 'ssl',
      'mail_smtpauth' => true,
      'mail_smtpauthtype' => 'LOGIN',
      'mail_smtpname' => 'xxx@gmail.com',
      'mail_smtppassword' => '123456',
      
    If the mail service should use ssl  
    In /php/php.ini, php_openssl should be active
    extension=php_openssl.dll



